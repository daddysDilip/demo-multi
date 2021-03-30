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
                                        <h2 class="text-capitalize base-dark font-2x fw-normal">Forgot Password</h2>
                                    </div>
                                    <p>Please enter your email address</p>
                                </div>
                            </div>

                            <div class="prtm-block-content">

                                <form action="{!! action('Auth\ProfileResetPassController@resetAdminPass',$subdomain_name) !!}" class="login-form" method="POST" id="forgot_form">

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

                                    <div class="form-group has-feedback">

                                        <span class="glyphicon glyphicon-user form-control-feedback fa-lg" aria-hidden="true"></span><input type="text" id="email" name="email" placeholder="Email address"  class="form-control"/>
                                    </div>

                                    <div class="mrgn-b-lg">
                                        <button type="submit" class="btn btn-success btn-block font-2x">Sign In</button>
                                    </div>

                                    <div class="text-center">

                                    <div class="text-center"> <a class="back-home-btn" href="{!! url('/admin/login') !!}"><i class="fa fa-long-arrow-left mrgn-r-xs"></i>Back To Login</a> </div>

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



        $.validator.addMethod('Validemail', function (value, element) {

            return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);

        }, "Please enter a valid email address.");



        $('#forgot_form').validate({

            rules:{

                email:{

                    required:true,

                    Validemail: true,

                    minlength: 3,

                    maxlength: 50,

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