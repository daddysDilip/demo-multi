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
                        <form method="POST" action="{!! action('CmsController@store',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="cms_form">
                            {{csrf_field()}}

                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.PageName')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name" class="form-control col-md-7 col-xs-12" name="name" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.PageTitle')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="title" class="form-control col-md-7 col-xs-12" name="title" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>
                                   
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.PageDetails')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea rows="10" class="form-control post-content" name="description" id="content1" onchange="testfunction();"></textarea>
                                        </div>
                                    </div>
            						
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MetaTitle')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="metatitle" class="form-control col-md-7 col-xs-12" name="metatitle" type="text" maxlength="60" minlength="3">
                                        </div>
                                    </div>
            						
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MetaDescription')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>
                                        
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <!-- <textarea rows="6" class="form-control post-content" name="metadescription" id="metadescription"></textarea>
 -->
                                            <textarea rows="6" class="form-control post-content" name="metadec" id="metadec"></textarea>

                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MetaKeywords')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                         <!--    <input id="metakeywords" class="form-control col-md-7 col-xs-12" name="metakeywords" type="text" maxlength="150" minlength="120"> -->
                                             <input id="metakey" class="form-control col-md-7 col-xs-12" name="metakey" type="text" maxlength="150" minlength="120">
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
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.PageName')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="trans_name_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_name[]" type="text">
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.PageTitle')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="trans_title_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_title[]" type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.PageDetails')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea rows="10" class="form-control post-content" name="trans_description[]" id="trans_description_{{$alllang}}" onchange="testfunction();"></textarea>
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MetaTitle')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                               <!--      <input id="trans_metatitle_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_metatitle[]"   type="text"> -->

                                                     <input id="metatitle" class="form-control col-md-7 col-xs-12" name="metatitle"   type="text">
                                                </div>
                                            </div>
                                            
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MetaDescription')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea rows="6" class="form-control post-content" name="trans_metadescription[]" id="trans_metadescription_{{$alllang}}"></textarea>
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MetaKeywords')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>
                                        
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="trans_metakeywords_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_metakeywords[]" type="text">
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

    $('.langcode').each(function(){
        var code = $(this).val();

        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true}).panelInstance('trans_description_'+code);
        });
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

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
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                },
                metatitle: {
                    // minlength: 60,
                    minlength: 3,
                    maxlength: 60,
                },
                metadec: {
                    // minlength: 60,
                    minlength: 3,
                    maxlength: 120,
                },
                metakeywords: {
                    // minlength: 120,
                    minlength: 3,
                    maxlength: 160,
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

        $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});

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