<?php

namespace App\Providers;

use App\Advertisement;
use App\SiteLanguage;
use App\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Auth;

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
			if($user = Auth::user())
			{
                $roleid = $user->role;
				$company_id = $user->company_id;
			}
			else
            {
                $roleid = '0';
				$company_id = '0';	
			}
		    $menudata = DB::table('menus')
            ->join('permissions', 'menus.id', '=', 'permissions.menuid')
			->where('permissions.roleid', $roleid)
            ->select('menus.*')
            ->get();

		    $settings->with('userdata',DB::select('select * from admin where company_id=?',[$company_id]));   			
            $settings->with('settings', DB::select('select * from settings where company_id=?',[1]));
            $settings->with('language', SiteLanguage::findOrFail(1));
            $settings->with('pagesettings', DB::select('select * from page_settings where id=?',[1]));
            $settings->with('sociallinks', DB::select('select * from social_links where id=?',[1]));
            $settings->with('lblogs', DB::select('select * from blogs order by `id` desc LIMIT 4'));
            $settings->with('sliders', DB::select('select * from sliders'));
            $settings->with('menus', DB::select('select * from categories where role=?',['main']));
            $settings->with('adminmenus', $menudata);
            $settings->with('code', DB::select('select * from code_scripts'));
            $settings->with('ads728x90', Advertisement::inRandomOrder()
                ->where('banner_size','728x90')->where('status',1)->first());
            $settings->with('ads300x250', Advertisement::inRandomOrder()
                ->where('banner_size','300x250')->where('status',1)->get());

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
