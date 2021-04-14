@extends('sadmin.includes.master-sadmin2')

@section('content')
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Blog 
                
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Blog</li>
                </ul>
            </div>
        </div>
    </div>
        <div class="container-fluid">
            
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

                    <!-- <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            <a href="{!! url('sadmin/blog/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Blog</a>
                        </div>
                    </div> -->
                    <!-- Page Content -->
                   
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="box-body table-responsive panel-body">


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


                    </div> -->
                    <div class="card">
                        <div class="header">
                            <h2><strong>Blogs</strong> List </h2>
                            <div class="prtm-block-title mrgn-b-lg">
                            </div>
                            <div class="caption">
                               <!--  <a href="{!! url('sadmin/company/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add Company</a> -->
                                <a href="{!! url('sadmin/blog/create') !!}" class="btn btn-primary hidden-sm-down float-right m-l-10" type="button">Add New Blog <i class="zmdi zmdi-plus"></i>
                                </a>

                            </div>
                        </div>
                        <div class="body">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="posts">
                                    <thead>  
                                              <tr >
                                                <th>Featured Image</th>
                                                <th>Blog Title</th>
                                                <th>Views</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                    </thead> 
                            </table>
                        </div>


                    </div>
                </div>
            </div>

                </div>
                <!-- /.end -->
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    

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