@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.Categories')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/categories') !!}">{{trans('app.Categories')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.ManageCategory')}}</li>
                </ul>
            </div>
         
            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    @if(Session::has('message'))
                        <div class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                        </div>
                    @endif

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
                        <form method="POST" action="{{url('admin/categories')}}/{{$category->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="category_form">
                            {{csrf_field()}}
                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    @php 
                                        $name = ''; 
                                    @endphp
                                    @if(\App\CategoryTranslations::where('langcode',get_defaultlanguage())->where('categoryid',$category->id)->count() > 0)
                                        @php 
                                            $name = \App\CategoryTranslations::where('langcode',get_defaultlanguage())->where('categoryid',$category->id)->first()->name; 
                                        @endphp
                                    @endif

                                    <input type="hidden" name="id" value="{{$category->id}}">
                                    <input type="hidden" name="_method" value="PATCH">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.CategoryName')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{$name}}" placeholder="e.g Sports" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.CategorySlug')}}<span class="required">*</span></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="slug" class="form-control col-md-7 col-xs-12" name="slug" value="{{$category->slug}}" placeholder="e.g sports" type="text" style="text-transform: lowercase;" maxlength="30" minlength="3">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="featured" id="atofea" value="1" @if($category->featured == 1) checked @endif><strong>{{trans('app.AddtoFeatured')}}</strong></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="fimg" @if($category->featured != 1) style="display:none;" @endif> 
                                        @if($category->feature_image != '')
                                        <div class="item form-group">
                                            <div class="loadDiv"> 
                                                <input type="hidden" name="_method" value="PATCH">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">{{trans('app.CurrentImage')}} <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <img style="max-width: 250px;" src="{{url('assets/images/categories')}}/{{$category->feature_image}}" alt="No Featured Image Added">
                                                        <br>
                                                        <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> {{trans('app.DeleteImage')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($category->featured != ''){{trans('app.ChangeImage')}} @else {{trans('app.FeaturedImage')}} @endif<span class="required">*</span><p class="small-label">{{trans('app.MustBeSquareSizedImage')}}(400x400)</p></label>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <img id="image_view" class="image_view">
                                                <button id="upload_files" onclick="document.getElementById('file').click(); return false;">{{trans('app.SelectImage')}}</button>
                                                <input type="file" accept="image/*" name="fimage" id="file" onchange="readURL(this);" @if($category->feature_image == '') required  @endif/>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Title<span class="required">*</span><p class="small-label">(English)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="metatitle" id="metatitle" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="60" value="{{$category->metatitle}}"> 
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Description<span class="required">*</span><p class="small-label">(English)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12" name="metadec" id="metadec" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="120">{{$category->metadec}}</textarea>
                                </div>
                            </div>

                             <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Keyword<span class="required">*</span><p class="small-label">(English)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12" name="metakey" id="metakey" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="160">{{$category->metakey}}</textarea>
                                </div>
                            </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.IsActive')}}?</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            @if($category->status == 1)
                                                <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="1" data-off="{{trans('app.Deactive')}}" checked>
                                            @elseif($category->status == 0)
                                                <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="0" data-off="{{trans('app.Deactive')}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @foreach($current_language as $alllang)
                                    @if($alllang != get_defaultlanguage())
                                        @php 
                                            $name = ''; 
                                        @endphp
                                        @if(\App\CategoryTranslations::where('langcode',$alllang)->where('categoryid',$category->id)->count() > 0)
                                            @php 
                                                $name = \App\CategoryTranslations::where('langcode',$alllang)->where('categoryid',$category->id)->first()->name; 
                                            @endphp
                                        @endif
                                        <div class="tab-pane" id="{{$alllang}}">
                                            <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">
                                            <br><br>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.CategoryName')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="trans_name_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_name[]" type="text" maxlength="50" minlength="3" value="{{$name}}">
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
                                    <a href="{!! url('admin/categories') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
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

    function string_to_slug(str) {
      str = str.replace(/^\s+|\s+$/g, ''); // trim
      str = str.toLowerCase();
      
      // remove accents, swap ñ for n, etc
      var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
      var to   = "aaaaeeeeiiiioooouuuunc------";
      for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
      }

      str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

      return str;
    }

    var id = $('input[name="id"]').val();

    $(document).ready(function(){

        $('#slug').change(function(){
            var slugval = string_to_slug($('#slug').val());
            $('#slug').val(slugval);
            return false;
        });

        $('#category_form').validate({
            rules:{
                name:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                    remote: {
                        type: 'post',
                        url: "{{ URL('admin/exist_category') }}",
                        async: false,
                        async:false,
                        data: {
                            name: function () 
                            {
                                return $("input[name='name']").val();
                            },
                            id: function() {
                                return id;
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                },
                slug:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                    remote: {
                        type: 'post',
                        url: "{{ URL('admin/exist_slug') }}",
                        async: false,
                        async:false,
                        data: {
                            slug: function () 
                            {
                                return $("input[name='slug']").val();
                            },
                            id: function() {
                                return id;
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                },
            },
            messages:
            {
                name:{
                    remote: AlreadyExist,
                },
                slug:{
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

        if ($("#category_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('input').on('blur keyup', function() {
            if ($("#category_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });  

    });


    $('.delete_img').click(function(){
        $.ajax({
            url: "{{ URL('admin/delete/category') }}/"+id,
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