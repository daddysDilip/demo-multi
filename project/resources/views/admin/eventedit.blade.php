@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize"><h3>{{trans('app.Event')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/event') !!}">{{trans('app.Event')}}</a></li>
                    <li class="breadcrumb-item">Manage Event</li>
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
                        <form method="POST" action="{{url('admin/event')}}/{{$event->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="event_form">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="{{$event->id}}">
                            <input type="hidden" name="_method" value="PATCH">

                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    @php 
                                        $eventname = ''; 
                                        $description = ''; 
                                    @endphp
                                    @if(\App\EventTranslations::where('langcode',get_defaultlanguage())->where('eventid',$event->id)->count() > 0)
                                        @php 
                                            $eventname = \App\EventTranslations::where('langcode',get_defaultlanguage())->where('eventid',$event->id)->first()->eventname; 
                                            $description = \App\EventTranslations::where('langcode',get_defaultlanguage())->where('eventid',$event->id)->first()->description;
                                        @endphp
                                    @endif

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.EventName')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="eventname" class="form-control col-md-7 col-xs-12" name="eventname" value="{{$eventname}}" type="text" maxlength="50" minlength="3">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.EventDate')}}<span class="required">*</span></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="eventdate" class="form-control col-md-7 col-xs-12 datepicker" name="eventdate" type="text" value=<?php echo date('d/m/Y',strtotime($event->eventdate)); ?>>
                                        </div>
                                    </div>

                                    @if($event->eventimage != '')
                                    <div class="loadDiv"> 
                                        <input type="hidden" name="_method" value="PATCH">
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> {{trans('app.CurrentImage')}}</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <img src="{{url('/assets/images/event')}}/{{$event->eventimage}}" class="img-responsive" alt="No Image Added" style="width: 40%;height: 200px;">
                                                <br>
                                                <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> {{trans('app.DeleteImage')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif    
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($event->eventimage != ''){{trans('app.ChangeImage')}} @else {{trans('app.FeaturedImage')}} @endif

                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img id="image_view" class="image_view">
                                            <button id="upload_files" onclick="document.getElementById('file').click(); return false;">{{trans('app.SelectImage')}}</button>
                                           <input type="file" accept="image/*" name="eventimage" id="file" onchange="readURL(this);">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.EventDetails')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea rows="10" class="form-control" name="description" id="content1">{{$description}}</textarea>
                                        </div>
                                    </div>


                                        <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Title<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="metatitle" id="metatitle" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="60" value="{{$event->metatitle}}"> 
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Description<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12" name="metadec" id="metadec" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="120">{{$event->metadec}}</textarea>
                                </div>
                            </div>

                             <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Keyword<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12" name="metakey" id="metakey" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="160">{{$event->metakey}}</textarea>
                                </div>
                            </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.IsActive')}}?</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            @if($event->status == 1)
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="1" data-off="{{trans('app.Deactive')}}" checked>
                                            @elseif($event->status == 0)
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="0" data-off="{{trans('app.Deactive')}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @foreach($current_language as $alllang)
                                    @if($alllang != get_defaultlanguage())
                                        @php 
                                            $eventname = ''; 
                                            $description = ''; 
                                        @endphp
                                        @if(\App\EventTranslations::where('langcode',$alllang)->where('eventid',$event->id)->count() > 0)
                                            @php 
                                                $eventname = \App\EventTranslations::where('langcode',$alllang)->where('eventid',$event->id)->first()->eventname; 
                                                $description = \App\EventTranslations::where('langcode',$alllang)->where('eventid',$event->id)->first()->description;
                                            @endphp
                                        @endif
                                        <div class="tab-pane" id="{{$alllang}}">
                                            <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">
                                            <br><br>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.EventName')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="trans_eventname_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_eventname[]" type="text" maxlength="50" minlength="3" value="{{$eventname}}">
                                                </div>
                                            </div>
                                            
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.EventDetails')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea rows="10" class="form-control post-content" name="trans_description[]" id="trans_description_{{$alllang}}" onchange="testfunction();">{{$description}}</textarea>
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
                                    <a href="{!! url('admin/event') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
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

    $('.langcode').each(function(){
        var code = $(this).val();

        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true}).panelInstance('trans_description_'+code);
        });
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    var id = $('input[name="id"]').val();

    $(document).ready(function(){

        $('#event_form').validate({
            rules:{
                eventname:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                },
                eventdate:{
                    required:true,
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

        if ($("#event_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('input').on('blur keyup', function() {
            if ($("#event_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });

    });



    $('.delete_img').click(function(){
        $.ajax({
            url: "{{ URL('admin/delete/eventimage') }}/"+id,
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