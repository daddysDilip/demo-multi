@extends('themextra-e-comm.includes.newmaster')

@section('content')

<main>
    
    <section id="shopping_cart">
        <div class="container">
            <div class="row">
                @if(count($carts) > 0)
                <div class="col-md-9 detail_box">
                    <h2>{{trans('app.Mycart')}}</h2>
                    <div class="seprator"></div>
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif

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
                            <div class="row" id="item{{$cart->product}}">
                                <div class="col-md-2">
                                    @if($cart->productimage)
                                        <img src="{{url('/assets/images/products')}}/{{$cart->productimage}}" class="img-responsive disp_img">
                                    @else
                                        <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive disp_img">
                                    @endif
                                </div>
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
                                <div class="col-md-7">
                                    <h2 class="title"><a href="{{url('/product')}}/{{$cart->product}}/{{str_replace(' ','-',strtolower(\App\Product::findOrFail($cart->product)->title))}}">{{$cart->title}}</a></h2>
                                    <div class="input-group">
                                        <div class="cart-btn">
                                            <span class="qty_number" id="number{{$cart->product}}">{{$cart->quantity}}</span>
                                            <span class="quantity-cart-minus" id="minus{{$cart->product}}"><i class="fa fa-minus"></i></span>
                                            <span class="quantity-cart-plus" id="plus{{$cart->product}}" max="{{get_quantity($cart->product)}}"><i class="fa fa-plus"></i></span>
                                        </div>
                                        <div class="error{{$cart->product}}"  style="color:red"></div>
                                    </div>
                                    <div class="shop_text">
                                        <div class="price_bg">
                                            <div class="price_in" id="price{{$cart->product}}">{{$settings[0]->currency_sign}}{{number_format($cart->cost,2)}}
                                            </div>
                                        </div>
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
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="seprator"></div>

                                    <div class="roar">
                                        <div class="ratings">
                                            <div class="empty-stars"></div>
                                            <div class="full-stars" style="width:{{\App\Review::ratings($cart->id)}}%"></div>
                                            @if(\App\Review::reviewCount($cart->id) > 1)
                                                <span class="review_label">{{\App\Review::reviewCount($cart->id)}} </span>
                                            @else
                                                <span class="review_label">{{\App\Review::reviewCount($cart->id)}} </span>
                                            @endif
                                        </div>
                                        <span class="avail">{{trans('app.Availability')}} : <span>@if(get_quantity($cart->product) != 0) {{trans('app.InStock')}} @else {{trans('app.OutStock')}} @endif</span></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div>
                                        <span class="price subtotal">{{$settings[0]->currency_sign}}<span id="subtotal{{$cart->product}}">{{number_format($display_subtotal,2)}}</span>
                                        </span>
                                        <a href="javascript:;" onclick="getDelete({{$cart->product}})" class="trash">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="seprator"></div>
                        @empty
                            <div>
                                <h3>{{trans('app.EmptyCart')}}</h3>
                            </div>
                        @endforelse
                    
                    <div class="add-cart shopping-btn f-12"><a href="{{url('/')}}" class="text-white">{{trans('app.ContinueShopping')}}</a></div>
                </div>
                <div class="col-md-3 cart_sidebar">
                    <div class="detail_box">
                        <input type="hidden" name="shipinfo" value="{{$settings[0]->shipping_information}}">
                        <input type="hidden" name="taxinfo" value="{{$settings[0]->tax_information}}">

                        @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                            <div>
                                <span class="heading">{{trans('app.SubTotal')}}</span>
                                <input type="hidden" name="sub_total" value="{{number_format($subtotal,2)}}">
                                <span class="price_tt">{{$settings[0]->currency_sign}}<span id="subtotal">{{number_format($subtotal,2)}}</span></span>
                            </div>
                        @endif
                        @if($settings[0]->shipping_information  == 'Per Order')
                            @if($shipcost != 0)
                            <div>
                                <span class="heading">{{trans('app.ShippingCost')}}</span>
                                <input type="hidden" name="po_shipcost" value="{{$settings[0]->shipping_cost}}">
                                <span class="price_tt">{{$settings[0]->currency_sign}}{{number_format($shipcost,2)}}</span>
                            </div>
                            @endif
                        @endif
                        @if($settings[0]->tax_information  == 'Per Order')
                            @if($tax != 0)
                            <div>
                                <span class="heading">{{trans('app.Tax')}} ({{$tax}}%)</span>
                                <input type="hidden" name="po_tax" value="{{$settings[0]->tax}}">
                                <span class="price_tt">{{$settings[0]->currency_sign}}<span id="po_tax">{{number_format($totaltax,2)}}</span></span>
                            </div>
                            @endif
                        @endif
                        <div>
                            <span class="heading">{{trans('app.Total')}}</span>
                            <input type="hidden" name="grand_total" value="{{number_format($grand_total,2)}}">
                            <span class="price_tt">{{$settings[0]->currency_sign}}<span id="grandtotal">{{number_format($grand_total,2)}}</span></span>
                        </div>
                        <div class="seprator mar_sap"></div>
                        <a href="{{route('user.checkout',$subdomain_name)}}" class="checkout">{{trans('app.ProceedCheckout')}}</a>
                    </div>
                </div>  
                @else
                <div class="col-md-12 detail_box">
                    <h5 style="margin-left: 20px;">{{trans('app.EmptyCart')}}</h5>
                    <div class="add-cart shopping-btn f-12"><a href="{{url('/')}}" class="text-white">{{trans('app.ContinueShopping')}}</a></div>
                </div>
                @endif
            </div>
        </div>
    </section>

</main>

@stop

@section('footer')
<script>

</script>
@stop