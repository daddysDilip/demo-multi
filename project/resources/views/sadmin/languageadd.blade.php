@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>language</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/language') !!}">language</a></li>
                    <li class="breadcrumb-item">Manage language</li>
                </ul>
            </div>
            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{!! action('Sadmin\LanguageController@store',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="language_form">
                        {{csrf_field()}}

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Language Name<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Enter Blog Title" type="text" maxlength="50" minlength="3">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Flag Image<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" accept="image/*" name="image">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Language Code<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               
                               <input type="text" class="form-control col-md-7 col-xs-12" name="code" id="code" maxlength="10" minlength="3">

                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Direction </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="direction" class="form-control" id="direction">
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
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
                                <button type="submit" class="btn btn-success">Add New language</button>
                                <a href="{!! url('sadmin/language') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

    $('#language_form').validate({
        rules:{
            name:{
                required:true,
                minlength: 3,
                maxlength: 30,
                remote: {
                    type: 'post',
                    url: "{{ URL('sadmin/existlanguname') }}",
                    async: false,
                    async:false,
                    data: {
                        name: function () 
                        {
                            return $("input[name='name']").val();
                        },
                        "_token": "{{ csrf_token() }}"  
                    },

                    async:false
                   //delay: 1000
                }
            },
            code:{
                required:true,
                minlength: 2,
                maxlength: 5,
                remote: {
                    type: 'post',
                    url: "{{ URL('sadmin/codelanguname') }}",
                    async: false,
                    async:false,
                    data: {
                        code: function () 
                        {
                            return $("input[name='code']").val();
                        },
                        "_token": "{{ csrf_token() }}"  
                    },

                    async:false
                   //delay: 1000
                }
            },
            image:{
                required:true,
               
            }
        },
        messages:{
            name:{
                remote:"Already exist",
            },
            code:{
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