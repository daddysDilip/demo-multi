@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Slider</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/sliders') !!}">Slider</a></li>
                    <li class="breadcrumb-item">Manage Slider</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{!! action('Sadmin\SliderController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="slider_form">
                        {{csrf_field()}}
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Slider Image<span class="required">*</span>

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" accept="image/*" name="image" required>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Slider Title
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="title" placeholder="e.g Sports" type="text" maxlength="30" minlength="3">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Slider Text
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="text" id="content" class="form-control" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Slider Text Position<span class="required">*</span>

                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <select name="text_position" class="form-control">
                                    <option value="slide_style_left">Left</option>
                                    <option value="slide_style_center">Center</option>
                                    <option value="slide_style_right">Right</option>
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Add Slider</button>
                                <a href="{!! url('sadmin/sliders') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')

<script type="text/javascript">

bkLib.onDomLoaded(function() {
    new nicEditor({fullPanel : true}).panelInstance('content');
});
    
$(document).ready(function(){

    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param) 
    }, "File must be less than 2MB");
    
    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $('#slider_form').validate({
        rules:{
            image:{
                required: true,
                extension: "jpg|jpeg|png",
                filesize: 2097152
            },
            title:{
                minlength: 3,
                maxlength: 30,
            },
            text:{
                minlength: 3,
                maxlength: 100,
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