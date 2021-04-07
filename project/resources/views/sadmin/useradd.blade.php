@extends('sadmin.includes.master-sadmin2')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>User</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="{!! url('sadmin/user') !!}">User</a></li>
        <li class="breadcrumb-item active">Manage User</li>
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
      <form method="POST" action="{!! action('Sadmin\UserController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="user_form">
              {{csrf_field()}}
        <div class="row clearfix">
          <div class="col-lg-12">
            <div class="card">
              <div class="body">
                <div class="prtm-block min-height-505">
                  <div class="form-horizontal"> 

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Name<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Enter Name" type="text" maxlength="30" minlength="3">
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Email<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="Enter Email Address" type="email" maxlength="50" minlength="3">
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Phone<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="phone" class="form-control col-md-7 col-xs-12" name="phone" placeholder="Enter Phone Number" type="text" maxlength="15" minlength="10" onkeypress="return isNumber(event)" >
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Role<span class="required">*</span></label>
                      </div>
                      <div class="col-md-5 col-sm-6 col-xs-5">
                        <select class="form-control" name="role" id="role">
                          <option value="">Select Role</option>
                          @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->role}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="photo">Profile Photo<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-5 col-md-6 col-sm-5">
                        <div class="form-group">
                          <input type="file" class="form-control" id="photo" name="photo" accept="image/*" />
                        </div>
                      </div>
                    </div>
                    
                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Password<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="password" class="form-control col-md-7 col-xs-12" name="password" placeholder="Enter Your Password" type="password" maxlength="20" minlength="8">
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
                  <a href="{!! url('sadmin/user') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('content1');
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

        $('#user_form').validate({
            rules:{
                name:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
			
                },
				password:{
                    required:true,
                    minlength: 6,
                    maxlength: 12,
				},
				phone:{
					required:true,
					minlength: 10,
                    maxlength: 15,			
				},
				role:{
					required:true,				
				},
				email:{
                    required:true,
                    email:true,
                    minlength: 3,
                    maxlength: 30,
					remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/existuseremail') }}",
                        async: false,
                        async:false,
                        data: {
                            email: function () 
                            {
                                return $("input[name='email']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                }
            },
            messages:{
                email:{
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