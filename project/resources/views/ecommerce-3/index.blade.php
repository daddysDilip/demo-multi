@extends('ecommerce-3.includes.newmaster')

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
              <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="banner_content">
                      <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <h1>{{$allslider->title}}</h1>
                        {!! htmlspecialchars_decode($allslider->text) !!}
                      </div>
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

    <section class="clearfix" id="collection">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 col-lg-2 col-xs-6">
            <div class="collection_box">
              <div class="img_box" style="background-image: url('images/collection-1.jpg');"></div>
              <a href="#">Collection 1</a>
            </div>
          </div>
          <div class="col-md-4 col-lg-2 col-xs-6">
            <div class="collection_box">
              <div class="img_box" style="background-image: url('images/collection-2.jpg');"></div>
              <a href="#">Collection 2</a>
            </div>
          </div>
          <div class="col-md-4 col-lg-2 col-xs-6">
            <div class="collection_box">
              <div class="img_box" style="background-image: url('images/collection-3.jpg');"></div>
              <a href="#">Collection 3</a>
            </div>
          </div>
          <div class="col-md-4 col-lg-2 col-xs-6">
            <div class="collection_box">
              <div class="img_box" style="background-image: url('images/collection-4.jpg');"></div>
              <a href="#">Collection 4</a>
            </div>
          </div>
          <div class="col-md-4 col-lg-2 col-xs-6">
            <div class="collection_box">
              <div class="img_box" style="background-image: url('images/collection-5.jpg');"></div>
              <a href="#">Collection 5</a>
            </div>
          </div>
          <div class="col-md-4 col-lg-2 col-xs-6">
            <div class="collection_box">
              <div class="img_box" style="background-image: url('images/collection-6.jpg');"></div>
              <a href="#">Collection 6</a>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- <section id="offer_banner" class="clearfix">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="offer_box" style="background-image: url('images/offer_1.jpg');">
              <div class="offer_text">
                <h3>GET AN EXTRA<br> 20% OFF<br> FIRST ORDER</h3>
                <a href="#">Read more...</a>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="offer_box" style="background-image: url('images/offer_2.jpg');">
              <div class="offer_text1">
                <h3>Big Sale!<br> Save UPTO<br> 50% OFF</h3>
                <a href="#">Read more...</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="just_us" class="clearfix">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="heading">The New Necessary: Just Us</h2>
            <p class="heading">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br>incididunt ut labore et dolore magna aliqua.</p>
          </div>
        </div>
        <div class="row right_img">
            <div class="col-sm-4">
              <div class="just_text_right">
                <h3>VALENTINE'S<br>DAY Offer!</h3>
                <p>VALENTINE'S DAY | From date night ideas to the chicest gifts, we guarantee you'll love our expert picks.</p>
                <a href="#" class="shop">shop now</a>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="img_box" style="background-image: url('images/just-1.jpg');"></div>
            </div>
        </div>
        <div class="row right_img">
            <div class="col-sm-8">
              <div class="img_box" style="background-image: url('images/just-2.jpg');"></div>
            </div>
            <div class="col-sm-4">
              <div class="just_text_left">
                <h3>VALENTINE'S<br>DAY Offer!</h3>
                <p>VALENTINE'S DAY | From date night ideas to the chicest gifts, we guarantee you'll love our expert picks.</p>
                <a href="#" class="shop">shop now</a>
              </div>
            </div>
        </div>
        <div class="row right_img">
            <div class="col-sm-4">
              <div class="just_text_right">
                <h3>VALENTINE'S<br>DAY Offer!</h3>
                <p>VALENTINE'S DAY | From date night ideas to the chicest gifts, we guarantee you'll love our expert picks.</p>
                <a href="#" class="shop">shop now</a>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="img_box" style="background-image: url('images/just-1.jpg');"></div>
            </div>
        </div>
      </div>
    </section> -->
    @if($pagesettings[0]->latestpro_status)
      @if(count($latests) > 0)
      <section class="clearfix" id="feat_prod">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <h2 class="heading">Featured Products</h2>
                <p class="heading">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br>incididunt ut labore et dolore magna aliqua.</p>
              </div>
            </div>
            <div class="owl-carousel" id="yoga-slider">
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
                <div class="img_feat_box" style="background-image: url('{{url('/assets/images')}}/<?php echo $img_url; ?>');">
                  <div class="off">50% Off</div>
                  <div class="feat_name">
                    <a href="#" class="pull-left" style="padding-left: 20px;">Consectetur adipiscing</a>
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
                            <a href="{{Url('cart')}}" class="add_cart">Go To Cart</a>
                          @else
                            <a href="javascript:;" class="add_cart to-cart"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader" style="display: none;">{{$language->add_to_cart}}</a>
                          @endif
                        @else
                          <a href="javascript:;" class="add_cart out_stock_btn">{{$language->out_of_stock}}</a>
                        @endif
                      </div>
                    </form>
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

$(document).ready(function(){

  $.validator.addMethod('Validemail', function (value, element) {
    return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
  }, "Please enter a valid email address.");

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
            $("#resp").html('<span style=\"color:#00C708;\">You are subscribed successfully.</span>').show().fadeOut(5000);
          }
          else if(data == 'fail')
          {
            $("#subform")[0].reset();
            $("#resp").html('<span style="color:#F90600;">You are already subscribed.</span>').show().fadeOut(5000);
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

