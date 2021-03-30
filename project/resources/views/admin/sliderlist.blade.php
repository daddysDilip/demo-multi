@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.Slider')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.Slider')}}</li>
                </ul>
            </div>
                
            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response">
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    </div>

                    @if(count($slider) > 0)
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            <a href="{!! url('admin/sliders/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> {{trans('app.AddNew')}} </a>
                            
                            @if(count($slider) > 0)
                                <a href="{!! url('admin/exportsliders') !!}" class="btn btn-primary btn-add"><i class="fa fa-download"></i> {{trans('app.Export')}}</a>
                            @endif

                            <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#modal-default"><i class="fa fa-file-excel-o"></i> Import</button>

                            <a href="http://adminuser.multiecom.com/assets/importtile/Slider.xls"><button type="button" class="btn btn-primary btn-add"><i class="fa fa-file-excel-o"></i> Demo File</button></a>
                        </div>
                    </div>
                    @endif

                    <table class="table table-striped table-bordered" cellspacing="0" id="posts" width="100%">
                        <thead>
                            <tr class="bg-primary">
                                <th>{{trans('app.SliderImage')}}</th>
                                <th>{{trans('app.SliderTitle')}}</th>
                                <th>{{trans('app.Status')}}</th>
                                <th>{{trans('app.Action')}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <!-- ============================================= Model import=========== -->

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('app.ImportFile')}}</h4>
                </div>

                <div class="modal-body">
                    <!-- Page Content -->
                    <div id="response"></div>

                    <form method="POST" action="{!! action('SliderController@import',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="blog_form">
                        {{csrf_field()}}

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Import')}} <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <img id="image_view" class="image_view">
                                <button id="upload_files" onclick="document.getElementById('imported_file').click(); return false;">{{trans('app.SelectFile')}}</button>
                                <input type="File" name="imported_file" id="imported_file" accept="application/vnd.ms-excel">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{trans('app.Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{trans('app.Save')}}</button>
                        </div> 
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- =============================================Over Model import=========== -->

@stop

@section('footer')

<script type="text/javascript">

    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsadminslider') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [                    
                {"data": "image"},
                { "data": "title"},
                { "data": "status"},
                { "data": "action"},
            ]    

        });
    });

    function delete_data(reportid)
    {
        if(confirm(DeleteConfirmation))
        {
            window.location = "{{url('/')}}/admin/sliders/delete/"+reportid;
            return true;
        }
        else
        {
            return false;
        }
    }

</script>

@stop