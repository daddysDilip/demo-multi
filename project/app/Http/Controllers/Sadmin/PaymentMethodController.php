<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\PaymentMethod;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;

class PaymentMethodController extends Controller
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
        $payment = PaymentMethod::all();
        return view('sadmin.paymentlist',compact('payment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sadmin.paymentadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = new PaymentMethod();
        $payment->fill($request->all());

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/payment',$photo_name);
            $payment['image'] = $photo_name;
        }

        $payment['tempcode'] = str_random(6);

        if ($request->status == "")
        {
            $payment['status'] = 0;
        }
        else
        {
            $payment['status'] = 1;
        }

        $payment->save();

        return redirect('sadmin/payment')->with('message','New Payment Method Added Successfully.');
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
        $payment = PaymentMethod::findOrFail($id);
        return view('sadmin.paymentedit',compact('payment'));
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
        $payment = PaymentMethod::findOrFail($id);
        $data = $request->all();

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/payment',$photo_name);
            $data['image'] = $photo_name;
            if($payment->image != '')
            {
                unlink('assets/images/payment/'.$payment->image);
            }
        }

        if ($request->status == "")
        {
            $data['status'] = 0;
        }
        else
        {
            $data['status'] = 1;
        }
       
        $payment->update($data);

        return redirect('sadmin/payment')->with('message','Payment Method Updated Successfully.');
    }
	
	public function payment_exists(Request $request){

        $id = $request->input('id');

        if($id != '')
        {
            $title_exists = ((\App\PaymentMethod::where('id', '!=', $id)->where('paymentname', '=', $request->input('paymentname'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = ((\App\PaymentMethod::where('paymentname', '=', $request->input('paymentname'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }  
    }

    public function status($id, $status)
    {
        $payment = PaymentMethod::findOrFail($id);
        $input['status'] = $status;

        $payment->update($input);
        return redirect('sadmin/payment')->with('message','Payment Method Status Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = PaymentMethod::findOrFail($id);
        if($payment->image != '')
        {
            unlink('assets/images/payment/'.$payment->image);
        }
        $payment->delete();
        return redirect('sadmin/payment')->with('message','Payment Method Delete Successfully.');
    }

    public function deleteimage($id)
    {
        $payment = PaymentMethod::findOrFail($id); 
       
        if($payment->image != '')
        {
            unlink('assets/images/payment/'.$payment->image);
        }
       
        $data['image'] = '';
        $updatedata = $payment->update($data);
    }


         public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                          
                        0 =>'image',   
                        1 =>'paymentname',   
                        2 =>'paymenttype',
                        3 =>'status',
                        4 =>'actions',
                         );
  
        $totalData = PaymentMethod::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = PaymentMethod::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  PaymentMethod::where('id','LIKE',"%{$search}%")
                            ->orWhere('paymentname', 'LIKE',"%{$search}%")
                            ->orWhere('paymenttype', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered =PaymentMethod::where('id','LIKE',"%{$search}%")
                            ->orWhere('paymentname', 'LIKE',"%{$search}%")
                            ->orWhere('paymenttype', 'LIKE',"%{$search}%")
                            ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {

                       if($post->image != '')
            {
            $image= "<img style='width: 300px;height: 100px;' src='".url("/")."/assets/images/payment/".$post->image."'>";
              }
               else
               {
        
                  $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive' width='300%' height='100%' style='width: 300px;height: 100px;'>";
              }
                     




               
                $nestedData['image'] = $image;
                $nestedData['paymentname'] = $post->paymentname;
                $nestedData['paymenttype'] = $post->paymenttype;
              
                 if($post->status == 1)
                 {
                   
                  $nestedData['status'] = "<a href='".url('sadmin/payment')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";
              
            
              }                         
                else
                {
                      $nestedData['status'] = "<a href='".url('sadmin/payment')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";

                }


          
    $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='payment/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";

    
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
