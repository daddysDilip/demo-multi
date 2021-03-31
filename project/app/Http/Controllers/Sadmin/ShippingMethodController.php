<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\ShippingMethod;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;

class ShippingMethodController extends Controller
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
        $shipping = ShippingMethod::all();
        return view('sadmin.shippinglist',compact('shipping'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sadmin.shippingadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shipping = new ShippingMethod();
        $shipping->fill($request->all());

        $shipping['tempcode'] = str_random(6);

        if ($request->status == "")
        {
            $shipping['status'] = 0;
        }
        else
        {
            $shipping['status'] = 1;
        }

        $shipping->save();

        return redirect('sadmin/shipping')->with('message','New shipping Method Added Successfully.');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $shipping = ShippingMethod::findOrFail($id);
        return view('sadmin.shippingedit',compact('shipping'));
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
        $shipping = ShippingMethod::findOrFail($id);
        $data = $request->all();

        if ($request->status == "")
        {
            $data['status'] = 0;
        }
        else
        {
            $data['status'] = 1;
        }
       
        $shipping->update($data);

        return redirect('sadmin/shipping')->with('message','Shipping Method Updated Successfully.');
    }

    public function shipping_exists(Request $request){

        $id = $request->input('id');

        if($id != '')
        {
            $title_exists = ((\App\ShippingMethod::where('id', '!=', $id)->where('shippingtype', '=', $request->input('shippingtype'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = ((\App\ShippingMethod::where('shippingtype', '=', $request->input('shippingtype'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }  
    }
	
    public function status($id, $status)
    {
        $shipping = ShippingMethod::findOrFail($id);
        $input['status'] = $status;

        $shipping->update($input);
        return redirect('sadmin/shipping')->with('message','Shipping Method Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping = ShippingMethod::findOrFail($id);
        $shipping->delete();
        return redirect('sadmin/shipping')->with('message','Shipping Method Delete Successfully.');
    }

     public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                            
                0  => 'shippingtype',
                1  => 'status',
                2  => 'actions',
            );
  
        $totalData = ShippingMethod::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = ShippingMethod::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  ShippingMethod::where('id','LIKE',"%{$search}%")
                            ->orWhere('shippingtype', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


    $totalFiltered =ShippingMethod::where('id','LIKE',"%{$search}%")
                            ->orWhere('shippingtype', 'LIKE',"%{$search}%")
                            ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                
                 
                $nestedData['shippingtype'] = $post->shippingtype;
             
                //   $nestedData['email'] = $post->email;
                //   $nestedData['message'] = $post->message;
                // $nestedData['date'] = $post->created_at->format('jS M Y');


                 if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('sadmin/shipping')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                                        
                elseif($post->status == 0)
                {
                
                $nestedData['status'] = "<a href='".url('sadmin/shipping')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
                      

    $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='shipping/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";
       

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
