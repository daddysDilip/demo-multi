@extends('themextra-e-comm.includes.newmaster')

@section('content')

<main>

  <section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
    <div class="row" style="background-color:rgba(0,0,0,0.7);">

      <div style="margin: 3% 0px 3% 0px;">
        <div class="text-center" style="color: #FFF;padding: 20px;">
          <h1>{{trans('app.SearchResult')}}: {{$tag}}</h1>
        </div>
      </div>

    </div>
  </section>

  <section id="grid">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="search-result-container ">
            <div id="myTabContent" class="tab-content category-list">
              <div class="tab-pane active " id="grid-container">
                <div class="category-product">
                  <div class="row">
                    @forelse($products as $product)
                    <div class="col-sm-4 col-md-3">
                      <div class="products">
                        <div class="product">

                          <div class="product-image">
                            <div class="image"> <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">
                              @if($product->feature_image != '')
                                <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive" alt=""></a> 
                              @else
                                <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive" alt=""></a> 
                              @endif
                            </div>
                            <!-- /.image -->
                            @php 
                              $publishdate = strtotime($product->created_at);
                              $nowdate = strtotime('-24 hours')
                            @endphp

                            @if($publishdate >= $nowdate)<div class="tag new"><span>{{trans('app.New')}}</span></div>@endif
                            @if($product->offer_price != "" && $product->offer_price != 0)<span class="tag sale">{{trans('app.Sale')}}</span>@endif

                          </div>
                          <!-- /.product-image -->
                          
                          <div class="product-info">
                            <h3 class="name"><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="description"></div>

                            <div class="product-price"> 
                              @if($product->offer_price != "" && $product->offer_price != 0)
                                <span class="price"> {{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}} </span> <span class="price-before-discount">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span> 
                              @else
                                <span class="price"> {{$settings[0]->currency_sign}}{{number_format($product->price,2)}} </span>
                              @endif
                            </div>
                            <!-- /.product-price --> 
                          </div>
                          <!-- /.product-info -->

                          <div class="cart clearfix">
                            <div class="action">
                              <ul class="list-unstyled">
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

                                  <div class="addcart_sec_{{$product->id}} list_addcart_sec">
                                    <li class="add-cart-button btn-group">
                                      @if($product->stock != 0 || $product->stock === null )
                                        @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                          <a href="{{Url('cart')}}" class="btn btn-primary cart-btn" type="button">{{trans('app.GoCart')}}</a>
                                        @else
                                          <button class="btn btn-primary cart-btn to-cart" type="button"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader">{{trans('app.AddCart')}}</button>
                                        @endif
                                      @else
                                        <button class="btn btn-primary cart-btn out_stock_btn" type="button">{{trans('app.OutStock')}}</button>
                                      @endif
                                    </li>
                                  </div>

                                </form>
                              </ul>
                            </div>
                            <!-- /.action --> 
                          </div>
                          <!-- /.cart --> 
                        </div>
                        <!-- /.product --> 
                        
                      </div>
                      <!-- /.products --> 
                    </div>
                    <!-- /.item -->
                    @empty
                      <h3 class="text-center">{{trans('app.NoProductsFound')}}</h3>
                    @endforelse
                  </div>
                </div>
                <!-- /.category-product -->
              </div>
              <!-- /.tab-pane -->
              
            </div>
            <!-- /.tab-content -->

          </div>
        </div>
      </div>
    </div>
  </section> 
    
</main>

@stop

@section('footer')

@stop