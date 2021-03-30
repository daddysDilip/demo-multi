<?php

namespace App\Http\Controllers;

use App\Subscribers;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Resource;
use Auth;
use Excel;

class SubscriberController extends Controller
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
        $subscribers = Subscribers::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.subscriberslist',compact('subscribers'));
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

    public function download()
    {
        $companyid = get_company_id();
        $subscribers = Subscribers::where('company_id',$companyid)->orderBy('id','desc')->get();

        $subscribersArray = []; 

        $subscribersArray[] = ['id', 'Email'];
        
        $i = 1;
        foreach ($subscribers as $alldata) 
        {
            $subscribersArray[] = array($i,$alldata->email);
            $i++;
        }

        Excel::create('subscribers', function($excel) use ($subscribersArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Subscribers List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('Subscribers List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($subscribersArray) {
                $sheet->fromArray($subscribersArray, null, 'A1', false, false);
            });

        })->download('xlsx');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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

                        0 =>'id',
                        1 =>'email',
                    
                         );
                    
    $totalData = Subscribers::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Subscribers::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Subscribers::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        $totalFiltered = Subscribers::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
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
                
                $nestedData['id'] =$i;
                $nestedData['email'] =$post->email;

            
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
