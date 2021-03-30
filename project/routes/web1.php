<?php

use App\UsersModel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Match my own domain

Auth::routes();

Route::group(['domain' => 'multiecom.com'], function()
{
    Route::get('admin/login', function () {
        return redirect('sadmin/login');
    });

    Route::any('/', 'Sadmin\FrontEndController@index');
    Route::get('/store/signup', 'Sadmin\FrontEndController@create_store');
    Route::post('/store/get_plan', 'Sadmin\FrontEndController@get_plan');
    Route::post('/store/register', 'Sadmin\FrontEndController@add_store');
    Route::post('/store/existstorename', 'Sadmin\FrontEndController@existstorename');
    Route::post('/store/checkdomainname', 'Sadmin\FrontEndController@checkdomainname');
    Route::post('/store/existemail','Sadmin\FrontEndController@existemail');
    Route::post('/store/state_list','Sadmin\FrontEndController@state_list');
    Route::post('/store/city_list','Sadmin\FrontEndController@city_list');
    Route::get('/contactus','Sadmin\FrontEndController@contact');
    Route::post('/contactus/email', 'Sadmin\FrontEndController@contactmail');
    Route::get('/blogs', 'Sadmin\FrontEndController@allblog');
    Route::get('/blog/{id}', 'Sadmin\FrontEndController@blogdetails');
    Route::post('/blogs/blogemail', 'Sadmin\FrontEndController@blogcontactus');

    Route::resource('/sadmin/company', 'Sadmin\CompanyController');
    Route::get('/sadmin/company/status/{id}/{status}','Sadmin\CompanyController@status');
    Route::get('/sadmin/company/delete/{id}','Sadmin\CompanyController@destroy');
    Route::post('/sadmin/company/state_list','Sadmin\CompanyController@state_list');
    Route::post('/sadmin/company/city_list','Sadmin\CompanyController@city_list');
    Route::post('/sadmin/company/existusernametitle','Sadmin\CompanyController@existusernametitle');
    Route::post('/sadmin/company/checkdomainname','Sadmin\CompanyController@checkdomainname');
    Route::post('/sadmin/company/existemail','Sadmin\CompanyController@existemail');
    Route::post('/sadmin/company/ajaxrequest','Sadmin\CompanyController@ajaxrequest');
    Route::get('/sadmin/company/viewprint/{id}','Sadmin\CompanyController@viewprint');

    Route::get('/sadmin', 'Auth\SadminLoginController@SadminLoginForm');
    Route::get('/sadmin/login', 'Auth\SadminLoginController@SadminLoginForm');
    Route::post('/sadmin/login', 'Auth\SadminLoginController@sadminlogin');
    Route::get('/sadmin/logout', 'Auth\SadminLoginController@logout');

    Route::get('/sadmin/dashboard', 'Sadmin\HomeController@index');
    Route::get('/sadmin/monthlygraph', 'Sadmin\HomeController@monthlygraph');
    Route::get('/sadmin/yearlygraph', 'Sadmin\HomeController@yearlygraph');

    Route::resource('/sadmin/menus', 'Sadmin\MenusController');
    Route::get('/sadmin/menus/status/{id}/{status}','Sadmin\MenusController@status');
    Route::get('/sadmin/menus/delete/{id}','Sadmin\MenusController@destroy');

    Route::resource('/sadmin/roles', 'Sadmin\RolesController');
    Route::get('/sadmin/roles/status/{id}/{status}','Sadmin\RolesController@status');
    Route::get('/sadmin/roles/delete/{id}','Sadmin\RolesController@destroy');
    Route::post('/sadmin/existrole','Sadmin\RolesController@exist_role');

    Route::resource('/sadmin/user', 'Sadmin\UserController');
    Route::get('/sadmin/user/status/{id}/{status}','Sadmin\UserController@status');
    Route::get('/sadmin/user/delete/{id}','Sadmin\UserController@destroy');
    Route::post('/sadmin/existuseremail','Sadmin\UserController@exist_email');

    Route::post('/sadmin/cms/titles', 'Sadmin\CmsController@titles');
    Route::resource('/sadmin/cms', 'Sadmin\CmsController');
    Route::get('/sadmin/cms/status/{id}/{status}','Sadmin\CmsController@status');
    Route::get('/sadmin/cms/delete/{id}','Sadmin\CmsController@destroy');
    Route::post('/sadmin/existcmstitle','Sadmin\CmsController@exist_titles');
    
    Route::post('/sadmin/news/titles', 'Sadmin\NewsController@titles');
    Route::resource('/sadmin/news', 'Sadmin\NewsController');
    Route::get('/sadmin/news/status/{id}/{status}','Sadmin\NewsController@status');
    Route::get('/sadmin/news/delete/{id}','Sadmin\NewsController@destroy');

    Route::resource('/sadmin/sliders', 'Sadmin\SliderController');
    Route::get('/sadmin/sliders/delete/{id}','Sadmin\SliderController@destroy');
    Route::get('/sadmin/sliders/status/{id}/{status}','Sadmin\SliderController@status');
    Route::get('/sadmin/delete/sliderimage/{id}','Sadmin\SliderController@deleteimage');

    Route::resource('/sadmin/emailcompose', 'Sadmin\EmailcomposeController');

    Route::resource('/sadmin/plans', 'Sadmin\PlanController');
    Route::get('/sadmin/plans/delete/{id}','Sadmin\PlanController@destroy');
    Route::get('/sadmin/plans/status/{id}/{status}','Sadmin\PlanController@status');
    Route::post('/sadmin/type_exists','Sadmin\PlanController@type_exists');

    Route::resource('/sadmin/themes', 'Sadmin\ThemeController');
    Route::get('/sadmin/themes/delete/{id}','Sadmin\ThemeController@destroy');
    Route::post('/sadmin/theme_exists','Sadmin\ThemeController@theme_exists');
    Route::post('/sadmin/themeurl_exists','Sadmin\ThemeController@themeurl_exists');
    Route::get('/sadmin/delete/themeimage/{id}','Sadmin\ThemeController@deleteimage');
    Route::get('/sadmin/delete/photo/{id}','Sadmin\UserController@deleteimage1');
    
    Route::resource('/sadmin/country', 'Sadmin\CountryController');
    Route::get('/sadmin/country/delete/{id}','Sadmin\CountryController@destroy');
    Route::get('/sadmin/country/status/{id}/{status}','Sadmin\CountryController@status');
    Route::post('/sadmin/country_exists','Sadmin\CountryController@country_exists');
    Route::post('/sadmin/sortname_exists','Sadmin\CountryController@sortname_exists');

    Route::resource('/sadmin/state', 'Sadmin\StateController');
    Route::get('/sadmin/state/statelist/{cid}', 'Sadmin\StateController@statebycid');
    Route::get('/sadmin/state/delete/{id}','Sadmin\StateController@destroy');
    Route::get('/sadmin/state/status/{id}/{status}','Sadmin\StateController@status');
    Route::post('/sadmin/state_exists','Sadmin\StateController@state_exists');

    Route::resource('/sadmin/city', 'Sadmin\CityController');
    Route::get('/sadmin/city/statelist/{cid}', 'Sadmin\CityController@statelist');
    Route::get('/sadmin/city/citylist/{cid}/{sid}', 'Sadmin\CityController@citybycsid');
    Route::get('/sadmin/city/delete/{id}','Sadmin\CityController@destroy');
    Route::get('/sadmin/city/status/{id}/{status}','Sadmin\CityController@status');
    Route::post('/sadmin/city_exists','Sadmin\CityController@city_exists');

    Route::resource('/sadmin/payment', 'Sadmin\PaymentMethodController');
    Route::get('/sadmin/payment/delete/{id}','Sadmin\PaymentMethodController@destroy');
    Route::get('/sadmin/payment/status/{id}/{status}','Sadmin\PaymentMethodController@status');
    Route::post('/sadmin/payment_exists','Sadmin\PaymentMethodController@payment_exists');
    Route::get('/sadmin/delete/paymentimage/{id}','Sadmin\PaymentMethodController@deleteimage');

    Route::resource('/sadmin/shipping', 'Sadmin\ShippingMethodController');
    Route::get('/sadmin/shipping/delete/{id}','Sadmin\ShippingMethodController@destroy');
    Route::get('/sadmin/shipping/status/{id}/{status}','Sadmin\ShippingMethodController@status');
    Route::post('/sadmin/existshipping','Sadmin\ShippingMethodController@shipping_exists');

    Route::resource('/sadmin/themebrought', 'Sadmin\BuyThemeController');
    Route::get('/sadmin/themebrought/view/{id}', 'Sadmin\BuyThemeController@show');
    Route::get('/sadmin/exportthemebuyer', 'Sadmin\BuyThemeController@Exportdata');

    Route::resource('/sadmin/upgradeplan', 'Sadmin\UpgradePlanController');
    Route::get('/sadmin/exportupgradeplan', 'Sadmin\UpgradePlanController@Exportdata');

    Route::resource('/sadmin/contactus', 'Sadmin\ContactusController');
    Route::get('/sadmin/exportcontactus', 'Sadmin\ContactusController@Exportdata');
    Route::get('/sadmin/contactus/status/{id}/{status}','Sadmin\ContactusController@status');

    Route::resource('/sadmin/tickets', 'Sadmin\TicketController');
    Route::get('/sadmin/tickets/changestatus/{id}/{tempcode}','Sadmin\TicketController@status');
    Route::post('/sadmin/addreply','Sadmin\TicketController@addreply');

    Route::resource('/sadmin/adminprofile', 'Sadmin\sAdminProfileController');
    Route::post('/sadmin/adminpassword/change/{id}', 'Sadmin\sAdminProfileController@changepass');
    Route::get('/sadmin/adminpassword', 'Sadmin\sAdminProfileController@password');
    Route::post('/sadmin/old_password','Sadmin\sAdminProfileController@old_password');

    Route::get('/sadmin/accessdenied','Sadmin\AccessdeniedController@index');

    Route::resource('/sadmin/language','Sadmin\LanguageController');
    Route::get('/sadmin/language/status/{id}/{status}','Sadmin\LanguageController@status');
    Route::get('/sadmin/language/delete/{id}','Sadmin\LanguageController@destroy');
    Route::post('/sadmin/language/languageimage/{id}','Sadmin\LanguageController@deleteimage');
    Route::post('/sadmin/existlanguname','Sadmin\LanguageController@exist_titles');
    Route::post('/sadmin/codelanguname','Sadmin\LanguageController@exist_code');

    //Route::post('/sadmin/blog/titles', 'BlogController@titles');
    Route::resource('/sadmin/blog', 'Sadmin\BlogController');
    Route::get('/sadmin/blog/delete/{id}','Sadmin\BlogController@destroy');
    Route::post('/sadmin/existblogtitle','Sadmin\BlogController@exist_titles');
    Route::get('/sadmin/blog/status/{id}/{status}','Sadmin\BlogController@status');
    Route::post('/sadmin/delete/blogimage/{id}','Sadmin\BlogController@deleteimage');

    Route::get('/{slug}', 'Sadmin\FrontEndController@cmsshow');

}); 

Route::group(['domain' => '{subdomain}.multiecom.com'], function()
{    
    Route::post('/language-chooser','LanguageController@changeLanguage');

    Route::post('/language', array(
            'before' => 'csrf',
            'as' => 'language-choose',
            'uses' => 'LanguageController@changeLanguage',
        )
    );   
    Route::group(['middleware' => ['activecompany']], function () {

    Route::get('/admin/accessdenied','AccessdeniedController@index');

    Route::get('/', 'FrontEndController@index');
    Route::get('/about', 'FrontEndController@about');
    Route::get('/faq', 'FrontEndController@faq');
    Route::get('/contact', 'FrontEndController@contact');
    Route::get('/listall', 'FrontEndController@all');
    Route::get('/listfeatured', 'FrontEndController@featured');
    Route::get('/services/{category}', 'FrontEndController@category');
    Route::get('/services/order/{id}', 'FrontEndController@order');

    Route::post('/profile/email', 'FrontEndController@usermail');
    Route::post('/contact/email', 'FrontEndController@contactmail');

    Route::get('/profile/{id}/{name}', 'FrontEndController@viewprofile');
    Route::get('product/{id}/{title}', 'FrontEndController@productdetails');
    Route::get('loadcategory/{slug}/{page}', 'FrontEndController@loadcatproduct');
    Route::get('/shop','FrontEndController@shop');
    Route::get('category/{slug}', 'FrontEndController@catproduct');
    Route::get('tags/{tag}', 'FrontEndController@tagproduct');
    Route::get('/blogs', 'FrontEndController@allblog');
    Route::get('/blog/{id}', 'FrontEndController@blogdetails');
   
    Route::get('search/{search}', 'FrontEndController@searchproduct');

    Route::get('quick-view/{id}', 'FrontEndController@getProduct');

    Route::post('user/review', 'FrontEndController@reviewsubmit')->name('review.submit');
    
    Route::get('/customerdetail', 'UserProfileController@customerdetail');

    Route::get('user/dashboard', 'UserProfileController@index')->name('user.account');
    Route::get('user/account-information', 'UserProfileController@accinfo')->name('user.accinfo');
    Route::get('user/account-password', 'UserProfileController@userchangepass')->name('user.accpass');
    Route::get('user/orders', 'UserProfileController@userorders')->name('user.orders');
    Route::get('user/order/{id}', 'UserProfileController@userorderdetails');
    Route::post('user/update/{id}', 'UserProfileController@update')->name('user.update');
    Route::post('user/passchange/{id}', 'UserProfileController@passchange')->name('user.passchange');
    Route::post('user/old_password','UserProfileController@old_password');
    Route::get('user/orderpdf/{id}', 'UserProfileController@orderdetailspdf');

    Route::get('/cart', 'FrontEndController@cart')->name('user.cart');

    Route::get('/cartdelete/{id}', 'FrontEndController@cartdelete');
    Route::get('/cartupdate', 'FrontEndController@cartupdate');
    Route::post('/cartupdate', 'FrontEndController@cartupdate');
    Route::post('/checkout/vouchercode', 'FrontEndController@vouchercode');

    Route::get('setcookie', function(){
        Session::setId($_GET['id']);
        Session::start();
    });

    Route::get('admin/themecolor', function () {
        return view('admin.themecolor');
    });

    Route::get('/admin/navigation', 'NavigationController@getIndex');
    Route::post('/admin/navigation', 'NavigationController@postIndex');

    Route::post('/admin/navigation/new', 'NavigationController@postNew');
    Route::post('/admin/navigation/delete', 'NavigationController@postDelete');

    Route::get('/admin/navigation/edit/{id}', 'NavigationController@getEdit');
    Route::post('/admin/navigation/edit/{id}', 'NavigationController@postEdit');

    Route::get('/admin', 'Auth\LoginController@showLoginForm');
    Route::get('/admin/login', 'Auth\LoginController@showLoginForm');
    Route::post('/admin/login', 'Auth\AdminLoginController@adminlogin');
    Route::get('/admin/logout', 'Auth\AdminLoginController@logout');

    Route::get('/admin/forgotpassword', 'Auth\ProfileResetPassController@showAdminForgotForm')->name('admin.forgotpass');
    Route::post('/admin/forgotpassword/submit', 'Auth\ProfileResetPassController@resetAdminPass')->name('admin.forgotpass.submit');
    Route::get('/admin/resetpassword/{code}', 'Auth\ProfileResetPassController@resetadminForm');
    Route::post('/admin/resetpassword', 'Auth\ProfileResetPassController@adminnewpassword');

    Route::get('/admin/monthlygraph', 'HomeController@monthlygraph');
    Route::get('/admin/yearlygraph', 'HomeController@yearlygraph');

    Route::get('/admin/dashboard', 'HomeController@index');
    Route::post('/admin/updatecolor', 'SettingsController@themecolor');

    Route::post('admin/settings/title', 'SettingsController@title');
    Route::post('admin/settings/payment', 'SettingsController@payment');
    Route::post('admin/settings/about', 'SettingsController@about');
    Route::post('admin/settings/address', 'SettingsController@address');
    Route::post('admin/settings/footer', 'SettingsController@footer');
    Route::post('admin/settings/logo', 'SettingsController@logo');
    Route::post('admin/settings/favicon', 'SettingsController@favicon');
    Route::post('admin/settings/pickup', 'SettingsController@pickup');
    Route::post('admin/settings/selectlanguage', 'SettingsController@selectlanguage');
    Route::get('admin/settings/pickup-del/{id}', 'SettingsController@pickdel');
    Route::post('admin/settings/background', 'SettingsController@background');
    Route::get('admin/language-settings', 'SettingsController@setlanguage');
    Route::post('admin/settings/language', 'SettingsController@language');
    Route::resource('/admin/settings', 'SettingsController');
    Route::get('admin/pickupstatus/status/{id}/{status}', 'SettingsController@pickupstatus');

    Route::resource('/admin/sliders', 'SliderController');
    Route::get('/admin/sliders/delete/{id}','SliderController@destroy');
    Route::get('/admin/sliders/status/{id}/{status}','SliderController@status');
    Route::get('/admin/exportsliders','SliderController@Exportdata');
    Route::post('/admin/importslider','SliderController@import')->name('importslider');

    Route::get('/admin/customers/email/{id}', 'CustomerController@email');
    Route::post('/admin/customers/emailsend', 'CustomerController@sendemail');
    Route::resource('/admin/customers', 'CustomerController');
    Route::get('/admin/customers/status/{id}/{status}','CustomerController@status');
    Route::get('/admin/customers/delete/{id}','CustomerController@destroy');
    Route::get('/admin/exportcustomer', 'CustomerController@Exportdata');

    Route::post('/admin/blog/titles', 'BlogController@titles');
    Route::resource('/admin/blog', 'BlogController');
    Route::get('/admin/blog/delete/{id}','BlogController@destroy');
    Route::post('/admin/existblogtitle','BlogController@exist_titles');
    Route::get('/admin/blog/status/{id}/{status}','BlogController@status');
    Route::get('/admin/exportblog','BlogController@Exportdata');
    Route::post('/admin/importblog','BlogController@import')->name('importblog');

    Route::post('/admin/news/titles', 'NewsController@titles');
    Route::resource('/admin/news', 'NewsController');
    Route::get('/admin/news/status/{id}/{status}','NewsController@status');
    Route::get('/admin/news/delete/{id}','NewsController@destroy');
    Route::get('/admin/exportnews','NewsController@Exportdata');
    Route::post('/admin/importnews','NewsController@import')->name('importnews');

    Route::post('/admin/event/titles', 'EventController@titles');
    Route::resource('/admin/event', 'EventController');
    Route::get('/admin/event/status/{id}/{status}','EventController@status');
    Route::get('/admin/event/delete/{id}','EventController@destroy');
    Route::get('/admin/exportevent','EventController@Exportdata');
    Route::post('/admin/importevent','EventController@import')->name('importevent');

    Route::post('/admin/cms/titles', 'CmsController@titles');
    Route::resource('/admin/cms', 'CmsController');
    Route::get('/admin/cms/status/{id}/{status}','CmsController@status');
    Route::get('/admin/cms/delete/{id}','CmsController@destroy');
    Route::post('/admin/existcmstitle','CmsController@exist_titles');
    Route::get('/admin/exportcms','CmsController@Exportdata');
    Route::post('/admin/importcms','CmsController@import')->name('importcms');


    Route::resource('/admin/menus', 'MenusController');
    Route::get('/admin/menus/status/{id}/{status}','MenusController@status');
    Route::get('/admin/menus/delete/{id}','MenusController@destroy');

    Route::resource('/admin/user', 'UserController');
    Route::get('/admin/user/status/{id}/{status}','UserController@status');
    Route::get('/admin/user/delete/{id}','UserController@destroy');
    Route::post('/admin/existuseremail','UserController@exist_email');
    Route::get('/admin/delete/userprofile/{id}','UserController@deleteimage');

    Route::resource('/admin/roles', 'RolesController');
    Route::get('/admin/roles/status/{id}/{status}','RolesController@status');
    Route::get('/admin/roles/delete/{id}','RolesController@destroy');
    Route::post('/admin/existrole','RolesController@exist_role');

    Route::post('/admin/emailtemplates/titles', 'EmailtemplatesController@titles');
    Route::resource('/admin/emailtemplates', 'EmailtemplatesController');
    Route::get('/admin/emailtemplates/status/{id}/{status}','EmailtemplatesController@status');
    Route::get('/admin/emailtemplates/delete/{id}','EmailtemplatesController@destroy');

    Route::resource('/admin/contactus', 'ContactusController');
    Route::get('/admin/contactus/status/{id}/{status}','ContactusController@status');
    Route::get('/admin/exportcontactus', 'ContactusController@Exportdata');

    Route::resource('/admin/review', 'ReviewController');
    Route::get('/admin/review/status/{id}/{status}','ReviewController@status');

    Route::resource('/admin/tickets', 'TicketController');
    Route::post('/admin/addreply','TicketController@addreply');

    Route::resource('/admin/discount', 'DiscountController');
    Route::get('/admin/discount/status/{id}/{status}','DiscountController@status');
    Route::get('/admin/discount/delete/{id}','DiscountController@destroy');
    Route::post('/admin/exist_discode','DiscountController@exist_discode');

    Route::post('/admin/testimonial/titles', 'TestimonialController@titles');
    Route::resource('/admin/testimonial', 'TestimonialController');
    Route::get('/admin/testimonial/delete/{id}','TestimonialController@destroy');
    Route::get('/admin/testimonial/status/{id}/{status}','TestimonialController@status');
     Route::get('/admin/exporttestimonial','TestimonialController@Exportdata');
    Route::post('/admin/importtestimonial','TestimonialController@import')->name('importtestimonial');

    Route::resource('/admin/services', 'ServiceController');
    
    Route::get('/admin/categories/delete/{id}', 'CategoryController@destroy');
    Route::resource('/admin/categories', 'CategoryController');
    Route::post('/admin/exist_category','CategoryController@exist_category');
    Route::post('/admin/exist_slug','CategoryController@exist_slug');
    Route::get('/admin/categories/status/{id}/{status}','CategoryController@status');
    Route::get('/admin/exportcategories','CategoryController@Exportdata');
    Route::post('/admin/storemain','CategoryController@storemain');

    Route::get('/subcats/{id}', 'SubCategoryController@subcats');
    Route::get('/childcats/{id}', 'ChildCategoryController@childcats');
    Route::get('/admin/subcategory/delete/{id}', 'SubCategoryController@destroy');

    Route::resource('/admin/subcategory', 'SubCategoryController');
    Route::resource('/admin/childcategory', 'ChildCategoryController');
    Route::get('/admin/childcategory/delete/{id}', 'ChildCategoryController@destroy');

    Route::resource('/admin/emailcompose', 'EmailcomposeController');

    Route::get('admin/brand/add', 'PageSettingsController@addbrand');
    Route::get('admin/brand/{id}/delete', 'PageSettingsController@branddelete');
    Route::get('admin/brand/{id}/edit', 'PageSettingsController@brandedit');
    Route::post('admin/brand/{id}/update', 'PageSettingsController@brandupdate');
    Route::post('admin/brand/brandsave', 'PageSettingsController@brandsave');
    Route::post('/admin/exist_faq', 'PageSettingsController@exist_faq');

    Route::get('admin/banner/add', 'PageSettingsController@addbanner');
    Route::get('admin/banner/{id}/delete', 'PageSettingsController@bannerdelete');
    Route::get('admin/banner/{id}/edit', 'PageSettingsController@banneredit');
    Route::post('admin/banner/{id}/update', 'PageSettingsController@bannerupdate');
    Route::post('admin/banner/save', 'PageSettingsController@bannersave');

    Route::get('admin/faq/add', 'PageSettingsController@addfaq');
    Route::get('admin/faq/{id}/delete', 'PageSettingsController@faqdelete');
    Route::get('admin/faq/{id}/edit', 'PageSettingsController@faqedit');
    Route::post('admin/faq/{id}/update', 'PageSettingsController@faqupdate');
    Route::post('admin/pagesettings/faqsave', 'PageSettingsController@faqsave');
    Route::post('admin/banner/large', 'PageSettingsController@largebanner');

    Route::post('admin/pagesettings/about', 'PageSettingsController@about');
    Route::post('admin/pagesettings/faq', 'PageSettingsController@faq');
    Route::post('admin/pagesettings/contact', 'PageSettingsController@contact');
    Route::resource('/admin/pagesettings', 'PageSettingsController');
    Route::get('admin/pagesettings/status/{id}/{status}', 'PageSettingsController@status');
    Route::get('admin/brandstatus/status/{id}/{status}', 'PageSettingsController@brandstatus');
    Route::get('admin/bannerstatus/status/{id}/{status}', 'PageSettingsController@bannerstatus');

    Route::get('admin/products/pending', 'ProductController@pending');
    Route::get('admin/products/pending/{id}', 'ProductController@pendingdetails');
    Route::get('admin/products/status/{id}/{status}', 'ProductController@status');
    Route::get('/admin/products/delete/{id}','ProductController@destroy');
    Route::resource('/admin/products', 'ProductController');
    Route::post('/admin/exist_skucode','ProductController@exist_skucode');
    Route::post('/admin/delete/productimage','ProductController@deleteimage');
    Route::get('/admin/exportprodect', 'ProductController@Exportdata');

    Route::get('admin/ads/status/{id}/{status}', 'AdvertiseController@status');

    Route::resource('/admin/ads', 'AdvertiseController');
    Route::resource('/admin/social', 'SocialLinkController');
    Route::resource('/admin/tools', 'SeoToolsController');
    Route::get('admin/subscribers/download', 'SubscriberController@download');

    Route::resource('/admin/subscribers', 'SubscriberController');
    Route::post('/admin/adminpassword/change/{id}', 'AdminProfileController@changepass');
    Route::get('/admin/adminpassword', 'AdminProfileController@password');
    Route::resource('/admin/adminprofile', 'AdminProfileController');
    Route::post('/admin/old_password','AdminProfileController@old_password');

    Route::get('/admin/withdraws/pending', 'WithdrawController@pendings');
    Route::get('/admin/withdraws/accept/{id}', 'WithdrawController@accept');
    Route::get('/admin/withdraws/reject/{id}', 'WithdrawController@reject');
    Route::resource('/admin/withdraws', 'WithdrawController');

    Route::get('/admin/orders/status/{id}/{status}', 'OrderController@status');
    Route::get('/admin/orders/{id}', 'OrderController@show');
    Route::get('/admin/orders/email/{id}', 'OrderController@email');
    Route::post('/admin/orders/emailsend', 'OrderController@sendemail');
    Route::get('/admin/orderpdf/{id}', 'OrderController@orderdetailspdf');
    Route::get('/admin/exportorder', 'OrderController@Exportdata');
    Route::resource('/admin/orders', 'OrderController');

    Route::post('/admin/qucikmail', 'HomeController@qucikmail');

    Route::resource('/admin/themesettings', 'ThemeController');
    Route::get('/admin/themesettings/delete/{id}','ThemeController@destroy');
    Route::get('/admin/themesettings/buytheme/{id}','ThemeController@show');
    Route::get('/admin/themesettings/active/{id}','ThemeController@active');

    Route::resource('/admin/upgradeplan', 'UpgradePlanController');
    Route::get('/admin/upgradeplan/buyplan/{id}','UpgradePlanController@show');

    Route::post('/payment', 'PaymentController@store')->name('payment.submit');
    Route::get('/payment/cancle', 'PaymentController@paycancle')->name('payment.cancle');
    Route::get('/payment/return', 'PaymentController@payreturn')->name('payment.return');
    Route::post('/payment/notify', 'PaymentController@notify')->name('payment.notify');

    Route::post('/stripe-submit', 'StripeController@store')->name('stripe.submit');

    Route::post('/cashondelivery', 'FrontEndController@cashondelivery')->name('cash.submit');
    Route::post('/mobile_money', 'FrontEndController@mobilemoney')->name('mobile.submit');
    Route::post('/bank_wire', 'FrontEndController@bankwire')->name('bank.submit');

    Route::get('/user/login', 'Auth\ProfileLoginController@showLoginFrom')->name('user.login');
    Route::post('/user/login/submit', 'Auth\ProfileLoginController@login')->name('user.login.submit');
    Route::get('/user/registration', 'Auth\ProfileRegistrationController@showRegistrationForm')->name('user.reg');
    Route::post('/user/registration', 'Auth\ProfileRegistrationController@register')->name('user.reg.submit');
    Route::post('/user/exist_email','Auth\ProfileRegistrationController@exist_email');

    Route::get('/user/forgot', 'Auth\ProfileResetPassController@showForgotForm')->name('user.forgotpass');
    Route::post('/user/forgot', 'Auth\ProfileResetPassController@resetPass')->name('user.forgotpass.submit');
    Route::get('/user/resetpassword/{code}', 'Auth\ProfileResetPassController@resetForm');
    Route::post('/user/resetpassword', 'Auth\ProfileResetPassController@usernewpassword');

    Route::post('/userlogin', 'Auth\ProfileLoginController@Userlogin')->name('userlogin.submit');

    Route::post('/subscribe', 'FrontEndController@subscribe');
    Route::get('/checkout', 'UserProfileController@checkout')->name('user.checkout');
    Route::post('/user/state_list','UserProfileController@state_list');
    Route::post('/user/city_list','UserProfileController@city_list');
    
    Route::get('/{slug}', 'FrontEndController@cmsshow');

    Route::get('/admin/delete/photo/{id}','UserController@deleteimage1');
    Route::get('/admin/delete/eventimage/{id}','EventController@deleteimage');
    Route::get('/admin/delete/discount/{id}','DiscountController@deleteimage');
    Route::get('/admin/delete/featured_image/{id}','BlogController@deleteimage');
    Route::get('/admin/delete/newsimage/{id}','NewsController@deleteimage');
    Route::get('/admin/delete/sliderimage/{id}','SliderController@deleteimage');
    Route::get('/admin/delete/feature_image/{id}','ProductController@deleteimage');
    Route::get('/admin/delete/category/{id}','CategoryController@deleteimage');
    Route::get('/admin/delete/chiledcategory/{id}','ChildCategoryController@deleteimage');
    Route::get('/admin/delete/subcategory/{id}','SubCategoryController@deleteimage');
    Route::post('/admin/storesub','SubCategoryController@storesub');
    Route::post('/admin/storechild','ChildCategoryController@storechild');



    Route::get('/user/billing_address', 'UserProfileController@billinginfo')->name('user.billinginfo');
    Route::post('/user/billing_address', 'UserProfileController@editbilling')->name('user.editbilling');
    Route::get('/user/shipping_address', 'UserProfileController@shippinginfo')->name('user.shippinginfo');
    Route::post('/user/shipping_address', 'UserProfileController@editshipping')->name('user.editshipping');

    });

});

//Route::get('/', 'FrontEndController@index');









