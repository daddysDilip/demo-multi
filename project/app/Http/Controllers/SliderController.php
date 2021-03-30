<?php

namespace App\Http\Controllers;

use App\Slider;
use App\SliderTranslations;
use Illuminate\Http\Request;
use Auth;
use Excel;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companyid = get_company_id();
        $slider = Slider::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.sliderlist',compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slideradd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());

        $slider = new Slider();
        $slider->fill($request->all());

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/sliders',$photo_name);
            $slider['image'] = $photo_name;
        }

        if ($request->status == ""){
            $slider['status'] = 0;
        }
        else
        {
           $slider['status'] = 1; 
        }

        if($request->target == "")
        {
            $slider['target']="";
        }
        else
        {
            $slider['target']=$request->target;

        }

          if($request->link == "")
        {
            $slider['link']="";
        }
        else
        {
            $slider['link']=$request->link;
            
        }



        $slider['company_id'] = get_company_id();

        // dd($slider);

        $slider->save();

        $slidertrans = new SliderTranslations();
        $slidertrans['sliderid'] = $slider->id;
        $slidertrans['title'] = $request->title;
        $slidertrans['text'] = $request->text;
        $slidertrans['langcode'] = $request->default_langcode;
        $slidertrans['company_id'] = get_company_id();
        $slidertrans->save();

          if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {
            $slideralltrans = new SliderTranslations();
            $slideralltrans['sliderid'] = $slider->id;
            $slideralltrans['title'] = $request->trans_title[$data];
            $slideralltrans['text'] = $request->trans_text[$data];
            $slideralltrans['langcode'] = $transdata;
            $slideralltrans['company_id'] = get_company_id();
            $slideralltrans->save();    
            
        }
    }

        return redirect('admin/sliders')->with('message',trans("app.SliderAddMsg"));
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
        $slider = Slider::findOrFail($id);
        return view('admin.slideredit',compact('slider'));
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
        $slider = Slider::findOrFail($id);
        $data = $request->all();

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/sliders',$photo_name);
            $data['image'] = $photo_name;

            if($slider->image  != '')
            {
                unlink('assets/images/sliders/'.$slider->image );
            }
        }

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }


           if($request->target != "")
        {
            $slider['target']=$request->target;
        
        }
    

          if($request->link != "")
        {
            $slider['link']=$request->link;
           
        }
   
        $slider->update($data);

        $sliderdeflang_exists = SliderTranslations::where('langcode', '=', $request->default_langcode)->where('sliderid', '=', $id)->first();

        if(count($sliderdeflang_exists) > 0)
        {
            SliderTranslations::where('langcode', '=', $request->default_langcode)->where('sliderid', '=', $id)->update(['title' => $request->title, 'text' => $request->text]);
        }
        else
        {
            $slidertrans = new SliderTranslations();
            $slidertrans['sliderid'] = $id;
            $slidertrans['title'] = $request->title;
            $slidertrans['text'] = $request->text;
            $slidertrans['langcode'] = $request->default_langcode;
            $slidertrans['company_id'] = get_company_id();
            $slidertrans->save();
        }
        

        foreach($request->langcode as $data => $transdata)
        {
            $sliderlang_exists = SliderTranslations::where('langcode', '=', $transdata)->where('sliderid', '=', $id)->first();
            if(count($sliderlang_exists) > 0)
            {

                SliderTranslations::where('langcode', '=', $transdata)->where('sliderid', '=', $id)->update(['title' => $request->trans_title[$data], 'text' => $request->trans_text[$data]]);
            }
            else
            {
                $slideralltrans = new SliderTranslations();
                $slideralltrans['sliderid'] = $id;
                $slideralltrans['title'] = $request->trans_title[$data];
                $slideralltrans['text'] = $request->trans_text[$data];
                $slideralltrans['langcode'] = $transdata;
                $slideralltrans['company_id'] = get_company_id();
                $slideralltrans->save();
            }
            
        }

        return redirect('admin/sliders')->with('message',trans("app.SliderUpdateMsg"));
    }

    public function status($subdomain,$id , $status)
    {
        $slider = Slider::findOrFail($id);
        $input['status'] = $status;

        $slider->update($input);

        return redirect('admin/sliders')->with('message',trans("app.SliderStatusUpdateMsg"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        $slider = Slider::findOrFail($id);

        if($slider->image != '')
        {
            unlink('assets/images/sliders/'.$slider->image);
        }

        $slider->delete();

        $slidertrans = SliderTranslations::where('sliderid',$id);
        $slidertrans->delete();

        return redirect('admin/sliders')->with('message',trans("app.SliderDeleteMsg"));
    }


    public function deleteimage($subdomain ,$id)
    {
        $slider = Slider::findOrFail($id); 
       
        if($slider->image != '')
        {
            unlink('assets/images/sliders/'.$slider->image);
        }
       
        $data['image'] = '';

        $updatedata = $slider->update($data);
    }

    public function Exportdata()
    { 

        $companyid = get_company_id();
        $slider = Slider::where('company_id',$companyid)->orderBy('id','desc')->get();
        
        // dd($slider);
        
        $sliderArray = []; 

        $sliderArray[] = ['Sr.No','Slider Image','Image Parth','Slider Title','Slider Text','Slider Text Position','status'];
        $i = 1;
        foreach ($slider as $alldata) 
        {
            if($alldata->status == 1)
            {
                $status = 'Active';
            }
            else if($alldata->status == 0)
            {
                $status = 'Deactive';
            }

            $parth=url('/').'/assets/images/sliders/'.$alldata->image;

            $title = '';
            $text = '';

            $slidertrans = SliderTranslations::where('sliderid',$alldata->id)->where('langcode',get_defaultlanguage())->first();

            if(count($slidertrans) > 0)
            {
                $title = $slidertrans->title;
                $text = $slidertrans->text;
            }

            $sliderArray[] = array($i,$alldata->image,$parth,$title,$text,$alldata->text_position,$status);
            $i++;
        }   
        Excel::create('Slider', function($excel) use ($sliderArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Slider List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('Slider List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($sliderArray) {
                $sheet->fromArray($sliderArray, null, 'A1', false, false);
            });

        })->download('xlsx');

    }

    public function import(Request $request)
    {

        // dd($request->all());
        $companyid = get_company_id();

        if($request->file('imported_file'))
        {
            $path = $request->file('imported_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            if(!empty($data) && $data->count())
            {
                $data = $data->toArray();
                for($i=0;$i<count($data);$i++)
                {
                    $data[$i]=array_filter($data[$i]);

                    if($data[$i] != null)
                    {
                        $dataImported[] = $data[$i];
                    }
                }
            }

            // dd($dataImported);

            foreach ($dataImported as $value)
            {         
                                
                $image=$value['slider_image'];

                if($value['status'] == 'Active')
                {
                    $status=1;
                } 
                else
                {
                    $status=0;
                }


                // if($image != null)
                // {
                        // $rand_imagname =str_random(6);
                        // $url = $image; 
                        // dd($url);
                                
                        // $filename = $rand_imagname."_".substr($url, strrpos($url, '/') + 1);

                        // dd($image=$filename);
                        // file_put_contents('assets/images/event/'.$filename, file_get_contents(str_replace('%20', ' ',$url)));

                        // file_put_contents('assets/images/event/'.$filename, file_get_contents($url));
                // }
                // else
                // {
                        //   $image=null;
                // }

                $slider = new Slider();
                $slider['title'] = $value['slider_title'];
                $slider['text'] = $value['slider_text'];
                $slider['image'] = $image;
                $slider['text_position'] = 'left';
                $slider['status'] = $status;
                $slider['company_id'] = $companyid;
                $slider->save(); 

                $slidertrans = new SliderTranslations();
                $slidertrans['sliderid'] = $slider->id;
                $slidertrans['title'] = $value['slider_title'];
                $slidertrans['text'] = $value['slider_text'];
                $slidertrans['langcode'] = get_defaultlanguage();
                $slidertrans['company_id'] = get_company_id();
                $slidertrans->save();
            
            }
            // die();

        }
       
        return back();
    }

    public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                        
                        0 =>'image',
                        1 =>'title',
                        2 =>'status',
                        3 =>'action',
                         );
  
        $totalData = Slider::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Slider::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Slider::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('title', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Slider::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('title', 'LIKE',"%{$search}%")
                             ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                $e=app()->getLocale();

            // $etitle=SliderTranslations::where('sliderid',$post->id)->where('langcode',$e)->first()->title;



             if($post->image != null)
            {
          $image= "<img style='width: 300px;height: 100px;' src='".url("/")."/assets/images/sliders/".$post->image."'>";
              }
               else
               {      
        // $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive' width='300' height='300' style='width: 300px;height: 100px;'>";   
        $image="-";
              }
              
                $nestedData['image'] =$image;
                $nestedData['title'] =$post->title;
              
                       if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('admin/sliders')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }                                       
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/sliders')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
                              
$nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='sliders/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";

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
