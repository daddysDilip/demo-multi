@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Change Theme Color</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Change Theme Color</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <div id="response"></div>
                    <form method="POST" action="{!! action('SettingsController@themecolor',$subdomain_name) !!}" class="form-horizontal form-label-left" id="color_form">
                        {{csrf_field()}}
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Select Theme Color<span class="required">*</span>
                                {{--<p class="small-label">(In Any Language)</p>--}}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div id="cp2" class="input-group colorpicker-component">
                                    <input id="cp1" type="text" value="{{$settings[0]->theme_color}}" name="color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success ">Update Website Color</button>
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
    $(function() {
        $('#cp1').colorpicker();
        $('#cp2').colorpicker();
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){

        $('#color_form').validate({
            rules:{
                color:{
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

    });
    
</script>

@stop