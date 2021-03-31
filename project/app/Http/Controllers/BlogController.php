<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogTranslations;
use DB;
use App\SectionTitles;
use Illuminate\Http\Request;
use File;
use URL;
use Auth;
use Excel;
use Illuminate\Support\Str;

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
        return view('admin.blogsection',compact('blogs','titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blogadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //dd($request->all());
        $blog = new Blog();
        $blog->fill($request->all());

        $cslug = Str::slug($request->title, '-');
        $slugcheck = Blog::where('slug','=',$cslug)->count();

        $slug="";
        if($slugcheck > 0 )
        {   
            $slug = $cslug."_".($slugcheck-1);
        }
        else
        {
            $slug = $cslug;
        }




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
        $blog['slug'] = $slug;
        $blog['company_id'] = get_company_id();

           // dd($blog); 
        $blog->save();

        $blogtrans = new BlogTranslations();
        $blogtrans['blogid'] = $blog->id;
        $blogtrans['title'] = $request->title;
        $blogtrans['details'] = $request->details;
        $blogtrans['langcode'] = $request->default_langcode;
        $blogtrans['company_id'] = get_company_id();
        $blogtrans->save();



        if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {
            $blogalltrans = new BlogTranslations();
            $blogalltrans['blogid'] = $blog->id;
            $blogalltrans['title'] = $request->trans_title[$data];
            $blogalltrans['details'] = $request->trans_details[$data];
            $blogalltrans['langcode'] = $transdata;
            $blogalltrans['company_id'] = get_company_id();
            $blogalltrans->save();    
            
        }
    }



        return redirect('admin/blog')->with('message', trans("app.BlogAddMsg"));
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
        $blog = Blog::findOrFail($id);
        return view('admin.blogedit',compact('blog'));
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
        $blog = Blog::findOrFail($id);
        $data = $request->all();

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/blog',$photo_name);
            $data['featured_image'] = $photo_name;

            if($blog->featured_image != '')
            {
                unlink('assets/images/blog/'.$blog->featured_image);
            }
        }

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $blog->update($data);

        $blogdeflang_exists = BlogTranslations::where('langcode', '=', $request->default_langcode)->where('blogid', '=', $id)->first();

        if(count($blogdeflang_exists) > 0)
        {
            BlogTranslations::where('langcode', '=', $request->default_langcode)->where('blogid', '=', $id)->update(['title' => $request->title, 'details' => $request->details]);
        }
        else
        {
            $blogtrans = new BlogTranslations();
            $blogtrans['blogid'] = $id;
            $blogtrans['title'] = $request->title;
            $blogtrans['details'] = $request->details;
            $blogtrans['langcode'] = $request->default_langcode;
            $blogtrans['company_id'] = get_company_id();
            $blogtrans->save();
        }
        
          if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {
            $bloglang_exists = BlogTranslations::where('langcode', '=', $transdata)->where('blogid', '=', $id)->first();
            if(count($bloglang_exists) > 0)
            {

                BlogTranslations::where('langcode', '=', $transdata)->where('blogid', '=', $id)->update(['title' => $request->trans_title[$data], 'details' => $request->trans_details[$data]]);
            }
            else
            {
                $blogalltrans = new BlogTranslations();
                $blogalltrans['blogid'] = $id;
                $blogalltrans['title'] = $request->trans_title[$data];
                $blogalltrans['details'] = $request->trans_details[$data];
                $blogalltrans['langcode'] = $transdata;
                $blogalltrans['company_id'] = get_company_id();
                $blogalltrans->save();
            }
            
        }
    }

        return redirect('admin/blog')->with('message', trans("app.BlogUpdateMsg"));
    }

    public function status($subdomain,$id , $status)
    {
        $blog = Blog::findOrFail($id);
        $input['status'] = $status;

        $blog->update($input);

        return redirect('admin/blog')->with('message', trans("app.BlogStatusUpdateMsg"));
    }

    public function exist_titles(Request $request)
    {

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
            $title_exists = (count(\App\Blog::where('id', '!=', $id)->where('company_id', '=', $companyid)->where('title', '=', $request->input('title'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = (count(\App\Blog::where('title', '=', $request->input('title'))->where('company_id', '=', $companyid)->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        $blog = Blog::findOrFail($id);

        if($blog->featured_image != '')
        {
            unlink('assets/images/blog/'.$blog->featured_image);
        }

        $blog->delete();

        $blogtrans = BlogTranslations::where('blogid',$id);
        $blogtrans->delete();

        return redirect('admin/blog')->with('message', trans("app.BlogDeleteMsg"));
    }

    public function deleteimage(Request $request , $subdomain ,$id )
    {
        // dd('innnnnnnnnnn');

        $blog = Blog::findOrFail($id); 
       
        if($blog->featured_image != '')
        {
            unlink('assets/images/blog/'.$blog->featured_image);
        }
       
        $data['featured_image'] = '';
        $updatedata = $blog->update($data);
    }

    public function Exportdata()
    { 

        $companyid = get_company_id();
        $blogs = Blog::where('company_id',$companyid)->orderBy('id','desc')->get();

        // dd($blogs);
    
        $blogArray = []; 

        $blogArray[] = ['Sr.NO','Blog Title','Featured Image','Blog Details','status'];
        $i = 1;
        foreach ($blogs as $alldata) 
        {
            if($alldata->status == 1)
            {
                $status = 'Active';
            }
            else if($alldata->status == 0)
            {
                $status = 'Deactive';
            }

            $title = '';
            $details = '';

            $blogtrans = BlogTranslations::where('blogid',$alldata->id)->where('langcode',get_defaultlanguage())->first();

            if(count($blogtrans) > 0)
            {
                $title = $blogtrans->title;
                $details = $blogtrans->details;
            }

            $blogArray[] = array($i,$title,$alldata->featured_image,$details,$status);
            $i++;
        }   

        Excel::create('Blogs', function($excel) use ($blogArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Blogs List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('Blogs List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($blogArray) {
                $sheet->fromArray($blogArray, null, 'A1', false, false);
            });

        })->download('xlsx');
        
    }


    public function import(Request $request)
    {

        // dd($request->all());

        $companyid = get_company_id();

        if($request->file('imported_file'))
        {
            $path = $request->file('imported_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            // if(!empty($data) && $data->count())
            // {
            //     $data = $data->toArray();
            //     echo count($data);
                for($i=0;$i<count($data);$i++)
                {
                  $dataImported[] = $data[$i];
                }
            // }

            // echo '<pre>'; print_r($dataImported); echo '</pre>';
             
            // Blog::insert($dataImported);
            if($dataImported != null)
            {

                // dd($dataImported);

                foreach ($dataImported as $value)
                {         

                    $cslug = Str::slug($value['blog_title'], '-');
                    $slugcheck = Blog::where('slug','=',$cslug)->count();

                    $slug="";
                    if($slugcheck > 0 )
                    {   
                        $slug = $cslug."_".($slugcheck-1);
                    }
                    else
                    {
                        $slug = $cslug;
                    }
    
                    if($value['status'] == 'Active')
                    {
                        $status=1;
                    } 
                    else
                    {
                        $status=0;
                    }

                    $image = $value['featured_image'];

                    if($image != null)
                    {
                        $rand_imagname =str_random(6);
                        $url = $image; 
                        //dd($url);
                        
                        $filename = $rand_imagname."_".substr($url, strrpos($url, '/') + 1);
                        $image = $filename;
              
                        file_put_contents('assets/images/blog/'.$filename, file_get_contents($url));
                        //dd($filename);

                    }
                    else
                    {
                        $image=null;
                    }

                    $blog = new Blog();
                    $blog['title'] = $value['blog_title'];
                    $blog['details'] = $value['blog_details'];
                    $blog['featured_image'] = $image;
                    $blog['slug'] = $slug;
                    $blog['status'] = $status;
                    $blog['company_id'] = $companyid;
                    $blog->save(); 

                    $blogtrans = new BlogTranslations();
                    $blogtrans['blogid'] = $blog->id;
                    $blogtrans['title'] = $value['blog_title'];
                    $blogtrans['details'] = $value['blog_details'];
                    $blogtrans['langcode'] = get_defaultlanguage();
                    $blogtrans['company_id'] = get_company_id();
                    $blogtrans->save();

                }
                 
            }

        }
        return back();
    }


    public function createSlug($title)
    {
        // Normalize the title
        $slug = Str::slug($title);

        $allSlugs = Blog::where('slug', 'like', $slug.'%')->count();

        // If we haven't used it before then we are all good.
        if ($allSlugs == 0){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) 
        {
            $newSlug = $slug.'-'.$i;
            $newSlugs = Blog::where('slug', 'like', $slug.'%')->count();

            if ($newSlugs == 0)
            {
                return $newSlug;
            }

            echo $newSlugs;
          
        }
        // throw new \Exception('Can not create a unique slug');
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


            $totalFiltered = Blog::where('company_id',$companyid)
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
                  $nestedData['status'] = "<a href='".url('admin/blog')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                                        
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/blog')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                 

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
