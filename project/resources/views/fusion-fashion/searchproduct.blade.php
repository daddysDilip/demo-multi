@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

  <nav class="breadcrumb-wrap" aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">{{trans('app.SearchResult')}}: {{$search}}</li>
      </ol>
    </div>
  </nav>

  <section class="main-wrapper grid_product_list">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          @if(count($products) > 0)
            @forelse($products as $product)
              <div class="col-md-3 col-sm-6">
                <div class="product-box clearfix">
                  <div class="product-catg"><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></div>
                  
                  <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">
                    @if($product->feature_image != '')
                      <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive">
                    @else
                      <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive">
                    @endif
                  </a>

                  <div class="prices">
                    @if($product->offer_price != "" && $product->offer_price != 0)
                      <span class="new-price">{{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}}</span>
                      <span class="old-price">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span>
                    @else
                      <span class="new-price">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span>
                    @endif
                    <div class="ratings">
                      <div class="empty-stars"></div>
                      <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                    </div>
                  </div>

                  <div class="three-btn">
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
                                  <a href="{{Url('cart')}}" class="p-btn buy-now">{{trans('app.GoCart')}}</a>
                              @else
                                  <a href="javascript:;" class="to-cart p-btn buy-now"><img src="{{url('/assets/images')}}/default.gif" id="loadr_img" class="to_cart_loader">{{trans('app.AddCart')}}</a>
                              @endif
                          @else
                              <a href="javascript:;" class="out_stock_btn p-btn buy-now">{{trans('app.OutStock')}}</a>
                          @endif
                      </div>
                    </form>
                  </div>
                  @if($product->offer_price != "" && $product->offer_price != 0)
                    <div class="sale-tag">{{trans('app.Sale')}}</div>
                  @endif

                </div>
              </div>
            @endforeach
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