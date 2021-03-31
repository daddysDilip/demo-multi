<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Themes;
use App\Plans;
use App\Themeplans;
use App\Settings;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;
use Illuminate\Support\Str;

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
        $theme = Themes::all();
        $activetheme = Settings::select(DB::raw("theme"))->get();

        // $buytheme = array();
        // $i =0;
        // foreach ($settings as $buytheme) {
        //     $buytheme[$i] = $buytheme->theme;
        //     $i++;
        // }
         
        return view('sadmin.themelist',compact('theme','activetheme'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plan = Plans::where('status', '=', 1)->get();
        return view('sadmin.themeadd',compact('plan'));
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
            $theme['themeprice'] = 0;
        }
        else
        {
            $theme['paid'] = 1;
        }
        $theme['foldername'] = Str::slug($theme['themename'], '-'); 

        $theme->save();
        $themeid = $theme->id;

        $plan = $request->planid;
       
        if($themeid)
        {   if(isset($plan))
            {
                foreach($plan as $planid)
                {  
                    $themeplan = new Themeplans();
                    
                    $themeplan['themeid'] = $themeid;
                    $themeplan['planid'] = $planid;
     
                    $themeplan->save();
                }
            }
            
       }

        return redirect('sadmin/themes')->with('message','New Theme Added Successfully.');
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
        $theme = Themes::findOrFail($id);
        $themeplan = Themeplans::where('themeid', '=', $id)->get();
        $plan = Plans::where('status', '=', 1)->get();
        return view('sadmin.themeedit',compact('theme','plan','themeplan'));
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
        $theme = Themes::findOrFail($id);
        $data = $request->all();

        if ($file = $request->file('themeimage')){
            $photo_name = str_random(3).$request->file('themeimage')->getClientOriginalName();
            $file->move('assets/images/themes',$photo_name);
            $data['themeimage'] = $photo_name;
            if($theme->themeimage != '')
            {
                unlink('assets/images/themes/'.$theme->themeimage);
            }
        }

        if ($request->paid == "")
        {
            $data['paid'] = 0;
            $data['themeprice'] = 0;
        }
        else
        {
            $data['paid'] = 1;
        }
       
        $theme->update($data);

        $plans = Themeplans::where('themeid', '=', $id)->get();

        if(isset($data['planid']))
        {   
            $planid =$data['planid'];
        }
        else
        {
            $planid = '';
        }
 
        if($plans != NULL && $planid != NULL)
        {
            foreach($plans as $pid)
            {
                if(!in_array($pid->planid,$planid))
                {
                    $themeplan = Themeplans::where('id',$pid->id);
                    $themeplan->delete();
                }
                else
                {               
                    $dataplan[] = $pid->planid;
                }               
            }
        }
        elseif($plans != NULL && $planid == NULL)
        {
            foreach($plans as $pid)
            {   
                $themeplan = Themeplans::where('id',$pid->id);
                $themeplan->delete();
            }
        }

        if($planid != NULL)
        {
            foreach($planid as $postid)
            {      
                $themeplan = new Themeplans();

                $themeplan['themeid'] = $id;
                $themeplan['planid'] = $postid;
 
                $themeplan->save();         
            }
        }   

        return redirect('sadmin/themes')->with('message','Theme Updated Successfully.');
    }
	
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
    public function destroy($id)
    {   
        $companyid = get_company_id();
        $theme = Themes::findOrFail($id); 
        $settings = Settings::select("theme")->get();
        
        foreach($settings as $alldata)
        {
            $themeid[] = $alldata->theme;
        }
        
        if(in_array($id,$themeid))
        {
            return redirect('sadmin/themes')->with('error','You Can Not Delete Theme. Beacause Of This Theme Is Activated.');
        }
        else
        {
            if($theme->themeimage != '')
            {
                unlink('assets/images/themes/'.$theme->themeimage);
            }
            $theme->delete();
            return redirect('sadmin/themes')->with('message','Theme Delete Successfully.');
        }
        
    }

    public function deleteimage(Request $request,$id)
    {

        $theme = Themes::findOrFail($id); 
       
        if($theme->themeimage != '')
        {
            unlink('assets/images/themes/'.$theme->themeimage);
        }
       
        $data['themeimage'] = '';
        $updatedata = $theme->update($data);
    }


    

}
