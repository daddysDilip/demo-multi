@extends('ecommerce-4.includes.newmaster')

@section('content')

  <main>
      
    <section id="inner_banner" style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;background-color: #2278b8;">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans('app.Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('app.SearchResult')}}: {{$search}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>

    <section id="main_contact" class="main-product-wrapper">
      <div class="container">
        <div class="row wrapper">
          <div class="col-12 col-md-12 col-lg-12">
            @if(count($products) > 0)
            <div class="tab-content grid_view">
              <div class="row">
              @forelse($products as $product)
              <div class="col-sm-3">
                <div class="product_box">
                  @if($product->feature_image != '')
                    <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive orig product_img">
                    <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive on_hover product_img">
                  @else
                    <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive orig product_img">
                    <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive on_hover product_img">
                  @endif

                  @php 
                    $publishdate = strtotime($product->created_at);
                    $nowdate = strtotime('-24 hours');
                  @endphp
                  
                  @if($publishdate >= $nowdate)<div class="tag new"><span>{{trans('app.New')}}</span></div>@endif

                  @if($product->offer_price != "" && $product->offer_price != 0)<div class="tag sale"><span>{{trans('app.Sale')}}</span></div>@endif  

                  <div class="product_button">
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
                            <!-- <a href="{{Url('cart')}}" class="p-btn"><i class='fas fa-shopping-cart'></i> Go To Cart</a> -->
                            <span class="cart"><a href="{{Url('cart')}}"><i class="fas fa-shopping-cart"></i> {{trans('app.GoCart')}}</a></span>
                          @else
                            <span class="cart to-cart"><a href="javascript:;"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader"><i class="fas fa-shopping-cart"></i> {{trans('app.AddCart')}}</a></span>
                          @endif
                        @else
                          <span class="cart"><a href="javascript:;" class="out_stock_btn"><i class="fas fa-shopping-cart"></i> {{trans('app.OutStock')}}</a></span>
                        @endif
                      </div>
                    </form>
                    
                  </div>
                </div>
                <div class="product_price">
                  <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a>
                  <p>
                    @if($product->offer_price != "" && $product->offer_price != 0)
                      <span class="price">{{$settings[0]->currency_sign}}{{$product->offer_price}}</span>
                      <span class="price-before-discount">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                    @else
                      <span class="price">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                    @endif 
                  </p>
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