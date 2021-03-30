@extends('ecommerce-3.includes.newmaster')

@section('content')

@php $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2); @endphp
<main>
    <ol class="carousel-indicators">
        @php $i = 0; @endphp
        
        @if(count($sliders) > 1)
          @foreach($sliders as $allslider)
            <li data-target="#myCarousel" data-slide-to="{{$i}}" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
          @php $i++; @endphp
          @endforeach
        @endif
      </ol>

      <section id="banner">
        <div class="container-fluid">

          <div class="row">
            <div class="col-sm-12">
              <div class="banner_content">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                       @php $i = 0; @endphp
        @foreach($sliders as $allslider)
                  
                         <div class="item  <?php echo ($i == 0) ? 'active' : ''; ?>" style="background-image: url({{('/assets/images/sliders')}}/{{$allslider->image}});">

                       <img src="{{url('/')}}/assets/images/sliders/{{$allslider->image}}" class="img-responsive">
                      <h2>{{$allslider->title}}</h2>
                      <h1>{!! htmlspecialchars_decode($allslider->text) !!}</h1>
                      <!-- <a href="#" class="shop">shop now</a> -->
                    </div>
                       @php $i++; @endphp
        @endforeach  

              
                   @if(count($sliders) > 1)
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                  </a>
                    @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


      

               @if($pagesettings[0]->latestpro_status)
      <section class="clearfix" id="collection">
        <div class="container-fluid">
            <div class="container">
          <div class="row">
            <br/><h2>{{$language->latest_products}}</h2><hr/>
            
          </div>
          @endif
        </div>

          <div class="row">
              @if(count($latests) > 0)


                          @foreach($latests as $product)
              <div class="col-md-4 col-lg-2 col-xs-6" id="latest_product">
            @php 
              $publishdate = strtotime($product->created_at);
              $nowdate = strtotime('-24 hours')
            @endphp
              <div class="collection_box">
                   @if($product->feature_image != '')

       
    <div class="img_box " style="background-image: url({{('/assets/images/products')}}/{{$product->feature_image}})"></div>

    

  

 @else
    <div class="img_box" style="background-image: url({{('/assets/images/products')}}/placeholder.jpg)"></div>
      
      

 @endif

 
      <a href="{{url('/product')}}/{{$product->id}}/{{str_replace(' ','-',strtolower($product->title))}}">{{$product->title}}</a>

          @if($publishdate >= $nowdate)<div class="tag new"><span>new</span></div>@endif 
                    @if($product->offer_price != "" && $product->offer_price != 0)<div class="tag sale"><span>Sale</span></div>@endif      
              </div>

             </div>
             


                @endforeach
                    @endif       

                      </div>
        </div>
      </section>

========================================================
             

 @if($pagesettings[0]->category_status)

     <section  id="feat_prod">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <h2 class="heading">{{$language->top_category}}</h2>
            <!--   <p class="heading">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br>incididunt ut labore et dolore magna aliqua.</p> -->
            </div>
          </div>

            <div class="owl-carousel" id="yoga-slider">
            @if(count($fcategories) > 0)
                @if($fcategory->feature_image != '')
              <div class="img_feat_box" style="background-image: url({{('/assets/images/categories')}}/{{$fcategory->feature_image}})">

             
             
                <div class="off">ddd50% Off</div>
            
                <div class="feat_name">
                  <a href="#">{{$fcategory->name}}</a>
                </div>
              </div>
                     @else
                <img src="{{url('/assets')}}/images/placeholder.jpg" class="img-responsive">
              @endif
                @endif
            </div>


          <!-- ======= -->
        </div>
        </section>
      
============================================



    <section id="banner_3">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h2>{{$language->top_category}}</h2>
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
          <p style="margin-bottom: 0px;">No data found.</p>
        @endif
      </div>
    </section>
    @endif
====================XXXXXXXXXXXXXXXXXXXXXX=====================










 
     @if($pagesettings[0]->featuredpro_status)
    <div class="container">
      <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
        <div class="more-info-tab clearfix ">
          <h3 class="new-product-title pull-left">{{$language->featured_products}}</h3>
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
                                <a href="{{Url('cart')}}" data-toggle="tooltip" class="btn btn-primary icon" type="button" title="Go To Cart"><i class="fa fa-shopping-cart"></i> Go To Cart</a>
                                @else
                                <button data-toggle="tooltip" class="to-cart btn btn-primary icon" type="button" title="{{$language->add_to_cart}}"><i class="fa fa-shopping-cart"></i><img src="{{url('/assets/images')}}/default.gif" class="to_cart_loader"> {{$language->add_to_cart}}</button>
                                @endif
                              @else
                                <button data-toggle="tooltip" class="btn btn-primary icon out_stock_btn" type="button" title="{{$language->out_of_stock}}"><i class="fa fa-shopping-cart"></i> {{$language->out_of_stock}}</button>
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
          <p style="margin-bottom: 0px;">No data found.</p>
          @endif
        </div>
      </div>
    </div>
    @endif






      <section id="offer_banner" class="clearfix">
        <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <div class="offer_box" style="background-image:url({{asset('assets/ecommerce-3/images/offer_1.jpg')}})">
                <div class="offer_text">
                  <h3>GET AN EXTRA<br> 20% OFF<br> FIRST ORDER</h3>
                  <a href="#">Read more...</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="offer_box" style="background-image: url({{asset('assets/ecommerce-3/images/offer_2.jpg')}})">
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
                <div class="img_box" style="background-image:url({{asset('assets/ecommerce-3/images/just-1.jpg')}})"></div>
              </div>
          </div>
          <div class="row right_img">
              <div class="col-sm-8">
                <div class="img_box" style="background-image:url({{asset('assets/ecommerce-3/images/just-2.jpg')}})"></div>
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
                <div class="img_box" style="background-image: url({{asset('assets/ecommerce-3/images/just-1.jpg')}})"></div>
              </div>
          </div>
        </div>
      </section>


      <section class="clearfix" id="feat_prod">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <h2 class="heading">Featured Products</h2>
              <p class="heading">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br>incididunt ut labore et dolore magna aliqua.</p>
            </div>
          </div>
          <div class="owl-carousel" id="yoga-slider">
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_1.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Lorem Ipsum</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_2.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Consectetur adipiscing</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image:url({{asset('assets/ecommerce-3/images/feat_3.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Lorem Ipsum</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_4.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Consectetur adipiscing</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_1.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Lorem Ipsum</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_2.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Consectetur adipiscing</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_3.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Lorem Ipsum</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_4.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Consectetur adipiscing</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_1.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Lorem Ipsum</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_2.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Consectetur adipiscing</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_3.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Lorem Ipsum</a>
                </div>
              </div>
              <div class="img_feat_box" style="background-image: url({{asset('assets/ecommerce-3/images/feat_4.jpg')}})">
                <div class="off">50% Off</div>
                <div class="feat_name">
                  <a href="#">Consectetur adipiscing</a>
                </div>
              </div>
          </div>
        </div>
      </section>
    </main>



  
@endsection
