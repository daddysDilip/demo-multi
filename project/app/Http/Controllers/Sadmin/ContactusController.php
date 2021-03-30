<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
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
        return view('sadmin.contactuslist',compact('contactus'));
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
    public function show($id)
    {
        //
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
            $excel->setDescription('Contact Us List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($contactArray) {
                $sheet->fromArray($contactArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request,$id)
    {
        //
    }

    public function status($id, $status)
    {
        $contactus = Contactus::findOrFail($id);
        $input['status'] = $status;

        $contactus->update($input);
        return redirect('sadmin/contactus')->with('message','Contact Us Status Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

       public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                            

                0 => 'name',
                1=> 'phone',
                2 => 'email',
                3 => 'message',
                4 => 'date',
                5 => 'status',
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
                         ->orWhere('created_at', 'LIKE',"%{$search}%")

                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered =Contactus::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->orWhere('phone', 'LIKE',"%{$search}%")
                             ->orWhere('email', 'LIKE',"%{$search}%")
                             ->orWhere('created_at', 'LIKE',"%{$search}%")
                             ->count();
                // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
               
   
                $nestedData['name'] = $post->name;
                $nestedData['phone'] = $post->phone;
                $nestedData['email'] = $post->email;
                $nestedData['message'] = $post->message;
                $nestedData['date'] = $post->created_at->format('jS M Y');


                 if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('sadmin/contactus')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                                        
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('sadmin/contactus')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                

                }
                      

    // $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='sliders/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";
       

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
