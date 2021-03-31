<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Country;
use Illuminate\Http\Request;
use Auth;

class CountryController extends Controller
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
        $country = Country::all();
        return view('sadmin.countrylist',compact('country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sadmin.countryadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $country = new Country();
        $country->fill($request->all());

        if ($request->status == ""){
            $country['status'] = 0;
        }
        else
        {
           $country['status'] = 1; 
        }

        $country->save();
        return redirect('sadmin/country')->with('message','Country Added Successfully.');
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
        $country = Country::findOrFail($id);
        return view('sadmin.countryedit',compact('country'));
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
        $country = Country::findOrFail($id);
        $data = $request->all();

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $country->update($data);
        return redirect('sadmin/country')->with('message','Country Updated Successfully.');
    }

    public function status($id , $status)
    {
        $country = Country::findOrFail($id);
        $input['status'] = $status;

        $country->update($input);

        return redirect('sadmin/country')->with('message','Country Updated Successfully.');
    }

    public function country_exists(Request $request){

        $id = $request->input('id');

        if($id != '')
        {
             $name_exists = ((\App\Country::where('id', '!=', $id)->where('countryname', '=', $request->input('countryname'))->get()) != null) ? false : true;
            return response()->json($name_exists);
        }
        else
        {
            $name_exists = ((\App\Country::where('countryname', '=', $request->input('countryname'))->get()) != null) ? false : true;
            return response()->json($name_exists);
        }  
    }

    public function sortname_exists(Request $request){

        $id = $request->input('id');

        if($id != '')
        {
             $name_exists = ((\App\Country::where('id', '!=', $id)->where('sortname', '=', $request->input('sortname'))->get()) != null) ? false : true;
            return response()->json($name_exists);
        }
        else
        {
            $title_exists = ((\App\Country::where('sortname', '=', $request->input('sortname'))->get()) != null) ? false : true;
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
        $country = Country::findOrFail($id);
        $country->delete();
        return redirect('sadmin/country')->with('message','Country Delete Successfully.');
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
                        0 =>'countryname',   
                        1 =>'status',
                        2 =>'actions',
                         );
  
        $totalData = Country::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Country::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Country::where('id','LIKE',"%{$search}%")
                            ->orWhere('countryname', 'LIKE',"%{$search}%")
                             
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


    $totalFiltered =Country::where('id','LIKE',"%{$search}%")
                    ->orWhere('countryname', 'LIKE',"%{$search}%")
                    ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                
            
                $nestedData['countryname'] = $post->countryname;
              

             if($post->status == 1)
             {
                 
         $nestedData['status'] = "<a href='".url('sadmin/sliders')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";
             }
                elseif($post->status == 0)
                {
                 $nestedData['status'] = "<a href='".url('sadmin/sliders')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
                      

    $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='country/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";
       

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
