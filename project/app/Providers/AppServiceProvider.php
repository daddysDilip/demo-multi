<?php

namespace App\Providers;

use App\Advertisement;
use App\SiteLanguage;
use App\Cart;
use App\Cms;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Auth;
use App\Language;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		
        view()->composer('*',function($settings){

            $companyid = get_company_id();

            if($companyid == null)
            {
                $companyid = 0;
            }
            else
            {
                $companyid = $companyid;
            }


			if($user = Auth::user())
			{
                $roleid = $user->role;
				$logincom=$user->company_id;
			}
			else
            {
                $roleid ='0';
                $logincom ='';
			}
			$user = Auth::user();
			$menudata ='';
			$storemenudata ='';
			
			if($logincom == 0){
          
			$menudata = DB::table('menus')
            ->join('permissions', 'menus.id', '=', 'permissions.menuid')
            ->where('permissions.roleid', $roleid)
			->where('permissions.company_id', $companyid)
			->where('menus.status', 1)
            ->orderBy('menus.menuorder', 'asc')
            ->select('menus.*')
            ->get();
			
			$userrole = DB::select('select * from admin where company_id =?',[$companyid]);
			//echo $userrole[0]->role;
			$storemenudata = DB::table('menus')
            ->join('permissions', 'menus.id', '=', 'permissions.menuid')
            ->where('permissions.roleid', $userrole[0]->role)
			->where('permissions.company_id', $companyid)
			->where('menus.status', 1)
            ->orderBy('menus.menuorder', 'asc')
            ->select('menus.*')
            ->get();
			
			
			}else{
				
			$storemenudata = DB::table('menus')
            ->join('permissions', 'menus.id', '=', 'permissions.menuid')
            ->where('permissions.roleid', $roleid)
			->where('permissions.company_id', $companyid)
			->where('menus.status', 1)
            ->orderBy('menus.menuorder', 'asc')
            ->select('menus.*')
            ->get();	
				
			}
            
            $url = '/'.collect(request()->segments())->last();

            $settings->with('subdomain_name',get_subdomain());    
            $settings->with('navigation', DB::select('select * from navigation where parent_id=? and company_id=?',[0,$companyid]));
            $settings->with('companydetails',DB::select('select * from company where id=?',[$companyid]));          
		    $settings->with('userdata',DB::select('select * from admin where company_id=?',[$companyid]));   			
            $settings->with('settings', DB::select('select * from settings where company_id=?',[$companyid]));
            // $settings->with('language', SiteLanguage::findOrFail(1));
            $settings->with('language', SiteLanguage::where('company_id', $companyid)->first());
            $settings->with('pagesettings', DB::select('select * from page_settings where company_id=?',[$companyid]));
            $settings->with('sociallinks', DB::select('select * from social_links where company_id=?',[$companyid]));
            $settings->with('lblogs', DB::select('select * from blogs  where status=? and company_id=? order by `id` desc LIMIT 4',[1,$companyid]));
            $settings->with('sliders', DB::select('select * from sliders where status=? and company_id=?',[1,$companyid]));
            $settings->with('menus', DB::select('select * from categories where role=:role and status=:status and company_id=:company_id',['role'=>'main','status'=>1,'company_id'=> $companyid]));
            $settings->with('adminmenus', $menudata);
            $settings->with('storemenus', $storemenudata);
            $settings->with('code', DB::select('select * from code_scripts where company_id=?',[$companyid]));
            $settings->with('ads728x90', Advertisement::inRandomOrder()
                ->where('banner_size','728x90')->where('company_id',$companyid)->where('status',1)->first());
            $settings->with('ads300x250', Advertisement::inRandomOrder()
                ->where('banner_size','300x250')->where('company_id',$companyid)->where('status',1)->get());
            $settings->with('cartvalue', Cart::where('uniqueid', Session::get('uniqueid'))->get());
            $settings->with('cmsmenu', Cms::where('company_id',$companyid)->where('status',1)->get());
            $settings->with('pagetitle', DB::select('select * from navigation where url=? and company_id=?',[$url,$companyid]));
            $settings->with('alllanguage', Language::all());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
