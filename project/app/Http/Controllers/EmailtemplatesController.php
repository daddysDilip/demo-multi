<?php

namespace App\Http\Controllers;

use App\Emailtemplates;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;
use Illuminate\Support\Str;

class EmailtemplatesController extends Controller
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
        $emailtemplates = Emailtemplates::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.emailtemplateslist',compact('emailtemplates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // return view('admin.emailtemplatesadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $emailtemplates = new Emailtemplates();
        $emailtemplates->fill($request->all());
       
        $slug = Str::slug($emailtemplates['title'], '-');
        
		$emailtemplates['company_id'] = 0;
        $emailtemplates['tempcode'] = str_random(6);

        if ($request->status == "")
        {
            $emailtemplates['status'] = 0;
        }
        else
        {
            $emailtemplates['status'] = 1;
        }

        $emailtemplates['company_id'] = get_company_id();

        $emailtemplates->save();
        return redirect('admin/emailtemplates')->with('message','New Email Template Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emailtemplates  $news
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emailtemplates  $emailtemplates
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {
        $emailtemplates = Emailtemplates::findOrFail($id);
        return view('admin.emailtemplatesedit',compact('emailtemplates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emailtemplates  $emailtemplates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain,$id)
    {
        $emailtemplates = Emailtemplates::findOrFail($id);
        $data = $request->all();

       /* if ($file = $request->file('newsimage')){
            $photo_name = str_random(3).$request->file('newsimage')->getClientOriginalName();
            $file->move('assets/images/news',$photo_name);
            $data['newsimage'] = $photo_name;
        }*/

        if(isset($data['status']))
        {
            $data['status'] = 1;
        }
        else
        {
            $data['status'] = 0;
        }
       
        $emailtemplates->update($data);
        return redirect('admin/emailtemplates')->with('message','Email Templates Updated Successfully.');
    }

    public function status($subdomain,$id , $status)
    {
        $emailtemplates = Emailtemplates::findOrFail($id);
        $input['status'] = $status;

        $emailtemplates->update($input);
        return redirect('admin/emailtemplates')->with('message','Email Template Status Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emailtemplates  $emailtemplates
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        $emailtemplates = Emailtemplates::findOrFail($id);
        $emailtemplates->delete();
        return redirect('admin/emailtemplates')->with('message','Email Template Delete Successfully.');
    }

    public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 

                        0 =>'title',
                        1 =>'fromname',
                        2 =>'subject',
                        3 =>'action',
                         );
                    




        $totalData = Emailtemplates::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Emailtemplates::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Emailtemplates::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('title', 'LIKE',"%{$search}%")
                            ->orWhere('fromname', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Emailtemplates::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('title', 'LIKE',"%{$search}%")
                            ->orWhere('fromname', 'LIKE',"%{$search}%")
                          
                             ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
  // $etitle=CmsTranslations::where('cmsid',$post->id)->where('langcode',app()->getLocale() )->first()->title;
            // $etitle=CmsTranslations::where('cmsid',$post->id)->where('langcode',app()->getLocale() )->first()->title;
                
                $nestedData['title'] =$post->title;
                $nestedData['fromname'] =$post->fromname;
                $nestedData['subject']= $post->subject;
              
                //        if($post->status == 1)
                //  {
                //   $nestedData['status'] = "<a href='".url('admin/cms')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                //  }                                       
                // elseif($post->status == 0)
                // {
                //       $nestedData['status'] = "<a href='".url('admin/cms')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                // }
                              
$nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='emailtemplates/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li></ul></div>";

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
