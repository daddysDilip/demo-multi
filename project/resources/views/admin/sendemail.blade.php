@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.SendEmailCustomer')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.SendEmailCustomer')}}</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{!! action('CustomerController@sendemail',$subdomain_name) !!}" class="form-horizontal form-label-left" id="sendemail_form">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$customer->email}}" name="to">
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.To')}}<span class="required">*</span>

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{$customer->email}}" disabled type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Subject')}}<span class="required">*</span>

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="subject" type="text" minlength="3" maxlength="50">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.Message')}}<span class="required">*</span>

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="message" rows="10" class="form-control"  minlength="3" maxlength="255"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">{{trans('app.SendEmail')}}</button>
                                <a href="{!! url('admin/customers') !!}" class="btn btn-danger btn-add"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
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

        $('#sendemail_form').validate({
            rules:{
                subject:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                },
                message:{
                    required:true,
                    minlength: 3,
                    maxlength: 255,
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