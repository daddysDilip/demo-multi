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
    <link href="{{ URL::asset('assets/fashion-ecommerce/css/fonts.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fashion-ecommerce/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{ URL::asset('assets/fashion-ecommerce/css/style.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fashion-ecommerce/css/responsive.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fashion-ecommerce/css/all.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fashion-ecommerce/css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fashion-ecommerce/css/bootstrap-slider.min.css')}}" rel="stylesheet">
    
    <style type="text/css">
      #owl-demo .item img{
        display: block;
        width: 100%;
        height: auto;
      }
    </style>
  </head>
  <body>
    <header>
      <section class="before-header bgclr-white pdtb-15 clearfix">
        <div class="container">
          <div class="row">
            <div class="col-12 col-md-2">
              <a class="navbar-brand mr-0 pd-0" href="{{url('/')}}">
                @if($settings[0]->logo != '')
                <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" class="img-fluid mx-auto">
                @else
                <img src="{!! url('assets/images/company') !!}/logo.png" class="img-fluid mx-auto">
                @endif
              </a>
            </div>
            <div class="col-12 col-md-5">
              <form id="searchform">
                <div class="input-group search-grp">
                  <input type="text" class="form-control search-input" id="searchdata" placeholder="{{ trans('app.Search') }}" aria-label="Recipient's username" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <span class="input-group-text bgclr-primary clr-white" id="searchbtn"><i class='fas fa-search'></i></span>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-12 col-md-5">
              <div class="right-side">

                @if(Auth::guard('profile')->guest())
                  <a href="{{url('user/login')}}" class="clr-secondary f-12 f-weight600">{{ trans('app.Login') }}</a> &nbsp;
                @else
                  <a href="{{route('user.account',$subdomain_name)}}" class="clr-secondary f-12 f-weight600">{{ trans('app.MyAccount') }}</a>
                @endif
                
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
                        <a href="{{route('user.checkout',$subdomain_name)}}" class="pd-15 f-14 bgclr-primary clr-white text-center text-uppercase cart-checkout">{{trans('app.Checkout')}}</a>
                        <a href="{{url('/cart')}}" class="pd-15 f-14 bgclr-white clr-primary text-center text-uppercase">{{trans('app.ViewCart')}}</a>
                      </div>
                    </div>
                  </div>
                </span>  

                @if($companydetails[0]->language != '')
                  @php $companylang = explode(',',$companydetails[0]->language); @endphp
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
                @endif
              </div>

                
            </div>
          </div>
        </div>
      </section>

      <section class="nav-header bgclr-primary clearfix">
        <div class="container">
          <div class="row">
            <div class="col-10 col-md-4">
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
                        @php $subcat = count($menu->sub); @endphp
                        <li <?php if($subcat != 0){ ?> class="parent dropdown" <?php } ?>><a href="{{url('/category')}}/{{$menu->slug}}">@if($menu->feature_image != '')<img src="{{url('/assets')}}/images/categories/{{$menu->feature_image}}" class="img-responsive">@else <img src="{{url('/')}}/assets/images/placeholder.jpg" class="img-responsive"> @endif {{$menu->name}}</a>
                          @if($subcat >0)
                            @if(app()->getLocale() == 'ar')<i class="fa fa-angle-left"></i>@else<i class="fa fa-angle-right"></i>@endif
                          <div class="dropdown-sub dropdown-menu sub-apmegamenu-1" >
                            <div class="dropdown-menu-inner right_bottom">
                              @if($subcat > 0)
                                <div class="row">
                                  @foreach($menu->sub as $submenu)
                                  <div class="col-md-6 col-sm-6 col-lg-4 subcat_list">
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
            <div class="col-12 col-md-8">
              <nav class="navbar navbar-expand-lg f-14 f-weight600 float-md-right">
                <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav">
				 @php 
				  $navigation_menu = get_front_menu(); 
				 @endphp
                  <ul class="navbar-nav mr-auto text-capitalize">
                    @foreach($navigation_menu as $navigations)
                      @php 
                        $submenu = count($navigations->sub);
                      @endphp

                      <li class="nav-item">
                        <a class="nav-link" href="{{url('/')}}{{$navigations->url}}" <?php if($submenu > 0) { ?> data-toggle="dropdown"<?php } ?>>{{$navigations->title}} <?php if($submenu > 0) { ?><span class="caret"></span><?php } ?></a>

                        @if($submenu > 0)
                        <ul class="dropdown-menu sub-menu">
                          @foreach($navigations->sub as $subnav)
                            @php $childmenu = count($subnav->child); @endphp

                            <li class="dropdown-<?php if($childmenu > 0) { ?>submenu<?php } else {?>item<?php } ?>">
                              <a href="{{url('/')}}{{$subnav->url}}" <?php if($childmenu > 0) { ?>class="dropdown-toggle" data-toggle="dropdown"<?php } ?>> {{$subnav->title}} </a>

                              @if($childmenu > 0)
                              <ul class="dropdown-menu child-menu">
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

                </div>
              </nav>
            </div>
          </div>
        </div>
      </section>
    </header>
    
    @yield('content')
    
    <footer>
      <section class="newsletter clearfix mt-50 pdtb-30 bgclr-secondary">
        <div class="container">
          <div class="row">
            <div class="col-12 col-sm-12 col-md">
              <h3 class="clr-white mr-0 text-uppercase">{{trans('app.SignUpForNewsletter')}}</h3>
            </div>
            <form id="subform" action="{{action('FrontEndController@subscribe',$subdomain_name)}}" method="post" class="col-12 col-sm-12 col-md">
              {{csrf_field()}}
              <div class="input-group search-grp f-14 @if(app()->getLocale() == 'ar') mr-auto @else ml-auto @endif">
                <input type="text" class="form-control search-input f-14 input-newsletter" placeholder="{{trans('app.EnterEmail')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" type="email" id="email" name="email">
                <div class="input-group-append">
                  <button class="clr-white btn-newsletter bgclr-primary" id="subs" value="{{trans('app.Subscribe')}}" style="cursor: pointer;">{{trans('app.Subscribe')}}</button>
                </div>
              </div>
              <div class="input-group search-grp f-14 @if(app()->getLocale() == 'ar') mr-auto @else ml-auto @endif">
                <div id="resp" class="text-danger" style="text-align: left; text-transform: initial;"></div>
              </div>
            </form>
          </div>
        </div>
      </section>
      <section class="links-wrap">
        <div class="container">
          <div class="row">
            @if($settings[0]->about != '')
            <div class="col-12 col-sm-6 col-md-3">
              <div class="links about_us">
                <h5 class="mr-0 clr-secondary text-uppercase"><strong>{{trans('app.AboutUs')}}</strong></h5>
                <hr>
                <p>{{$settings[0]->about}}</p>
              </div>
            </div>
            @endif
            <div class="col-12 col-sm-6 col-md-3">
              <div class="links navigation">
                <h5 class="mr-0 clr-secondary text-uppercase"><strong>{{trans('app.QuickLinks')}}</strong></h5>
                <hr>
                <ul>
                  <li><a href="{{url('/')}}"><i class="fa fa-caret-right"></i> {{trans('app.Home')}}</a></li>
                  <li><a href="{{url('/about')}}"><i class="fa fa-caret-right"></i> {{trans('app.AboutUs')}}</a></li>
                  <li><a href="{{url('/faq')}}"><i class="fa fa-caret-right"></i> {{trans('app.FAQ')}}</a></li>
                  <li><a href="{{url('/contact')}}"><i class="fa fa-caret-right"></i> {{trans('app.ContactUs')}}</a></li>
                </ul>
              </div>
            </div>
            @if(count($lblogs) > 0)
            <div class="col-12 col-sm-6 col-md-3 latest_blog">
              <div class="links navigation">
                <h5 class="mr-0 clr-secondary text-uppercase"><strong>{{trans('app.LatestBlogs')}}</strong></h5>
                <hr>
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
            <div class="col-12 col-sm-6 col-md-3">
              <div class="links navigation">
                <h5 class="mr-0 clr-secondary text-uppercase"><strong>{{trans('app.PopularTags')}}</strong></h5>
                <hr>
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
            <div class="col-12 col-sm"><span class="f-14 clr-secondary-light">{!! $settings[0]->footer !!}</span></div>
            <div class="col-12 col-sm social">
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

    <script src="{{ URL::asset('assets/fashion-ecommerce/js/jquery.min.js')}}"></script>
    <script src="{{ URL::asset('assets/fashion-ecommerce/js/bootstrap.min.js')}}"></script>
    <script src="{{ URL::asset('assets/fashion-ecommerce/js/jquery.zoom.js')}}"></script>
    <script src="{{ URL::asset('assets/fashion-ecommerce/js/main.js')}}" ></script>
    <script src="{{ URL::asset('assets/fashion-ecommerce/js/owl.carousel.min.js')}}"></script>
    <script src="{{ URL::asset('assets/fashion-ecommerce/js/notify.js')}}"></script>
    <script src="{{ URL::asset('assets/fashion-ecommerce/js/bootstrap-slider.min.js')}}"></script>
    
    <script src="{{ URL::asset('assets/fashion-ecommerce/js/jquery.validate.min.js')}}"></script>
    <script src="{{ URL::asset('assets/fashion-ecommerce/js/additional-methods.min.js')}}"></script>
    
    @if(app()->getLocale() != 'en')
      <script src="{{ URL::asset('assets/js/localization/messages_')}}{{app()->getLocale()}}.js"></script>
    @endif

    <script type="text/javascript">
        
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