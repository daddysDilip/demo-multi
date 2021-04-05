@extends('sadmin.includes.master-sadmin2')

@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>State</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="{!! url('sadmin/state') !!}">State</a></li>
        <li class="breadcrumb-item active">Manage State</li>
      </ul>
    </div>
  </div>
</div>
<div class="container-fluid">
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
      <form method="POST" action="{{url('sadmin/state')}}/{{$state->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="state_form">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$state->id}}">
        <input type="hidden" name="_method" value="PATCH">
        <div class="row clearfix">
          <div class="col-lg-12">
            <div class="card">
              <div class="body">
                <div class="prtm-block min-height-505">
                  <div class="form-horizontal"> 
                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Country<span class="required">*</span></label>
                      </div>

                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <select class="form-control show-tick col-md-7 col-xs-12" name="countryid" id="countryid">
                            <option value="">Select Country</option>
                            @foreach($country as $countries)
                              @if($state->countryid == $countries->id)
                                <option value="{{$countries->id}}" selected="selected">{{$countries->countryname}}</option>
                              @else
                                <option value="{{$countries->id}}">{{$countries->countryname}}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">State Name<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="statename" class="form-control col-md-7 col-xs-12" name="statename" placeholder="Enter State Name" type="text" maxlength="25" minlength="3" value="{{$state->statename}}">
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="email_address_2">Is Active?</label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group ">
                          @if($state->status == 1)
                            <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                          @elseif($state->status == 0)
                            <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
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
                <a href="{!! url('sadmin/state') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
              </div>
            </div>
          </div>
        </div> 
      </form>      
    </div>
      <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
@stop

@section('footer')

<script type="text/javascript">
    $(document).ready(function(){

        $(':input').change(function() {
            $(this).val($(this).val().trim());
        });
        
        var id = $('input[name="id"]').val();

        jQuery.validator.addMethod("lettersonly", function(value, element) 
        {
        return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "Please enter valid state"); 

        $('#state_form').validate({
            rules:{
                countryid:{
                    required: true,  
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/state_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            countryid: function () 
                            {
                                return $("#countryid").val();
                            },
                            statename: function () 
                            {
                                return $("input[name='statename']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                    }
                },
                statename:{
                    required: true,
                    maxlength: 25,
                    minlength:2,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/state_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            statename: function () 
                            {
                                return $("input[name='statename']").val();
                            },
                            countryid: function () 
                            {
                                return $("#countryid").val();
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
            },
            messages:{
                countryid:{
                    remote:"",
                },
                statename:{
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