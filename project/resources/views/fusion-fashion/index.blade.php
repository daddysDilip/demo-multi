@extends('fusion-fashion.includes.newmaster')
@section('content')

@php $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2); @endphp

    @if($pagesettings[0]->slider_status)
    <section class="banner">
        <div id="myCarousel" class="carousel" data-ride="carousel">
          <!-- Indicators -->
            <ol class="carousel-indicators">
                @php $i = 0; @endphp
                @foreach($sliders as $allslider)
                    <li data-target="#myCarousel" data-slide-to="{{$i}}" class="<?php echo ($i == 0) ? 'active' : ''; ?>">{{$i+1}}</li>
                @php $i++; @endphp
                @endforeach
            </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            @php $i = 0; @endphp
            @foreach($sliders as $allslider)
                <div class="item <?php echo ($i == 0) ? 'active' : ''; ?>">
                    @if($allslider->image != '')
                    <img src="{{url('/')}}/assets/images/sliders/{{$allslider->image}}" alt="{{$allslider->title}}">
                    @endif
                    <div class="slider-text">
                        <div class="container">
                            <div class="row">
                                <h2>{{$allslider->title}}</h2>
                                {!! htmlspecialchars_decode($allslider->text) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @php $i++; @endphp
            @endforeach
          </div>
        </div>
    </section>
    @endif

    <section class="three-star clearfix">
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
              <div class="three-star-box">
                <span>
                  <img src="{{url('/')}}/assets/fashion-ecommerce/images/delivery.svg" class="img-responsive">
                </span>
                <span>
                  <h6>{{trans('app.FreeDelivery$300')}}</h6>
                  <p>{{trans('app.LoremIpsumText')}}</p>
                </span>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="three-star-box">
                <span>
                  <img src="{{url('/')}}/assets/fashion-ecommerce/images/guarantee.svg" class="img-responsive">
                </span>
                <span>
                  <h6>{{trans('app.MoneyBackGuarantee')}}</h6>
                  <p>{{trans('app.LoremIpsumText')}}</p>
                </span>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="three-star-box">
                <span>
                  <img src="{{url('/')}}/assets/fashion-ecommerce/images/24-hours.svg" class="img-responsive">
                </span>
                <span>
                  <h6>{{trans('app.Authenticityguaranteed')}}</h6>
                  <p>{{trans('app.LoremIpsumText')}}</p>
                </span>
              </div>
            </div>
          </div>
        </div>
    </section>

    @if($pagesettings[0]->category_status)
    <section class="adv-banners clearfix">
        <div class="container">
          <div class="row">
            @if(count($fcategories) > 0)
            <div class="col-sm-4 first_sec">
                <a href="{{url('/category')}}/{{$fcategory->slug}}" class="mb-12">
                    <div class="text_box">
                        <h3>{{$fcategory->name}}</h3>
                        <p class="btn shop_text">{{trans('app.ShopNow')}}</p>
                    </div>
                    @if($fcategory->feature_image != '')
                        <img src="{{url('/assets')}}/images/categories/{{$fcategory->feature_image}}" class="img-responsive">
                    @else
                        <img src="{{url('/assets')}}/images/placeholder.jpg" class="img-responsive">
                    @endif
                </a>

                @php $i=1; @endphp
                @foreach($fcategories as $fcat)
                    @if($i == 1)
                    <a href="{{url('/category')}}/{{$fcat->slug}}" class="mt-12">
                        <div class="text_box">
                            <h3>{{$fcat->name}}</h3>
                            <p class="btn shop_text">{{trans('app.ShopNow')}}</p>
                        </div>
                        @if($fcat->feature_image != '')
                            <img src="{{url('/assets')}}/images/categories/{{$fcat->feature_image}}" class="img-responsive">
                        @else
                            <img src="{{url('/assets')}}/images/placeholder.jpg" class="img-responsive">
                        @endif
                    </a>
                    @endif
                @php $i++; @endphp
                @endforeach
            </div>
            <div class="col-sm-4 second_sec">
                @php $i=1; @endphp
                @foreach($fcategories as $fcat)
                    @if($i == 2)
                    <a href="{{url('/category')}}/{{$fcat->slug}}">
                        <div class="text_box">
                            <h3>{{$fcat->name}}</h3>
                            <p class="btn shop_text">{{trans('app.ShopNow')}}</p>
                        </div>
                        @if($fcat->feature_image != '')
                            <img src="{{url('/assets')}}/images/categories/{{$fcat->feature_image}}" class="img-responsive">
                        @else
                            <img src="{{url('/assets')}}/images/placeholder.jpg" class="img-responsive">
                        @endif
                    </a>
                    @endif
                @php $i++; @endphp
                @endforeach
            </div>
            <div class="col-sm-4 third_sec">
                @php $i=1; @endphp
                @foreach($fcategories as $fcat)
                    @if($i == 3 || $i == 4)
                    <a href="{{url('/category')}}/{{$fcat->slug}}" class="<?php if($i == 3){ ?>mb-12<?php } if($i == 4){ ?>mt-12<?php } ?>">
                        <div class="text_box">
                            <h3>{{$fcat->name}}</h3>
                            <p class="btn shop_text">{{trans('app.ShopNow')}}</p>
                        </div>
                        @if($fcat->feature_image != '')
                            <img src="{{url('/assets')}}/images/categories/{{$fcat->feature_image}}" class="img-responsive">
                        @else
                            <img src="{{url('/assets')}}/images/placeholder.jpg" class="img-responsive">
                        @endif
                    </a>
                    @endif
                @php $i++; @endphp
                @endforeach
            </div>
            @endif
          </div>
        </div>
    </section>
    @endif

    @if($pagesettings[0]->latestpro_status)
    <section class="product-slider-wrap clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="product-wrapper">

                        <div class="prod-header">
                          <span>{{trans('app.LatestProducts')}}</span>
                        </div>
                        @if(count($latests) > 0)
                        <div class="product-slider owl-carousel">
                            @foreach($latests as $product)
                            <div class="product-box">
                                <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}"><div class="product-catg">{{$product->title}}</div></a>

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
                                </div>
                                <div class="three-btn">
                                    <div class="ratings">
                                        <div class="empty-stars"></div>
                                        <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                                    </div>
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
                                        <div class="latestpr_sec_{{$product->id}}">
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
                            @endforeach
                        </div>
                        @else
                            <h4 class="text-center">{{trans('app.NoDataFound')}}</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($pagesettings[0]->featuredpro_status)
    <section class="product-slider-wrap slider2 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="product-wrapper">

                        <div class="prod-header">
                          <span>{{trans('app.FeaturedProducts')}}</span>
                        </div>
                        @if(count($features) > 0)
                        <div class="product-slider owl-carousel">
                            @foreach($features as $product)
                            <div class="product-box">
                                <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}"><div class="product-catg">{{$product->title}}</div></a>

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
                                </div>
                                <div class="three-btn">
                                    <div class="ratings">
                                        <div class="empty-stars"></div>
                                        <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                                    </div>
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
                                        <div class="featurepr_sec_{{$product->id}}">
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
                            @endforeach
                        </div>
                        @else
                            <h4 class="text-center">{{trans('app.NoDataFound')}}</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($pagesettings[0]->blogs_status)
    <section class="blog-slider-main clearfix">
        <div class="banner" @if($settings[0]->background != null) style="background-image: url('{{url('/')}}/assets/images/{{$settings[0]->background}}'); @endif">
        </div>
        <div class="container">
            <div class="row">
                @if(count($blogs) > 0)
                <div class="blog-slider owl-carousel" id="blog-slider-single">
                    @foreach($blogs as $blog)
                    <div class="blog-wrap">
                        <span>
                            <div class="img-box">
                                @if($blog->featured_image != '')
                                    <img src="{{url('/assets')}}/images/blog/{{$blog->featured_image}}" class="img-responsive">
                                @else
                                    <img src="{{url('/')}}/assets/images/placeholder.jpg" class="img-responsive">
                                @endif
                            </div>
                        </span>
                        <span>
                            <div class="blog-title"><a href="{{url('/blog')}}/{{$blog->id}}" class="">{{ \App\BlogTranslations::where('blogid',$blog->id)->where('langcode',app()->getLocale() )->first()->title }}</a></div>
                            <div class="info">By <span>{{$companydetails[0]->comapany_name}}</span> {{date('M d, Y',strtotime($blog->created_at))}}</div>
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                    <h4 class="text-center">{{trans('app.NoDataFound')}}</h4>
                @endif
            </div>
        </div>
    </section>
    @endif

    @if($pagesettings[0]->popularpro_status)
    <section class="product-slider-wrap slider2 clear fix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="product-wrapper">

                        <div class="prod-header">
                          <span>{{trans('app.PopularProducts')}}</span>
                        </div>
                        @if(count($tops) > 0)
                        <div class="product-slider owl-carousel">
                            @foreach($tops as $product)
                            <div class="product-box">
                                <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}"><div class="product-catg">{{$product->title}}</div></a>
                                
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
                                </div>
                                <div class="three-btn">
                                    <div class="ratings">
                                        <div class="empty-stars"></div>
                                        <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                                    </div>
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
                                        <div class="popupr_sec_{{$product->id}}">
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
                            @endforeach
                        </div>
                        @else
                            <h4 class="text-center">{{trans('app.NoDataFound')}}</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

@stop

@section('footer')

<script type="text/javascript">

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    var owl = $('.testimonial-section');
    owl.owlCarousel({
        nav: owl.children().length > 1,
        navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 1,
        autoplay: true,
        autoplaySpeed: 500,
        loop: owl.children().length > 1
    });

</script>


@stop