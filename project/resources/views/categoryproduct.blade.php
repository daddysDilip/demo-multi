@extends('includes.newmaster')

@section('content')


    <div class="home-wrapper category_sec">
        <!-- Starting of product filter breadcroumb area -->
        
    <section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
        <div class="row" style="background-color:rgba(0,0,0,0.7);">

            <div style="margin: 3% 0px 3% 0px;">
                <div class="text-center" style="color: #FFF;padding: 20px;">
                    @if(is_object($category))
                        <h1>{{$category->name}}</h1>
                    @else
                        <h1>{{trans('app.NoCategoryFound')}}</h1>
                    @endif
                </div>
            </div>
        </div>
    </section>
        <!-- Ending of product filter breadcroumb area -->

        <!-- Starting of product filter area -->
        <div class="section-padding product-filter-wrapper wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                        <div class="product-filter-leftDiv">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="product-filter-option">
                                        <h2 class="filter-title">{{trans('app.FilterOption')}}</h2>
                                            <div class="form-group">
                                                <select id="sortby" class="form-control">
                                                    @if($sort == "new")
                                                        <option value="new" selected>{{trans('app.SortByLatest')}}</option>
                                                    @else
                                                        <option value="new">{{trans('app.SortByLatest')}}</option>
                                                    @endif
                                                    @if($sort == "old")
                                                        <option value="old" selected>{{trans('app.SortByOldest')}}</option>
                                                    @else
                                                        <option value="old">{{trans('app.SortByOldest')}}</option>
                                                    @endif
                                                    @if($sort == "low")
                                                        <option value="low" selected>{{trans('app.SortByLowest')}}</option>
                                                    @else
                                                        <option value="low">{{trans('app.SortByLowest')}}</option>
                                                    @endif
                                                    @if($sort == "high")
                                                        <option value="high" selected>{{trans('app.SortByHighest')}}</option>
                                                    @else
                                                        <option value="high">{{trans('app.SortByHighest')}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="product-filter-option">
                                        <h2 class="filter-title">{{trans('app.AllCategories')}}</h2>
                                        <ul>
                                            @foreach($menus as $menu)
                                                @php $submenu = App\Category::where('mainid',$menu->id)->where('role','sub')->where('status',1)->count() @endphp
                                                <li>
                                                <span href="#{{$menu->slug}}-1" aria-expanded="false" data-toggle="collapse">
                                                    @if($submenu > 0)<i class="fa fa-plus"></i><i class="fa fa-minus"></i>@endif
                                                </span>
                                                    <a href="{{url('/category')}}/{{$menu->slug}}">{{$menu->name}}</a>
                                                    <ul id="{{$menu->slug}}-1" class="collapse">
                                                        @foreach(\App\Category::where('mainid',$menu->id)->where('role','sub')->where('status',1)->get() as $submenu)
                                                            @php $childmenu = App\Category::where('subid',$submenu->id)->where('role','child')->where('status',1)->count() @endphp
                                                            <li>
                                                            <span href="#{{$submenu->slug}}-1" aria-expanded="false" data-toggle="collapse">
                                                            @if($childmenu > 0)<i class="fa fa-plus"></i><i class="fa fa-minus"></i>@endif
                                                            </span>
                                                                <a href="{{url('/category')}}/{{$submenu->slug}}">{{$submenu->name}}</a>
                                                                <ul id="{{$submenu->slug}}-1" class="collapse">
                                                                    @foreach(\App\Category::where('subid',$submenu->id)->where('role','child')->where('status',1)->get() as $childmenu)
                                                                        <li><i class="fa fa-angle-right"></i><a href="{{url('/category')}}/{{$childmenu->slug}}">{{$childmenu->name}}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if(count($products) > 0)
                                @if($mins != $maxs)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="product-filter-option">
                                            <h2 class="filter-title">{{trans('app.Price')}}</h2>
                                            <form action="" method="GET">
                                                <div class="form-group padding-bottom-10">
                                                    <input id="ex2" type="text" class="form-control" value="" data-slider-min="{{$minvalue}}" data-slider-max="{{$maxvalue}}" data-slider-step="5" data-slider-value="[{{$mins}},{{$maxs}}]"/>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="price-min" class="price-input" value="{{$mins}}" name="min">
                                                    <i class="fa fa-minus"></i>
                                                    <input type="text" id="price-max" class="price-input" value="{{$maxs}}" name="max">
                                                    <input type="submit" class="price-search-btn" value="{{trans('app.Search')}}">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif
                            
                            @if($settings[0]->popular_tags)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="product-filter-option">
                                        <h2 class="filter-title">{{trans('app.PopularTags')}}</h2>
                                        <div class="product-filter-content tags">
                                            @foreach(explode(',',$settings[0]->popular_tags) as $tag)
                                                <a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                        <div class="product-filter-rightDiv">
                            <div class="row" id="products">
                                <div class="col-md-12">
                                    @forelse($products as $product)
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 all_product">
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
                                                            <div class="addcart_sec_{{$product->id}}">
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
                                                        <a  href="javascript:;" class="wish-list" onclick="getQuickView({{$product->id}})" data-toggle="modal" data-target="#myModal">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row" style="margin-left: 0">
                                            <div class="col-md-12">
                                                <h3 style="margin-bottom: 0px;">{{trans('app.NoProductsFound')}}</h3>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            @if(count($products) > 9)
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img id="load" src="{{url('/assets/images/default.gif')}}" style="display: none;width: 80px;">
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="hidden" id="page" value="2">
                                    <a href="javascript:;" id="load-more" class="product-filter-loadMore-btn">load more</a>
                                </div>
                            </div>
                            @endif
                            <div class="pagination-container">
                                {{ $products->links() }}
                                <!-- /.list-inline --> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ending of product filter area -->

    </div>


@stop

@section('footer')
<script type="text/javascript">

$("#sortby").change(function () {
    var sort = $("#sortby").val();
    window.location = "{{url('/category')}}/{{$category->slug}}?sort="+sort;
});

$(".all_product").slice(0, 9).show();

var $group = $('.all_product');

$("#load-more").click(function() {
    
    if ($(this).hasClass('disable')) return false;

    var $hidden = $group.filter(':hidden:first').addClass('active');
    if (!$hidden.next('.all_product').length) {
        $(this).css("display", "none");
    }
});


</script>
@stop