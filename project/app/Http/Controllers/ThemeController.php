<?php

namespace App\Http\Controllers;

use App\Themes;
use App\Plans;
use App\User;
use App\Themeplans;
use App\Settings;
use App\Buytheme;
use App\Company;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;

class ThemeController extends Controller
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
        $user = User::find(Auth::user()->id);
        $theme = Themes::all();
        $themeplan = Company::join('themeplans','themeplans.planid','=','company.planid')->where('company.id', $companyid)->get();
        $settings = Settings::where('company_id', $companyid)->first();
        $buytheme = Buytheme::where('company_id',$companyid)->get();
        
        return view('admin.themelist',compact('theme','settings','themeplan','buytheme'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plan = Plans::where('status', '=', 1)->get();
        return view('admin.themeadd',compact('plan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $theme = new Themes();
        $theme->fill($request->all());

        if ($file = $request->file('themeimage')){
            $photo_name = str_random(3).$request->file('themeimage')->getClientOriginalName();
            $file->move('assets/images/themes',$photo_name);
            $theme['themeimage'] = $photo_name;
        }

        if ($request->paid == "")
        {
            $theme['paid'] = 0;
        }
        else
        {
            $theme['paid'] = 1;
        }

        $theme->save();
        $themeid = $theme->id;

        $plan = $request->planid;
       
        if($themeid)
        {   
            foreach($plan as $planid)
            {  
                $themeplan = new Themeplans();
                
                $themeplan['themeid'] = $themeid;
                $themeplan['planid'] = $planid;
 
                $themeplan->save();
            }
       }

        return redirect('admin/themes')->with('message','New Theme Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        $theme = Themes::findOrFail($id);
        return view('admin.buytheme',compact('theme'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {   
        $theme = Themes::findOrFail($id);
        $themeplan = Themeplans::where('themeid', '=', $id)->get();
        $plan = Plans::where('status', '=', 1)->get();
        return view('admin.themeedit',compact('theme','plan','themeplan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$subdomain,$id)
    {
        $buytheme = new Buytheme();
        $buytheme->fill($request->all());

        $buytheme['themeid'] = $id;

        if ($request->paid == "")
        {
            $buytheme['paid'] = 0;
        }
        else
        {
            $buytheme['paid'] = 1;
        }

        $buytheme['company_id'] = get_company_id();

        $buytheme->save();

        return redirect('admin/themesettings')->with('message','Theme Bought Successfully.');
    }

    public function active($subdomain,$id)
    {
        $companyid = get_company_id();
        $settings = Settings::where('company_id',$companyid)->first();
        $input['theme'] = $id;

        $settings->update($input);
        return redirect('admin/themesettings')->with('message','Theme Activated Successfully.');
    }

    // public function themepayment(Request $request,$subdomain,$id)
    // {
    //     echo $subdomain;
    // }
	
	public function theme_exists(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
            $title_exists = (count(\App\Themes::where('id', '!=', $id)->where('themename', '=', $request->input('themename'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = (count(\App\Themes::where('themename', '=', $request->input('themename'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }  
    }

    public function themeurl_exists(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
            $title_exists = (count(\App\Themes::where('id', '!=', $id)->where('themeurl', '=', $request->input('themeurl'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = (count(\App\Themes::where('themeurl', '=', $request->input('themeurl'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
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
        $theme = Themes::findOrFail($id);
        $theme->delete();
        return redirect('admin/themesettings')->with('message','Theme Delete Successfully.');
    }
}
