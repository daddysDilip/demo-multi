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
                        <h3>FAQ</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/pagesettings') !!}">FAQ</a></li>
                    <li class="breadcrumb-item">Manage FAQ</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('admin/faq')}}/{{$faq->id}}/update" class="form-horizontal form-label-left" id="addfaq_settings">
                        {{csrf_field()}}
                        <input type="hidden" name="id" class="form-control" id="id" value="{{$faq->id}}">
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Question<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" name="question" value="{{$faq->question}}" placeholder="e.g What is this website about?" type="text" maxlength="100" minlength="3">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Answer<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="answer" id="content1" rows="10" class="form-control" placeholder="Define Your Answer" minlength="3" maxlength="5000">{{$faq->answer}}</textarea>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                @if($faq->status == 1)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                                @elseif($faq->status == 0)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
                                @endif
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update FAQ</button>
                                <a href="{!! url('admin/pagesettings') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

    // bkLib.onDomLoaded(function() {
    //     new nicEditor({fullPanel : true}).panelInstance('content1');
    // });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    var id = $('input[name="id"]').val();
    
    $('#addfaq_settings').validate({
            // ignore: [],
            // debug: false,
            rules:{
                question:{
                    required:true,
                    minlength: 3,
                    maxlength: 100,
                    remote: {
                        type: 'post',
                        url: "{{ URL('admin/exist_faq') }}",
                        async: false,
                        async:false,
                        data: {
                            question: function () 
                            {
                                return $("input[name='question']").val();
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
                answer:{
                    required:true,
                    minlength: 3,
                    maxlength:5000
                }
            },
            messages:{
                question:{
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

</script>


@stop