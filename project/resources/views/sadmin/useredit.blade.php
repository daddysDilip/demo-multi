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
      <form method="POST" action="{{url('sadmin/user')}}/{{$user->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="user_form">
        {{csrf_field()}}

        <input type="hidden" name="id" value="{{$user->id}}">
        <input type="hidden" name="_method" value="PATCH">
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
                          <input id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{$user->name}}" placeholder="Enter Name" type="text" maxlength="30" minlength="3">
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
                          <input id="email" class="form-control col-md-7 col-xs-12" name="email" value="{{$user->email}}"  placeholder="Enter Email Address" type="email" maxlength="50" minlength="3" disabled="disabled">
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
                          <input id="phone" class="form-control col-md-7 col-xs-12" name="phone" value="{{$user->phone}}" placeholder="Enter Phone Number" type="text" maxlength="15" minlength="10" onkeypress="return isNumber(event)" >
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
                            @if($user->role == $role->id)
                              <option value="{{$role->id}}" selected>{{$role->role}}</option>
                            @else
                              <option value="{{$role->id}}">{{$role->role}}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
						
						        {{-- <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="photo">Profile Photo<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-5 col-md-6 col-sm-5">
                        <div class="form-group">
                          <input type="file" class="form-control" id="photo" name="photo" accept="image/*" />
                        </div>
                      </div>
                    </div> --}}
						
					
						
                    {{-- <div class="row clearfix"> --}}
                    <div class="item form-group">
                      @if($user->photo != '')
                      <input type="hidden" name="_method" value="PATCH">
                      <div class="row clearfix">
                        <label class="col-lg-3 col-md-3 col-sm-4 form-control-label"> Profile Photo</label>
                          <div class="col-lg-5 col-md-6 col-sm-5">
                            <img src="{!! url('/') !!}/assets/images/admin/{{$user->photo}}" style="max-height: 250px;width: 50%;" alt="No Theme Image"><br>
                            <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> Delete photo Image</a>
                          </div>
                     </div>
                      @endif    
                        <div class="item form-group">
                           <div class="row clearfix">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($user->photo != '')Change Image @else Pofile Image @endif</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" accept="image/*" name="photo">

                            </div>
                        </div>     
                    </div>
                  </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="email_address_2">Is Active?</label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group ">
                          @if($user->status == 1)
                          <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                          @elseif($user->status == 0)
                          <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive" >
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

    var id = $('input[name="id"]').val();

    $(document).ready(function(){

        $('#user_form').validate({
            rules:{
                name:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
			
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
                            id: function ()
                            {
                                return id;
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



        $('.delete_img').click(function(){
        $.ajax({
            url: "{{ URL('sadmin/delete/photo') }}/"+id,
            type: "get",
            async: false,
            data: {"_token": "{{ csrf_token() }}"},
            success: function(data)
            {
                $('.loadDiv').load(' .loadDiv');
            },
        });
    });
</script>
@stop