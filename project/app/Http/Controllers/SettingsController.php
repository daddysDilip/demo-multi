<?php

namespace App\Http\Controllers;

use App\PageSettings;
use App\SettingsTranslations;
use App\Settings;
use App\SiteLanguage;
use App\PickUpLocations;
use App\PickUpLocationTranslations;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Support\Str;

class SettingsController extends Controller
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
        $companyid = get_company_id();
        $setting = DB::select('select * from settings where company_id=?',[$companyid]);
        $pickups = PickUpLocations::where('company_id',$companyid)->orderBy('id','desc')->get();
        $pageset = PageSettings::where('company_id', '=', $companyid)->get();
        $slanguage = Language::where('status', '=', 1)->get();

        return view('admin.settings', compact('setting','pickups','pageset','slanguage'));
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
        $companyid = get_company_id();

        DB::table('settings')
            ->where('company_id', $companyid)
            ->update(['title' => $request->title]);
        Session::flash('message', trans("app.TitleUpdatedMsg"));
        return redirect('admin/settings');
    }

    public function title(Request $request)
    {
        $companyid = get_company_id();
        $homesections = PageSettings::where('company_id', '=', $companyid);

        $input['slider_status'] = 1;
        $input['category_status'] = 1;
        $input['sbanner_status'] = 1;
        $input['latestpro_status'] = 1;
        $input['featuredpro_status'] = 1;
        $input['lbanner_status'] = 1;
        $input['popularpro_status'] = 1;
        $input['blogs_status'] = 1;
        $input['testimonial_status'] = 1;
        $input['brands_status'] = 1;
        $input['subscribe_status'] = 1;

        if ($request->slider_status != 1){
            $input['slider_status'] = 0;
        }
        if ($request->category_status != 1){
            $input['category_status'] = 0;
        }
        if ($request->sbanner_status != 1){
            $input['sbanner_status'] = 0;
        }
        if ($request->latestpro_status != 1){
            $input['latestpro_status'] = 0;
        }
        if ($request->featuredpro_status != 1){
            $input['featuredpro_status'] = 0;
        }
        if ($request->lbanner_status != 1){
            $input['lbanner_status'] = 0;
        }
        if ($request->popularpro_status != 1){
            $input['popularpro_status'] = 0;
        }
        if ($request->blogs_status != 1){
            $input['blogs_status'] = 0;
        }
        if ($request->testimonial_status != 1){
            $input['testimonial_status'] = 0;
        }
        if ($request->brands_status != 1){
            $input['brands_status'] = 0;
        }
        if ($request->subscribe_status != 1){
            $input['subscribe_status'] = 0;
        }

        $tags = str_replace(', ',',',$request->popular_tags);
        DB::table('settings')
            ->where('company_id',$companyid)
            ->update(['title' => $request->title,'currency_sign' => $request->currency_sign,'popular_tags' => $tags]);

        $homesections->update($input);

        $settingdeflang_exists = SettingsTranslations::where('langcode', '=', $request->default_langcode)->where('settingid', '=', $request->id)->first();

        if(count($settingdeflang_exists) > 0)
        {
            SettingsTranslations::where('langcode', '=', $request->default_langcode)->where('settingid', '=', $request->id)->update(['title' => $request->title, 'popular_tags' => $request->popular_tags, 'currency_sign' => $request->currency_sign]);
        }
        else
        {
            $pagetrans = new SettingsTranslations();
            $pagetrans['settingid'] = $request->id;
            $pagetrans['title'] = $request->title;
            $pagetrans['popular_tags'] = $request->popular_tags;
            $pagetrans['currency_sign'] = $request->currency_sign;
            $pagetrans['langcode'] = $request->default_langcode;
            $pagetrans['company_id'] = get_company_id();
            $pagetrans->save();
        }
        

        foreach($request->langcode as $data => $transdata)
        {
            $settinglang_exists = SettingsTranslations::where('langcode', '=', $transdata)->where('settingid', '=', $request->id)->first();
            
            if(count($settinglang_exists) > 0)
            {
                SettingsTranslations::where('langcode', '=', $transdata)->where('settingid', '=', $request->id)->update(['title' => $request->trans_title[$data], 'popular_tags' => $request->trans_popular_tags[$data], 'currency_sign' => $request->trans_currency_sign[$data]]);
            }
            else
            {
                $pagealltrans = new SettingsTranslations();
                $pagealltrans['settingid'] = $request->id;
                $pagealltrans['title'] = $request->trans_title[$data];
                $pagealltrans['popular_tags'] = $request->trans_popular_tags[$data];
                $pagealltrans['currency_sign'] = $request->trans_currency_sign[$data];
                $pagealltrans['langcode'] = $transdata;
                $pagealltrans['company_id'] = get_company_id();
                $pagealltrans->save();
            }
            
        }

        Session::flash('message', trans("app.WebsiteContentUpdatedMsg"));
        return redirect('admin/settings');
    }

    public function payment(Request $request)
    {
        $companyid = get_company_id();

        $paypal = 0;
        $stripe = 0;
        $mobile = 0;
        $bank = 0;
        $cash = 0;
        if ($request->paypal_status == 1){
            $paypal = 1;
        }
        if ($request->stripe_status == 1){
            $stripe = 1;
        }
        if ($request->mobile_status == 1){
            $mobile = 1;
        }
        if ($request->bank_status == 1){
            $bank = 1;
        }
        if ($request->cash_status == 1){
            $cash = 1;
        }
        
        DB::table('settings')
            ->where('company_id', $companyid)
            ->update([
                'paypal_business' => $request->paypal,
                'stripe_key' => $request->stripe_key,
                'stripe_secret' => $request->stripe_secret,
                'tax_information' => $request->tax_information,
                'tax' => $request->tax,
                'mobile_money' => $request->mobile_money,
                'bank_wire' => $request->bank_wire,
                'shipping_information' => $request->shipping_information,
                'shipping_cost' => $request->shipping_cost,
                'paypal_status' => $paypal,
                'stripe_status' => $stripe,
                'mobile_status' => $mobile,
                'bank_status' => $bank,
                'cash_status' => $cash
            ]);

        Session::flash('message', trans("app.PaymentInfoUpdatedMsg"));
        return redirect('admin/settings');
    }

    //Payment Old
    public function payment_old(Request $request)
    {
        $companyid = get_company_id();

        DB::table('settings')
            ->where('company_id', $companyid)
            ->update(['paypal_business' => $request->paypal,'stripe_key' => $request->stripe_key,'stripe_secret' => $request->stripe_secret,'withdraw_fee' => $request->withdraw_fee,'withdraw_charge' => $request->withdraw_charge]);

        Session::flash('message', trans("app.PaymentInfoUpdatedMsg"));
        return redirect('admin/settings');
    }

    public function about(Request $request)
    {
        //dd($request->all());
        $companyid = get_company_id();

        DB::table('settings')
            ->where('company_id', $companyid)
            ->update(['about' => $request->about]);

        $pagedeflang_exists = SettingsTranslations::where('langcode', '=', $request->default_langcode)->where('settingid', '=', $request->id)->first();

        if(count($pagedeflang_exists) > 0)
        {
            SettingsTranslations::where('langcode', '=', $request->default_langcode)->where('settingid', '=', $request->id)->update(['about' => $request->about]);
        }
        else
        {
            $pagetrans = new SettingsTranslations();
            $pagetrans['settingid'] = $request->id;
            $pagetrans['about'] = $request->about;
            $pagetrans['langcode'] = $request->default_langcode;
            $pagetrans['company_id'] = get_company_id();
            $pagetrans->save();
        }
        

        foreach($request->langcode as $data => $transdata)
        {
            $pagelang_exists = SettingsTranslations::where('langcode', '=', $transdata)->where('settingid', '=', $request->id)->first();
            
            if(count($pagelang_exists) > 0)
            {

                SettingsTranslations::where('langcode', '=', $transdata)->where('settingid', '=', $request->id)->update(['about' => $request->trans_about[$data]]);
            }
            else
            {
                $pagealltrans = new SettingsTranslations();
                $pagealltrans['settingid'] = $request->id;
                $pagealltrans['about'] = $request->trans_about[$data];
                $pagealltrans['langcode'] = $transdata;
                $pagealltrans['company_id'] = get_company_id();
                $pagealltrans->save();
            }
            
        }

        Session::flash('message', trans("app.AboutUsTextUpdatedMsg"));
        return redirect('admin/settings');
    }

    public function address(Request $request)
    {
        $companyid = get_company_id();

        DB::table('settings')
            ->where('company_id', $companyid)
            ->update(['address' => $request->address,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'email' => $request->email]);

        $pagedeflang_exists = SettingsTranslations::where('langcode', '=', $request->default_langcode)->where('settingid', '=', $request->id)->first();

        if(count($pagedeflang_exists) > 0)
        {
            SettingsTranslations::where('langcode', '=', $request->default_langcode)->where('settingid', '=', $request->id)->update(['address' => $request->address]);
        }
        else
        {
            $pagetrans = new SettingsTranslations();
            $pagetrans['settingid'] = $request->id;
            $pagetrans['address'] = $request->address;
            $pagetrans['langcode'] = $request->default_langcode;
            $pagetrans['company_id'] = get_company_id();
            $pagetrans->save();
        }
        

        foreach($request->langcode as $data => $transdata)
        {
            $pagelang_exists = SettingsTranslations::where('langcode', '=', $transdata)->where('settingid', '=', $request->id)->first();
            
            if(count($pagelang_exists) > 0)
            {

                SettingsTranslations::where('langcode', '=', $transdata)->where('settingid', '=', $request->id)->update(['address' => $request->trans_address[$data]]);
            }
            else
            {
                $pagealltrans = new SettingsTranslations();
                $pagealltrans['settingid'] = $request->id;
                $pagealltrans['address'] = $request->trans_address[$data];
                $pagealltrans['langcode'] = $transdata;
                $pagealltrans['company_id'] = get_company_id();
                $pagealltrans->save();
            }
            
        }

        Session::flash('message', trans("app.AddressUpdatedMsg"));
        return redirect('admin/settings');
    }

    public function footer(Request $request)
    {
        // dd($request->id);
        $companyid = get_company_id();

        DB::table('settings')
            ->where('company_id', $companyid)
            ->update(['footer' => $request->footer]);

        $pagedeflang_exists = SettingsTranslations::where('langcode', '=', $request->default_langcode)->where('settingid', '=', $request->id)->first();

        if(count($pagedeflang_exists) > 0)
        {
            SettingsTranslations::where('langcode', '=', $request->default_langcode)->where('settingid', '=', $request->id)->update(['footer' => $request->footer]);
        }
        else
        {
            $pagetrans = new SettingsTranslations();
            $pagetrans['settingid'] = $request->id;
            $pagetrans['footer'] = $request->footer;
            $pagetrans['langcode'] = $request->default_langcode;
            $pagetrans['company_id'] = get_company_id();
            $pagetrans->save();
        }
        

        foreach($request->langcode as $data => $transdata)
        {
            $pagelang_exists = SettingsTranslations::where('langcode', '=', $transdata)->where('settingid', '=', $request->id)->first();
            
            if(count($pagelang_exists) > 0)
            {

                SettingsTranslations::where('langcode', '=', $transdata)->where('settingid', '=', $request->id)->update(['footer' => $request->trans_footer[$data]]);
            }
            else
            {
                $pagealltrans = new SettingsTranslations();
                $pagealltrans['settingid'] = $request->id;
                $pagealltrans['footer'] = $request->trans_footer[$data];
                $pagealltrans['langcode'] = $transdata;
                $pagealltrans['company_id'] = get_company_id();
                $pagealltrans->save();
            }
            
        }

        Session::flash('message', trans("app.FooterUpdatedMsg"));
        return redirect('admin/settings');
    }

    public function logo(Request $request)
    {
        $companyid = get_company_id();

        $logo = $request->file('logo');
        $name = Str::random(3).$logo->getClientOriginalName();
        $logo->move('assets/images/company',$name);

        DB::table('settings')
            ->where('company_id', $companyid)
            ->update(['logo' => $name]);

        DB::table('company')
            ->where('id', $companyid)
            ->update(['company_logo' => $name]);

        Session::flash('message', trans("app.WebsiteLogoUpdatedMsg"));
        return redirect('admin/settings');
    }

    public function favicon(Request $request)
    {
        $companyid = get_company_id();

        $logo = $request->file('favicon');
        $name = $logo->getClientOriginalName();
        $logo->move('assets/images/',$name);

        DB::table('settings')
            ->where('company_id', $companyid)
            ->update(['favicon' => $name]);

        Session::flash('message', trans("app.WebsiteFaviconUpdatedMsg"));
        return redirect('admin/settings');
    }

    public function background(Request $request)
    {
        $companyid = get_company_id();

        $logo = $request->file('background');
        $name = $logo->getClientOriginalName();
        $logo->move('assets/images',$name);

        DB::table('settings')
            ->where('company_id', $companyid)
            ->update(['background' => $name]);

        Session::flash('message', trans("app.BackgroundImageUpdatedMsg"));
        return redirect('admin/settings');
    }

    public function setlanguage()
    {
        $companyid = get_company_id();
        $languages = SiteLanguage::where('company_id', '=', $companyid)->get();
        return view('admin.language',compact('languages'));
    }

    public function language(Request $request)
    {
        $companyid = get_company_id();
        $language = SiteLanguage::where('company_id', '=', $companyid);
        $data = $request->except(['_token']);
        $language->update($data);
        return redirect('admin/language-settings')->with('message', trans("app.WebsiteLanguageUpdatedMsg"));
    }

    public function pickup(Request $request)
    {
        $pickl = new PickUpLocations();
        $pickl->address = $request->address;

        $pickl['company_id'] = get_company_id();

        $pickl->save();

        $pickupdeflang_exists = PickUpLocationTranslations::where('langcode', '=', $request->default_langcode)->where('plocationgid', '=', $pickl->id)->first();

        if(count($pickupdeflang_exists) > 0)
        {
            PickUpLocationTranslations::where('langcode', '=', $request->default_langcode)->where('plocationgid', '=', $pickl->id)->update(['address' => $request->address]);
        }
        else
        {
            $pickuptrans = new PickUpLocationTranslations();
            $pickuptrans['plocationgid'] = $pickl->id;
            $pickuptrans['address'] = $request->address;
            $pickuptrans['langcode'] = $request->default_langcode;
            $pickuptrans['company_id'] = get_company_id();
            $pickuptrans->save();
        }
        

        foreach($request->langcode as $data => $transdata)
        {
            $pickuplang_exists = PickUpLocationTranslations::where('langcode', '=', $transdata)->where('plocationgid', '=', $pickl->id)->first();
            
            if(count($pickuplang_exists) > 0)
            {

                PickUpLocationTranslations::where('langcode', '=', $transdata)->where('plocationgid', '=', $pickl->id)->update(['address' => $request->trans_address[$data]]);
            }
            else
            {
                $pickupalltrans = new PickUpLocationTranslations();
                $pickupalltrans['plocationgid'] = $pickl->id;
                $pickupalltrans['address'] = $request->trans_address[$data];
                $pickupalltrans['langcode'] = $transdata;
                $pickupalltrans['company_id'] = get_company_id();
                $pickupalltrans->save();
            }
            
        }

        return redirect('admin/settings')->with('message', trans("app.NewPickupLocationAddedMsg"));
    }

    public function pickupstatus($subdomain,$id , $status)
    {
        $pickup = PickUpLocations::findOrFail($id);
        $input['status'] = $status;
        
        $pickup->update($input);

        return redirect('admin/settings')->with('message', trans("app.PickupLocationUpdatedMsg"));
    }
    
    public function pickdel($subdomain,$id)
    {
        $pickl = PickUpLocations::findOrFail($id);
        $pickl->delete();

        $pickltrans = PickUpLocationTranslations::where('plocationgid', $id);
        $pickltrans->delete();

        return redirect('admin/settings')->with('message', trans("app.PickupLocationDeletedMsg"));
    }

    public function selectlanguage(Request $request)
    {
        $companyid = get_company_id();
        if(in_array($request->default_language,$request->language))
        {
            $default_language = $request->default_language;
        }
        else
        {
            $default_language = $request->language[0];
        }
        
        DB::table('company')
            ->where('id', $companyid)
            ->update(array('language'=>implode(',', $request->language),'default_language'=>$default_language));

        Session::flash('message', trans("app.LanguageSettingUpdatedMsg"));
        return redirect('admin/settings');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain,$id)
    {
        //
        //return $request->all();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        //
    }

}
