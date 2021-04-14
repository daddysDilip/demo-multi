<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="Estorewiz Admin Panel.">
    <meta name="author" content="Estorewiz">
    <link rel="icon" type="image/png" href="{{url('/')}}/assets/images/{{$settings[0]->favicon}}" />

    <title>{{$settings[0]->title}} - Super Admin Panel</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/octicons/3.5.0/octicons.min.css" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap-colorpicker.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap-datepicker.css')}}" rel="stylesheet">

    <link href="{{ URL::asset('assets/css/olddatatables.min.css')}}" rel="stylesheet"> -->

    <!-- Custom CSS -->
    <!-- <link href="{{ URL::asset('assets/css/vendor.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/plugins.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/pratham.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/fastselect.css')}}" rel="stylesheet"> -->


    <!-- sadmin2 -->
    <link href="{{ URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="{{ URL::asset('assets/sadmin2/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/sadmin2/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('assets/sadmin2/plugins/morrisjs/morris.min.css')}}" />
    <link href="{{ URL::asset('assets/sadmin2/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />
    <!-- Bootstrap Select Css -->
    <link href="{{ URL::asset('assets/sadmin2/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
    <!-- Multi Select Css -->
<link rel="stylesheet" href="{{ URL::asset('assets/sadmin2/plugins/multi-select/css/multi-select.css')}}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/sadmin2/css/main.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/sadmin2/css/color_skins.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/sadmin2/css/ecommerce.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/sadmin2/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
    <!-- sadmin2 -->

    <!-- <link href="{{ URL::asset('assets/css/genius-admin.css')}}" rel="stylesheet"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        .prtm-loader-wrap, #toast-container
        {
            display: none !important;
        }
        .prtm-content-wrapper
        {
            margin-left: 280px !important;
        }
        .basic
        {
            
            background: linear-gradient(60deg, #00adef, #0094da) !important;
            color: #fff !important;
        }
        .platinum
        {
            background: linear-gradient(45deg, #708090, #7c8ea0) !important;
            color: #fff !important;
        }
        .standard
        {
            background: linear-gradient(60deg, #16c99f, #12a682) !important;
            color: #fff !important;
        }
        .golden
        {
            background: linear-gradient(60deg, #f83600, #fe8c00) !important;
            color: #fff !important;
        }
    </style>

</head>
<body class="theme-cyan">

<!-- Top Bar -->
<nav class="navbar">
    <div class="col-12">        
        <div class="navbar-header">
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{!! url('sadmin/dashboard') !!}"><img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" width="" alt="logo"></a>
        </div>
        <ul class="nav navbar-nav navbar-left">
            <li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a></li>            
            <li class="hidden-sm-down">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-addon">
                        <i class="zmdi zmdi-search"></i>
                    </span>
                </div>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-notifications"></i>
                <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                </a>
                <ul class="dropdown-menu dropdown-menu-right slideDown">
                    <li class="header">NOTIFICATIONS</li>
                    <li class="body">
                        <ul class="menu list-unstyled">
                            <li> <a href="javascript:void(0);">
                                <div class="icon-circle bg-blue"><i class="zmdi zmdi-account"></i></div>
                                <div class="menu-info">
                                    <h4>8 New Members joined</h4>
                                    <p><i class="zmdi zmdi-time"></i> 14 mins ago </p>
                                </div>
                                </a> </li>
                            <li> <a href="javascript:void(0);">
                                <div class="icon-circle bg-amber"><i class="zmdi zmdi-shopping-cart"></i></div>
                                <div class="menu-info">
                                    <h4>4 Sales made</h4>
                                    <p> <i class="zmdi zmdi-time"></i> 22 mins ago </p>
                                </div>
                                </a> </li>
                            <li> <a href="javascript:void(0);">
                                <div class="icon-circle bg-red"><i class="zmdi zmdi-delete"></i></div>
                                <div class="menu-info">
                                    <h4><b>Nancy Doe</b> Deleted account</h4>
                                    <p> <i class="zmdi zmdi-time"></i> 3 hours ago </p>
                                </div>
                                </a> </li>
                            <li> <a href="javascript:void(0);">
                                <div class="icon-circle bg-green"><i class="zmdi zmdi-edit"></i></div>
                                <div class="menu-info">
                                    <h4><b>Nancy</b> Changed name</h4>
                                    <p> <i class="zmdi zmdi-time"></i> 2 hours ago </p>
                                </div>
                                </a> </li>
                            <li> <a href="javascript:void(0);">
                                <div class="icon-circle bg-grey"><i class="zmdi zmdi-comment-text"></i></div>
                                <div class="menu-info">
                                    <h4><b>John</b> Commented your post</h4>
                                    <p> <i class="zmdi zmdi-time"></i> 4 hours ago </p>
                                </div>
                                </a> </li>
                            <li> <a href="javascript:void(0);">
                                <div class="icon-circle bg-purple"><i class="zmdi zmdi-refresh"></i></div>
                                <div class="menu-info">
                                    <h4><b>John</b> Updated status</h4>
                                    <p> <i class="zmdi zmdi-time"></i> 3 hours ago </p>
                                </div>
                                </a> </li>
                            <li> <a href="javascript:void(0);">
                                <div class="icon-circle bg-light-blue"><i class="zmdi zmdi-settings"></i></div>
                                <div class="menu-info">
                                    <h4>Settings Updated</h4>
                                    <p> <i class="zmdi zmdi-time"></i> Yesterday </p>
                                </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer"> <a href="javascript:void(0);">View All Notifications</a> </li>
                </ul>
            </li>
            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-flag"></i>
                <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                </a>
                <ul class="dropdown-menu dropdown-menu-right slideDown">
                    <li class="header">TASKS</li>
                    <li class="body">
                        <ul class="menu tasks list-unstyled">
                            <li> <a href="javascript:void(0);">
                                <div class="progress-container progress-primary">
                                    <span class="progress-badge">Footer display issue</span>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100" style="width: 86%;">
                                            <span class="progress-value">86%</span>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>
                            <li> <a href="javascript:void(0);">
                                <div class="progress-container progress-info">
                                    <span class="progress-badge">Answer GitHub questions</span>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                            <span class="progress-value">35%</span>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>
                            <li> <a href="javascript:void(0);">
                                <div class="progress-container progress-success">
                                    <span class="progress-badge">Solve transition issue</span>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">
                                            <span class="progress-value">72%</span>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>
                            <li><a href="javascript:void(0);">
                                <div class="progress-container">
                                    <span class="progress-badge"> Create new dashboard</span>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
                                            <span class="progress-value">45%</span>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>
                            <li> <a href="javascript:void(0);">
                                <div class="progress-container progress-warning">
                                    <span class="progress-badge">Panding Project</span>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100" style="width: 29%;">
                                            <span class="progress-value">29%</span>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer"><a href="javascript:void(0);">View All</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="fullscreen hidden-sm-down" data-provide="fullscreen" data-close="true"><i class="zmdi zmdi-fullscreen"></i></a>
            </li>
            <li><a href="{!! url('sadmin/logout') !!}" class="mega-menu" data-close="true"><i class="zmdi zmdi-power"></i></a></li>
            <li class=""><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a></li>
        </ul>
    </div>
</nav>
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="menu">
       <!--  <ul class="list">
            <li>
                <div class="user-info">
                    <div class="image"><a href="profile.html"><img src="assets/images/profile_av.jpg" alt="User"></a></div>
                    <div class="detail">
                        <h4>Michael</h4>
                        <small>UI UX Designer</small>                        
                    </div>
                    <a href="events.html" title="Events"><i class="zmdi zmdi-calendar"></i></a>
                    <a href="mail-inbox.html" title="Inbox"><i class="zmdi zmdi-email"></i></a>
                    <a href="contact.html" title="Contact List"><i class="zmdi zmdi-account-box-phone"></i></a>
                    <a href="chat.html" title="Chat App"><i class="zmdi zmdi-comments"></i></a>
                    <a href="sign-in.html" title="Sign out"><i class="zmdi zmdi-power"></i></a>
                </div>
            </li>
            
        </ul> -->
        <ul class="list">
            @foreach($adminmenus as $adminmenu)
            <li>
                <a href="{!! url('sadmin') !!}/{{$adminmenu->path}}"><i class="fa fa-fw {{$adminmenu->menuicon}}"></i>  {{$adminmenu->name}}</a>
            </li>   
            @endforeach
            </a>
        </ul>
    </div>
</aside>
<section class="content home">
    @yield('content')
    </section>

<script>
    var baseUrl = '{!! url('/') !!}';
</script>

<!-- sadminjs2 -->
<script src="{{ URL::asset('assets/js/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery-ui.min.js')}}"></script>

<script src="{{ URL::asset('assets/sadmin2/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
<script src="{{ URL::asset('assets/sadmin2/bundles/vendorscripts.bundle.js')}}"></script> <!-- slimscroll, waves Scripts Plugin Js -->
<script src="{{ URL::asset('assets/sadmin2/plugins/momentjs/moment.js')}}"></script> 
<script src="{{ URL::asset('assets/sadmin2/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 




<script src="{{ URL::asset('assets/sadmin2/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{ URL::asset('assets/sadmin2/js/pages/forms/basic-form-elements.js')}}"></script>

<script src="{{ URL::asset('assets/sadmin2/js/pages/index.js')}}"></script>

<!-- sadminjs2 -->
<!-- jQuery -->

<!-- <script src="{{ URL::asset('assets/js/jquery.smooth-scroll.js')}}"></script> -->

<!-- Bootstrap Core JavaScript -->
<!-- <script src="{{ URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-tagsinput.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-datepicker.min.js')}}"></script>

<script src="{{ URL::asset('assets/js/olddatatable.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/fastclick.js')}}"></script>
<script src="{{ URL::asset('assets/js/fastselect.standalone.js')}}"></script> -->
<!-- Switchery -->
<!-- <script src="{{ URL::asset('assets/js/bootstrap-toggle.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/plugin/nicEdit.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/admin-genius.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/Chart.min.js')}}"></script> -->
<!-- Validation -->



<!-- sadmin2 datatavke js -->


<!-- Jquery DataTable Plugin Js --> 
<script src="{{ URL::asset('assets/sadmin2/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{ URL::asset('assets/sadmin2/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/sadmin2/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/sadmin2/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{ URL::asset('assets/sadmin2/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{ URL::asset('assets/sadmin2/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/sadmin2/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/sadmin2/plugins/multi-select/js/jquery.multi-select.js')}}"></script> <!-- Multi Select Plugin Js --> 
{{-- <script src="{{ URL::asset('assets/sadmin2/js/pages/forms/advanced-form-elements.js')}}"></script>  --}}

<script src="{{ URL::asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/additional-methods.min.js')}}"></script>

<!-- <script src="{{ URL::asset('assets/sadmin2/js/pages/tables/jquery-datatable.js')}}"></script> -->
<!-- sadmin2 datatavke js -->

<script type="text/javascript">
    setTimeout(function() {
        $("#res .alert").hide('blind', {}, 500)
    }, 2000);
</script>

<script>
    $("#maincats").change(function () {
        $("#subs").html('<option value="">Select Sub Category</option>');
        $("#subs").attr('disabled',true);
        $("#childs").html('<option value="">Select Sub Category</option>');
        $("#childs").attr('disabled',true);
        var mainid = $(this).val();
        $.get('{{url('/')}}/subcats/'+mainid, function(response){
            $("#subs").attr('disabled',false);
            $.each(response, function(i, cart){
                $.each(cart, function (index, data) {
                    $("#subs").append('<option value="'+data.id+'">'+data.name+'</option>');
                    //console.log('index', data)
                })
            })
        });
    });
    $("#subs").change(function () {
        $("#childs").html('<option value="">Select Sub Category</option>');
        $("#childs").attr('disabled',true);
        var mainid = $(this).val();
        $.get('{{url('/')}}/childcats/'+mainid, function(response){
            $("#childs").attr('disabled',false);
            $.each(response, function(i, cart){
                $.each(cart, function (index, data) {
                    $("#childs").append('<option value="'+data.id+'">'+data.name+'</option>');
                    //console.log('index', data)
                })
            })
        });
    });

    /*$(".datepicker").datepicker({ 
        autoclose: true, 
        startDate: "today",
    });*/


</script>
@yield('footer')
</body>
</html>

