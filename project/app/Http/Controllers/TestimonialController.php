<?php

namespace App\Http\Controllers;

use App\SectionTitles;
use App\Testimonial;
use App\TestimonialTranslations;
use Illuminate\Http\Request;
use Auth;
use Excel;

class TestimonialController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyid = get_company_id();
        $titles = SectionTitles::where('company_id', '=', $companyid)->get();
        $testimonials = Testimonial::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.testimonialsection',compact('testimonials','titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonialadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $testimonial = new Testimonial;
        $testimonial->fill($request->all());

        if ($request->status == ""){
            $testimonial['status'] = 0;
        }
        else
        {
           $testimonial['status'] = 1; 
        }

        $testimonial['company_id'] = get_company_id();

        $testimonial->save();

        $testimonialtrans = new TestimonialTranslations();
        $testimonialtrans['testimonialid'] = $testimonial->id;
        $testimonialtrans['review'] = $request->review;
        $testimonialtrans['designation'] = $request->details;
        $testimonialtrans['langcode'] = $request->default_langcode;
        $testimonialtrans['company_id'] = get_company_id();
        $testimonialtrans->save();


        if($request->langcode != null)
        {

            foreach($request->langcode as $data => $transdata)
            {
                $testimonialalltrans = new TestimonialTranslations();
                $testimonialalltrans['testimonialid'] = $testimonial->id;
                $testimonialalltrans['review'] = $request->trans_review[$data];
                $testimonialalltrans['designation'] = $request->trans_designation[$data];
                $testimonialalltrans['langcode'] = $transdata;
                $testimonialalltrans['company_id'] = get_company_id();
                $testimonialalltrans->save();    
                
            }
        }

        return redirect('admin/testimonial')->with('message',trans("app.TestimonialAddMsg"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonialedit',compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain,$id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $data = $request->all();

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $testimonial->update($data);

        $testideflang_exists = TestimonialTranslations::where('langcode', '=', $request->default_langcode)->where('testimonialid', '=', $id)->first();

        if($testideflang_exists != null)
        {
            TestimonialTranslations::where('langcode', '=', $request->default_langcode)->where('testimonialid', '=', $id)->update(['review' => $request->review, 'designation' => $request->designation]);
        }
        else
        {
            $testimonialtrans = new TestimonialTranslations();
            $testimonialtrans['testimonialid'] = $id;
            $testimonialtrans['review'] = $request->review;
            $testimonialtrans['designation'] = $request->designation;
            $testimonialtrans['langcode'] = $request->default_langcode;
            $testimonialtrans['company_id'] = get_company_id();
            $testimonialtrans->save();
        }
        
            if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {
            $testilang_exists = TestimonialTranslations::where('langcode', '=', $transdata)->where('testimonialid', '=', $id)->first();
            if($testilang_exists != null)
            {

                TestimonialTranslations::where('langcode', '=', $transdata)->where('testimonialid', '=', $id)->update(['review' => $request->trans_review[$data], 'designation' => $request->trans_designation[$data]]);
            }
            else
            {
                $testimonialltrans = new TestimonialTranslations();
                $testimonialltrans['testimonialid'] = $id;
                $testimonialltrans['review'] = $request->trans_review[$data];
                $testimonialltrans['designation'] = $request->trans_designation[$data];
                $testimonialltrans['langcode'] = $transdata;
                $testimonialltrans['company_id'] = get_company_id();
                $testimonialltrans->save();
            }
            
        }
    }

        return redirect('admin/testimonial')->with('message',trans("app.TestimonialUpdateMsg"));
    }

    public function status($subdomain, $id , $status)
    {
        $testimonial = Testimonial::findOrFail($id);
        $input['status'] = $status;
        
        $testimonial->update($input);

        return redirect('admin/testimonial')->with('message',trans("app.TestimonialStatusUpdateMsg"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        $testimonialltrans = TestimonialTranslations::where('testimonialid',$id);
        $testimonialltrans->delete();

        return redirect('admin/testimonial')->with('message',trans("app.TestimonialDeleteMsg"));
    }

    public function Exportdata()
    { 

        $companyid = get_company_id();
        $testimonial = Testimonial::where('company_id',$companyid)->orderBy('id','desc')->get();
        
        // dd($testimonial);
        
        $testimonialArray = []; 

        $testimonialArray[] = ['Sr.No','Review','Client Name','Designation','Status'];
        $i = 1;

        foreach ($testimonial as $alldata) 
        {
            if($alldata->status == 1)
            {
                $status = 'Active';
            }
            else if($alldata->status == 0)
            {
                $status = 'Deactive';
            }

            $review = '';
            $designation = '';

            $testimonialtrans = TestimonialTranslations::where('testimonialid',$alldata->id)->where('langcode',get_defaultlanguage())->first();

            if($testimonialtrans != null)
            {
                $review = $testimonialtrans->review;
                $designation = $testimonialtrans->designation;
            }

            $testimonialArray[] = array($i,$review,$alldata->client,$designation,$status);
            $i++;
        }   
        Excel::create('Testimonial', function($excel) use ($testimonialArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Testimonial List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('Testimonial List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($testimonialArray) {
                $sheet->fromArray($testimonialArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }


    public function import(Request $request)
    {

        // dd($request->imported_file);
        $companyid = get_company_id();

        if($request->file('imported_file'))
        {
            $path = $request->file('imported_file')->getRealPath();

            // dd($path);
            $data = Excel::load($path, function($reader) {
            })->get();

            if(!empty($data) && $data->count())
            {
                //dd($data);
                $data = $data->toArray();
                for($i=0;$i<count($data);$i++)
                {
                    // $data[$i]=array_filter($data[$i]);

                    //          if($data[$i] != null)
                    // {

                        $dataImported[] = $data[$i];

                    // } 
                }
            }
            // dd($dataImported);
            foreach ($dataImported as $value)
            {         
                        
                if($value['status'] == 'Active')
                {
                    $status=1;
                } 
                else
                {
                    $status=0;
                }

                $testimonial = new Testimonial();
                $testimonial['review'] = $value['review'];
                $testimonial['client'] = $value['client_name'];
                $testimonial['designation'] = $value['designation'];
                $testimonial['status'] = $status;
                $testimonial['company_id'] = get_company_id();
                $testimonial->save();

                $testimonialtrans = new TestimonialTranslations();
                $testimonialtrans['testimonialid'] = $testimonial->id;
                $testimonialtrans['review'] = $value['review'];
                $testimonialtrans['designation'] = $value['designation'];
                $testimonialtrans['langcode'] = get_defaultlanguage();
                $testimonialtrans['company_id'] = get_company_id();
                $testimonialtrans->save();

            }
     
        }
        return back();
    }

     public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                        
                        0 =>'review',
                        1 =>'client',
                        2 =>'designation',
                        3 =>'status',
                        4 =>'action',
                         );
                    



        $totalData = Testimonial::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Testimonial::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Testimonial::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('review', 'LIKE',"%{$search}%")
                            ->orWhere('client', 'LIKE',"%{$search}%")
                            ->orWhere('designation', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Testimonial::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('review', 'LIKE',"%{$search}%")
                            ->orWhere('client', 'LIKE',"%{$search}%")
                            ->orWhere('designation', 'LIKE',"%{$search}%")
                             ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {

            // $etitle=TestimonialTranslations::where('testimonialid',$post->id)->where('langcode',app()->getLocale() )->first()->review;

        //      if($post->image != '')
        //     {
        // $image= "<img style='width: 300px;height: 100px;' src='".url("/")."/assets/images/sliders/".$post->image."'>";
        //       }
        //        else
        //        {      
        // $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive' width='300' height='300' style='width: 300px;height: 100px;'>";
        //       }
                
                $nestedData['review'] =$post->review;
                $nestedData['client'] =$post->client;
                $nestedData['designation']=$post->designation;
              
                       if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('admin/testimonial')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }                                       
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/testimonial')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
                              
$nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='testimonial/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";

                $data[] = $nestedData;
                $i++;
            }
        }          
        $json_data=array(
                  "draw"            => intval($request->input('draw')),  
                  "recordsTotal"    => intval($totalData),  
                  "recordsFiltered" => intval($totalFiltered), 
                  "data"            => $data   
                    );

        // dd($json_data);

       echo json_encode($json_data,JSON_UNESCAPED_UNICODE ); 
        
    }   

}
