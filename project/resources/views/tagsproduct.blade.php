@extends('includes.newmaster')

@section('content')


    <section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
        <div class="row" style="background-color:rgba(0,0,0,0.7);">

            <div style="margin: 3% 0px 3% 0px;">
                <div class="text-center" style="color: #FFF;padding: 20px;">
                    <h1>{{trans('app.SearchResult')}}: {{$tag}}</h1>
                </div>
            </div>

        </div>
    </section>

    <div class="section-padding product-filter-wrapper wow fadeInUp tags_product">
            <div class="container">
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <div class="single-product-carousel-item text-center">
                                <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}"> <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" alt="Product Image" /> </a>
                                <div class="product-carousel-text">
                                    <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">
                                        <h4 class="product-title">{{$product->title}}</h4>
                                    </a>
                                    <div>
                                    <div class="ratings">
                                        <div class="empty-stars"></div>
                                        <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                                    </div>
                                </div>
                                    <div class="product-price">
                                        @if($product->offer_price != "" && $product->offer_price != 0)
                                            <span class="original-price">${{number_format($product->offer_price,2)}}</span>
                                            <del class="offer-price">${{number_format($product->price,2)}}</del>
                                        @else
                                            <span class="original-price">${{number_format($product->price,2)}}</span>
                                        @endif
                                    </div>
                                    <div class="product-meta-area">
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
                                            <div class="signle_addcart_{{$product->id}}">
                                            @if($product->stock != 0 || $product->stock === null )
                                                @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                                <a href="{{Url('cart')}}" type="button" class="addTo-cart to-cart"><i class="fa fa-cart-plus"></i><span>{{trans('app.GoCart')}}</span></a>
                                                @else
                                                <button type="button" class="addTo-cart to-cart"><i class="fa fa-cart-plus"></i><span>{{trans('app.AddCart')}}</span></button>
                                                @endif
                                            @else
                                                <button type="button" class="addTo-cart to-cart" disabled><i class="fa fa-cart-plus"></i>{{trans('app.OutStock')}}</button>
                                            @endif
                                            </div>
                                        </form>
                                        <a  href="javascript:;" class="wish-list" onclick="getQuickView({{$product->id}})" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3>{{trans('app.NoProductsFound')}}</h3>
                    @endforelse
                </div>
            </div>
    </div>

@stop

@section('footer')

@stop