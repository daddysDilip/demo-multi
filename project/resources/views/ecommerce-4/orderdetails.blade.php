@extends('ecommerce-4.includes.newmaster')

@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .invoice * {
            visibility: visible;
        }
        .invoice,.edit-account-info-div .back-btn{
            visibility: hidden;
        }
        .invoice {
            position: absolute;
            margin-top: -350px;
            margin-left: 0px;
            width: 100%;
        }
        .invoice address{
            line-height: 30px;
            font-size: 18px;
        }
        .invoice .invoice_to 
        {
            margin-top: -160px;
        }
    }
</style>

<main>

    <section id="order_list">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
                <h2>{{trans('app.OrderDetails')}}</h2>
                <div class="table_box">
                    <h3 style="display: inline;">{{trans('app.Order')}}# {{$order->order_number}} | <?php echo date('M d, Y', strtotime($order->booking_date)) ?></h3>
                    <a class="btn btn-md view_order back-btn pull-right" href="{{route('user.orders',$subdomain_name)}}" style="margin-top: -5px">{{trans('app.Back')}}</a>
                    <hr>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">{{trans('app.Order')}}</a></li>
                        <li><a data-toggle="tab" href="#menu1">{{trans('app.Invoice')}}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="order_box">
                                        <h4>{{trans('app.OrderDetails')}}</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <span class="order_label">{{trans('app.Order')}} #:</span>
                                                        <span class="order_label">{{trans('app.OrderDate')}} :</span>
                                                        <span class="order_label">{{trans('app.OrderStatus')}} :</span>
                                                        <span class="order_label">{{trans('app.GrandTotal')}} :</span>
                                                        <span class="order_label">{{trans('app.PaymentInformation')}} :</span>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <span>{{$order->order_number}}</span>
                                                        <span><?php echo date('M d, Y', strtotime($order->booking_date)) ?></span>
                                                        @if($order->status == 'pending')
                                                            @php $class = 'danger'; @endphp 
                                                        @elseif($order->status == 'processing')
                                                            @php $class = 'warning'; @endphp 
                                                        @else($order->status == 'completed')
                                                            @php $class = 'success'; @endphp 
                                                        @endif
                                                        <span class="order_status label label-{{$class}} btn-rounded font-sm">{{$order->status}}</span>
                                                        <span>{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}</span>
                                                        <span>{{$order->method}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <i class="fas fa-shopping-cart low_opp"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order_box">
                                        <h4>{{trans('app.CustomerDetails')}}</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <span class="order_label">{{trans('app.Name')}} :</span>
                                                        <span class="order_label">{{trans('app.LastName')}} :</span>
                                                        <span class="order_label">{{trans('app.EmailAddress')}} :</span>
                                                        <span class="order_label">{{trans('app.PhoneNumber')}} :</span>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <span>{{$user->firstname}} {{$user->lastname}}</span>
                                                        <span>{{$user->email}}</span>
                                                        <span>{{$user->phone}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <i class="fas fa-user low_opp"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order_box">
                                        <h4>{{trans('app.Address')}}</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <span class="order_label">{{trans('app.BillingAddress')}} :</span>
                                                    </div>
                                                    <div class="col-sm-6">
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
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <span class="order_label">{{trans('app.ShippingAddress')}} :</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        @if($order->shipping_info == 1)
                                                        <address>
                                                            {{$order->shipping_firstname}} {{$order->shipping_lastname}}<br>
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <i class="fas fa-map low_opp"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="shopping_list">
                                        <div class="table_box">
                                            <h3>{{trans('app.ShoppingCart')}}</h3>
                                            <hr>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <td align="center">{{trans('app.Image')}}</td>
                                                            <td align="center">{{trans('app.ProductName')}}</td>
                                                            <td align="center">{{trans('app.Price')}}</td>
                                                            <td align="center">{{trans('app.Quantity')}}</td>
                                                            <td align="center">{{trans('app.SubTotal')}}</td>
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
                                                                    <img src="{{url('/assets/images/products')}}/{{$allproduct->productimage}}" class="img-responsive disp_img" width="70" height="70">
                                                                @else
                                                                    <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive disp_img" width="70" height="70">
                                                                @endif
                                                            </td>
                                                            <td>{{$allproduct->prodectname}}</td>
                                                            <td>{{$settings[0]->currency_sign}}{{number_format($allproduct->cost,2)}}<br>
                                                            @if($settings[0]->shipping_information  == 'Per Product' && $allproduct->shipping_cost != '')
                                                                {{trans('app.ShippingCost')}}: {{$settings[0]->currency_sign}}{{$allproduct->shipping_cost}}
                                                            @endif
                                                            @if($settings[0]->tax_information  == 'Per Product' && $allproduct->tax != '')
                                                                {{trans('app.Tax')}} ({{$allproduct->tax}} %): {{$settings[0]->currency_sign}}{{number_format($finalptax,2)}}
                                                            @endif</td>
                                                            <td>{{$allproduct->quantity}}</td>
                                                            <td>{{$settings[0]->currency_sign}}{{number_format($psubtotal,2)}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                                <span class="order_label">{{trans('app.SubTotal')}} :</span>
                                                @elseif(!empty($order->discount_code))
                                                <span class="order_label">{{trans('app.SubTotal')}} :</span>
                                                @endif

                                                @if(!empty($order->discount_code))
                                                <span class="order_label">{{trans('app.Discount')}}<br>({{$order->discount_code}}) :</span>
                                                @endif

                                                @if($settings[0]->shipping_information  == 'Per Order')
                                                <span class="order_label">{{trans('app.ShippingCost')}} :</span>
                                                @endif

                                                @if($settings[0]->tax_information  == 'Per Order')
                                                <span class="order_label">{{trans('app.Tax')}}({{$order->tax}}%) :</span>
                                                @endif

                                                <span class="order_label">{{trans('app.Total')}} :</span>
                                            </div>
                                            <div class="col-xs-6">
                                                @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                                <span align="right">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</span>
                                                @elseif(!empty($order->discount_code))
                                                <span align="right">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</span>
                                                @endif

                                                @if(!empty($order->discount_code))
                                                    @if($discount[0]->amounttype == 2)
                                                    <span align="right">- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}</span>
                                                    @elseif($discount[0]->amounttype == 1)
                                                    <span align="right">{{$discount[0]->discount}}%<br>- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}</span>
                                                    @endif
                                                @endif

                                                @if($settings[0]->shipping_information  == 'Per Order')
                                                <span align="right">{{$settings[0]->currency_sign}}{{number_format($order->shippingcharge,2)}}</span>
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
                                                <span align="right">{{$settings[0]->currency_sign}}{{number_format($totaltax,2)}}</span>
                                                @endif

                                                <span align="right">{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12 col-md-8 invoice_details">
                                    <div class="invoice">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="invoice_from">
                                                    <h5>{{$order->customer_firstname}} {{$order->customer_lastname}}</h5>
                                                    <address>
                                                        <span>{{$order->customer_address}}</span>
                                                        <span>{{trans('app.EmailAddress')}} : {{$order->customer_email}}</span>
                                                        <span>{{trans('app.PhoneNumber')}} : {{$order->customer_phone}}</span>
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="invoice_to">
                                                    @if($order->shipping_info == 1)
                                                    <address>
                                                        <span>{{trans('app.To')}},</span>
                                                        <span>{{$order->shipping_firstname}} {{$order->shipping_lastname}}</span>
                                                        <span>{{$order->shipping_address}}</span>
                                                        <span>{{get_country_name($order->shipping_country)}}</span>
                                                        <span>{{get_state_name($order->shipping_state)}}</span>
                                                        <span>{{get_city_name($order->shipping_city)}}-{{$order->shipping_zip}}</span>
                                                    </address>
                                                    @else
                                                    <address>
                                                        <span>{{trans('app.To')}},</span>
                                                        <span>{{$order->customer_firstname}} {{$order->customer_lastname}}</span>
                                                        <span>{{$order->customer_address}}</span>
                                                        <span>{{get_country_name($order->customer_country)}}</span>
                                                        <span>{{get_state_name($order->customer_state)}}</span>
                                                        <span>{{get_city_name($order->customer_city)}}-{{$order->customer_zip}}</span>
                                                    </address>
                                                    @endif
                                                    <div class="date">
                                                        <span>{{trans('app.OrderDate')}}: <?php echo date('F d, Y', strtotime($order->booking_date)) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <td align="center">{{trans('app.Image')}}</td>
                                                        <td align="center">{{trans('app.ProductName')}}</td>
                                                        <td align="center">{{trans('app.Price')}}</td>
                                                        <td align="center">{{trans('app.Quantity')}}</td>
                                                        <td align="center">{{trans('app.SubTotal')}}</td>
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
                                                                <img src="{{url('/assets/images/products')}}/{{$allproduct->productimage}}" class="img-responsive disp_img" width="70" height="70">
                                                            @else
                                                                <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive disp_img" width="70" height="70">
                                                            @endif
                                                        </td>
                                                        <td>{{$allproduct->prodectname}}</td>
                                                        <td>{{$settings[0]->currency_sign}}{{number_format($allproduct->cost,2)}}<br>
                                                        @if($settings[0]->shipping_information  == 'Per Product' && $allproduct->shipping_cost != '')
                                                            {{trans('app.ShippingCost')}}: {{$settings[0]->currency_sign}}{{$allproduct->shipping_cost}}
                                                        @endif
                                                        @if($settings[0]->tax_information  == 'Per Product' && $allproduct->tax != '')
                                                            {{trans('app.Tax')}} ({{$allproduct->tax}} %): {{$settings[0]->currency_sign}}{{number_format($finalptax,2)}}
                                                        @endif</td>
                                                        <td>{{$allproduct->quantity}}</td>
                                                        <td align="right">{{$settings[0]->currency_sign}}{{number_format($psubtotal,2)}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="grand_total">
                                            @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                                <span class="heading">{{trans('app.SubTotal')}} : </span>
                                                <span>{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</span>
                                            @elseif(!empty($order->discount_code))
                                                <span class="heading">{{trans('app.SubTotal')}} : </span>
                                                <span>{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</span>
                                            @endif

                                            @if(!empty($order->discount_code))
                                                <span class="heading">
                                                    {{trans('app.Discount')}} ({{$order->discount_code}}) :  
                                                </span>
                                                <span>
                                                    @if($discount[0]->amounttype == 2)
                                                    - {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                                                @elseif($discount[0]->amounttype == 1)
                                                    {{$discount[0]->discount}}%<br>- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                                                @endif
                                                </span>
                                            @endif

                                            @if($settings[0]->shipping_information  == 'Per Order')
                                                <span class="heading">{{trans('app.ShippingCost')}} : </span>
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
                                                <span class="heading">{{trans('app.Tax')}}({{$order->tax}}%)</span>
                                                <span>{{$settings[0]->currency_sign}}{{number_format($totaltax,2)}}
                                            </span>
                                            @endif

                                            <span class="heading total">{{trans('app.Total')}}: </span>
                                            <span>{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="thank">
                                        <div class="button-content">
                                            <button class="btn btn-block btn-default btn-lg mrgn-b-xs"><a href="{{url('user/orderpdf/')}}/{{$order->id}}">{{trans('app.DownloadInvoice')}}</a></button>
                                            <button onclick="window.print();" class="btn btn-block btn-default btn-lg mrgn-b-xs">{{trans('app.Print')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
    </section>

</main>

@stop

@section('footer')

@stop