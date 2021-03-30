<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex" />
    <link rel="icon" type="image/png" href="{{url('/')}}/assets/superadmin/favicon.png" />
    <title>estoreWhiz</title>

    <link href="{{ URL::asset('assets/superadmin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/superadmin/css/mdb.min.css')}}" rel="stylesheet" type="text/css">
	
    <link href="{{ URL::asset('assets/superadmin/css/style.css')}}" rel="stylesheet" type="text/css">
	
    <link href="{{ URL::asset('assets/superadmin/css/responsive.css')}}" rel="stylesheet" type="text/css">
	
    <link href="{{ URL::asset('assets/superadmin/css/stepswizard.css')}}" rel="stylesheet" type="text/css">
	
     <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.4.1/css/all.css' integrity='sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz' crossorigin='anonymous'>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')}}"></script>
    <![endif]-->


</head>
<body>


<header>
      <section class="header-wrapper">
        <div class="before-header">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <a href="mailto:" class="f-16">
                  <i class='far fa-envelope'></i> support@estorewhiz.com
                </a>
              </div>
              <div class="col-sm-6">
                <ul class="social-icon">
                  <li class="rounded-circle"><a href="https://www.facebook.com/estorewhiz/" class="f-12" target="_blank"><i class='fab fa-facebook-f'></i></a></li>
                  <li class="rounded-circle"><a href="https://twitter.com/estorewhiz" class="f-12" target="_blank"><i class='fab fa-twitter'></i></a></li>
                  <li class="rounded-circle"><a href="https://www.linkedin.com/company/estorewhiz/about/" class="f-12" target="_blank"><i class='fab fa-linkedin'></i></a></li>
                  <li class="rounded-circle"><a href="https://plus.google.com/u/1/103940417350317015446" class="f-12" target="_blank"><i class='fab fa-google-plus'></i></a></li>
                  <li class="rounded-circle"><a href="https://www.instagram.com/estorewhiz/" class="f-12" target="_blank"><i class='fab fa-instagram'></i></a></li>
                  <li class="rounded-circle"><a href="https://in.pinterest.com/estorewhiz/" class="f-12" target="_blank"><i class='fab fa-pinterest-p'></i></a></li>
                  <li class="rounded-circle"><a href="https://www.youtube.com/channel/UCvqV02QyVb0QGs9b-2vlFKg?view_as=public" class="f-12" target="_blank"><i class='fab fa-youtube'></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="nav-wrap">
          <div class="container">
            <nav class="navbar navbar-expand-lg bgcolor-white">
              <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('/')}}/assets/superadmin/images/logo.png" class="img-responsive" alt="Logo"></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item active">
                    <a class="nav-link f-14" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
                  </li>
                  <?php foreach($cmsmenu as $allcms) { 
                    if($allcms->menudisplay == 'header' || $allcms->menudisplay == 'both') {
                  ?>
                  <li class="nav-item">
                    <a class="nav-link f-14" href="/{{$allcms->slug}}">{{$allcms->name}}</a>
                  </li>
                  <?php } } ?>
                  <li class="nav-item">
                    <a class="nav-link f-14" href="#">Pricing</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link f-14" href="/contactus">Contact us</a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
		
        
      </section>
    </header>
	
     @yield('content')

        <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="sm-desc">
              <img src="{{url('/')}}/assets/superadmin/images/logo.png" class="d-block img-fluid">
              <div class="tx-detail f-16 mt-30">aque ipsa quae ab illo inventore veritatis et quarnatur aut odit aut fugit, s onsequuntur voluptatemorro qui inventore veritatis et quarnatur </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="row">
              <div class="col-sm-6 col-md-auto">
                <div class="ft-heading f-16">Quick Links</div>
                <ul class="f-14">
                  <li><a href="/blogs">Blog</a></li>
                  <li><a href="/contactus">Contact Us</a></li>
                  <?php foreach($cmsmenu as $allcms) { 
                    if($allcms->menudisplay == 'footer' || $allcms->menudisplay == 'both') {
                  ?>
                  <li><a href="/{{$allcms->slug}}">{{$allcms->name}}</a></li>
                  <?php } } ?>
                </ul>
              </div>
              <div class="col-sm-6 col-md-auto">
                <div class="ft-heading f-16 ">SUPPORT</div>
                <ul class="f-14">
                  <li><a href="#">24/7 Support</a></li>
                  <li><a href="#">Help Center</a></li>
                  <li><a href="#">Free Tools</a></li>
                  <li><a href="#">Websites For sale</a></li>
                </ul>
              </div>
              <div class="col-sm-6 col-md-auto">
                <div class="ft-heading f-16 ">SUPPORT</div>
                <ul class="f-14">
                  <li><a href="#">Point of sale</a></li>
                  <li><a href="#">Features</a></li>
                  <li><a href="#">POS Software</a></li>
                  <li><a href="#">Hardware</a></li>
                </ul>
              </div>
              <div class="col-sm-6 col-md-auto">
                <div class="ft-heading f-16 ">POINT OF SALE</div>
                <ul class="f-14">
                  <li><a href="#">24/7 Support</a></li>
                  <li><a href="#">Help Center</a></li>
                  <li><a href="#">Free Tools</a></li>
                  <li><a href="#">Websites For sale</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col">
            <p class="text-center f-14">© ALL RIGHTS RESERVED | <a href="#">estorewhiz.com</a></p>
          </div>
        </div>
      </div>
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

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!--<script src="{{ URL::asset('assets/theme2/js/cart.js')}}" type="text/javascript"></script>-->
<script src="{{ URL::asset('assets/superadmin/js/popper.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/superadmin/js/mdb.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/superadmin/js/jquery.steps.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/superadmin/js/custom.js')}}" type="text/javascript"></script>



	<!-- Validation -->
<script src="{{ URL::asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/additional-methods.min.js')}}"></script>
@yield('footer')
</body>
</html>