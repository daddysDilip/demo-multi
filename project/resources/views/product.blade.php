@extends('includes.newmaster')

@section('content')

<style type="text/css">
    .forum-content {
        width:500px;
        height:auto;
        padding:5px 10px;
    }
    .comments-space {
        width:90%;
        min-height:50px;
        height:auto;
        border-radius:5px;
        background:#f0f0f0;
        margin-bottom: 5px;
        padding: 3px 5px;
        text-align: justify;
    }
    .remaining-content span {
        display:none;
    }
</style>

    <div class="home-wrapper">
        <div class="section-padding product-details-wrapper padding-bottom-0 wow fadeInUp">
            <div class="container">
                <div class="product-projects-FullDiv-area">
                    <div class="breadcrumb-box">
                        <a href="{{url('/')}}">{{trans('app.Home')}}</a>
                        <a href="{{url('/category')}}/{{\App\Category::where('id',$productdata->category[0])->first()->slug}}">{{\App\Category::where('id',$productdata->category[0])->first()->name}}</a>
                        @if($productdata->category[1] != "")
                            <a href="{{url('/category')}}/{{\App\Category::where('id',$productdata->category[1])->first()->slug}}">{{\App\Category::where('id',$productdata->category[1])->first()->name}}</a>
                        @endif
                        @if($productdata->category[2] != "")
                            <a href="{{url('/category')}}/{{\App\Category::where('id',$productdata->category[2])->first()->slug}}">{{\App\Category::where('id',$productdata->category[2])->first()->name}}</a>
                        @endif
                        <a href="{{url('/product')}}/{{$productdata->id}}/{{str_replace(' ','-',strtolower($productdata->title))}}">{{$productdata->title}}</a>
                    </div>

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
                            <h2 class="product-header">{{$productdata->title}}</h2>
                            
                            <p class="product-status">
                            @if($productdata->stock != 0 || $productdata->stock === null )
                                <span class="available">
                                    <i class="fa fa-check-square-o"></i>
                                    <span>{{ trans('app.QuickReview') }}</span>
                                </span>
                            @else
                                <span class="not-available">
                                    <i class="fa fa-times-circle-o"></i>
                                    <span>{{ trans('app.OutStock') }}</span>
                                </span>
                            @endif

                            </p>
                            <div>
                                <div class="ratings">
                                    <div class="empty-stars"></div>
                                    <div class="full-stars" style="width:{{\App\Review::ratings($productdata->id)}}%"></div>
                                </div>
                                @if(\App\Review::reviewCount($productdata->id) > 1)
                                    <span>{{\App\Review::reviewCount($productdata->id)}} {{ trans('app.Reviews') }}</span>
                                @else
                                    <span>{{\App\Review::reviewCount($productdata->id)}} {{ trans('app.Review') }}</span>
                                @endif
                            </div>
                            <p class="product-description">
                                {!! htmlspecialchars_decode($productdata->description) !!}
                            </p>
                            <h1 class="product-price">
                                @if($productdata->offer_price != "" && $productdata->offer_price != 0) 
                                    {{$settings[0]->currency_sign}}{{number_format($productdata->offer_price,2)}}
                                    <span>
                                        <del>{{$settings[0]->currency_sign}}{{number_format($productdata->price,2)}}</del> 
                                    </span>
                                @else
                                    {{$settings[0]->currency_sign}}{{number_format($productdata->price,2)}}
                                @endif
                            </h1>

                            @if($productdata->sizes != null)
                                <div class="product-size" id="product-size">
                                <p>Size</p>
                                    @foreach(explode(',',$productdata->sizes) as $size)
                                    <span>{{$size}}</span>
                                    @endforeach
                                </div>
                            @endif
                            <!-- <div class="product-quantity">
                                <p>{{$language->quantity}}</p>
                                @if($productdata->stock != 0 || $productdata->stock === null )
                                    <span class="quantity-btn" id="qty-minus"><i class="fa fa-minus"></i></span>
                                    <span id="pqty">1</span>
                                    <span class="quantity-btn" id="qty-add"><i class="fa fa-plus"></i></span>
                                @else
                                    <span class="quantity-btn" style="cursor: unset;"><i class="fa fa-minus"></i></span>
                                    <span id="pqty">0</span>
                                    <span class="quantity-btn" style="cursor: unset;"><i class="fa fa-plus"></i></span>
                                @endif
                            </div> -->
                            <form class="addtocart-form">
                                {{csrf_field()}}
                                @if(Session::has('uniqueid'))
                                    <input type="hidden" name="uniqueid" value="{{Session::get('uniqueid')}}">
                                @else
                                    <input type="hidden" name="uniqueid" value="{{str_random(7)}}">
                                @endif
                                <input type="hidden" name="price" value="{{$productdata->selling_price}}">
                                <input type="hidden" name="title" value="{{$productdata->title}}">
                                <input type="hidden" name="product" value="{{$productdata->id}}">
                                <input type="hidden" name="shipping_cost" value="{{$productdata->shipping_cost}}">
                                <input type="hidden" name="tax" value="{{$productdata->tax}}">
                                <input type="hidden" name="cost" value="{{$productdata->selling_price}}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" id="productimage" name="productimage" value="{{$productdata->feature_image}}">
                                <div class="signle_addcart_{{$productdata->id}}">
                                @if($productdata->stock != 0 || $productdata->stock === null )
                                    @if((\App\Cart::where('product',$productdata->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                    <a href="{{Url('cart')}}" type="button" class="product-addCart-btn"><i class="fa fa-cart-plus"></i><span>{{trans('app.GoCart')}}</span></a>
                                    @else
                                    <button type="button" class="product-addCart-btn to-cart"><i class="fa fa-cart-plus"></i><span>{{trans('app.AddCart')}}</span></button>
                                    @endif
                                @else
                                    <button type="button" class="product-addCart-btn  to-cart" disabled><i class="fa fa-cart-plus"></i>{{trans('app.OutStock')}}</button>
                                @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-padding product-description-wrapper padding-bottom-0 padding-top-0 wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="custom-tab">
                            <div class="row">
                                <div class="col-md-5">
                                    <ul class="tab-list">
                                        <li class="active"><a data-toggle="tab" href="#overview-tab-1">{{ trans('app.Description') }}</a></li>
                                        <li><a data-toggle="tab" href="#pricing-tab-2">{{ trans('app.ReturnPolicy') }}</a></li>
                                        <li><a data-toggle="tab" href="#location-tab-3">{{ trans('app.Reviews') }} ({{\App\Review::reviewCount($productdata->id)}})</a></li>
                                    </ul>
                                </div>

                                <div class="col-md-7">
                                    @if(Session::has('message'))
                                        <div class="alert alert-success alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            {{ Session::get('message') }}
                                        </div>
                                    @endif
                                    <div class="tab-content">
                                        <div id="overview-tab-1" class="tab-pane active fade in">
                                            <p>{!! $productdata->description !!}</p>
                                        </div>

                                        <div id="pricing-tab-2" class="tab-pane fade">
                                            <p>{!! $productdata->policy !!}</p>
                                        </div>

                                        <div id="location-tab-3" class="tab-pane fade">
                                            <p>
                                            <h3>{{ trans('app.Reviews') }}: </h3>
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
                                                                        <span class="glyphicon glyphicon-star"></span>5
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
                                                                        <span class="glyphicon glyphicon-star"></span>4
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
                                                                        <span class="glyphicon glyphicon-star"></span>3
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
                                                                        <span class="glyphicon glyphicon-star"></span>2
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
                                                                        <span class="glyphicon glyphicon-star"></span>1
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
                                                            <div class="col-md-6 col-sm-6 pull-left">
                                                                <i class="fa fa-calendar"></i>  {{date('jS M Y',strtotime($review->review_date))}}
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 pull-right">
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

                                            <div id="myModal" class="modal fade login_user" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <form action="" method="POST" id="customer_login">
                                                        {{ csrf_field() }}
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">{{trans('app.Login')}}</h4>
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

                                            <h3>{{trans('app.WriteReview')}}</h3>
                                            <hr>
                                            <div class="write_review_msg">
                                                <h5>{{trans('app.NoWriteReviewmsg')}}</h5>
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
                </div>
            </div>
        </div>

        @if(count($relateds) > 0)
        <div class="section-padding product-carousel-wrapper wow fadeInUp related_product_sec">
            <div class="container">
                <div class="product-carousel-full-div">
                    <div class="row margin-bottom-0">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2>{{ trans('app.RelatedProducts') }}</h2>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product-carousel-list related_product">
                                @foreach($relateds as $product)
                                    <div class="single-product-carousel-item text-center">
                                        <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}"> <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" alt="Product Image" /> </a>
                                        <div class="product-carousel-text">
                                            <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">
                                                <h4 class="product-title">{{$product->title}}</h4>
                                            </a>
                                            <div class="ratings">
                                                <div class="empty-stars"></div>
                                                <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                                            </div>
                                            @if($product->offer_price != "" && $product->offer_price != 0)
                                            <div class="product-price">
                                                <span class="original-price">{{$settings[0]->currency_sign}}{{$product->offer_price}}</span><br>
                                                <del class="offer-price">{{$settings[0]->currency_sign}}{{$product->price}}</del>
                                            </div>
                                            @else
                                            <div class="product-price" style="padding-bottom: 25px;">
                                                <span class="original-price">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                                                </div>
                                            @endif
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
                                                        <input type="hidden" name="cost" value="{{$product->selling_price}}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <input type="hidden" id="productimage" name="productimage" value="{{$product->feature_image}}">
                                                        <div class="related_addcart_{{$product->id}}">
                                                        @if($product->stock != 0 || $product->stock === null )
                                                            @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                                                <a href="{{Url('cart')}}" type="button" class="addTo-cart"><i class="fa fa-cart-plus"></i><span>{{trans('app.GoCart')}}</span></a>
                                                            @else
                                                                <button type="button" class="addTo-cart to-cart"><i class="fa fa-cart-plus"></i><span>{{trans('app.AddCart')}}</span></button>
                                                            @endif
                                                        @else
                                                            <button type="button" class="addTo-cart  to-cart" disabled><i class="fa fa-cart-plus"></i>{{trans('app.OutStock')}}</button>
                                                        @endif
                                                        </div>
                                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>



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
            messages:{
                title:{
                    remote: AlreadyExist,
                }
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
        }, ValidEmailError);

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