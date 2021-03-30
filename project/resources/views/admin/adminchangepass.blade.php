@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{ trans('app.ChangePassword') }}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{ trans('app.Home') }}</a></li>
                    <li class="breadcrumb-item">{{ trans('app.ChangePassword') }}</li>
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
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('error') }}
                            </div>
                        @endif

                    </div>
                    <form method="POST" action="{{url('admin/adminpassword/change')}}/{{$admin->id}}" class="form-horizontal form-label-left" id="changepass_form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$admin->id}}">
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('app.CurrentPassword') }}<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="cpass" placeholder="{{ trans('app.CurrentPassword') }}" type="password">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug"> {{ trans('app.NewPassword') }} <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="newpass" id="newpass" placeholder="{{ trans('app.NewPassword') }}" type="password">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> {{ trans('app.ReTypeNewPassword') }} <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="renewpass" placeholder="{{ trans('app.ReTypeNewPassword') }}" type="password">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button id="update_pass" type="submit" class="btn btn-success">{{ trans('app.ChangePassword') }}</button>
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

    $(document).ready(function(){

        var id = $('input[name="id"]').val();

        $('#changepass_form').validate({
            rules:{
                cpass:{
                    required:true,
                    remote: {
                        type: 'post',
                        url: "{{ URL('admin/old_password') }}",
                        async: false,
                        async:false,
                        data: {
                            cpass: function () 
                            {
                                return $("input[name='cpass']").val();
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
                newpass:{
                    required:true,
                    minlength: 6,
                    maxlength: 12,
                },
                renewpass:{
                    required:true,
                    equalTo:"#newpass",
                }
            },
            messages:{
                cpass:{
                    remote: CurrentPassIncorrect,
                },
                renewpass:{
                    equalTo: PasswordNoMatch
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