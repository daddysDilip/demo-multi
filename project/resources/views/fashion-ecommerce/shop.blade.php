@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
  <section class="inner-page-banner bgclr-primary pd-30">
    <div class="container">
      <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{trans('app.Shop')}}</div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans('app.Home')}}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{trans('app.Shop')}}</li>
        </ol>
      </nav>
    </div>
  </section>
      
  <section class="filter-section clearfix">
    <div class="container">
      <div class="row">
        <div class="col-6 col-sm-6 col-md">
          <div class="filter1">
            <label>{{trans('app.ViewIn')}}:</label>
            <span>
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home" class="grid_view clr-secondary f-12"><i class="fas fa-th"></i></a></li>
                <li><a data-toggle="tab" href="#menu1" class="list_view clr-secondary f-12"><i class="fas fa-list-ul"></i></a></li>
              </ul>
            </span>
          </div>
        </div>
        <div class="col-6 col-sm-6 col-md">
          <div class="filter2">
            <label>{{trans('app.ShortBy')}}:</label>
            <span>
              <select id="sortby" class="custom-select custom-select-sm">
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
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="main-product-wrapper">
    <div class="container">
      <div class="row wrapper">
        <div class="col-12 col-md-4 col-lg-3">
          <div class="sidebar-filters-wrapper bgclr-white">
            <div class="main-heading pd-15 bgclr-white-off clr-primary f-14 text-capitalize">
              <span>{{trans('app.Filters')}}</span>
              <span><i class="fas fa-filter"></i></span>
            </div>
            <div class="filter-manufacturer bgclr-white-off pd-15">
              <div class="filtername f-14 text-uppercase clr-secondary">{{trans('app.AllCategories')}}</div>
              <ul>
                @foreach($menus as $menu)
                @php $submenu = App\Category::where('mainid',$menu->id)->where('role','sub')->where('status',1)->count() @endphp
                <li>
                @if($submenu > 0)
                <span href="#{{$menu->slug}}-1" aria-expanded="false" data-toggle="collapse">
                  <i class="fa fa-plus"></i><i class="fa fa-minus"></i>
                </span>
                @endif
                    <a href="{{url('/category')}}/{{$menu->slug}}">{{$menu->name}}</a>
                    <ul id="{{$menu->slug}}-1" class="collapse">
                      @foreach(\App\Category::where('mainid',$menu->id)->where('role','sub')->where('status',1)->get() as $submenu)
                        @php $childmenu = App\Category::where('subid',$submenu->id)->where('role','child')->where('status',1)->count() @endphp
                        <li>
                        @if($childmenu > 0)
                        <span href="#{{$submenu->slug}}-1" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-plus"></i><i class="fa fa-minus"></i>
                        </span>
                        @endif
                          <a href="{{url('/category')}}/{{$submenu->slug}}">{{$submenu->name}}</a>
                          <ul id="{{$submenu->slug}}-1" class="collapse">
                            @foreach(\App\Category::where('subid',$submenu->id)->where('role','child')->where('status',1)->get() as $childmenu)
                              <li>@if(app()->getLocale() == 'ar')<i class="fa fa-angle-left"></i>@else<i class="fa fa-angle-right"></i>@endif<a href="{{url('/category')}}/{{$childmenu->slug}}">{{$childmenu->name}}</a></li>
                            @endforeach
                          </ul>
                        </li>
                      @endforeach
                    </ul>
                </li>
                @endforeach
              </ul>
            </div>
            @if(count($products) > 0)
              @if($mins != $maxs)
              <div class="filter-price bgclr-white-off pd-15">
                <div class="filtername f-14 text-uppercase clr-secondary">{{trans('app.PriceRange')}}</div>
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
              @endif
            @endif

            @if($settings[0]->popular_tags)
            <div class="filter-tag bgclr-white-off pd-15">
              <div class="filtername f-14 text-uppercase clr-secondary">{{trans('app.PopularTags')}}</div>
              <ul>
                @foreach(explode(',',$settings[0]->popular_tags) as $tag)
                <li><a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a></li>
                @endforeach
              </ul>
            </div>
            @endif
            <!-- <button class="reset bgclr-primary clr-white" type="reset">Reset All</button> -->
          </div>
        </div>
        <div class="col-12 col-md-8 col-lg-9">
          <div class="tab-content">
            @if(count($products) > 0)
            <div id="home" class="tab-pane fade in active">
              <div class="row product-row">
                @forelse($products as $product)
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 all_product">
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
                        <div class="addcart_sec_{{$product->id}}">
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
                @endforeach
              </div>
            </div>
            <div id="menu1" class="tab-pane fade">
              <div class="row">
                @forelse($products as $product)
                <div class="col-12 list_view_product">
                  <div class="product-list-wrap bgclr-white pd-10">
                    <div class="img-and-text">
                      <div class="list-img-wrap">
                        @if($product->feature_image != '')
                          <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-fluid mx-auto">
                        @else
                          <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-fluid mx-auto">
                        @endif
                      </div>
                      <div class="list-text-wrap">
                        <div class="prod-name f-18 clr-secondary">{{$product->title}}</div>
                        
                        <div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                        </div>
                        @if($product->description != '')
                        {{ substr(strip_tags($product->description), 0, 100) }}
                        {{ strlen(strip_tags($product->description)) > 50 ? "..." : "" }}
                        @endif
                        
                      </div>
                    </div>
                    <div class="cart-detail-wrap">
                      <div class="or-available">

                        <span class="f-12 clr-secondary stock">{{trans('app.Availability')}} : 
                          <strong>@if($product->stock > 0) {{trans('app.InStock')}} @else {{trans('app.OutStock')}} @endif</strong>
                        </span>

                        @if($product->offer_price != "" && $product->offer_price != 0)
                        @php
                          $pricediff = (($product->price) - ($product->offer_price));        
                          $percentage = round((($pricediff/$product->price)*100));  
                        @endphp
                        <span class="tag clr-white bgclr-primary">{{$percentage}}% {{trans('app.Off')}}</span>
                        @endif
                      </div>
                      <div class="price-detail">
                        <div class="price">
                          @if($product->offer_price != "" && $product->offer_price != 0)
                            <span class="old">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span>
                            <span class=" new"><strong>{{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}}</strong></span>
                          @else
                            <span class=" new"><strong>{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</strong></span>
                          @endif
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
                          <div class="list_addcart_sec_{{$product->id}} list_addcart_sec">
                            @if($product->stock != 0 || $product->stock === null )
                              @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                <a href="{{Url('cart')}}"><button class="add-cart f-12 text-uppercase"><i class="fas fa-shopping-cart"></i> {{trans('app.GoCart')}}</button></a>
                              @else
                                <button class="add-cart f-12 text-uppercase to-cart"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader"><i class="fas fa-shopping-cart"></i> {{trans('app.AddCart')}}</button>
                              @endif
                            @else
                              <button class="add-cart f-12 text-uppercase out_stock_btn"><i class="fas fa-shopping-cart"></i> {{trans('app.OutStock')}}</button>
                            @endif
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            @else
              <h4 class="text-center" style="margin-top: 50px;">{{trans('app.NoProductsFound')}}</h4>
            @endif
          </div>
          <nav aria-label="...">
            {{ $products->links() }}
          </nav>
        </div>
      </div>
    </div>
  </section>

</main>

@stop

@section('footer')

<script type="text/javascript">

$("#sortby").change(function () {
    var sort = $("#sortby").val();
    window.location = "{{url('/category')}}/?sort="+sort;
});

</script>
@stop