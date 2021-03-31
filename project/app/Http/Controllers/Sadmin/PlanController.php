<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Plans;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;
use App\Planupgradepay;

class PlanController extends Controller
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
        $plan = Plans::all();
        return view('sadmin.planlist',compact('plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sadmin.planadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plan = new Plans();
        $plan->fill($request->all());

        if ($request->status == "")
        {
            $plan['status'] = 0;
        }
        else
        {
            $plan['status'] = 1;
        }

        $plan->save();
        return redirect('sadmin/plans')->with('message','New Plan Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plans  $plan
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
        $plan = Plans::findOrFail($id);
        $upgradeplan = Planupgradepay::all();
        return view('sadmin.planedit',compact('plan','upgradeplan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plans  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $plan = Plans::findOrFail($id);
        $data = $request->all();

        if ($request->status == "")
        {
            $data['status'] = 0;
        }
        else
        {
            $data['status'] = 1;
        }
       
        $plan->update($data);
        return redirect('sadmin/plans')->with('message','Plan Updated Successfully.');
    }

    public function status($id, $status)
    {
        $plan = Plans::findOrFail($id);
        $input['status'] = $status;

        $plan->update($input);
        return redirect('sadmin/plan')->with('message','Plan Status Updated Successfully.');
    }
	
	public function type_exists(Request $request){

        $id = $request->input('id');

        if($id != '')
        {
             $title_exists = ((\App\Plans::where('id', '!=', $id)->where('plantype', '=', $request->input('plantype'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = ((\App\Plans::where('plantype', '=', $request->input('plantype'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plans  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plans::findOrFail($id);
        $plan->delete();
        return redirect('sadmin/plans')->with('message','Plan Delete Successfully.');
    }
}
