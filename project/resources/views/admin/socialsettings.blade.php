@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.SocialLinks')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.SocialLinks')}}</li>
                </ul>
            </div>

            
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
                    <form method="POST" action="{{url('admin/social')}}/{{$social[0]->id}}" class="form-horizontal form-label-left" id="social_form">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> {{trans('app.Facebook')}} <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="facebook" type="text" value="{{$social[0]->facebook}}" maxlength="100">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                @if($social[0]->f_status == "enable")
                                    <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="f_status" value="enable" data-off="{{trans('app.Disabled')}}" checked>
                                @else
                                    <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="f_status" value="enable" data-off="{{trans('app.Disabled')}}">
                                @endif
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="g_plus">{{trans('app.GooglePlus')}}<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="g_plus" type="text" value="{{$social[0]->g_plus}}" maxlength="100">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                @if($social[0]->g_status == "enable")
                                    <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="g_status" value="enable" data-off="{{trans('app.Disabled')}}" checked>
                                @else
                                    <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="g_status" value="enable" data-off="{{trans('app.Disabled')}}">
                                @endif
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twiter"> {{trans('app.Twiter')}} <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="twiter" type="text" value="{{$social[0]->twiter}}" maxlength="100">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                @if($social[0]->t_status == "enable")
                                    <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="t_status" value="enable" data-off="{{trans('app.Disabled')}}" checked>
                                @else
                                    <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="t_status" value="enable" data-off="{{trans('app.Disabled')}}">
                                @endif
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rss_feed"> {{trans('app.Linkedin')}} <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="linkedin" type="text" value="{{$social[0]->linkedin}}" maxlength="100">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                @if($social[0]->link_status == "enable")
                                    <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="link_status" value="enable" data-off="{{trans('app.Disabled')}}" checked>
                                @else
                                    <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="link_status" value="enable" data-off="{{trans('app.Disabled')}}">
                                @endif
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
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

        if($('input[name="f_status"]').is(':checked'))
        {
            $('input[name="facebook"]').addClass('facebook_url');
        }
        else
        {
            $('input[name="facebook"]').removeClass('facebook_url');
        }

        $('input[name="f_status"]').change(function () {
            if (this.checked) 
                $('input[name="facebook"]').addClass('facebook_url');
            else 
                $('input[name="facebook"]').removeClass('facebook_url');
        });

        if($('input[name="g_status"]').is(':checked'))
        {
            $('input[name="g_plus"]').addClass('g_plus_url');
        }
        else
        {
            $('input[name="g_plus"]').removeClass('g_plus_url');
        }

        $('input[name="g_status"]').change(function () {
            if (this.checked) 
                $('input[name="g_plus"]').addClass('g_plus_url');
            else 
                $('input[name="g_plus"]').removeClass('g_plus_url');
        });

        if($('input[name="t_status"]').is(':checked'))
        {
            $('input[name="twiter"]').addClass('twiter_url');
        }
        else
        {
            $('input[name="twiter"]').removeClass('twiter_url');
        }

        $('input[name="t_status"]').change(function () {
            if (this.checked) 
                $('input[name="twiter"]').addClass('twiter_url');
            else 
                $('input[name="twiter"]').removeClass('twiter_url');
        });

        if($('input[name="link_status"]').is(':checked'))
        {
            $('input[name="linkedin"]').addClass('linkedin_url');
        }
        else
        {
            $('input[name="linkedin"]').removeClass('linkedin_url');
        }
        
        $('input[name="link_status"]').change(function () {
            if (this.checked) 
                $('input[name="linkedin"]').addClass('linkedin_url');
            else 
                $('input[name="linkedin"]').removeClass('linkedin_url');
        });

        jQuery.validator.addClassRules("facebook_url", {
            required: true,
            url: true,
        });

        jQuery.validator.addClassRules("g_plus_url", {
            required: true,
            url: true,
        });

        jQuery.validator.addClassRules("twiter_url", {
            required: true,
            url: true,
        });

        jQuery.validator.addClassRules("linkedin_url", {
            required: true,
            url: true,
        });

        $('#social_form').validate({
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