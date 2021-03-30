<?php

namespace App\Http\Controllers;

use App\Contactus;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;
use Excel;

class ContactusController extends Controller
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
        $contactus = Contactus::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.contactuslist',compact('contactus'));
    }

    public function Exportdata()
    {
        $companyid = get_company_id();
        $contact = Contactus::where('company_id',$companyid)->orderBy('id','desc')->get();

        $contactArray = []; 

        $contactArray[] = ['Sr No', 'Name', 'Phone', 'Email', 'Message','Published Date','Status'];
        $i = 1;
        foreach ($contact as $alldata) 
        {
            //$uplanArray[] = $alldata->toArray();
            if($alldata->status == 1)
            {
                $status = 'Active';
            }
            else if($alldata->status == 0)
            {
                $status = 'Deactive';
            }

            $createddate = date('d-m-Y H:ia',strtotime($alldata->created_at));

            $contactArray[] = array($i,$alldata->name,$alldata->phone,$alldata->email,$alldata->message,$createddate,$status);
            $i++;
        }

        Excel::create('contact', function($excel) use ($contactArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Contact Us List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('contact Us List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($contactArray) {
                $sheet->fromArray($contactArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain,$id)
    {
        //
    }

    public function status($subdomain,$id , $status)
    {
        $contactus = Contactus::findOrFail($id);
        $input['status'] = $status;

        $contactus->update($input);
        return redirect('admin/contactus')->with('message','Contacts Status Updated Successfully.');
    }

    public function titles(Request $request)
    {
       //
    }
	
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
      //
    }

     public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 

                        0 =>'name',
                        1 =>'title',
                        2 =>'date',
                        3 =>'status',
                        4 =>'action',
                         );
                    
        $totalData = Contactus::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Contactus::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Contactus::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Contactus::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
            // $etitle=CmsTranslations::where('cmsid',$post->id)->where('langcode',app()->getLocale() )->first()->title;
                
                $nestedData['name'] =$post->name;
                $nestedData['phone'] =$post->phone;
                $nestedData['email'] =$post->email;
                $nestedData['message'] =$post->message;
                $nestedData['date']= date('jS,M Y',strtotime($post->created_at));
                       if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('admin/contactus')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";
                 }                                       
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/contactus')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
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
