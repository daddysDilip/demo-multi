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

    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap-slider.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/genius-slider.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/go-style.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/responsive.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/main.css')}}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')}}"></script>
    <![endif]-->


</head>
<body>
<div id="cover"></div>
<div id="content-block">
    <div class="content-center fixed-header-margin" style="padding-top: 114px;">
        <!-- HEADER -->
        <!-- @php $total = 0; @endphp

        @foreach($cartvalue as $cart) 
            @php 
                $totaltax = ($cart->cost + $cart->shipping_cost) *($cart->tax/100);
                $cost = $cart->cost + $cart->shipping_cost + $totaltax;
                $total += $cart->quantity * $cost;
            @endphp
        @endforeach  -->
    
        <div class="header-wrapper style-10">
            <header class="type-1">

                <div class="header-product">
                    <div class="logo-wrapper">
                        <a href="{{url('/')}}" id="logo">
                            @if($settings[0]->logo != '')
                            <img alt="" src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" alert="LOGO">
                            @else
                            <img class="logo" src="{!! url('assets/images/company') !!}/logo.png" alt="LOGO" alert="LOGO">
                            @endif
                        </a>
                    </div>

                    <div class="product-header-content">
                        <div class="line-entry">
                            <div class="menu-button responsive-menu-toggle-class"><i class="fa fa-reorder"></i></div>

                        </div>
                        {{--<div class="middle-line"></div>--}}
                        <div class="line-entry">
                            <div class="header-top-entry increase-icon-responsive open-search-popup">
                                <div class="title"><i class="fa fa-search"></i> <span>{{ trans('app.Search') }}</span></div>
                            </div>
                            <div class="header-top-entry increase-icon-responsive login">
                                @if(Auth::guard('profile')->guest())
                                    <a href="{{url('user/login')}}" class="title"><i class="fa fa-user"></i> <span>{{ trans('app.Login') }}</span></a>
                                @else
                                    <a href="{{route('user.account',$subdomain_name)}}" class="title"><i class="fa fa-user"></i> <span>{{ trans('app.MyAccount') }}</span></a>
                                @endif
                            </div>
                            <a href="{{url('/cart')}}" class="header-top-entry open-cart-popup" id="notify"><div class="title"><i class="fa fa-shopping-cart"></i><span>{{trans('app.Mycart')}}</span> <b id="carttotal">{{$settings[0]->currency_sign}}0.00</b></div></a>

                            @if($companydetails[0]->language != '')
                                @php $companylang = explode(',',$companydetails[0]->language); @endphp
                                <div class="header-top-entry">
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
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="close-header-layer"></div>
                <div class="navigation">
                    <div class="navigation-header responsive-menu-toggle-class">
                        <div class="title">{{ trans('app.Navigation') }}</div>
                        <div class="close-menu"></div>
                    </div>
                    <div class="nav-overflow">
                        <nav>
                            <ul>
                                @php 
                                    $navigation_menu = get_front_menu(); 
								@endphp
                                @foreach($navigation_menu as $navigations)
                                @php 
                                    $submenu = count($navigations->sub); 
                                @endphp
                                <li class="full-width-columns">
                                    <a href="{{url('/')}}{{$navigations->url}}">{{$navigations->title}}</a>
                                    @if($submenu >0)
                                        <i class="fa fa-chevron-down"></i>
                                        <div class="submenu">
                                            @foreach($navigations->sub as $subnav)
                                             @php $childmenu = count($subnav->child); @endphp
                                                <div class="product-column-entry">
                                                    <div class="submenu-list-title"><a href="{{url('/')}}{{$subnav->url}}">{{$subnav->title}}</a><span class="toggle-list-button"></span></div>
                                                    @if($childmenu > 0)
                                                    <div class="description toggle-list-container">
                                                        <ul class="list-type-1">
                                                            @foreach($subnav->child as $childnav)
                                                                <li><a href="{{url('/')}}{{$childnav->url}}"><i class="fa fa-angle-right"></i>{{$childnav->title}}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </li>
                                @endforeach
								
								 @php 
                                    $navigation_cat_menu = get_cat_front_menu(); 
								@endphp

                                @foreach($navigation_cat_menu as $menu)
                                <li class="full-width-columns">
                                    <a href="{{url('/category')}}/{{$menu->slug}}">{{$menu->name}}</a>
                                    @if(count($menu->sub) >0)
                                        <i class="fa fa-chevron-down"></i>
                                        <div class="submenu">
                                            @foreach($menu->sub as $submenu)
                                                <div class="product-column-entry">
                                                    <div class="submenu-list-title"><a href="{{url('/category')}}/{{$submenu->slug}}">{{$submenu->name}}</a><span class="toggle-list-button"></span></div>
													 @if(count($submenu->child) >0)
                                                    <div class="description toggle-list-container">
                                                        <ul class="list-type-1">
                                                            @foreach($submenu->child as $childmenu)
                                                                <li><a href="{{url('/category')}}/{{$childmenu->slug}}"><i class="fa fa-angle-right"></i>{{$childmenu->name}}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
													 @endif
                                                    <div class="hot-mark yellow">sale</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </li>
                                @endforeach

                                <li class="fixed-header-visible">
                                    <a class="fixed-header-square-button open-cart-popup"><i class="fa fa-shopping-cart"></i></a>
                                    <a class="fixed-header-square-button open-search-popup"><i class="fa fa-search"></i></a>
                                </li>
                            </ul>

                            <div class="clear"></div>

                        </nav>
                        <div class="navigation-footer responsive-menu-toggle-class">

                        </div>
                    </div>
                </div>
            </header>
            <div class="clear"></div>
        </div>
    </div>

    @yield('content')

        <!-- starting of footer area -->
        <footer class="section-padding footer-area-wrapper wow fadeInUp">
            <div class="container">
                <div class="row">
                    @if($settings[0]->about != '')
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="single-footer-area">
                            <div class="footer-title">
                                {{trans('app.AboutUs')}}
                            </div>
                            <div class="footer-content">
                                <p>
                                    {{$settings[0]->about}}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="single-footer-area">
                            <div class="footer-title">
                                {{trans('app.QuickLinks')}}
                            </div>
                            <div class="footer-content">
                                <ul class="about-footer">
                                    <li><a href="{{url('/')}}"><i class="fa fa-caret-right"></i> {{trans('app.Home')}}</a></li>
                                    <li><a href="{{url('/about')}}"><i class="fa fa-caret-right"></i> {{trans('app.AboutUs')}}</a></li>
                                    <li><a href="{{url('/faq')}}"><i class="fa fa-caret-right"></i> {{trans('app.FAQ')}}</a></li>
                                    <li><a href="{{url('/contact')}}"><i class="fa fa-caret-right"></i> {{trans('app.ContactUs')}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if(count($lblogs) > 0)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="single-footer-area">
                            <div class="footer-title">
                               {{trans('app.LatestBlogs')}}
                            </div>
                            <div class="footer-content">
                                <ul class="latest-tweet">
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
                    </div>
                    @endif
					@if($settings[0]->popular_tags)
                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                        <div class="single-footer-area">
                            <div class="footer-title">
                               {{trans('app.PopularTags')}}
                            </div>
                            <div class="footer-content tags">
                                @foreach(explode(',',$settings[0]->popular_tags) as $tag)
                                    <a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
					 @endif
                </div>
            </div>
            <hr>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 footer-copy">
                        {!! $settings[0]->footer !!}
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="footer-social-links">
                            <ul>
                                @if($sociallinks[0]->f_status == "enable")
                                <li>
                                    <a class="facebook" href="{{$sociallinks[0]->facebook}}" target="_blank">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                @endif
                                @if($sociallinks[0]->g_status == "enable")
                                <li>
                                    <a class="google" href="{{$sociallinks[0]->g_plus}}" target="_blank">
                                        <i class="fa fa-google"></i>
                                    </a>
                                </li>
                                @endif
                                @if($sociallinks[0]->t_status == "enable")
                                <li>
                                    <a class="twitter" href="{{$sociallinks[0]->twiter}}" target="_blank">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                @endif
                                @if($sociallinks[0]->link_status == "enable")
                                <li>
                                    <a class="tumblr" href="{{$sociallinks[0]->linkedin}}" target="_blank">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Ending of footer area -->


        <div class="cart-box popup">
            <div class="popup-container">
                <div id="emptycart">
                    {{trans('app.EmptyCart')}}
                </div>
                <div id="goCart">
                    
                </div>
            
                <div class="summary">
                    <div class="grandtotal">{{trans('app.SubTotal')}} <span id="grandttl">{{$settings[0]->currency_sign}}0.00</span></div>
                </div>
                <div class="cart-buttons">
                    <div class="column">
                        <a href="{{url('/cart')}}" class="button style-3">{{trans('app.ViewCart')}}</a>
                        <div class="clear"></div>
                    </div>
                    <div class="column">
                        <a href="{{route('user.checkout',$subdomain_name)}}" class="button style-4">{{trans('app.Checkout')}}</a>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
               
            </div>
        </div>


        <div class="search-box popup">
            <form id="searchform">
                <button type="button" id="searchbtn" class="search-button">
                    <i class="fa fa-search"></i>
                </button>

                <div class="search-field">
                    <input type="text" id="searchdata" value="" placeholder="{{trans('app.Search')}}" />
                </div>
            </form>
        </div>

        <!-- Product Quick View Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="viewProduct">

                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

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

</script>

<script src="{{ URL::asset('assets/js/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.zoom.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-slider.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/wow.js')}}"></script>
<script src="{{ URL::asset('assets/js/genius-slider.js')}}"></script>
<script src="{{ URL::asset('assets/js/global.js')}}"></script>
<script src="{{ URL::asset('assets/js/main.js')}}"></script>
<script src="{{ URL::asset('assets/js/plugins.js')}}"></script>
<script src="{{ URL::asset('assets/js/notify.js')}}"></script>
<script src="{{ URL::asset('assets/js/owl.carousel.min.js')}}"></script>
<!-- Validation -->
<script src="{{ URL::asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/additional-methods.min.js')}}"></script>

@if(app()->getLocale() != 'en')
    <script src="{{ URL::asset('assets/js/localization/messages_')}}{{app()->getLocale()}}.js"></script>
@endif

@yield('footer')
</body>
</html>