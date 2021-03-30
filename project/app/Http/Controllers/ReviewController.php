<?php

namespace App\Http\Controllers;

use App\Review;
use DB;
use App\Product;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;

class ReviewController extends Controller
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
     
        $review = Review::join('products', 'products.id', '=', 'reviews.productid')->where('reviews.company_id',$companyid)->select(DB::raw("reviews.*,products.title"))->orderBy('reviews.id','desc')->get();
        return view('admin.reviewlist',compact('review'));
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

    public function status($subdomain, $id, $status)
    {   
        $review = Review::findOrFail($id);
        $input['status'] = $status;
        //die();
        $review->update($input);
        return redirect('admin/review')->with('message','Review Status Updated Successfully.');
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

                        0 =>'productid',
                        1 =>'name',
                        2 =>'email',
                        3 =>'review',    
                        4 =>'rating',
                        5 =>'review_date',
                        6 =>'status',
                         );
                    
    $totalData = Review::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
                        $posts = Review::where('reviews.company_id',$companyid)
                          ->join('products', 'products.id', '=', 'reviews.productid')
                        ->offset($start)
                         ->limit($limit)
                         ->select('reviews.*','products.title as ptitle')
                         ->orderBy($order,$dir)
                         ->get();
                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Review::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();



        $totalFiltered = Review::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->count();
                // dd($totalFiltered);
        }
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
        
                $nestedData['productid'] =$post->ptitle;
                $nestedData['name'] =$post->name;
                $nestedData['email'] =$post->email;
                $nestedData['review'] =$post->review;
                $nestedData['rating'] =$post->rating;
                $nestedData['review_date']=date('d-m-Y H:ia', strtotime($post->review_date));

               if($post->status == 1)
                  {

                  $nestedData['status'] = "<a href='".url('admin/review')."/status/".$post->id."/0'class='"."btn btn-success btn-xs'>Approved</a>";

                 }
                          
               elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/review')."/status/".$post->id."/1'class='"."btn btn-danger btn-xs'>Unapproved</a>";
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
