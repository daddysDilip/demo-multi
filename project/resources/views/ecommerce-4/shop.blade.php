@extends('ecommerce-4.includes.newmaster')

@section('content')

<link href="{{ URL::asset('assets/ecommerce-4/css/bootstrap-slider.min.css')}}" rel="stylesheet">

<main>
 
  <section id="sidebar" class="grid_view">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-xs-12">
          <div class="nav-side-menu">
            <div class="menu-list">

              <ul id="" class="menu-content">
                <button data-toggle="collapse" data-target="#demo1" class="collapse_menu">{{trans('app.ProductCategories')}}</button>
                <div id="demo1" class="collapse">
                  <ul class="parent_cat">
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
                          <li class="sub_category">
                          <span href="#{{$submenu->slug}}-1" aria-expanded="false" data-toggle="collapse">
                          @if($childmenu > 0)<i class="fa fa-plus"></i><i class="fa fa-minus"></i>@endif
                          </span>
                            <a href="{{url('/category')}}/{{$submenu->slug}}">{{$submenu->name}}</a>
                            <ul id="{{$submenu->slug}}-1" class="collapse">
                              @foreach(\App\Category::where('subid',$submenu->id)->where('role','child')->where('status',1)->get() as $childmenu)
                                <li class="child_category"> <a href="{{url('/category')}}/{{$childmenu->slug}}">{{$childmenu->name}}</a></li>
                              @endforeach
                            </ul>
                          </li>
                        @endforeach
                      </ul>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </ul>

              @if(count($products) > 0)
                @if($mins != $maxs)
                <ul id="" class="menu-content">
                  <li>
                    <button data-toggle="collapse" data-target="#demo" class="collapse_menu">{{trans('app.FilterbyPrice')}}</button>
                    <div id="demo" class="collapse">
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
                  </li>
                </ul>
                @endif
              @endif

              @if($settings[0]->popular_tags)
              <ul id="" class="menu-content">
                <li>
                  <button data-toggle="collapse" data-target="#demo3" class="collapse_menu">{{trans('app.PopularTags')}}</button>
                  <div id="demo3" class="collapse">
                    <ul class="filter-tag">
                      @foreach(explode(',',$settings[0]->popular_tags) as $tag)
                      <li><a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a></li>
                      @endforeach
                    </ul>
                  </div>
                </li>
              </ul>
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-9 col-xs-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="product_filter">
                <ul class="nav nav-pills">
                  <li class="nav-item active">
                    <a class="nav-link active" data-toggle="tab" href="#home"><i class="fas fa-th"></i></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1"><i class="fas fa-list-ul"></i></a>
                  </li>
                </ul>
                <form class="form-inline">
                  <span class="counting">{{trans('app.ShortBy')}}:</span>
                  <div class="form-group">
                    <!-- <label for="exampleFormControlSelect1">Example select</label> -->
                    <select class="form-control" id="exampleFormControlSelect1">
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
                </form>
              </div>
            </div>
          </div>

          <div class="tab-content">
            @if(count($products) > 0)
            <div class="tab-pane active" id="home">
              <div class="row">
                @forelse($products as $product)
                <div class="col-sm-4">
                  <div class="product_box">
                    @if($product->feature_image != '')
                      <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive orig product_img">
                      <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive on_hover product_img">
                    @else
                      <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive orig product_img">
                      <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive on_hover product_img">
                    @endif

                    @php 
                      $publishdate = strtotime($product->created_at);
                      $nowdate = strtotime('-24 hours');
                    @endphp
                    
                    @if($publishdate >= $nowdate)<div class="tag new"><span>{{trans('app.New')}}</span></div>@endif 

                    @if($product->offer_price != "" && $product->offer_price != 0)<div class="tag sale"><span>{{trans('app.Sale')}}</span></div>@endif  

                    <div class="product_button">
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
                              <span class="cart"><a href="{{Url('cart')}}"><i class="fas fa-shopping-cart"></i> {{trans('app.GoCart')}}</a></span>
                            @else
                              <span class="cart to-cart"><a href="javascript:;"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader"><i class="fas fa-shopping-cart"></i> {{trans('app.AddCart')}}</a></span>
                            @endif
                          @else
                            <span class="cart"><a href="javascript:;" class="out_stock_btn"><i class="fas fa-shopping-cart"></i> {{trans('app.OutStock')}}</a></span>
                          @endif
                        </div>
                      </form>
                      
                    </div>
                  </div>
                  <div class="product_price">
                    <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a>
                    <div class="ratings">
                      <div class="empty-stars"></div>
                      <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                    </div>
                    <div class="price_sec">
                      @if($product->offer_price != "" && $product->offer_price != 0)
                        <span class="price">{{$settings[0]->currency_sign}}{{$product->offer_price}}</span>
                        <span class="price-before-discount">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                      @else
                        <span class="price">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                      @endif 
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <div class="tab-pane fade" id="menu1">
              @forelse($products as $product)
              <div class="row grid_view">
                <div class="col-sm-4">
                  <div class="product_box">
                    @if($product->feature_image != '')
                      <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive orig product_img">
                      <img src="{{url('/assets/images/products')}}/{{$product->feature_image}}" class="img-responsive on_hover product_img">
                    @else
                      <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive orig product_img">
                      <img src="{{url('/assets/images')}}/placeholder.jpg" class="img-responsive on_hover product_img">
                    @endif

                    @php 
                      $publishdate = strtotime($product->created_at);
                      $nowdate = strtotime('-24 hours');
                    @endphp
                    @if($publishdate >= $nowdate)<div class="tag new"><span>new</span></div>@endif 
                    @if($product->offer_price != "" && $product->offer_price != 0)<div class="tag sale"><span>Sale</span></div>@endif  
                  </div>
                </div>
                <div class="col-sm-8">
                  <div class="product_desc">
                    <div class="product_price">

                      <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a>
                      <p>
                      <div class="ratings">
                        <div class="empty-stars"></div>
                        <div class="full-stars" style="width:{{\App\Review::ratings($product->id)}}%"></div>
                      </div>
                      <div class="price_sec"> 
                        @if($product->offer_price != "" && $product->offer_price != 0)
                          <span class="price">{{$settings[0]->currency_sign}}{{$product->offer_price}}</span>
                          <span class="price-before-discount">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                        @else
                          <span class="price">{{$settings[0]->currency_sign}}{{$product->price}}</span>
                        @endif 
                      </div>
                      </p>

                      @if($product->description != '')
                        <p class="desc">
                        {!! html_entity_decode(str_limit($product->description, 100)) !!}
                        </p>
                      @endif

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
                                <a href="{{Url('cart')}}"><button class="add add-cart f-12 text-uppercase"><i class="fas fa-shopping-cart"></i> {{trans('app.GoCart')}}</button></a>
                              @else
                                <a href="javascript:void(0);" class="add add-cart f-12 text-uppercase to-cart"><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader"><i class="fas fa-shopping-cart"></i> {{trans('app.AddCart')}}</a>
                              @endif
                            @else
                              <button class="add add-cart f-12 text-uppercase out_stock_btn"><i class="fas fa-shopping-cart"></i> {{trans('app.OutStock')}}</button>
                            @endif
                          </div>
                        </form>
                      
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @else
              <h4 class="text-center">{{trans('app.NoProductsFound')}}</h4>
            @endif
            
            <div class="row">
              {{ $products->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

@stop

@section('footer')

<script type="text/javascript">

$("#exampleFormControlSelect1").change(function () {
    var sort = $("#exampleFormControlSelect1").val();
    window.location = "{{url('/shop')}}/?sort="+sort;
});

</script>
@stop