<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\Request;
use Auth;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companyid = get_company_id();
        $slider = Slider::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('sadmin.sliderlist',compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sadmin.slideradd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slider = new Slider();
        $slider->fill($request->all());

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/sliders',$photo_name);
            $slider['image'] = $photo_name;
        }

        if ($request->status == ""){
            $slider['status'] = 0;
        }
        else
        {
           $slider['status'] = 1; 
        }

        $slider['company_id'] = get_company_id();

        $slider->save();
        return redirect('sadmin/sliders')->with('message','Slider Added Successfully.');
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
        $slider = Slider::findOrFail($id);
        return view('sadmin.slideredit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $slider = Slider::findOrFail($id);
        $data = $request->all();

        if ($file = $request->file('image')){
            $photo_name = str_random(3).$request->file('image')->getClientOriginalName();
            $file->move('assets/images/sliders',$photo_name);
            $data['image'] = $photo_name;
            if($slider->image != '')
            {
                unlink('assets/images/sliders/'.$slider->image);
            }
        }

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $slider->update($data);
        return redirect('sadmin/sliders')->with('message','Slider Updated Successfully.');
    }

    public function status($id, $status)
    {
        $slider = Slider::findOrFail($id);
        $input['status'] = $status;

        $slider->update($input);

        return redirect('sadmin/sliders')->with('message','Slider Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        
        if($slider->image != '')
        {
            unlink('assets/images/sliders/'.$slider->image);
        }
        $slider->delete();
        return redirect('sadmin/sliders')->with('message','Slider Delete Successfully.');
    }

    public function deleteimage($id)
    {
        $slider = Slider::findOrFail($id); 
       
        if($slider->image != '')
        {
            unlink('assets/images/sliders/'.$slider->image);
        }
       
        $data['image'] = '';
        $updatedata = $slider->update($data);
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
                        0 =>'image',   
                        1 =>'title',
                        2 =>'status',
                        3 =>'actions',
                         );
  
        $totalData = Slider::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Slider::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Slider::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('title', 'LIKE',"%{$search}%")
                             
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered =Slider::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                             ->orWhere('title', 'LIKE',"%{$search}%")
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
            $image= "<img style='width: 300px;height: 100px;' src='".url("/")."/assets/images/sliders/".$post->image."'>";
              }
               else
               {
        
                  $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive' width='300' height='300' style='width: 300px;height: 100px;'>";
              }
                                    
              

                $nestedData['image'] = $image;
                $nestedData['title'] = $post->title;
              

                 if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('sadmin/sliders')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                                        
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('sadmin/sliders')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                   // $nestedData['status'] = <a href="{!! url('sadmin/cms') !!}/status/{{$allcms->id}}/1" class="btn btn-danger btn-xs">Deactive</a>

                }
    $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='sliders/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";
       

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
