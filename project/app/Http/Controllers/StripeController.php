<?php

namespace App\Http\Controllers;

use App\Cart;
use App\OrderedProducts;
use App\Product;
use Illuminate\Http\Request;
use URL;
use Redirect;
use Input;
use Validator;
use App\Order;
use App\Package;
use App\PricingTable;
use App\Settings;
use Config;
use Session;
use App\CustomerAddress;
use DB;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;

class StripeController extends Controller
{

    public function __construct()
    {
        //Set Spripe Keys
        $stripe = Settings::findOrFail(1);
  		Config::set('services.stripe.key', $stripe->stripe_key);
  		Config::set('services.stripe.secret', $stripe->stripe_secret);
    }


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

        if(count($caddress) > 0)
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

		$validator = Validator::make($request->all(),[
						'card' => 'required',
						'cvv' => 'required',
						'month' => 'required',
						'year' => 'required',
					]);

		if ($validator->passes()) {

	     	$stripe = Stripe::make(Config::get('services.stripe.secret'));
	     	try{
	     		$token = $stripe->tokens()->create([
	     			'card' =>[
	     					'number' => $request->card,
	     					'exp_month' => $request->month,
	     					'exp_year' => $request->year,
	     					'cvc' => $request->cvv,
	     				],
	     			]);
	     		if (!isset($token['id'])) {
	     			return back()->with('error','Token Problem With Your Token.');
	     		}

	     		$charge = $stripe->charges()->create([
	     			'card' => $token['id'],
	     			'currency' => 'USD',
	     			'amount' => $item_amount,
	     			'description' => $item_name,
	     			]);

	     		//dd($charge);

	     		if ($charge['status'] == 'succeeded') {

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
                    $order['method'] = "Stripe";
                    $order['customer_email'] = $request->email;
                    $order['customer_firstname'] = $request->customer_firstname;
                    $order['customer_lastname'] = $request->customer_lastname;
                    $order['customer_phone'] = $request->phone;
                    $order['booking_date'] = date('Y-m-d H:i:s');
                    $order['order_number'] = $item_number;
                    $order['shipping'] = $request->shipping;
                    $order['pickup_location'] = $request->pickup_location;
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
			        $order['txnid'] = $charge['balance_transaction'];
			        $order['charge_id'] = $charge['id'];
                    $order['company_id'] =$companyid;
                    $order['shipping_info'] = $shipping_info;
			        $order->save();
                    $orderid = $order->id;

                    $pdata = explode(',',$request->products);
                    $qdata = explode(',',$request->quantities);
                    $sdata = explode(',',$request->sizes);


        //            $i=0;
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
//                    foreach (array_combine($pdata, $qdata) as $product => $quantity){
//                        $productdet = Product::findOrFail($product);
//                        $stocks = $productdet->stock - $quantity;
//                        if ($stocks < 0){
//                            $stocks = 0;
//                        }
//                        $quant['stock'] = $stocks;
//                        $productdet->update($quant);
//                    }

                    Cart::where('uniqueid',Session::get('uniqueid'))->delete();

	     			return redirect($success_url);
	     		}
	     		
	     	}catch (Exception $e){
	     		return back()->with('error', $e->getMessage());
	     	}catch (\Cartalyst\Stripe\Exception\CardErrorException $e){
	     		return back()->with('error', $e->getMessage());
	     	}catch (\Cartalyst\Stripe\Exception\MissingParameterException $e){
	     		return back()->with('error', $e->getMessage());
	     	}
		}
		return back()->with('error', 'Please Enter Valid Credit Card Informations.');
	}
}
