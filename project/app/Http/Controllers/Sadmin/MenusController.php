<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Menus;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 

class MenusController extends Controller
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
        $allmenus = Menus::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('sadmin.menulist',compact('allmenus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
        return view('sadmin.menuadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $allmenu = new Menus();
        $allmenu->fill($request->all());

        /*if ($file = $request->file('newsimage')){
            $photo_name = str_random(3).$request->file('newsimage')->getClientOriginalName();
            $file->move('assets/images/news',$photo_name);
            $news['newsimage'] = $photo_name;
        }*/
        
        
		$allmenu['company_id'] = get_company_id();
        $allmenu['tempcode'] = str_random(6);
        if(isset($allmenu['status']))
        {
            $allmenu['status'] = 1;
        }
        else
        {
            $allmenu['status'] = 0;
        }

        $allmenu->save();
        return redirect('sadmin/menus')->with('message','New Menu Added Successfully.');
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
        $allmenu = Menus::findOrFail($id);
        return view('sadmin.menuedit',compact('allmenu'));
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
        $allmenu = Menus::findOrFail($id);
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
       
        $allmenu->update($data);
        return redirect('sadmin/menus')->with('message','Menu Updated Successfully.');
    }

    public function status($id , $status)
    {
        $allmenus = Menus::findOrFail($id);
        $input['status'] = $status;

        $allmenus->update($input);
        return redirect('sadmin/menus')->with('message','Menu Status Updated Successfully.');
    }

   
	
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $allmenus = Menus::findOrFail($id);
        $allmenus->delete();
        return redirect('sadmin/menus')->with('message','Menu Delete Successfully.');
    }
}
