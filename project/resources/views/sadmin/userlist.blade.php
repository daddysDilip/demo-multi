@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>User Section</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">User Section</li>
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
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            <a href="{!! url('sadmin/user/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New User</a>
                        </div>
                    </div>
                    <!--  <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                        <thead>
                            <tr class="bg-primary">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($user as $alluser)
                            <tr>
                                <td>{{$alluser->name}}</td>
                                <td>{{$alluser->email}}</td>
                                <td>{{$alluser->phone}}</td>
                               
                                <td>
                                    @if($alluser->status == 1)
                                        <a href="{!! url('sadmin/user') !!}/status/{{$alluser->id}}/0" class="btn btn-success btn-xs">Active</a>
                                    @elseif($alluser->status == 0)
                                        <a href="{!! url('sadmin/user') !!}/status/{{$alluser->id}}/1" class="btn btn-danger btn-xs">Deactive</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown display-ib">
                                        <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                                        <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                            <li>
                                                <a href="user/{{$alluser->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>
                                            </li>
                                            <li>
                                                <a href="#" onclick="return delete_data('{{$alluser->id}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a>
                                            </li>
                                        </ul>  
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table> -->





                         <div class="row">
            <div class="col-xs-12">
                <div class="box-body table-responsive">


                      <table class="table table-bordered" id="posts">
                    <thead>  
                              <tr class="bg-primary">
                               <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                    </thead> 
                    <tbody>
                        <tr>
                            <td>helloo</td>
                            <td>hellooo2</td>
                           
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
                     "url": "{{ url('sadmin/allpostuser') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "name"},
                { "data": "email"},
                { "data": "phone"},
                { "data": "status"},
                { "data": "actions"},
            ]    
        });
    });
</script>

<script type="text/javascript">

    function delete_data(reportid)
    {
        if(confirm('Are You sure You want to Delete ?'))
        {
            window.location = "{{url('/')}}/sadmin/user/delete/"+reportid;
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