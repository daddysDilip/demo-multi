<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Planupgradepay;
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
        $upgradeplan = Planupgradepay::join('company', 'company.id', '=', 'planupgradepay.company_id' ,'left')->join('plans', 'plans.id', '=', 'planupgradepay.planid' ,'left')->select(DB::raw("planupgradepay.*,company.comapany_name,plans.plantype"))->get();
        return view('sadmin.upgradeplanlist',compact('upgradeplan'));
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
    public function show($id)
    {
        //
    }

    public function Exportdata()
    {
        $uplan = Planupgradepay::join('company', 'company.id', '=', 'planupgradepay.company_id' ,'left')->join('plans', 'plans.id', '=', 'planupgradepay.planid' ,'left')->select(DB::raw("planupgradepay.id,company.comapany_name,plans.plantype,planupgradepay.payamount,DATE_FORMAT(planupgradepay.start_date,'%d-%m-%y'),DATE_FORMAT(planupgradepay.expiry_date,'%d-%m-%y')"))->get();

        $uplanArray = []; 

        $uplanArray[] = ['id', 'Compnay Name', 'Plan Type', 'Payment', 'Payment Date','Expiry Date'];
       
        foreach ($uplan as $alldata) 
        {
            $uplanArray[] = $alldata->toArray();
        }

        Excel::create('upgradeplan', function($excel) use ($uplanArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Upgrade Plan List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('Upgrade Plan List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($uplanArray) {
                $sheet->fromArray($uplanArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request,$id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
