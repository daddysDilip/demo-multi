@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Seo Section</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Seo Section</a></li>
                    <li class="breadcrumb-item">Seo Sceion </li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">

              <!--       <ul class="nav nav-tabs">
                        <li class="active"><a href="#default_lang" data-toggle="tab" aria-expanded="true">{{get_language_name(get_defaultlanguage())}}</a></li>

                        @php $current_language = explode(",", $companydetails[0]->language); @endphp
                        @foreach($current_language as $alllang)
                            @if($alllang != get_defaultlanguage())
                                <li class="store_lang"><a href="#{{$alllang}}" data-toggle="tab" aria-expanded="true">{{get_language_name($alllang)}}</a></li>
                            @endif
                        @endforeach
                    </ul> -->

                    <div id="response"></div>
                    <div class="col-xs-12">
                        <form method="POST" action="{{url('admin/seosetionupdate')}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="event_form">
                            {{csrf_field()}}


                            <input type="hidden" name="id" value="{{$seosetion->id}}">
                            <input type="hidden" name="_method" value="PATCH">
                            

                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>
                                    
                                     <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Title<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="metatitle" id="metatitle" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="60" value="{{$seosetion->metatitle}}"> 
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Description<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12" name="metadec" id="metadec" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="120">{{$seosetion->metadec}}</textarea>
                                </div>
                            </div>

                             <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Keyword<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12" name="metakey" id="metakey" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="160">{{$seosetion->metakey}}</textarea>
                                </div>
                            </div>
                            
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                    <a href="{!! url('admin/event') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
                                </div>
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

        $('#event_form').validate({
            rules:{
                metatitle:{
                    required:true,
                    minlength: 3,
                    maxlength: 60,
                },
                metadec:{
                    required:true,
                    minlength:3,
                    maxlength:120,
                },
                metakey:{
                    required:true,
                    minlength:3,
                    maxlength:160,
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
            if ($("#event_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });  

    });
</script>
@stop