@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.BuyTheme')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/themes') !!}">{{trans('app.Themes')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.BuyTheme')}}</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('admin/themesettings')}}/{{$theme->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="theme_form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$theme->id}}">
                        <input type="hidden" name="_method" value="PATCH">
						
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment">{{trans('app.Price')}}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="payment" class="form-control col-md-7 col-xs-12" name="payment" type="text" maxlength="30" minlength="3" value="{{$theme->themeprice}}" readonly="readonly">
                            </div>
                        </div>
                        
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.Payment')}}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" data-toggle="toggle" data-on="Yes" name="paid" value="1" data-off="No" checked>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                <a href="{!! url('admin/themesettings') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
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

    var id = $('input[name="id"]').val();

    $(document).ready(function(){

        $('#theme_form').validate({
            rules:{
                themename:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/theme_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            themename: function () 
                            {
                                return $("input[name='themename']").val();
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
                themeurl:{
                    required:true,
                    url:true,
                    maxlength: 100,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/themeurl_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            themeurl: function () 
                            {
                                return $("input[name='themeurl']").val();
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
                themepricee:
                {
                    required: true,
                    number:true,
                    maxlength:10,
                    min:0
                },
            },
            messages:{
                themename:{
                    remote: AlreadyExist,
                },
                themeurl:{
                    remote: AlreadyExist,
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