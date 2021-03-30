@extends('themextra-e-comm.includes.newmaster')

@section('content')

<main>
    
  <section id="grid">
    <div class="container">
      <div class="row">
        <div class='col-md-3 sidebar'> 
          <!-- ================================== TOP NAVIGATION ================================== -->
          <div class="side-menu animate-dropdown outer-bottom-xs">
            <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> {{trans('app.Categories')}}</div>

            <nav class="yamm megamenu-horizontal">
              <ul class="nav">

                @foreach($menus as $menu)
                @php $submenu = App\Category::where('mainid',$menu->id)->where('role','sub')->where('status',1)->count() @endphp
                <li class="dropdown menu-item"> <a href="{{url('/category')}}/{{$menu->slug}}" class="dropdown-toggle" data-toggle="dropdown"><i class="icon fa fa-shopping-bag" aria-hidden="true"></i>{{$menu->name}}</a>
                  
                  <ul class="dropdown-menu mega-menu">
                    @if($submenu > 0)
                    <li class="yamm-content">
                      <div class="row">

                        @foreach(\App\Category::where('mainid',$menu->id)->where('role','sub')->where('status',1)->get() as $submenu)
                        <div class="col-sm-12 col-md-3">
                          
                          <a class="sub_category" href="{{url('/category')}}/{{$submenu->slug}}">{{$submenu->name}}</a>

                          <ul class="links list-unstyled">
                            @foreach(\App\Category::where('subid',$submenu->id)->where('role','child')->get() as $childmenu)
                              <li><a href="{{url('/category')}}/{{$childmenu->slug}}">{{$childmenu->name}}</a></li>
                            @endforeach
                          </ul>

                        </div>
                        @endforeach

                        <!-- /.col --> 
                      </div>
                      <!-- /.row --> 
                    </li>
                    @else
                      <p style="padding: 20px;">{{trans('app.NoCategoryFound')}}</p>
                    @endif
                    <!-- /.yamm-content -->
                  </ul>
                  <!-- /.dropdown-menu --> 
                </li>
                @endforeach
                <!-- /.menu-item -->
                
              </ul>
              <!-- /.nav --> 
            </nav>
            <!-- /.megamenu-horizontal --> 
          </div>
          <!-- /.side-menu --> 
          @if(count($products) > 0)
            @if($mins != $maxs)
            <div class="side-menu outer-bottom-xs">
              <div class="head"><i class="icon fa fa-filter fa-fw"></i> {{trans('app.FilterbyPrice')}}</div>
              <div class="filter-price">
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
            @endif
          @endif

          @if($settings[0]->popular_tags)
          <div class="side-menu outer-bottom-xs">
            <div class="head"><i class="icon fa fa-tag fa-fw"></i> {{trans('app.PopularTags')}}</div>
            <div class="product-filter-content tags">
              @foreach(explode(',',$settings[0]->popular_tags) as $tag)
                  <a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a>
              @endforeach
            </div>
          </div>
          @endif
          <!-- ================================== TOP NAVIGATION : END ================================== -->
        </div>
        <div class="col-md-9">

          @if($settings[0]->background != '')
            <img src="{{url('/')}}/assets/images/{{$settings[0]->background}}" class="img-responsive banner">
          @endif

          <div class="clearfix filters-container m-t-10">

            <div class="filter-tabs col-md-6">
              <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                <li class="active"> <a data-toggle="tab" href="#grid-container"><i class="icon fa fa-th-large"></i>{{trans('app.Grid')}}</a> </li>
                <li><a data-toggle="tab" href="#list-container"><i class="icon fa fa-th-list"></i>{{trans('app.List')}}</a></li>
              </ul>
            </div>

            <div class="col-md-6">
              <div class="lbl-cnt"> <span class="lbl">{{trans('app.ShortBy')}}</span>
                <div class="fld inline">
                  <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                    
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

          </div>

          <div class="search-result-container ">
            <div id="myTabContent" class="tab-content category-list">
            @if(count($products) > 0)
              <div class="tab-pane active " id="grid-container">
                <div class="category-product">
                  <div class="row">
                    @forelse($products as $product)
                    <div class="col-sm-6 col-md-4">
                      <div class="products">
                        <div class="product">

                          <div class="product-image">
                            <div class="image"> <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">
                              @if($product->feature_image != '')
                                <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive" alt=""></a> 
                              @else
                                <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive" alt=""></a> 
                              @endif
                            </div>
                            <!-- /.image -->
                            @php 
                              $publishdate = strtotime($product->created_at);
                              $nowdate = strtotime('-24 hours')
                            @endphp

                            @if($publishdate >= $nowdate)<div class="tag new"><span>{{trans('app.New')}}</span></div>@endif
                            @if($product->offer_price != "" && $product->offer_price != 0)<span class="tag sale">{{trans('app.Sale')}}</span>@endif

                          </div>
                          <!-- /.product-image -->
                          
                          <div class="product-info text-left">
                            <h3 class="name"><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="description"></div>

                            <div class="product-price"> 
                              @if($product->offer_price != "" && $product->offer_price != 0)
                                <span class="price"> {{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}} </span> <span class="price-before-discount">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span> 
                              @else
                                <span class="price"> {{$settings[0]->currency_sign}}{{number_format($product->price,2)}} </span>
                              @endif
                            </div>

                            <!-- /.product-price --> 
                          </div>
                          <!-- /.product-info -->
                          <div class="cart clearfix">
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

                                  <div class="addcart_sec_{{$product->id}} list_addcart_sec">
                                    <li class="add-cart-button btn-group">
                                      @if($product->stock != 0 || $product->stock === null )
                                        @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                          <a href="{{Url('cart')}}" class="btn btn-primary cart-btn" type="button">{{trans('app.GoCart')}}</a>
                                        @else
                                          <button class="btn btn-primary cart-btn to-cart" type="button"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader">{{trans('app.AddCart')}}</button>
                                        @endif
                                      @else
                                        <button class="btn btn-primary cart-btn out_stock_btn" type="button">{{trans('app.OutStock')}}</button>
                                      @endif
                                    </li>
                                  </div>

                                </form>
                              </ul>
                            </div>
                            <!-- /.action --> 
                          </div>
                          <!-- /.cart --> 
                        </div>
                        <!-- /.product --> 
                        
                      </div>
                      <!-- /.products --> 
                    </div>
                    <!-- /.item -->
                    @endforeach
                  </div>
                </div>
                <!-- /.category-product -->
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane"  id="list-container">
                <div class="category-product">
                  
                  @forelse($products as $product)
                  <div class="category-product-inner wow fadeInUp">
                    <div class="products">
                      <div class="product-list product">
                        <div class="row product-list-row">
                          <div class="col col-sm-4 col-lg-4">
                            <div class="product-image">
                              <div class="image"> 
                                @if($product->feature_image != '')
                                  <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" alt="{{$product->title}}" class="img-responsive">
                                @else
                                  <img src="{{url('/assets/images')}}/placeholder.jpg" alt="{{$product->title}}" class="img-responsive">
                                @endif
                              </div>
                              <div class="tag sale"><span>{{trans('app.Sale')}}</span></div>
                            </div>
                            <!-- /.product-image --> 
                          </div>
                          <!-- /.col -->
                          <div class="col col-sm-8 col-lg-8">
                            <div class="product-info">

                              <h3 class="name"><a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a></h3>
                              <div class="rating rateit-small"></div>

                              <div class="product-price"> 
                                @if($product->offer_price != "" && $product->offer_price != 0)
                                  <span class="price"> {{$settings[0]->currency_sign}}{{number_format($product->offer_price,2)}} </span> <span class="price-before-discount">{{$settings[0]->currency_sign}}{{number_format($product->price,2)}}</span> 
                                @else
                                  <span class="price"> {{$settings[0]->currency_sign}}{{number_format($product->price,2)}} </span>
                                @endif
                              </div>
                              <!-- /.product-price -->
                              <div class="description m-t-10">
                                {{ substr(strip_tags($product->description), 0, 100) }}
                                {{ strlen(strip_tags($product->description)) > 50 ? "..." : "" }}
                              </div>

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

                                      <div class="list_addcart_sec_{{$product->id}} list_addcart_sec">
                                        <li class="add-cart-button btn-group">
                                          @if($product->stock != 0 || $product->stock === null )
                                            @if((\App\Cart::where('product',$product->id)->where('uniqueid', Session::get('uniqueid'))->count()) > 0)
                                              <a href="{{Url('cart')}}" class="btn btn-primary cart-btn" type="button">{{trans('app.GoCart')}}</a>
                                            @else
                                              <button class="btn btn-primary cart-btn to-cart" type="button"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader">{{trans('app.AddCart')}}</button>
                                            @endif
                                          @else
                                            <button class="btn btn-primary cart-btn out_stock_btn" type="button">{{trans('app.OutStock')}}</button>
                                          @endif
                                        </li>
                                      </div>

                                    </form>
                                  </ul>
                                </div>
                                <!-- /.action --> 
                              </div>
                              <!-- /.cart --> 
                              
                            </div>
                            <!-- /.product-info --> 
                          </div>
                          <!-- /.col --> 
                        </div>
                        <!-- /.product-list-row -->
                        
                      </div>
                      <!-- /.product-list --> 
                    </div>
                    <!-- /.products --> 
                  </div>
                  @endforeach
                  <!-- /.category-product-inner -->
                  
                </div>
                <!-- /.category-product --> 
              </div>
            @else
              <h4 class="text-center">{{trans('app.NoProductsFound')}}</h4>
            @endif
            </div>
            <!-- /.tab-content -->
            <div class="clearfix filters-container">
              <div class="text-right">
                <div class="pagination-container">
                  {{ $products->links() }}
                  <!-- /.list-inline --> 
                </div>
              </div>
            </div>
          <!-- /.filters-container -->
          </div>
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