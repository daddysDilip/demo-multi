@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Page Section</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/cms') !!}">Page Section</a></li>
                    <li class="breadcrumb-item">Manage Page</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('sadmin/cms')}}/{{$cms->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="news_form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$cms->id}}">
                        <input type="hidden" name="_method" value="PATCH">
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{$cms->name}}" placeholder="Enter Page Name" type="text" maxlength="30" minlength="3">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Title<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="title" class="form-control col-md-7 col-xs-12" name="title" value="{{$cms->title}}" placeholder="Enter Page Title" type="text" maxlength="30" minlength="3">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Page Details
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea rows="10" class="form-control" name="description" id="content1" placeholder="Enter Page Details">{{$cms->description}}</textarea>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Menu Display
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="menudisplay" id="menudisplay" class="form-control">
                                    <option value="header" <?php if($cms->menudisplay == 'header') { echo "selected"; }?>>Header</option>
                                    <option value="footer" <?php if($cms->menudisplay == 'footer') { echo "selected"; }?>>Footer</option>
                                    <option value="both" <?php if($cms->menudisplay == 'both') { echo "selected"; }?>>Both</option>
                                </select>
                            </div>
                        </div>
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Meta Title
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="metatitle" class="form-control col-md-7 col-xs-12" name="metatitle" value="{{$cms->metatitle}}" placeholder="Enter Meta Title" type="text" maxlength="60" minlength="3">
                            </div>
                        </div>
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Meta Description
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea rows="6" class="form-control" name="metadec" id="metadec" placeholder="Enter Meta Description" maxlength="120" minlength="3">{{$cms->metadec}}</textarea>
                            </div>  
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Meta Keywords
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="metakey" class="form-control col-md-7 col-xs-12" name="metakey" value="{{$cms->metakey}}" placeholder="Enter Meta Title" type="text" maxlength="160" minlength="3">
                            </div>
                        </div>
						
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                @if($cms->status == 1)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                                @elseif($cms->status == 0)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
                                @endif
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update Page</button>
                                <a href="{!! url('sadmin/cms') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

        $('#news_form').validate({
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
                        url: "{{ URL('sadmin/existcmstitle') }}",
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
                    minlength: 3,
                    maxlength: 60,
                },
                metadec: {
                    minlength: 3,
                    maxlength: 120,
                },
                metakey: {
                    minlength: 3,
                    maxlength: 160,
                }
            },
            messages:{
                name:{
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
</script>
@stop