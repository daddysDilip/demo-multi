<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\User;
use App\Roles;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use File;
use URL;
use Carbon\Carbon; 

class UserController extends Controller
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
        $user = User::where('role','!=',1)->where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('sadmin.userlist',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyid = get_company_id();
		$roles = Roles::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('sadmin.useradd',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->fill($request->all());

       if ($file = $request->file('photo')){
            $photo = time().$request->file('photo')->getClientOriginalName();
            $file->move('assets/images/admin',$photo);
            $user['photo'] = $photo;
        }
		$user['password'] = Hash::make($request->password);
                
        $user['company_id'] = get_company_id();
        $user['created_by'] = get_user_id();
        
		$parts = explode("@", $user['email']);
        $username = $parts[0];
        $user['username'] =$username; 
       // $user['role'] ='Administrator'; 
        $user['remember_token'] =' '; 
        
        if(isset($user['status']))
        {
            $user['status'] = 1;
        }
        else
        {
            $user['status'] = 0;
        }

        $user->save();
        return redirect('sadmin/user')->with('message','New User Added Successfully.');
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
        $companyid = get_company_id();
        $user = User::findOrFail($id);
		$roles = Roles::where('company_id',$companyid)->orderBy('id','desc')->get();
        if($user->role == 1)
        {
            return back();
        }
        else
        {
            return view('sadmin.useredit',compact('user','roles'));
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();

         if ($file = $request->file('photo')){
            $photo = time().$request->file('photo')->getClientOriginalName();
            $file->move('assets/images/admin',$photo);
            $data['photo'] = $photo;
        }
        if(isset($data['status']))
        {
            $data['status'] = 1;
        }
        else
        {
            $data['status'] = 0;
        }
       
        $user->update($data);
        return redirect('sadmin/user')->with('message','User Updated Successfully.');
    }

    public function status($id, $status)
    {
        $user = User::findOrFail($id);
        $input['status'] = $status;

        $user->update($input);
        return redirect('sadmin/user')->with('message','User Status Updated Successfully.');
    }

    
	
	public function exist_email(Request $request)
    {
        $companyid = get_company_id();
        $id = $request->input('id');

        if($id != '')
        {
            $email_exists = (count(\App\User::where('id', '!=', $id)->where('email', '=', $request->input('email'))->get()) > 0) ? false : true;
            return response()->json($email_exists);
        }
        else
        {

            $email_exists = (count(\App\User::where('email', '=', $request->input('email'))->get()) > 0) ? false : true;
            return response()->json($email_exists);
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
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('sadmin/user')->with('message','User Delete Successfully.');
    }



    public function deleteimage1(Request $request,$id)
    {

        $user = User::findOrFail($id); 
       
        if($user->photo != '')
        {
            unlink('assets/images/admin/'.$user->photo);
        }
       
        $data['photo'] = '';
        $updatedata = $user->update($data);
    }

         public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                          
                        0 =>'name',   
                        1 =>'email',   
                        2 =>'phone',
                        3 =>'status',
                        4 =>'actions',
                         );
  
        $totalData = User::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = User::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  User::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                             
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered =User::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
               
                $nestedData['name'] = $post->name;
                $nestedData['email'] = $post->email;
                $nestedData['phone'] = $post->phone;
              
                 if($post->status == 1)
                 {
                     if($post->created_by == 0)
                    {
                             $nestedData['status'] = "";
                    }
                    else
                    {
                  $nestedData['status'] = "<a href='".url('sadmin/sliders')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";
                    }
            
              }

                
                                        
                else
                {
                      $nestedData['status'] = "<a href='".url('sadmin/sliders')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";

                }


                    if($post->created_by == 0)
                    {
            
            $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='sliders/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li></ul></div>";


                    }
                    else
                    {



    $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='sliders/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";
}
    
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
