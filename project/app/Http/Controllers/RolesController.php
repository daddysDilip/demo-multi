<?php

namespace App\Http\Controllers;

use App\Roles;
use App\RoleTranslations;
use App\Menus;
use App\Permissions;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 

class RolesController extends Controller
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
        $roles = Roles::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.roleslist',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyid = get_company_id();
		$allmenu = Menus::where('status',1)->where('company_id',$companyid)->get();
		//print_r($menus ); exit;
        return view('admin.rolesadd',compact('allmenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$companyid = get_company_id();
        $roles = new Roles();
        $roles->fill($request->all());
		
		$roles['company_id'] = $companyid;
        $roles['tempcode'] = str_random(6);
        $roles->save();
		$lastid = $roles->id;
		
		if($menuid = $request->menuid)
        {
			foreach($menuid as $merow)
            {
				$permissions = new Permissions;
				$permissions['menuid'] = $merow;
                $permissions['roleid'] = $lastid;
                $permissions['company_id'] = $companyid;
                $permissions->save();
			}	
		}

        $roletrans = new RoleTranslations();
        $roletrans['roleid'] = $lastid;
        $roletrans['role'] = $request->role;
        $roletrans['langcode'] = $request->default_langcode;
        $roletrans['company_id'] = get_company_id();
        $roletrans->save();
        if($request->langcode)
        {
            foreach($request->langcode as $data => $transdata)
            {
                $rolealltrans = new RoleTranslations();
                $rolealltrans['roleid'] = $lastid;
                $rolealltrans['role'] = $request->trans_role[$data];
                $rolealltrans['langcode'] = $transdata;
                $rolealltrans['company_id'] = get_company_id();
                $rolealltrans->save();    
                
            }            
        }

        return redirect('admin/roles')->with('message','New Role Added Successfully.');
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
        $roles = Roles::findOrFail($id);
        $allmenu = Menus::where('status',1)->where('company_id',$companyid)->get();
        $permissions = Permissions::where('roleid',$id)->get();
		$menuids= array();
		foreach($permissions as $permission){
			$menuids[] =$permission->menuid;
		}
		
        return view('admin.rolesedit',compact('roles','allmenu','permissions','menuids'));
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
        $companyid = get_company_id();
        $roles = Roles::findOrFail($id);
        $data = $request->all();

        $roles->update($data);

        $menuid = $request->menuid;

        $perm = Permissions::where('roleid',$id)->get();
		
		if($menuid != NULL){
			//print_r($menuid);
			//$permissions = new Permissions;
				
			foreach($perm as $prow)
            {
    			if(!in_array($prow->menuid, $menuid))
                { 	 
    				//$pe = Permissions::where('menuid',$prow->menuid)->where('roleid',$id);
    			    $pe = Permissions::findOrFail($prow->id);
    				$pe->delete();	
			    }
			}
		}
		elseif($menuid == NULL)
        {
            foreach($perm as $prow)
            {   
                $pe = Permissions::findOrFail($prow->id);
                $pe->delete();  
            }
        }	
		if($newmenuid = $request->newmenuid){
    		foreach($newmenuid as $newmerow){
    			$permission = new Permissions;
    			$permission['menuid'] = $newmerow;
    			$permission['roleid'] = $id;
    			$permission['company_id'] = $companyid;
    			$permission->save();
    		}
		}

        $roledeflang_exists = RoleTranslations::where('langcode', '=', $request->default_langcode)->where('roleid', '=', $id)->first();

        if($roledeflang_exists != null)
        {
            RoleTranslations::where('langcode', '=', $request->default_langcode)->where('roleid', '=', $id)->update(['role' => $request->role]);
        }
        else
        {
            $roletrans = new RoleTranslations();
            $roletrans['roleid'] = $id;
            $roletrans['role'] = $request->role;
            $roletrans['langcode'] = $request->default_langcode;
            $roletrans['company_id'] = get_company_id();
            $roletrans->save();
        }
        

        foreach($request->langcode as $data => $transdata)
        {
            $rolelang_exists = RoleTranslations::where('langcode', '=', $transdata)->where('roleid', '=', $id)->first();
            if($rolelang_exists > 0)
            {

                RoleTranslations::where('langcode', '=', $transdata)->where('roleid', '=', $id)->update(['role' => $request->trans_role[$data]]);
            }
            else
            {
                $rolealltrans = new RoleTranslations();
                $rolealltrans['roleid'] = $id;
                $rolealltrans['role'] = $request->trans_role[$data];
                $rolealltrans['langcode'] = $transdata;
                $rolealltrans['company_id'] = get_company_id();
                $rolealltrans->save();
            }
            
        }

        return redirect('admin/roles')->with('message','Role Updated Successfully.');
    }

    public function status($subdomain,$id , $status)
    {
        $roles = Roles::findOrFail($id);
        $input['status'] = $status;

        $roles->update($input);
        return redirect('admin/roles')->with('message','Role Status Updated Successfully.');
    } 
	
	public function exist_role(Request $request)
    {
        $companyid = get_company_id();
        $id = $request->input('id');

        if($id != '')
        {
            $role_exists = (count(\App\Roles::where('id', '!=', $id)->where('role', '=', $request->input('role'))->where('company_id',$companyid)->get())  > 0) ? false : true;
            return response()->json($role_exists);
        }
        else
        {
            $role_exists = (count(\App\Roles::where('role', '=', $request->input('role'))->where('company_id',$companyid)->get())  > 0) ? false : true;
            return response()->json($role_exists);
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
        $roles = Roles::findOrFail($id);
        $roles->delete();
		$pe = Permissions::where('roleid',$id);
        $pe->delete();
		
        return redirect('admin/roles')->with('message','Role Delete Successfully.');
    }

    public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
            0 =>'role',
            1 =>'action',          
        );
                    
        $totalData = Roles::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Roles::where('company_id',$companyid)->offset($start)->limit($limit)->orderBy($order,$dir)->get();
        }
        else 
        {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Roles::where('company_id',$companyid)->where('id','LIKE',"%{$search}%")->orWhere('role', 'LIKE',"%{$search}%")->offset($start)->limit($limit)->orderBy($order,$dir)->get();


            $totalFiltered = Roles::where('company_id',$companyid)->orwhere('id','LIKE',"%{$search}%")->orWhere('role', 'LIKE',"%{$search}%")->count();
        }
   
        $data = array();

        if(!empty($posts))
        { 
            $i=1;
            foreach ($posts as $post)
            {
                // $etitle=CmsTranslations::where('cmsid',$post->id)->where('langcode',app()->getLocale() )->first()->title;
                
                $nestedData['role'] = $post->role;

                $nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='roles/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>".trans("app.Edit")." </span>". "</a></li></ul></div>";
            
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
