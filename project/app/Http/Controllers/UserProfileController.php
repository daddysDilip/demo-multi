<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Product;
use App\Review;
use App\Settings;
use App\UserProfile;
use App\PickUpLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Discount;
use PDF;
use App\OrderedProducts;
use App\Country;
use App\State;
use App\City;
use App\CustomerAddress;
use DB;

class UserProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:profile',['except' => 'checkout','cashondelivery']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $themename = get_theme_name();
        $user = UserProfile::find(Auth::user()->id);
        $address = CustomerAddress::where('customerid', Auth::user()->id)->first();
        return view($themename.'account',compact('user','address'));
    }

    public function accinfo()
    {
        $themename = get_theme_name();
        $user = UserProfile::find(Auth::user()->id);
        return view($themename.'accountedit',compact('user'));
    }


    public function billinginfo()
    {
        $themename = get_theme_name();
        $billingadd = CustomerAddress::where('customerid', Auth::user()->id)->first();
        $country = Country::where('status','1')->get();
        $state = State::where('status','1')->where('countryid',$billingadd->billing_country)->get();
        $city = City::where('status','1')->where('stateid',$billingadd->billing_state)->get();
        return view($themename.'editbillingaddress',compact('billingadd','country','state','city'));
    }

    public function shippinginfo()
    {
        $themename = get_theme_name();
        $shippingadd = CustomerAddress::where('customerid', Auth::user()->id)->first();
        $country = Country::where('status','1')->get();
        $state = State::where('status','1')->where('countryid',$shippingadd->shipping_country)->get();
        $city = City::where('status','1')->where('stateid',$shippingadd->shipping_state)->get();
        return view($themename.'editshippingaddress',compact('shippingadd','country','state','city'));
    }

    public function editbilling(Request $request, $subdomain)
    {
        $id = Auth::user()->id;
        $addressdata = array(
            'billing_firstname' => $request->billing_firstname,
            'billing_lastname' => $request->billing_lastname,
            'billing_email' => $request->billing_email,
            'billing_phone' => $request->billing_phone,
            'billing_address' => $request->billing_address,
            'billing_country' => $request->billing_country,
            'billing_state' => $request->billing_state,
            'billing_city' => $request->billing_city,
            'billing_zip' => $request->billing_zip,
        );
        DB::table('address')
            ->where('customerid', $id)
            ->update($addressdata);
        return redirect()->back()->with('message',trans("app.UpdateBillingAddressMsg"));
    }

    public function editshipping(Request $request, $subdomain)
    {
        $id = Auth::user()->id;
        $addressdata = array(
            'shipping_firstname' => $request->shipping_firstname,
            'shipping_lastname' => $request->shipping_lastname,
            'shipping_email' => $request->shipping_email,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_country' => $request->shipping_country,
            'shipping_state' => $request->shipping_state,
            'shipping_city' => $request->shipping_city,
            'shipping_zip' => $request->shipping_zip,
        );
        DB::table('address')
            ->where('customerid', $id)
            ->update($addressdata);
        return redirect()->back()->with('message',trans("app.UpdateShippingAddressMsg"));
    }

    public function userchangepass()
    {
        $themename = get_theme_name();
        $user = UserProfile::find(Auth::user()->id);
        return view($themename.'userchangepass',compact('user'));
    }

    public function customerdetail(Request $request)
    {
        $productid = $request['pid'];
        $user = UserProfile::find(Auth::user()->id);
        $id = $user->id;
      
        $data['purchaseproduct'] = Order::join('ordered_products','orders.id','=','ordered_products.orderid')->where('productid',$productid)->where('customerid',$user->id)->get();
        
        echo json_encode($data);
    }

    public function userorders()
    {

        $themename = get_theme_name();
        $user = UserProfile::find(Auth::user()->id);
        $orders = Order::where('customerid', Auth::user()->id)->orderBy('id','desc')->get();
        return view($themename.'userorders',compact('user','orders'));
    }

    public function userorderdetails($subdomain,$id)
    { 
        // dd('innnn');
        $themename = get_theme_name();
        $user = UserProfile::find(Auth::user()->id);
        $order = Order::findOrFail($id);
        $orderproduct = OrderedProducts::where('orderid', $id)->get();
        $discount = Discount::where('id', $order->discount_id)->get();
        return view($themename.'orderdetails',compact('user','order','orderproduct','discount'));
    }

    public function orderdetailspdf(Request $request,$subdomain,$id)
    {
        $themename = get_theme_name();
        $user = UserProfile::find(Auth::user()->id);
        $order = Order::findOrFail($id);
        $orderproduct = OrderedProducts::where('orderid', $id)->get();
        $discount = Discount::where('id', $order->discount_id)->get();



        $pdf=PDF::loadView($themename.'pdfview', compact('user','order','orderproduct','discount'));
        //return $pdf->stream('pdfview.pdf');
        return $pdf->download('order.pdf');
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


    //Submit Review
    public function checkout()
    {
        
        $themename = get_theme_name();
        $companyid = get_company_id();
        if(Auth::guard('profile')->user())
        {
            $currentdate=date('Y-m-d');
            $pickups = PickUpLocations::where('status',1)->where('company_id',$companyid)->get();
            $product = 0;
            $quantity = 0;
            $sizes = 0;
            $settings = Settings::where('company_id',$companyid)->first();
            $discount = Discount::where('enddate','>=',$currentdate)->where('status',1)->where('company_id',$companyid)->get();

            $address = CustomerAddress::where('customerid',Auth::guard('profile')->user()->id)->first();
            $country = Country::where('status','1')->get();

            if(count($address) > 0)
            {
                $billingstate = State::where('status','1')->where('countryid',$address->billing_country)->get();
                $billingcity = City::where('status','1')->where('stateid',$address->billing_state)->get();

                $shippingstate = State::where('status','1')->where('countryid',$address->shipping_country)->get();
                $shippingcity = City::where('status','1')->where('stateid',$address->shipping_state)->get();
            }
            /*else
            {
                $billingstate = State::where('status','1')->get();
                $billingcity = City::where('status','1')->get();

                $shippingstate = State::where('status','1')->get();
                $shippingcity = City::where('status','1')->get();
            }*/
            
            $carts = Cart::where('uniqueid',Session::get('uniqueid'));
            $cartdata = $carts->get();
            if($carts->count() > 0){
                $total = $carts->sum('cost') + $settings->shipping_cost;
                foreach ($carts->get() as $cart){
                    if ($product==0 && $quantity==0){
                        $product = $cart->product;
                        $quantity = $cart->quantity;
                        $sizes = $cart->size;
                    }else{
                        $product = $product.",".$cart->product;
                        $quantity = $quantity.",".$cart->quantity;
                        $sizes = $sizes.",".$cart->size;
                    }
                }

                return view($themename.'checkout',compact('product','sizes','quantity','total','cartdata','user','pickups','discount','country','billingstate','billingcity','shippingstate','shippingcity','address'));
            }
        }
        else
        {
            return view($themename.'checkout');
        }


            

        return redirect('/cart')->with('message',trans("app.NoProductCheckoutMsg"));
    }

    public function state_list(Request $request){

        $countryid = $request->input('countryid');
        $state = State::where('status','1')->where('countryid',$countryid)->get();
        $options='<option value="">' . trans("app.SelectState") . '</option>';
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
        $options='<option value="">' . trans("app.SelectCity") . '</option>';
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
        $user = UserProfile::findOrFail($id);
        $input = $request->all();
        $user->update($input);
        return redirect()->back()->with('message',trans("app.UpdateAccountInfoMsg"));
    }

    public function old_password(Request $request)
    {
        $id = $request->input('id');
        $user = UserProfile::find(Auth::user()->id);
        $cpass = $request->input('cpass');

        if ($cpass){
            if (Hash::check($cpass, $user->password)){
                echo json_encode(true);
            }
            else
            {
                echo json_encode(false);
            }
        }
    }

    public function passchange(Request $request, $subdomain,$id)
    {
        $user = UserProfile::findOrFail($id);
        $input['password'] = "";
        if ($request->cpass){
            if (Hash::check($request->cpass, $user->password)){
                
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    Session::flash('error', trans("app.ConfirmPassNoMatchMsg"));
                    return redirect()->back();
                }
            }else{
                Session::flash('error', trans("app.CurrentPassNoMatchMsg"));
                return redirect()->back();
            }
        }
        $user->update($input);
        return redirect()->back()->with('message',trans("app.UpdateAccountPasswordMsg"));
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
