@extends('fashion-ecommerce.includes.newmaster')
@section('content')

@php $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2); @endphp

    <main>
      @if($pagesettings[0]->slider_status)
      <div id="demo" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          @php $i = 0; @endphp
          @foreach($sliders as $allslider)
          <div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
            <section class="home-banner clearfix" <?php if($allslider->image != '') { ?>style="background-image: url('{{url('/')}}/assets/images/sliders/{{$allslider->image}}');"<?php } ?>>
              <div class="container">
                <div class="row">
                  <div class="col-12">
                    <div class="banner-wrapper clearfix">
                      <div class="banner-text">
                        <div class="heading-small clr-primary text-capitalize f-weight600 f-16 mb-30 wow bounceInLeft" data-wow-delay="250ms" data-wow-duration="2s">{{$allslider->title}}</div>
                        <div class="heading-large f-36 clr-secondary text-capitalize mb-30 wow bounceInLeft" data-wow-delay="350ms" data-wow-duration="2s">{!! htmlspecialchars_decode($allslider->text) !!}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
          @php $i++; @endphp
          @endforeach
          @if(count($sliders) > 1)
          <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon clr-secondary"></span>
          </a>
          <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon clr-secondary"></span>
          </a>
          @endif
        </div>
      </div>
      @endif

      <section class="main-service clearfix">
        <div class="container">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="service-box">
                <span>
                  <img src="{{url('/')}}/assets/fashion-ecommerce/images/return.png" class="img-fluid mx-auto">
                </span>
                <span class="text-span">
                  <div class="s-name f-18 clr-primary text-uppercase"><strong>{{trans('app.365DaysYear')}}</strong></div>
                  <div class="s-subname f-14 clr-primary f-weight600 text-capitalize">{{trans('app.FreeReturn')}}</div>
                </span>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="service-box">
                <span>
                  <img src="{{url('/')}}/assets/fashion-ecommerce/images/shipping.png" class="img-fluid mx-auto">
                </span>
                <span class="text-span">
                  <div class="s-name f-18 clr-primary text-uppercase"><strong>{{trans('app.FreeShipping')}}</strong></div>
                  <div class="s-subname f-14 clr-primary f-weight600 text-capitalize">{{trans('app.From$50')}}</div>
                </span>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="service-box">
                <span>
                  <img src="{{url('/')}}/assets/fashion-ecommerce/images/discount.png" class="img-fluid mx-auto">
                </span>
                <span class="text-span">
                  <div class="s-name f-18 clr-primary text-uppercase"><strong>{{trans('app.HighDiscount')}}</strong></div>
                  <div class="s-subname f-14 clr-primary f-weight600 text-capitalize">{{trans('app.SaveYouMoney')}}</div>
                </span>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="service-box">
                <span>
                  <img src="{{url('/')}}/assets/fashion-ecommerce/images/support.png" class="img-fluid mx-auto">
                </span>
                <span class="text-span">
                  <div class="s-name f-18 clr-primary text-uppercase"><strong>{{trans('app.24/7Agents')}}</strong></div>
                  <div class="s-subname f-14 clr-primary f-weight600 text-capitalize">{{trans('app.ForSupport')}}</div>
                </span>
              </div>
            </div>
          </div>
        </div>
      </section>

      @if($pagesettings[0]->latestpro_status)
        @if(count($latests) > 0)
        <section class="home-product clearfix mt-30 banner-left">
          <div class="container">

            <div class="row">
              <nav class="navbar navbar-expand-md">
                <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#fashion" aria-controls="fashion" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 col-md" style="float: left;width: 20%;">
                <div class="product-banner" data-title="{{trans('app.LatestProducts')}}">
                  <a href="#"><img src="{{url('/')}}/assets/fashion-ecommerce/images/product-banner.png" class="img-fluid mx-auto"></a>
                </div>
              </div>
              <div id="latest_product" class="owl-carousel" style="float: right;width: 80%;">
                @foreach($latests as $product)
                <div class="item">
                  <div class="col-12 col-md">
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

                          <div class="latestpr_sec_{{$product->id}}">
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
                      <span class="sale-tag bgclr-secondary f-10 clr-white">{{$percentage}}%<br> {{trans('app.Off')}}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </section>
        @endif
      @endif

      @if($pagesettings[0]->featuredpro_status)
        @if(count($features) > 0)
        <section class="home-product clearfix mt-30 banner-right">
          <div class="container">
            <div class="row">
              <nav class="navbar navbar-expand-md">
                <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#electronics" aria-controls="electronics" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              </nav>
            </div>
            
            <div class="row">
              <div id="featured_product" class="owl-carousel" style="float: right;width: 80%;">
                @foreach($features as $product)
                <div class="item">
                  <div class="col-12 col-md">
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

                          <div class="featurepr_sec_{{$product->id}}">
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
                      <span class="sale-tag bgclr-secondary f-10 clr-white">{{$percentage}}%<br> {{trans('app.Off')}}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <div class="col-12 col-md">
                <div class="product-banner" data-title="{{trans('app.FeaturedProducts')}}">
                  <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}"><img src="{{url('/')}}/assets/fashion-ecommerce/images/product-banner1.png" class="img-fluid mx-auto"></a>
                </div>
              </div>
            </div>
            
          </div>
        </section>
        @endif
      @endif

      @if($pagesettings[0]->popularpro_status)
        @if(count($tops) > 0)
        <section class="home-product clearfix mt-30 banner-left">
          <div class="container">
            <div class="row">
              <nav class="navbar navbar-expand-md">
                <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#fashion" aria-controls="fashion" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              </nav>
            </div>

            <div class="row">
              <div class="col-12 col-md" style="float: left;width: 20%;">
                <div class="product-banner" data-title="{{trans('app.PopularProducts')}}">
                  <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}"><img src="{{url('/')}}/assets/fashion-ecommerce/images/product-banner.png" class="img-fluid mx-auto"></a>
                </div>
              </div>
              <div id="popular_product" class="owl-carousel" style="float: right;width: 80%;">
                @foreach($tops as $product)
                <div class="item">
                  <div class="col-12 col-md">
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

                          <div class="popupr_sec_{{$product->id}}">
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
                      <span class="sale-tag bgclr-secondary f-10 clr-white">{{$percentage}}%<br> {{trans('app.Off')}}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </section>
        @endif
      @endif

      @if($pagesettings[0]->blogs_status)
        @if(count($blogs) > 0)
        <section class="blog-grid home-blogsection">
          <div class="container">
            <div class="row">
              <div class="col">
                <h2 class="text-center f-weight600 clr-primary mb-30 text-uppercase">{{$languages->blog_title}}</h2>
              </div>
            </div>
            <div class="row">
              @foreach($blogs as $blog)
              <div class="col-12 col-sm-6 col-md-3">
                <div class="blog-wrap">
                  <div class="bimg-wrap">
                    @if($blog->featured_image != '')
                    <img src="{{url('/assets')}}/images/blog/{{$blog->featured_image}}" class="img-fluid mx-auto">
                    @else
                    <img src="{{url('/')}}/assets/images/placeholder.jpg" class="img-fluid mx-auto">
                    @endif
                  </div>
                  <div class="btext-wrap">
                    <div class="date mb-15">
                      <i class="far fa-calendar-alt"></i>
                      <a href="{{url('/blog')}}/{{$blog->id}}" class="">{{date('F d Y',strtotime($blog->created_at))}}</a>
                    </div>
                    <div class="blog-name  mb-15"><a href="{{url('/blog')}}/{{$blog->id}}" class="f-16 clr-secondary">{{$blog->title}}</a></div>
                    <div class="blog-desc f-14 clr-secondary-light">
                      {{ substr(strip_tags($blog->details), 0, 100) }}
                      {{ strlen(strip_tags($blog->details)) > 50 ? "..." : "" }}
                    </div>
                    <a href="{{url('/blog')}}/{{$blog->id}}" class="btn-main clr-secondary text-uppercase f-12 mt-15">{{trans('app.ReadMore')}}<span><i class="fas fa-long-arrow-alt-right"></i></span></a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </section>
        @endif
      @endif

    </main>

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