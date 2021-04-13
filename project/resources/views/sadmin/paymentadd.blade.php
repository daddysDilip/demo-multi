@extends('sadmin.includes.master-sadmin2')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>Payment</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="{!! url('sadmin/payment') !!}">Payment</a></li>
        <li class="breadcrumb-item active">Manage Payment</li>
      </ul>
    </div>
  </div>
</div>
<div class="container-fluid">
    <!-- Page Content -->
  <div class="panel panel-default">
    <div class="panel-body">
      <div id="res">
          @if(Session::has('message'))
            <div class="alert alert-success alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('message') }}
            </div>
          @endif
      </div>
      <form method="POST" action="{!! action('Sadmin\PaymentMethodController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="payment_form">
        {{csrf_field()}}
        <div class="row clearfix">
          <div class="col-lg-12">
            <div class="card">
              <div class="body">
                <div class="prtm-block min-height-505">
                  <div class="form-horizontal">

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="paymentname">Name<span class="required">*</span><p class="small-label">(In Any Language)</p></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="paymentname" class="form-control col-md-7 col-xs-12" name="paymentname" placeholder="Enter Payment Name" type="text" maxlength="30" minlength="3">
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="paymenttype">Type<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="paymenttype" class="form-control col-md-7 col-xs-12" name="paymenttype" placeholder="Enter Payment Type" type="text" maxlength="30" minlength="3">
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="image">Image<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-5 col-md-6 col-sm-5">
                        <div class="form-group">
                          <input type="file" class="form-control" id="image" name="image" accept="image/*" />
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="email_address_2">Is Active?</label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group ">
                          <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
            </div>  
          </div>  
          <div class="ln_solid"></div>
            <div class="col-md-12 col-lg-12">
              <div class="card">
                <div class="body" style="float: right;">
                  <button type="submit" class="btn btn-success">Submit</button>
                  <a href="{!! url('sadmin/payment') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
                </div>
              </div>
            </div>   
        </div> 
      </form>				
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
</script>
@stop