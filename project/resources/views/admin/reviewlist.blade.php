@extends('admin.includes.master-admin')

@section('content')
    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.ReviewSections')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.ReviewSections')}}</li>
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
                    
                    <table class="table table-bordered" id="posts">
                        <thead>  
                            <tr class="bg-primary">
                                <th>{{trans('app.Product')}}</th>
                                <th>{{trans('app.Name')}}</th>
                                <th>{{trans('app.Email')}}</th>
                                <th>{{trans('app.Review')}}</th>
                                <th>{{trans('app.Rating')}}</th>
                                <th>{{trans('app.ReviewDate')}}</th>
                                <th>{{trans('app.Status')}}</th>
                            </tr>
                        </thead>   
                    </table>
                   
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
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsadminreview') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [                
                { "data": "productid"},
                { "data": "name"},
                { "data": "email"},
                { "data": "review"},
                { "data": "rating"},
                { "data": "review_date"},
                { "data": "status"},
            ]    
        });
    });

    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });
    
 
</script>

@stop