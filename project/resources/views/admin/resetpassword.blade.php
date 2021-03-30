<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="Simple Documentation for project NewsOcean.">
    <meta name="author" content="GeniusOcean">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forgot Password - Admin Panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::asset('assets/css/vendor.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/plugins.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/pratham.min.css')}}" rel="stylesheet">
    <!-- <link href="{{ URL::asset('assets/css/genius-admin.css')}}" rel="stylesheet"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

<div class="prtm-wrapper">
    <div class="prtm-main">
        <div class="login-banner"></div>
        <div class="login-form-wrapper mrgn-b-lg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-5 center-block">
                        <div class="prtm-form-block prtm-full-block overflow-wrappper">

                            <div class="login-bar"> 
                                <img src="{{ URL::asset('assets/img/login-bars.png')}}" class="img-responsive" alt="login bar" width="743" height="7" style="width: 100%;"> 
                            </div>

                            <div class="prtm-block-title text-center">
                                <div class="login-top mrgn-b-lg">
                                    <div class="mrgn-b-md">
                                        <h2 class="text-capitalize base-dark font-2x fw-normal">Reset Password</h2>
                                    </div>
                                    <p>Please enter your email address</p>
                                </div>
                            </div>

                            <div class="prtm-block-content">
                                <form action="{!! action('Auth\ProfileResetPassController@adminnewpassword',$subdomain_name) !!}" class="login-form" method="POST" id="reset_form">
                                    {{ csrf_field() }}

                                    <div id="resp">
                                        @if(Session::has('success'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('success') }}
                                            </div>
                                        @endif
                                        @if(Session::has('error'))
                                            <div class="alert alert-danger alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('error') }}
                                            </div>
                                        @endif
                                    </div>

                                    <input type="hidden" name="id" value="{{$id}}">

                                    <div class="form-group has-feedback">
                                        <span class="glyphicon glyphicon-lock form-control-feedback fa-lg" aria-hidden="true"></span><input type="password" id="new_password" name="new_password" placeholder="Enter New Password"  class="form-control"/>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <span class="glyphicon glyphicon-lock form-control-feedback fa-lg" aria-hidden="true"></span><input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter Password"  class="form-control"/>
                                    </div>

                                    <div class="mrgn-b-lg">
                                        <button type="submit" class="btn btn-success btn-block font-2x">Submit</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ URL::asset('assets/js/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/additional-methods.min.js')}}"></script>

<script type="text/javascript">

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){

        $('#reset_form').validate({
            rules:{
                new_password:{
                    required: true,
                    minlength: 6,
                    maxlength: 12,
                },
                confirm_password:{
                    equalTo: '#new_password',
                },
            },
            highlight: function (element) {
                $(element).parent().addClass('has-error')
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('has-error')
            },
            errorElement: 'span',
            errorClass: 'text-danger',
        });

    });
</script>

</body>
</html>