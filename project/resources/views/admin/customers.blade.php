@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.Customers')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{trans('app.Customers')}}</a></li>
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

                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            @if(count($customers) > 0)
                                <a href="{!! url('admin/exportcustomer') !!}" class="btn btn-primary btn-add"><i class="fa fa-download"></i> {{trans('app.Export')}}</a>
                            @endif
                        </div>
                    </div>

                    <table class="table table-striped table-bordered" cellspacing="0" id="posts" width="100%">
                        <thead>
                            <tr class="bg-primary">
                                <th>{{trans('app.CustomerName')}}</th>
                                <th width="10%">{{trans('app.CustomerEmail')}}</th>
                                <th>{{trans('app.Phone')}}</th>
                                <th width="10%">{{trans('app.RegisteredOn')}}</th>
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

@stop

@section('footer')

<script type="text/javascript">

    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsadmincustomers') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [                
                { "data": "firstname"},
                { "data": "email"},
                { "data": "phone"},
                { "data": "registeredOn"},
                { "data": "status"},
                { "data": "action"},
            ]    
        });
    });
    
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

@stop