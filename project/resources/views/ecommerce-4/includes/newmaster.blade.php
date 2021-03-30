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
    <!-- <link href="css/fonts" rel="stylesheet"> -->

    <!-- Bootstrap CSS -->
    <link href="{{ URL::asset('assets/ecommerce-4/css/slider.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-4/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-4/css/xzoom.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-4/css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-4/css/owl.transitions.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-4/css/style.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-4/css/responsive.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-4/css/animation.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-4/css/fontawesome.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-4/css/fonts.css')}}" rel="stylesheet">
    <!-- <link href="{{ URL::asset('assets/ecommerce-4/css/jquery.exzoom.css')}}" rel="stylesheet"> -->
    
  </head>
  <body>
    
  <header id="header" class="header-style-1">
    <section id="before_header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6 col-xs-12 col-md-4">
            <div class="search_box">
              <input type="text" id="searchdata" name="search" placeholder="{{ trans('app.Search') }}">
              <div class="right">
                <button type="button" id="searchbtn" class="search-button"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </div>
          <div class="col-sm-3 col-xs-6 col-md-4">
            <div class="logo">
              <a href="{{url('/')}}">
                @if($settings[0]->logo != '')
                  <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" class="img-responsive">
                @else
                  <img src="{!! url('assets/images/company') !!}/logo.png" class="img-responsive">
                @endif
              </a>
            </div>
          </div>
          <div class="col-sm-3 col-xs-6 col-md-4">
            <div class="login">

              @if($companydetails[0]->language != '')
                @php $companylang = explode(',',$companydetails[0]->language); @endphp
                <select id="languageSwitcher">
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
              @endif
              
              <a class="my_account" href="{{route('user.account',$subdomain_name)}}"><i class="fas fa-user-plus"></i></a>

              <span class="my-cart">
                <button class="tt-dropdown-toggle" data-toggle="collapse" data-target="#cart">
                  <i class="fas fa-cart-arrow-down"></i>
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
              </span>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ============================================== NAVBAR ============================================== -->
    <div class="header-nav animate-dropdown affix-top" data-spy="affix" data-offset-top="197">
      <div class="container">
        <div class="yamm navbar navbar-default" role="navigation">
          <div class="navbar-header">
         <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> 
         <span class="sr-only">{{trans('app.ToggleNavigation')}}</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          </div>
          <div class="nav-bg-class">
            <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
              <div class="nav-outer">
				@php 
				  $navigation_menu = get_front_menu(); 
				 @endphp
                <ul class="nav navbar-nav">
                  @foreach($navigation_menu as $navigations)
                  @php 
                    $submenu = count($navigations->sub);
                  @endphp
                  <li class="dropdown yamm mega-menu"> <a href="{{url('/')}}{{$navigations->url}}" <?php if($submenu > 0) { ?>data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown"<?php } ?>>{{$navigations->title}}</a>

                    @if($submenu > 0)
                    <ul class="dropdown-menu container">
                      <li>
                        <div class="yamm-content ">
                          <div class="row">
                            @foreach($navigations->sub as $subnav)
                            @php $childmenu = count($subnav->child); @endphp
                              <div class="col-xs-12 col-sm-3 col-md-2 col-menu">
                                <h2 class="title"><a href="{{url('/')}}{{$subnav->url}}">{{$subnav->title}}</a></h2>
                                <hr>
                                @if($childmenu > 0)
                                <ul class="links">
                                  @foreach($subnav->child as $childnav)
                                  <li><a href="{{url('/')}}{{$childnav->url}}">{{$childnav->title}}</a></li>
                                  @endforeach
                                </ul>
                                @endif
                              </div>
                            @endforeach
                            <!-- /.col -->
                            <!-- /.yamm-content --> 
                          </div>
                        </div>
                      </li>
                    </ul>
                    @endif

                  </li>
                  @endforeach
                </ul>
                <!-- /.navbar-nav -->
                <div class="clearfix"></div>
              </div>
              <!-- /.nav-outer --> 
            </div>
            <!-- /.navbar-collapse --> 
            
          </div>
          <!-- /.nav-bg-class --> 
        </div>
        <!-- /.navbar-default --> 
      </div>
      <!-- /.container-class --> 
    </div>
    <!-- /.header-nav --> 
    <!-- ============================================== NAVBAR : END ============================================== --> 
  </header>
    
  @yield('content')
    
  <footer>
    <section id="links">
      <div class="container">

        <div class="col-md-4 col-sm-6">
          @if($settings[0]->logo != '')
            <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" alert="LOGO" class="img-responsive logo">
          @else
            <img class="logo" src="{!! url('assets/images/company') !!}/logo.png" alert="LOGO" class="img-responsive logo">
          @endif
          <p>{{$settings[0]->about}}</p>
        </div>

        <div class="col-md-3 col-sm-6">
          <h3>{{trans('app.QuickLinks')}}</h3>
          <ul class="contact">
            <li><a href="{{url('/')}}">@if(app()->getLocale() == 'ar')<i class="fa fa-caret-left"></i>@else<i class="fa fa-caret-right"></i>@endif {{trans('app.Home')}}</a></li>

            <li><a href="{{url('/about')}}">@if(app()->getLocale() == 'ar')<i class="fa fa-caret-left"></i>@else<i class="fa fa-caret-right"></i>@endif {{trans('app.AboutUs')}}</a></li>

            <li><a href="{{url('/faq')}}">@if(app()->getLocale() == 'ar')<i class="fa fa-caret-left"></i>@else<i class="fa fa-caret-right"></i>@endif {{trans('app.FAQ')}}</a></li>

            <li><a href="{{url('/contact')}}">@if(app()->getLocale() == 'ar')<i class="fa fa-caret-left"></i>@else<i class="fa fa-caret-right"></i>@endif {{trans('app.ContactUs')}}</a></li>
          </ul>
        </div>

        @if(count($lblogs) > 0)
        <div class="col-md-2 col-sm-6">
          <h3>{{trans('app.LatestBlogs')}}</h3>
          <ul class="profile latest_blog">
            @foreach($lblogs as $lblog)
            <li>
              <a href="{{url('/blog')}}/{{$lblog->id}}">
                @if($lblog->featured_image != '')
                    <img src="{{url('/assets/images/blog')}}/{{$lblog->featured_image}}" alt="">
                @else
                    <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="">
                @endif
                <span>{{$lblog->title}}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </div>
        @endif

        @if($settings[0]->popular_tags)
        <div class="col-md-3 col-sm-6">
          <h3>{{trans('app.PopularTags')}}</h3>
          <div class="footer-content tags">
            @foreach(explode(',',$settings[0]->popular_tags) as $tag)
              <a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a>
            @endforeach
          </div> 
        </div>
        @endif
      </div>
    </section>

    <section id="copyright">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <p>{!! $settings[0]->footer !!}</p>
          </div>
          <div class="col-sm-12">
            <div class="footer-social-links">
              <ul>
                @if($sociallinks[0]->f_status == "enable")
                <li>
                  <a class="facebook" href="{{$sociallinks[0]->facebook}}" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                </li>
                @endif
                @if($sociallinks[0]->g_status == "enable")
                <li>
                  <a class="google" href="{{$sociallinks[0]->g_plus}}" target="_blank">
                    <i class="fab fa-google"></i>
                  </a>
                </li>
                @endif
                @if($sociallinks[0]->t_status == "enable")
                <li>
                  <a class="twitter" href="{{$sociallinks[0]->twiter}}" target="_blank">
                    <i class="fab fa-twitter"></i>
                  </a>
                </li>
                @endif
                @if($sociallinks[0]->link_status == "enable")
                <li>
                  <a class="tumblr" href="{{$sociallinks[0]->linkedin}}" target="_blank">
                    <i class="fab fa-linkedin"></i>
                  </a>
                </li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </footer>

  <!-- JavaScript -->
 
  <script>
    var mainurl = '{{url('/')}}';
    var currency = '{{$settings[0]->currency_sign}}';
    var ship_info = '{{$settings[0]->shipping_information}}';
    var tax_info = '{{$settings[0]->tax_information}}';
    var potax = '{{$settings[0]->tax}}';
    var poshipcost = '{{$settings[0]->shipping_cost}}';
    var language = {!! json_encode($language) !!};
    var Pricelang = '{{ trans("app.Price") }}';
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

  <script src="{{ URL::asset('assets/ecommerce-4/js/jquery.min.js')}}"></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/bootstrap.min.js')}}"></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/jquery.zoom.js')}}"></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/bootstrap-slider.min.js')}}"></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/owl.carousel.min.js')}}"></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/main.js')}}" ></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/custom.js')}}" ></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/slick.js')}}" ></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/bootstrap-hover-dropdown.min.js')}}" ></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/wow.min.js')}}" ></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/notify.js')}}"></script>
  
  <script src="{{ URL::asset('assets/ecommerce-4/js/jquery.validate.min.js')}}"></script>
  <script src="{{ URL::asset('assets/ecommerce-4/js/additional-methods.min.js')}}"></script> 

  @if(app()->getLocale() != 'en')
    <script src="{{ URL::asset('assets/js/localization/messages_')}}{{app()->getLocale()}}.js"></script>
  @endif
  
  @yield('footer')

  </body>
</html>