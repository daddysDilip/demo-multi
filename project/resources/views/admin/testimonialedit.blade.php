@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.Testimonial')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/testimonial') !!}">{{trans('app.Testimonial')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.ManageTestimonial')}}</li>
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
                        <form method="POST" action="{{url('admin/testimonial')}}/{{$testimonial->id}}" class="form-horizontal form-label-left" id="testimonial_form">
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="PATCH">

                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    @php 
                                        $review = ''; 
                                        $designation = ''; 
                                    @endphp
                                    @if(\App\TestimonialTranslations::where('langcode',get_defaultlanguage())->where('testimonialid',$testimonial->id)->count() > 0)
                                        @php 
                                            $review = \App\TestimonialTranslations::where('langcode',get_defaultlanguage())->where('testimonialid',$testimonial->id)->first()->review; 
                                            $designation = \App\TestimonialTranslations::where('langcode',get_defaultlanguage())->where('testimonialid',$testimonial->id)->first()->designation;
                                        @endphp
                                    @endif

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.ClientReview')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="review" class="form-control" rows="6" maxlength="500" minlength="3">{{$review}}</textarea>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.ClientName')}}<span class="required">*</span>

                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name" class="form-control col-md-7 col-xs-12" name="client" value="{{$testimonial->client}}" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.ClientDesignation')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="slug" class="form-control col-md-7 col-xs-12" name="designation" value="{{$designation}}" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.IsActive')}}?</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            @if($testimonial->status == 1)
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="1" data-off="{{trans('app.Deactive')}}" checked>
                                            @elseif($testimonial->status == 0)
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="0" data-off="{{trans('app.Deactive')}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @foreach($current_language as $alllang)
                                    @if($alllang != get_defaultlanguage())

                                        @php 
                                            $review = ''; 
                                            $designation = ''; 
                                        @endphp
                                        @if(\App\TestimonialTranslations::where('langcode',$alllang)->where('testimonialid',$testimonial->id)->count() > 0)
                                            @php 
                                                $review = \App\TestimonialTranslations::where('langcode',$alllang)->where('testimonialid',$testimonial->id)->first()->review; 
                                                $designation = \App\TestimonialTranslations::where('langcode',$alllang)->where('testimonialid',$testimonial->id)->first()->designation;
                                            @endphp
                                        @endif

                                        <div class="tab-pane" id="{{$alllang}}">
                                            <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">
                                           <br><br>

                                           <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.ClientReview')}}<span class="required">*</span><p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea name="trans_review[]" class="form-control" rows="6" maxlength="500" minlength="3">{{$review}}</textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.ClientDesignation')}}<span class="required">*</span><p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="slug" class="form-control col-md-7 col-xs-12" name="trans_designation[]" type="text" maxlength="30" minlength="3" value="{{$designation}}">
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
                                    <a href="{!! url('admin/testimonial') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
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

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){

        $('#testimonial_form').validate({
            rules:{
                review:{
                    required:true,
                    minlength: 3,
                    maxlength: 500,
                },
                client:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                designation:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
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

        if ($("#blog_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

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