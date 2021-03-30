@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Shipping</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/shipping') !!}">Shipping</a></li>
                    <li class="breadcrumb-item">Manage Shipping</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{!! action('Sadmin\ShippingMethodController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="shipping_form">
                        {{csrf_field()}}

						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="shippingtype">Type<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="shippingtype" class="form-control col-md-7 col-xs-12" name="shippingtype" placeholder="Enter Shipping Type" type="text" maxlength="30" minlength="3">
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
                                <button type="submit" class="btn btn-success">Add New Shipping</button>
                                <a href="{!! url('sadmin/shipping') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

        jQuery.validator.addMethod("lettersonly", function(value, element) 
        {
            return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "Please enter only letters"); 

        $('#shipping_form').validate({
            rules:{
                shippingtype:{
                    required:true,
                    lettersonly:true,
                    minlength: 3,
                    maxlength: 30,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/existshipping') }}",
                        async: false,
                        async:false,
                        data: {
                            shippingtype: function () 
                            {
                                return $("input[name='shippingtype']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },
                        async:false
                    }
                },
            },
            messages:{
                shippingtype:{
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