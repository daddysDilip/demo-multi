@extends('fusion-fashion.includes.newmaster')

@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .dashboard-content * {
            visibility: visible;
        }
        .print-order-btn,.edit-account-info-div .back-btn{
            visibility: hidden;
        }
        .dashboard-content {
            position: absolute;
            margin-top: -700px;
            margin-left: -10px;
            width: 100%;
        }
        .dashboard-content address{
            line-height: 30px;
            font-size: 18px;
        }
        .dashboard-content h5 {
            margin-bottom: 15px;
            font-weight: 600;
        }
        .dashboard-content .table_box {
            padding: 0px;
            border: none !important;
        }
    }
</style>

<main>
    
    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="{{route('user.orders',$subdomain_name)}}">{{trans('app.Orders')}}</a></li>
              <li class="breadcrumb-item active text-capitalize" aria-current="page">{{trans('app.Order')}}# {{$order->order_number}} </li>
            </ol>
        </div>
    </nav>

    <div id="order_list" class="my-cart-wrap">
        <div class="container">
            <div class="row wrapper">
                <div class="col-md-4 col-sm-4">
                    @include('fashion-ecommerce.includes.usermenu')
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="dashboard-content">
                        <div class="view-order-page table_box">

                            <h4 class="text-uppercase f-weight600">{{trans('app.Order')}}# {{$order->order_number}} [{{$order->status}}]</h4>

                            <div class="print-order text-right">
                                <button type="button" onclick="window.print();" class="print-order-btn">
                                    <i class="fa fa-print"></i> {{trans('app.PrintOrder')}}
                                </button>
                            </div>

                            <p class="order-date">{{trans('app.OrderDate')}}: {{$order->booking_date}}</p>

                            <div class="shipping-add-area">
                                <div class="row">
                                    <div class="col-md-6">
                                        @if($order->shipping == "shipto")
                                            <h5 class="f-18 f-weight600">{{trans('app.ShippingAddress')}}</h5>
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
                                            <h5 class="f-18 f-weight600">{{trans('app.PickUpLocation')}}</h5>
                                            <address>
                                                {{trans('app.Address')}}: {{$order->pickup_location}}<br>
                                            </address>
                                        @endif

                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="f-18 f-weight600">{{trans('app.ShippingMethod')}}</h5>
                                        @if($order->shipping == "shipto")
                                            <p>{{trans('app.ShipToAddress')}}</p>
                                        @else
                                            <p>{{trans('app.PickUp')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="billing-add-area">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="f-18 f-weight600">{{trans('app.BillingAddress')}}</h5>
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
                                    <div class="col-md-6">
                                        <h5 class="f-18 f-weight600">{{trans('app.PaymentMethod')}}</h5>
                                        <p>{{$order->method}}</p>

                                        @if($order->method != "Cash On Delivery")
                                            @if($order->method=="Stripe")
                                                {{$order->method}} {{trans('app.ChargeID')}}: <p>{{$order->charge_id}}</p>
                                            @endif
                                                {{$order->method}} {{trans('app.TransactionID')}}: <p>{{$order->txnid}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h5>{{trans('app.OrderedProducts')}}:</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered veiw-details-table">
                                    <tr class="veiw-details-row">
                                        <td align="center">{{trans('app.ProductName')}}e</td>
                                        <td align="center">{{trans('app.Price')}}</td>
                                        <td align="center">{{trans('app.Quantity')}}</td>
                                        <td align="center">{{trans('app.SubTotal')}}</td>
                                    </tr>
                                    
                                    <?php //echo "<pre>"; print_r($orderproduct); echo "</pre>"; ?>
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
                                                {{trans('app.ShippingCost')}}: {{$settings[0]->currency_sign}}{{$allproduct->shipping_cost}}
                                            @endif
                                            @if($settings[0]->tax_information  == 'Per Product' && $allproduct->tax != '')
                                                {{trans('app.Tax')}} ({{$allproduct->tax}} %): {{$settings[0]->currency_sign}}{{number_format($finalptax,2)}}
                                            @endif
                                        </td>
                                        <td align="center">{{$allproduct->quantity}}</td>
                                        <td align="right">{{$settings[0]->currency_sign}}{{number_format($psubtotal,2)}}</td>
                                    </tr>
                                    @endforeach

                                    @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                    <tr style="font-weight: 600;">
                                        <td colspan="3" style="text-align: right">{{trans('app.SubTotal')}}</td>
                                        <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</td>
                                    </tr>
                                    @elseif(!empty($order->discount_code))
                                    <tr style="font-weight: 600;">
                                        <td colspan="3" style="text-align: right">{{trans('app.SubTotal')}}</td>
                                        <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</td>
                                    </tr>
                                    @endif
                                    @if(!empty($order->discount_code))
                                    <tr style="font-weight: 600;">
                                        <td colspan="3" style="text-align: right">{{trans('app.Discount')}}<br>({{$order->discount_code}})</td>
                                        <?php  //echo "<pre>"; print_r($discount); echo "</pre>"; echo $discount[0]->id; ?>
                                        @if($discount[0]->amounttype == 2)
                                            <td align="right">- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                                        @elseif($discount[0]->amounttype == 1)</td>
                                            <td align="right">{{$discount[0]->discount}}%<br>- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}</td>
                                        @endif
                                    </tr>
                                    @endif
                                    @if($settings[0]->shipping_information  == 'Per Order')
                                        @if($order->shippingcharge != 0)
                                        <tr style="font-weight: 600;">
                                            <td colspan="3" style="text-align: right">{{trans('app.ShippingCost')}}</td>
                                            <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->shippingcharge,2)}}</td>
                                        </tr>
                                        @endif
                                    @endif
                                    @if($settings[0]->tax_information  == 'Per Order')
                                        @if($order->tax != 0)
                                        <tr style="font-weight: 600;">
                                            <td colspan="3" style="text-align: right">{{trans('app.Tax')}}({{$order->tax}}%)</td>
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
                                    @endif
                                    <tr style="font-weight: 600;">
                                        <td colspan="3" style="text-align: right">{{trans('app.Total')}}</td>
                                        <td align="right">{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="edit-account-info-div">
                                <div class="form-group">
                                    <a class="btn btn-md back-btn" href="{{route('user.orders',$subdomain_name)}}">{{trans('app.Back')}}</a>
                                    <a class="btn btn-md back-btn download_invoice pull-right" href="{{url('user/orderpdf/')}}/{{$order->id}}">{{trans('app.DownloadInvoice')}}</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

@stop

@section('footer')

@stop