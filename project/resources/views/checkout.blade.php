@extends('includes.newmaster')
@section('content')
    
<style type="text/css">
    .cart_total tr td
    {
        border-top: none !important;
    }
    .cart_total tr td h4
    {
        margin: 0px;
    }
    .shopping_cart_product
    {
        border-bottom: 1px solid #ccc;
    }
    .shopping_cart_product tbody td {
        border-bottom: 1px solid #ccc;
    }
</style>
@if(Auth::guard('profile')->guest())
@else
@if(count($discount) > 0)

<div class="discountslider">
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" >
                        @php $i=0; @endphp 
                        @foreach($discount as $all) 
                    
                        <div class="item <?php echo ($i == 0) ? 'active' : ''; ?>">
                            <div class="voucher_bgimg">
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-8 show_detail">
                                    <h3 class="title">{{$all->title}}</h3>
                                    <button class="btn btn-primary coupon_code_btn" data-toggle="modal" data-target="#discountModal" data-code="{{$all->code}}" data-description="{{$all->description}}" data-title="{{$all->title}}">{{trans('app.GetCouponCode')}}</button>
                                </div> 
                                <div class="coupon_code"></div>
                                <div class="coupon_description"></div>
                            </div>
                        </div>

                        @php $i++; @endphp
                        @endforeach
                    </div>
                    @if ($i > 1)
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">{{trans('app.Previous')}}</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">{{trans('app.Next')}}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 

<div id="discountModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{trans('app.CouponCode')}}</h4>
      </div>
      <div class="modal-body">
        <div class="discount_detail">
            <div class="code_box">
                <div class="code_box_header">
                    <h4>{{trans('app.CopyCouponCode')}}</h4>
                </div>
                <div class="code_box_body">
                    <p id="vcode" style="display: none;"></p>
                    <button class="btn btn-default vtitle" onclick="copyToClipboard('#vcode')"></button>
                    <h4 id="code_copy" style="margin-top: 10px;"></h4>
                </div>
            </div>
            <h4 class="text-center"><b class="vcode"></b></h4>
            <div class="detail">
                <h4 class="text-center">{{trans('app.Details')}}</h4>
                <p class="vdescription"></p>
                <ul>
                </ul>
            </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('app.Close')}}</button>
      </div>
    </div>

  </div>
</div>

@endif
@endif
<div class="home-wrapper">
    <!-- Starting of product shipping form -->
    <div class="section-padding product-shipping-wrapper wow fadeInUp checkoutPage">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    @if(Auth::guard('profile')->guest())
                    <div class="signIn-area">
                        <h2 class="signIn-title text-center">{{trans('app.CustomerSignIn')}}</h2>
                        <hr/>
                        <form action="{{ route('user.login.submit',$subdomain_name) }}" method="POST" id="customer_login" style="width: 50%;margin: 0 auto;">
                            {{ csrf_field() }}

                            <input type="hidden" name="checkoutlogin" value="1">

                            <div class="form-group">
                                <label for="email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                <input class="form-control" value="{{ old('email') }}" type="email" name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label for="password">{{trans('app.Password')}} <span>*</span></label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="{{route('user.reg',$subdomain_name)}}">{{trans('app.CreateNewAccount')}}</a>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                        <a href="{{route('user.forgotpass',$subdomain_name)}}">{{trans('app.ForgotYourPassword')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div id="resp">
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                                @if ($errors->has('email'))
                                        <div class="alert alert-danger alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="btn btn-md login-btn" type="submit" value="{{trans('app.Login')}}">
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="product-shipping-full-div">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 45px;">
                                <h3 class="signIn-title">{{trans('app.OrderDetails')}}</h3>
                                <hr/>
                                <div class="pricing-list">
                                    <table class="table shopping_cart_product">
                                        <thead>
                                        <tr>
                                            <th class="product_name">{{trans('app.ProductName')}}</th>
                                            <th class="quantity" width="20%">{{trans('app.Quantity')}}</th>
                                            <th class="unit_price" width="20%">{{trans('app.UnitPrice')}}</th>
                                            <th class="subtotal" width="20%">{{trans('app.SubTotal')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        @php $subtotal = 0 @endphp

                                        @foreach($cartdata as $cart)
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
                                            <tr>
                                                <td class="product_name"><a href="{{url('/product')}}/{{$cart->product}}/{{str_replace(' ','-',strtolower(\App\Product::findOrFail($cart->product)->title))}}" target="_blank">{{$cart->title}}</a></td>
                                                <td class="quantity">{{$cart->quantity}}</td>
                                                <td  class="unit_price">{{$settings[0]->currency_sign}}<span id="price{{$cart->product}}">{{number_format($cart->cost,2)}}</span><br>

                                                    @if($settings[0]->shipping_information == "Per Product")
                                                        @if($cart->shipping_cost != 0)
                                                        <span id="shipping_cost{{$cart->product}}">{{trans('app.ShippingCost')}}: {{$settings[0]->currency_sign}}{{number_format($cart->shipping_cost,2)}}</span><br>
                                                        @endif
                                                    @endif

                                                    @if($settings[0]->tax_information == "Per Product")
                                                        @if($cart->tax != 0)
                                                            <span id="tax_val{{$cart->product}}">{{trans('app.Tax')}} ({{$cart->tax}} %): {{$settings[0]->currency_sign}}{{number_format($pr_tax,2)}}</span>
                                                        @endif
                                                    @endif

                                                </td>
                                                <td  class="subtotal">{{$settings[0]->currency_sign}}{{number_format($display_subtotal,2)}}</td>
                                            </tr>
                                            <tr></tr>
                                        @endforeach
                                        </tbody>
                                        @if(count($discount) > 0)
                                        <tfoot>
                                            <tr>
                                                <td colspan="">
                                                    <div class="coupon_code">
                                                        <input type="text" name="coupon" class="form-control coupon" placeholder="{{trans('app.EnterCouponCode')}}"><button type="button" class="btn btn-upper btn-primary outer-left-xs apply_code">{{trans('app.Apply')}}</button>
                                                        <span class="voucher_error" style="display:none;color:red;">{{trans('app.EnterValidCouponCode')}}</span>
                                                    </div>
                                                </td>
                                                <td colspan="3"></td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                    <table class="table cart_total">
                                        @if($settings[0]->shipping_information  == 'Per Order' || $settings[0]->tax_information  == 'Per Order')
                                        <tr align="right">
                                            <td><h4>{{trans('app.SubTotal')}}:</h4></td>
                                            <td width="20%"><h4>{{$settings[0]->currency_sign}}<span id="sub_total">{{number_format($subtotal,2)}}</span></h4></td>
                                        </tr>
                                        @else
                                        <tr align="right">
                                            <td class="display_sub_total"><h4>{{trans('app.SubTotal')}}:</h4></td>
                                            <td width="20%" class="display_sub_total"><h4>{{$settings[0]->currency_sign}}<span id="sub_total">{{number_format($subtotal,2)}}</span></h4></td>
                                        </tr>
                                        @endif
                                        <tr class="coupon_data" align="right">
                                            <td><h4>{{trans('app.Discount')}} :<br> <div class="code_title"></h4></div> </td>
                                            <td class="discount">
                                                <h4 class="discount_val"></h4>
                                                <h4 class="discount_val1"></h4>
                                            </td>
                                        </tr>
                                        @if($settings[0]->shipping_information  == 'Per Order')
                                        <tr align="right">
                                            @if($shipcost != 0)
                                                <td><h4>{{trans('app.ShippingCost')}}:</h4></td>
                                                <td width="20%"><h4>{{$settings[0]->currency_sign}}<span id="ship-cost">{{number_format($shipcost,2)}}</span></h4></td>
                                            @endif
                                        </tr>
                                        @endif
                                        @if($settings[0]->tax_information  == 'Per Order')
                                        <tr align="right">
                                            @if($tax != 0)
                                                <td><h4>{{trans('app.Tax')}} ({{$tax}} %):</h4></td>
                                                <td width="20%"><h4>{{$settings[0]->currency_sign}}<span id="ship-cost" class="ptotaltax">{{number_format($totaltax,2)}}</span></h4></td>
                                            @endif
                                        </tr>
                                        @endif
                                        <tr align="right">
                                            <td><h4>{{trans('app.Total')}}:</h4></td>
                                            <td width="20%"><h4>{{$settings[0]->currency_sign}}<span id="total-cost" class="grand_total_val">{{number_format($grand_total,2)}}</span></h4></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
							
                            <form  action="" method="post" id="payment_form">
                                {{csrf_field()}}
                                <input type="hidden" name="shippinginfo" value="{{$settings[0]->shipping_information}}">
                                <input type="hidden" name="taxinfo" value="{{$settings[0]->tax_information}}">
                                <input type="hidden" name="vouchercode" class="add_vouchercode">
                                <input type="hidden" name="discountprice" class="discountprice">
                                <input type="hidden" name="discountid" class="discountid">
                                <input type="hidden" name="sub_total" value="{{$subtotal}}">
                                <input type="hidden" name="currency_sign" value="{{$settings[0]->currency_sign}}">
                                @if($settings[0]->shipping_information  == 'Per Order')
                                    <input type="hidden" name="productshipping" value="{{$shipcost}}">
                                @else
                                    <input type="hidden" name="productshipping" value="0">
                                @endif
                                @if($settings[0]->tax_information  == 'Per Order')
                                    <input type="hidden" name="producttax" value="{{$tax}}">
                                @else
                                    <input type="hidden" name="producttax" value="0">
                                @endif
                                <input type="hidden" name="total" class="final_total" value="{{$grand_total}}">

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="billing-details-area">
                                        <h2 class="signIn-title">{{trans('app.BillingDeatils')}}</h2>
                                        <hr/>
                                        <div class="form-group">
                                            <select class="form-control" onChange="sHipping(this)" id="shipop" name="shipping" required>
                                                <option value="shipto" selected>{{trans('app.ShipToAddress')}}</option>
                                                <option value="pickup">{{trans('app.PickUp')}}</option>
                                            </select>
                                        </div>

                                    <div id="pick" style="display:none;">
                                        <div class="form-group">
                                            <select class="form-control" name="pickup_location">
                                                <option value="">{{trans('app.SelectPickUpLocation')}}</option>
                                                @foreach($pickups as $pickup)
                                                    <option value="{{$pickup->address}}">{{$pickup->address}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @php $bfirstname = ( isset($address) ? $address->billing_firstname : '');  @endphp
                                    <div class="form-group">
                                        <label for="customer_firstname">{{trans('app.FirstName')}} <span>*</span></label>
                                        <input class="form-control" type="text" name="customer_firstname" id="customer_firstname" maxlength="30" minlength="3" value="{{$bfirstname}}">
                                    </div>

                                    @php $blastname = ( isset($address) ? $address->billing_lastname : '');  @endphp
                                    <div class="form-group">
                                        <label for="customer_lastname">{{trans('app.LastName')}} <span>*</span></label>
                                        <input class="form-control" type="text" name="customer_lastname" id="" maxlength="30" minlength="3" value="{{$blastname}}">
                                    </div>

                                    @php $bphone = ( isset($address) ? $address->billing_phone : '');  @endphp
                                    <div class="form-group">
                                        <label for="customer_phone">{{trans('app.PhoneNumber')}}<span>*</span></label>
                                        <input type="text" class="form-control" name="phone" value="{{$bphone}}" maxlength="10" minlength="10" onkeypress="return isNumber(event)">
                                    </div>

                                    @php $bemail = ( isset($address) ? $address->billing_email : '');  @endphp
                                    <div class="form-group">
                                        <label for="customer_email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                        <input type="email" class="form-control" name="email" value="{{$bemail}}" maxlength="50" minlength="3">
                                    </div>

                                    @php $baddress = ( isset($address) ? $address->billing_address : '');  @endphp
                                    <div class="form-group">
                                        <label for="customer_address">{{trans('app.Address')}} <span>*</span></label>
                                        <textarea class="form-control" name="address" id="billing_address" cols="30" rows="1" style="resize: vertical;"maxlength="255" minlength="3">{{$baddress}}</textarea>
                                    </div>

                                    @php $bcountry = ( isset($address) ? $address->billing_country : '');  @endphp
                                    <div class="item form-group">
                                        <label for="customer_country">{{trans('app.Country')}} <span>*</span></label>
                                        <select class="form-control" name="country" id="country" required>
                                            <option value="">{{trans('app.SelectCountry')}}</option>
                                            @foreach($country as $allcountry)
                                                <option value="{{$allcountry->id}}" {{ ($bcountry == $allcountry->id ? 'selected': '') }}>{{$allcountry->countryname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    @php $bstate = ( isset($address) ? $address->billing_state : '');  @endphp
                                    <div class="item form-group">
                                        <label for="customer_state">{{trans('app.State')}} <span>*</span></label>
                                        <div id='state_loader' style='display: none;position: absolute;'>
                                            <img src='{{url('/')}}/assets/images/ajax.gif' width='32px' height='32px'>
                                        </div>
                                        <select class="form-control" name="state" id="state" required>
                                            <option value="">{{trans('app.SelectState')}}</option>
                                            @if(isset($address))
                                            @foreach($billingstate as $allstate)
                                                <option value="{{$allstate->id}}" {{ ($bstate == $allstate->id ? 'selected': '') }}>{{$allstate->statename}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    
                                    @php $bcity = ( isset($address) ? $address->billing_city : '');  @endphp
                                    <div class="item form-group">
                                        <label for="customer_city">{{trans('app.City')}} <span>*</span></label>
                                        <div id='city_loader' style='display: none;position: absolute;'>
                                            <img src='{{url('/')}}/assets/images/ajax.gif' width='32px' height='32px'>
                                        </div>
                                        <select class="form-control" name="city" id="city" required>
                                            <option value="">{{trans('app.SelectCity')}}</option>
                                            @if(isset($address))
                                            @foreach($billingcity as $allcity)
                                                <option value="{{$allcity->id}}" {{ ($bcity == $allcity->id ? 'selected': '') }}>{{$allcity->cityname}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    @php $bzip = ( isset($address) ? $address->billing_zip : '');  @endphp
                                    <div class="form-group">
                                        <label for="customer_zip">{{trans('app.PostalCode')}} <span>*</span></label>
                                        <input type="text" class="form-control" name="zip" value="{{$bzip}}" maxlength="6" minlength="6" onkeypress="return isNumber(event)" >
                                    </div>
                                    <input type="hidden" name="customer" value="{{Auth::guard('profile')->user()->id}}" />
                                
                                    <div class="form-group">
                                        <label>{{trans('app.SelectPaymentMethod')}} <span>*</span></label>
                                        <select name="method" onChange="meThods(this)" class="form-control">
                                            <option value="" selected>{{trans('app.SelectPaymentMethod')}}</option>
                                            @if($settings[0]->paypal_status == 1)
                                                <option value="Paypal">{{trans('app.Paypal')}}</option>
                                            @endif
                                            @if($settings[0]->stripe_status == 1)
                                                <option value="Stripe">{{trans('app.CreditCard')}}</option>
                                            @endif
                                            @if($settings[0]->mobile_status == 1)
                                                <option value="Mobile">{{trans('app.MobileMoney')}}</option>
                                            @endif
                                            @if($settings[0]->bank_status == 1)
                                                <option value="Bank">{{trans('app.BankWire')}}</option>
                                            @endif
                                            @if($settings[0]->cash_status == 1)
                                                <option value="Cash">{{trans('app.CashOnDelivery')}}</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div id="mobile" style="display: none;">
                                        <div class="form-group">
                                            <strong>{{$settings[0]->mobile_money}}</strong>
                                        </div>
                                        <div class="form-group">
                                            <label for="mobile_transactionid">{{trans('app.TransactionID')}}# <span>*</span></label>
                                            <input type="text" class="form-control" name="txn_id" placeholder="{{trans('app.TransactionID')}}#" onkeypress="return isNumber(event)" maxlength="8" minlength="8">
                                        </div>
                                    </div>
                                    <div id="bank" style="display: none;">
                                        <div class="form-group">
                                            <strong>{{trans('app.Bank')}} {{$settings[0]->bank_wire}}</strong>
                                        </div>
                                        <div class="form-group">
                                            <label for="banck_  transactionid">{{trans('app.TransactionID')}}# <span>*</span></label>
                                            <input type="text" class="form-control" name="txn_id" placeholder="{{trans('app.TransactionID')}}#" onkeypress="return isNumber(event)" maxlength="8" minlength="8">
                                        </div>
                                    </div>
                                    <div id="stripes" style="display: none;">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="card" placeholder="{{trans('app.Card')}}" onkeypress="return isNumber(event)">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="cvv" placeholder="{{trans('app.Cvv')}}" onkeypress="return isNumber(event)" maxlength="4" minlength="3">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="month" placeholder="{{trans('app.Month')}}" onkeypress="return isNumber(event)" maxlength="2" minlength="2">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="year" placeholder="{{trans('app.Year')}}" onkeypress="return isNumber(event)" maxlength="4" minlength="4">
                                        </div>
                                    </div>

                                    <!-- <input type="hidden" name="total" id="grandtotal" value="{{number_format($total,2)}}" /> -->
                                    <input type="hidden" name="products" value="{{$product}}" />
                                    <input type="hidden" name="quantities" value="{{$quantity}}" />
                                    <input type="hidden" name="sizes" value="{{$sizes}}" />

                                    <div id="paypals">
                                        <input type="hidden" name="cmd" value="_xclick" />
                                        <input type="hidden" name="no_note" value="1" />
                                        <input type="hidden" name="lc" value="UK" />
                                        <input type="hidden" name="currency_code" value="{{$settings[0]->currency_code}}" />
                                        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="shipping-title">
                                    <label id="ship-diff">
                                        <input class="shippingCheck" type="checkbox" value="check" name="shipping_info"> 
                                        {{trans('app.ShipDiffAddress')}}
                                    </label>
                                    <label id="pick-info" style="display: none">
                                        {{trans('app.PickupLocationYouSelected')}}
                                    </label>
                                </div>
                                <hr/>
                                <div class="shipping-details-area">

                                    @php $sfirstname = ( isset($address) ? $address->shipping_firstname : '');  @endphp
                                    <div class="form-group">
                                        <label for="shipping_firstname">{{trans('app.FirstName')}} <span>*</span></label>
                                        <input class="form-control" type="text" name="shipping_firstname" id="shipping_firstname" maxlength="30" minlength="3" value="{{$sfirstname}}">
                                    </div>

                                    @php $slastname = ( isset($address) ? $address->shipping_lastname : '');  @endphp
                                    <div class="form-group">
                                        <label for="shipping_lastname">{{trans('app.LastName')}} <span>*</span></label>
                                        <input class="form-control" type="text" name="shipping_lastname" id="shipping_lastname" maxlength="30" minlength="3" value="{{$slastname}}">
                                    </div>

                                    @php $sphone = ( isset($address) ? $address->shipping_phone : '');  @endphp
                                    <div class="form-group">
                                        <label for="shipping_phone">{{trans('app.PhoneNumber')}} <span>*</span></label>
                                        <input class="form-control" type="text" name="shipping_phone" id="shipping_phone" onkeypress="return isNumber(event)" maxlength="10" minlength="10" value="{{$sphone}}"> 
                                    </div>

                                    @php $semail = ( isset($address) ? $address->shipping_email : '');  @endphp
                                    <div class="form-group">
                                        <label for="ship_email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                        <input class="form-control" type="email" name="shipping_email" id="ship_email" maxlength="50" minlength="3" value="{{$semail}}">
                                    </div>

                                    @php $saddress = ( isset($address) ? $address->shipping_address : '');  @endphp
                                    <div class="form-group">
                                        <label for="shipping_address">{{trans('app.Address')}} <span>*</span></label>
                                        <textarea class="form-control" name="shipping_address" id="shipping_address" cols="30" rows="1" style="resize: vertical;"maxlength="255" minlength="3">{{$saddress}}</textarea>
                                    </div>

                                    @php $scountry = ( isset($address) ? $address->shipping_country : '');  @endphp
                                    <div class="item form-group">
                                        <label for="shipping_country">{{trans('app.Country')}} <span>*</span></label>
                                        <select class="form-control" name="shipping_country" id="shipping_country" required>
                                            <option value="">{{trans('app.SelectCountry')}}</option>
                                            @foreach($country as $allcountry)
                                          <option value="{{$allcountry->id}}" {{ ($scountry == $allcountry->id ? 'selected': '') }}>{{$allcountry->countryname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    @php $sstate = ( isset($address) ? $address->shipping_state : '');  @endphp
                                    <div class="item form-group">
                                        <label for="shipping_state">{{trans('app.State')}} <span>*</span></label>
                                        <div id='sstate_loader' style='display: none;position: absolute;'>
                                            <img src='{{url('/')}}/assets/images/ajax.gif' width='32px' height='32px'>
                                        </div>
                                        <select class="form-control" name="shipping_state" id="shipping_state" required>
                                            <option value="">{{trans('app.SelectState')}}</option>
                                            @if(isset($address))
                                            @foreach($shippingstate as $allstate)
                                                <option value="{{$allstate->id}}" {{ ($sstate == $allstate->id ? 'selected': '') }}>{{$allstate->statename}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    
                                    @php $scity = ( isset($address) ? $address->shipping_city : '');  @endphp
                                    <div class="item form-group">
                                        <label for="shipping_city">{{trans('app.City')}} <span>*</span></label>
                                        <div id='scity_loader' style='display: none;position: absolute;'>
                                            <img src='{{url('/')}}/assets/images/ajax.gif' width='32px' height='32px'>
                                        </div>
                                        <select class="form-control" name="shipping_city" id="shipping_city" required>
                                            <option value="">{{trans('app.SelectCity')}}</option>
                                            @if(isset($address))
                                            @foreach($shippingcity as $allcity)
                                                <option value="{{$allcity->id}}" {{ ($scity == $allcity->id ? 'selected': '') }}>{{$allcity->cityname}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    @php $szip = ( isset($address) ? $address->shipping_zip : '');  @endphp
                                    <div class="form-group">
                                        <label for="shippingPostal_code">{{trans('app.PostalCode')}} <span>*</span></label>
                                        <input class="form-control" type="text" name="shipping_zip" id="shippingPostal_code" onkeypress="return isNumber(event)" maxlength="6" minlength="6" value="{{$szip}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="order_notes">{{trans('app.OrderNotes')}}</label>
                                    <textarea class="form-control order-notes" name="order_notes" id="order_notes" cols="30" rows="5" style="resize: vertical;" maxlength="255" minlength="3"></textarea>
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="form-group">
                                    <input class="btn btn-md order-btn" type="submit" value="{{trans('app.OrderNow')}}">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Ending of product shipping form -->

</div>


@stop
@section('footer')
<script type="text/javascript">
function meThods(val) {
    var action1 = "{{route('payment.submit',$subdomain_name)}}";
    var action2 = "{{route('stripe.submit',$subdomain_name)}}";
    var action3 = "{{route('cash.submit',$subdomain_name)}}";
    var action4 = "{{route('mobile.submit',$subdomain_name)}}";
    var action5 = "{{route('bank.submit',$subdomain_name)}}";
    if (val.value == "Mobile") {
        $("#payment_form").attr("action", action4);
        $("#stripes").hide();
        $("#mobile").show();
        $("#bank").hide();
    }
    if (val.value == "Bank") {
        $("#payment_form").attr("action", action5);
        $("#stripes").hide();
        $("#mobile").hide();
        $("#bank").show();
    }
    if (val.value == "Paypal") {
        $("#payment_form").attr("action", action1);
        $("#stripes").hide();
        $("#mobile").hide();
        $("#bank").hide();
    }
    if (val.value == "Stripe") {
        $("#payment_form").attr("action", action2);
        $("#stripes").show();
        $("#mobile").hide();
        $("#bank").hide();
    }
    if (val.value == "Cash") {
        $("#payment_form").attr("action", action3);
        $("#stripes").hide();
        $("#mobile").hide();
        $("#bank").hide();
    }
}

function sHipping(val) {
    var shipcost = parseFloat($("#ship-cost").html());
    var totalcost = parseFloat($("#total-cost").html());
    var total = 0;
    //alert(val.value);
    if (val.value == "shipto") {

        $("#pick").hide();
        $("#ship-diff").show();
        $("#pick-info").hide();
        if ($(this).prop('checked')==true){ 
            $(".shipping-details-area").show();
        }
        else
        {
            $(".shipping-details-area").hide();
        }
    }

    if (val.value == "pickup") {
        $(".shippingCheck").prop("checked", false);
        $("#pick").show();
        $("#pick-info").show();
        $("#ship-diff").hide();
        $(".shipping-details-area").hide();
        $("#shipto").find("input").prop('required',false);
    }
}

$(':input').change(function() {
    $(this).val($(this).val().trim());
});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

$(document).ready(function() {  
     
    $("#country").change(function(){  
        $("#state_loader").show(); 
        $("#state").hide(); 
        $.ajax({  
            url:"{{ URL('user/state_list') }}",  
            data: {countryid: $(this).val(),_token : $("input[name=_token]").val()},  
            type: "POST", 
            success:function(data)
            {  
                
                $("#state").show();  
                $("#state").html(data);  
                $("#state_loader").hide();
            }  
        });  
    });
 
    $("#state").change(function(){  
        $("#city_loader").show(); 
        $("#city").hide(); 
        $.ajax({  
            url:"{{ URL('user/city_list') }}",  
            data: {stateid: $(this).val(),_token : $("input[name=_token]").val()},  
            type: "POST",  
            success:function(data)
            {  
                $("#city").show();  
                $("#city").html(data);  
                $("#city_loader").hide();
            }  
      });  
    });  

    $("#shipping_country").change(function(){  
        $("#sstate_loader").show(); 
        $("#shipping_state").hide(); 
        $.ajax({  
            url:"{{ URL('user/state_list') }}",  
            data: {countryid: $(this).val(),_token : $("input[name=_token]").val()},  
            type: "POST", 
            success:function(data)
            {  
                
                $("#shipping_state").show();  
                $("#shipping_state").html(data);  
                $("#sstate_loader").hide();
            }  
        });  
    });
 
    $("#shipping_state").change(function(){  
        $("#scity_loader").show(); 
        $("#shipping_city").hide(); 
        $.ajax({  
            url:"{{ URL('user/city_list') }}",  
            data: {stateid: $(this).val(),_token : $("input[name=_token]").val()},  
            type: "POST",  
            success:function(data)
            {  
                $("#shipping_city").show();  
                $("#shipping_city").html(data);  
                $("#scity_loader").hide();
            }  
      });  
    });  
});

$.validator.addMethod('Validemail', function (value, element) {
    return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
}, ValidEmailError);

$.validator.addMethod('regCVV', function (value, element) {
    return this.optional(element) ||  value.match(/^[0-9]{3,4}$/);
}, regCVVError);

$.validator.addMethod('regMonth', function (value, element) {
    return this.optional(element) ||  value.match(/^01|02|03|04|05|06|07|08|09|10|11|12$/);
}, regMonthError);

$(document).ready(function(){

    var currentYear = new Date().getFullYear();

    $('#payment_form').validate({
        rules:{
            shipping:{
                required:true,  
            },
            pickup_location:{
                required:true,  
            },
            billing_firstname:{
                required:true,
                minlength:3,
                maxlength:30
            },
            billing_lastname:{
                required:true,
                minlength:3,
                maxlength:30
            },
            phone:{
                required:true,
                number:true,
                minlength:10,
                maxlength:10
            },
            email:{
                required:true,
                Validemail:true,
                minlength:3,
                maxlength:50
            },
            address:{
                required:true,
                minlength:3,
                maxlength:225
            },
            country:{
                required:true,
            },
            state:{
                required:true,
            },
            city:{
                required:true,
            },
            zip:{
                required:true,
                minlength:6,
                maxlength:6
            },
            method:{
                required:true,
            },
            card:{
                required:true,
                creditcard: true,
            },
            cvv:{
                required:true,
                regCVV:true,
            },
            month:{
                required:true,
                regMonth:true,
            },
            year:{
                required:true,
                minlength: 4,
                maxlength: 4,
            },
            txn_id:{
                required:true,
                number:true,
                minlength: 8,
                maxlength: 8,
            },
            shipping_firstname:{
                required:true,
                minlength:3,
                maxlength:30
            },
            shipping_lastmname:{
                required:true,
                minlength:3,
                maxlength:30
            },
            shipping_phone:{
                required:true,
                number:true,
                minlength:10,
                maxlength:50
            },
            shipping_email:{
                required:true,
                Validemail:true,
                minlength:3,
                maxlength:50
            },
            shipping_address:{
                required:true,
                minlength:3,
                maxlength:225
            },
            shipping_phone:{
                required:true,
                number:true,
                minlength:10,
                maxlength:50
            },
            shipping_email:{
                required:true,
                Validemail:true,
                minlength:3,
                maxlength:50
            },
            shipping_address:{
                required:true,
                minlength:3,
                maxlength:225
            },
            shipping_country:{
                required:true,
            },
            shipping_state:{
                required:true,
            },
            shipping_city:{
                required:true,
            },
            shipping_zip:{
                required:true,
                minlength:6,
                maxlength:6
            },
            order_notes:{
                minlength:3,
                maxlength:255
            }
        },
        highlight: function (element) {
            $(element).parent().addClass('has-error')
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('has-error')
        },
        errorElement: 'span',
        errorClass: 'text-danger',
    });

});

$(document).ready(function (e) { 
    $('.coupon_data').hide();   
    $('.voucher_error').css('display','none');
    $('.display_sub_total').hide();

    $('.apply_code').click(function(){
        var code = $('input[name="coupon"]').val();
        var subtotal = $('input[name="sub_total"]').val();
        var producttax = $('input[name="producttax"]').val();
        var shippingcost = $('input[name="productshipping"]').val();
        var tokenval = '{{csrf_token()}}';
        var customerid = $('input[name="customer"]').val();
        var currency = $('input[name="currency_sign"]').val();
        
        $.ajax({
            type: "POST",
            url: mainurl+'/checkout/vouchercode',
            dataType: 'json',
            data: {vouchercode: code,customerid: customerid, _token:tokenval},
            success: function (response) {
                var subtotalprice = parseInt(subtotal); 
                console.log(response.orderdetail[0]);
                 
                if(response.voucherdetail == '')
                {

                    //alert('test1');
                    $('.coupon_data').hide();   
                    $('.voucher_error').css('display','block');
                    $('.voucher_error').text(CouponNotExist);

                    var finalstotal = Number(subtotal) + Number(shippingcost);
                    var ptotaltax = finalstotal*(producttax/100);
                    var dtotal = Number(finalstotal) + Number(ptotaltax) ;

                    $('.ptotaltax').html(ptotaltax.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                    $('.grand_total_val').html(dtotal.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                    $('input[name="total"]').val(dtotal);
                }
                else if(response.orderdetail == '')
                {
                    //alert('test');
                    if(response.voucherdetail[0].minprice > subtotalprice)
                    {
                        $('.coupon_data').hide();   
                        $('.voucher_error').css('display','block');
                        $('.voucher_error').text(CouponMinAmount+' '+currency+''+response.voucherdetail[0].minprice);
                    }
                    else
                    {
                        //alert('0');
                        $('.voucher_error').css('display','none');
                        $('.display_sub_total').show();     
                        $('.coupon_data').show();       
                        $('.code_title').html('('+response.voucherdetail[0].code+')');
                        $('.add_vouchercode').val(response.voucherdetail[0].code);
                        if(response.voucherdetail[0].amounttype == 2)
                        {

                            var finalstotal = Number(subtotal) + Number(shippingcost) - Number(response.voucherdetail[0].discount);
                            var ptotaltax = finalstotal*(producttax/100);
                            var dtotal = Number(finalstotal) + Number(ptotaltax) ;
                            var dicountprice = Number(response.voucherdetail[0].discount);
                           // alert(finalstotal+'_'+ptotaltax+'_'+dtotal);

                            $('.discountprice').val(dicountprice.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                            $('.discount_val').html(currency+'-'+response.voucherdetail[0].discount.toFixed(2));
                            $('.ptotaltax').html(ptotaltax.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                            $('.grand_total_val').html(dtotal.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                            $('input[name="discountid"]').val(response.voucherdetail[0].id);
                            $('input[name="total"]').val(dtotal.toFixed(2));
                        }
                        else
                        {
                            //alert('00');
                            var disc = response.voucherdetail[0].discount;
                            var dec = (disc/100).toFixed(2); //its convert 10 into 0.10
                            var mult = subtotal*dec; // gives the value for subtract from main value
                            var maxprice = (response.voucherdetail[0].maxprice );

                            if(maxprice <= mult)
                            {
                               // alert('000');
                                var finalstotal = Number(subtotal) + Number(shippingcost) - Number(maxprice);
                        
                                var ptotaltax = finalstotal*(producttax/100);
                                var dtotal = Number(finalstotal) + Number(ptotaltax) ;
                                
                                $('.discountprice').val(maxprice.toFixed(2));
                                $('.discount_val').html(response.voucherdetail[0].discount+'%');
                                $('.discount_val1').html(currency+'-'+maxprice.toFixed(2));
                                $('.grand_total_val').html(dtotal.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                                $('.ptotaltax').html(ptotaltax.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                                $('input[name="discountid"]').val(response.voucherdetail[0].id);
                                $('input[name="total"]').val(dtotal.toFixed(2));
                            }
                            else
                            {
                               // alert('001');
                                var finalstotal = Number(subtotal) + Number(shippingcost) - Number(mult.toFixed(2));
                        
                                var ptotaltax = finalstotal*(producttax/100);
                                var dtotal = Number(finalstotal) + Number(ptotaltax) ;
                               // alert(dtotal);
                                $('.discountprice').val(mult.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                                $('.discount_val').html(response.voucherdetail[0].discount+'%');
                                $('.discount_val1').html(currency+'-'+mult.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                                $('.grand_total_val').html(dtotal.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                                $('.ptotaltax').html(ptotaltax.toFixed(2).replace(/\B(?=(?:\d{3})+(?!\d))/g, ','));
                                $('input[name="discountid"]').val(response.voucherdetail[0].id);
                                $('input[name="total"]').val(dtotal.toFixed(2));
                            }   
                        }
                    }
                }
                else if(response.voucherdetail[0].code == response.orderdetail[0].discount_code)
                {
                    $('.coupon_data').hide();   
                    $('.voucher_error').css('display','block');
                    $('.voucher_error').text(CouponApplyOnce);
                }
            },
            error: function (data) {
                //console.log('Error:', data);
            }
        });
    });

});

$(".coupon_code_btn").click(function(e) {
    //alert('test');
    var title = $(this).data('title');
    var code = $(this).data('code');
    var description = $(this).data('description');
    //console.log(title+'_'+code+'_'+description);

    $('.vcode').text(title);
    $('.vtitle').text(code);
    $('#vcode').text(code);
    $('.vdescription').text(description);
});

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $('#code_copy').show();
  
    $('#discountModal').modal('hide');
    $('input[name="coupon"]').val($(element).text());
}

$(document).ready(function(){

    $.validator.addMethod('Validemail', function (value, element) {
        return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
    }, ValidEmailError);

    $('#customer_login').validate({
        rules:{
            email:{
                required:true,
                Validemail: true,
                minlength: 3,
                maxlength: 50,
            },
            password:{
                required:true,
                maxlength:12,
                minlength:6
            }
        },
        highlight: function (element) {
            $(element).parent().addClass('has-error')
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('has-error')
        },
        errorElement: 'span',
        errorClass: 'text-danger',
    });

});

</script>
@stop