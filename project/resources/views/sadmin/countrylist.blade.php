@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Country</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Country</li>
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
                            <a href="{!! url('sadmin/country/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Country</a>
                        </div>
                    </div>
                <!--     <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                        <thead>
                        <tr class="bg-primary">
                            <th>Country Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($country as $alldata)
                                <tr>
                                    <td>{{$alldata->countryname}}</td>
                                    <td>
                                        @if($alldata->status == 1)
                                            <a href="{!! url('sadmin/country') !!}/status/{{$alldata->id}}/0" class="btn btn-success btn-xs">Active</a>
                                        @elseif($alldata->status == 0)
                                            <a href="{!! url('sadmin/country') !!}/status/{{$alldata->id}}/1" class="btn btn-danger btn-xs">Deactive</a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown display-ib">
                                            <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                                            <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                                <li>
                                                    <a href="country/{{$alldata->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>
                                                </li>
                                                <li>
                                                    <a href="#" onclick="return delete_data('{{$alldata->id}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a>
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
                            <th>Country Name</th>
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
                     "url": "{{ url('sadmin/allpostcountry') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "countryname"},
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
            window.location = "{{url('/')}}/sadmin/country/delete/"+reportid;
            return true;
        }
        else
        {
            return false;
        }
    }

</script>

@stop