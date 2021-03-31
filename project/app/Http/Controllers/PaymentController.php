<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\PricingTable;
use App\Product;
use App\Settings;
use App\OrderedProducts;
use Illuminate\Http\Request;
use Session;
use App\CustomerAddress;
use DB;

class PaymentController extends Controller
{


 public function store(Request $request,$subdomain){

    $companyid = get_company_id();

    $settings = Settings::where('company_id',$companyid)->first();

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
    $paypal_email = $settings->paypal_business;
    $return_url = action('PaymentController@payreturn',$subdomain);
    $cancel_url = action('PaymentController@paycancle',$subdomain);
    $notify_url = action('PaymentController@notify',$subdomain);

    $item_name = $settings->title." Order";
    $item_number = str_random(4).time();
    $item_amount = $request->total;
    $querystring = '';

    // Firstly Append paypal account to querystring
    $querystring .= "?business=".urlencode($paypal_email)."&";

    // Append amount& currency (£) to quersytring so it cannot be edited in html

    //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
    $querystring .= "item_name=".urlencode($item_name)."&";
    $querystring .= "amount=".urlencode($item_amount)."&";
    $querystring .= "item_number=".urlencode($item_number)."&";

    $querystring .= "cmd=".urlencode(stripslashes($request->cmd))."&";
    $querystring .= "bn=".urlencode(stripslashes($request->bn))."&";
    $querystring .= "lc=".urlencode(stripslashes($request->lc))."&";
    $querystring .= "currency_code=".urlencode(stripslashes($request->currency_code))."&";

     // Append paypal return addresses
    $querystring .= "return=".urlencode(stripslashes($return_url))."&";
    $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
    $querystring .= "notify_url=".urlencode($notify_url)."&";

    $querystring .= "custom=".$request->customer;

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
        $order['method'] = "Paypal";
        $order['booking_date'] = date('Y-m-d H:i:s');
        $order['order_number'] = $item_number;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_firstname'] = $request->customer_firstname;
        $order['customer_lastname'] = $request->customer_lastname;
        $order['customer_phone'] = $request->phone;
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
        $order['payment_status'] = "Pending";
        $order['company_id'] =$companyid;
        $order['shipping_info'] = $shipping_info;
        $order->save();
        $orderid = $order->id;

        $pdata = explode(',',$request->products);
        $qdata = explode(',',$request->quantities);
        $sdata = explode(',',$request->sizes);

  

	
	    foreach ($pdata as $data => $product){
	        $proorders = new OrderedProducts();
	
	        $productdet = Product::findOrFail($product);

            if($request->shippinginfo == 'Per Product')
            {
                $shippingcharge = $productdet->shipping_cost;
            }
            else if($request->shippinginfo == 'Per Order')
            {
                $shippingcharge = null;
            }

            if($request->taxinfo == 'Per Product')
            {
                $taxval = $productdet->tax;
            }
            else if($request->taxinfo == 'Per Order')
            {
                $taxval = null;
            }
	
	        $proorders['orderid'] = $orderid;
	        $proorders['owner'] = $productdet->owner;
	        $proorders['productid'] = $product;
            $proorders['prodectname'] =$productdet->title;
            $proorders['subtotal'] =$productdet->selling_price*$qdata[$data];
	        $proorders['quantity'] = $qdata[$data];
	        $proorders['size'] = $sdata[$data];
	        $proorders['payment'] = "pending";
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
	    }
                    
        Cart::where('uniqueid',Session::get('uniqueid'))->delete();


        // Redirect to paypal IPN
        header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
        exit();

 }


 public function paycancle(){
     return redirect()->back();
 }

public function payreturn(){

    $themename = get_theme_name();
    return view($themename.'payreturn');

 }

public function notify(Request $request){

    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
        $keyval = explode ('=', $keyval);
        if (count($keyval) == 2)
            $myPost[$keyval[0]] = urldecode($keyval[1]);
    }

// Read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
        $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
        if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
        } else {
            $value = urlencode($value);
        }
        $req .= "&$key=$value";
    }

    /*
     * Post IPN data back to PayPal to validate the IPN data is genuine
     * Without this step anyone can fake IPN data
     */
    $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
    $ch = curl_init($paypalURL);
    if ($ch == FALSE) {
        return FALSE;
    }
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

// Set TCP timeout to 30 seconds
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
    $res = curl_exec($ch);

    /*
     * Inspect IPN validation result and act accordingly
     * Split response headers and payload, a better way for strcmp
     */
    $tokens = explode("\r\n\r\n", trim($res));
    $res = trim(end($tokens));
    if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {

        $order = Order::where('customerid',$_POST['custom'])
            ->where('order_number',$_POST['item_number'])->first();
        $data['txnid'] = $_POST['txn_id'];
        $data['payment_status'] = $_POST['payment_status'];
        $order->update($data);

	$proorders = OrderedProducts::where('orderid',$order->id);
        $datas['payment'] = "completed";
        $proorders->update($datas);


//
//        $fh = fopen('paymentLaravel.txt', 'w');
//        fwrite($fh, $req);
//        fclose($fh);
//
//
//        $fs = fopen('paymentstatus.txt', 'w');
//        fwrite($fs, $_POST['payment_status']);
//        fclose($fs);
//        //return "yes";

    }else{

        $fh = fopen('newresag.txt', 'w');
        fwrite($fh, $req);
        fclose($fh);
    }

}



}
