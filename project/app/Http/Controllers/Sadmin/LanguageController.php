<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Language;
use Auth;
use DB;


class LanguageController extends Controller
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
        if(!has_permission('Language Manage'))
        {
            return redirect('admin/accessdenied');
        }
        
    				
    	$lang=Language::all();

    	return view('sadmin.languagelist',compact('lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sadmin.languageadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

    	$language = new Language();
        $language->fill($request->all());


        if ($file = $request->file('image'))
        {
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/language',$photo_name);
            $language['image'] = $photo_name;
        }

        if ($request->status == ""){
            $language['status'] = 0;
        }
        else
        {
           $language['status'] = 1; 
        }

        $language['createby'] =
        $language->save();

    	return redirect('sadmin/language')->with('message','New language Added Successfully.');

    }


    public function status($id, $status)
    {
        $language = Language::findOrFail($id);
        $input['status'] = $status;
        $language->update($input);
            
        return redirect('sadmin/language')->with('message','Language Updated Successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $lang = Language::findOrFail($id);

        return view('sadmin.languageedit',compact('lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        $data = $request->all();
        	
        if ($file = $request->file('image'))
        {
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/language',$photo_name);
            $data['image'] = $photo_name; 
        }
        else{
            $data['image']=$request->hidd_image;
        }

        if ($request->status == "")
        {
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $language->update($data);
        return redirect('sadmin/language')->with('message','Language Updated Successfully.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        $language->delete();
        return redirect('sadmin/language')->with('message','Slider Delete Successfully.');
    }

   public function exist_titles(Request $request)
   {	
   

        $id = $request->input('id');

        if($id != '')
        {
            $title_exists = ((\App\Language::where('id', '!=', $id)->where('name', '=', $request->input('name'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = ((\App\Language::where('name', '=', $request->input('name'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }  
    }


    public function exist_code(Request $request)
    {

        $id = $request->input('id');

        if($id != '')
        {
            $code_exists = ((\App\Language::where('id', '!=', $id)->where('code', '=', $request->input('code'))->get()) != null) ? false : true;
            return response()->json($code_exists);
        }
        else
        {
            $code_exists = ((\App\Language::where('code', '=', $request->input('code'))->get()) != null) ? false : true;
            return response()->json($code_exists);
        }  
    }


    public function deleteimage(Request $request, $id)
    {
       
        $language = Language::findOrFail($id); 
       
        if($language->image != '')
        {
            unlink('assets/images/language/'.$language->image);
        }
       
        $data['image'] = '';
        $language->update($data);
    }

       public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                            
                0  => 'image',
                1  => 'language',
                2  => 'code',
                3  => 'status',
                4  => 'actions',
            );
  
        $totalData = Language::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Language::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Language::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                             ->orWhere('code', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


    $totalFiltered =Language::where('id','LIKE',"%{$search}%")
                            ->orWhere('name','LIKE',"%{$search}%")
                             ->orWhere('code','LIKE',"%{$search}%")
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

                       // $image=<img src="url('/assets/images/language')}}/{{$langu->image}}" alt="" class="service-icon" width="120px" height="70px">

                    $image= "<img style='width: 120px;height: 70px;' src='".url("/")."/assets/images/language/".$post->image."'>";
                     }
                                          
                    else
                    {

                       $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive'style='width: 120px;height: 70px;'>";


                    }

            





                 
                $nestedData['image'] = $image;
                $nestedData['language'] = $post->name;
                $nestedData['code'] = $post->code;


             


                 if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('sadmin/language')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                                        
                elseif($post->status == 0)
                {
                
                $nestedData['status'] = "<a href='".url('sadmin/language')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
                      

    $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='language/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";
       

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