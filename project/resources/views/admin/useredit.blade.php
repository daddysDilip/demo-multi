@extends('admin.includes.master-admin')
@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>User Section</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/cms') !!}">User Section</a></li>
                    <li class="breadcrumb-item">Manage User</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('admin/user')}}/{{$user->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="user_form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <input type="hidden" name="_method" value="PATCH">
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{$user->name}}" placeholder="Enter Name" type="text" maxlength="30" minlength="3">
                            </div>
                        </div>
						
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="email" class="form-control col-md-7 col-xs-12" name="email" value="{{$user->email}}"  placeholder="Enter Email Address" type="email" maxlength="50" minlength="3" disabled="disabled">
                            </div>
                        </div>
						
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Phone<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="phone" class="form-control col-md-7 col-xs-12" name="phone" value="{{$user->phone}}" placeholder="Enter Phone Number" type="text" maxlength="15" minlength="10" onkeypress="return isNumber(event)" >
                            </div>
                        </div>
						
						
						
						<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Role<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
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
					
						
                        <div class="loadDiv"> 
                            @if($user->photo != '')
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> profile photo</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <img src="{!! url('/') !!}/assets/images/admin/{{$user->photo}}" style="max-height: 250px;width: 50%;" alt="No Theme Image"><br>
                                    <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> Delete photo Image</a>
                                </div>
                            </div>
                            @endif                    
                            
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($user->photo != '')Change Theme Image @else Theme Image @endif
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" accept="image/*" name="photo">
                                </div>
                            </div>
                        </div>
                     
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($user->photo != '')Change Image @else Pofile Image @endif</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" accept="image/*" name="photo">
                            </div>
                        </div>







                    
<!--                         <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($user->photo != '')Change Image @else Pofile Image @endif</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" accept="image/*" name="photo">
                            </div>
                        </div>
 -->						
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                @if($user->status == 1)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                                @elseif($user->status == 0)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
                                @endif
                            </div>
                        </div>
                       
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update User</button>
                                <a href="{!! url('admin/user') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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
                        url: "{{ URL('admin/existuseremail') }}",
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
            url: "{{ URL('admin/delete/photo') }}/"+id,
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