@extends('ecommerce-3.includes.newmaster')

@section('content')

<main>

    <section id="wishlist">
        <div class="container"> 
            <div class="row">

                @if(count($carts) > 0)
                <div class="col-sm-12">
                    <h2>My Cart</h2>
                    <hr>

                    <div class="">
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif  
                        <table class="product_cart table table-hover">
                          <thead>
                            <tr>
                              <td></td>
                              <td>Image</td>
                              <td>{{$language->product_name}}</td>
                              <td>{{$language->unit_price}}</td>
                              <td>{{$language->quantity}}</td>
                              <td>{{$language->subtotal}}</td>
                            </tr>
                          </thead>
                          <tbody>

                            @php $subtotal = 0 @endphp

                            @foreach($carts as $cart)
                                        
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
                                    <td>
                                        <a onclick="getDelete({{$cart->product}})" class="delete"><i class="fas fa-times"></i></a>
                                    </td>
                                    <td class="img-box">
                                        @if($cart->productimage)
                                            <img src="{{url('/assets/images/products')}}/{{$cart->productimage}}" alt="">
                                        @else
                                            <img src="{{url('/assets/images')}}/placeholder.jpg" alt="">
                                        @endif
                                    </td>
                                    <td data-title="{{$language->product_name}}">
                                        <a href="{{url('/product')}}/{{$cart->product}}/{{str_replace(' ','-',strtolower(\App\Product::findOrFail($cart->product)->title))}}" class="name">{{$cart->title}}</a>
                                    </td>
                                    <td data-title="{{$language->unit_price}}">
                                        <p class="cart-btn">
                                            <span class="quantity-cart-minus" id="minus{{$cart->product}}"><i class="fa fa-minus"></i></span>
                                            <span id="number{{$cart->product}}">{{$cart->quantity}}</span>
                                            <span class="quantity-cart-plus" id="plus{{$cart->product}}" max="{{get_quantity($cart->product)}}"><i class="fa fa-plus"></i></span>
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
                                    <td data-title="{{$language->quantity}}">
                                        <span class="amount" id="price{{$cart->product}}">{{$settings[0]->currency_sign}}{{number_format($cart->cost,2)}}</span>
                                        <ul>
                                            @if($settings[0]->shipping_information == "Per Product")
                                            <input type="hidden" name="shipping_cost{{$cart->product}}" value="{{$cart->shipping_cost}}">
                                                @if($cart->shipping_cost != 0)
                                                    <li id="shipping_cost{{$cart->product}}">{{$language->shipping_cost}}: {{$settings[0]->currency_sign}}{{number_format($cart->shipping_cost,2)}}</li>
                                                @endif
                                            @endif
                                            @if($settings[0]->tax_information == "Per Product")
                                            <input type="hidden" name="tax_val{{$cart->product}}" value="{{$cart->tax}}">
                                                @if($cart->tax != 0)
                                                    <li id="tax_val{{$cart->product}}">{{$language->tax}} ({{$cart->tax}} %): {{$settings[0]->currency_sign}}{{number_format($pr_tax,2)}}</li>
                                                @endif
                                            @endif
                                        </ul>
                                    </td>
                                    <td class="product-subtotal" data-title="">
                                        <span class="amount">{{$settings[0]->currency_sign}}<span id="subtotal{{$cart->product}}" class="subtotal">{{number_format($display_subtotal,2)}}</span></span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <div class="add-cart shopping-btn f-12"><a href="{{url('/')}}" class="text-white">{{$language->continue_shopping}}</a></div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-4 col-sm-6" style="float: right;">
                        <div class="cart_total_box">
                            <h4>cart totals</h4>
                            <input type="hidden" name="shipinfo" value="{{$settings[0]->shipping_information}}">
                            <input type="hidden" name="taxinfo" value="{{$settings[0]->tax_information}}">
                            <div class="table-responsive">
                                <table class="cart_total">
                                    @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                    <tr>
                                      <th>{{$language->subtotal}}</th>
                                      <td><input type="hidden" name="sub_total" value="{{round($subtotal,2)}}">{{$settings[0]->currency_sign}}<span  id="subtotal">{{number_format($subtotal,2)}}</span></td>
                                    </tr>
                                    @endif
                                    @if($settings[0]->shipping_information  == 'Per Order')
                                    <tr>
                                      <th>{{$language->shipping_cost}}</th>
                                      <td><input type="hidden" name="po_shipcost" value="{{$settings[0]->shipping_cost}}">{{$settings[0]->currency_sign}}{{number_format($shipcost,2)}}</td>
                                    </tr>
                                    @endif
                                    @if($settings[0]->tax_information  == 'Per Order')
                                    <tr>
                                        <th>{{$language->tax}} ({{$tax}}%)</th>
                                        <td><input type="hidden" name="po_tax" value="{{$settings[0]->tax}}">{{$settings[0]->currency_sign}}<span id="po_tax">{{number_format($totaltax,2)}}</span></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>{{$language->total}}</th>
                                        <td><input type="hidden" name="grand_total" value="{{round($grand_total,2)}}">{{$settings[0]->currency_sign}}<span id="grandtotal">{{number_format($grand_total,2)}}</span></td>
                                    </tr>
                                </table>
                                <a href="{{route('user.checkout',$subdomain_name)}}" class="checkout btn text-white">proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <h4>{{$language->empty_cart}}</h4>
                    <div class="add-cart shopping-btn f-12"><a href="{{url('/')}}" class="text-white">{{$language->continue_shopping}}</a></div>
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