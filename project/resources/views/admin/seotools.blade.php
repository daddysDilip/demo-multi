@extends('admin.includes.master-admin')

@section('content')

<style type="text/css">
    textarea
    {
        resize: none;
    }
</style>

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.SEOSettings')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.SEOSettings')}}</li>
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
                    <!-- /.start -->
                    <div class="col-md-12">
                        <ul class="nav nav-tabs tabs-left">
                            <li class="active"><a href="#analytics" data-toggle="tab" aria-expanded="true">{{trans('app.GoogleAnalytics')}}</a>
                            <li><a href="#metatags" data-toggle="tab" aria-expanded="false">{{trans('app.WebsiteMetaKeywords')}}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xs-9">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="analytics">
                                <br>
                                <div class="ln_solid"></div>
                                <form method="POST" action="{{url('admin/tools')}}/{{$tools[0]->id}}" class="form-horizontal form-label-left" novalidate id="ganalytics_form">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="PATCH">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="google_script"> {{trans('app.GoogleAnalyticsScript')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <textarea rows="10" class="form-control" name="google_analytics">{{$tools[0]->google_analytics}}</textarea>
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
                            <div class="tab-pane" id="metatags">
                                <br>
                                <div class="ln_solid"></div>
                                <form method="POST" action="{{url('admin/tools')}}/{{$tools[0]->id}}" id="meta_form" class="form-horizontal form-label-left" novalidate>
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="PATCH">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_keys"> {{trans('app.WebsiteMetaKeywords')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <textarea rows="10" class="form-control" name="meta_keys" minlength="3" maxlength="255">{{$tools[0]->meta_keys}}</textarea>
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
                <!-- /.end -->
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

        $('#ganalytics_form').validate({
            rules:{
                google_analytics:{
                    required:true,
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

         $('#meta_form').validate({
            rules:{
                meta_keys:{
                    required:true,
                    maxlength:3,
                    maxlength:255
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