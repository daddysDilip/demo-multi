<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Buytheme;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;
use Excel;

class BuyThemeController extends Controller
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
        $buytheme = Buytheme::join('company', 'company.id', '=', 'buythemes.company_id' ,'left')->join('themes', 'themes.id', '=', 'buythemes.themeid' ,'left')->select(DB::raw("buythemes.*,themes.themename,company.comapany_name"))->get();

        return view('sadmin.buythemelist',compact('buytheme'));
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
        $buytheme = Buytheme::join('company', 'company.id', '=', 'buythemes.company_id' ,'left')->join('themes', 'themes.id', '=', 'buythemes.themeid' ,'left')->select(DB::raw("buythemes.id,themes.themename,company.comapany_name,buythemes.payment,buythemes.created_at"))->get();

        $buyersArray = []; 

        $buyersArray[] = ['id', 'Theme Name','Company Name','Payment','Payment Date'];
        
        $i = 1;
        foreach ($buytheme as $alldata) 
        {
            $createddate = date('jS M Y',strtotime($alldata->created_at));

            $buyersArray[] = array($i,$alldata->themename,$alldata->comapany_name,$alldata->payment,$createddate);
            $i++;
        }

        Excel::create('buyers', function($excel) use ($buyersArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Theme Buyer List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('Theme Buyer List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($buyersArray) {
                $sheet->fromArray($buyersArray, null, 'A1', false, false);
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
                            
                 0=>'themeid',
                 1=>'companyname',
                 2=>'payment',
                 3=>'paymentdate',
                 4=> 'action');



        $totalData = Buytheme::where('company_id',$companyid)->count();
        $totalData =5;
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
                  // $posts=Buytheme::leftjoin('buythemes')

            $posts = Buytheme::leftjoin('company', 'company.id', '=', 'buythemes.company_id')
                            ->leftjoin('themes', 'themes.id', '=', 'buythemes.themeid')
                            ->select(DB::raw("buythemes.*,themes.themename,company.comapany_name"))
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            // $posts = Buytheme::offset($start)
            //              ->limit($limit)
            //              ->orderBy($order,$dir)
            //              ->get();

         $totalData=Buytheme::leftjoin('company', 'company.id', '=', 'buythemes.company_id')
                            ->leftjoin('themes', 'themes.id', '=', 'buythemes.themeid')
                            ->select(DB::raw("buythemes.*,themes.themename,company.comapany_name"))
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
                // ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);


            $posts =  Buytheme::leftjoin('company', 'company.id', '=', 'buythemes.company_id')
                            ->leftjoin('themes', 'themes.id', '=', 'buythemes.themeid')
                            ->where('id','LIKE',"%{$search}%")
                            ->select(DB::raw("buythemes.*,themes.themename,company.comapany_name"))
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            // $totalFiltered =Buytheme::where('id','LIKE',"%{$search}%")
                             // ->orWhere('themeid', 'LIKE',"%{$search}%")
                             // ->count();


            $totalFiltered = Buytheme::leftjoin('company', 'company.id', '=', 'buythemes.company_id')
                            ->leftjoin('themes', 'themes.id', '=', 'buythemes.themeid')
                            ->where('id','LIKE',"%{$search}%")
                            ->select(DB::raw("buythemes.*,themes.themename,company.comapany_name"))
                           ->count();
                         // dd($totalFiltered);


       
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                    

                $nestedData['themeid'] = $post->themename;
                $nestedData['companyname'] = $post->comapany_name;
                $nestedData['payment'] = $post->payment;
                $nestedData['paymentdate'] = $post->created_at->format('jS M Y');
                
                                    

                //  if($post->status == 1)
                //  {
                //   $nestedData['status'] = "<a href='".url('sadmin/sliders')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                //  }
                                        
                // elseif($post->status == 0)
                // {
                //       $nestedData['status'] = "<a href='".url('sadmin/sliders')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
              

                // }
                      

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
