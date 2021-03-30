<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

           <?php if(isset($meta)){?>

          <?php if($meta['metatitle'] != '') {  echo '<title>'.$meta['metatitle'].'</title>'; } else{ echo " <title>".$settings[0]->title."</title>";}?>
    
<?php if($meta['metadec'] != '') { ?><meta name="description" content="<?php echo $meta['metadec']; ?>" /><?php } ?>
    
<?php if($meta['metakey'] != '') { ?><meta name="keywords" content="<?php echo $meta['metakey']; ?>"/><?php } ?>
<?php }?>

    <!-- <title>{{$settings[0]->title}}</title> -->
    <link href="{{ URL::asset('assets/ecommerce-3/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="icon" href="{{ URL::asset('assets/ecommerce-3/images/favicon.png')}}" type="image/x-icon">  
    <link href="{{ URL::asset('assets/ecommerce-3/css/style.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-3/css/responsive.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-3/css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ecommerce-3/css/fonts.css')}}" rel="stylesheet"> 
    <link href="{{ URL::asset('assets/ecommerce-3/css/fontawesome.min.css')}}" rel="stylesheet">
    <script src="{{ URL::asset('assets/ecommerce-3/js/w3.js')}}"></script>
  
 <section id="before_header">
        <div class="container-fluid">ecommerce-3/
          <div class="row">
            <div class="col-xs-6">
              <div class="language-box">
         
              

                <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle lang" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    English
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu lang_menu" aria-labelledby="dropdownMenu1">
                    <li><a href="#">English</a></li>
                    <li><a href="#">English</a></li>
                    <li><a href="#">English</a></li>
                  </ul>
                </div>
                <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle lang" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    INR
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu lang_menu" aria-labelledby="dropdownMenu2">
                    <li><a href="#">INR</a></li>
                    <li><a href="#">INR</a></li>
                    <li><a href="#">INR</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="my_account">
                <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle lang" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-user-circle"></i> My Account
                  </button>
                  <ul class="dropdown-menu lang_menu" aria-labelledby="dropdownMenu2">
                    <li><a href="{{route('user.account',$subdomain_name)}}">Login</a></li>
                    <li><a href="#">INR</a></li>
                    <li><a href="#">INR</a></li>
                  </ul>
                </div>


                 <ul class="navbar-right">
      <li><a href="#" id="cart"><i class="fa fa-shopping-cart"></i> Cart <span class="badge">3</span></a></li>
    </ul> 


      






                 <ul class="dropdown-menu lang_menu" aria-labelledby="dropdownMenu2">
                  <div class="col-sm-3 col-xs-6 col-md-4 ">
                
            

              <span class="my-cart">
         <!--        <button class="tt-dropdown-toggle" data-toggle="collapse" data-target="#cart">
                  <i class="fas fa-cart-arrow-down"></i>
                  <span class="tt-badge-cart" id="cartQty">0</span>
                </button> -->
                   <button class="btn btn-default dropdown-toggle lang" data-target="#cart"  data-toggle="collapse">
                    <i class="fas fa-shopping-cart" id="cartQty">0</i>
                  </button>

                <div id="cart" class="collapse cart-box" style="background-color: white;" >
                  <div id="emptycart" >
                    {{$language->empty_cart}}
                  </div>
                  <div class="cart-list" id="goCart">
                    
                  </div>
                  <div class="cartbox-total">
                    <div class="total-title">{{$language->subtotal}}</div>
                    <div class="total-price">{{$settings[0]->currency_sign}}0.00</div>
                  </div>
                  <div class="cart-butnbox">
                    <div class="cart-item">
                      <a href="{{route('user.checkout',$subdomain_name)}}" class="text-center text-uppercase checkout-btn">{{$language->checkout}}</a>
                      <a href="{{url('/cart')}}" class="text-center text-uppercase cart-btn">{{$language->view_cart}}</a>
                    </div>
                  </div>
                </div>
              </span>
        
          </div>
        </ul>


            

              </div>
            </div>
           

                 </span>
            </div>
          </div>
          
      
      </section>


          </div>
        </div>
      </section>
      <section id="company_info">
        <div class="container">

          <!-- ====================================== Div logo oregginal place-->
                        <div class="logo_box col-xs-6">
              <a href="{{url('/')}}">
               @if($settings[0]->logo != '')
              <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" class="img-responsive"  width="80px" height="150px">
                @else
                  <img src="{!! url('assets/images/company') !!}/logo.png" class="img-responsive" width="80px" height="150px">
                @endif
           </a>
          </div>


        

          <!-- ======================================================= -->

      </section>

      <!-- ------------------------------------------------------------------ -->

        <section id="nav_box">
        <div class="container">
          <nav class="navbar navbar-default">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @php 
				  $navigation_menu = get_front_menu(); 
			 @endphp
            <ul class="nav navbar-nav">
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

          
          </nav>
        </div>
      </section>


</head>


   @yield('content')



   <footer class="clearfix">
        <section id="service">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-3">
                <div class="ser_box">
                  <i class="fas fa-truck"></i>
                  <span>
                    <div><strong>FREE SHIPPING</strong></div>
                    <div>Free ship for local customers</div>
                  </span>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="ser_box">
                  <i class="fas fa-clock"></i>
                  <span>
                    <div><strong>ONLINE SUPPORT</strong></div>
                    <div>Answer questions with 12 hours</div>
                  </span>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="ser_box">
                  <i class="fas fa-retweet"></i>
                  <span>
                    <div><strong>FREE EXCHANGE</strong></div>
                    <div>Exchange your item in 24 hours</div>
                  </span>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="ser_box">
                  <i class="fas fa-thumbs-up"></i>
                  <span>
                    <div><strong>SATISFACTION GUARANTEED</strong></div>
                    <div>Lorem ipsum dolor sit amet</div>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section id="need_support" class="clearfix">
          <div class="container-fluid">
            <div class="col-sm-4">
              <!-- <p>Need support? Call us (+123)4 123 456 789</p> -->
              <p>{!! $settings[0]->footer !!}</p>
            </div>
            <div class="col-sm-4">
              <div class="text-center">
                   @if($sociallinks[0]->f_status == "enable")
                <a href="{{$sociallinks[0]->facebook}}"><i class="fab fa-facebook-f"></i></a>
                  @endif  

                    @if($sociallinks[0]->g_status == "enable")

                       <a href="{{$sociallinks[0]->g_plus}}"><i class="fab fa-google-plus-g"></i></a>

                     @endif
                @if($sociallinks[0]->t_status == "enable")
                
                   <a href="{{$sociallinks[0]->twiter}}"><i class="fab fa-twitter"></i></a>

                  @endif
                @if($sociallinks[0]->link_status == "enable")

               
                  <a href=" {{$sociallinks[0]->linkedin}}"><i class="fab fa-linkedin-in"></i></a>

                @endif

             
              
                <!-- <a href="#"><i class="fab fa-pinterest-p"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a> -->
               
              </div>
            </div>
            <div class="col-sm-4">
              <div class="frm_subscribe">
              <form>
                <input type="email" name="email" placeholder="Enter Your Email-id">
                <button>Subscribe</button>
              </form>
              </div>
            </div>
          </div>
        </section>
        <section id="links">
          <div class="container">
            <div class="row">

                 <div class="col-md-3" style="color: white;">

          @if($settings[0]->logo != '')
            <imgsrc="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" alert="LOGO" class="img-responsive logo">
          @else
            <img class="logo" src="{!! url('assets/images/company') !!}/logo.png" alert="LOGO" class="img-responsive logo">
          @endif
               <ul class="list_link">
                  <h3>ABOUT US</h3>
          <p>{{$settings[0]->about}}</p>
        </ul>
        </div>




              <div class="col-sm-3">
                <ul class="list_link">
                  <h3>QUICK LINKS</h3>
            
            <li><a href="{{url('/')}}">{{$language->home}}</a></li>
            <li><a href="{{url('/about')}}">{{$language->about_us}}</a></li>
            <li><a href="{{url('/faq')}}">{{$language->faq}}</a></li>
            <li><a href="{{url('/contact')}}">{{$language->contact_us}}</a></li>


                </ul>
              </div>


        @if(count($lblogs) > 0)    
              <div class="col-sm-3">
                <ul class="list_link">
                  <h3>{{$language->latest_blogs}}</h3>
                    @foreach($lblogs as $lblog)
                    <li>
              <a href="{{url('/blog')}}/{{$lblog->id}}">
                @if($lblog->featured_image != '')
                    <img src="{{url('/assets/images/blog')}}/{{$lblog->featured_image}}" alt="" width="80px" height="65px">
                @else
                    <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="" width="80px" height="65px">
                @endif
                <span>{{$lblog->title}}</span>
              </a>
            </li>
            @endforeach
                </ul>
              </div>

          @endif   

             @if($settings[0]->popular_tags) 
              <div class="col-sm-3">
                <ul class="address">
                  <h3>{{$language->popular_tags}}</h3>
                    @foreach(explode(',',$settings[0]->popular_tags) as $tag)
                  <li>
                  <a href="{{url('/tags')}}/{{$tag}}">{{$tag}}</a></li>
            @endforeach

                </ul>
              </div>
           @endif   

            </div>
          </div>
        </section>
        <section id="copy_right">
          <div class="container">
            <div class="col-md-12">
              <p>Copyright © 2018 ThemeXtra WordPress Theme by ThemeXtra</p>
            </div>
          </div>
        </section>
    </footer>

      <script>
    var mainurl = '{{url('/')}}';
    var currency = '{{$settings[0]->currency_sign}}';
    var ship_info = '{{$settings[0]->shipping_information}}';
    var tax_info = '{{$settings[0]->tax_information}}';
    var potax = '{{$settings[0]->tax}}';
    var poshipcost = '{{$settings[0]->shipping_cost}}';
    var language = {!! json_encode($language) !!};
  </script>


    <script src="{{ URL::asset('assets/ecommerce-3/js/jquery.min.js')}}"></script>
    <script src="{{ URL::asset('assets/ecommerce-3/js/bootstrap.min.js')}}"></script>
    <script src="{{ URL::asset('assets/ecommerce-3/js/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/ecommerce-3/js/custom.js')}}"></script>
    <script src="{{ URL::asset('assets/ecommerce-4/js/bootstrap-slider.min.js')}}"></script>
    <script src="{{ URL::asset('assets/ecommerce-3/js/main.js')}}"></script>
    <script src="{{ URL::asset('assets/ecommerce-3/js/jquery.validate.min.js')}}"></script>
    <script src="{{ URL::asset('assets/ecommerce-3/js/additional-methods.min.js')}}"></script>
    @yield('footer')
  </body>
</html>