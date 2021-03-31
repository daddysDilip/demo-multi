<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Blog;
use DB;
use App\SectionTitles;
use Illuminate\Http\Request;
use File;
use URL;
use Auth;

class BlogController extends Controller
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
        $titles = SectionTitles::where('company_id', '=', $companyid)->get();
        $blogs = Blog::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('sadmin.blogsection',compact('blogs','titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sadmin.blogadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $blog = new Blog();
        $blog->fill($request->all());

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/blog',$photo_name);
            $blog['featured_image'] = $photo_name;
        }

        if ($request->status == ""){
            $blog['status'] = 0;
        }
        else
        {
           $blog['status'] = 1; 
        }



        $blog['company_id'] = get_company_id();

        $blog->save();
        return redirect('sadmin/blog')->with('message','New Blog Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('sadmin.blogedit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $data = $request->all();

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/blog',$photo_name);
            $data['featured_image'] = $photo_name;
        }

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $blog->update($data);
        return redirect('sadmin/blog')->with('message','Blog Updated Successfully.');
    }

    public function status($id , $status)
    {
        $blog = Blog::findOrFail($id);
        $input['status'] = $status;

        $blog->update($input);

        return redirect('sadmin/blog')->with('message','Blog Status Updated Successfully.');
    }
    
    public function titles(Request $request)
    {
        $companyid = get_company_id();

        $blog = SectionTitles::where('company_id', $companyid);
        $data['blog_title'] = $request->blog_title;
        $data['blog_text'] = $request->blog_text;

        $blog->update($data);

        return redirect('sadmin/blog')->with('message','Blog Section Title & Text Updated Successfully.');
    }

    public function exist_titles(Request $request){

        $id = $request->input('id');

        $id = get_company_id();

            dd($id);

        if($id != '')
        {
            $title_exists = ((\App\Blog::where('id', '!=', $id)->where('company_id', '=', $companyid)->where('title', '=', $request->input('title'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
    $title_exists = ((\App\Blog::where('title', '=', $request->input('title'))->where('company_id', '=', $companyid)->get()) != null) ? false : true;

            return response()->json($title_exists);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect('sadmin/blog')->with('message','Blog Delete Successfully.');
    }


    public function deleteimage(Request $request , $id)
    {
        echo $id;
        $blog = Blog::findOrFail($id); 
       
        if($blog->featured_image != '')
        {
            unlink('assets/images/blog/'.$blog->featured_image);
        }
       
        $data['featured_image'] = '';
        $updatedata = $blog->update($data);
    }




     public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                            // 0 =>'id', 
                            // 1 =>'title',
                            // 2=> 'body',
                            // 3=> 'created_at',
                            // 4=> 'id',

                        0 =>'featured_image',
                        1 =>'title',
                        2 =>'views',
                        3 =>'status',
                        4 =>'action',
                         );
  
        $totalData = Blog::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Blog::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Blog::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('title', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Banner::where('company_id',$companyid)
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
              
                                

             if($post->featured_image != '')
            {
            $image= "<img style='width: 300px;height: 100px;' src='".url("/")."/assets/images/blog/".$post->featured_image."'>";
              }
               else
               {
        
                  $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive' width='300' height='300' style='width: 300px;height: 100px;'>";
              }
                   

                                            
                $nestedData['featured_image'] =$image;
                $nestedData['title'] =$post->title;
                $nestedData['views']=$post->views;


                       if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('sadmin/blog')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                                        
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('sadmin/blog')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                   // $nestedData['status'] = <a href="{!! url('sadmin/cms') !!}/status/{{$allcms->id}}/1" class="btn btn-danger btn-xs">Deactive</a>

                }
                      
             

$nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='blog/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";






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
