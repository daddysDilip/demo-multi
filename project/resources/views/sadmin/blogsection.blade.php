@extends('sadmin.includes.master-sadmin')

@section('content')
    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize"><h3>Blog</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Blog</li>
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
                    <!-- /.start -->

                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            <a href="{!! url('sadmin/blog/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Blog</a>
                        </div>
                    </div>
                    <!-- Page Content -->
                   
        <div class="row">
            <div class="col-xs-12">
                <div class="box-body table-responsive panel-body">


                      <table class="table table-bordered" id="posts">
                    <thead>  
                             <tr class="bg-primary">
                                    <th>Featured Image</th>
                                    <th>Blog Title</th>
                                    <th>Views</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                    </thead> 
                    <tbody>
                        <tr>
                            <td>helloo</td>
                            <td>hellooo2</td>
                            <td>heleoeoeo4</td>
                        </tr>
                    </tbody>            
               </table>


                </div>
            </div>
        </div>

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
                     "url": "{{ url('sadmin/allpostsblog') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "featured_image"},
                { "data": "title"},
                { "data": "views"},
                { "data": "status"},
                { "data": "action"},
            ]    

        });
    });
</script>

<script type="text/javascript">
    
    function delete_data(reportid)
    {
        if(confirm('Are You sure You want to Delete ?'))
        {
            window.location = "{{url('/')}}/sadmin/blog/delete/"+reportid;
            return true;
        }
        else
        {
            return false;
        }
    }

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });
   
</script>

@stop