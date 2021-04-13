@extends('sadmin.includes.master-sadmin2')

@section('content')

<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>Country</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="{!! url('sadmin/country') !!}">Country</a></li>
        <li class="breadcrumb-item active">Manage Country</li>
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
      <form method="POST" action="{{url('sadmin/country')}}/{{$country->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="country_form">
        {{csrf_field()}}
        <div class="row clearfix">
          <div class="col-lg-12">
            <div class="card">
              <div class="body">
                <div class="prtm-block min-height-505">
                  <div class="form-horizontal">    
                    <input type="hidden" name="id" value="{{$country->id}}">
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="row clearfix">
                      <input type="hidden" name="domainname" value="{{get_subdomain()}}">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="email_address_2">Country Name<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                            <input id="countryname" class="form-control" name="countryname" placeholder="Enter Country Name" type="text" maxlength="30" minlength="3" value="{{$country->countryname}}">
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <input type="hidden" name="domainname" value="{{get_subdomain()}}">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="email_address_2">Short Name<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="sortname" class="form-control" name="sortname" placeholder="Enter Country Sort Name" type="text" maxlength="3" minlength="2" value="{{$country->sortname}}">
                        </div>
                      </div>
                    </div>    

                    <div class="row clearfix">
                      <input type="hidden" name="domainname" value="{{get_subdomain()}}">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="email_address_2">Phone Code<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="phonecode" class="form-control" name="phonecode" placeholder="Enter Phone Code" type="phonecode" maxlength="5" minlength="2" value="{{$country->phonecode}}" onkeypress="return isNumber(event)">
                        </div>
                      </div>
                    </div>    
                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="email_address_2">Is Active?</label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group ">
                          @if($country->status == 1)
                          <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                          @elseif($country->status == 0)
                          <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive" checked>
                          @endif
                          
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
              <a href="{!! url('sadmin/country') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(document).ready(function(){

        $(':input').change(function() {
            $(this).val($(this).val().trim());
        });
        
        var id = $('input[name="id"]').val();

        jQuery.validator.addMethod("lettersonly", function(value, element) 
        {
            return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "Please enter valid country"); 

        $('#country_form').validate({
            rules:{
                countryname:{
                    required: true,
                    maxlength: 15,
                    minlength:2,
                    lettersonly:true,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/country_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            countryname: function () 
                            {
                                return $("input[name='countryname']").val();
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
                sortname:{
                    maxlength: 3,
                    minlength:2,
                    lettersonly:true,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/sortname_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            sortname: function () 
                            {
                                return $("input[name='sortname']").val();
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
                phonecode:{
                    number: true,
                    minlength: 2,
                    maxlength: 5,
                }
            },
            messages:{
                countryname:{
                    remote:"Already exist",
                },
                sortname:{
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