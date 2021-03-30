@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.News')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/news') !!}">{{trans('app.News')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.ManageNews')}}</li>
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
                        <form method="POST" action="{{url('admin/news')}}/{{$news->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="news_form">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$news->id}}">
                            <input type="hidden" name="_method" value="PATCH">

                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    @php 
                                        $newstitle = ''; 
                                        $content = ''; 
                                    @endphp
                                    @if(\App\NewsTranslations::where('langcode',get_defaultlanguage())->where('newsid',$news->id)->count() > 0)
                                        @php 
                                            $newstitle = \App\NewsTranslations::where('langcode',get_defaultlanguage())->where('newsid',$news->id)->first()->newstitle; 
                                            $content = \App\NewsTranslations::where('langcode',get_defaultlanguage())->where('newsid',$news->id)->first()->content;
                                        @endphp
                                    @endif

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.NewsTitle')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="newstitle" class="form-control col-md-7 col-xs-12" name="newstitle" value="{{$newstitle}}" type="text" maxlength="50" minlength="3">
                                        </div>
                                    </div>

                                    @if($news->newsimage != '')
                                    <div class="loadDiv"> 
                                        <input type="hidden" name="_method" value="PATCH">
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> {{trans('app.CurrentImage')}}</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <img src="{{url('/assets/images/news')}}/{{$news->newsimage}}" class="img-responsive" alt="No Image Added" style="width: 40%;height: 200px;">
                                                <br>
                                                <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> {{trans('app.DeleteImage')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif    
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($news->newsimage != ''){{trans('app.ChangeImage')}} @else {{trans('app.FeaturedImage')}} @endif</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img id="image_view" class="image_view">
                                            <button id="upload_files" onclick="document.getElementById('file').click(); return false;">{{trans('app.SelectImage')}}</button>
                                            <input type="file" accept="image/*" name="newsimage" id="file" onchange="readURL(this);">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.NewsDetails')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea rows="10" class="form-control" name="content" id="content1">{{$content}}</textarea>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.IsActive')}}?</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            @if($news->status == 1)
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="1" data-off="{{trans('app.Deactive')}}" checked>
                                            @elseif($news->status == 0)
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="0" data-off="{{trans('app.Deactive')}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @foreach($current_language as $alllang)
                                    @if($alllang != get_defaultlanguage())
                                        @php 
                                            $newstitle = ''; 
                                            $content = ''; 
                                        @endphp
                                        @if(\App\NewsTranslations::where('langcode',$alllang)->where('newsid',$news->id)->count() > 0)
                                            @php 
                                                $newstitle = \App\NewsTranslations::where('langcode',$alllang)->where('newsid',$news->id)->first()->newstitle; 
                                                $content = \App\NewsTranslations::where('langcode',$alllang)->where('newsid',$news->id)->first()->content;
                                            @endphp
                                        @endif
                                        <div class="tab-pane" id="{{$alllang}}">
                                            <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">
                                            <br><br>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.NewsTitle')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="trans_newstitle_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_newstitle[]" type="text" maxlength="50" minlength="3" value="{{$newstitle}}">
                                                </div>
                                            </div>
                                            
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.NewsDetails')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea rows="10" class="form-control post-content" name="trans_content[]" id="trans_content_{{$alllang}}" onchange="testfunction();">{{$content}}</textarea>
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
                                    <a href="{!! url('admin/news') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
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
    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('content1');
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    var id = $('input[name="id"]').val();

    $(document).ready(function(){

        $('#news_form').validate({
            rules:{
                newstitle:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
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

        if ($("#news_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('input').on('blur keyup', function() {
            if ($("#news_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });  

    });

    $('.delete_img').click(function(){
        $.ajax({
            url: "{{ URL('admin/delete/newsimage') }}/"+id,
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