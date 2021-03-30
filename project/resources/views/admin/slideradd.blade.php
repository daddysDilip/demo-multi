@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.Slider')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/sliders') !!}">{{trans('app.Slider')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.ManageSlider')}}</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">

                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#default_lang" data-toggle="tab" aria-expanded="true">{{get_language_name(get_defaultlanguage())}}</a></li>

                        @php $current_language = explode(",", $companydetails[0]->language); @endphp
                        @foreach($current_language as $alllang)
                            @if($alllang != get_defaultlanguage())
                                <li class="store_lang"><a href="#{{$alllang}}" data-toggle="tab" aria-expanded="true">{{get_language_name($alllang)}}</a></li>
                            @endif
                        @endforeach
                    </ul>

                    <div id="response"></div>

                    <div class="col-xs-12">
                        <form method="POST" action="{!! action('SliderController@store',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="slider_form">
                            {{csrf_field()}}

                            <div class="tab-content">

                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.SliderImage')}}<span class="required">*</span></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img id="image_view" class="image_view">
                                            <button id="upload_files" onclick="document.getElementById('file').click(); return false;">{{trans('app.SelectImage')}}</button>
                                            <input type="file" accept="image/*" name="image" id="file" onchange="readURL(this);" required>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.SliderTitle')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name" class="form-control col-md-7 col-xs-12" name="title" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.SliderText')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="text" id="content" class="form-control" rows="6"></textarea>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.SliderTextPosition')}}<span class="required">*</span></label>
                                        
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <select name="text_position" class="form-control">
                                                <option value="slide_style_left">{{trans('app.Left')}}</option>
                                                <option value="slide_style_center">{{trans('app.Center')}}</option>
                                                <option value="slide_style_right">{{trans('app.Right')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Link<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="link" class="form-control col-md-7 col-xs-12" name="link" type="text"  minlength="3">
                                        </div>
                                    </div>


                                     <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Target<span class="required">*</span></label>
                                        
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <select name="target" class="form-control">
                                                <option value="_blank">Load in a new window</option>
                                                <option value="_self">Load in the same frame as it was clicked</option>
                                                <option value="_parent">Load in the parent frameset</option>
                                                <option value="_top">Load in the full body of the window</option>
                                                <option value="framename">Load in a named frame</option>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.IsActive')}}?</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="1" data-off="{{trans('app.Deactive')}}" checked>
                                        </div>
                                    </div>
                                </div>

                                @foreach($current_language as $alllang)
                                    @if($alllang != get_defaultlanguage())
                                    <div class="tab-pane" id="{{$alllang}}">
                                        <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">
                                        <br><br>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.SliderTitle')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="trans_title_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_title[]" type="text" maxlength="50" minlength="3">
                                            </div>
                                        </div>
                                        
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.SliderText')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea rows="10" class="form-control post-content" name="trans_text[]" id="trans_text_{{$alllang}}" onchange="testfunction();"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    @endif
                                @endforeach

                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                    <a href="{!! url('admin/sliders') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')

<script type="text/javascript">

bkLib.onDomLoaded(function() {
    new nicEditor({fullPanel : true}).panelInstance('content');
});

$('.langcode').each(function(){
    var code = $(this).val();

    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('trans_text_'+code);
    });
});

$(document).ready(function(){

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $('#slider_form').validate({
        rules:{
            image:{
                required:true,
            },
            title:{
                minlength: 3,
                maxlength: 30,
            },
            text:{
                minlength: 3,
            },
            link:{
                minlength:3,
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

    $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});

    $('input').on('blur keyup', function() {
        if ($("#blog_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }
    });  

});
</script>

@stop