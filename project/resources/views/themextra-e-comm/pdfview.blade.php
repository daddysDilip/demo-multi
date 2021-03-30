<!DOCTYPE html>
<html>
<head>
	<title>User list - PDF</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="dashboard-content">
                <div class="view-order-page">
                    <h3>Order# {{$order->order_number}} [{{$order->status}}]</h3>
                   
                    <p class="order-date">Order Date: {{$order->booking_date}}</p>

                    <div class="shipping-add-area">
                        <div class="row">
                            <div class="col-md-6" style="float: left;">
                                @if($order->shipping == "shipto")
                                    <h5><b>Shipping Address</b></h5>
                                    @if($order->shipping_info == 1)
                                    <address>
                                        {{$order->shipping_firstname}} {{$order->shipping_firstname}}<br>
                                        {{$order->shipping_email}}<br>
                                        {{$order->shipping_phone}}<br>
                                        {{$order->shipping_address}}<br>
                                        {{get_country_name($order->shipping_country)}}<br>
                                        {{get_state_name($order->shipping_state)}}<br>
                                        {{get_city_name($order->shipping_city)}}-{{$order->shipping_zip}}
                                    </address>
                                    @else
                                    <address>
                                        {{$order->customer_firstname}} {{$order->customer_lastname}}<br>
                                        {{$order->customer_email}}<br>
                                        {{$order->customer_phone}}<br>
                                        {{$order->customer_address}}<br>
                                        {{get_country_name($order->customer_country)}}<br>
                                        {{get_state_name($order->customer_state)}}<br>
                                        {{get_city_name($order->customer_city)}}-{{$order->customer_zip}}
                                    </address>
                                    @endif
                                @else
                                    <h5><b>PickUp Location</b></h5>
                                    <address>
                                        Address: {{$order->pickup_location}}<br>
                                    </address>
                                @endif
                            </div>
                            <div class="col-md-6" style="float: right;">
                                <h5><b>Shipping Method</b></h5>
                                @if($order->shipping == "shipto")
                                    <p>Ship To Address</p>
                                @else
                                    <p>Pick Up</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="billing-add-area">
                        <div class="row">
                            <div class="col-md-6" style="float: left;">
                                <h5><b>Billing Address</b></h5>
                                <address>
                                    {{$order->customer_firstname}} {{$order->customer_lastname}}<br>
                                    {{$order->customer_email}}<br>
                                    {{$order->customer_phone}}<br>
                                    {{$order->customer_address}}<br>
                                    {{get_country_name($order->customer_country)}}<br>
                                    {{get_state_name($order->customer_state)}}<br>
                                    {{get_city_name($order->customer_city)}}-{{$order->customer_zip}}
                                </address>
                            </div>
                            <div class="col-md-6" style="float: right;">
                                <h5><b>Payment Method</b></h5>
                                <p>{{$order->method}}</p>

                                @if($order->method != "Cash On Delivery")
                                    @if($order->method=="Stripe")
                                        {{$order->method}} Charge ID: <p>{{$order->charge_id}}</p>
                                    @endif
                                        {{$order->method}} Transaction ID: <p>{{$order->txnid}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    	<h5><b>Ordered Products:</b></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered veiw-details-table">
                            <thead>
                                <tr class="veiw-details-row">
                                    <td align="center">Product Name</td>
                                    <td align="center" align="center">Price</td>
                                    <td align="center">Quantity</td>
                                    <td align="center">Subtotal</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($orderproduct as $allproduct)
								<tr>
                                    @php
                                        $price = ($allproduct->cost)*($allproduct->quantity);
                                        $pshippingcost = $allproduct->shipcost;
                                        $ptax = $allproduct->tax;
                                        $finalptax = $price * ($ptax/100);
                                        $psubtotal = $price + $pshippingcost + $finalptax;
                                    @endphp
                                    <td align="center">{{$allproduct->prodectname}}</td>
                                    <td align="center">
                                        {{$settings[0]->currency_sign}}{{number_format($allproduct->cost,2)}}<br>
                                        @if($settings[0]->shipping_information  == 'Per Product' && $allproduct->shipping_cost != '')
                                            {{$language->shipping_cost}}: {{$settings[0]->currency_sign}}{{$allproduct->shipping_cost}}
                                        @endif
                                        @if($settings[0]->tax_information  == 'Per Product' && $allproduct->tax != '')
                                            {{$language->tax}} ({{$allproduct->tax}} %): {{$settings[0]->currency_sign}}{{number_format($finalptax,2)}}
                                        @endif
                                    </td>
                                    <td align="center">{{$allproduct->quantity}}</td>
                                    <td align="right">{{$settings[0]->currency_sign}}{{number_format($psubtotal,2)}}</td>
									 </tr>
                                @endforeach

                                @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                <tr style="font-weight: 600;">
                                    <td colspan="3" style="text-align: right">{{$language->subtotal}}</td>
                                    <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</td>
                                </tr>
                                @elseif(!empty($order->discount_code))
                                <tr style="font-weight: 600;">
                                    <td colspan="3" style="text-align: right">{{$language->Subtotal}}</td>
                                    <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</td>
                                </tr>
                                @endif
                                @if(!empty($order->discount_code))
                                <tr style="font-weight: 600;">
                                    <td colspan="3" style="text-align: right">Discount<br>({{$order->discount_code}})</td>
                                    <?php  //echo "<pre>"; print_r($discount); echo "</pre>"; echo $discount[0]->id; ?>
                                    @if($discount[0]->amounttype == 2)
                                        <td align="right">- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                                    @elseif($discount[0]->amounttype == 1)</td>
                                        <td align="right">{{$discount[0]->discount}}%<br>- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}</td>
                                    @endif
                                </tr>
                                @endif
                                @if($settings[0]->shipping_information  == 'Per Order')
                                <tr style="font-weight: 600;">
                                    <td colspan="3" style="text-align: right">{{$language->shipping_cost}}</td>
                                    <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->shippingcharge,2)}}</td>
                                </tr>
                                @endif
                                @if($settings[0]->tax_information  == 'Per Order')
                                <tr style="font-weight: 600;">
                                    <td colspan="3" style="text-align: right">{{$language->tax}}({{$order->tax}}%)</td>
                                    @if(!empty($order->discount_code))
                                        @php 
                                            $tax = $order->tax;
                                            $totalprice = ($order->subtotal) - ($order->discountprice) + ($order->shippingcharge);
                                            $totaltax = ($totalprice) * ($tax/100);
                                        @endphp
                                    @else
                                        @php 
                                            $tax = $order->tax;
                                            $totaltax = ($order->subtotal + $order->shippingcharge) * ($tax/100);
                                        @endphp
                                    @endif
                                    <td align="right">{{$settings[0]->currency_sign}}{{number_format($totaltax,2)}}</td>
                                </tr>
                                @endif
                                <tr style="font-weight: 600;">
                                    <td colspan="3" style="text-align: right">{{$language->total}}</td>
                                    <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>

</body>
</html>