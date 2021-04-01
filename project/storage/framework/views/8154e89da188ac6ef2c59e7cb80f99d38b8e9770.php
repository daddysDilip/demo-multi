<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="Estorewiz Admin Panel.">
    <meta name="author" content="Estorewiz">
    <link rel="icon" type="image/png" href="<?php echo e(url('/')); ?>/assets/images/<?php echo e($settings[0]->favicon); ?>" />

    <title><?php echo e($settings[0]->title); ?> - Super Admin Panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo e(URL::asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/bootstrap-toggle.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/bootstrap-tagsinput.css')); ?>" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/octicons/3.5.0/octicons.min.css" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/bootstrap-colorpicker.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/bootstrap-datepicker.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(URL::asset('assets/css/olddatatables.min.css')); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo e(URL::asset('assets/css/vendor.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/plugins.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/pratham.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/fastselect.css')); ?>" rel="stylesheet">
    <!-- <link href="<?php echo e(URL::asset('assets/css/genius-admin.css')); ?>" rel="stylesheet"> -->

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
    </style>

</head>
<body>

<div class="prtm-wrapper">
    <header class="prtm-header">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span><span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <button class="c-hamburger c-hamburger--htra prtm-bars pull-right"> <span>toggle menu</span> </button>
                    <div class="prtm-logo">
                        <a class="navbar-brand" href="<?php echo url('sadmin/dashboard'); ?>">
                            <img class="logo" src="<?php echo url('assets/images/company'); ?>/<?php echo e($settings[0]->logo); ?>" alt="LOGO">
                        </a>
                    </div>
                </div>
                <div id="navbar" class="navbar-collapse collapse" data-hover="dropdown">
                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><?php echo e(Auth::user()->name); ?> <b class="fa fa-angle-down"></b>
                                <?php if(Auth::user()->photo != ''): ?>
                                    <img class="img-responsive display-ib mrgn-l-sm img-circle" src="<?php echo e(url('/')); ?>/assets/images/admin/<?php echo e(Auth::user()->photo); ?>" width="64" height="64" alt="User-image">
                                <?php else: ?>
                                    <img class="img-responsive display-ib mrgn-l-sm img-circle" src="<?php echo e(url('/')); ?>/assets/images/user-placeholder.jpg" width="64" height="64" alt="User-image">
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo url('sadmin/adminprofile'); ?>"><i class="fa fa-fw fa-user"></i> Edit Profile</a></li>
                                <li><a href="<?php echo url('sadmin/adminpassword'); ?>"><i class="fa fa-fw fa-cog"></i> Change Password</a></li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo url('sadmin/logout'); ?>"><i class="fa fa-fw fa-power-off"></i>Logout</a>
                                    <!-- <a href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-fw fa-power-off"></i> Logout
                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo e(csrf_field()); ?>

                                    </form> -->
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
                            <?php $__currentLoopData = $adminmenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adminmenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo url('sadmin'); ?>/<?php echo e($adminmenu->path); ?>"><i class="fa fa-fw <?php echo e($adminmenu->menuicon); ?>"></i>  <?php echo e($adminmenu->name); ?></a>
                            </li>   
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </a>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<script>
    var baseUrl = '<?php echo url('/'); ?>';
</script>
<!-- jQuery -->
<script src="<?php echo e(URL::asset('assets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/jquery.smooth-scroll.js')); ?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo e(URL::asset('assets/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/dataTables.bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/bootstrap-tagsinput.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/bootstrap-colorpicker.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/bootstrap-datepicker.min.js')); ?>"></script>

<script src="<?php echo e(URL::asset('assets/js/olddatatable.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/fastclick.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/fastselect.standalone.js')); ?>"></script>
<!-- Switchery -->
<script src="<?php echo e(URL::asset('assets/js/bootstrap-toggle.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('assets/js/plugin/nicEdit.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('assets/js/admin-genius.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('assets/js/Chart.min.js')); ?>"></script>
<!-- Validation -->

<script src="<?php echo e(URL::asset('assets/js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/additional-methods.min.js')); ?>"></script>

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
        $.get('<?php echo e(url('/')); ?>/subcats/'+mainid, function(response){
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
        $.get('<?php echo e(url('/')); ?>/childcats/'+mainid, function(response){
            $("#childs").attr('disabled',false);
            $.each(response, function(i, cart){
                $.each(cart, function (index, data) {
                    $("#childs").append('<option value="'+data.id+'">'+data.name+'</option>');
                    //console.log('index', data)
                })
            })
        });
    });

    $(".datepicker").datepicker({ 
        autoclose: true, 
        startDate: "today",
    });


</script>
<?php echo $__env->yieldContent('footer'); ?>
</body>
</html>

<?php /**PATH D:\wamp\www\on_git\multi-ecomm\project\resources\views/sadmin/includes/master-sadmin.blade.php ENDPATH**/ ?>