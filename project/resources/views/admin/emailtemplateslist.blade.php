@extends('admin.includes.master-admin')

@section('content')
    
    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Email Templates</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Email Templates</li>
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

                    <table class="table table-striped table-bordered" cellspacing="0" id="posts" width="100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Actions</th>
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
                     "url": "{{ url('admin/allpostsadminemail') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [          


      
                { "data": "title"},
                { "data": "fromname"},
                { "data": "subject"},
                { "data": "action"},
            ]    
        });
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });
    

</script>

@stop