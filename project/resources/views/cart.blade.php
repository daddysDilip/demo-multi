@extends('includes.newmaster')

@section('content')

<style type="text/css">
    .shopping_cart_table tbody
    {
        border-bottom: 1px solid black;
    }
    .tfooter_data tr td
    {
        border-top: none !important;
    }
    .tfooter_data tr td h4
    {
        margin: 0px;
    }

</style>

    <div class="home-wrapper">
        <!-- Starting of add to cart table -->
        <div class="section-padding product-shoppingCart-wrapper wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">

                        <div class="table-responsive">
                            <div class="breadcrumb-box">
                                <a href="{{url('/')}}">{{trans('app.Home')}}</a>
                                <a href="{{url('/cart')}}">{{trans('app.Mycart')}}</a>
                            </div>
                            @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('message') }}
                                </div>
                            @endif  
                            
                            @if(count($carts) > 0)
                            <table class="table shopping_cart_table">
                                <thead>
                                    <tr>
                                        <th>{{trans('app.Remove')}}</th>
                                        <th>{{trans('app.Image')}}</th>
                                        <th width="25%">{{trans('app.ProductName')}}</th>
                                        <th>{{trans('app.Quantity')}}</th>
                                        <th>{{trans('app.UnitPrice')}}</th>
                                        <th>{{trans('app.SubTotal')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $subtotal = 0 @endphp

                                    @forelse($carts as $cart)
                                    
                                        @php
                                            $pric = $cart->cost;
                                            $itmqt = $cart->quantity;  
                                        @endphp

                                        @if($settings[0]->shipping_information  == 'Per Product')  
                                            @php $shipcost = $cart->shipping_cost; @endphp
                                        @elseif($settings[0]->shipping_information  == 'Per Order') 
                                            @php $shipcost = $settings[0]->shipping_cost; @endphp
                                        @endif

                                        @if($settings[0]->tax_information  == 'Per Product')  
                                            @php $tax = $cart->tax; @endphp
                                        @elseif($settings[0]->tax_information  == 'Per Order') 
                                            @php $tax = $settings[0]->tax; @endphp
                                        @endif

                                        @php
                                            $pr_price = $pric*$itmqt;
                                        @endphp

                                        @if($settings[0]->shipping_information  == 'Per Product' && $settings[0]->tax_information  == 'Per Product')
                                            @php 
                                                $pr_tax = ($pric + $shipcost) * ($tax/100);
                                                $totaltax = $pr_tax * $itmqt;  
                                                $totalshipcost = $itmqt * $shipcost;
                                                $display_subtotal= $pr_price + $totalshipcost + $totaltax;
                                                $subtotal = $subtotal + $display_subtotal;   
                                                $grand_total = $subtotal;
                                            @endphp
                                        @elseif($settings[0]->shipping_information  == 'Per Product')
                                            @php 
                                                $totalshipcost = $itmqt * $shipcost;
                                                $display_subtotal = $pr_price + $totalshipcost; 
                                                $subtotal = $subtotal + $display_subtotal;
                                                $totaltax = $subtotal * ($tax/100); 
                                                $grand_total =  $totaltax + $subtotal;
                                            @endphp
                                        @elseif($settings[0]->tax_information  == 'Per Product')
                                            @php 
                                                $pr_tax = $pric * ($tax/100);
                                                $totaltax = ($pr_tax) * ($itmqt);
                                                $display_subtotal = $pr_price + $totaltax; 
                                                $subtotal = $subtotal + $display_subtotal;
                                                $grand_total = $shipcost + $subtotal;
                                            @endphp
                                        @else
                                            @php 
                                                $display_subtotal = $pric*$itmqt; 
                                                $subtotal = $subtotal + $display_subtotal;
                                                $totaltax = ($shipcost + $subtotal) * ($tax/100);    
                                                $grand_total = $shipcost + $totaltax + $subtotal;
                                            @endphp  
                                        @endif 

                                    <tr id="item{{$cart->product}}">
                                        <td><a onclick="getDelete({{$cart->product}})"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                        <td><img src="{{url('/assets/images/products')}}/{{\App\Product::findOrFail($cart->product)->feature_image}}" alt=""></td>
                                        <td class="text-center">
                                            <a href="{{url('/product')}}/{{$cart->product}}/{{str_replace(' ','-',strtolower(\App\Product::findOrFail($cart->product)->title))}}" class="product-name-header">{{$cart->title}}</a>
                                            <p class="table-product-review" style="left: -45px;">
                                                <i class="fa fa-star"></i>
                                                <!-- <span>(06 Reviews)</span> -->
                                            </p>
                                        </td>
                                        <td>
                                            <div class="error{{$cart->product}}"  style="color:red"></div>
                                            <p class="cart-btn">
                                                <span class="quantity-cart-minus" id="minus{{$cart->product}}"><i class="fa fa-minus"></i></span>
                                                <span id="number{{$cart->product}}">{{$cart->quantity}}</span>
                                                <span class="quantity-cart-plus" id="plus{{$cart->product}}" max="{{get_quantity($cart->product)}}"><i class="fa fa-plus"></i></span>
                                            </p>
                                        </td>
                                        <form id="citem{{$cart->product}}">
                                            {{csrf_field()}}
                                            @if(Session::has('uniqueid'))
                                                <input type="hidden" name="uniqueid" value="{{Session::get('uniqueid')}}">
                                            @else
                                                <input type="hidden" name="uniqueid" value="{{str_random(7)}}">
                                            @endif
                                            <input type="hidden" name="title" value="{{$cart->title}}">
                                            <input type="hidden" name="product" value="{{$cart->product}}">
                                            <input type="hidden" id="cost{{$cart->product}}" name="cost" value="{{$cart->cost}}" autocomplete="off">
                                            <input type="hidden" id="quantity{{$cart->product}}" name="quantity" value="{{$cart->quantity}}">
                                        </form>
                                        <td class="text-center">{{$settings[0]->currency_sign}}<span id="price{{$cart->product}}">{{number_format($cart->cost,2)}}</span><br>

                                            @if($settings[0]->shipping_information == "Per Product")
                                            <input type="hidden" name="shipping_cost{{$cart->product}}" value="{{$cart->shipping_cost}}">
                                                @if($cart->shipping_cost != 0)
                                                    <span id="shipping_cost{{$cart->product}}">{{trans('app.ShippingCost')}}: {{$settings[0]->currency_sign}}{{number_format($cart->shipping_cost,2)}}</span><br>
                                                @endif
                                            @endif

                                            @if($settings[0]->tax_information == "Per Product")
                                            <input type="hidden" name="tax_val{{$cart->product}}" value="{{$cart->tax}}">
                                                @if($cart->tax != 0)
                                                <span id="tax_val{{$cart->product}}">{{trans('app.Tax')}} ({{$cart->tax}} %): {{$settings[0]->currency_sign}}{{number_format($pr_tax,2)}}</span>
                                                @endif
                                            @endif

                                        </td>
                                        <td>{{$settings[0]->currency_sign}}<span id="subtotal{{$cart->product}}" class="subtotal">{{number_format($display_subtotal,2)}}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">
                                            <h3>{{trans('app.EmptyCart')}}</h3>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="tfooter_data">
                                    <input type="hidden" name="shipinfo" value="{{$settings[0]->shipping_information}}">
                                    <input type="hidden" name="taxinfo" value="{{$settings[0]->tax_information}}">
                                    @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                    <tr>
                                        <td colspan="5">
                                            <h4>{{trans('app.SubTotal')}}</h4>
                                        </td>
                                        <td colspan="2">
                                            <input type="hidden" name="sub_total" value="{{number_format($subtotal,2)}}">
                                            <h4>{{$settings[0]->currency_sign}}<span id="subtotal">{{number_format($subtotal,2)}}</span></h4>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($settings[0]->shipping_information  == 'Per Order')
                                        @if($shipcost != 0)
                                        <tr>
                                            <td colspan="5">
                                                <h4>{{trans('app.ShippingCost')}}</h4>
                                            </td>
                                            <td colspan="2">
                                                <input type="hidden" name="po_shipcost" value="{{$settings[0]->shipping_cost}}">
                                                <h4>{{$settings[0]->currency_sign}}<span>{{number_format($shipcost,2)}}</span></h4>
                                            </td>
                                        </tr>
                                        @endif
                                    @endif
                                    @if($settings[0]->tax_information  == 'Per Order')
                                        @if($tax != 0)
                                        <tr>
                                            <td colspan="5">
                                                <h4>{{trans('app.Tax')}} ({{$tax}}%)</h4>
                                            </td>
                                            <td colspan="2">
                                                <input type="hidden" name="po_tax" value="{{$settings[0]->tax}}">
                                                <h4>{{$settings[0]->currency_sign}}<span id="po_tax">{{number_format($totaltax,2)}}</span></h4>
                                            </td>
                                        </tr>
                                        @endif
                                    @endif
                                    <tr>
                                        <td colspan="5">
                                            <h4>{{trans('app.Total')}}</h4>
                                        </td>
                                        <td colspan="2">
                                            <input type="hidden" name="grand_total" value="{{number_format($grand_total,2)}}">
                                            <h4>{{$settings[0]->currency_sign}}<span id="grandtotal">{{number_format($grand_total,2)}}</span></h4>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">
                                            <a href="{{url('/')}}" class="shopping-btn">{{trans('app.ContinueShopping')}}</a>
                                        </td>
                                        <td colspan="4">
                                            <a href="{{route('user.checkout',$subdomain_name)}}" class="update-shopping-btn">{{trans('app.ProceedCheckout')}}</a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            @else
                                <div class="col-md-12 col-sm-12">
                                    <h4>{{trans('app.EmptyCart')}}</h4>
                                    <a href="{{url('/')}}" class="shopping-btn">{{trans('app.ContinueShopping')}}</a>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ending of add to cart table -->
    </div>

@stop

@section('footer')
<script>

</script>
@stop