<?php

namespace App\Http\Controllers;

use App\Discount;
use App\DiscountTranslations;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;

class DiscountController extends Controller
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
        $discount = Discount::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.discountlist',compact('discount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discountadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discount = new Discount();
        $discount->fill($request->all());

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/discount',$photo_name);
            $discount['image'] = $photo_name;
        }
       
        $discount['tempcode'] = str_random(6);

        if($request->status == "")
        {
            $discount['status'] = 0;
        }
        else
        {
            $discount['status'] = 1;
        }

        $date = Carbon::createFromFormat('d/m/Y', $discount['startdate']);
        $discount['startdate'] =  $date->format('Y-m-d');

        $date = Carbon::createFromFormat('d/m/Y', $discount['enddate']);
        $discount['enddate'] =  $date->format('Y-m-d');

        $discount['company_id'] = get_company_id();

        $discount->save();

        $discounttrans = new DiscountTranslations();
        $discounttrans['discountid'] = $discount->id;
        $discounttrans['title'] = $request->title;
        $discounttrans['description'] = $request->description;
        $discounttrans['langcode'] = $request->default_langcode;
        $discounttrans['company_id'] = get_company_id();
        $discounttrans->save();
        if($request->langcode)
        {
            foreach($request->langcode as $data => $transdata)
            {
                $discountalltrans = new DiscountTranslations();
                $discountalltrans['discountid'] = $discount->id;
                $discountalltrans['title'] = $request->trans_title[$data];
                $discountalltrans['description'] = $request->trans_description[$data];
                $discountalltrans['langcode'] = $transdata;
                $discountalltrans['company_id'] = get_company_id();
                $discountalltrans->save();       
            }
        }

        return redirect('admin/discount')->with('message', trans("app.DiscountAddMsg"));
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
        $discount = Discount::findOrFail($id);
        return view('admin.discountedit',compact('discount'));
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
        $discount = Discount::findOrFail($id);
        $data = $request->all();
       
        $date = Carbon::createFromFormat('d/m/Y', $data['startdate']);
        $data['startdate'] =  $date->format('Y-m-d');

        $date = Carbon::createFromFormat('d/m/Y', $data['enddate']);
        $data['enddate'] =  $date->format('Y-m-d');
       
        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/discount',$photo_name);
            $data['image'] = $photo_name;
        }
        if($request->status == "")
        {
            $data['status'] = 0;
        }
        else
        {
            $data['status'] = 1;
        }
       
        $discount->update($data);

        $discountdeflang_exists = DiscountTranslations::where('langcode', '=', $request->default_langcode)->where('discountid', '=', $id)->first();

        if($discountdeflang_exists != null)
        {
            DiscountTranslations::where('langcode', '=', $request->default_langcode)->where('discountid', '=', $id)->update(['title' => $request->title, 'description' => $request->description]);
        }
        else
        {
            $blogtrans = new DiscountTranslations();
            $blogtrans['discountid'] = $id;
            $blogtrans['title'] = $request->title;
            $blogtrans['description'] = $request->description;
            $blogtrans['langcode'] = $request->default_langcode;
            $blogtrans['company_id'] = get_company_id();
            $blogtrans->save();
        }
        
        if($request->langcode)
        {
            foreach($request->langcode as $data => $transdata)
            {
                $discountlang_exists = DiscountTranslations::where('langcode', '=', $transdata)->where('discountid', '=', $id)->first();
                if(count($discountlang_exists) > 0)
                {

                    DiscountTranslations::where('langcode', '=', $transdata)->where('discountid', '=', $id)->update(['title' => $request->trans_title[$data], 'description' => $request->trans_description[$data]]);
                }
                else
                {
                    $blogalltrans = new DiscountTranslations();
                    $blogalltrans['discountid'] = $id;
                    $blogalltrans['title'] = $request->trans_title[$data];
                    $blogalltrans['description'] = $request->trans_description[$data];
                    $blogalltrans['langcode'] = $transdata;
                    $blogalltrans['company_id'] = get_company_id();
                    $blogalltrans->save();
                }
                
            }
            
        }

        return redirect('admin/discount')->with('message', trans("app.DiscountUpdateMsg"));
    }

    public function status($subdomain,$id , $status)
    {
        $discount = Discount::findOrFail($id);
        $input['status'] = $status;

        $discount->update($input);
        return redirect('admin/discount')->with('message', trans("app.DiscountStatusUpdateMsg"));
    }
	
	public function exist_discode(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();
        
        if($id != '')
        {
            $code_exists = (count(\App\Discount::where('id', '!=', $id)->where('company_id', '=', $companyid)->where('code', '=', $request->input('code'))->get()) > 0) ? false : true;
            return response()->json($code_exists);
        }
        else
        {
            $code_exists = (count(\App\Discount::where('code', '=', $request->input('code'))->where('company_id', '=', $companyid)->get()) > 0) ? false : true;
            return response()->json($code_exists);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        $discount = Discount::findOrFail($id);

        if($discount->image != '')
        {
            unlink('assets/images/discount/'.$discount->image);
        }
        
        $discount->delete();

        $discounttrans = DiscountTranslations::where('discountid',$id);
        $discountytrans->delete();

        return redirect('admin/discount')->with('message', trans("app.DiscountDeleteMsg"));
    }

    public function deleteimage(Request $request , $subdomain ,$id )
    {
        // dd($request);

        $discount = Discount::findOrFail($id); 
       
        if($discount->image != '')
        {
            unlink('assets/images/discount/'.$discount->image);
        }
       
        $data['image'] = '';
        $updatedata = $discount->update($data);
    }

     public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 

                        0 =>'code',
                        1 =>'title',
                        2 =>'startdate',
                        3 =>'enddate',    
                        4 =>'status',
                        5 =>'action',
                        
                         );
                    
    $totalData = Discount::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Discount::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Discount::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                               ->orWhere('email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


        $totalFiltered = Discount::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
            // $etitle=CmsTranslations::where('cmsid',$post->id)->where('langcode',app()->getLocale() )->first()->title;

                $nestedData['code'] =$post->code;
                $nestedData['title'] =$post->title;
                $nestedData['phone'] =$post->phone;
                $nestedData['startdate'] =$post->startdate;
                $nestedData['enddate'] =$post->enddate;

             
               if($post->status == 1)
                  {

                  $nestedData['status'] = "<a href='".url('admin/discount')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                          
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/discount')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                } 

                $nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='discount/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";
                
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
