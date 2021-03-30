@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">

            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.PageSection')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/cms') !!}">{{trans('app.PageSection')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.ManageCms')}}</li>
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
                        <form method="POST" action="{{url('admin/cms')}}/{{$cms->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="cms_form">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$cms->id}}">
                            <input type="hidden" name="_method" value="PATCH">

                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">

                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    @php 
                                        $name = ''; 
                                        $title = ''; 
                                        $description = ''; 
                                        $metatitle = ''; 
                                        $metadescription = ''; 
                                        $metakeywords = ''; 
                                    @endphp
                                    @if(\App\CmsTranslations::where('langcode',get_defaultlanguage())->where('cmsid',$cms->id)->count() > 0)
                                        @php 
                                            $name = \App\CmsTranslations::where('langcode',get_defaultlanguage())->where('cmsid',$cms->id)->first()->name; 
                                            $title = \App\CmsTranslations::where('langcode',get_defaultlanguage())->where('cmsid',$cms->id)->first()->title;
                                            $description = \App\CmsTranslations::where('langcode',get_defaultlanguage())->where('cmsid',$cms->id)->first()->description;
                                            $metatitle = \App\CmsTranslations::where('langcode',get_defaultlanguage())->where('cmsid',$cms->id)->first()->metatitle;
                                            $metadescription = \App\CmsTranslations::where('langcode',get_defaultlanguage())->where('cmsid',$cms->id)->first()->metadescription;
                                            $metakeywords = \App\CmsTranslations::where('langcode',get_defaultlanguage())->where('cmsid',$cms->id)->first()->metakeywords;
                                        @endphp
                                    @endif

            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.PageName')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{$cms->name}}" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.PageTitle')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="title" class="form-control col-md-7 col-xs-12" name="title" value="{{$title}}" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.PageDetails')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></p>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea rows="10" class="form-control" name="description" id="content1">{{$description}}</textarea>
                                        </div>
                                    </div>
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MetaTitle')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="metatitle" class="form-control col-md-7 col-xs-12" name="metatitle" value="{{$cms->metatitle}}" type="text" maxlength="60" minlength="3">
                                        </div>
                                    </div>
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MetaDescription')}}<p class="small-label">(English)</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <!-- <textarea rows="6" class="form-control" name="metadescription" id="metadescription">{{$metadescription}}</textarea> -->
                                              <textarea rows="6" class="form-control" name="metadec" id="metadec">{{$cms->metadec}}</textarea>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MetaKeywords')}}<p class="small-label">({{get_language_name($alllang)}}) (English)</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                     

                                    <input id="metakey" class="form-control col-md-7 col-xs-12" name="metakey" type="text" value="{{$cms->metakey}}">      
                                        </div>
                                    </div>
            						
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.IsActive')}}?</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            @if($cms->status == 1)
                                                <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="1" data-off="{{trans('app.Deactive')}}" checked>
                                            @elseif($cms->status == 0)
                                                <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="0" data-off="{{trans('app.Deactive')}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                              
                            </div>

                            <div class="ln_solid"></div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                    <a href="{!! url('admin/cms') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
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

    $('.langcode').each(function(){
        var code = $(this).val();

        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true}).panelInstance('trans_description_'+code);
        });
    });

    var id = $('input[name="id"]').val();

    $(document).ready(function(){

        $('#cms_form').validate({
            rules:{
                title:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
				name:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                    remote: {
                        type: 'post',
                        url: "{{ URL('admin/existcmstitle') }}",
                        async: false,
                        async:false,
                        data: {
                            name: function () 
                            {
                                return $("input[name='name']").val();
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
                metatitle: {
                    // minlength: 60,
                    minlength: 3,
                    maxlength: 70,
                },
                metakey: {
                    // minlength: 120,
                    minlength: 3,
                    maxlength: 160,
                },
                metadec: {
                    // minlength: 120,
                    minlength: 3,
                    maxlength: 120,
                }
            },
            messages:{
                name:{
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

        if ($("#cms_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('input').on('blur keyup', function() {
            if ($("#cms_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });  

    });
</script>
@stop