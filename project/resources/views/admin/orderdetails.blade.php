@extends('admin.includes.master-admin')

@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .order_invoice * {
            visibility: visible;
        }
        .order_invoice{
            visibility: hidden;
        }
        .order_invoice {
            position: absolute;
            margin-top: -300px;
            margin-left: -300px;
        }
        
    }
</style>
<main>

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{ trans('app.OrderDetails') }}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{ trans('app.Home') }}</a></li>
                    <li class="breadcrumb-item">{{ trans('app.OrderDetails') }}</li>
                </ul>
            </div>
               
            <!-- Page Content -->
            <div class="order-detail">
                <div class="prtm-block">

                    <div class="prtm-block-title pos-relative">
                        <div class="caption">
                            <h3>{{ trans('app.Order') }} #{{$order->order_number}} | {{date('M d, Y H:i:s', strtotime($order->booking_date))}}</h3> 
                        </div>
                    </div>

                    <div class="prtm-block-content prtm-block-no-gutter">
                        <div class="line-slide-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"> <a data-toggle="tab" href="#order" aria-expanded="false">{{ trans('app.Order') }} </a> </li>
                                <li> <a data-toggle="tab" href="#invoice" aria-expanded="true">{{ trans('app.Invoice') }} </a> </li>
                            </ul>
                        </div>

                        <div class="tab-content pad-all-lg">
                            <div id="order" class="tab-pane fade in active">
                                <div class="row">

                                    <div id="response">
                                        @if(Session::has('message'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="prtm-block pos-relative">
                                            <div class="prtm-block-title mrgn-b-md">
                                                <div class="caption">
                                                    <h5 class="text-capitalize">{{ trans('app.OrderDetails') }}</h5> 
                                                </div>
                                            </div>
                                            <div class="prtm-block-content">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-9">
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.Order') }} #:</span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$order->order_number}}</span> </div>
                                                        </div>
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.OrderDate') }} &amp; {{ trans('app.Time') }} : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{date('M d, Y H:i:s', strtotime($order->booking_date))}}</span> </div>
                                                        </div>
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.OrderStatus') }} : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> 
                                                                @if($order->status == "completed")
                                                                    @php $btn_class = 'primary'; @endphp
                                                                @elseif($order->status == "cancelled")
                                                                    @php $btn_class = 'danger'; @endphp
                                                                @elseif($order->status == "processing")
                                                                    @php $btn_class = 'info'; @endphp
                                                                @else
                                                                    @php $btn_class = 'default'; @endphp
                                                                @endif
                                                                @if($order->status != 'completed' && $order->status != 'cancelled')
                                                                    <span class="dropdown">
                                                                        <button class="btn btn-{{$btn_class}} btn-rounded dropdown-toggle btn-xs" type="button" data-toggle="dropdown">{{ucfirst($order->status)}}<span class="caret"></span></button>
                                                                        <ul class="dropdown-menu">
                                                                            @if($order->status == 'pending')
                                                                                <li><a href="{!! url('admin/orders') !!}/status/{{$order->id}}/processing">{{ trans('app.Processing') }}</a></li>
                                                                                <li><a href="orders/status/{{$order->id}}/completed">{{ trans('app.Completed') }}</a></li>
                                                                                <li><a href="orders/status/{{$order->id}}/cancelled">{{ trans('app.Canceled') }}</a></li>
                                                                            @elseif($order->status == 'processing')
                                                                                <li><a href="orders/status/{{$order->id}}/completed">{{ trans('app.Completed') }}</a></li>
                                                                                <li><a href="orders/status/{{$order->id}}/cancelled">{{ trans('app.Canceled') }}</a></li>
                                                                            @endif
                                                                        </ul>
                                                                    </span>
                                                                @else
                                                                    <button class="btn btn-{{$btn_class}} btn-rounded btn-xs ">{{ucfirst($order->status)}}</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.GrandTotal') }} : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}</span> </div>
                                                        </div>
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.PaymentInformation') }} : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$order->method}}</span> </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 hidden-sm text-center"> <span class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prtm-block pos-relative">
                                            <div class="prtm-block-title mrgn-b-md">
                                                <div class="caption">
                                                    <h5 class="text-capitalize">{{ trans('app.CustomerDetails') }}</h5> 
                                                </div>
                                            </div>
                                            <div class="prtm-block-content">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-9">
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.Name') }} :</span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$customer->firstname}} {{$customer->lastname}}</span> </div>
                                                        </div>
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.Email') }} : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$customer->email}}</span> </div>
                                                        </div>
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.PhoneNumber') }} : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{$customer->phone}}</span> </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 hidden-sm text-center"> <span class="icon"><i class="fa fa-user" aria-hidden="true"></i></span> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prtm-block pos-relative">
                                            <div class="prtm-block-title mrgn-b-md">
                                                <div class="caption">
                                                    <h5 class="text-capitalize">{{ trans('app.Address') }}</h5> 
                                                </div>
                                            </div>
                                            <div class="prtm-block-content">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-9">
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-4 col-sm-4 col-md-4"> <span>{{ trans('app.BillingAddress') }}</span> </div>
                                                            <div class="col-xs-8 col-sm-8 col-md-8"> 
                                                                <address>
                                                                    <span class="show">{{$order->customer_firstname}} {{$order->customer_lastname}}</span>
                                                                    <span class="show">{{$order->customer_email}}</span>
                                                                    <span class="show">{{$order->customer_phone}}</span>
                                                                    <span class="show">{{$order->customer_address}}</span>
                                                                    <span class="show">{{get_country_name($order->customer_country)}}</span>
                                                                    <span class="show">{{get_state_name($order->customer_state)}}</span>
                                                                    <span class="show">{{get_city_name($order->customer_city)}}-{{$order->customer_zip}}</span>
                                                                </address> 
                                                            </div>
                                                        </div>
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-4 col-sm-4 col-md-4"> <span>{{ trans('app.ShippingAddress') }} : </span> </div>
                                                            <div class="col-xs-8 col-sm-8 col-md-8"> 
                                                                <address>
                                                                    @if($order->shipping_info == 1)
                                                                        <span class="show">{{$order->shipping_firstname}} {{$order->shipping_lastname}}</span>
                                                                        <span class="show">{{$order->shipping_email}}</span>
                                                                        <span class="show">{{$order->shipping_phone}}</span>
                                                                        <span class="show">{{$order->shipping_address}}</span>
                                                                        <span class="show">{{get_country_name($order->shipping_country)}}</span>
                                                                        <span class="show">{{get_state_name($order->shipping_state)}}</span>
                                                                        <span class="show">{{get_city_name($order->shipping_city)}}-{{$order->shipping_zip}}</span>
                                                                    @else
                                                                        <span class="show">{{$order->customer_firstname}} {{$order->customer_lastname}}</span>
                                                                        <span class="show">{{$order->customer_email}}</span>
                                                                        <span class="show">{{$order->customer_phone}}</span>
                                                                        <span class="show">{{$order->customer_address}}</span>
                                                                        <span class="show">{{get_country_name($order->customer_country)}}</span>
                                                                        <span class="show">{{get_state_name($order->customer_state)}}</span>
                                                                        <span class="show">{{get_city_name($order->customer_city)}}-{{$order->customer_zip}}</span>
                                                                    @endif
                                                                </address> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 hidden-sm text-center"> <span class="icon"><i class="fa fa-map" aria-hidden="true"></i></span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-12 col-lg-6">
                                        <div class="prtm-block pos-relative">
                                            <div class="prtm-block-title mrgn-b-lg">
                                                <div class="caption">
                                                    <h3 class="text-capitalize">{{ trans('app.ShoppingCart') }}</h3> 
                                                </div>
                                            </div>
                                            <div class="prtm-block-content">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead class="thead-primary">
                                                            <tr class="bg-primary">
                                                                <th>#</th>
                                                                <th>{{ trans('app.Product') }}</th>
                                                                <th>{{ trans('app.Quantity') }}</th>
                                                                <th>{{ trans('app.Price') }}</th>
                                                                <th>{{ trans('app.SubTotal') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $i = 1; @endphp
                                                            @foreach($products as $allproduct)
                                                                @php
                                                                    $price = ($allproduct->cost)*($allproduct->quantity);
                                                                    $pshippingcost = $allproduct->shipcost;
                                                                    $ptax = $allproduct->tax;
                                                                    $finalptax = $price * ($ptax/100);
                                                                    $psubtotal = $price + $pshippingcost + $finalptax;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{$i}}</td>
                                                                    <td>
                                                                    <a target="_blank" href="{{prodectlink($allproduct->productid)}}"> {{$allproduct->prodectname}}</a>
                                                                    </td>
                                                                    <td>{{$allproduct->quantity}}</td>
                                                                    <td>{{$settings[0]->currency_sign}}{{number_format($allproduct->cost,2)}}</td>
                                                                    <td>{{$settings[0]->currency_sign}}{{number_format($psubtotal,2)}}</td>
                                                                </tr>
                                                            @php $i++; @endphp
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="mrgn-b-lg product_total">
                                                        @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.SubTotal') }} : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</span> </div>
                                                        </div>
                                                        @elseif(!empty($order->discount_code))
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.SubTotal') }} : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</span> </div>
                                                        </div>
                                                        @endif

                                                        @if(!empty($order->discount_code))
                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.Discount') }} ({{$order->discount_code}})  : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> 
                                                                <span class="value">
                                                                    @if($discount[0]->amounttype == 2)
                                                                        - {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                                                                    @elseif($discount[0]->amounttype == 1)
                                                                        {{$discount[0]->discount}}%<br>- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                                                                    @endif
                                                                </span> 
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if($settings[0]->shipping_information  == 'Per Order')
                                                            @if($order->shippingcharge!= 0)
                                                            <div class="row mrgn-b-md">
                                                                <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.ShippingCost') }} : </span> </div>
                                                                <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$settings[0]->currency_sign}}{{number_format($order->shippingcharge,2)}}</span> </div>
                                                            </div>
                                                            @endif
                                                        @endif

                                                        @if($settings[0]->tax_information  == 'Per Order')
                                                            @if($order->tax!= 0)
                                                            <div class="row mrgn-b-md">
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
                                                                <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.Tax') }} ({{$order->tax}}%): </span> </div>
                                                                <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$settings[0]->currency_sign}}{{number_format($totaltax,2)}}</span> </div>
                                                            </div>
                                                            @endif
                                                        @endif

                                                        <div class="row mrgn-b-md">
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span>{{ trans('app.Total') }} : </span> </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}</span> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="invoice"  class="tab-pane fade in ">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-8">
                                        <div class="prtm-block">
                                            <div class="order_invoice">
                                                <div class="mrgn-b-lg clearfix">

                                                    <div class="pull-left">
                                                        <div class="invoice_from">
                                                            <address>
                                                                <span class="fw-medium font-lg mrgn-b-md show">{{$order->customer_firstname}} {{$order->customer_lastname}}
                                                                </span>
                                                         
                                                                  <span class="show" >{{$order->customer_address}}</span>
                                                                <span class="show">{{trans('app.EmailAddress')}} : {{$order->customer_email}}</span>
                                                                <span class="show">{{trans('app.PhoneNumber')}} : {{$order->customer_phone}}</span>
                                                            </address>
                                                        </div>
                                                    </div>

                                                    <div class="pull-right text-right">
                                                        <div class="invoice_to">
                                                            <div class="mrgn-b-lg">
                                                                <h5 class="text-uppercase">{{trans('app.InvoiceNo')}}: {{$order->order_number}}</h5> 
                                                            </div>
                                                            @if($order->shipping_info == 1)
                                                                <h5>{{trans('app.To')}},</h5>
                                                                <h5>{{$order->shipping_firstname}} {{$order->shipping_lastname}}</h5> 
                                                                <address>
                                                                    <span  class="show">{{$order->shipping_address}}</span>
                                                                    <span  class="show">{{get_country_name($order->shipping_country)}}</span>
                                                                    <span  class="show">{{get_state_name($order->shipping_state)}}</span>
                                                                    <span  class="show">{{get_city_name($order->shipping_city)}}-{{$order->shipping_zip}}</span>
                                                                </address>
                                                            @else
                                                                <h5>{{trans('app.To')}},</h5>
                                                                <address>
                                                                    <span  class="show">{{$order->customer_firstname}} {{$order->customer_lastname}}</span>
                                                                    <span  class="show">{{$order->customer_address}}</span>
                                                                    <span  class="show">{{get_country_name($order->customer_country)}}</span>
                                                                    <span  class="show">{{get_state_name($order->customer_state)}}</span>
                                                                    <span  class="show">{{get_city_name($order->customer_city)}}-{{$order->customer_zip}}</span>
                                                                </address>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="table-responsive mrgn-b-lg prtm-block-no-gutter">
                                                    <table class="table table-striped table-hover">
                                                        <thead class="thead-primary">
                                                            <tr class="bg-primary">
                                                                <th>#</th>
                                                                <th>{{ trans('app.Product') }}</th>
                                                                <th>{{ trans('app.Quantity') }}</th>
                                                                <th>{{ trans('app.Price') }}</th>
                                                                <th>{{ trans('app.SubTotal') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $i = 1; @endphp
                                                            @foreach($products as $allproduct)
                                                                @php
                                                                    $price = ($allproduct->cost)*($allproduct->quantity);
                                                                    $pshippingcost = $allproduct->shipcost;
                                                                    $ptax = $allproduct->tax;
                                                                    $finalptax = $price * ($ptax/100);
                                                                    $psubtotal = $price + $pshippingcost + $finalptax;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{$i}}</td>
                                                                    <td>
                                    
                                    <a target="_blank" href="{{prodectlink($allproduct->productid)}}">
                                                                      {{$allproduct->prodectname}}</a>
                                                                    </td>
                                                                    <td>{{$allproduct->quantity}}</td>
                                                                    <td>{{$settings[0]->currency_sign}}{{number_format($allproduct->cost,2)}}</td>
                                                                    <td>{{$settings[0]->currency_sign}}{{number_format($psubtotal,2)}}</td>
                                                                </tr>
                                                            @php $i++; @endphp
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="text-right base-dark">

                                                    @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                                        <h5>
                                                            {{ trans('app.SubTotal') }} : 
                                                           {{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}
                                                        </h5>
                                                    @elseif(!empty($order->discount_code))
                                                        <h5>{{ trans('app.SubTotal') }} :{{$settings[0]->currency_sign}}{{number_format($order->subtotal,2)}}</h5>
                                                    @endif

                                                    @if(!empty($order->discount_code))
                                                        <h5>{{ trans('app.Discount') }} ({{$order->discount_code}})  : 
                                                            @if($discount[0]->amounttype == 2)
                                                                - {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                                                            @elseif($discount[0]->amounttype == 1)
                                                                {{$discount[0]->discount}}%<br>- {{$settings[0]->currency_sign}}{{number_format($order->discountprice,2)}}
                                                            @endif
                                                        </h5>
                                                    @endif

                                                    @if($settings[0]->shipping_information  == 'Per Order')
                                                        @if($order->shippingcharge!= 0)
                                                    <h5>{{ trans('app.ShippingCost') }} :{{$settings[0]->currency_sign}}{{number_format($order->shippingcharge,2)}}</h5>
                                                        @endif
                                                    @endif


                                                    @if($settings[0]->tax_information  == 'Per Order')
                                                        @if($order->tax!= 0)
                                                            <h5>
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
                                                           Tax ({{$order->tax}}%): {{$settings[0]->currency_sign}}{{number_format($totaltax,2)}}
                                                        @endif
                                                       </h5>
                                                    @endif

                                                    <h3>{{ trans('app.Total') }} : {{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}</h3>
                                              
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="col-sm-12 col-md-12 col-lg-4">
                                        <div class="prtm-block-content">
                                            <a href="{{url('admin/orderpdf/')}}/{{$order->id}}"><button class="btn btn-block btn-success btn-lg mrgn-b-xs">
                                            {{ trans('app.DownloadInvoice') }}
                                            </button></a>
                                            <button class="btn btn-block btn-default btn-lg mrgn-b-xs" onclick="window.print();">{{ trans('app.Print') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</main>


@stop

@section('footer')

@stop