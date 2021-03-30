<?php

namespace App\Http\Controllers;

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
        $user = User::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.userlist',compact('user'));
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
        return view('admin.useradd',compact('roles'));
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
		$parts = explode("@", $user['email']);
        $username = $parts[0];
        $user['username'] =$username; 
        $user['created_by'] = get_user_id();
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
        return redirect('admin/user')->with('message','New User Added Successfully.');
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
        $companyid = get_company_id();
        $user = User::findOrFail($id);
		$roles = Roles::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.useredit',compact('user','roles'));
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
        return redirect('admin/user')->with('message','User Updated Successfully.');
    }

    public function status($subdomain,$id , $status)
    {
        $user = User::findOrFail($id);
        $input['status'] = $status;

        $user->update($input);
        return redirect('admin/user')->with('message','User Status Updated Successfully.');
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
    public function destroy($subdomain,$id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('admin/user')->with('message','User Delete Successfully.');
    }


    public function deleteimage1(Request $request , $subdomain ,$id )
    {
            // dd('innnnnnnnnnn');


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
                        4 =>'action',
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
                               ->orWhere('email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


        $totalFiltered = User::where('company_id',$companyid)
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
                        
               $userid = get_user_id();
               $roleid = get_user_role_id();
                $sadmin = get_sadmin_user_id(); 


                         foreach($sadmin as $alldata)
                         {
                             $sid[]= $alldata->id; 
                         }
                                 
                              

                $nestedData['name'] =$post->name;
                $nestedData['email'] =$post->email;
                $nestedData['phone'] =$post->phone;
                        
                     if(!in_array($post->created_by, $sid))
                     {
                                        if($post->id != $userid)
                                        {
                                            if($post->status == 1)
                                            {

                  $nestedData['status'] = "<a href='".url('admin/user')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                          
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/user')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";

                }
                else
                {
                     $nestedData['status'] = '-';
                }
            }
        } else
                {
                     $nestedData['status'] = '-';
                }

                 if(!in_array($post->created_by, $sid))
                 {

                    if($post->id != $userid)
                    {

                $nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='roles/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li></ul></div>";
                    } else
                    {
                        $nestedData['action'] = '-';
                    }
                } else
                    {
                        $nestedData['action'] = '-';
                    }

    
                $data[] = $nestedData;
                $i++;
            }
             //  echo "<pre>"; print_r($nestedData); echo "</pre>"; exit();
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
