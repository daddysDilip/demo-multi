@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Contact Us Section</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Contact Us</li>
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
                            @if(count($contactus) > 0)
                            <a href="{!! url('sadmin/exportcontactus') !!}" class="btn btn-primary btn-add"><i class="fa fa-file-excel-o"></i> Export</a>
                            @endif
                        </div>
                    </div>
                 <!--    <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                        <thead>
                        <tr class="bg-primary">
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Published Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($contactus as $alldata)
                                <tr>
                                    <td>{{$alldata->name}}</td>
                                    <td>{{$alldata->phone}}</td>
                                    <td>{{$alldata->email}}</td>
                                    <td>{{$alldata->message}}</td>
                                    <td>{{date("jS, M Y", strtotime($alldata->created_at))}}</td>
                                    <td>
                                        @if($alldata->status == 1)
                                        <a href="{!! url('sadmin/contactus') !!}/status/{{$alldata->id}}/0" class="btn btn-success btn-xs">Active</a>
                                        @elseif($alldata->status == 0)
                                        <a href="{!! url('sadmin/contactus') !!}/status/{{$alldata->id}}/1" class="btn btn-danger btn-xs">Deactive</a>
                                        @endif
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
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Published Date</th>
                            <th>Status</th>
                            </tr>
                    </thead> 
                           
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
                     "url": "{{ url('sadmin/allpostscontact') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "name"},
                { "data": "phone"},
                { "data": "email"},
                { "data": "message"},
                { "data": "date"},
                { "data": "status"},



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