@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Blog</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/blog') !!}">Blog</a></li>
                    <li class="breadcrumb-item">Manage Blog</li>
                </ul>
            </div>
            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                <div id="response"></div>
                    <form method="POST" action="{{url('sadmin/blog')}}/{{$blog->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="blog_form">
                        {{csrf_field()}}

                        <input type="hidden" name="id" value="{{$blog->id}}">
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Blog Title<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="title" value="{{$blog->title}}" placeholder="Enter Blog Title" type="text" maxlength="50" minlength="3">
                            </div>
                        </div>

                        @if($blog->featured_image != '')

                        <div class="item form-group">
                            <div class="loadDiv"> 
                             
                                <input type="hidden" name="_method" value="PATCH">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> Current Image</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                          <img src="{{url('/assets/images/blog')}}/{{$blog->featured_image}}" class="img-responsive" alt="No Image Added" style="width: 40%;height: 200px;">
                                        <br>
                                        <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> Delete Blog Image</a>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                        @endif    
                    
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($blog->featured_image != '')Change Image @else Featured Image @endif

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" accept="image/*" name="image">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Blog Details
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea rows="10" class="form-control" name="details" id="content1" placeholder="Enter Blog Contents">{{$blog->details}}</textarea>

                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Source<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="slug" class="form-control col-md-7 col-xs-12" name="source" value="{{$blog->source}}" placeholder="e.g www.geniusocean.com" required="required" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    @if($blog->status == 1)
                                    <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                                    @elseif($blog->status == 0)
                                    <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
                                    @endif
                                </div>
                            </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update Blog</button>
                                <a href="{!! url('sadmin/blog') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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
    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('content1');
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    var id = $('input[name="id"]').val();

    $(document).ready(function(){

        $('#blog_form').validate({
            rules:{
                title:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/existblogtitle') }}",
                        async: false,
                        async:false,
                        data: {
                            title: function () 
                            {
                                return $("input[name='title']").val();
                            },
                            id: function() {
                                return id;
                            },
                            "_token": "{{ csrf_token() }}"  
                        },
                    }
                },
                source:{
                    required:true,
                    url:true
                }
            },
            messages:{
                title:{
                    remote:"Already exist",
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

       $('.delete_img').click(function(){
        $.ajax({
            url: "{{ URL('sadmin/delete/blogimage') }}/"+id,
            type: "post",
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