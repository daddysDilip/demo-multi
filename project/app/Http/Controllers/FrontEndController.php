<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Brand;
use App\Cart;
use App\Category;
use App\Counter;
use App\Contactus;
use App\FAQ;
use App\Gallery;
use App\Order;
use App\OrderedProducts;
use App\PageSettings;
use App\Product;
use App\Review;
use App\SectionTitles;
use App\Service;
//use App\ServiceSection;
use App\Settings;
use App\SiteLanguage;
use App\Subscribers;
use App\Testimonial;
use App\UserProfile;
use App\Discount;
use App\Cms;
use App\Company;
use App\Emailtemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\CustomerAddress;
use App\Seosetion;
use DB;
use Mail;
use Illuminate\Support\Str;

class FrontEndController extends Controller
{

    public function __construct()
    {
        //$this->middleware('web');
        //$this->middleware('auth:profile');
        //$referral_url = "";
        if(isset($_SERVER['HTTP_REFERER'])){
            $referral = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
            if ($referral != $_SERVER['SERVER_NAME']){

                $brwsr = Counter::where('type','browser')->where('referral',$this->getOS());
                if($brwsr->count() > 0){
                    $brwsr = $brwsr->first();
                    $tbrwsr['total_count']= $brwsr->total_count + 1;
                    $brwsr->update($tbrwsr);
                }else{
                    $newbrws = new Counter();
                    $newbrws['referral']= $this->getOS();
                    $newbrws['type']= "browser";
                    $newbrws['total_count']= 1;
                    $newbrws->save();
                }

                $count = Counter::where('referral',$referral);
                if($count->count() > 0){
                    $counts = $count->first();
                    $tcount['total_count']= $counts->total_count + 1;
                    $counts->update($tcount);
                }else{
                    $newcount = new Counter();
                    $newcount['referral']= $referral;
                    $newcount['total_count']= 1;
                    $newcount->save();
                }
            }
        }else{
            $brwsr = Counter::where('type','browser')->where('referral',$this->getOS());
            if($brwsr->count() > 0){
                $brwsr = $brwsr->first();
                $tbrwsr['total_count']= $brwsr->total_count + 1;
                $brwsr->update($tbrwsr);
            }else{
                $newbrws = new Counter();
                $newbrws['referral']= $this->getOS();
                $newbrws['type']= "browser";
                $newbrws['total_count']= 1;
                $newbrws->save();
            }
        }
    }

    function getOS() {

        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];

        $os_platform    =   "Unknown OS Platform";

        $os_array       =   array(
            '/windows nt 10/i'     =>   'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }

        }
        return $os_platform;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$companyid = get_company_id();
		$themename = get_theme_name();
		//echo $themename; exit;
	    $languages = SectionTitles::where('company_id',$companyid)->first();
        //$services = ServiceSection::all();
        $brands = Brand::where('type','brand')->where('status',1)->where('company_id',$companyid)->get();
        $banners = Brand::where('type','banner')->where('status',1)->where('company_id',$companyid)->get();
        $blogs = Blog::where('company_id',$companyid)->where('status',1)->orderBy('id','desc')->take(8)->get();
        $features = Product::where('featured','1')->where('status',1)->where('status','1')->where('company_id',$companyid)->orderBy('id','desc')->take(8)->get();
        $tops = Product::where('status','1')->where('status',1)->where('company_id',$companyid)->where('views','>',0)->orderBy('views','desc')->take(8)->get();
        $latests = Product::where('status','1')->where('status',1)->where('company_id',$companyid)->orderBy('id','desc')->take(8)->get();
        $fcategory = Category::where('featured','1')->where('status',1)->where('company_id',$companyid)->orderBy('id','desc')->first();
        $fcategories = Category::where('featured','1')->where('status',1)->where('company_id',$companyid)->orderBy('id','desc')->skip(1)->take(4)->get();
        $testimonials = Testimonial::where('status',1)->where('company_id',$companyid)->get();

        $meta = Seosetion::where('slug','home')->first();

                       // dd($themename);

		
        return view($themename.'index', compact('banners','brands','blogs','fcategories','fcategory','features','latests','tops','testimonials','languages','meta'));
    }

    public function vouchercode(Request $request)
    {   
	    $companyid = get_company_id();
        $themename = get_theme_name();
        $currentdate=date('Y-m-d');
        $code = $request['vouchercode'];
        $customerid = $request['customerid'];

       // $user = UserProfile::find(Auth::user()->id);

        $coddata = Discount::where('code',$code)->where('company_id',$companyid)->where('enddate','>=',$currentdate)->get();

        $data['voucherdetail'] = $coddata;

        $orderdata = Order::where('discount_code',$code)->where('company_id',$companyid)->where('customerid',$customerid)->get();

        $data['orderdetail'] = $orderdata;

        echo json_encode($data);
    }

    public function discountDetail($tempcode)
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
        $discount = Discount::where('tempcode',$tempcode)->where('company_id',$companyid)->get();
        return view($themename.'discountdetail',compact('discount'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$slug)
    {
	 
    }
	
	public function cmsshow($subdomain,$slug)
    {
	  $companyid = get_company_id();
      $themename = get_theme_name();
      $cms = Cms::where('slug', $slug)->where('status', 1)->where('company_id',$companyid)->firstOrFail(); 

      $meta=$cms;   
	  return view($themename.'cmspage',compact('cms','meta'));
    }

    //Blog Details
    public function blogdetails($subdomain,$id)
    {
        // dd('innn blog i demo');
		$companyid = get_company_id();
        $themename = get_theme_name();
        /*$blog = Blog::findOrFail($id);*/
        $blog = Blog::where('company_id', $companyid)->where('id', $id)->first();
        $input['views'] = $blog->views + 1;
        $blog->update($input);
        $meta=$blog;
        $recents = Blog::where('company_id',$companyid)->orderBy('id','desc')->take(5)->get();
        return view($themename.'blogdetails',compact('blog','recents','meta'));
    }

    //All Blogs
    public function allblog()
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
        $blogs = Blog::where('company_id',$companyid)->where('status',1)->get();
          $mete=$blogs;
        return view($themename.'blogs',compact('blogs','meta'));
    }

    public function cartupdate(Request $request)
    {
       // dd($request);
		$companyid = get_company_id();
        $themename = get_theme_name();
        if ($request->isMethod('post')){

            if (empty(Session::get('uniqueid'))){

                $cart = new Cart;
                $cart->fill($request->all());
                Session::put('uniqueid', $request->uniqueid);
				$cart['company_id'] = $companyid;
                $cart->save();

            }else{

                $cart = Cart::where('uniqueid',$request->uniqueid)
                    ->where('product',$request->product)->where('company_id',$companyid)->first();
                $carts = Cart::where('uniqueid',$request->uniqueid)
                        ->where('product',$request->product)->where('company_id',$companyid)->count();
                if ($carts  > 0 ){
                    $data =  $request->all();
                    $cart->update($data);
                }else{
                    $cart = new Cart;
                    $cart->fill($request->all());
					$cart['company_id'] = $companyid;
                    $cart->save();
                }

            }
         return response()->json(['response' => 'Successfully Added to Cart.','product' => $request->product]);
        }

        $getcart = Cart::where('uniqueid',Session::get('uniqueid'))->where('company_id',$companyid)->get();

        return response()->json(['response' => $getcart]);
    }

    public function cartdelete($subdomain,$id)
    {
		$companyid = get_company_id();
        $cartproduct = Cart::where('uniqueid',Session::get('uniqueid'))
            ->where('product',$id)->where('company_id',$companyid)->first();
        $cartproduct->delete();

        $getcart = Cart::where('uniqueid',Session::get('uniqueid'))->where('company_id',$companyid)->get();
        return response()->json(['response' => $getcart]);
    }

    //Submit Review
    public function reviewsubmit(Request $request)
    {
		$companyid = get_company_id();
        $review = new Review;
        $review->fill($request->all());
        $review['company_id'] = $companyid;
        $review['review_date'] = date('Y-m-d H:i:s');
        $review->save();
        return redirect()->back()->with('message','Your Review Submitted Successfully.');
    }

    //Product Data
    public function productdetails($subdomain,$id,$title)
    {


		$companyid = get_company_id();
        $themename = get_theme_name();
        /*$productdata = Product::findOrFail($id);*/
        $productdata = Product::where('company_id', $companyid)->where('id', $id)->where('slug', $title)->first();
        $meta=$productdata;
        if($productdata != "")
        {
            $data['views'] = $productdata->views + 1;
            $productdata->update($data);
            $relateds = Product::where('status','1')->where('company_id',$companyid)->where('id', '!=', $id)->where('slug', '!=', $title)->whereRaw('FIND_IN_SET(?,category)', [$productdata->category[0]])
                ->take(8)->get();
            $gallery = Gallery::where('productid',$id)->get();
            $purchaseproduct = "";

            $reviews = Review::where('productid',$id)->where('company_id',$companyid)->where('status',1)->get();
            return view($themename.'product', compact('productdata','gallery','reviews','relateds','purchaseproduct','meta'));
        }
        else
        {
            abort(404, 'Unauthorized action.');
        }
        
    }

    //Category Products
    public function catproduct(Request $request,$subdomain,$slug)
    {
        
        $sort = "";
        $companyid = get_company_id();
        $themename = get_theme_name(); 
        $category = Category::where('slug',$slug)->where('status',1)->where('company_id',$companyid)->first();

    

        $meta=$category;
        if ($category === null) {
            abort(404, 'Unauthorized action.');
        }else{

            $minvalue = $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])->min('selling_price');
            $maxvalue = $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])->max('selling_price');

            if (Input::get('sort') != "") {
                $sort = Input::get('sort');
            }
            if (Input::get('min') != "") {
                $min = $request->min;
                $mins = Input::get('min');
                $sort = "selling_price";
            }
            else
            {
                $mins = $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])->min('selling_price');
            }
            if (Input::get('max') != "") {
                $max = $request->max;
                $maxs = Input::get('max');
                $sort = "selling_price";
            }
            else
            {
                $maxs = $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])->max('selling_price');
            }

            if ($sort=="old") {
                
                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('created_at','asc')
                ->paginate(12);
                
            }elseif ($sort=="new") {

                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('created_at','desc')
                ->paginate(12);

            }elseif ($sort=="low") {

                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('selling_price','asc')
                ->paginate(12);

            }elseif ($sort=="high") {

                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('selling_price','desc')
                ->paginate(12);

            }elseif ($sort=="selling_price") {

                $products = Product::where('status','1')
				    ->where('company_id',$companyid)
                    ->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                    ->whereBetween('selling_price', [$min, $max])
                    ->orderBy('selling_price','asc')
                    ->paginate(12);

            }else{

                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('created_at','desc')
                ->paginate(12);
            }
        }
        return view($themename.'categoryproduct', compact('products','category','sort','mins','maxs','maxvalue','minvalue','meta'));
    }

    public function shop(Request $request,$subdomain)
    {

        $sort = "";
        $companyid = get_company_id();
        $themename = get_theme_name(); 
     
           $minvalue = $products = Product::where('status','1')->where('company_id',$companyid)->min('selling_price');
            $maxvalue = $products = Product::where('status','1')->where('company_id',$companyid)->max('selling_price');


                  if (Input::get('sort') != "") {
                $sort = Input::get('sort');
            }
            if (Input::get('min') != "") {
                $min = $request->min;
                $mins = Input::get('min');
                $sort = "selling_price";
            }
            else
            {
                $mins = $products = Product::where('status','1')->where('company_id',$companyid)->min('selling_price');
            }
            if (Input::get('max') != "") {
                $max = $request->max;
                $maxs = Input::get('max');
                $sort = "selling_price";
            }
            else
            {
                $maxs = $products = Product::where('status','1')->where('company_id',$companyid)->max('selling_price');
            }



            if ($sort=="old") {
                
                $products = Product::where('status','1')->where('company_id',$companyid)
                ->orderBy('created_at','asc')
                ->paginate(12);
                
            }elseif ($sort=="new") {

                $products = Product::where('status','1')->where('company_id',$companyid)
                ->orderBy('created_at','desc')
                ->paginate(12);

            }elseif ($sort=="low") {

                $products = Product::where('status','1')->where('company_id',$companyid)
                ->orderBy('selling_price','asc')
                ->paginate(12);

            }elseif ($sort=="high") {

                $products = Product::where('status','1')->where('company_id',$companyid)
                ->orderBy('selling_price','desc')
                ->paginate(12);

            }elseif ($sort=="selling_price") {

                $products = Product::where('status','1')
                    ->where('company_id',$companyid)
                   
                    ->whereBetween('selling_price', [$min, $max])
                    ->orderBy('selling_price','asc')
                    ->paginate(12);

            }else{

                $products = Product::where('status','1')->where('company_id',$companyid)
                ->orderBy('created_at','desc')
                ->paginate(12);
            }


        return view($themename.'shop', compact('products','category','sort','mins','maxs','maxvalue','minvalue'));

    }

    //Load More Category Products
    public function loadcatproduct($subdomain,$slug,$page)
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
        $language = SiteLanguage::where('company_id', $companyid)->first();
        $settings = Settings::where('company_id', $companyid)->first();
        $res = "";
        $min = "0";
        $max = "500";
        $mins = "0";
        $maxs = "500";
        $skip = ($page-1)*9;

        $sort = "";
        if (Input::get('sort') != "") {
            $sort = Input::get('sort');
        }

        if (Input::get('min') != "") {
            $min = Product::Filter(Input::get('min'));
            $mins = Input::get('min');
            $sort = "price";
        }
        if (Input::get('max') != "") {
            $max = Product::Filter(Input::get('max'));
            $maxs = Input::get('max');
            $sort = "price";
        }
        $category = Category::where('slug',$slug)->first();
        if ($category === null) {
            $category['name'] = "Nothing Found";
            $products = new \stdClass();
        }else{

            if ($sort=="old") {
                
                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('created_at','asc')
                ->skip($skip)
                ->take(9)
                ->get();
                
            }elseif ($sort=="new") {

                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('created_at','desc')
                ->skip($skip)
                ->take(9)
                ->get();

            }elseif ($sort=="low") {

                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('price','asc')
                ->skip($skip)
                ->take(9)
                ->get();

            }elseif ($sort=="high") {

                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('price','desc')
                ->skip($skip)
                ->take(9)
                ->get();

            }elseif ($sort=="price") {

                $products = Product::where('status','1')
				     ->where('company_id',$companyid)
                    ->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                    ->whereBetween('price', [$min, $max])
                    ->orderBy('price','asc')
                    ->take(9)
                    ->get();

            }else{

                $products = Product::where('status','1')->where('company_id',$companyid)->whereRaw('FIND_IN_SET(?,category)', [$category->id])
                ->orderBy('created_at','desc')
                ->skip($skip)
                ->take(9)
                ->get();
            }


            foreach($products as $product) {
                $res .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="single-product-carousel-item text-center">
                                <a href="' . url('/product') . '/' . $product->id . '/' . str_replace(' ', '-', strtolower($product->title)) . '"> <img src="' . url('/assets/images/products') . '/' . $product->feature_image . '" alt="Product Image" /> </a>
                                <div class="product-carousel-text">
                                    <a href="' . url('/product') . '/' . $product->id . '/' . str_replace(' ', '-', strtolower($product->title)) . '">
                                        <h4 class="product-title">' . $product->title . '</h4>
                                    </a>
                                    <div class="ratings">
                                        <div class="empty-stars"></div>
                                        <div class="full-stars" style="width:'.Review::ratings($product->id).'%"></div>
                                    </div>
                                    <div class="product-price">';
                                    if ($product->offer_price != "" && $product->offer_price != 0) {
                                        $res .= '<span class="original-price">' .$settings->currency_sign. $product->offer_price . '</span>';
                                    }
                                    $res .= '
                                       
                                        <del class="offer-price">' .$settings->currency_sign. Product::Cost($product->id) . '</del>
                                    </div>
                                    <div class="product-meta-area">
                                        <form class="addtocart-form">';
                                    if (Session::has('uniqueid')) {
                                        $res .= '<input type="hidden" name="uniqueid" value="' . Session::get('uniqueid') . '">';
                                    } else {
                                        $res .= '<input type="hidden" name="uniqueid" value="' . str_random(7) . '">';
                                    }

                                    $res .= '
                                            <input name="title" value="' . $product->title . '" type="hidden">
                                            <input name="product" value="' . $product->id . '" type="hidden">
                                            <input type="hidden" name="shipping_cost" value="'.$product->shipping_cost.'">
                                            <input type="hidden" name="tax" value="'.$product->tax.'">
                                            <input id="cost" name="cost" value="' . Product::Cost($product->id) . '" type="hidden">
                                            <input id="quantity" name="quantity" value="1" type="hidden">';
                                    if ($product->stock != 0){
                                        $res .='<button type="button" onclick="toCart(this)" class="addTo-cart to-cart"><i class="fa fa-cart-plus"></i><span>'.trans("app.AddCart").'</span></button>';
                                    }else{
                                        $res .='<button type="button" class="addTo-cart  to-cart" disabled><i class="fa fa-cart-plus"></i>'.trans("app.OutStock").'</button>';
                                    }
                                    $res .=' 
                                            
                                        </form>
                                        <a  href="javascript:;" class="wish-list" onclick="getQuickView('.$product->id.')" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }

        }
        return $res;
    }
 

    //Search Products
    public function searchproduct($subdomain,$search)
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
       $products = Product::where('status','1')->where('company_id',$companyid)->where('title', 'like', '%' . $search . '%')
                ->get();
       return view($themename.'searchproduct', compact('products','search'));
    }

    //Tags Products
    public function tagproduct($subdomain,$tag)
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
        $products = Product::where('status','1')->where('company_id',$companyid)->where('tags', 'like', '%' . $tag . '%')
                ->get();
       return view($themename.'tagsproduct', compact('products','tag'));
    }

    public function cashondelivery(Request $request,$subdomain)
    {   

	    $companyid = get_company_id();

        $themename = get_theme_name(); 
        $settings = Settings::where('company_id', $companyid)->first();

        if(isset($request->shipping_info))
        {
            $shipping_info = 1;
        }
        else
        {
            $shipping_info = 0;
        }

        $caddress = CustomerAddress::where('customerid',$request->customer)->where('company_id',$companyid)->first();


        $customeraddress = new CustomerAddress;

                // dd($caddress);

        if($caddress != "")
        {

            
            $addressdata = array(
                'billing_firstname' => $request->customer_firstname,
                'billing_lastname' => $request->customer_lastname,
                'billing_email' => $request->email,
                'billing_phone' => $request->phone,
                'billing_address' => $request->address,
                'billing_country' => $request->country,
                'billing_state' => $request->state,
                'billing_city' => $request->city,
                'billing_zip' => $request->zip,
                'shipping_firstname' => $request->shipping_firstname,
                'shipping_lastname' => $request->shipping_lastname,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_country' => $request->shipping_country,
                'shipping_state' => $request->shipping_state,
                'shipping_city' => $request->shipping_city,
                'shipping_zip' => $request->shipping_zip,
                'shipping_info' => $shipping_info,
                'company_id' => $companyid,
            );
            DB::table('address')
                ->where('customerid', $request->customer)
                ->update($addressdata);
        }
        else
        {

            $customeraddress['customerid'] = $request->customer;
            $customeraddress['billing_firstname'] = $request->customer_firstname;
            $customeraddress['billing_lastname'] = $request->customer_lastname;
            $customeraddress['billing_email'] = $request->email;
            $customeraddress['billing_phone'] = $request->phone;
            $customeraddress['billing_address'] = $request->address;
            $customeraddress['billing_country'] = $request->country;
            $customeraddress['billing_state'] = $request->state;
            $customeraddress['billing_city'] = $request->city;
            $customeraddress['billing_zip'] = $request->zip;
            $customeraddress['shipping_firstname'] = $request->shipping_firstname;
            $customeraddress['shipping_lastname'] = $request->shipping_lastname;
            $customeraddress['shipping_email'] = $request->shipping_email;
            $customeraddress['shipping_phone'] = $request->shipping_phone;
            $customeraddress['shipping_address'] = $request->shipping_address;
            $customeraddress['shipping_country'] = $request->shipping_country;
            $customeraddress['shipping_state'] = $request->shipping_state;
            $customeraddress['shipping_city'] = $request->shipping_city;
            $customeraddress['shipping_zip'] = $request->shipping_zip;
            $customeraddress['shipping_info'] = $shipping_info;
            $customeraddress['company_id'] = $companyid;
            $customeraddress->save();
        }
        


        $order = new Order;
        $success_url = action('PaymentController@payreturn',$subdomain);
        $item_name = $settings->title." Order";
        $item_number = Str::random(7).time();
        $item_amount = $request->total;

        $request->customer;

        $order['customerid'] = $request->customer;
        $order['products'] = $request->products;
        $order['quantities'] = $request->quantities;
        $order['sizes'] = $request->sizes;
        $order['shippingmethod'] = $request->shippinginfo;
        $order['taxmethod'] = $request->taxinfo;
        $order['discount_id'] = $request->discountid;
        $order['shippingcharge'] = $request->productshipping;
        $order['tax'] = $request->producttax;
        $order['discountprice'] = $request->discountprice;
        $order['subtotal'] = $request->sub_total;
        $order['pay_amount'] = $request->total;
        $order['discount_code'] = $request->vouchercode;
        $order['method'] = "Cash On Delivery";
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_firstname'] = $request->customer_firstname;
        $order['customer_lastname'] = $request->customer_lastname;
        $order['customer_phone'] = $request->phone;
        $order['booking_date'] = date('Y-m-d H:i:s');
        $order['order_number'] = $item_number;
        $order['customer_address'] = $request->address;
        $order['customer_country'] = $request->country;
        $order['customer_state'] = $request->state;
        $order['customer_city'] = $request->city;
        $order['customer_zip'] = $request->zip;
        $order['shipping_email'] = $request->shipping_email;
        $order['shipping_firstname'] = $request->shipping_firstname;
        $order['shipping_lastname'] = $request->shipping_lastname;
        $order['shipping_phone'] = $request->shipping_phone;
        $order['shipping_address'] = $request->shipping_address;
        $order['shipping_country'] = $request->shipping_country;
        $order['shipping_state'] = $request->shipping_state;
        $order['shipping_city'] = $request->shipping_city;
        $order['shipping_zip'] = $request->shipping_zip;
        $order['order_note'] = $request->order_note;
        $order['payment_status'] = "Completed";
        $order['company_id'] =$companyid;
        $order['shipping_info'] = $shipping_info;
        $order->save();
        $orderid = $order->id;
        $pdata = explode(',',$request->products);
        $qdata = explode(',',$request->quantities);
        $sdata = explode(',',$request->sizes);


        //         $i=0;
        //         $prodectname=array();
        //         $prodectprice=array();

        //   foreach ($pdata as $data => $value)
        //  {      

        //         $a[]=$qdata[$data];
        //         $a[]=$value;
        //     $allstrok=DB::table('products')
        //         ->where('id','=',$value)
        //         ->first();
        //            $count=($allstrok->stock)-($qdata[$data]); 

        //            $a[]=$allstrok;
        //            $a[]=$count;
        //     DB::table('products')
        //            ->where('id','=',$allstrok->id)
        //            ->update([
        //                      'stock'=>$count,  
        //                     ]); 


        // }

        // dd($a);

  

         // $prodectname=implode(",",$prodectname);

      

        $company =  Company::join('cities','cities.id', '=', 'company.city')->where('company.id',$companyid)->first();
        $settings =  Settings::where('company_id',$companyid)->first();
        //print_r($company);
        $link = $request->root();
        $storename = $company->comapany_name;

        $name = $request->customer_firstname.' '.$request->customer_lastname;
        $currency = $settings->currency_sign;

        $productdetail='';
        $discountval='';

        if($settings->logo != '') 
        { 
           $logo = '<img src="'.$link.'/assets/images/company/'.$settings->logo.'" style="margin-bottom: 20px;" width="200">';
        }
        else
        {
            $logo = '';
        }
        
        $caddress = '<address><p style="margin:0px;"><span class="fw-medium font-lg mrgn-b-md show" style="font-weight:bold;margin:0px;">'.$request->name.'</span></p><p style="margin:0px;"><span class="show">'.$request->address.',</span></p><p style="margin:0px;"><span class="show">'.$request->city.' - '.$request->zip.'</span></p></address>';

        $subtotal=0;
        $grandtotal=0;

        foreach ($pdata as $data => $product){
            $proorders = new OrderedProducts();

            $productdet = Product::findOrFail($product);

                  


            if($request->shippinginfo == 'Per Product')
            {
                $shippingcharge = $productdet->shipping_cost;
                $prshipcost = '<span id="shipping_cost">Shipping Cost: '.$currency.' '.$shippingcharge.'</span>';
            }
            else if($request->shippinginfo == 'Per Order')
            { 
                $shippingcharge = null;
                $prshipcost = '';
            }

            if($request->taxinfo == 'Per Product')
            {
                $taxval = $productdet->tax;
                $totaltax = ($productdet->selling_price) * ($taxval/100);
                $prtax = '<span id="shipping_cost">Tax ('.$productdet->tax.'%): '.$currency.' '.$totaltax.'</span>';
            }
            else if($request->taxinfo == 'Per Order')
            {
                $taxval = null;
                $prtax = '';
            }
            
            $proorders['orderid'] = $orderid;
            $proorders['owner'] = $productdet->owner;
            $proorders['productid'] = $product;
            $proorders['prodectname'] =$productdet->title;
            $proorders['subtotal'] =$productdet->selling_price*$qdata[$data];

            $proorders['quantity'] = $qdata[$data];
            $proorders['size'] = $sdata[$data];
            $proorders['cost'] = $productdet->selling_price;
            $proorders['shipcost'] = $shippingcharge;
            $proorders['tax'] = $taxval;

            $proorders->save();

            $stocks = $productdet->stock - $qdata[$data];
            if ($stocks < 0){
                $stocks = 0;
            }
            $quant['stock'] = $stocks;
            $productdet->update($quant);

            $productdata = get_productdetail($product);

            $price = ($productdet->selling_price)*($qdata[$data]);
            $finalptax = $price * ($taxval/100);
            $psubtotal = $price + $shippingcharge + $finalptax;

            $imgurl = $link.'/assets/images/products/'.\App\Product::findOrFail($product)->feature_image;

            $productdetail .='<tr style="background: #f5f5f5;">
                        <td style="text-align: center;"><span><img src="'.$imgurl.'" width="100px;" height="65px;"></span></td>
                        <td style="text-align: center;">'.$productdata[0]->title.'<br>'. $prshipcost.'<br>'.$prtax.'</td>
                        <td style="text-align: center;">'.$qdata[$data].'</td>
                        <td style="text-align: center;">'.$currency.' '.$psubtotal.'</td>
                    </tr>';

        }

        Cart::where('uniqueid',Session::get('uniqueid'))->delete();

        if($request->shippinginfo  == 'Per Product' && $request->taxinfo  == 'Per Product')
        {
            $subtotal = '';
        }
        if($request->shippinginfo  == 'Per Order' || $request->taxinfo  == 'Per Order')
        {
            $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($request->sub_total, 2).'</h5>';
        }
        else if(!empty($request->vouchercode))
        {
            $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($request->sub_total, 2).'</h5>';
        }
        $voucher = Discount::where('code',$request->vouchercode)->get();

        if($request->vouchercode != '')
        {
            $vcode = '<h5>Discount - <span>('.$voucher[0]->code.') : ';
            if($voucher[0]->amounttype ==2) {
                $discount = $voucher[0]->discount;
                $discountval = '- Rs'.number_format($discount, 2);   
            } else if($voucher[0]->amounttype ==1) {
                $discount = $voucher[0]->discount;
                $discountval = $voucher[0]->discount.'% <br>- '.$currency.' '.number_format($discount, 2).'</h5>';
            }
        }
        else
        {   
            $vcode = '';
        }
        if($request->shippinginfo  == 'Per Order')
        {
            $shipcost = '<h5>Shipping : '.$currency.' '.$request->productshipping.'</h5> ';
        }
        else
        {
            $shipcost = '';
        }

        if($request->taxinfo  == 'Per Order')
        {
            if(!empty($request->vouchercode))
            {
                $tax = $request->producttax;
                $totalprice = ($request->sub_total) - ($request->discountprice) + ($request->productshipping);
                $totaltax = ($totalprice) * ($tax/100);
            }
            else
            {
                $tax = $request->producttax;
                $totalprice = ($request->sub_total) + ($request->productshipping);
                $totaltax = ($request->sub_total + $request->productshipping) * ($tax/100);
            }
            $taxcost = '<h5>Tax ('.$tax.'%) : '.$currency.' '.number_format($totaltax, 2).'</h5>';
        }
        else
        {
            $taxcost = '';
        }
        $totalprice = '<h5>Total : '.$currency.' '.$request->total.'</h5>';

        $priceval = '<h5 style="margin:0px;">'.$subtotal.'</h5>
                    <h5 style="margin:0px;">'.$vcode.' '.$discountval.'</h5>
                    <h5 style="margin:0px;">'.$shipcost.'</h5>
                    <h5 style="margin:0px;">'.$taxcost.'</h5>
                    <h5 style="margin:0px;">'.$totalprice.'</h5>';

        $emailtemplate =  Emailtemplates::where('Label','New-Order-Placed')->where('company_id',$companyid)->get();

        $find =  array('{{link}}','{{Name}}','{{OrderID}}','{{productdetail}}','{{priceval}}','{{address}}','{{logo}}','{{storename}}');
        $replace = array($link,$name,$orderid,$productdetail,$priceval,$caddress,$logo,$storename);

        $headers = "MIME-Version: 1.0\r\n"; #Define MIME Version
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $subject = str_replace($find,$replace,$emailtemplate[0]->subject);
        $message = str_replace($find,$replace,$emailtemplate[0]->content);
        //print_r($message);
       
        $to = $request->email;



        mail($to,$subject,$message,$headers);   
             
        //Sending Email To Admin
        $to = $settings->email;
        $receiveemail =  Emailtemplates::where('Label','New-Order-Recieved')->where('company_id',$companyid)->get();

        $rsubject = str_replace($find,$replace,$receiveemail[0]->subject);
        $rmessage = str_replace($find,$replace,$receiveemail[0]->content);
        //print_r($rmessage); die();

        mail($to,$rsubject,$rmessage,$headers);

        return redirect($success_url);
    }

    public function mobilemoney(Request $request,$subdomain)
    {
        $companyid = get_company_id();
        $themename = get_theme_name(); 
        $settings = Settings::where('company_id', $companyid)->first();

        if(isset($request->shipping_info))
        {
            $shipping_info = 1;
        }
        else
        {
            $shipping_info = 0;
        }

        $caddress = CustomerAddress::where('customerid',$request->customer)->where('company_id',$companyid)->first();


        $customeraddress = new CustomerAddress;

        if($caddress != null)
        {
            $addressdata = array(
                'billing_firstname' => $request->customer_firstname,
                'billing_lastname' => $request->customer_lastname,
                'billing_email' => $request->email,
                'billing_phone' => $request->phone,
                'billing_address' => $request->address,
                'billing_country' => $request->country,
                'billing_state' => $request->state,
                'billing_city' => $request->city,
                'billing_zip' => $request->zip,
                'shipping_firstname' => $request->shipping_firstname,
                'shipping_lastname' => $request->shipping_lastname,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_country' => $request->shipping_country,
                'shipping_state' => $request->shipping_state,
                'shipping_city' => $request->shipping_city,
                'shipping_zip' => $request->shipping_zip,
                'shipping_info' => $shipping_info,
                'company_id' => $companyid,
            );
            DB::table('address')
                ->where('customerid', $request->customer)
                ->update($addressdata);
        }
        else
        {
            $customeraddress['customerid'] = $request->customer;
            $customeraddress['billing_firstname'] = $request->customer_firstname;
            $customeraddress['billing_lastname'] = $request->customer_lastname;
            $customeraddress['billing_email'] = $request->email;
            $customeraddress['billing_phone'] = $request->phone;
            $customeraddress['billing_address'] = $request->address;
            $customeraddress['billing_country'] = $request->country;
            $customeraddress['billing_state'] = $request->state;
            $customeraddress['billing_city'] = $request->city;
            $customeraddress['billing_zip'] = $request->zip;
            $customeraddress['shipping_firstname'] = $request->shipping_firstname;
            $customeraddress['shipping_lastname'] = $request->shipping_lastname;
            $customeraddress['shipping_email'] = $request->shipping_email;
            $customeraddress['shipping_phone'] = $request->shipping_phone;
            $customeraddress['shipping_address'] = $request->shipping_address;
            $customeraddress['shipping_country'] = $request->shipping_country;
            $customeraddress['shipping_state'] = $request->shipping_state;
            $customeraddress['shipping_city'] = $request->shipping_city;
            $customeraddress['shipping_zip'] = $request->shipping_zip;
            $customeraddress['shipping_info'] = $shipping_info;
            $customeraddress['company_id'] = $companyid;
            $customeraddress->save();
        }

        $order = new Order;
        $success_url = action('PaymentController@payreturn',$subdomain);
        $item_name = $settings->title." Order";
        $item_number = str_random(4).time();
        $item_amount = $request->total;

        $order['customerid'] = $request->customer;
        $order['products'] = $request->products;
        $order['quantities'] = $request->quantities;
        $order['sizes'] = $request->sizes;
        $order['shippingmethod'] = $request->shippinginfo;
        $order['taxmethod'] = $request->taxinfo;
        $order['discount_id'] = $request->discountid;
        $order['shippingcharge'] = $request->productshipping;
        $order['tax'] = $request->producttax;
        $order['discountprice'] = $request->discountprice;
        $order['subtotal'] = $request->sub_total;
        $order['pay_amount'] = $request->total;
        $order['discount_code'] = $request->vouchercode;
        $order['method'] = "Mobile Money";
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_firstname'] = $request->customer_firstname;
        $order['customer_lastname'] = $request->customer_lastname;
        $order['customer_phone'] = $request->phone;
        $order['booking_date'] = date('Y-m-d H:i:s');
        $order['order_number'] = $item_number;
        $order['customer_address'] = $request->address;
        $order['customer_country'] = $request->country;
        $order['customer_state'] = $request->state;
        $order['customer_city'] = $request->city;
        $order['customer_zip'] = $request->zip;
        $order['shipping_email'] = $request->shipping_email;
        $order['shipping_firstname'] = $request->shipping_firstname;
        $order['shipping_lastname'] = $request->shipping_lastname;
        $order['shipping_phone'] = $request->shipping_phone;
        $order['shipping_address'] = $request->shipping_address;
        $order['shipping_country'] = $request->shipping_country;
        $order['shipping_state'] = $request->shipping_state;
        $order['shipping_city'] = $request->shipping_city;
        $order['shipping_zip'] = $request->shipping_zip;
        $order['order_note'] = $request->order_note;
        $order['txnid'] = $request->txn_id;
        $order['payment_status'] = "Completed";
        $order['company_id'] = $companyid;
        $order['shipping_info'] = $shipping_info;
        $order->save();
        $orderid = $order->id;
        $pdata = explode(',',$request->products);
        $qdata = explode(',',$request->quantities);
        $sdata = explode(',',$request->sizes);

        //           $i=0;
        //         $prodectname=array();
        //         $prodectprice=array();
        //   foreach ($pdata as $value)
        //  {  

        //       $allstrok= Product::where('id',$value)->first(); 

        //       $prodectname[]=$allstrok->title;


        //         $demo=$allstrok->stock-$qdata[$i];
        //         $pricedata=$allstrok->price*$qdata[$i];
                

        //             $data['stock']=$demo;
        //              $allstrok->update($data);
        //         $i++;

        // }

        //  $prodectname=implode(",",$prodectname);

        $company =  Company::join('cities','cities.id', '=', 'company.city')->where('company.id',$companyid)->first();
        $settings =  Settings::where('company_id',$companyid)->first();
        //print_r($company);
        $link = $request->root();
        $storename = $company->comapany_name;

        $name = $request->customer_firstname.' '.$request->customer_lastname;

        $productdetail='';
        $discountval='';

        if($settings->logo != '') { 
           $logo = '<img src="'.$link.'/assets/images/company/'.$settings->logo.'" style="margin-bottom: 20px;" width="200">';
        }
        else{
            $logo = '';
        }
        
        $caddress = '<address><p style="margin:0px;"><span class="fw-medium font-lg mrgn-b-md show" style="font-weight:bold;margin:0px;">'.$request->name.'</span></p><p style="margin:0px;"><span class="show">'.$request->address.',</span></p><p style="margin:0px;"><span class="show">'.$request->city.' - '.$request->zip.'</span></p></address>';

        $subtotal=0;
        $grandtotal=0;

        foreach ($pdata as $data => $product){
            $proorders = new OrderedProducts();

            $productdet = Product::findOrFail($product);

            if($request->shippinginfo == 'Per Product')
            {
                $shippingcharge = $productdet->shipping_cost;
                $prshipcost = '<span id="shipping_cost">Shipping Cost: '.$currency.' '.$shippingcharge.'</span>';
            }
            else if($request->shippinginfo == 'Per Order')
            {
                $shippingcharge = null;
                $prshipcost = '';
            }

            if($request->taxinfo == 'Per Product')
            {
                $taxval = $productdet->tax;
                $totaltax = ($productdet->selling_price) * ($taxval/100);
                $prtax = '<span id="shipping_cost">Tax ('.$productdet->tax.'%): '.$currency.' '.$totaltax.'</span>';
            }
            else if($request->taxinfo == 'Per Order')
            {
                $taxval = null;
                $prtax = '';
            }

            $proorders['orderid'] = $orderid;
            $proorders['owner'] = $productdet->owner;
            $proorders['productid'] = $product;
            $proorders['prodectname'] =$productdet->title;
            $proorders['subtotal'] =$productdet->selling_price*$qdata[$data];
            $proorders['quantity'] = $qdata[$data];
            $proorders['size'] = $sdata[$data];
            $proorders['cost'] = $productdet->selling_price;
            $proorders['shipcost'] = $shippingcharge;
            $proorders['tax'] = $taxval;
            $proorders->save();

            $stocks = $productdet->stock - $qdata[$data];
            if ($stocks < 0){
                $stocks = 0;
            }
            $quant['stock'] = $stocks;
            $productdet->update($quant);
                
            $productdata = get_productdetail($product);

            $price = ($productdet->selling_price)*($qdata[$data]);
            $finalptax = $price * ($taxval/100);
            $psubtotal = $price + $shippingcharge + $finalptax;

            $imgurl = $link.'/assets/images/products/'.\App\Product::findOrFail($product)->feature_image;

            $productdetail .='<tr style="background: #f5f5f5;">
                        <td style="text-align: center;"><span><img src="'.$imgurl.'" width="100px;" height="65px;"></span></td>
                        <td style="text-align: center;">'.$productdata[0]->title.'<br>'. $prshipcost.'<br>'.$prtax.'</td>
                        <td style="text-align: center;">'.$qdata[$data].'</td>
                        <td style="text-align: center;">'.$currency.' '.$psubtotal.'</td>
                    </tr>';
            
            
        }

        Cart::where('uniqueid',Session::get('uniqueid'))->delete();

        if($request->shippinginfo  == 'Per Product' && $request->taxinfo  == 'Per Product')
        {
            $subtotal = '';
        }
        if($request->shippinginfo  == 'Per Order' || $request->taxinfo  == 'Per Order')
        {
            $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($request->sub_total, 2).'</h5>';
        }
        else if(!empty($request->vouchercode))
        {
            $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($request->sub_total, 2).'</h5>';
        }
        $voucher = Discount::where('code',$request->vouchercode)->get();

        if($request->vouchercode != '')
        {
            $vcode = '<h5>Discount - <span>('.$voucher[0]->code.') : &nbsp';
            if($voucher[0]->amounttype ==2) {
                $discount = $voucher[0]->discount;
                $discountval = '- ₹'.number_format($discount, 2);   
            } else if($voucher[0]->amounttype ==1) {
                echo $discount = $voucher[0]->discount;
                $discountval = $voucher[0]->discount.'% <br>- '.$currency.' '.number_format($discount, 2).'</h5>';
            }
        }
        else
        {
            $vcode = '';
        }
        if($request->shippinginfo  == 'Per Order')
        {
            $shipcost = '<h5>Shipping : '.$currency.' '.$request->productshipping.'</h5> ';
        }
        else
        {
            $shipcost = '';
        }

        if($request->taxinfo  == 'Per Order')
        {
            if(!empty($request->vouchercode))
            {
                $tax = $request->producttax;
                $totalprice = ($request->sub_total) - ($request->discountprice) + ($request->productshipping);
                $totaltax = ($totalprice) * ($tax/100);
            }
            else
            {
                $tax = $request->producttax;
                $totalprice = ($request->sub_total) + ($request->productshipping);
                $totaltax = ($request->sub_total + $request->productshipping) * ($tax/100);
            }
            $taxcost = '<h5>Tax ('.$tax.'%) : '.$currency.' '.number_format($totaltax, 2).'</h5>';
        }
        else
        {
            $taxcost = '';
        }
        $totalprice = '<h5>Total : '.$currency.' '.$request->total.'</h5>';

        $priceval = '<h5 style="margin:0px;">'.$subtotal.'</h5>
                    <h5 style="margin:0px;">'.$vcode.' '.$discountval.'</h5>
                    <h5 style="margin:0px;">'.$shipcost.'</h5>
                    <h5 style="margin:0px;">'.$taxcost.'</h5>
                    <h5 style="margin:0px;">'.$totalprice.'</h5>';
        
        //Sending Email To Buyer
        $emailtemplate =  Emailtemplates::where('Label','New-Order-Placed')->where('company_id',$companyid)->get();

        $find =  array('{{link}}','{{Name}}','{{OrderID}}','{{productdetail}}','{{priceval}}','{{address}}','{{logo}}','{{storename}}');
        $replace = array($link,$name,$orderid,$productdetail,$priceval,$caddress,$logo,$storename);

        $headers = "MIME-Version: 1.0\r\n"; #Define MIME Version
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $subject = str_replace($find,$replace,$emailtemplate[0]->subject);
        $message = str_replace($find,$replace,$emailtemplate[0]->content);
        $to = $request->email;
		
		mail($to,$subject,$message,$headers);   
		     
        //Sending Email To Admin
        $to = $settings->email;
        $receiveemail =  Emailtemplates::where('Label','New-Order-Recieved')->where('company_id',$companyid)->get();

        $rsubject = str_replace($find,$replace,$receiveemail[0]->subject);
        $rmessage = str_replace($find,$replace,$receiveemail[0]->content);
        
        mail($to,$rsubject,$rmessage,$headers);
		
        return redirect($success_url);
    }

    public function bankwire(Request $request,$subdomain)
    {
        $companyid = get_company_id();
        $themename = get_theme_name();
        $settings = Settings::where('company_id', $companyid)->first();

        if(isset($request->shipping_info))
        {
            $shipping_info = 1;
        }
        else
        {
            $shipping_info = 0;
        }

        $caddress = CustomerAddress::where('customerid',$request->customer)->where('company_id',$companyid)->first();


        $customeraddress = new CustomerAddress;

        if($caddress != null)
        {
            $addressdata = array(
                'billing_firstname' => $request->customer_firstname,
                'billing_lastname' => $request->customer_lastname,
                'billing_email' => $request->email,
                'billing_phone' => $request->phone,
                'billing_address' => $request->address,
                'billing_country' => $request->country,
                'billing_state' => $request->state,
                'billing_city' => $request->city,
                'billing_zip' => $request->zip,
                'shipping_firstname' => $request->shipping_firstname,
                'shipping_lastname' => $request->shipping_lastname,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_country' => $request->shipping_country,
                'shipping_state' => $request->shipping_state,
                'shipping_city' => $request->shipping_city,
                'shipping_zip' => $request->shipping_zip,
                'shipping_info' => $shipping_info,
                'company_id' => $companyid,
            );
            DB::table('address')
                ->where('customerid', $request->customer)
                ->update($addressdata);
        }
        else
        {
            $customeraddress['customerid'] = $request->customer;
            $customeraddress['billing_firstname'] = $request->customer_firstname;
            $customeraddress['billing_lastname'] = $request->customer_lastname;
            $customeraddress['billing_email'] = $request->email;
            $customeraddress['billing_phone'] = $request->phone;
            $customeraddress['billing_address'] = $request->address;
            $customeraddress['billing_country'] = $request->country;
            $customeraddress['billing_state'] = $request->state;
            $customeraddress['billing_city'] = $request->city;
            $customeraddress['billing_zip'] = $request->zip;
            $customeraddress['shipping_firstname'] = $request->shipping_firstname;
            $customeraddress['shipping_lastname'] = $request->shipping_lastname;
            $customeraddress['shipping_email'] = $request->shipping_email;
            $customeraddress['shipping_phone'] = $request->shipping_phone;
            $customeraddress['shipping_address'] = $request->shipping_address;
            $customeraddress['shipping_country'] = $request->shipping_country;
            $customeraddress['shipping_state'] = $request->shipping_state;
            $customeraddress['shipping_city'] = $request->shipping_city;
            $customeraddress['shipping_zip'] = $request->shipping_zip;
            $customeraddress['shipping_info'] = $shipping_info;
            $customeraddress['company_id'] = $companyid;
            $customeraddress->save();
        }
        $order = new Order;
        $success_url = action('PaymentController@payreturn',$subdomain);
        $item_name = $settings->title." Order";
        $item_number = str_random(4).time();
        $item_amount = $request->total;
        $order['customerid'] = $request->customer;
        $order['products'] = $request->products;
        $order['quantities'] = $request->quantities;
        $order['sizes'] = $request->sizes;
        $order['shippingmethod'] = $request->shippinginfo;
        $order['taxmethod'] = $request->taxinfo;
        $order['discount_id'] = $request->discountid;
        $order['shippingcharge'] = $request->productshipping;
        $order['tax'] = $request->producttax;
        $order['discountprice'] = $request->discountprice;
        $order['subtotal'] = $request->sub_total;
        $order['pay_amount'] = $request->total;
        $order['discount_code'] = $request->vouchercode;
        $order['method'] = "Bank Wire";
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_firstname'] = $request->customer_firstname;
        $order['customer_lastname'] = $request->customer_lastname;
        $order['customer_phone'] = $request->phone;
        $order['booking_date'] = date('Y-m-d H:i:s');
        $order['order_number'] = $item_number;
        $order['customer_address'] = $request->address;
        $order['customer_country'] = $request->country;
        $order['customer_state'] = $request->state;
        $order['customer_city'] = $request->city;
        $order['customer_zip'] = $request->zip;
        $order['shipping_email'] = $request->shipping_email;
        $order['shipping_firstname'] = $request->shipping_firstname;
        $order['shipping_lastname'] = $request->shipping_lastname;
        $order['shipping_phone'] = $request->shipping_phone;
        $order['shipping_address'] = $request->shipping_address;
        $order['shipping_country'] = $request->shipping_country;
        $order['shipping_state'] = $request->shipping_state;
        $order['shipping_city'] = $request->shipping_city;
        $order['shipping_zip'] = $request->shipping_zip;
        $order['order_note'] = $request->order_note;
        $order['txnid'] = $request->txn_id;
        $order['payment_status'] = "Completed";
        $order['company_id'] =$companyid;
        $order['shipping_info'] = $shipping_info;
        $order->save();
        $orderid = $order->id;
        $pdata = explode(',',$request->products);
        $qdata = explode(',',$request->quantities);
        $sdata = explode(',',$request->sizes);

        //    $i=0;
        //         $prodectname=array();
        //         $prodectprice=array();
        //   foreach ($pdata as $value)
        //  {  

        //       $allstrok= Product::where('id',$value)->first(); 

        //       $prodectname[]=$allstrok->title;


        //         $demo=$allstrok->stock-$qdata[$i];
        //         $pricedata=$allstrok->price*$qdata[$i];
                

        //             $data['stock']=$demo;
        //              $allstrok->update($data);
        //         $i++;

        // }

        //  $prodectname=implode(",",$prodectname);

        $company =  Company::join('cities','cities.id', '=', 'company.city')->where('company.id',$companyid)->first();
        $settings =  Settings::where('company_id',$companyid)->first();
        //print_r($company);
        $link = $request->root();
        $storename = $company->comapany_name;

        $name = $request->customer_firstname.' '.$request->customer_lastname;

        $productdetail='';
        $discountval='';

        if($settings->logo != '') { 
           $logo = '<img src="'.$link.'/assets/images/company/'.$settings->logo.'" style="margin-bottom: 20px;" width="200">';
        }
        else{
            $logo = '';
        }
        
        $caddress = '<address><p style="margin:0px;"><span class="fw-medium font-lg mrgn-b-md show" style="font-weight:bold;margin:0px;">'.$request->name.'</span></p><p style="margin:0px;"><span class="show">'.$request->address.',</span></p><p style="margin:0px;"><span class="show">'.$request->city.' - '.$request->zip.'</span></p></address>';

        $subtotal=0;
        $grandtotal=0;

        foreach ($pdata as $data => $product){
            $proorders = new OrderedProducts();

            $productdet = Product::findOrFail($product);

            if($request->shippinginfo == 'Per Product')
            {
                $shippingcharge = $productdet->shipping_cost;
                $prshipcost = '<span id="shipping_cost">Shipping Cost: '.$currency.' '.$shippingcharge.'</span>';
            }
            else if($request->shippinginfo == 'Per Order')
            {
                $shippingcharge = null;
                $prshipcost = '';
            }

            if($request->taxinfo == 'Per Product')
            {
                $taxval = $productdet->tax;
                $totaltax = ($productdet->selling_price) * ($taxval/100);
                $prtax = '<span id="shipping_cost">Tax ('.$productdet->tax.'%): '.$currency.' '.$totaltax.'</span>';
            }
            else if($request->taxinfo == 'Per Order')
            {
                $taxval = null;
                $prtax = '';
            }

            $proorders['orderid'] = $orderid;
            $proorders['owner'] = $productdet->owner;
            $proorders['productid'] = $product;
            $proorders['prodectname'] =$productdet->title;
            $proorders['subtotal'] =$productdet->selling_price*$qdata[$data];
            $proorders['quantity'] = $qdata[$data];
            $proorders['size'] = $sdata[$data];
            $proorders['cost'] = $productdet->selling_price;
            $proorders['shipcost'] = $shippingcharge;
            $proorders['tax'] = $taxval;
            $proorders->save();

            $stocks = $productdet->stock - $qdata[$data];
            if ($stocks < 0){
                $stocks = 0;
            }
            $quant['stock'] = $stocks;
            $productdet->update($quant);
                    
            $productdata = get_productdetail($product);

            $price = ($productdet->selling_price)*($qdata[$data]);
            $finalptax = $price * ($taxval/100);
            $psubtotal = $price + $shippingcharge + $finalptax;

            $imgurl = $link.'/assets/images/products/'.\App\Product::findOrFail($product)->feature_image;

            $productdetail .='<tr style="background: #f5f5f5;">
                        <td style="text-align: center;"><span><img src="'.$imgurl.'" width="100px;" height="65px;"></span></td>
                        <td style="text-align: center;">'.$productdata[0]->title.'<br>'. $prshipcost.'<br>'.$prtax.'</td>
                        <td style="text-align: center;">'.$qdata[$data].'</td>
                        <td style="text-align: center;">'.$currency.' '.$psubtotal.'</td>
                    </tr>';
            
            
        }

        Cart::where('uniqueid',Session::get('uniqueid'))->delete();

        if($request->shippinginfo  == 'Per Product' && $request->taxinfo  == 'Per Product')
        {
            $subtotal = '';
        }
        if($request->shippinginfo  == 'Per Order' || $request->taxinfo  == 'Per Order')
        {
            $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($request->sub_total, 2).'</h5>';
        }
        else if(!empty($request->vouchercode))
        {
            $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($request->sub_total, 2).'</h5>';
        }
        $voucher = Discount::where('code',$request->vouchercode)->get();

        if($request->vouchercode != '')
        {
            $vcode = '<h5>Discount - <span>('.$voucher[0]->code.') : &nbsp';
            if($voucher[0]->amounttype ==2) {
                $discount = $voucher[0]->discount;
                $discountval = '- ₹'.number_format($discount, 2);   
            } else if($voucher[0]->amounttype ==1) {
                echo $discount = $voucher[0]->discount;
                $discountval = $voucher[0]->discount.'% <br>- '.$currency.' '.number_format($discount, 2).'</h5>';
            }
        }
        else
        {
            $vcode = '';
        }
        if($request->shippinginfo  == 'Per Order')
        {
            $shipcost = '<h5>Shipping : '.$currency.' '.$request->productshipping.'</h5> ';
        }
        else
        {
            $shipcost = '';
        }

        if($request->taxinfo  == 'Per Order')
        {
            if(!empty($request->vouchercode))
            {
                $tax = $request->producttax;
                $totalprice = ($request->sub_total) - ($request->discountprice) + ($request->productshipping);
                $totaltax = ($totalprice) * ($tax/100);
            }
            else
            {
                $tax = $request->producttax;
                $totalprice = ($request->sub_total) + ($request->productshipping);
                $totaltax = ($request->sub_total + $request->productshipping) * ($tax/100);
            }
            $taxcost = '<h5>Tax ('.$tax.'%) : '.$currency.' '.number_format($totaltax, 2).'</h5>';  
        }
        else
        {
            $taxcost = '';
        }
        $totalprice = '<h5>Total : '.$currency.' '.$request->total.'</h5>';

        $priceval = '<h5 style="margin:0px;">'.$subtotal.'</h5>
                    <h5 style="margin:0px;">'.$vcode.' '.$discountval.'</h5>
                    <h5 style="margin:0px;">'.$shipcost.'</h5>
                    <h5 style="margin:0px;">'.$taxcost.'</h5>
                    <h5 style="margin:0px;">'.$totalprice.'</h5>';
        
        //Sending Email To Buyer
        $emailtemplate =  Emailtemplates::where('Label','New-Order-Placed')->where('company_id',$companyid)->get();

        $find =  array('{{link}}','{{Name}}','{{OrderID}}','{{productdetail}}','{{priceval}}','{{address}}','{{logo}}','{{storename}}');
        $replace = array($link,$name,$orderid,$productdetail,$priceval,$caddress,$logo,$storename);

        $headers = "MIME-Version: 1.0\r\n"; #Define MIME Version
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $subject = str_replace($find,$replace,$emailtemplate[0]->subject);
        $message = str_replace($find,$replace,$emailtemplate[0]->content);
        $to = $request->email;
        
        mail($to,$subject,$message,$headers);    
		     
        //Sending Email To Admin
        $to = $settings->email;
        $receiveemail =  Emailtemplates::where('Label','New-Order-Recieved')->where('company_id',$companyid)->get();

        $rsubject = str_replace($find,$replace,$receiveemail[0]->subject);
        $rmessage = str_replace($find,$replace,$receiveemail[0]->content);
        
        mail($to,$rsubject,$rmessage,$headers);
		
        return redirect($success_url);
    }

    //Product Quick View
    public function getProduct($subdomain,$id)
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
        $language = SiteLanguage::where('company_id', $companyid)->first();
        $profiledata = Product::where('company_id', $companyid)->where('id', $id)->first();
        $data = '<div class="col-md-3 col-sm-12">
                    <div class="product-review-details-img">
                        <img src="' . url('/') . '/assets/images/products/' . $profiledata->feature_image . '" alt="">
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="product-review-details-description">
                        <h3>' . $profiledata->title . '</h3>
                        <div class="ratings">
                            <div class="empty-stars"></div>
                            <div class="full-stars" style="width:' . Review::ratings($profiledata->id) . '%"></div>
                        </div>
                        <div class="product-price">
                            <div class="single-product-price">
                                $' . $profiledata->price . '
                            </div>
                            <div class="product-availability">';
                                if ($profiledata->stock != 0 || $profiledata->stock === null) {
                                    $data .= '<span class="available">
                                                    <i class="fa fa-check-square-o"></i>
                                                    <span>' . trans("app.Available") . '</span>
                                                </span>';
                                }else{
                                    $data .= '<span class="not-available">
                                        <i class="fa fa-times-circle-o"></i>
                                        <span>' . trans("app.OutStock").'</span>
                                        </span>';
                                }
                            $data .='</div>
                        </div>
                        <div class="product-review-description">
                            <h4>'.trans("app.QuickReview").'</h4>
                            <p>'.$profiledata->description.'</p>
                        </div>
                        <div class="product-quantity">
                            <a href="'.url('/').'/product/'.$profiledata->id.'/'.str_replace(' ','-',strtolower($profiledata->title)).'" class="addToCart-btn">'.trans("app.ViewDetails").'</a>
                        </div>
                    </div>
                </div>';
        return $data;
    }

    //Profile Data
    public function account()
    {
        //$profiledata = UserProfile::findOrFail($id);
       $themename = get_theme_name();
        return view($themename.'account');
    }

    //Contact Page Data
    public function contact()
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
        $pagedata = PageSettings::where('company_id', $companyid)->first();

        $meta = Seosetion::where('slug','contact-us')->first();
		
        return view($themename.'contact', compact('pagedata','meta'));
    }

    //About Page Data
    public function about()
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
        $pagedata = PageSettings::where('company_id', $companyid)->first();
            $meta = Seosetion::where('slug','about-us')->first();
        
        return view($themename.'about', compact('pagedata','meta'));
    }

    //FAQ Page Data
    public function faq()
    {
		$companyid = get_company_id();
        $themename = get_theme_name();  
        $pagedata = PageSettings::where('company_id', $companyid)->first();
		$faqs = FAQ::where('company_id', $companyid)->get();
         $meta = Seosetion::where('slug','faq')->first();
        return view($themename.'faq', compact('pagedata','faqs','meta'));
    }

    //Show Category Users
    public function category($subdomain,$category)
    {
		$companyid = get_company_id();
        $themename = get_theme_name(); 
        $categories = Category::where('company_id', $companyid)->where('slug', $category)->first();
        $services = Service::where('status', 1)
            ->where('category', $categories->id)
			->where('company_id', $companyid)
            ->get();
        $pagename = "All Sevices in: ".ucwords($categories->name);
        return view($themename.'services', compact('services','pagename','categories'));
    }


    //Show Cart
    public function cart()
    {

		$companyid = get_company_id();
        $themename = get_theme_name(); 
        $sum = 0.00;
        $carts = new \stdClass();
        if (Session::has('uniqueid')){
            $carts = Cart::where('uniqueid', Session::get('uniqueid'))->where('company_id', $companyid)->get();
            $sum = Cart::where('uniqueid', Session::get('uniqueid'))->where('company_id', $companyid)->sum('cost');
        }
        
        // dd($carts,$sum);
        return view($themename.'cart', compact('carts','sum'));
    }

    // public function header()
    // {
    //     $sum = 0.00;
    //     $carts = new \stdClass();
    //     if (Session::has('uniqueid')){
    //         $carts = Cart::where('uniqueid', Session::get('uniqueid'))->get();
    //         $sum = Cart::where('uniqueid', Session::get('uniqueid'))->sum('cost');
    //     }
    //     return view('includes.newmaster', compact('carts','sum'));
    // }

    //User Subscription
    public function subscribe(Request $request)
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
        $exist = Subscribers::where('email',$request->email)->where('company_id', $companyid);

        if ($exist->count() > 0){
            echo json_encode('fail');
        }else{
            $subscribe = new Subscribers;
            $subscribe->fill($request->all());
			$subscribe['company_id'] =$companyid;
            $subscribe->save();
            echo json_encode('success');
        }
    }

    //Send email to Admin
    public function contactmail(Request $request)
    {
		$companyid = get_company_id();
        $themename = get_theme_name();
		$Contactus = new Contactus();
        $Contactus->fill($request->all()); 
		
		$pagedata = PageSettings::where('company_id', $companyid)->first();
        $setting = Settings::where('company_id', $companyid)->first();
		
        $subject = "Contact From Of ".$setting->title;
        $to = $request->to;
        $name = $request->name;
        $phone = $request->phone;
        $from = $request->email;
        $msg = "Name: ".$name."\nEmail: ".$from."\nPhone: ".$request->phone."\nMessage: ".$request->message;
		
		$Contactus['company_id'] = $companyid;
        
        if(isset($Contactus['status']))
        {
            $Contactus['status'] = 1;
        }
        else
        {
            $Contactus['status'] = 0;
        }

        $Contactus->save();	
		
        mail($to,$subject,$msg);
         
        Session::flash('cmail', $pagedata->contact);
        return redirect('/contact');
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

