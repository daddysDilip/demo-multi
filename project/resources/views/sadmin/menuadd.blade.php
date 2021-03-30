@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Menu Section</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/menus') !!}">Menu Section</a></li>
                    <li class="breadcrumb-item">Manage Menu</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{!! action('Sadmin\MenusController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="cms_form">
                        {{csrf_field()}}

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Menu Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Enter Menu Name" type="text" maxlength="30" minlength="3">
                            </div>
                        </div>
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Path<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="path" class="form-control col-md-7 col-xs-12" name="path" placeholder="Enter Menu Path" type="text" maxlength="50" minlength="3">
                            </div>
                        </div>
                       
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Icon
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input id="menuicon" class="form-control col-md-7 col-xs-12" name="menuicon" placeholder="Enter Menu icon class" type="text" maxlength="80" minlength="3">

                            </div>
                        </div>
						
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Menu Order
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input id="menuorder" class="form-control col-md-7 col-xs-12" name="menuorder" placeholder="Enter Menu Order" type="text" maxlength="50" minlength="0">

                            </div>
                        </div>
						
						
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Add New Page</button>
                                <a href="{!! url('sadmin/menus') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')
<script type="text/javascript">

    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('content1');
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){

        $('#cms_form').validate({
            rules:{
                title:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
			
                },
				path:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
				
                }
				
            },
            messages:{
                name:{
                    remote:"Already exist",
                }
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
@stop