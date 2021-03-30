@extends('themextra-e-comm.includes.newmaster')
@section('content')

@php $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2); @endphp

  <main>
    @if($pagesettings[0]->slider_status)
    <div id="myCarousel" class="carousel slide" data-ride="carousel">

      <ul class="carousel-indicators">
        @php $i = 0; @endphp
        @if(count($sliders) > 1)
        @foreach($sliders as $allslider)
          <li data-target="#myCarousel" data-slide-to="{{$i}}" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
        @php $i++; @endphp
        @endforeach
        @endif
      </ul>

      <div class="carousel-inner">
        @php $i = 0; @endphp
        @foreach($sliders as $allslider)
        <div class="item <?php echo ($i == 0) ? 'active' : ''; ?>">
          <section id="banner" <?php if($allslider->image != '') { ?>style="background-image: url('{{url('/')}}/assets/images/sliders/{{$allslider->image}}');"<?php } ?>>
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="banner_text">
                    <h1>{{$allslider->title}}</h1>
                    {!! htmlspecialchars_decode($allslider->text) !!}
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        @php $i++; @endphp
        @endforeach
      </div>
    </div>
    @endif

    @if(count($fcategories) > 0)
    <section id="our_category" class="clearfix">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="heading">{{trans('app.TopCategory')}}</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-sm-8">

            @php $i = 0; @endphp
            <div class="row">
            @foreach($fcategories as $fcat)

            @if($fcat->feature_image != '')
              @php $img_url = 'categories/'.$fcat->feature_image @endphp
            @else
              @php $img_url = 'placeholder.jpg' @endphp  
            @endif

            @if($i == 0) <div class="col-md-4 col-sm-4"> @endif
            @if($i == 1) <div class="col-md-8 col-sm-8"> @endif
            @if($i == 2) <div class="col-md-8 col-sm-8"> @endif
            @if($i == 3) <div class="col-md-4 col-sm-4"> @endif
              <div class="category">
                <a href="{{url('/category')}}/{{$fcat->slug}}">
                  <div class="catg_<?php echo $i; ?>" style="background-image: url('{{url('/assets/images')}}/<?php echo $img_url; ?>')">
                    <div class="layer">
                      <div class="cat_text">{{$fcat->name}}</div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            @php $i++; @endphp
            @endforeach
          </div>
          </div>
          <div class="col-md-4 col-sm-4">
            <div class="category">
              @if($fcategory->feature_image != '')
                @php $img_url = 'categories/'.$fcategory->feature_image @endphp
              @else
                @php $img_url = 'placeholder.jpg' @endphp  
              @endif
              <a href="{{url('/category')}}/{{$fcategory->slug}}">
              <div class="catg_5" style="background-image: url('{{url('/assets/images')}}/<?php echo $img_url; ?>')">
                <div class="layer">
                <div class="cat_text">
                  {{$fcategory->name}}
                </div>
                </div>
              </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif

    @if($pagesettings[0]->latestpro_status)
    <section class="top_sell clearfix">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="heading">{{trans('app.LatestProducts')}}</h2>
          </div>
        </div>
        @if(count($latests) > 0)
        <div id="latest_product" class="owl-carousel">
          @foreach($latests as $product)

          @if($product->feature_image != '')
            @php $img_url = 'products/'.$product->feature_image @endphp
          @else
            @php $img_url = placeholder.jpg @endphp  
          @endif

          @php 
            $publishdate = strtotime($product->created_at);
            $nowdate = strtotime('-24 hours')
          @endphp
          
          <div class="item">
            <div class="col-md-12">
              <div class="sell_item">
                <div class="item_1" style="background-image: url('{{url('/assets/images')}}/<?php echo $img_url; ?>')">

                  @if($publishdate >= $nowdate)<span class="blue">{{trans('app.New')}}</span>@endif
                  @if($product->offer_price != "" && $product->offer_price != 0)<span class="red">{{trans('app.Sale')}}</span>@endif

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
                            <a href="{{Url('cart')}}" class="add_cart">{{trans('app.GoCart')}}</a>
                          @else
                            <a href="javascript:;" class="add_cart to-cart"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader">{{trans('app.AddCart')}}</a>
                          @endif
                        @else
                          <a href="javascript:;" class="add_cart out_stock_btn">{{trans('app.OutStock')}}</a>
                        @endif
                      </div>
                  </form>
                </div>
                
                <div class="sell_text clearfix">
                  <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}" class="name">{{$product->title}}</a><br>
                  <div class="ratings">
                    <div class="empty-stars"></div>
                    <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                  </div>
                  @if($product->offer_price != "" && $product->offer_price != 0)
                    <div class="price">{{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}} <span> {{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span></div>
                  @else
                    <div class="price">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @else
          <h4 style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</h4>
        @endif
      </div>
    </section>
    @endif

    @if($pagesettings[0]->featuredpro_status)
    <section class="top_sell clearfix">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="heading">{{trans('app.FeaturedProducts')}}</h2>
          </div>
        </div>
        @if(count($features) > 0)
        <div id="featured_product" class="owl-carousel">
          @foreach($features as $product)
          @if($product->feature_image != '')
            @php $img_url = 'products/'.$product->feature_image @endphp
          @else
            @php $img_url = placeholder.jpg @endphp  
          @endif

          @php 
            $publishdate = strtotime($product->created_at);
            $nowdate = strtotime('-24 hours')
          @endphp

          <div class="item">
            <div class="col-md-12">
              <div class="sell_item">
                <div class="item_1" style="background-image: url('{{url('/assets/images')}}/<?php echo $img_url; ?>')">

                  @if($publishdate >= $nowdate)<span class="blue">{{trans('app.New')}}</span>@endif
                  @if($product->offer_price != "" && $product->offer_price != 0)<span class="red">{{trans('app.Sale')}}</span>@endif

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
                            <a href="{{Url('cart')}}" class="add_cart">{{trans('app.GoCart')}}</a>
                          @else
                            <a href="javascript:;" class="add_cart to-cart"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader">{{trans('app.AddCart')}}</a>
                          @endif
                        @else
                        <a href="javascript:;" class="add_cart out_stock_btn">{{trans('app.OutStock')}}</a>
                        @endif
                      </div>
                  </form>
                </div>
                
                <div class="sell_text clearfix">
                  <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}" class="name">{{$product->title}}</a><br>
                  <div class="ratings">
                    <div class="empty-stars"></div>
                    <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                  </div>
                  @if($product->offer_price != "" && $product->offer_price != 0)
                    <div class="price">{{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}} <span> {{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span></div>
                  @else
                    <div class="price">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @else
          <h4 style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</h4>
        @endif
      </div>
    </section>
    @endif

    @if($pagesettings[0]->popularpro_status)
    <section class="top_sell clearfix">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="heading">{{trans('app.PopularProducts')}}</h2>
          </div>
        </div>
        @if(count($tops) > 0)
        <div id="popular_product" class="owl-carousel">
          @foreach($tops as $product)
          @if($product->feature_image != '')
            @php $img_url = 'products/'.$product->feature_image @endphp
          @else
            @php $img_url = placeholder.jpg @endphp  
          @endif

          @php 
            $publishdate = strtotime($product->created_at);
            $nowdate = strtotime('-24 hours')
          @endphp
          <div class="item">
            <div class="col-md-12">
              <div class="sell_item">
                <div class="item_1" style="background-image: url('{{url('/assets/images')}}/<?php echo $img_url; ?>')">

                  @if($publishdate >= $nowdate)<span class="blue">{{trans('app.New')}}</span>@endif
                  @if($product->offer_price != "" && $product->offer_price != 0)<span class="red">{{trans('app.Sale')}}</span>@endif

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
                            <a href="{{Url('cart')}}" class="add_cart">{{trans('app.GoCart')}}</a>
                          @else
                            <a href="javascript:;" class="add_cart to-cart"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader">{{trans('app.AddCart')}}</a>
                          @endif
                        @else
                          <a href="javascript:;" class="add_cart out_stock_btn">{{trans('app.OutStock')}}</a>
                        @endif
                      </div>
                  </form>
                </div>

                <div class="sell_text clearfix">
                  <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}" class="name">{{$product->title}}</a><br>
                  <div class="ratings">
                    <div class="empty-stars"></div>
                    <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                  </div>
                  @if($product->offer_price != "" && $product->offer_price != 0)
                    <div class="price">{{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}} <span> {{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span></div>
                  @else
                    <div class="price">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @else
          <h4 style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</h4>
        @endif
      </div>
    </section>
    @endif

    @if($pagesettings[0]->blogs_status)
    <section class="blog">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h2 class="heading">{{$languages->blog_title}}</h2>
          </div>
        </div>
        @if(count($blogs) > 0)
        <div class="row">
          <div class="col-md-12">
            <div class="blog-wrap owl-carousel">
              @foreach($blogs as $blog)
              <div class="blog-box">
                <div class="img-box">
                  @if($blog->featured_image != '')
                    <img src="{{url('/assets')}}/images/blog/{{$blog->featured_image}}" class="img-responsive">
                  @else
                    <img src="{{url('/')}}/assets/images/placeholder.jpg" class="img-responsive">
                  @endif
                </div>
                <div class="text-box">
                  <a href="{{url('/')}}/blog/{{$blog->id}}"><div class="blog-title">{{$blog->title}}</div></a>
                  <div class="date">{{date('F d, Y',strtotime($blog->created_at))}}</div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @else
          <h4 style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</h4>
        @endif
      </div>
    </section>
    @endif

    <section id="subscribe">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="text">
              {{trans('app.SignUpForNewsletter')}}
            </div>
          </div>
          <div class="col-md-6">
            <form id="subform" action="{{action('FrontEndController@subscribe',$subdomain_name)}}" method="post" class="col-12 col-sm-12 col-md">
              {{csrf_field()}}
              <input type="email" name="email" id="email" class="subsc" placeholder="{{trans('app.EnterEmail')}}">
              <button class="subsc" id="subs">{{trans('app.Subscribe')}}</button>
            </form>
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-6 input-group search-grp pull-right">
            <div id="resp" class="text-danger" style="text-align: left; margin: 10px 0px 0px 30px;"></div>
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