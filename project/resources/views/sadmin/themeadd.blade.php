@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Theme</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/themes') !!}">Theme</a></li>
                    <li class="breadcrumb-item">Manage Theme</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{!! action('Sadmin\ThemeController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="theme_form">
                        {{csrf_field()}}

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="themename">Name<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="themename" class="form-control col-md-7 col-xs-12" name="themename" placeholder="Enter Theme Name" type="text" maxlength="30" minlength="3">
                            </div>
                        </div>
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="themeurl">Url<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="themeurl" class="form-control col-md-7 col-xs-12" name="themeurl" placeholder="Enter Theme Url" type="text" maxlength="100" minlength="3">
                            </div>
                        </div>
                       
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="themecontent">Content
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea rows="10" class="form-control post-content" name="themecontent" id="themecontent" placeholder="Enter Content"></textarea>

                            </div>
                        </div>
                        
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Paid?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" data-toggle="toggle" data-on="Yes" name="paid" value="1" data-off="No" checked>
                            </div>
                        </div>
						
						<div class="item form-group ThemePrice">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="themeprice">Price<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="themeprice" class="form-control col-md-7 col-xs-12" name="themeprice" placeholder="Enter Theme Price" type="text" maxlength="10" minlength="0" onkeypress="return isNumber(event)">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_limit">Select Paln
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                @foreach($plan as $allplan)
                                <input id="planid" name="planid[]" type="checkbox" value="{{$allplan->id}}"> {{$allplan->plantype}}
                                @endforeach
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="themeimage">Theme Image</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" accept="image/*" name="themeimage">
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Add New Theme</button>
                                <a href="{!! url('sadmin/themes') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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
        new nicEditor({fullPanel : true}).panelInstance('themecontent');
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(document).ready(function(){

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param) 
        }, "File must be less than 2MB");

        $('input[name="paid"]').change(function(){
            if ($(this).prop('checked')==true){ 
                $('.ThemePrice').show();
                $('#themeprice').attr('name','themeprice');
            }
            else
            {
                $('.ThemePrice').hide();
                $('#themeprice').removeAttr('name','themeprice');
            }
        });

        $('#theme_form').validate({
            rules:{
                themename:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/theme_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            themename: function () 
                            {
                                return $("input[name='themename']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                        //delay: 1000
                    }
			
                },
                themeurl:{
                    required:true,
                    url:true,
                    maxlength: 100,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/themeurl_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            themeurl: function () 
                            {
                                return $("input[name='themeurl']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                        //delay: 1000
                    }
            
                },
                themeimage:{
                    extension: "jpg|jpeg|png",
                    filesize: 2097152
                },
                themeprice:
                {
                    required: true,
                    number:true,
                    maxlength:10,
                    min:1,
                },
            },
            messages:{
                themename:{
                    remote:"Already exist",
                },
                themeurl:{
                    remote:"Already exist",
                },
                themeprice:
                {
                    min: "Please enter valid price",
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