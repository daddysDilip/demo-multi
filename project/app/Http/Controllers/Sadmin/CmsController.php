<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Cms;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;

class CmsController extends Controller
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
        $cms = Cms::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('sadmin.cmslist',compact('cms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sadmin.cmsadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cms = new Cms();
        $cms->fill($request->all());

        $slug = str_slug($cms['name'], '-');
        $cms['slug'] = $slug;
        $cms['tempcode'] = str_random(6);

        if ($request->status == "")
        {
            $cms['status'] = 0;
        }
        else
        {
            $cms['status'] = 1;
        }

        $cms['company_id'] = get_company_id();

        $cms->save();
        return redirect('sadmin/cms')->with('message','New Page Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function show($slug){
		/*print_r($slug)
    $cms = Cms::where('slug', $slug)->first();
    return view('cmspage')->with('cms', $cms);*/ 
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cms = Cms::findOrFail($id);
        return view('sadmin.cmsedit',compact('cms'));
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
        $cms = Cms::findOrFail($id);
        $data = $request->all();

        if ($request->status == "")
        {
            $data['status'] = 0;
        }
        else
        {
            $data['status'] = 1;
        }
       
        $cms->update($data);
        return redirect('sadmin/cms')->with('message','Page Updated Successfully.');
    }

    public function status($id, $status)
    {
        $cms = Cms::findOrFail($id);
        $input['status'] = $status;

        $cms->update($input);
        return redirect('sadmin/cms')->with('message','Page Status Updated Successfully.');
    }
	
	public function exist_titles(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
             $title_exists = (count(\App\Cms::where('id', '!=', $id)->where('company_id', '=', $companyid)->where('name', '=', $request->input('name'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = (count(\App\Cms::where('name', '=', $request->input('name'))->where('company_id', '=', $companyid)->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cms = Cms::findOrFail($id);
        $cms->delete();
        return redirect('sadmin/cms')->with('message','Page Delete Successfully.');
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
                        0 =>'name',   
                        1 =>'title',
                        2 =>'date',
                        3 =>'status',
                        4 =>'actions',
                         );
  
        $totalData = Cms::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Cms::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Cms::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('title', 'LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                               ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered =Cms::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                             ->orWhere('title', 'LIKE',"%{$search}%")
                              ->orWhere('name', 'LIKE',"%{$search}%")
                              ->orWhere('created_at', 'LIKE',"%{$search}%")
                             ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                  if($post->image)
                                
                  $edit = "<a href='javascript::void(0)'"."onclick=".'"return delete_data('.$post->id.');"'."class='btn btn-danger btn-xs'><i class='fa fa-trash fa-lg'></i></a>";
                                     

                                                  
                // $show = $post->id;
                // $edit = $post->id;

                $nestedData['name'] = $post->name;
                $nestedData['title'] = $post->title;
                $nestedData['date'] =$post->created_at->format('jS M Y');


                 if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('sadmin/cms')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                                        
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('sadmin/cms')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                   // $nestedData['status'] = <a href="{!! url('sadmin/cms') !!}/status/{{$allcms->id}}/1" class="btn btn-danger btn-xs">Deactive</a>

                }
                      

    $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='cms/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";
       

           

        // ''.''.''.'<a href="#" onclick="return delete_data("'.$post->id.'");><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a>';


    

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
