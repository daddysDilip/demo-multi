@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Payment</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/payment') !!}">Payment</a></li>
                    <li class="breadcrumb-item">Manage Payment</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('sadmin/payment')}}/{{$payment->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="payment_form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$payment->id}}">
                        <input type="hidden" name="_method" value="PATCH">

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paymentname">Name<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="paymentname" class="form-control col-md-7 col-xs-12" name="paymentname" placeholder="Enter Payment Name" type="text" maxlength="30" minlength="3" value="{{$payment->paymentname}}">
                            </div>
                        </div>
                        
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paymenttype">Type<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="paymenttype" class="form-control col-md-7 col-xs-12" name="paymenttype" placeholder="Enter Payment Type" type="text" maxlength="30" minlength="3" value="{{$payment->paymenttype}}">
                            </div>
                        </div>
                        <div class="loadDiv"> 
                            @if($payment->image != '')
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> Current Image</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <img src="{!! url('/') !!}/assets/images/payment/{{$payment->image}}" style="max-height: 150px;width: 20%;" alt="No Payment Image">
                                    <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> Delete Payment Image</a>
                                </div>
                            </div>
                            @endif
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($payment->image != '')Change Image @else Image @endif
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="file" accept="image/*" name="image">
                                </div>
                            </div>
                        </div>
                        
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                @if($payment->status == 1)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                                @elseif($payment->status == 0)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
                                @endif
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update Payment</button>
                                <a href="{!! url('sadmin/payment') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

    var id = $('input[name="id"]').val();

    $(document).ready(function(){

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param) 
        }, "File must be less than 2MB");

        jQuery.validator.addMethod("lettersonly", function(value, element) 
        {
            return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "Please enter only letter"); 

        $('#payment_form').validate({
            rules:{
                paymentname:{
                    required:true,
                    lettersonly:true,
                    minlength: 3,
                    maxlength: 30,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/payment_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            paymentname: function () 
                            {
                                return $("input[name='paymentname']").val();
                            },
                            id: function () 
                            {
                                return id;
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
            
                },
                paymenttype:{
                    required:true,
                    lettersonly:true,
                    maxlength: 30,
                    minlength: 3,
            
                },
                image:{
                    extension: "jpg|jpeg|png",
                    filesize: 2097152
                },
            },
            messages:{
                paymentname:{
                    remote:"Already exist",
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

    $('.delete_img').click(function(){
        $.ajax({
            url: "{{ URL('sadmin/delete/paymentimage') }}/"+id,
            type: "get",
            async: false,
            data: {},
            success: function(data)
            {
                $('.loadDiv').load(' .loadDiv');
            },
        });
    });

</script>
@stop