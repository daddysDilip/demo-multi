<?php

namespace App\Http\Controllers;

use App\Planupgradepay;
use App\Plans;
use App\Company;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;
use Excel;

class UpgradePlanController extends Controller
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
        $plan = Plans::where('status',1)->orderby('id', 'desc')->get();
        $upgradeplan = Planupgradepay::where('company_id',$companyid)->orderby('id', 'desc')->first();
        return view('admin.upgradeplanlist',compact('plan','upgradeplan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        $companyid = get_company_id();
        $plan = Plans::findOrFail($id);
        $currentplan = Planupgradepay::join('plans','plans.id','=','planupgradepay.planid')->where('planupgradepay.company_id',$companyid)->orderby('planupgradepay.id', 'desc')->first();

        $todaydate = date('Y-m-d'); 
        $expirydate = date('Y-m-d',strtotime($currentplan->expiry_date));

        if($expirydate > $todaydate)
        {
            return redirect('admin/upgradeplan');
        }
        else
        {
            return view('admin.buyplan',compact('plan','currentplan'));
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {   
        //
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
        $companyid = get_company_id();
        $company = Company::where('id',$companyid)->first();

        $data['planid'] = $id;
        $company->update($data);

        $planupgradepay = new Planupgradepay();

        $planupgradepay->fill($request->all());
        $planupgradepay['company_id'] = get_company_id();
        $planupgradepay['reasontochange'] = $request->switch_plan;
        $planupgradepay['start_date'] = date('Y-m-d');
        $planupgradepay['expiry_date'] = date('Y-m-d', strtotime("+30 days") );
        $planupgradepay['duration'] = '1 Month';
        $planupgradepay->save();

        return redirect('admin/upgradeplan')->with('message','Page Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        //
    }
}
