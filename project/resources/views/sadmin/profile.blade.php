@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Admin Profile</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Admin Profile</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response">
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    </div>
                    <form method="POST" action="{{url('sadmin/adminprofile')}}/{{$admin->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="admin_profile">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="item form-group">
                            <label style="margin-top: 90px;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Current Photo
                            </label>
                            <span class="col-md-2 col-sm-6 col-xs-12">
                            @if(Auth::user()->photo != '')
                                <img style="width: 120px; height: 120px;" src="{{url('/')}}/assets/images/admin/{{Auth::user()->photo}}" id="adminimg" class="img-circle profile_img" alt="Admin Photo">
                            @else
                                <img style="width: 120px; height: 120px;" src="{{url('/')}}/assets/images/user-placeholder.jpg" id="vendorimg" class="img-circle profile_img" alt="Admin Photo">
                            @endif
                            </span>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <input class="hidden" onchange="readURL(this)" id="uploadFile" name="photo" type="file" accept="image/*">
                                <div id="uploadTrigger" onclick="uploadclick()" style="margin-top: 90px;white-space: normal;" class="form-control btn btn-default"><i class="fa fa-upload"></i> Change Photo</div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> User Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="email" placeholder="Admin Email" value="{{Auth::user()->username}}" type="text" maxlength="50" minlength="3" readonly>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Email Address <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="email" placeholder="Admin Email" value="{{Auth::user()->email}}" type="text" maxlength="50" minlength="3" readonly>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Admin Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="name" placeholder="Admin Name" value="{{Auth::user()->name}}" type="text" maxlength="50" minlength="3">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Phone Number <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="phone" placeholder="Admin Phone Number" value="{{Auth::user()->phone}}" type="text" maxlength="10" minlength="10">
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update profile</button>
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

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#adminimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){

        $('#admin_profile').validate({
            rules:{
                name:{
                    required:true,
                    minlength: 3,
                    maxlength: 50
                },
                phone:{
                    required:true,
                    number:true,
                    minlength: 10,
                    maxlength: 10
                },
                photo:{
                    extension: "jpg|jpeg|png",
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