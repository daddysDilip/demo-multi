@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
      <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
          <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{trans('app.SearchResult')}}: {{$tag}}</div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans('app.Home')}}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{trans('app.SearchResult')}}: {{$tag}}</li>
            </ol>
          </nav>
        </div>
      </section>
      <section class="main-product-wrapper">
        <div class="container">
          <div class="row wrapper">
            <div class="col-12 col-md-12 col-lg-12">
              @if(count($products) > 0)
              <div class="tab-content">
                <div class="row product-row">
                  @forelse($products as $product)
                  <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="product-wrap">
                      <div class="p-name f-14 f-weight600 clr-secondary"><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></div>
                      
                      <div class="ratings">
                        <div class="empty-stars"></div>
                        <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                      </div>

                      <div class="price f-14">
                        @if($product->offer_price != "" && $product->offer_price != 0)
                          <span class="old clr-secondary-light">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span>
                          <span class=" newclr-secondary"><strong>{{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}}</strong></span>
                        @else
                          <span class=" newclr-secondary"><strong>{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</strong></span>
                        @endif
                      </div>
                      <div class="prod-img">
                        @if($product->feature_image != '')
                          <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-fluid mx-auto">
                        @else
                          <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-fluid mx-auto">
                        @endif
                      </div>
                      <div class="product-footer">
                        <form class="addtocart-form">
                          {{csrf_field()}}
                          @if(Session::has('uniqueid'))
                              <input type="hidden" name="uniqueid" value="{{Session::get('uniqueid')}}">
                          @else
                              <input type="hidden" name="uniqueid" value="{{str_random(7)}}">
                          @endif
                          <input type="hidden" name="title" value="{{$product->title}}">
                          <input type="hidden" name="product" value="{{$product->id}}">
                          <input type="hidden" name="shipping_cost" value="{{$product->shipping_cost}}">
                          <input type="hidden" name="tax" value="{{$product->tax}}">
                          <input type="hidden" id="cost" name="cost" value="{{$product->selling_price}}">
                          <input type="hidden" id="quantity" name="quantity" value="1">
                          <input type="hidden" id="productimage" name="productimage" value="{{$product->feature_image}}">
                          <div class="addcart_sec_{{$product->id}}">
                            @if($product->stock != 0 || $product->stock === null )
                              @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                <a href="{{Url('cart')}}" class="p-btn"><i class='fas fa-shopping-cart'></i> {{trans('app.GoCart')}}</a>
                              @else
                                <a href="javascript:;" class="to-cart p-btn"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader"><i class='fas fa-shopping-cart'></i> {{trans('app.AddCart')}}</a>
                              @endif
                            @else
                              <a href="javascript:;" class="out_stock_btn p-btn"><i class='fas fa-shopping-cart'></i> {{trans('app.OutStock')}}</a>
                            @endif
                          </div>
                        </form>
                      </div>
                      @if($product->offer_price != "" && $product->offer_price != 0)
                      @php
                        $pricediff = (($product->price) - ($product->offer_price));        
                        $percentage = round((($pricediff/$product->price)*100));  
                      @endphp
                      <span class="sale-tag bgclr-secondary f-10 clr-white">{{$percentage}}%<br>  {{trans('app.Off')}}</span>
                      @endif
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              @else
                <p class="text-center">{{trans('app.NoProductsFound')}}</p>
              @endif
            </div>
          </div>
        </div>
      </section>
    
    </main>

@stop

@section('footer')

@stop