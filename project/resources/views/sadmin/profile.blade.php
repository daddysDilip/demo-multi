@extends('sadmin.includes.master-sadmin2')

@section('content')
<style type="text/css">
    .hidden {
    display: none!important;
}
</style>
<link rel="stylesheet" href="{{ URL::asset('assets/sadmin2/plugins/dropzone/dropzone.css')}}">

    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Admin Profile </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Admin Profile</li>
                </ul>
            </div>
        </div>
    </div>
        <div class="container-fluid">
            <!-- <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Admin Profile</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Admin Profile</li>
                </ul>
            </div>
 -->
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
                    <div class="card">
                        <div class="header">
                            <h2><strong>Admin</strong> Profile </h2>
                            <div class="prtm-block-title mrgn-b-lg">
                            </div>
                            
                        </div>
                        <div class="body">
                            <form method="POST" action="{{url('sadmin/adminprofile')}}/{{$admin->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="admin_profile">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="PATCH">
                            <div class="card member-card">
                                <div class="header l-cyan">
                                    <h4 class="m-t-10">{{Auth::user()->name}}</h4>
                                </div>
                                <div class="member-img">
                                    <a  class="">
                                        <input class="hidden" onchange="readURL(this)" id="uploadFile" name="photo" type="file" accept="image/*">
                                        @if(Auth::user()->photo != '')
                                            <img src="{{url('/')}}/assets/images/admin/{{Auth::user()->photo}}" id="adminimg" class="rounded-circle profile_img" alt="profile-image" onclick="uploadclick()">
                                        @else
                                            <img src="{{url('/')}}/assets/images/user-placeholder.jpg" id="adminimg" class="rounded-circle profile_img" alt="profile-image" onclick="uploadclick()">
                                        @endif

                                    </a>
                                </div>
                                <div class="body">
                                    <!-- <div class="col-12">
                                        <ul class="social-links list-unstyled">
                                            <li><a title="facebook" href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                                            <li><a title="twitter" href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                                            <li><a title="instagram" href="#"><i class="zmdi zmdi-instagram"></i></a></li>
                                        </ul>
                                        <p class="text-muted">795 Folsom Ave, Suite 600 San Francisco, CADGE 94107</p>
                                    </div> -->
                                    <hr>
                                    <div class="row">
                                        <div class="col-3">
                                            <input class="form-control col-xs-12" name="email" placeholder="Admin Email" value="{{Auth::user()->username}}" type="text" maxlength="50" minlength="3" readonly>
                                            <small>User Name</small>
                                        </div>
                                        <div class="col-3">
                                            <!-- <h5>{{Auth::user()->email}}</h5> -->
                                            <input class="form-control col-xs-12" name="email" placeholder="Admin Email" value="{{Auth::user()->email}}" type="text" maxlength="50" minlength="3" readonly>
                                            <small>Email Address</small>
                                        </div>
                                        <div class="col-3">
                                            <!-- <h5>{{Auth::user()->name}}</h5> -->
                                            <input class="form-control  col-xs-12" name="name" placeholder="Admin Name" value="{{Auth::user()->name}}" type="text" maxlength="50" minlength="3">
                                            <small>Admin Name</small>
                                        </div> 
                                        <div class="col-3">
                                            <!-- <h5>{{Auth::user()->phone}}</h5> -->
                                            <input class="form-control col-xs-12" name="phone" placeholder="Admin Phone Number" value="{{Auth::user()->phone}}" type="text" maxlength="10" minlength="10">
                                            <small>Phone Number</small>
                                        </div>                            
                                    </div>
                                    <div class="ln_solid"></div>
                                    
                                        <div class="col-md-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-success">Update profile</button>
                                        </div>
                                    
                                </div>
                            </div>
                        </form>
                            <!-- <form method="POST" action="{{url('sadmin/adminprofile')}}/{{$admin->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="admin_profile">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="PATCH">
                                <div class="item form-group">
                                    <label style="margin-top: 90px;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Current Photo
                                    </label>
                                    <span class="col-md-2 col-sm-6 col-xs-12 col-lg-2">
                                    @if(Auth::user()->photo != '')
                                        <img style="width: 120px; height: 120px;" src="{{url('/')}}/assets/images/admin/{{Auth::user()->photo}}" id="adminimg" class="img-circle profile_img" alt="Admin Photo">
                                    @else
                                        <img style="width: 120px; height: 120px;" src="{{url('/')}}/assets/images/user-placeholder.jpg" id="vendorimg" class="img-circle profile_img" alt="Admin Photo">
                                    @endif
                                    </span>
                                    <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
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
                            </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    
    <!-- /#page-wrapper -->
@stop

@section('footer')
<script src="{{ URL::asset('assets/sadmin2/plugins/dropzone/dropzone.js')}}"></script>

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

    function uploadclick(){
    $("#uploadFile").click();
    $("#uploadFile").change(function(event) {
        $("#uploadTrigger").html($("#uploadFile").val());
    });
}

</script>



@stop