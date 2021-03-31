<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Company;
use App\Country;
use App\State;
use App\City;
use App\Plans;
use App\Planupgradepay;
use App\Paymentdetail;
use App\Roles;
use App\Menus;
use App\Permissions;
use App\User;
use App\SampleEmailtemplates;
use App\Emailtemplates;
use App\Settings;
use App\PageSettings;
use App\SiteLanguage;
use App\Buytheme;
use App\SectionTitles;
use App\SocialLink;
use App\SeoTools;
Use App\Language;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use File;
use URL;
use Carbon\Carbon; 
use Mail;
use PDF;

class CompanyController extends Controller
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
        $company = Company::orderBy('id','desc')->get();
        return view('sadmin.companylist2',compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$country = Country::where('status','1')->get();
		$plans = Plans::where('status','1')->get();
		$languages=Language::where('status','1')->get();
        return view('sadmin.companyadd2',compact('country','plans','languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
    	   

    	// dd($request->all(),$multilanguage);
        $company = new Company();
        $company->fill($request->all());
        $company['language']  = implode(',', $request->language);
        $company['default_language'] = 'en';
        $password = str_random(8);
		
		if ($file = $request->file('company_logo'))
		{
            $photo_name = str_random(3).$request->file('company_logo')->getClientOriginalName();
            $file->move('assets/images/company',$photo_name);
            $company['company_logo'] = $photo_name;
        }

		$path = $_SERVER['HTTP_HOST'];
		$name = $company['username'];
		
		$url  = "http://$name.$path";
		$company['storeurl'] = $url;

		$company->save();
		$lastid = $company->id;
		
		// Plans  $Paymentdetail 
		 
		$plans = Plans::findOrFail($company['planid']);
		$planupgrade = new Planupgradepay();
		$planupgradearray = array(
		  'planid' => $company['planid'],
		  'payamount' => $plans->planamount ,
		  'start_date' => date('Y-m-d'),
		  'expiry_date' => date('Y-m-d', strtotime('+1 month')),
		  'duration' => '1 Month',
		  'reasontochange' => '-',
		  'company_id' => $lastid,
		  'created_at' =>  date('Y-m-d H:i:s'),
		  'updated_at' =>  date('Y-m-d H:i:s')
		);
		$planupgrade->fill( $planupgradearray );
		$planupgrade->save();
		
		$lastplanupgrade = $planupgrade->id;
		
		$paymentdetail = new Paymentdetail();
		$paymentdetailarray = array(
		  'planupgradid' => $lastplanupgrade,
		  'created_at' =>  date('Y-m-d H:i:s'),
		  'updated_at' =>  date('Y-m-d H:i:s')
		  );
		$paymentdetail->fill( $paymentdetailarray );
		$paymentdetail->save();
		
	    // Roles $ Users 
		
		$roles = new Roles();
		
		$rolesarray = array(
		  'role' => 'Admin',
		  'company_id' =>  $lastid,
		  'tempcode' =>  str_random(6),
		  'created_at' =>  date('Y-m-d H:i:s'),
		  'updated_at' =>  date('Y-m-d H:i:s')
		  );
		$roles->fill( $rolesarray );
		$roles->save();
		  
	  	$roleid=$roles->id;
	  
	  	$user = new User();
	  	$user['name'] =$company['comapany_name']; 
	  	$user['username'] =$company['username']; 
	  	$user['email'] =$company['company_email']; 
	  	$user['phone'] =$company['company_phone']; 
	  	$user['role'] =$roleid; 
	  	$user['status'] =1; 
	  	$user['company_id'] =$lastid; 
	  	$user['password'] = Hash::make($password);
      	$user['remember_token'] =' '; 
      	$user['created_at'] =date('Y-m-d H:i:s'); 
      	$user['updated_at'] =date('Y-m-d H:i:s'); 
      	$user['created_by'] = get_user_id();
	  	$user->save();
	  	$userid=  $user->id;

		// General Settings
		
		$settings = new Settings();
		
		$settings['logo'] = $photo_name;
		$settings['favicon'] = 'favicon.ico';
		$settings['title'] = $company['comapany_name'];
		$settings['about'] = ' ';
		$settings['address'] = $company['addressline1'].' '.$company['addressline2'];
		$settings['phone'] = $company['company_phone'];
		$settings['fax'] = ' ';
		$settings['email'] = $company['company_email'];
		$settings['footer'] = ' ';
		$settings['background'] = '';
		$settings['theme_color'] = '#000000';
		$settings['shipping_information'] = 'Per Order';
		$settings['shipping_cost'] = '0';
		$settings['tax_information'] = 'Per Order';
		$settings['tax'] = '0';
		$settings['currency_sign'] = '$';
		$settings['theme'] = 1;
		$settings['company_id'] = $lastid;
		$settings->save();
		
		// Page settings
		
		$pagesettings = new PageSettings();
		$pagesettings['contact'] = 'Contact';
		$pagesettings['contact_email'] = $company['company_email'];
		$pagesettings['faq'] = 'faq';
		$pagesettings['c_status'] = 1;
		$pagesettings['a_status'] = 1;
		$pagesettings['f_status'] = 1;
		$pagesettings['company_id'] = $lastid;
		$pagesettings->save();

		// Section Titles

		$sectiontitles = new SectionTitles();
		$sectiontitles['company_id'] = $lastid;
		$sectiontitles->save();

		// Social Link

		$sociallink = new SocialLink();
		$sociallink['company_id'] = $lastid;
		$sociallink->save();

		$sociallink = new SeoTools();
		$sociallink['company_id'] = $lastid;
		$sociallink->save();
		
		// Site languages
		$sitelanguage = new SiteLanguage();
		
		$sitelanguagearray = array('home' => 'Home','about_us' => 'About Us','contact_us' => 'Contact Us','faq' => 'FAQ','search' => 'Search','vendor' => 'Vendor','my_account' => 'My Account','my_cart' => 'My Cart','view_cart' => 'View Cart','checkout' => 'Checkout','continue_shopping' => 'Continue Shopping','proceed_to_checkout' => 'Proceed To Checkout','empty_cart' => 'Your Cart is Empty.','product_name' => 'Product Name','unit_price' => 'Unit Price','subtotal' => 'SubTotal','total' => 'Total','quantity' => 'Quantity','add_to_cart' => 'Add To Cart','out_of_stock' => 'Out of Stock','available' => 'Available','reviews' => 'Reviews','related_products' => 'Related Products','return_policy' => 'Return Policy','no_review' => 'No Review','write_a_review' => 'Write A Review','subscription' => 'Subscription','subscribe' => 'Subscribe','address' => 'Address','added_to_cart' => 'Successfully Added To Cart','description' => 'Description','share_in_social' => 'Share in Social','top_category' => 'Top Category','featured_products' => 'Featured Products','latest_products' => 'Latest Products','popular_products' => 'Popular Products','search_result' => 'Search Result','no_result' => 'No Products Found','contact_us_today' => 'Contact Us Today!','filter_option' => 'Filter Option','all_categories' => 'All Categories','load_more' => 'Load More','sort_by_latest' => 'Sort By Latest Products','sort_by_oldest' => 'Sort By Oldest Products','sort_by_highest' => 'Sort By Highest Price','sort_by_lowest' => 'Sort By Lowest Price','street_address' => 'Street Address','phone' => 'Phone','email' => 'E-mail','fax' => 'Fax','submit' => 'Submit','name' => 'Name','review_details' => 'Review Details','enter_shipping' => 'Enter Shipping Details','order_details' => 'Order Details','shipping_cost' => 'Shipping Cost','tax' => 'Tax','order_now' => 'Order Now','sign_in' => 'Sign In','popular_tags' => 'Popular Tags','latest_blogs' => 'Latest Blogs','footer_links' => 'Footer Links','view_details' => 'View Details','quick_review' => 'Quick Review','blog' => 'Blog','ship_to_another' => 'Ship to a Different Address?','pickup_details' => 'Pickup From The Location you Selected','logout' => 'Logout','company_id' => $lastid);

		$sitelanguage->fill( $sitelanguagearray );
		$sitelanguage->Save();  
		  
		// Menu $ permissions 
        $menusname = array('Dashboard', 'Orders','Products','Product Review','Discount','Customers','Manage Category','Blog','Event','News','Slider Settings','Language Settings','Testimonial Section','CMS','Page Settings','Email Templates','Email Compose','Contact US','Social Settings','Seo Tools','General Settings','Tickets','Subscribers','Role Management','Admin User','Theme Settings','Upgarde Plan','Navigation');
				  
		$menupath = array('dashboard','orders','products','review','discount','customers','categories','blog','event','news','sliders','language-settings','testimonial','cms','pagesettings','emailtemplates','emailcompose','contactus','social','tools','settings','tickets','subscribers','roles','user','themesettings','upgradeplan','navigation');	

		$menusicon = array('fa-home','fa-usd','fa-shopping-cart','fa-shopping-cart','fa-tags','fa-user','fa-sitemap','fa-file-text','fa-calendar','fa-newspaper-o','fa-photo','fa-language','fa-quote-right','fa-file-code-o','fa-file-code-o','fa-envelope-o','fa-envelope','fa-tty','fa-paper-plane','fa-wrench','fa-cogs','fa-ticket','fa-group','fa-user-circle-o','fa-user','fa-file-image-o','fa-thumbs-up','fa-bars');	  
     
	    for($i=0;$i<count($menusname);$i++)
	    {
			$menus = new Menus();
			$menusarray = array(
				'name' =>  $menusname[$i],
				'path' => $menupath[$i],
				'menuicon' => $menusicon[$i],
				'menuorder' => $i+1,
				'parentid' => 0,
				'status' => 1,
				'tempcode' => str_random(6),
				'created_at' =>  date('Y-m-d H:i:s'),
		        'updated_at' =>  date('Y-m-d H:i:s'),
				'company_id' => $lastid
			);
			$menus->fill( $menusarray );
           	$menus->save();
           	$menuid = $menus->id;
		   
		    $permissions = new Permissions;
			$permissions['menuid'] = $menuid;
			$permissions['roleid'] = $roleid;
			$permissions['company_id'] = $lastid;
			$permissions->save();
		    
		}
         
		// Email Templates
		 
        $sampleemailtemplates = SampleEmailtemplates::all();	

        if($sampleemailtemplates != null){
		  
		    foreach($sampleemailtemplates as $sme){
			   
			  	$emailtemplates = new Emailtemplates(); 
			  	$emailtemplates['type'] = $sme->type;
			  	$emailtemplates['title'] = $sme->title;
			  	$emailtemplates['fromname'] = $sme->fromname;
			  	$emailtemplates['fromemail'] = $sme->fromemail;
			  	$emailtemplates['subject'] = $sme->subject;
			  	$emailtemplates['label'] = $sme->label;
			  	$emailtemplates['content'] = $sme->content;
			  	$emailtemplates['tempcode'] = str_random(6);
			  	$emailtemplates['status'] = 1;
			  	$emailtemplates['created_at'] = date('Y-m-d H:i:s');
			  	$emailtemplates['updated_at'] = date('Y-m-d H:i:s');
			  	$emailtemplates['company_id'] = $lastid;
			  	$emailtemplates->save();
		    }
	    }		

		$emailtemplate =  Emailtemplates::where('Label','Company-Password')->where('company_id',0)->get();

		$email = $company['company_email'];
		$storename = $company['comapany_name'];
		$username = $company['username'];
        $subject = $emailtemplate[0]->subject;
        
        $find =  array('{{username}}','{{storename}}','{{password}}');
        $replace = array($username,$storename,$password);

        $headers = "MIME-Version: 1.0\r\n"; #Define MIME Version
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = str_replace($find,$replace,$emailtemplate[0]->content);

		mail($email,$subject,$message,$headers);
		
        return redirect('sadmin/company')->with('message','New Company Added Successfully. Password Send To Your Email Please Check It.');
    }
	
	public function ajaxrequest(Request $request)
    {
        $company = new Company();
        $company->fill($request->all());
		
		if ($file = $request->file('company_logo')){
            $photo_name = str_random(3).$request->file('company_logo')->getClientOriginalName();
            $file->move('assets/images/company',$photo_name);
            $company['company_logo'] = $photo_name;
        }

        $company->save();

      	return response()->json(array('success' => true, 'last_insert_id' => $company->id), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	
       	$company = Company::join('admin', 'admin.company_id', '=', 'company.id')->join('plans', 'plans.id', '=' ,'company.planid')->join('cities', 'cities.id', '=' ,'company.city')->select(DB::raw("company.*,plans.plantype,plans.planamount,cities.cityname,admin.email,admin.phone"))->where('company.id',$id)->get();
       	$upgradeplan = Planupgradepay::join('plans', 'planupgradepay.planid', '=', 'plans.id')->where('planupgradepay.company_id',$id)->orderby('planupgradepay.id','desc')->first();
       	$activetheme = Settings::join('themes', 'settings.theme', '=', 'themes.id')->where('settings.company_id',$id)->get();
       	$buytheme = Buytheme::join('themes', 'buythemes.themeid', '=', 'themes.id')->where('buythemes.company_id',$id)->select(DB::raw("buythemes.*,themes.themename,themes.themeimage"))->get();
       	$paymentdetail = Planupgradepay::join('plans', 'planupgradepay.planid', '=', 'plans.id')->where('planupgradepay.company_id',$id)->get();

        return view('sadmin.companyview',compact('company','upgradeplan','activetheme','buytheme','paymentdetail'));
    }

    public function viewprint($id)
    {
    	$company = Company::join('admin', 'admin.company_id', '=', 'company.id')->join('plans', 'plans.id', '=' ,'company.planid')->join('cities', 'cities.id', '=' ,'company.city')->select(DB::raw("company.*,plans.plantype,plans.planamount,cities.cityname,admin.email,admin.phone"))->where('company.id',$id)->get();
       	$upgradeplan = Planupgradepay::join('plans', 'planupgradepay.planid', '=', 'plans.id')->where('planupgradepay.company_id',$id)->orderby('planupgradepay.id','desc')->first();
       	$activetheme = Settings::join('themes', 'settings.theme', '=', 'themes.id')->where('settings.company_id',$id)->get();
       	$buytheme = Buytheme::join('themes', 'buythemes.themeid', '=', 'themes.id')->where('buythemes.company_id',$id)->select(DB::raw("buythemes.*,themes.themename,themes.themeimage"))->get();
       	$paymentdetail = Planupgradepay::join('plans', 'planupgradepay.planid', '=', 'plans.id')->where('planupgradepay.company_id',$id)->get();

       	$pdf = PDF::loadView('sadmin.companyprintview', compact('company','upgradeplan','activetheme','buytheme','paymentdetail'));

       	return $pdf->stream();
    }

    public function companypdf(Request $request,$id)
    {
    	// dd($id);

         	$company = Company::join('admin', 'admin.company_id', '=', 'company.id')->join('plans', 'plans.id', '=' ,'company.planid')->join('cities', 'cities.id', '=' ,'company.city')->select(DB::raw("company.*,plans.plantype,plans.planamount,cities.cityname,admin.email,admin.phone"))->where('company.id',$id)->get();
       	$upgradeplan = Planupgradepay::join('plans', 'planupgradepay.planid', '=', 'plans.id')->where('planupgradepay.company_id',$id)->orderby('planupgradepay.id','desc')->first();
       	$activetheme = Settings::join('themes', 'settings.theme', '=', 'themes.id')->where('settings.company_id',$id)->get();
       	$buytheme = Buytheme::join('themes', 'buythemes.themeid', '=', 'themes.id')->where('buythemes.company_id',$id)->select(DB::raw("buythemes.*,themes.themename,themes.themeimage"))->get();
       	$paymentdetail = Planupgradepay::join('plans', 'planupgradepay.planid', '=', 'plans.id')->where('planupgradepay.company_id',$id)->get();

        $pdf=PDF::loadView('sadmin.companypdfview', compact('company','upgradeplan','activetheme','buytheme','paymentdetail'));

        return $pdf->download('company.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
		$country = Country::where('status','1')->get();
		$state = State::where('status','1')->where('countryid',$company->country)->get();
		$city = City::where('status','1')->where('stateid',$company->state)->get();
		$languages=Language::where('status','1')->get();
        return view('sadmin.companyedit',compact('company','country','state', 'city','languages'));
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
    	$userid = get_user_id();
        $company = Company::findOrFail($id);
        $data = $request->all();
        $data['language'] = implode(',', $request->language);

        $settings = Settings::where('company_id', '=', $id);

        $user = User::where('created_by', '=', $userid)->where('company_id', '=', $id);

		if ($file = $request->file('company_logo')){
            $photo_name = str_random(3).$request->file('company_logo')->getClientOriginalName();
            $file->move('assets/images/company',$photo_name);
            $data['company_logo'] = $photo_name;

            $logo['logo'] = $photo_name;
            $settings->update($logo);
            if($company->company_logo != '')
            {
                unlink('assets/images/company/'.$company->company_logo);
            }
        }

        if ($request->status == "")
        {
            $data['status'] = 0;
            $userdata['status'] = 0;
        }
        else
        {
            $data['status'] = 1;
            $userdata['status'] = 1;
        }

        $user->update($userdata);
        $company->update($data);

        return redirect('sadmin/company')->with('message','Company Updated Successfully.');
    }

    public function status($id, $status)
    {
    	$userid = get_user_id();
        $company = Company::findOrFail($id);
        $input['status'] = $status;

        $company->update($input);

        $admin = User::where('created_by', '=', $userid)->where('company_id', '=', $id);
        $data['status'] = $status;

        $admin->update($data);

        return redirect('sadmin/company')->with('message','Company Status Updated Successfully.');
    }
	
	public function existemail(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
             $title_exists = (count(\App\User::where('id', '!=', $id)->where('email', '=', $request->input('company_email'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = (count(\App\User::where('email', '=', $request->input('company_email'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }  
    }
	
	public function existusernametitle(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
             $title_exists = (count(\App\User::where('id', '!=', $id)->where('username', '=', $request->input('username'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = (count(\App\User::where('username', '=', $request->input('username'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }  
    }
	
	
	public function state_list(Request $request){

        $countryid = $request->input('countryid');
        $state = State::where('status','1')->where('countryid',$countryid)->get();
        $options='<option value="">Select State</option>';
        if($state != null)
        {
			foreach($state as $sl)
			{
				$options .='<option data-tokens="'.$sl->statename.'" value="'.$sl->id.'">'.$sl->statename.'</option>';
			}			
			echo $options;
           
        }
        else
        {
            echo $options;
        }  
    }

	
	public function city_list(Request $request){

        $stateid = $request->input('stateid');
        $city = City::where('status','1')->where('stateid',$stateid)->get();
        $options='<option value="">Select City</option>';
        if($city != null)
        {
			foreach($city as $cl)
			{
				$options .='<option data-tokens="'.$cl->cityname.'" value="'.$cl->id.'">'.$cl->cityname.'</option>';
			}			
			echo $options;
            
           
        }
        else
        {
            echo $options;
        }  
    }

    public function checkdomainname(Request $request)
    {

        $domian = $request->input('domian');
        $username = $request->input('username');

        if($domian == $username)
        {
                return response()->json(false);
        }
        else
        {
                return response()->json(true);
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
        $company = Company::findOrFail($id);
       // $users = User::where('company_id',$id);
        $planupgradepay = Planupgradepay::where('company_id',$id);
        //$paymentdetail = Paymentdetail::where('company_id',$id);
        $roles = Roles::where('company_id',$id);
        $settings = Settings::where('company_id',$id);
        $pagesettings = PageSettings::where('company_id',$id);
        $sectiontitles = SectionTitles::where('company_id',$id);
        $sociallinks = SocialLink::where('company_id',$id);
        $seotoole = SeoTools::where('company_id',$id);
        $sitelanguage = SiteLanguage::where('company_id',$id);
        $menus = Menus::where('company_id',$id);
        $permission = Permissions::where('company_id',$id);
        $emailtemplates = Emailtemplates::where('company_id',$id);
        if($company->company_logo != '')
        {
            unlink('assets/images/company/'.$company->company_logo);
        }
        $company->delete();
       // $users->delete();
        $planupgradepay->delete();
        //$paymentdetail->delete();
        $roles->delete();
        $settings->delete();
        $pagesettings->delete();
        $sectiontitles->delete();
        $sociallinks->delete();
        $seotoole->delete();
        $sitelanguage->delete();
        $menus->delete();
        $permission->delete();
        $emailtemplates->delete();
        return redirect('sadmin/company')->with('message','Company Delete Successfully.');
    }





       public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                            
                0  => 'company_logo',
                1  => 'comapny',
                2  => 'storeurl',
                3  => 'email',
                4  => 'phone',
                5  => 'status',
                6  => 'actions',
            );
  
        $totalData = Company::count();

        // dd($totalData);
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Company::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($limit,$start,$order,$dir,$posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts = Company::where('id','LIKE',"%{$search}%")
                            ->orWhere('comapany_name', 'LIKE',"%{$search}%")
                             ->orWhere('company_email', 'LIKE',"%{$search}%")
                             ->orWhere('company_phone', 'LIKE',"%{$search}%")
                            
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

                            	// dd($posts);

    $totalFiltered =Company::where('id','LIKE',"%{$search}%")
                           ->orWhere('comapany_name', 'LIKE',"%{$search}%")
                            ->orWhere('company_email', 'LIKE',"%{$search}%")
                            ->orWhere('company_phone', 'LIKE',"%{$search}%")
                            ->count();
                
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                     if($post->company_logo != '')
                     {

                    $image= "<img style='width: 50px;height: 50px;' src='".url("/")."/assets/images/company/".$post->company_logo."'>";
                     }
                                          
                    else
                    {
                       $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive'style='width: 120px;height: 70px;'>";


                    }

                 $url="<a href='".$post->storeurl."/admin' target='_blank' class='store_list'>".$post->storeurl."</a>".
                 "<img src='".$post->storeurl."/setcookie?id=".Session::getId() ."' style='display:none;' />";


		   
                $nestedData['company_logo']    = $image;
                $nestedData['comapny'] = $post->comapany_name;
                $nestedData['storeurl'] = $url;
                $nestedData['email'] = $post->company_email; 
                $nestedData['phone'] = $post->company_phone;

                 if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('sadmin/company')."/status/$post->id}}/0'class='"."badge badge-success'>Active</a>";

                 }
                                        
                elseif($post->status == 0)
                {
                
                $nestedData['status'] = "<a href='".url('sadmin/company')."/status/$post->id}}/1'class='"."badge badge-danger'>Deactive</a>";
                }
                      

    $nestedData['actions']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='company/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='".url("/")."/sadmin/company/".$post->id."'<i class='fa fa-eye'></i><span class='mrgn-l-sm'>View</span></a></a></li></ul></div>";
       

                $data[] = $nestedData;
                $i++;
            }
        }          
        $json_data=array(
                  "draw"            => intval($request->input('draw')),  
                  "recordsTotal"    => intval($totalData),  
                  "recordsFiltered" => intval($totalFiltered), 
                  "data"            => $data   
                    );

        // dd($json_data);

       echo json_encode($json_data,JSON_UNESCAPED_UNICODE ); 
        
    }   
}
