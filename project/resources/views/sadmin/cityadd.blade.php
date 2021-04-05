@extends('sadmin.includes.master-sadmin2')

@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>City</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="{!! url('sadmin/city') !!}">City</a></li>
        <li class="breadcrumb-item active">Manage City</li>
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
      <form method="POST" action="{!! action('Sadmin\CityController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="state_form">
        {{csrf_field()}}
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
                                <option value="{{$countries->id}}">{{$countries->countryname}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="stateid">State<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <select class="form-control show-tick col-md-7 col-xs-12" name="stateid" id="stateid">
                            <option value="">Select State</option>
                            
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="cityname">City Name<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="cityname" class="form-control col-md-7 col-xs-12" name="cityname" placeholder="Enter City Name" type="text" maxlength="25" minlength="3">
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
                <a href="{!! url('sadmin/city') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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
    <!-- /#page-wrapper -->
@stop

@section('footer')

<script type="text/javascript">
    $(document).ready(function(){
        $("#countryid").change(function () {
            var selectedText = $(this).find("option:selected").text();
            var selectedValue = $(this).val();
            alert("Selected Text: " + selectedText + " Value: " + selectedValue);
            $.ajax({
              url: "{{ URL('sadmin/get_state_dropdown') }}",
              data:{countryId:selectedValue,_token: "{{ csrf_token() }}"},
              type:"POST",
              success: function(res){
                // $("#results").append(html);
                console.log('------------->');
                console.log('------------->',res);
              }
            });
        });
        $(':input').change(function() {
            $(this).val($(this).val().trim());
        });

        jQuery.validator.addMethod("lettersonly", function(value, element) 
        {
        return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "Please enter valid city"); 

        $('#city_form').validate({
            rules:{
                stateid:{
                    required: true, 
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/city_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            stateid: function () 
                            {
                                return $("#stateid").val();
                            },
                            cityname: function () 
                            {
                                return $("input[name='cityname']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                },
                cityname:{
                    required: true,
                    maxlength: 25,
                    minlength:2,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/city_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            cityname: function () 
                            {
                                return $("input[name='cityname']").val();
                            },
                            stateid: function ()
                            {
                                return $( "#stateid" ).val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                },
            },
            messages:{
                stateid:{
                    remote:"",
                },
                cityname:{
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