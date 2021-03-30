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
                        <h3>{{trans('app.PageSettings')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.PageSettings')}}</li>
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
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#faq" data-toggle="tab" aria-expanded="true">{{trans('app.FAQPage')}}</a>
                            </li>
                            <li><a href="#brands" data-toggle="tab" aria-expanded="false">{{trans('app.BrandLogos')}}</a></li>
                            <li><a href="#banners" data-toggle="tab" aria-expanded="false">{{trans('app.HomeBanners')}}</a></li>
                            <li><a href="#largeBanner" data-toggle="tab" aria-expanded="false">{{trans('app.LargeHomeBanners')}}</a></li>
                            <li><a href="#contact" data-toggle="tab" aria-expanded="false">{{trans('app.ContactUsPage')}}</a>
                            </li>
                            <li><a href="#seo" data-toggle="tab" aria-expanded="false">Seo Section</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xs-12">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="faq">
                                <br>

                                <div class="prtm-block-title mrgn-b-lg">
                                    <div class="caption">
                                        <a href="{!! url('admin/faq/add') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> {{trans('app.AddNew')}}</a>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>

                                <form method="POST" action="{{action('PageSettingsController@faq',$subdomain_name)}}" class="form-horizontal form-label-left" id="addfaq_settings">
                                    {{csrf_field()}}
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> {{trans('app.DisableEnableFAQPage')}}
                                        </label>
                                        <div class="col-md-2 col-sm-3 col-xs-6">
                                            @if($pagedata[0]->f_status == 1)
                                                <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="f_status" value="1" data-off="{{trans('app.Disable')}}" checked>
                                            @else
                                                <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="f_status" value="1" data-off="{{trans('app.Disable')}}">
                                            @endif
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <button id="faq_page_update" type="submit" class="btn btn-success">{{trans('app.Apply')}}</button>
                                        </div>
                                    </div>

                                </form>
                                <p class="lead">{{trans('app.AllFAQs')}}</p>
                                <table class="table table-striped table-bordered" id="posts1">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th width="35%">{{trans('app.Questions')}}</th>
                                            <th width="45%">{{trans('app.Answers')}}</th>
                                            <th width="20%">{{trans('app.Status')}}</th>
                                            <th width="20%">{{trans('app.Action')}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            
                            <div class="tab-pane" id="brands">
                                <br>
                                <div class="prtm-block-title mrgn-b-lg">
                                    <div class="caption">
                                        <a href="{!! url('admin/brand/add') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> {{trans('app.AddNew')}}</a>
                                    </div>
                                </div>
                                <p class="lead"></p>
                                <table class="table table-striped table-bordered" id="posts3" width="100%">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th width="35%">{{trans('app.BrandLogo')}}</th>
                                            <th width="20%">{{trans('app.Status')}}</th>
                                            <th width="20%">{{trans('app.Action')}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="tab-pane" id="banners">
                                <br>
                                <div class="prtm-block-title mrgn-b-lg">
                                    <div class="caption">
                                        <a href="{!! url('admin/banner/add') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> {{trans('app.AddNew')}}</a>
                                    </div>
                                </div>
                                
                                <p class="lead">{{trans('app.HomeBanners')}}</p>
                                <table class="table table-striped table-bordered" id="posts2" width="100%">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th width="35%">{{trans('app.Banner')}}</th>
                                            <th width="45%">{{trans('app.HyperLink')}}</th>
                                            <th width="20%">{{trans('app.Status')}}</th>
                                            <th width="20%">{{trans('app.Action')}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            
                            <div class="tab-pane" id="largeBanner">
                                <p class="lead"></p>
                                <div class="ln_solid"></div>
                                <form method="POST" action="banner/large" class="form-horizontal form-label-left" enctype="multipart/form-data" id="large_banner">
                                    {{csrf_field()}}

                                    @if($pagedata[0]->large_banner != '') 
                                    <div class="item form-group loadDiv" style="margin-bottom: -10px;">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.CurrentLargeBanner')}}
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img src="../assets/images/{{$pagedata[0]->large_banner}}" style="width: 100%;">
                                        </div>
                                    </div><br>
                                    @endif

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.SetupNewBanner')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img id="image_view" class="image_view">
                                            <button id="upload_files" onclick="document.getElementById('file').click(); return false;">{{trans('app.SelectImage')}}</button>
                                            <input type="file" name="large_banner" accept="image/*" id="file" onchange="readURL(this);"/>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.LargeBannerLink')}} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" name="banner_link" type="text" value="{{$pagedata[0]->banner_link}}">
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

                            <div class="tab-pane" id="contact">
                                <p class="lead"></p>
                                <div class="ln_solid"></div>

                                <ul class="lang_ul nav nav-tabs col-md-2 col-sm-3 col-xs-12">
                                    <li class="active"><a href="#default_lang" data-toggle="tab" aria-expanded="true">{{get_language_name(get_defaultlanguage())}}</a></li>

                                    @php $current_language = explode(",", $companydetails[0]->language); @endphp
                                    @foreach($current_language as $alllang)
                                        @if($alllang != get_defaultlanguage())
                                            <li class="store_lang"><a href="#{{$alllang}}" data-toggle="tab" aria-expanded="true">{{get_language_name($alllang)}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <form method="POST" action="{{action('PageSettingsController@contact',$subdomain_name)}}" class="form-horizontal form-label-left" id="contact_settings">
                                        {{csrf_field()}}

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="default_lang">
                                                <input type="hidden" name="id" value="{{$pagedata[0]->id}}">
                                                <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">

                                                @php 
                                                    $contact = ''; 
                                                @endphp
                                                @if(\App\PageSettingTranslations::where('langcode',get_defaultlanguage())->where('pagesettingsid',$pagedata[0]->id)->count() > 0)
                                                    @php 
                                                        $contact = \App\PageSettingTranslations::where('langcode',get_defaultlanguage())->where('pagesettingsid',$pagedata[0]->id)->first()->contact; 
                                                    @endphp
                                                @endif

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> {{trans('app.DisableEnableContactPage')}}
                                                    </label>
                                                    <div class="col-md-3 col-sm-3 col-xs-9">
                                                        @if($pagedata[0]->c_status == 1)
                                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="c_status" value="1" data-off="{{trans('app.Disabled')}}" checked>
                                                        @else
                                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Enabled')}}" name="c_status" value="1" data-off="{{trans('app.Disabled')}}">
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> {{trans('app.ContactFormSuccessText')}} <span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <textarea rows="3" class="form-control" name="contact" maxlength="100" minlength="3">{{$contact}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> {{trans('app.ContactUsEmailAddress')}} <span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" class="form-control" name="contact_email" value="{{$pagedata[0]->contact_email}}" maxlength="50" minlength="3"/>
                                                    </div>
                                                </div>
                                            </div>

                                            @foreach($current_language as $alllang)
                                                @if($alllang != get_defaultlanguage())
                                                @php 
                                                    $contact = ''; 
                                                @endphp
                                                @if(\App\PageSettingTranslations::where('langcode',$alllang)->where('pagesettingsid',$pagedata[0]->id)->count() > 0)
                                                    @php 
                                                        $contact = \App\PageSettingTranslations::where('langcode',$alllang)->where('pagesettingsid',$pagedata[0]->id)->first()->contact; 
                                                    @endphp
                                                @endif
                                                <div class="tab-pane" id="{{$alllang}}">
                                                    <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">

                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> {{trans('app.ContactFormSuccessText')}} <span class="required">*</span><p class="small-label">({{get_language_name($alllang)}})</p>
                                                        </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <textarea rows="3" class="form-control" name="trans_contact[]" maxlength="100" minlength="3">{{$contact}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="ln_solid"></div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button id="contact_page_update" type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>

                           <div class="tab-pane" id="seo">
                                <p class="lead"></p>
                                <div class="ln_solid"></div>

                                     <div class="caption">
                                        <a href="{!! url('admin/seoadd') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> {{trans('app.AddNew')}}</a><br/><br/>
                                    </div>
                                <div class="col-md-10 col-sm-9 col-xs-12">

                                        <table class="table table-striped table-bordered" id="posts5" width="100%">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th width="35%">Title</th>
                                            <th width="45%">Dec</th>
                                            <th width="20%">keyword</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                </table>


                                    
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

    $(document).ready(function () {
        $('#posts1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsfaq') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [   

                { "data": "question"},
                { "data": "answer"},
                { "data": "status"},
                { "data": "action"},
    
            ]    
        });
    });
</script>

<script type="text/javascript">

    $(document).ready(function () {
        $('#posts2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsbanner') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [   

                { "data": "image"},
                { "data": "link"},
                { "data": "status"},
                { "data": "action"},
    
            ]    
        });
    });
</script>

<script type="text/javascript">

    $(document).ready(function () {
        $('#posts3').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsbrandlogo') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [   

                { "data": "image"},
                { "data": "status"},
                { "data": "action"},
    
            ]    
        });
    });
</script>

<script type="text/javascript">

    $(document).ready(function () {
        $('#posts5').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsseo') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [   

                { "data": "metatitle"},
                { "data": "metakey"},
                { "data": "metadec"},
                { "data": "action"},
    
            ]    
        });
    });
</script>

<script type="text/javascript">
  
    function delete_faqdata(reportid)
    {
        if(confirm(DeleteConfirmation))
        {
            window.location = "faq/"+reportid+"/delete";
            return true;
        }
        else
        {
            return false;
        }
    }

    function delete_brand(reportid)
    {
        if(confirm(DeleteConfirmation))
        {
            window.location = "brand/"+reportid+"/delete";
            return true;
        }
        else
        {
            return false;
        }
    }

    function delete_banner(reportid)
    {
        if(confirm(DeleteConfirmation))
        {
            window.location = "banner/"+reportid+"/delete";
            return true;
        }
        else
        {
            return false;
        }
    }

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){
        $('.form-group .toggle.btn').css('width','100px');
        
        $.validator.addMethod('Validemail', function (value, element) {
            return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
        }, ValidEmailError);

        $('#contact_settings').validate({
            rules:{
                contact:{
                    required:true,
                    minlength: 3,
                    maxlength: 100,
                },
                contact_email:{
                    required:true,
                    Validemail:true,
                    maxlength: 50,
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

        if ($("#contact_settings").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('input').on('blur keyup', function() {
            if ($("#contact_settings").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });  

        $('#large_banner').validate({
            rules:{
                banner_link:{
                    required:true,
                    url:true,
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