<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" langdir="{{get_language_direction()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <?php if(isset($meta)){?>
    
<?php if($meta['description'] != '') { ?><meta name="description" content="<?php echo $meta['description']; ?>" /><?php } ?>
    
<?php if($meta['Keyword'] != '') { ?><meta name="keywords" content="<?php echo $meta['Keyword']; ?>"/><?php } ?>
<?php } ?>
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
   
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="{{url('/')}}/assets/images/{{$settings[0]->favicon}}" />

    <title>{{$settings[0]->title}} - {{ trans('app.AdminPanel') }}</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/octicons/3.5.0/octicons.min.css" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap-colorpicker.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap-datepicker.css')}}" rel="stylesheet">

    <link href="{{ URL::asset('assets/css/olddatatables.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::asset('assets/css/vendor.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/plugins.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/pratham.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/fastselect.css')}}" rel="stylesheet">

    <style type="text/css">
        .prtm-loader-wrap, #toast-container
        {
            display: none !important;
        }
        .prtm-content-wrapper
        {
            margin-left: 280px !important;
        }
    </style>

</head>
<body>

<div class="prtm-wrapper">
    <header class="prtm-header">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">{{ trans('app.ToggleNavigation') }}</span> <span class="icon-bar"></span><span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <button class="c-hamburger c-hamburger--htra prtm-bars pull-right"> <span>{{ trans('app.ToggleMenu') }}</span> </button>
                    <div class="prtm-logo">
                        <a class="navbar-brand" href="{!! url('admin/dashboard') !!}">
                            @if($settings[0]->logo != '')
                            <img class="logo" src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" alt="LOGO">
                            @else
                            <img class="logo" src="{!! url('assets/images/company') !!}/logo.png" alt="LOGO">
                            @endif
                        </a>
                    </div>
                </div>
                <div id="navbar" class="navbar-collapse collapse" data-hover="dropdown">
                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{$userdata[0]->username}} <b class="fa fa-angle-down"></b>
                                @if($userdata[0]->photo != '')
                                    <img class="img-responsive display-ib mrgn-l-sm img-circle" src="{{url('/')}}/assets/images/admin/{{$userdata[0]->photo}}" width="64" height="64" alt="User-image">
                                @else
                                    <img class="img-responsive display-ib mrgn-l-sm img-circle" src="{{url('/')}}/assets/images/user-placeholder.jpg" width="64" height="64" alt="User-image">
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{!! url('admin/adminprofile') !!}"><i class="fa fa-fw fa-user"></i> {{ trans('app.EditProfile') }}</a></li>
                                <li><a href="{!! url('admin/adminpassword') !!}"><i class="fa fa-fw fa-cog"></i> {{ trans('app.ChangePassword') }} </a></li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ url('/admin/logout') }}">
                                        <i class="fa fa-fw fa-power-off"></i> {{ trans('app.Logout') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>
    </header>
    <div class="prtm-main">
        <div class="prtm-sidebar">
            <div class="prtm-sidebar-back"> </div>
            <div class="prtm-sidebar-nav-wrapper">
                <div class="prtm-sidebar-menu">
                   <nav class="sidebar-nav collapse">
                        <ul class="list-unstyled sidebar-menu">
                            @foreach($storemenus as $storemenu)
                            <li>
                                <a href="{!! url('admin') !!}/{{$storemenu->path}}"><i class="fa fa-fw {{$storemenu->menuicon}}"></i> {{trans('app.'.$storemenu->name)}}</a>
                            </li>   
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</div>

<script>
    var baseUrl = '{!! url('/') !!}';
    var ValidEmailError = '{{ trans("app.ValidEmailError") }}';
    var AlreadyExist = '{{ trans("app.AlreadyExist") }}';
    var PasswordNoMatch = '{{ trans("app.PasswordNoMatch") }}';
    var CurrentPassIncorrect = '{{ trans("app.CurrentPassIncorrect") }}';
    var DeleteConfirmation = '{{ trans("app.DeleteConfirmation") }}';
    var langDirection = '{{get_language_direction()}}';
    var MinTwoDecimalPlaces = '{{ trans("app.MinTwoDecimalPlaces") }}';
    var EnddateGreaterFromdate = '{{ trans("app.EnddateGreaterFromdate") }}';
    var CategoryNotDeleteMsg = '{{ trans("app.CategoryNotDeleteMsg") }}';
    var CategoryStatusNotChangeMsg = '{{ trans("app.CategoryStatusNotChangeMsg") }}';
    var SelectSubCategory = '{{ trans("app.SelectSubCategory") }}';
</script>
<!-- jQuery -->
<script src="{{ URL::asset('assets/js/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.smooth-scroll.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-tagsinput.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-datepicker.min.js')}}"></script>

<script src="{{ URL::asset('assets/js/olddatatable.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/fastclick.js')}}"></script>
<script src="{{ URL::asset('assets/js/fastselect.standalone.js')}}"></script>
<!-- Switchery -->
<script src="{{ URL::asset('assets/js/bootstrap-toggle.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/plugin/nicEdit.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/admin-genius.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/Chart.min.js')}}"></script>
<!-- Validation -->

<script src="{{ URL::asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/additional-methods.min.js')}}"></script>

@if(app()->getLocale() != 'en')
    <script src="{{ URL::asset('assets/js/localization/messages_')}}{{app()->getLocale()}}.js"></script>
@endif

<script type="text/javascript">
    setTimeout(function() {
        $("#res .alert").hide('blind', {}, 500)
    },2000);
</script>

<script>

    function readURL(input)
    {
        if(input.files && input.files[0])
        {
            var reader = new FileReader();
            reader.onload = function(e)
            {
                $('#image_view').attr('src',e.target.result).width(200).height(190);
            };
            reader.readAsDataURL(input.files[0]);
        }
        $('.loadDiv').css('display','none');
    }

    $("#maincats").change(function () {
        $("#subs").html('<option value="">'+SelectSubCategory+'</option>');
        $("#subs").attr('disabled',true);
        $("#childs").html('<option value="">'+SelectSubCategory+'</option>');
        $("#childs").attr('disabled',true);
        var mainid = $(this).val();

        $.get('{{url('/')}}/subcats/'+mainid, function(response){

            if(response)
            {
                $('.subcat_btn').css('display','none');
                $('#subs').css('display','block');

                $("#subs").attr('disabled',false);
                $.each(response, function(i, cart){
                    $.each(cart, function (index, data) {

                        $("#subs").append('<option value="'+data.id+'">'+data.name+'</option>');

                    })
                })
            }
            else
            {
                $('.subcat_btn').css('display','block');
                $('#subs').css('display','none');
                $('input[name="mainid"]').val(mainid);
            }
        });
    });

    $("#subs").change(function () {
        $("#childs").html('<option value="">'+SelectSubCategory+'</option>');
        $("#childs").attr('disabled',true);
     
        var mainid = $(this).val();
        $.get('{{url('/')}}/childcats/'+mainid, function(response){
          
            if(response)
            {
                $('.childcat_btn').css('display','none');
                $('#childs').css('display','block');

                $("#childs").attr('disabled',false);
                $.each(response, function(i, cart){
                    $.each(cart, function (index, data) {
                        $("#childs").append('<option value="'+data.id+'">'+data.name+'</option>');
                        //console.log('index', data)
                    })
                })
            }
            else
            {
                console.log('innn else');
                $('.childcat_btn').css('display','block');
                $('#childs').css('display','none');
                $('input[name="mainid"]').val(mainid);

            }
        });
    });

    if(langDirection == 'right')
    {
        var orientationval = "right";
    }
    else
    {
        var orientationval = "left";
    }

    $(".datepicker").datepicker({ 
        autoclose: true, 
        startDate: "today",
        format: 'dd/mm/yyyy',
        orientation: orientationval
    });

</script>

@yield('footer')

</body>
</html>

