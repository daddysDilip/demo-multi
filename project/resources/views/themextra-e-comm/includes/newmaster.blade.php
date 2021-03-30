<!doctype html>
<html lang="{{ app()->getLocale() }}" langdir="{{get_language_direction()}}">

  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <?php if(isset($meta)){?>

          <?php if($meta['metatitle'] != '') {  echo '<title>'.$meta['metatitle'].'</title>'; } else{ echo " <title>".$settings[0]->title."</title>";}?>
    
<?php if($meta['metadec'] != '') { ?><meta name="description" content="<?php echo $meta['metadec']; ?>" /><?php } ?>
    
<?php if($meta['metakey'] != '') { ?><meta name="keywords" content="<?php echo $meta['metakey']; ?>"/><?php } ?>
<?php }?>

    <!-- <title>{{$settings[0]->title}}</title> -->
    <link rel="icon" type="image/png" href="{{url('/')}}/assets/images/{{$settings[0]->favicon}}" />

    <!-- Required CSS -->
    <link href="{{ URL::asset('assets/themextra-e-comm/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/themextra-e-comm/css/xzoom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/themextra-e-comm/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/themextra-e-comm/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/themextra-e-comm/css/all.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/themextra-e-comm/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/themextra-e-comm/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/themextra-e-comm/css/bootstrap-slider.min.css')}}" rel="stylesheet">
    
  </head>

  <body>

    <!-- Start Header -->
    <header>

      <section id="before_header">
        <div class="container">

          <ul class="r_head">
            <li><a href="mailto:{{$companydetails[0]->company_email}}"><i class="far fa-envelope"></i>{{$companydetails[0]->company_email}}</a></li>
            <li><a href="tel:{{$companydetails[0]->company_phone}}"><i class="fas fa-phone"></i>{{$companydetails[0]->company_phone}}</a></li>
          </ul>

          <ul class="l_head">
            <li>
              <div class="search-box popup">
                <form id="searchform">
                  <div class="search-field">
                    <input type="text" id="searchdata" class="form-control" value="" placeholder="{{$language->search}}" />
                  </div>
                  <button type="button" id="searchbtn" class="btn search-button">
                    <i class="fa fa-search"></i>
                  </button>
                </form>
              </div>
              <a href="javascript:;" data-label="show" class="open-search-popup open"><i class="fas fa-search"></i></a>
            </li>
            <li><a href="{{route('user.account',$subdomain_name)}}"><i class="fas fa-user-circle"></i></a></li>
            <li class="my-cart">
              <button class="tt-dropdown-toggle" data-toggle="collapse" data-target="#cart">
                <i class="fas fa-shopping-cart"></i>
                <span class="tt-badge-cart" id="cartQty">0</span>
              </button>
              <div id="cart" class="collapse cart-box">
                <div id="emptycart">
                  {{trans('app.EmptyCart')}}
                </div>
                <div class="cart-list" id="goCart">
                  
                </div>
                <div class="cartbox-total">
                  <div class="total-title">{{trans('app.SubTotal')}}</div>
                  <div class="total-price">{{$settings[0]->currency_sign}}0.00</div>
                </div>
                <div class="cart-butnbox">
                  <div class="cart-item">
                    <a href="{{route('user.checkout',$subdomain_name)}}" class="text-center text-uppercase checkout-btn">{{trans('app.Checkout')}}</a>
                    <a href="{{url('/cart')}}" class="text-center text-uppercase cart-btn">{{trans('app.ViewCart')}}</a>
                  </div>
                </div>
              </div>
            </li>
            @if($companydetails[0]->language != '')
              @php $companylang = explode(',',$companydetails[0]->language); @endphp
              <li>
                <select class="form-control pull-right" id="languageSwitcher">
                  @foreach($alllanguage as $alllang)
                    @if(in_array($alllang->code, $companylang))
                      @if(Session::has("locale"))
                        <option value="{{$alllang->code}}" @if(Session::get("locale") == "$alllang->code") selected @endif>{{$alllang->name}}</option>
                      @else
                        <option value="{{$alllang->code}}" @if($companydetails[0]->default_language == "$alllang->code") selected @endif>{{$alllang->name}}</option>
                      @endif
                    @endif
                  @endforeach
                </select>
                {{ csrf_field() }}
              </li>
            @endif
          </ul>

        </div>

      </section>

      <nav class="navbar navbar-default">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">{{trans('app.ToggleNavigation')}}</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">
              @if($settings[0]->logo != '')
                <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" class="img-responsive" alert="LOGO">
              @else
                <img src="{!! url('assets/images/company') !!}/logo.png" class="img-responsive" alert="LOGO">
              @endif
            </a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
             @php 
				$navigation_menu = get_front_menu(); 
			@endphp
            <ul class="nav navbar-nav navbar-right">
              @foreach($navigation_menu as $navigations)
               @php 
					$submenu = count($navigations->sub); 
			   @endphp

                <li>
                  <a href="{{url('/')}}{{$navigations->url}}" <?php if($submenu > 0) { ?>class="dropdown-toggle" data-toggle="dropdown"<?php } ?>>{{$navigations->title}} <?php if($submenu > 0) { ?><span class="caret"></span><?php } ?></a>

                  @if($submenu > 0)
                  <ul class="dropdown-menu multi-level">
                    @foreach($navigations->sub as $subnav)
                    @php $childmenu = count($subnav->child); @endphp

                      <li <?php if($childmenu > 0) { ?>class="dropdown-submenu"<?php } ?>>
                        <a href="{{url('/')}}{{$subnav->url}}" <?php if($childmenu > 0) { ?>class="dropdown-toggle" data-toggle="dropdown"<?php } ?>>{{$subnav->title}}</a>

                        @if($childmenu > 0)
                        <ul class="dropdown-menu">
                          @foreach($subnav->child as $childnav)
                            <li><a href="{{url('/')}}{{$childnav->url}}">{{$childnav->title}}</a></li>
                          @endforeach
                        </ul>
                        @endif

                      </li>
                    @endforeach
                  </ul>
                  @endif

                </li>

              @endforeach
            </ul>
          </div><!-- /.navbar-collapse -->

        </div><!-- /.container-fluid -->
      </nav>
    </header>
    <!-- End Header -->
    
    @yield('content')
    <!-- Start Footer -->
    <footer>
      <!-- <section id="services">
        <div class="container border">
          <div class="row">

            <div class="col-md-3 col-sm-3 col-xs-6">
              <div class="ser_box">
                <div class="img-box">
                  <img src="{{url('/')}}/assets/themextra-e-comm/images/delivery.png" class="img-responsive">
                </div>
                <div class="ser_textbox">
                  <div class="ser_text">{{trans('app.FreeShipping')}}</div>
                  <div class="ser_des">Free ship for local customers</div>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-6">
              <div class="ser_box">
                <div class="img-box">
                  <img src="{{url('/')}}/assets/themextra-e-comm/images/time.png" class="img-responsive">
                </div>
                <div class="ser_textbox">
                  <div class="ser_text">ONLINE SUPPORT</div>
                  <div class="ser_des">Answer questions with 12 hours</div>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-6">
              <div class="ser_box">
                <div class="img-box">
                  <img src="{{url('/')}}/assets/themextra-e-comm/images/exchange.png" class="img-responsive">
                </div>
                <div class="ser_textbox">
                  <div class="ser_text">FREE EXCHANGE</div>
                  <div class="ser_des">Exchange your item in 24 hours</div>
                </div>
              </div>
            </div> 

            <div class="col-md-3 col-sm-3 col-xs-6">
              <div class="ser_box">
                <div class="img-box">
                  <img src="{{url('/')}}/assets/themextra-e-comm/images/best.png" class="img-responsive">
                </div>
                <div class="ser_textbox">
                  <div class="ser_text">SATISFACTION GUARANTEED</div>
                  <div class="ser_des">Lorem ipsum dolor sit amet</div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section> -->

      <section id="footer">
        <div class="container">

          <div class="row">
            <div class="col-md-12">
              @if($settings[0]->logo != '')
                <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" class="img-responsive footer_logo">
              @else
                <img src="{!! url('assets/images/company') !!}/logo.png" class="img-responsive footer_logo">
              @endif
              <p class="head">{{$settings[0]->about}}</p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 col-sm-4">
              <h3>{{trans('app.QuickLinks')}}</h3>
              <ul class="link">
                <li><a href="{{url('/')}}"> {{trans('app.Home')}}</a></li>
                <li><a href="{{url('/about')}}"> {{trans('app.AboutUs')}}</a></li>
                <li><a href="{{url('/faq')}}"> {{trans('app.FAQ')}}</a></li>
                <li><a href="{{url('/contact')}}"> {{trans('app.ContactUs')}}</a></li>
              </ul>
            </div>

            @if(count($lblogs) > 0)
            <div class="col-md-4 col-sm-4 latest_blog">
              <h3>{{trans('app.LatestBlogs')}}</h3>
              <ul>
                @foreach($lblogs as $lblog)
                  <li>
                    <a href="{{url('/blog')}}/{{$lblog->id}}">
                      @if($lblog->featured_image != '')
                        <img src="{{url('/assets/images/blog')}}/{{$lblog->featured_image}}" alt="">
                      @else
                        <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="">
                      @endif
                      <div class="content">
                        <p>{{$lblog->title}}</p>
                        <span>{{date('F d, Y',strtotime($lblog->created_at))}}</span>
                      </div>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
            @endif

            @if($settings[0]->popular_tags)
            <div class="col-md-4 col-sm-4">
              <h3>{{trans('app.PopularTags')}}</h3>
              <ul class="footer_tags">
                @foreach(explode(',',$settings[0]->popular_tags) as $tag)
                  <li><a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a></li>
                @endforeach
              </ul>
            </div>
            @endif
          </div>

        </div>
      </section>

      <section id="copyright">
        <div class="container">
          <div class="row"> 
            <div class="pull-left">{!! $settings[0]->footer !!}</div>
            <div class="pull-right social">
              <ul>
                @if($sociallinks[0]->f_status == "enable")
                <li><a href="{{$sociallinks[0]->facebook}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                @endif
                @if($sociallinks[0]->g_status == "enable")
                <li><a href="{{$sociallinks[0]->g_plus}}" target="_blank"><i class="fab fa-google"></i></a></li>
                @endif
                @if($sociallinks[0]->t_status == "enable")
                <li><a href="{{$sociallinks[0]->twiter}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                @endif
                @if($sociallinks[0]->link_status == "enable")
                <li><a href="{{$sociallinks[0]->linkedin}}" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </section>
    </footer>
    <!-- Start Footer -->

    <!-- Required Javascript -->
    <script>
      var mainurl = '{{url('/')}}';
      var currency = '{{$settings[0]->currency_sign}}';
      var ship_info = '{{$settings[0]->shipping_information}}';
      var tax_info = '{{$settings[0]->tax_information}}';
      var potax = '{{$settings[0]->tax}}';
      var poshipcost = '{{$settings[0]->shipping_cost}}';
      var language = {!! json_encode($language) !!};
      var Pricelang = '{{ trans("app.Price") }}';
      var Quantitylang = '{{ trans("app.Quantity") }}';
      var EmptyCartlang = '{{ trans("app.EmptyCart") }}';
      var ShippingCostlang = '{{ trans("app.ShippingCost") }}';
      var Taxlang = '{{ trans("app.Tax") }}';
      var AddCartMsglang = '{{ trans("app.AddCartMsg") }}';
      var CouponNotExist = '{{ trans("app.CouponNotExist") }}';
      var CouponMinAmount = '{{ trans("app.CouponMinAmount") }}';
      var CouponApplyOnce = '{{ trans("app.CouponMinAmount") }}';
      var ValidEmailError = '{{ trans("app.ValidEmailError") }}';
      var AlreadyExist = '{{ trans("app.AlreadyExist") }}';
      var PasswordNoMatch = '{{ trans("app.PasswordNoMatch") }}';
      var regCVVError = '{{ trans("app.regCVVError") }}';
      var regMonthError = '{{ trans("app.regMonthError") }}';
      var CurrentPassIncorrect = '{{ trans("app.CurrentPassIncorrect") }}';
      var SubscribedSuccessfully = '{{ trans("app.SubscribedSuccessfully") }}';
      var AlreadySubscribed = '{{ trans("app.AlreadySubscribed") }}';
    </script>

    <script src="{{ URL::asset('assets/themextra-e-comm/js/jquery.min.js')}}"></script>
    <script src="{{ URL::asset('assets/themextra-e-comm/js/bootstrap.min.js')}}"></script>
    <script src="{{ URL::asset('assets/themextra-e-comm/js/jquery.zoom.js')}}"></script>
    <script src="{{ URL::asset('assets/themextra-e-comm/js/main.js')}}" ></script>
    <script src="{{ URL::asset('assets/themextra-e-comm/js/owl.carousel.min.js')}}"></script>
    <script src="{{ URL::asset('assets/themextra-e-comm/js/notify.js')}}"></script>
    <script src="{{ URL::asset('assets/themextra-e-comm/js/bootstrap-slider.min.js')}}"></script>
    
    <script src="{{ URL::asset('assets/themextra-e-comm/js/jquery.validate.min.js')}}"></script>
    <script src="{{ URL::asset('assets/themextra-e-comm/js/additional-methods.min.js')}}"></script>

    @if(app()->getLocale() != 'en')
      <script src="{{ URL::asset('assets/js/localization/messages_')}}{{app()->getLocale()}}.js"></script>
    @endif
  
    @yield('footer')
  </body>
</html>