<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\News;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\Contactus;
use App\Cms;
use App\Blog;
use Mail;
use Illuminate\Support\Str;

class FrontEndController extends Controller
{

    public function __construct()
    {
        
    }
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  
		$companyid = get_company_id();
		$news = News::where('company_id',$companyid)->orderBy('id','desc')->take(3)->get();
		$plans = Plans::where('status',1)->orderBy('id','asc')->get();
		
		return view('sadmin.frontend.index',compact('news','plans'));
    }
	
	 public function create_store()
    {
		 $companyid = get_company_id();
		 $country = Country::where('status','1')->get();
		 $plans = Plans::orderBy('id','asc')->get();
		 return view('sadmin.frontend.createstore',compact('country','plans'));
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_plan(Request $request)
    {
	   $planid = $request->input('planid');
	   $plantype = $request->input('plantype');
	   $plan = Plans::where('status', 1)->where('id',$planid)->firstOrFail(); 
      if( $plantype == 'y'){
		  $du = '12 Months';
		   $amount = $plan->planamount*12;
		}else {
			 $du = '1 Month';
			 $amount = $plan->planamount;
		}
		$options = '';
 	   if($plan != null)
        {
			
		$options .='<tr>
					  <td style="padding: 20px 10px; text-align: left;">'.$plan->plantype.'</td>
					  <td style="padding: 20px 10px; text-align: left;">'.$du.'</td>
					  <td style="padding: 20px 10px; text-align: right;">'.$amount.'</td>
					  <td style="padding: 20px 10px; text-align: right;">'.$amount.'<input type="hidden" name="planid" value="'.$plan->id.'"><input type="hidden" name="plantype" value="'.$plantype.'"><input type="hidden" name="total_amount" value="'.$amount.'"></td>
					 </tr>';
					
			echo $options;
            
           
        }
        else
        {
            echo $options;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_store(Request $request)
    {
        $company = new Company();
        $company->fill($request->all());
	
		/*echo '<pre>'; print_r($request->all()); echo '</pre>';
		exit;*/
		
		$password = $request->password;
		
		$path = $_SERVER['HTTP_HOST'];
		$company['comapany_name'] = $company['username'];
		$storename = Str::slug($company['username'], '-');
		$company['username'] = $storename;
		$name = $company['username'];
		$company['status'] = 1;
		$url  = "http://$name.$path";
		$company['storeurl'] = $url;
		
		$company->save();
		$lastid = $company->id;
		
		// Plans  $Paymentdetail 
		 if($request->plantype == 'y'){
			$du = "12 Months";
			$ex =date('Y-m-d', strtotime('+1 year'));
		 }else{
			$du = "1 Month";
			$ex =date('Y-m-d', strtotime('+1 month')); 
		 }
		$plans = Plans::findOrFail($company['planid']);
		$planupgrade = new Planupgradepay();
		$planupgradearray = array(
		  'planid' => $company['planid'],
		  'payamount' => $plans->planamount ,
		  'start_date' => date('Y-m-d'),
		  'expiry_date' => $ex,
		  'duration' => $du ,
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
		
		$settings['logo'] = 'logo.png';
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

		// SectionTitles
		
		$sectiontitles = new SectionTitles();
		$sectiontitles['company_id'] = $lastid;
		$sectiontitles->save();
		
		// SocialLink
		$sociallink = new SocialLink();
		$sociallink['company_id'] = $lastid;
		$sociallink->save();

		// SEO Tools
		$sociallink = new SeoTools();
		$sociallink['company_id'] = $lastid;
		$sociallink->save();
		
		// Site languages
		$sitelanguage = new SiteLanguage();
		
		$sitelanguagearray = array('home' => 'Home','about_us' => 'About Us','contact_us' => 'Contact Us','faq' => 'FAQ','search' => 'Search','vendor' => 'Vendor','my_account' => 'My Account','my_cart' => 'My Cart','view_cart' => 'View Cart','checkout' => 'Checkout','continue_shopping' => 'Continue Shopping','proceed_to_checkout' => 'Proceed To Checkout','empty_cart' => 'Your Cart is Empty.','product_name' => 'Product Name','unit_price' => 'Unit Price','subtotal' => 'SubTotal','total' => 'Total','quantity' => 'Quantity','add_to_cart' => 'Add To Cart','out_of_stock' => 'Out of Stock','available' => 'Available','reviews' => 'Reviews','related_products' => 'Related Products','return_policy' => 'Return Policy','no_review' => 'No Review','write_a_review' => 'Write A Review','subscription' => 'Subscription','subscribe' => 'Subscribe','address' => 'Address','added_to_cart' => 'Successfully Added To Cart','description' => 'Description','share_in_social' => 'Share in Social','top_category' => 'Top Category','featured_products' => 'Featured Products','latest_products' => 'Latest Products','popular_products' => 'Popular Products','search_result' => 'Search Result','no_result' => 'No Products Found','contact_us_today' => 'Contact Us Today!','filter_option' => 'Filter Option','all_categories' => 'All Categories','load_more' => 'Load More','sort_by_latest' => 'Sort By Latest Products','sort_by_oldest' => 'Sort By Oldest Products','sort_by_highest' => 'Sort By Highest Price','sort_by_lowest' => 'Sort By Lowest Price','street_address' => 'Street Address','phone' => 'Phone','email' => 'E-mail','fax' => 'Fax','submit' => 'Submit','name' => 'Name','review_details' => 'Review Details','enter_shipping' => 'Enter Shipping Details','order_details' => 'Order Details','shipping_cost' => 'Shipping Cost','tax' => 'Tax','order_now' => 'Order Now','sign_in' => 'Sign In','popular_tags' => 'Popular Tags','latest_blogs' => 'Latest Blogs','footer_links' => 'Footer Links','view_details' => 'View Details','quick_review' => 'Quick Review','blog' => 'Blog','ship_to_another' => 'Ship to a Different Address?','pickup_details' => 'Pickup From The Location you Selected','logout' => 'Logout','company_id' => $sectiontitles['company_id']);

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
		
		$email = $company['company_email'];
		$subject = 'Store activation ';
		$message = 'Hello '.$company['username'].'  Your Password is: '.$password.'';

		//mail($email,$subject,$message);
		
        //return redirect('sadmin/company')->with('message','New Company Added Successfully.');
        echo $url;

    }
 
 
    public function existstorename(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();
		$storename = Str::slug($request->input('username'), '-');

        if($id != '')
        {
             $title_exists = ((\App\User::where('id', '!=', $id)->where('username', '=', $storename)->get()) != null) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = ((\App\User::where('username', '=', $storename)->get()) != null) ? false : true;
            return response()->json($title_exists);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        //
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
	
	public function existemail(Request $request)
	{

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
            $title_exists = ((\App\User::where('id', '!=', $id)->where('email', '=', $request->input('company_email'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = ((\App\User::where('email', '=', $request->input('company_email'))->get()) != null) ? false : true;
            return response()->json($title_exists);
        }  
    }

    public function contact()
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
        $pagedata = PageSettings::where('company_id', $companyid)->first();
		
        return view('sadmin/frontend/contact', compact('pagedata'));
    }

    public function contactmail(Request $request)
    {
		$companyid = get_company_id();

		$user = User::where('role',1)->where('company_id',$companyid)->orderBy('id','asc')->first();

		$Contactus = new Contactus();
        $Contactus->fill($request->all()); 
		
		$Contactus['company_id'] = $companyid;
        
        $Contactus['status'] = 1;

        $Contactus->save();	

        $emailtemplate =  Emailtemplates::where('Label','Super-Admin-Contact')->where('company_id',$companyid)->first();

        $find =  array('{{name}}','{{phone}}','{{email}}','{{message}}');
        $replace = array($Contactus['name'], $Contactus['phone'], $Contactus['email'], $Contactus['message']);
        
        $subject = str_replace($find,$replace,$emailtemplate->subject);
        $content = str_replace($find,$replace,$emailtemplate->content);
       
        $to = $user->email;

        Mail::send('email',compact('content'), function ($message) use ($emailtemplate,$to){
            $message->from($emailtemplate->fromemail, $emailtemplate->from);
            $message->to($to);
            $message->subject($emailtemplate->subject);
        });

        if (Mail::failures()) 
        {
            $failures[] = Mail::failures()[0];
            Session::flash('error', 'Please Try Again...');
        }
        else
        {
        	Session::flash('success', 'Thank You For Your Message. It has been Sent...');
        }   
        return redirect('/contactus');
    }

    public function cmsshow($slug)
    {
	  	$companyid = get_company_id();
      	$cms = Cms::where('slug', $slug)->where('status', 1)->where('company_id',$companyid)->firstOrFail(); 
	  	return view('sadmin/frontend/cmspage',compact('cms'));
    }

    public function blogdetails($id)
    {

		$companyid = get_company_id();
        // $themename = get_theme_name();
        /*$blog = Blog::findOrFail($id);*/
        $blog = Blog::where('company_id', $companyid)->where('id', $id)->first();
        $input['views'] = $blog->views + 1;
        $blog->update($input);
        $recents = Blog::where('company_id',$companyid)->orderBy('id','desc')->take(5)->get();
        return view('sadmin/frontend/blogdetails',compact('blog','recents'));
    }

    //All Blogs
    public function allblog()
    {

    	
		$companyid = get_company_id();
  
        $blogs = Blog::where('company_id', $companyid)->where('status',1)->get();
     
        return view('sadmin/frontend/blogs',compact('blogs'));
    }
}
