@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

  <nav class="breadcrumb-wrap" aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">{{trans('app.Shop')}}</li>
      </ol>
    </div>
  </nav>

  <section class="main-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4">
          <div class="prod-sidebar">
            <div class="category">

               <div class="filter-wrap">
                <h3 class="filter">{{trans('app.Categories')}}</h3>
                <div class="panel-group" id="accordion">
                  @php $i = 1; @endphp
                  @foreach($menus as $menu)
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a href="{{url('/category')}}/{{$menu->slug}}" class="cat_menu">
                        {{$menu->name}}</a><span  data-toggle="collapse" data-parent="#accordion" href="#" data-target="#collapse{{$i}}"><i class="fa fa-plus"></i></span>
                      </h4>
                    </div>

                    <div id="collapse{{$i}}" class="panel-collapse collapse <?php echo ($i == 1) ? 'in' : ''; ?>">
                      <div class="panel-body">
                        <ul>
                          @php $j = 1; @endphp
                          @foreach(\App\Category::where('mainid',$menu->id)->where('role','sub')->get() as $submenu)
                          <li>
                            <span data-toggle="collapse" data-parent="#accordion21" data-target="#collapse{{$i}}{{$j}}"><i class="fa fa-plus"></i></span>
                            <a href="{{url('/category')}}/{{$submenu->slug}}">{{$submenu->name}}</a>
                            <div id="collapse{{$i}}{{$j}}" class="panel-collapse collapse">
                              <div class="panel-body">
                                <ul>
                                  @foreach(\App\Category::where('subid',$submenu->id)->where('role','child')->get() as $childmenu)
                                  <li>
                                    @if(app()->getLocale() == 'ar')<i class="fa fa-angle-left"></i>@else<i class="fa fa-angle-right"></i>@endif<a href="{{url('/category')}}/{{$childmenu->slug}}"> {{$childmenu->name}}</a>
                                  </li>
                                  @endforeach
                                </ul>
                              </div>
                            </div>
                          </li>
                          @php $j++; @endphp
                          @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                  @php $i++; @endphp
                  @endforeach
                </div>
              </div>
              
              @if(count($products) > 0)
                @if($mins != $maxs)
                <div class="filter-wrap filter-price">
                  <h3 class="filter">{{trans('app.Price')}}</h3>

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
              <div class="filter-wrap filter-tag">
                <h3 class="filter">{{trans('app.PopularTags')}}</h3>
                <ul>
                  @foreach(explode(',',$settings[0]->popular_tags) as $tag)
                  <li><a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a></li>
                  @endforeach
                </ul>
              </div>
              @endif

            </div>
          </div>
        </div>
        <div class="col-md-9 col-sm-8">
          <div class="main-grid-wrap">
            
            <div class="product-grid-wrap">
              <span class="prod-cat-name">{{trans('app.Shop')}}</span>
              <span class="result">
                <select id="sortby" class="form-control custom-select custom-select-sm">
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
              <hr>

              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#grid"><i class="fa fa-th"></i></a></li>
                <li><a data-toggle="tab" href="#list"><i class="fa fa-th-list"></i></a></li>
              </ul>

              <div class="tab-content">
                @if(count($products) > 0)

                <div id="grid" class="tab-pane fade in active">
                  <div class="row">
                    @forelse($products as $product)
                    <div class="col-md-4 col-sm-6">
                      <div class="product-box clearfix">
                        <div class="product-catg"><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></div>
                        
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
                            <div class="addcart_sec_{{$product->id}}">
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
                    </div>
                    @endforeach
                  </div>
                </div>

                <div id="list" class="tab-pane fade">
                  <div class="row">
                    <div class="col-md-12">
                      @forelse($products as $product)
                      <div class="prod-list-wrap clearfix">

                        <div class="img-wrap">
                          <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">
                            @if($product->feature_image != '')
                              <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive">
                            @else
                              <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive">
                            @endif
                          </a>
                        </div>

                        <div class="text-wrap">
                          <h5><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></h5>
                         
                          <div class="ratings">
                            <div class="empty-stars"></div>
                            <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                          </div>

                          <p>
                            @if($product->description != '')
                            {{ substr(strip_tags($product->description), 0, 100) }}
                            {{ strlen(strip_tags($product->description)) > 50 ? "..." : "" }}
                            @endif
                          </p>

                          @if($product->offer_price != "" && $product->offer_price != 0)
                            <span class="new-price">{{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}}</span>
                            <span class="old-price">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span>
                          @else
                            <span class="new-price">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span>
                          @endif

                          <div class="three-btn">
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
                              <div class="list_addcart_sec_{{$product->id}}">
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

                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>

                @else
                  <h4 class="text-center" style="margin-top: 50px;">{{trans('app.NoProductsFound')}}</h4>
                @endif
              </div>
            </div>
          </div>
          {{ $products->links() }}
          <!-- <ul class="pagination">
            <li class="active"><a href="#"><i class="fa fa-fast-backward"></i></a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#"><i class="fa fa-fast-forward"></i></a></li>
          </ul> -->
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
  window.location = "{{url('/shop')}}/?sort="+sort;
});

</script>
@stop