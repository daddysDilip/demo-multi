@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>
    
    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{url('/category')}}/{{\App\Category::where('id',$productdata->category[0])->first()->slug}}">{{\App\Category::where('id',$productdata->category[0])->first()->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$productdata->title}}</li>
            </ol>
        </div>
    </nav>

    <div class="product-detail-wrap" id="magnific">
        <div class="container">
          <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-12">
                <div class="product-review-carousel-img product-zoom">
                    <img id="imageDiv" src="{{url('/assets/images/products')}}/{{$productdata->feature_image}}" alt="">
                </div>
                <div class="product-review-owl-carousel">
                    <div class="single-product-item">
                        <img id="iconOne" onclick="productGallery(this.id)" src="{{url('/assets/images/products')}}/{{$productdata->feature_image}}" alt="">
                    </div>
                    @forelse($gallery as $galdta)
                        <div class="single-product-item">
                            <img id="galleryimg{{$galdta->id}}" onclick="productGallery(this.id)" src="{{url('/assets/images/gallery')}}/{{$galdta->image}}" alt="">
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="prod-detail-text">
                    <h3>{{$productdata->title}}</h3>
                    
                    <div class="ratings">
                        <div class="empty-stars"></div>
                        <div class="full-stars" style="width:{{\App\Review::ratings($productdata->id)}}%"></div>
                    </div>
                    @if(\App\Review::reviewCount($productdata->id) > 1)
                        <span class="review_label">{{\App\Review::reviewCount($productdata->id)}} {{trans('app.Reviews')}}</span>
                    @else
                        <span class="review_label">{{\App\Review::reviewCount($productdata->id)}} {{trans('app.Review')}}</span>
                    @endif

                    @if($productdata->description != '')
                        {!! htmlspecialchars_decode($productdata->description) !!}
                    @endif

                    <hr>
                    <form class="addtocart-form">
                        {{csrf_field()}}
                        @if(Session::has('uniqueid'))
                            <input type="hidden" name="uniqueid" value="{{Session::get('uniqueid')}}">
                        @else
                            <input type="hidden" name="uniqueid" value="{{str_random(7)}}">
                        @endif
                      
                        <input type="hidden" name="title" value="{{$productdata->title}}">
                        <input type="hidden" name="product" value="{{$productdata->id}}">
                        <input type="hidden" name="shipping_cost" value="{{$productdata->shipping_cost}}">
                        <input type="hidden" name="tax" value="{{$productdata->tax}}">
                        <input type="hidden" name="cost" value="{{$productdata->selling_price}}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="productimage" value="{{$productdata->feature_image}}">
                        <div class="signle_addcart_{{$productdata->id}}">
                            @if($productdata->stock != 0 || $productdata->stock === null )
                                @if((\App\Cart::where('product',$productdata->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                    <a href="{{Url('cart')}}" class="p-btn buy-now">{{trans('app.GoCart')}}</a>
                                @else
                                    <a href="javascript:;" class="to-cart p-btn buy-now"><img src="{{url('/assets/images')}}/default.gif" id="loadr_img" class="to_cart_loader">{{trans('app.AddCart')}}</a>
                                @endif
                            @else
                                <a href="javascript:;" class="out_stock_btn p-btn buy-now">{{trans('app.OutStock')}}</a>
                            @endif
                        </div>
                    </form>
                    <!-- <button class="buy-now">Add to Cart</button> -->
                   
                    <div class="desc">
                        @php $myArray = array(); @endphp
                        @foreach($productdata->category as $categories)
                           @php $myArray[] = \App\Category::find($categories)->name; @endphp
                        @endforeach
                       
                        <p><strong>{{trans('app.Category')}} :</strong>  {{implode( ', ', $myArray )}}<br></p>
                        <p><strong>{{trans('app.SKU')}} :</strong> {{$productdata->skucode}} <br></p>
                    </div>
                    <div class="share">
                      <h6>{{trans('app.Share')}} :</h6>
                        <ul>
                            @if($sociallinks[0]->f_status == "enable")
                              <li><a href="{{$sociallinks[0]->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                            @endif
                            @if($sociallinks[0]->g_status == "enable")
                              <li><a href="{{$sociallinks[0]->g_plus}}"><i class="fab fa-google"></i></a></li>
                            @endif
                            @if($sociallinks[0]->t_status == "enable")
                              <li><a href="{{$sociallinks[0]->twiter}}"><i class="fab fa-twitter"></i></a></li> 
                            @endif
                            @if($sociallinks[0]->link_status == "enable")
                              <li><a href="{{$sociallinks[0]->linkedin}}"><i class="fab fa-linkedin"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">

              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#desc">{{ trans('app.Description') }}</a></li>
                <li><a data-toggle="tab" href="#info">{{ trans('app.ReturnPolicy') }}</a></li>
                <li><a data-toggle="tab" href="#reviews">{{ trans('app.Reviews') }} ({{\App\Review::reviewCount($productdata->id)}})</a></li>
              </ul>

              <div class="tab-content">

                <div id="desc" class="tab-pane fade in active">
                  <div class="row">
                    <div class="col-sm-12">
                      <p>{!! htmlspecialchars_decode($productdata->description) !!}</p>
                    </div>
                  </div>
                </div>

                <div id="info" class="tab-pane fade">
                    <p class="table">{!! htmlspecialchars_decode($productdata->policy) !!}</p>
                </div>

                <div id="reviews" class="tab-pane fade">
                    <h4 class="f-weight600">{{ trans('app.Reviews') }}: </h4>
                    <hr>
                    <div class="review-rating-description">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-12 col-md-4 text-center">
                                    <h1 class="rating-num">
                                    {{\App\Review::totalratings($productdata->id)}}</h1>
                                    <div class="ratings">
                                        <div class="empty-stars"></div>
                                        <div class="full-stars" style="width:{{\App\Review::ratings($productdata->id)}}%"></div>
                                    </div>
                                    <div>
                                        {{\App\Review::reviewCount($productdata->id)}} {{ trans('app.Reviews') }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-8">
                                    <div class="rating-desc">
                                        <div class="row ">
                                            <div class="col-xs-3 col-md-2 text-right">
                                                <i class="fa fa-star f-12"></i>5
                                            </div>
                                            <div class="col-xs-7 col-md-8">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{\App\Review::reviewByratings($productdata->id,5)}}"
                                                        aria-valuemin="0" aria-valuemax="100" style="width:{{\App\Review::reviewByratings($productdata->id,5)}}%">
                                                        <span class="sr-only">{{\App\Review::reviewByratings($productdata->id,5)}}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-md-2">
                                                {{\App\Review::reviewCountByratings($productdata->id,5)}}
                                            </div>
                                        </div>
                                        <!-- end 5 -->
                                        <div class="row ">
                                            <div class="col-xs-3 col-md-2 text-right">
                                                <i class="fa fa-star f-12"></i>4
                                            </div>
                                            <div class="col-xs-7 col-md-8">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{\App\Review::reviewByratings($productdata->id,4)}}"
                                                        aria-valuemin="0" aria-valuemax="100" style="width: {{\App\Review::reviewByratings($productdata->id,4)}}%">
                                                        <span class="sr-only">{{\App\Review::reviewByratings($productdata->id,4)}}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-md-2">
                                                {{\App\Review::reviewCountByratings($productdata->id,4)}}
                                            </div>
                                        </div>
                                        <!-- end 4 -->
                                        <div class="row ">
                                            <div class="col-xs-3 col-md-2 text-right">
                                                <i class="fa fa-star f-12"></i>3
                                            </div>
                                            <div class="col-xs-7 col-md-8">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{\App\Review::reviewByratings($productdata->id,3)}}"
                                                        aria-valuemin="0" aria-valuemax="100" style="width: {{\App\Review::reviewByratings($productdata->id,3)}}%">
                                                        <span class="sr-only">{{\App\Review::reviewByratings($productdata->id,3)}}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-md-2">
                                                {{\App\Review::reviewCountByratings($productdata->id,3)}}
                                            </div>
                                        </div>
                                        <!-- end 3 -->
                                        <div class="row ">
                                            <div class="col-xs-3 col-md-2 text-right">
                                                <i class="fa fa-star f-12"></i>2
                                            </div>
                                            <div class="col-xs-7 col-md-8">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{\App\Review::reviewByratings($productdata->id,2)}}"
                                                        aria-valuemin="0" aria-valuemax="100" style="width: {{\App\Review::reviewByratings($productdata->id,2)}}%">
                                                        <span class="sr-only">{{\App\Review::reviewByratings($productdata->id,2)}}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-md-2">
                                                {{\App\Review::reviewCountByratings($productdata->id,2)}}
                                            </div>
                                        </div>
                                        <!-- end 2 -->
                                        <div class="row ">
                                            <div class="col-xs-3 col-md-2 text-right">
                                                <i class="fa fa-star f-12"></i>1
                                            </div>
                                            <div class="col-xs-7 col-md-8">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{\App\Review::reviewByratings($productdata->id,1)}}"
                                                        aria-valuemin="0" aria-valuemax="100" style="width: {{\App\Review::reviewByratings($productdata->id,1)}}%">
                                                        <span class="sr-only">{{\App\Review::reviewByratings($productdata->id,1)}}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-md-2">
                                                {{\App\Review::reviewCountByratings($productdata->id,1)}}
                                            </div>
                                        </div>
                                        <!-- end 1 -->
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                        </div>
                        <div id="all_reviews">
                            @foreach($reviews as $review)
                            <div class="all_userreview">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <i class="fa fa-calendar"></i>  {{date('jS M Y',strtotime($review->review_date))}}
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="ratings">
                                            <div class="empty-stars"></div>
                                            <div class="full-stars" style="width:{{$review->rating*20}}%"></div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12"><p><b>{{$review->name}}</b></p></div>
                                    <div class="col-md-12"><p>{{$review->review}}</p></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if(count($reviews) > 3)
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img id="load" src="{{url('/assets/images/default.gif')}}" style="display: none;width: 80px;">
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="hidden" id="page" value="2">
                                    <a href="javascript:;" id="loadMore" class="product-filter-loadMore-btn">{{trans('app.LoadMore')}}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <hr>
                    @if(Auth::guard('profile')->guest())
                    <button class="btn btn-md btn-default" data-toggle="modal" data-target="#myModal">{{trans('app.WriteReview')}}</button>

                    <div id="myModal" class="modal login_user">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <form action="" method="POST" id="customer_login">
                                {{ csrf_field() }}
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{trans('app.Login')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                            <input class="form-control" value="{{ old('email') }}" type="email" name="email" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">{{trans('app.Password')}} <span>*</span></label>
                                            <input class="form-control" type="password" name="password" id="password">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <a href="{{route('user.reg',$subdomain_name)}}">{{trans('app.CreateNewAccount')}}</a>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                                    <a href="{{route('user.forgotpass',$subdomain_name)}}">{{trans('app.ForgotYourPassword')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="suceessresp" style="display: none;">
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>{{trans('app.SuccessfullyLogin')}}</strong>
                                            </div>
                                        </div>
                                        <div id="resp" style="display: none;">
                                            <div class="alert alert-danger alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>{{trans('auth.failed')}}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input class="btn btn-md btn-success login-btn" type="submit" value="{{trans('app.Login')}}">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('app.Close')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else

                    <h3 class="f-24 f-weight600">{{trans('app.WriteReview')}}</h3>
                    <hr>
                    <div class="write_review_msg">
                        <h5 class="f-14"><b>{{trans('app.NoWriteReviewmsg')}}</b></h5>
                    </div>
                    <div class="write_review_sec">
                        
                        <div class="review-star">
                            <div class='starrr' id='star1'></div>
                            <div>
                                <span class='your-choice-was' style='display: none;'>
                                    {{trans('app.YourRatingIs')}}: <span class='choice'></span>.
                                </span>
                            </div>
                        </div>
                        
                        <form class="product-review-form" method="POST" action="{{route('review.submit',$subdomain_name)}}" id="review_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="rating" id="rate" value="5">
                            <input type="hidden" name="productid" value="{{$productdata->id}}">
                            <div class="form-group">
                                <input name="name" type="text" class="form-control" placeholder="{{trans('app.Name')}}" minlength="3" maxlength="50">
                            </div>
                            <div class="form-group">
                                <input name="email" type="email" class="form-control" placeholder="{{trans('app.EmailAddress')}}" minlength="3" maxlength="50">
                            </div>
                            <div class="form-group">
                                <textarea name="review" id="" rows="5" placeholder="{{trans('app.ReviewDetails')}}" class="form-control" style="resize: vertical;" minlength="3" maxlength="255"></textarea>
                            </div>
                            @if ($errors->has('error'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <div class="form-group text-center">
                                <input name="btn" type="submit" class="btn-review" value="{{trans('app.Submit')}}">
                            </div>
                        </form>
                    </div>
                    @endif
                </div>

              </div>
            </div>
          </div>
        </div>
    </div>

    @if(count($relateds) > 0)
    <section id="related_product" class="product-slider-wrap slider2 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="product-wrapper">

                        <div class="prod-header">
                          <span>{{ trans('app.RelatedProducts') }}</span>
                        </div>

                        <div class="product-slider owl-carousel">
                            @foreach($relateds as $product)
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
                                        <input type="hidden" name="cost" value="{{$product->selling_price}}">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="productimage" value="{{$product->feature_image}}">
                                        <div class="related_addcart_{{$product->id}}">
                                            @if($product->stock != 0 || $product->stock === null )
                                                @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                                    <a href="{{Url('cart')}}" class="p-btn buy-now">{{ trans('app.GoCart') }}</a>
                                                @else
                                                    <a href="javascript:;" class="to-cart p-btn buy-now"><img src="{{url('/assets/images')}}/default.gif" id="loadr_img" class="to_cart_loader">{{ trans('app.AddCart') }}</a>
                                                @endif
                                            @else
                                                <a href="javascript:;" class="out_stock_btn p-btn buy-now">{{ trans('app.OutStock') }}</a>
                                            @endif
                                        </div>
                                    </form>
                                </div>

                                @if($product->offer_price != "" && $product->offer_price != 0)
                                    <div class="sale-tag">{{ trans('app.Sale') }}</div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

</main>

@stop

@section('footer')

<script type="text/javascript">

$(".all_userreview").slice(0, 3).show();

var $group = $('.all_userreview');

$("#loadMore").click(function() {
    
    if ($(this).hasClass('disable')) return false;

    var $hidden = $group.filter(':hidden:first').addClass('active');
    if (!$hidden.next('.all_userreview').length) {
        $(this).css("display", "none");
    }
});

var showChar = 256;
var ellipsestext = "...";
var moretext = "See More";
var lesstext = "See Less";
$('.product-description').each(function () {
    var content = $(this).html();
    if (content.length > showChar) {
        var show_content = content.substr(0, showChar);
        var hide_content = content.substr(showChar, content.length - showChar);
        var html = show_content + '<span class="moreelipses">' + ellipsestext + '</span><span class="remaining-content"><span>' + hide_content + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
        $(this).html(html);
    }
});

$(".morelink").click(function () {
    if ($(this).hasClass("less")) {
        $(this).removeClass("less");
        $(this).html(moretext);
    } else {
        $(this).addClass("less");
        $(this).html(lesstext);
    }
    $(this).parent().prev().toggle();
    $(this).prev().toggle();
    return false;
});

$('#star1').starrr({
    rating: 5,
    change: function(e, value){
        if (value) {
            $('.your-choice-was').show();
            $('.choice').text(value);
            $('#rate').val(value);
        } else {
            $('.your-choice-was').hide();
        }
    }
});

$("#showmore").click(function() {
    $('html, body').animate({
        scrollTop: $("#description").offset().top - 200
    }, 1000);
});

$(':input').change(function() {
    $(this).val($(this).val().trim());
});

$(document).ready(function(){

    $.validator.addMethod('Validemail', function (value, element) {
        return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
    }, ValidEmailError);

    $('#review_form').validate({
        rules:{
            name:{
                required:true,
                minlength: 3,
                maxlength: 50,
            },
            email:{
                required:true,
                Validemail:true, 
                minlength: 3,
                maxlength: 50,
            },
            review:{
                required:true, 
                minlength: 3,
                maxlength: 255,
            },
        },
        highlight: function (element) {
            $(element).parent().addClass('has-error')
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('has-error')
        },
        errorElement: 'span',
        errorClass: 'text-danger',
    });

});


$(':input').change(function() {
    $(this).val($(this).val().trim());
});

$(document).ready(function(){

    $.validator.addMethod('Validemail', function (value, element) {
        return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
    }, "Please enter a valid email address.");

    $('#customer_login').validate({
        rules:{
            email:{
                required:true,
                Validemail: true,
                minlength: 3,
                maxlength: 50,
            },
            password:{
                required:true,
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: "post",
                url: "{{ URL('userlogin') }}",
                data: $(form).serialize(),
                dataType: 'JSON',
                success:function(data){
                    console.log(data);
                    if(data.auth == true)
                    {
                        $('#suceessresp').show();
                        $('#resp').hide();
                        setTimeout(function(){ location.reload(); }, 500);
                    }
                    else
                    {
                        $('#resp').show();
                        $('#suceessresp').hide();
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
        errorElement: 'span',
        errorClass: 'text-danger',
    });

    var pid = $('input[name="product"]').val();

    $.ajax({
        type: "get",
        url: "{{ URL('customerdetail') }}",
        data: {pid: pid},
        dataType: 'JSON',
        success: function(response) {
            if(response.purchaseproduct == '')
            {
                $('.write_review_sec').hide();
                $('.write_review_msg').show();
            }
            else
            {
                $('.write_review_msg').hide();
                $('.write_review_sec').show();
            }
        },        
    });

});


</script>

@stop