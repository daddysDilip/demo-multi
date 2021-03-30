@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Slider</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/sliders') !!}">Slider</a></li>
                    <li class="breadcrumb-item">Manage Slider</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('sadmin/sliders')}}/{{$slider->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="slider_form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$slider->id}}">
                        <input type="hidden" name="_method" value="PATCH">



                        <div class="loadDiv"> 
                            @if($slider->image != '')
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> Current Slider Image</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <img src="{!! url('/') !!}/assets/images/sliders/{{$slider->image}}" style="max-height: 300px;width: 100%;" alt="No Banner Photo">
                                    <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> Delete Slider Image</a>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($slider->image != '')Change Slider Image @else Slider Image @endif<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="file" accept="image/*" name="image" >
                                </div>
                            </div>
                            @else
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($slider->image != '')Change Slider Image @else Slider Image @endif<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="file" accept="image/*" name="image" required>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Slider Title
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="title" value="{{$slider->title}}" placeholder="e.g Sports" type="text" maxlength="30" minlength="3">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Slider Text
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="text" id="content" class="form-control" rows="6">{{$slider->text}}</textarea>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Slider Text Position<span class="required">*</span>

                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <select name="text_position" class="form-control">
                                    @if($slider->text_position == "slide_style_left")
                                        <option value="slide_style_left" selected>Left</option>
                                    @else
                                        <option value="slide_style_left">Left</option>
                                    @endif
                                    @if($slider->text_position == "slide_style_center")
                                        <option value="slide_style_center" selected>Center</option>
                                    @else
                                        <option value="slide_style_center">Center</option>
                                    @endif
                                    @if($slider->text_position == "slide_style_right")
                                        <option value="slide_style_right" selected>Right</option>
                                    @else
                                        <option value="slide_style_right">Right</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                @if($slider->status == 1)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                                @elseif($slider->status == 0)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
                                @endif
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update Slider</button>
                                <a href="{!! url('sadmin/sliders') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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
        new nicEditor({fullPanel : true}).panelInstance('content');
    });

    var id = $('input[name="id"]').val();
    
    $(document).ready(function(){

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param) 
        }, "File must be less than 2MB");
        
        $(':input').change(function() {
            $(this).val($(this).val().trim());
        });
        
        $('#slider_form').validate({
            rules:{
                title:{
                    minlength: 3,
                    maxlength: 30,
                },
                text:{
                    minlength: 3,
                    maxlength: 100,
                },
                image:{
                    extension: "jpg|jpeg|png",
                    filesize: 2097152
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

    });

    $('.delete_img').click(function(){
        $.ajax({
            url: "{{ URL('sadmin/delete/sliderimage') }}/"+id,
            type: "get",
            async: false,
            data: {},
            success: function(data)
            {
                $('.loadDiv').load(' .loadDiv');
            },
        });
    });

</script>

@stop