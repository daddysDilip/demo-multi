<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" langdir="{{get_language_direction()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
      <?php if(isset($meta)){?>

          <?php if($meta['metatitle'] != '') {  echo '<title>'.$meta['metatitle'].'</title>'; } else{ echo " <title>".$settings[0]->title."</title>";}?>
    
<?php if($meta['metadec'] != '') { ?><meta name="description" content="<?php echo $meta['metadec']; ?>" /><?php } ?>
    
<?php if($meta['metakey'] != '') { ?><meta name="keywords" content="<?php echo $meta['metakey']; ?>"/><?php } ?>
<?php }?>
    <!-- <meta name="keywords" content="{{$code[0]->meta_keys}}"> -->
    <meta name="author" content="GeniusOcean">
    <link rel="icon" type="image/png" href="{{url('/')}}/assets/images/{{$settings[0]->favicon}}" />
    <!-- <title>{{$settings[0]->title}}</title> -->

    <link href="{{ URL::asset('assets/fusion-fashion/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fusion-fashion/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fusion-fashion/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fusion-fashion/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fusion-fashion/css/theme-option.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fusion-fashion/css/color-1.css') }}" rel="stylesheet" title="color-1">
    <link href="{{ URL::asset('assets/fusion-fashion/css/color-2.css') }}" rel="alternate stylesheet" title="color-2">
    <link href="{{ URL::asset('assets/fusion-fashion/css/color-3.css') }}" rel="alternate stylesheet" title="color-3">
    <link href="{{ URL::asset('assets/fusion-fashion/css/color-4.css') }}" rel="alternate stylesheet" title="color-4">
    <link href="{{ URL::asset('assets/fusion-fashion/css/style5.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fusion-fashion/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fusion-fashion/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fusion-fashion/css/bootstrap-slider.min.css')}}" rel="stylesheet">

    <script src="{{ URL::asset('assets/fusion-fashion/js/jquery.min.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')}}"></script>
    <![endif]-->

</head>
<body>
  <!-- <div class="preloader">
    <div id="loader"></div>
  </div> -->

  <header>

    <section class="before-header">
      <div class="container">
        <div class="row">

          <div class="col-sm-6">
            <div class="email-deal">
              <span><i class="fa fa-envelope"></i>{{trans('app.Email')}} : <a href="mailto:{{$companydetails[0]->company_email}}">{{$companydetails[0]->company_email}}</a></span>
              <span><i class="fa fa-phone"></i> <a href="tel:{{$companydetails[0]->company_phone}}">{{$companydetails[0]->company_phone}}</a></span>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="login-lang">
              <span class="regis-login">
                @if(Auth::guard('profile')->guest())
                  <a href="{{url('user/login')}}"><i class="fa fa-user-o"></i>{{trans('app.SignIn')}}</a>
                @else
                  <a href="{{route('user.account',$subdomain_name)}}"><i class="fa fa-user-o"></i>{{ trans('app.MyAccount') }}</a>
                @endif
              </span>
              @if($companydetails[0]->language != '')
                @php $companylang = explode(',',$companydetails[0]->language); @endphp
                <select class="" id="languageSwitcher">
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
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Sidebar Holder -->
    <nav id="sidebar" class="sid_br">
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
    </nav>

    <nav class="navbar navbar-default main-nav">
      <div class="container">

        <div class="col-sm-3">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" id="sidebarCollapse" class="navbar-btn">
              <span></span>
              <span></span>
              <span></span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fas fa-align-justify"></i>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">
              @if($settings[0]->logo != '')
                <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" class="img-responsive" alt="" class="img-responsive" alt="LOGO">
              @else
                <img src="{!! url('assets/images/company') !!}/logo.png" class="img-responsive" alt="LOGO">
              @endif
            </a>
          </div>
        </div>

        <div class="col-sm-6">
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
			 @php 
				$navigation_menu = get_front_menu(); 
			@endphp
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
        </div>

        <div class="col-sm-3">
          <!-- <div class="wishlst-cart"> -->
          <span class="my-cart">
            <button class="tt-dropdown-toggle" data-toggle="collapse" data-target="#cart">
              <i class="fas fa-shopping-bag"></i>
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
                  <a href="{{route('user.checkout',$subdomain_name)}}" class="text-center text-uppercase cart-checkout">{{trans('app.Checkout')}}</a>
                  <a href="{{url('/cart')}}" class="text-center text-uppercase view-cart">{{trans('app.ViewCart')}}</a>
                </div>
              </div>
            </div>
          </span>
        <!-- </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </nav>

    <section class="after-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <div class="shop-by-catgwrap">
              <div class="vertical-menu">
                <div class="title-box">
                  <i class="fa fa-bars"></i>
                  <span>{{ trans('app.Categories') }}</span>
                  <i class="fa fa-angle-down"></i>
                </div>

                <div id="verticalmenu" class="verticalmenu">
                  <div class="navbar">
				   @php 
					$navigation_cat_menu = get_cat_front_menu(); 
				    @endphp
                    <ul class="nav navbar-nav nav-verticalmenu">
                      @foreach($navigation_cat_menu as $menu)
                      

                        <li <?php if($subcat != 0){ ?> class="parent dropdown" <?php } ?>>
                          <a href="{{url('/category')}}/{{$menu->slug}}">
                            @if($menu->feature_image != '')<img src="{{url('/assets')}}/images/categories/{{$menu->feature_image}}" class="img-responsive"> @else <img src="{{url('/')}}/assets/images/placeholder.jpg" class="img-responsive"> @endif {{$menu->name}}
                          </a>

                          @if(count($menu->sub) >0)
                          @if(app()->getLocale() == 'ar')<i class="fa fa-angle-left"></i>@else<i class="fa fa-angle-right"></i>@endif
                          <div class="dropdown-sub dropdown-menu sub-apmegamenu-1" >
                            <div class="dropdown-menu-inner right_bottom">
                              @if(count($menu->sub) >0)
                                <div class="row">
                                  @foreach($menu->sub as $submenu)
                                  <div class="col-md-6 col-sm-6 col-lg-4">
                                    <h4><a href="{{url('/category')}}/{{$submenu->slug}}">{{$submenu->name}}</a></h4>
									 @if(count($submenu->child) >0)
                                    <ul>
                                      @foreach($submenu->child as $childmenu)
                                      <li><a href="{{url('/category')}}/{{$childmenu->slug}}">{{$childmenu->name}}</a></li>
                                      @endforeach
                                    </ul>
									 @endif
                                  </div>
                                  @endforeach
                                </div>
                                @endif
                            </div>
                          </div>
                          @endif

                      </li>

                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8 col-sm-8">
            <div class="row">
              <div class="col-sm-5">
                <div class="customer-care">
                  <span>
                    <img src="{{url('/assets')}}/fusion-fashion/images/cust-care.png" class="img-responsive">
                  </span>
                  <span>
                    <h5>{{trans('app.CallCustomerServices')}} :</h5>
                    <h5><strong><a href="tel:{{$companydetails[0]->company_phone}}">{{$companydetails[0]->company_phone}}</a></strong></h5>
                  </span>
                </div>
              </div>
              <div class="col-sm-7">
                <div class="search-wrap">
                  <form id="searchform">
                    <input type="search" name="search" id="searchdata" placeholder="{{trans('app.Search')}}">
                    <span class="search-btn" id="searchbtn"><i class="fa fa-search"></i></span>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </header>

  <main>
    @yield('content')
    <div class="side-panel">
      <div class="colors">
        <h6>{{ trans('app.ColorSchemes') }}</h6>
        <a onclick="setActiveStyleSheet('color-1'); return false;" class="color-1"></a>
        <a onclick="setActiveStyleSheet('color-2'); return false;" class="color-2"></a>
        <a onclick="setActiveStyleSheet('color-3'); return false;" class="color-3"></a>
        <a onclick="setActiveStyleSheet('color-4'); return false;" class="color-4"></a>
      </div>
    </div>
  </main>

  <footer>
    <section class="newsletter clearfix">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="newsletter-text">
              <span>
                <i class="fa fa-envelope-open-o"></i>
              </span>
              <span>
                <h4>{{trans('app.SignUpForNewsletter')}}</h4>
              </span>
            </div>
          </div>
          <div class="col-md-5">
            <div class="search-wrap">
              <form id="subform" action="{{action('FrontEndController@subscribe',$subdomain_name)}}" method="post" class="col-12 col-sm-12 col-md">
              {{csrf_field()}}
                <input type="email" id="email" name="email" placeholder="{{trans('app.EnterEmail')}}">
                <button class="search-btn">{{trans('app.Subscribe')}}</button>
                <div class="input-group search-grp f-14 ml-auto">
                  <div id="resp" class="text-danger" style="text-align: left; text-transform: initial;"></div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-3">
            <div class="social-icons">
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
      </div>
    </section>

    <section class="final-footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <div class="widget-ft">
              <h3>{{trans('app.AboutUs')}}</h3>
              <p>{{$settings[0]->about}}</p>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="widget-ft">
              <h3>{{trans('app.QuickLinks')}}</h3>
              <ul>
                <li><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
                <li><a href="{{url('/about')}}">{{trans('app.AboutUs')}}</a></li>
                <li><a href="{{url('/faq')}}">{{trans('app.FAQ')}}</a></li>
                <li><a href="{{url('/contact')}}">{{trans('app.ContactUs')}}</a></li>
              </ul>
            </div>
          </div>

          @if(count($lblogs) > 0)
          <div class="col-sm-3 latest_blog">
            <div class="widget-ft">
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
                        <span>{{$lblog->title}}</span>
                      </a>
                    </li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif

          @if($settings[0]->popular_tags)
          <div class="col-sm-3">
            <div class="get-touch">
              <h3>{{trans('app.PopularTags')}}</h3>
              <ul class="footer_tags">
                @foreach(explode(',',$settings[0]->popular_tags) as $tag)
                  <li><a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a></li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif

        </div>
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <p class="text-center">{!! $settings[0]->footer !!}</p>
          </div>
        </div>
      </div>
    </section>
  </footer>

</div>

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


<script src="{{ URL::asset('assets/fusion-fashion/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/fusion-fashion/js/custom.js') }}"></script>
<script src="{{ URL::asset('assets/fusion-fashion/js/main.js') }}"></script>
<script src="{{ URL::asset('assets/fusion-fashion/js/owl.carousel.min.js') }}"></script>
<script src="{{ URL::asset('assets/fusion-fashion/js/styleswitcher.js') }}"></script>
<script src="{{ URL::asset('assets/fusion-fashion/js/notify.js') }}"></script>
<script src="{{ URL::asset('assets/ecommerce-4/js/jquery.zoom.js')}}"></script>
<script src="{{ URL::asset('assets/fusion-fashion/js/bootstrap-slider.min.js')}}"></script>
<!-- Validation -->
<script src="{{ URL::asset('assets/fusion-fashion/js/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('assets/fusion-fashion/js/additional-methods.min.js') }}"></script>

@if(app()->getLocale() != 'en')
  <script src="{{ URL::asset('assets/js/localization/messages_')}}{{app()->getLocale()}}.js"></script>
@endif

<script type="text/javascript">
  $(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
      $(this).toggleClass('active');
    });
  });

  $(document).ready(function(){

      $.validator.addMethod('Validemail', function (value, element) {
          return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
      }, ValidEmailError);

      $('#subform').validate({
          rules:{
              email:{
                  required:true,
                  Validemail:true,
                  minlength: 3,
                  maxlength: 50,
              },
          },
          submitHandler: function(form) {
              $.ajax({
                  type: "post",
                  url: "{{ URL('subscribe') }}",
                  data: $(form).serialize(),
                  dataType: 'JSON',
                  success:function(data){
                    if(data == 'success')
                    {  
                      $("#subform")[0].reset();
                      $("#resp").html('<span style=\"color:#00C708;\">'+SubscribedSuccessfully+'</span>').show().fadeOut(5000);
                    }
                    else if(data == 'fail')
                    {
                      $("#subform")[0].reset();
                      $("#resp").html('<span style="color:#F90600;">'+AlreadySubscribed+'</span>').show().fadeOut(5000);
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
          errorClass: 'text-danger',
      });

  });

</script>

@yield('footer')
</body>
</html>