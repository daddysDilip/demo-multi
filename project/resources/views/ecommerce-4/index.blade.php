@extends('ecommerce-4.includes.newmaster')
@section('content')

@php $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2); @endphp

  <main>

    @if($pagesettings[0]->slider_status)
    <div id="myCarousel" class="carousel slide top_slider">

      <!-- Indicators -->
      <ol class="carousel-indicators">
        @php $i = 0; @endphp
        
        @if(count($sliders) > 1)
          @foreach($sliders as $allslider)
            <li data-target="#myCarousel" data-slide-to="{{$i}}" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
          @php $i++; @endphp
          @endforeach
        @endif
      </ol>

      <div class="carousel-inner">
        @php $i = 0; @endphp
        @foreach($sliders as $allslider)
        <div class="item <?php echo ($i == 0) ? 'active' : ''; ?>">
            <div class="fill">
              <img src="{{url('/')}}/assets/images/sliders/{{$allslider->image}}" class="img-responsive">
              <div class="carousel-caption">
                <h2 class="animated fadeInLeft slow">{{$allslider->title}}</h2>
                <p class="animated fadeInUp slow subline">{!! htmlspecialchars_decode($allslider->text) !!}</p>
              </div>
            </div>
        </div>
        @php $i++; @endphp
        @endforeach        
      </div>
      <!-- Controls -->
      @if(count($sliders) > 1)
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="icon-next"></span>
        </a>
      @endif
    </div>
    @endif

    @if($pagesettings[0]->latestpro_status)
    <div class="container">
      <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
        <div class="more-info-tab clearfix ">
          <h3 class="new-product-title">{{trans('app.LatestProducts')}}</h3>
        </div>
        <div class="tab-content outer-top-xs">
          @if(count($latests) > 0)
          <div id="latest_product" class="owl-carousel product-slider custom-carousel">
            @foreach($latests as $product)
            @php 
              $publishdate = strtotime($product->created_at);
              $nowdate = strtotime('-24 hours')
            @endphp
            <div class="item">
              <div class="products">
                <div class="product">  

                  <div class="product-image">
                    <div class="image">
                      <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">
                        @if($product->feature_image != '')
                          <img  src="{{url('/assets/images/products')}}/{{$product->feature_image}}" alt="{{$product->title}}">
                        @else
                          <img  src="{{url('/assets/images')}}/placeholder.jpg" alt="{{$product->title}}">
                        @endif
                      </a>
                    </div><!-- /.image -->      

                    @if($publishdate >= $nowdate)
                      <div class="tag new"><span>{{trans('app.New')}}</span></div>
                    @endif 

                    @if($product->offer_price != "" && $product->offer_price != 0)
                      <div class="tag sale"><span>{{trans('app.Sale')}}</span></div>
                    @endif 

                  </div><!-- /.product-image -->

                  <div class="product-info text-left">
                    <h3 class="name"><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></h3>

                    <div class="ratings">
                      <div class="empty-stars"></div>
                      <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                    </div>
                    
                    <div class="product-price"> 
                      @if($product->offer_price != "" && $product->offer_price != 0)
                        <span class="price">{{$settings[0]->currency_sign}}{{$product->offer_price}}</span>
                        <span class="price-before-discount">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                      @else
                        <span class="price">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                      @endif 
                    </div><!-- /.product-price -->
                  </div><!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
                    <div class="action">
                      <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
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
                                <a href="{{Url('cart')}}" data-toggle="tooltip" class="btn btn-primary icon" type="button" title="Go To Cart"><i class="fa fa-shopping-cart"></i> {{trans('app.GoCart')}}</a>
                                @else
                                <button data-toggle="tooltip" class="to-cart btn btn-primary icon" type="button" title="{{$language->add_to_cart}}"><i class="fa fa-shopping-cart"></i><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader"> {{trans('app.AddCart')}}</button>
                                @endif
                              @else
                                <button data-toggle="tooltip" class="btn btn-primary icon out_stock_btn" type="button" title="{{$language->out_of_stock}}"><i class="fa fa-shopping-cart"></i> {{trans('app.OutStock')}}</button>
                              @endif
                            </div>
                          </form>
                        </li>
                      </ul>
                    </div><!-- /.action -->
                  </div><!-- /.cart -->
                </div><!-- /.product -->
              </div><!-- /.products -->
            </div><!-- /.item -->
            @endforeach
          </div>
          @else
          <p style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</p>
          @endif
        </div>
      </div>
    </div>
    @endif

    @if($pagesettings[0]->category_status)
    <section id="banner_3">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h2>{{trans('app.TopCategory')}}</h2>
          </div>
        </div>
        @if(count($fcategories) > 0)
        <div class="row">
          <div class="col-sm-6">
            <div class="img_box first">
              @if($fcategory->feature_image != '')
                <img src="{{url('/assets')}}/images/categories/{{$fcategory->feature_image}}" class="img-responsive">
              @else
                <img src="{{url('/assets')}}/images/placeholder.jpg" class="img-responsive">
              @endif
              <div class="text_box">
                <h3><a href="{{url('/category')}}/{{$fcategory->slug}}">{{$fcategory->name}}</a></h3>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              @php $i=1; @endphp
              @foreach($fcategories as $fcat)

              @if($i==3 || $i==4)
                @php $class = 'last'; @endphp
              @else
                @php $class = ''; @endphp
              @endif

              <div class="col-sm-6">
                <div class="img_box second <?php echo $class; ?>">
                  @if($fcat->feature_image != '')
                    <img src="{{url('/assets')}}/images/categories/{{$fcat->feature_image}}" class="img-responsive">
                  @else
                    <img src="{{url('/assets')}}/images/placeholder.jpg" class="img-responsive">
                  @endif
                  <div class="text_box">
                    <h3><a href="{{url('/category')}}/{{$fcat->slug}}">{{$fcat->name}}</a></h3>
                  </div>
                </div>
              </div>
              @php $i++; @endphp
              @endforeach
            </div>
          </div>
        </div>
        @else
          <p style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</p>
        @endif
      </div>
    </section>
    @endif

    @if($pagesettings[0]->featuredpro_status)
    <div class="container">
      <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
        <div class="more-info-tab clearfix ">
          <h3 class="new-product-title">{{trans('app.FeaturedProducts')}}</h3>
        </div>
        <div class="tab-content outer-top-xs">
          @if(count($features) > 0)
          <div id="featured_product" class="owl-carousel product-slider custom-carousel">
            @foreach($features as $product)
            @php 
              $publishdate = strtotime($product->created_at);
              $nowdate = strtotime('-24 hours')
            @endphp
            <div class="item">
              <div class="products">
                <div class="product">   
                  <div class="product-image">
                    <div class="image">
                      <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">
                        @if($product->feature_image != '')
                          <img  src="{{url('/assets/images/products')}}/{{$product->feature_image}}" alt="{{$product->title}}">
                        @else
                          <img  src="{{url('/assets/images')}}/placeholder.jpg" alt="{{$product->title}}">
                        @endif
                      </a>
                    </div><!-- /.image -->      
                    @if($publishdate >= $nowdate)<div class="tag new"><span>new</span></div>@endif 
                    @if($product->offer_price != "" && $product->offer_price != 0)<div class="tag sale"><span>Sale</span></div>@endif                              
                  </div><!-- /.product-image -->
                  <div class="product-info text-left">
                    <h3 class="name"><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></h3>
                    
                    <div class="ratings">
                      <div class="empty-stars"></div>
                      <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                    </div>

                    <div class="product-price"> 
                      @if($product->offer_price != "" && $product->offer_price != 0)
                        <span class="price">{{$settings[0]->currency_sign}}{{$product->offer_price}}</span>
                        <span class="price-before-discount">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                      @else
                        <span class="price">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                      @endif 
                    </div><!-- /.product-price -->
                  </div><!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
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

                          <div class="featurepr_sec_{{$product->id}}">
                            <li class="add-cart-button btn-group">
                              @if($product->stock != 0 || $product->stock === null )
                                @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0) 
                                <a href="{{Url('cart')}}" data-toggle="tooltip" class="btn btn-primary icon" type="button" title="Go To Cart"><i class="fa fa-shopping-cart"></i> {{trans('app.GoCart')}}</a>
                                @else
                                <button data-toggle="tooltip" class="to-cart btn btn-primary icon" type="button" title="{{$language->add_to_cart}}"><i class="fa fa-shopping-cart"></i><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader"> {{trans('app.AddCart')}}</button>
                                @endif
                              @else
                                <button data-toggle="tooltip" class="btn btn-primary icon out_stock_btn" type="button" title="{{$language->out_of_stock}}"><i class="fa fa-shopping-cart"></i> {{trans('app.OutStock')}}</button>
                              @endif
                            </li>
                          </div>
                      </form>
                      </ul>
                    </div><!-- /.action -->
                  </div><!-- /.cart -->
                </div><!-- /.product -->
              </div><!-- /.products -->
            </div><!-- /.item -->
            @endforeach
          </div>
          @else
          <p style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</p>
          @endif
        </div>
      </div>
    </div>
    @endif

    @if($pagesettings[0]->popularpro_status)
    <div class="container">
      <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
        <div class="more-info-tab clearfix ">
          <h3 class="new-product-title">{{trans('app.PopularProducts')}}</h3>
        </div>
        <div class="tab-content outer-top-xs">
          @if(count($tops) > 0)
          <div id="popular_product" class="owl-carousel product-slider custom-carousel">
            @foreach($tops as $product)
            @php 
              $publishdate = strtotime($product->created_at);
              $nowdate = strtotime('-24 hours')
            @endphp
            <div class="item">
              <div class="products">
                <div class="product">   
                  <div class="product-image">
                    <div class="image">
                      <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">
                        @if($product->feature_image != '')
                          <img  src="{{url('/assets/images/products')}}/{{$product->feature_image}}" alt="{{$product->title}}">
                        @else
                          <img  src="{{url('/assets/images')}}/placeholder.jpg" alt="{{$product->title}}">
                        @endif
                      </a>
                    </div><!-- /.image -->      
                    @if($publishdate >= $nowdate)<div class="tag new"><span>new</span></div>@endif 
                    @if($product->offer_price != "" && $product->offer_price != 0)<div class="tag sale"><span>Sale</span></div>@endif                              
                  </div><!-- /.product-image -->
                  <div class="product-info text-left">
                    <h3 class="name"><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></h3>
                    
                    <div class="ratings">
                      <div class="empty-stars"></div>
                      <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                    </div>
                    
                    <div class="product-price"> 
                      @if($product->offer_price != "" && $product->offer_price != 0)
                        <span class="price">{{$settings[0]->currency_sign}}{{$product->offer_price}}</span>
                        <span class="price-before-discount">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                      @else
                        <span class="price">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                      @endif 
                    </div><!-- /.product-price -->
                  </div><!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
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

                          <div class="popupr_sec_{{$product->id}}">
                            <li class="add-cart-button btn-group">
                              @if($product->stock != 0 || $product->stock === null )
                                @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0) 
                                <a href="{{Url('cart')}}" data-toggle="tooltip" class="btn btn-primary icon" type="button" title="Go To Cart"><i class="fa fa-shopping-cart"></i> {{trans('app.GoCart')}}</a>
                                @else
                                <button data-toggle="tooltip" class="to-cart btn btn-primary icon" type="button" title="{{$language->add_to_cart}}"><i class="fa fa-shopping-cart"></i><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader"> {{trans('app.AddCart')}}</button>
                                @endif
                              @else
                                <button data-toggle="tooltip" class="btn btn-primary icon out_stock_btn" type="button" title="{{$language->out_of_stock}}"><i class="fa fa-shopping-cart"></i> {{trans('app.OutStock')}}</button>
                              @endif
                            </li>
                          </div>
                      </form>
                      </ul>
                    </div><!-- /.action -->
                  </div><!-- /.cart -->
                </div><!-- /.product -->
              </div><!-- /.products -->
            </div><!-- /.item -->
            @endforeach
          </div>
          @else
          <p style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</p>
          @endif
        </div>
      </div>
    </div>
    @endif

    @if($pagesettings[0]->blogs_status)
    <section id="latest_blog">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h2 class="heading">{{$languages->blog_title}}</h2>
            <hr>
          </div>
        </div>
        @if(count($blogs) > 0)
        <div class="row">
          <div class="col-md-12">
            <div class="blog-wrap owl-carousel">
              @foreach($blogs as $blog)
              <div class="blog_box">
                <div class="row">
                  <div class="col-sm-5">
                    @if($blog->featured_image != '')
                      <img src="{{url('/assets')}}/images/blog/{{$blog->featured_image}}" class="img-responsive">
                    @else
                      <img src="{{url('/')}}/assets/images/placeholder.jpg" class="img-responsive">
                    @endif
                  </div>
                  <div class="col-sm-7">
                    <div class="text_box">
                      <h4>{{$blog->title}}</h4>
                      <p>{{ substr(strip_tags($blog->details), 0, 100) }}
                        {{ strlen(strip_tags($blog->details)) > 50 ? "..." : "" }}</p>
                      <a href="{{url('/blog')}}/{{$blog->id}}">{{trans('app.ReadMore')}}</a>
                      <div class="date"><a href="{{url('/blog')}}/{{$blog->id}}">{{date('d MY',strtotime($blog->created_at))}}</a>     - <a href="{{url('/blog')}}/{{$blog->id}}">{{$companydetails[0]->comapany_name}}</a></div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif
      </div>
    </section>
    @endif

    @if($pagesettings[0]->brands_status)
      @if(count($brands) > 0)
      <section id="partner" class="clearfix">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <h2 class="heading">{{trans('app.OurBrandPartner')}}</h2>
            </div>
            <div class="col-sm-12">
              <section class="customer-logos slider">
                @foreach($brands as $brand)
                <div class="slide"><img src="{{url('/assets/images/brands')}}/{{$brand->image}}"></div>
                @endforeach
             </section>
            </div>
          </div>
        </div>
      </section>
      @endif
    @endif

    <section id="newsletter">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <form id="subform" action="{{action('FrontEndController@subscribe',$subdomain_name)}}" method="post" class="col-12 col-sm-12 col-md">
              {{csrf_field()}}
              <h2 class="heading">{{trans('app.SignUpForNewsletter')}}</h2>
              <p class="heading">{{trans('app.SuscribeOftersMsg')}}</p>
              <div class="text-center"><input type="email" name="email" id="email" class="subsc" placeholder="{{trans('app.EnterEmail')}}" /><br></div>
              <div class="text-center"><button type="submit" id="subs">{{trans('app.Subscribe')}}</button></div>
              <div id="resp" class="text-danger text-center"></div>
            </form>
          </div>
        </div>
      </div>
    </section>

  </main>

@stop

@section('footer')

<script type="text/javascript">

$(':input').change(function() {
  $(this).val($(this).val().trim());
});

$(document).ready(function(){

  $.validator.addMethod('Validemail', function (value, element) {
      return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
  }, ValidEmailError);

  $('#subform').validate({
    rules:{
      email:{
        required:true,
        Validemail:true,
        minlength: 3,
        maxlength: 50,
      },
    },
    submitHandler: function(form) {
      $.ajax({
        type: "post",
        url: "{{ URL('subscribe') }}",
        data: $(form).serialize(),
        dataType: 'JSON',
        success:function(data){
          if(data == 'success')
          {  
            $("#subform")[0].reset();
            $("#resp").html('<span style=\"color:#00C708;\">'+SubscribedSuccessfully+'</span>').show().fadeOut(5000);
          }
          else if(data == 'fail')
          {
            $("#subform")[0].reset();
            $("#resp").html('<span style="color:#F90600;">'+AlreadySubscribed+'</span>').show().fadeOut(5000);
          }
          
        },
        error: function (data) {
            console.log(data);
        }        
      });
    },
    highlight: function (element) {
      $(element).parent().addClass('has-error')
    },
    unhighlight: function (element) {
      $(element).parent().removeClass('has-error')
    },
    errorClass: 'text-danger',
  });

});
</script>

@stop