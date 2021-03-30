@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{trans('app.Mycart')}}</li>
          </ol>
        </div>
    </nav>
    
    <div class="my-cart-wrap">
        <div class="container">
            <div class="row">

                @if(count($carts) > 0)
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table-cart table">
                            <thead>
                                <tr>
                                    <th class="product-name" colspan="2">{{trans('app.ProductName')}}</th>
                                    <th class="product-quantity">{{trans('app.Quantity')}}</th>
                                    <th class="product-price">{{trans('app.UnitPrice')}}</th>
                                    <th class="product-subtotal" colspan="2">{{trans('app.SubTotal')}}</th>
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
                                <tr class="cart_item" id="item{{$cart->product}}">
                                    <td class="product-thumbnail" data-title="Image">
                                        <a href="{{url('/product')}}/{{$cart->product}}/{{str_replace(' ','-',strtolower(\App\Product::findOrFail($cart->product)->title))}}">
                                            @if($cart->productimage)
                                                <img src="{{url('/assets/images/products')}}/{{$cart->productimage}}" alt="">
                                            @else
                                                <img src="{{url('/assets/images')}}/placeholder.jpg" alt="">
                                            @endif
                                        </a>
                                    </td>
                                    <td class="product-name" data-title="Product">
                                        <a href="{{url('/product')}}/{{$cart->product}}/{{str_replace(' ','-',strtolower(\App\Product::findOrFail($cart->product)->title))}}">{{$cart->title}}</a>
                                    </td>
                                    <td class="product-quantity" data-title="Quantity">
                                        <p class="quantity buttons_added">
                                            <span class="quantity-cart-minus minus" id="minus{{$cart->product}}"><i class="fa fa-minus"></i></span>
                                            <span id="number{{$cart->product}}" class="input-text qty text">{{$cart->quantity}}</span>
                                            <span class="quantity-cart-plus plus" id="plus{{$cart->product}}" max="{{get_quantity($cart->product)}}"><i class="fa fa-plus"></i></span>
                                        </p>
                                        <div class="error{{$cart->product}}"  style="color:red"></div>
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
                                    <td class="product-price" data-title="Price">
                                        <span class="amount" id="price{{$cart->product}}">{{$settings[0]->currency_sign}}{{number_format($cart->cost,2)}}</span>
                                        <ul>
                                            @if($settings[0]->shipping_information == "Per Product")
                                            <input type="hidden" name="shipping_cost{{$cart->product}}" value="{{$cart->shipping_cost}}">
                                                @if($cart->shipping_cost != 0)
                                                    <li id="shipping_cost{{$cart->product}}">{{trans('app.ShippingCost')}}: {{$settings[0]->currency_sign}}{{number_format($cart->shipping_cost,2)}}</li>
                                                @endif
                                            @endif
                                            @if($settings[0]->tax_information == "Per Product")
                                            <input type="hidden" name="tax_val{{$cart->product}}" value="{{$cart->tax}}">
                                                @if($cart->tax != 0)
                                                    <li id="tax_val{{$cart->product}}">{{trans('app.Tax')}} ({{$cart->tax}} %): {{$settings[0]->currency_sign}}{{number_format($pr_tax,2)}}</li>
                                                @endif
                                            @endif
                                        </ul>
                                    </td>
                                    <td class="product-subtotal" data-title="Total">
                                        <span class="amount">{{$settings[0]->currency_sign}}<span id="subtotal{{$cart->product}}" class="subtotal">{{number_format($display_subtotal,2)}}</span></span>
                                    </td>
                                    <td class="product-remove">
                                        <a href="javascript:;" onclick="getDelete({{$cart->product}})" class="remove" title="Remove this item">
                                          <i class="far fa-times-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <h3>{{trans('app.EmptyCart')}}</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <a href="{{url('/')}}" class="btn shopping-btn">{{trans('app.ContinueShopping')}}</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="cart-total">
                        <h5>{{trans('app.CartTotal')}}</h5>
                        <input type="hidden" name="shipinfo" value="{{$settings[0]->shipping_information}}">
                        <input type="hidden" name="taxinfo" value="{{$settings[0]->tax_information}}">
                        <ul>
                            @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                            <li>
                                <span class="title">{{trans('app.SubTotal')}}</span>
                                <input type="hidden" name="sub_total" value="{{round($subtotal,2)}}">
                                <span class="amt">{{$settings[0]->currency_sign}}<span  id="subtotal">{{number_format($subtotal,2)}}</span></span>
                            </li>
                            @endif
                            @if($settings[0]->shipping_information  == 'Per Order')
                                @if($shipcost != 0)
                                <li>
                                    <span class="title">{{trans('app.ShippingCost')}}</span>
                                    <input type="hidden" name="po_shipcost" value="{{$settings[0]->shipping_cost}}">
                                    <span class="amt">{{$settings[0]->currency_sign}}{{number_format($shipcost,2)}}</span>
                                </li>
                                @endif
                            @endif
                            @if($settings[0]->tax_information  == 'Per Order')
                                @if($tax != 0)
                                <li>
                                    <span class="title">{{trans('app.Tax')}} ({{$tax}}%)</span>
                                    <input type="hidden" name="po_tax" value="{{$settings[0]->tax}}">
                                    <span class="amt">{{$settings[0]->currency_sign}}<span id="po_tax">{{number_format($totaltax,2)}}</span></span>
                                </li>
                                @endif
                            @endif
                            <li class="g-total">
                                <span class="title">{{trans('app.Total')}}</span>
                                <input type="hidden" name="grand_total" value="{{round($grand_total,2)}}">
                                <span class="amt">{{$settings[0]->currency_sign}}<span id="grandtotal">{{number_format($grand_total,2)}}</span></span>
                            </li>
                        </ul>
                        <!-- <button class="add-cart f-12 text-uppercase">Update cart</button> -->
                        <a href="{{route('user.checkout',$subdomain_name)}}" class="text-white checkout">{{trans('app.ProceedCheckout')}}</a>
                    </div>
                </div>
                @else
                    <div class="col-md-12">
                        <h4>{{trans('app.EmptyCart')}}</h4>
                        <a href="{{url('/')}}" class="btn shopping-btn">{{trans('app.ContinueShopping')}}</a>
                    </div>
                @endif
            </div>
        </div>
    </div> 
    
</main>

@stop

@section('footer')
<script>

</script>
@stop