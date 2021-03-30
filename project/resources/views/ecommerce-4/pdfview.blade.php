<!DOCTYPE html>
<html>
<head>
	<title>User list - PDF</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<style type="text/css">
    .grand_total 
    {
        width: 40%;
        float: right;
    }
    .table
    {
        border:none !important;
        width:100% !important;
    }
    .table tbody 
    {
        border-bottom: 1px solid #e3e3e3;
    }
    .table td
    {
        border:none !important;
    }
</style>
<body>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
            <div class="invoice">
                <div class="row">
                    <div class="col-sm-6" style="float: left;">
                        <div class="invoice_from">
                            <h5>{{$order->customer_firstname}} {{$order->customer_lastname}}</h5>
                            <address>
                                <span>{{$order->customer_address}}</span><br>
                                <span>Email Address : {{$order->customer_email}}</span><br>
                                <span>Phone Number : {{$order->customer_phone}}</span><br>
                            </address>
                        </div>
                    </div>
                    <div class="col-sm-6" style="float: right;">
                        <div class="invoice_to">
                            @if($order->shipping_info == 1)
                            <address>
                                <span>To,</span><br>
                                <span>{{$order->shipping_firstname}} {{$order->shipping_firstname}}</span><br>
                                <span>{{$order->shipping_email}}</span><br>
                                <span>{{$order->shipping_phone}}</span><br>
                                <span>{{$order->shipping_address}}</span><br>
                                <span>{{get_country_name($order->shipping_country)}}</span><br>
                                <span>{{get_state_name($order->shipping_state)}}</span><br>
                                <span>{{get_city_name($order->shipping_city)}}-{{$order->shipping_zip}}</span>
                            </address>
                            @else
                            <address>
                                <span>To,</span><br>
                                <span>{{$order->customer_firstname}} {{$order->customer_lastname}}</span><br>
                                <span>{{$order->customer_email}}</span><br>
                                <span>{{$order->customer_phone}}</span><br>
                                <span>{{$order->customer_address}}</span><br>
                                <span>{{get_country_name($order->customer_country)}}</span><br>
                                <span>{{get_state_name($order->customer_state)}}</span><br>
                                <span>{{get_city_name($order->customer_city)}}-{{$order->customer_zip}}</span>
                            </address>
                            @endif
                            <div class="date">
                                <span>Order Date: <?php echo date('F d, Y', strtotime($order->booking_date)) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style="margin-top: 50px;border: none">
                    <table border="0" class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th align="center">Image</th>
                                <th align="center">Product Name</th>
                                <th align="center">Price</th>
                                <th align="center">Quantity</th>
                                <th align="center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderproduct as $allproduct)
                            @php
                                $price = ($allproduct->cost)*($allproduct->quantity);
                                $pshippingcost = $allproduct->shipcost;
                                $ptax = $allproduct->tax;
                                $finalptax = $price * ($ptax/100);
                                $psubtotal = $price + $pshippingcost + $finalptax;
                            @endphp
                            <tr>
                                <td>
                                    @if($allproduct->productimage)
                                        <img src="{{url('/assets/images/products')}}/{{$allproduct->productimage}}" class="" style="width: 100px;height: 100px;">
                                    @else
                                        <img src="{{url('/assets/images')}}/placeholder.jpg" class="" style="width: 100px;height: 100px;">
                                    @endif
                                </td>
                                <td>{{$allproduct->prodectname}}</td>
                                <td>{{$settings[0]->currency_sign}}{{number_format($allproduct->cost,2)}}<br>
                                @if($settings[0]->shipping_information  == 'Per Product' && $allproduct->shipping_cost != '')
                                    {{$language->shipping_cost}}: {{$settings[0]->currency_sign}}{{$allproduct->shipping_cost}}
                                @endif
                                @if($settings[0]->tax_information  == 'Per Product' && $allproduct->tax != '')
                                    {{$language->tax}} ({{$allproduct->tax}} %): {{$settings[0]->currency_sign}}{{number_format($finalptax,2)}}
                                @endif</td>
                                <td>{{$allproduct->quantity}}</td>
                                <td align="right">{{$settings[0]->currency_sign}}{{number_format($psubtotal,2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                            <tr style="font-weight: 600;">
                                <td colspan="4" style="text-align: right">{{$language->subtotal}}</td>
                                <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</td>
                            </tr>
                            @elseif(!empty($order->discount_code))
                            <tr style="font-weight: 600;">
                                <td colspan="4" style="text-align: right">{{$language->Subtotal}}</td>
                                <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</td>
                            </tr>
                            @endif
                            @if(!empty($order->discount_code))
                            <tr style="font-weight: 600;">
                                <td colspan="4" style="text-align: right">Discount<br>({{$order->discount_code}})</td>
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
                                <td colspan="4" style="text-align: right">{{$language->shipping_cost}}</td>
                                <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->shippingcharge,2)}}</td>
                            </tr>
                            @endif
                            @if($settings[0]->tax_information  == 'Per Order')
                            <tr style="font-weight: 600;">
                                <td colspan="4" style="text-align: right">{{$language->tax}}({{$order->tax}}%)</td>
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
                                <td colspan="4" style="text-align: right">{{$language->total}}</td>
                                <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- <div class="grand_total">
                    @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                        <span class="heading">{{$language->subtotal}} : 
                        {{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</span>
                    @elseif(!empty($order->discount_code))
                        <span class="heading">{{$language->subtotal}} :{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</span><br>
                    @endif

                    @if(!empty($order->discount_code))
                        <span>
                            Discount : <br>({{$order->discount_code}}) 
                       
                            @if($discount[0]->amounttype == 2)
                            - {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                        @elseif($discount[0]->amounttype == 1)
                            {{$discount[0]->discount}}%<br>- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                        @endif
                        </span><br>
                    @endif

                    @if($settings[0]->shipping_information  == 'Per Order')
                        <span class="heading">{{$language->shipping_cost}} : </span>
                        <span>{{$settings[0]->currency_sign}}{{number_format($order->shippingcharge,2)}}</span>
                    @endif

                    @if($settings[0]->tax_information  == 'Per Order')
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
                        <span class="heading">{{$settings[0]->currency_sign}}</span>
                        <span>{{number_format($totaltax,2)}}
                    </span>
                    @endif

                    <span class="heading total">{{$language->total}}: </span>
                    <span>{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}
                    </span>
                </div> -->
            </div>
        </div>
	</div>
</div>

</body>
</html>