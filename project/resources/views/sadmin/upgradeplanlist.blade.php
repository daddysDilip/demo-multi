@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Plan List</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Plan List</li>
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
                            <a href="{!! url('sadmin/exportplanlist') !!}" class="btn btn-primary btn-add"><i class="fa fa-file-excel-o"></i> Export</a>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                        <thead>
                            <tr class="bg-primary">
                                <th>Company Name</th>
                                <th>Plan type</th>
                                <th>Pay Amount</th>
                                <th>Payment Date</th>
                                <th>Expiry Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upgradeplan as $alldata)
                            <tr>
                                <td><a href="{!! url('/')!!}/sadmin/company/{{$alldata->company_id}}">{{$alldata->comapany_name}}</a></td>
                                <td>{{$alldata->plantype}}</td>
                                <td>{{$alldata->payamount}}</td>
                                <td>{{date('d-m-Y',strtotime($alldata->start_date))}}</td>
                                <td>{{date('d-m-Y',strtotime($alldata->expiry_date))}}</td>
                                <td><a href="{!! url('/')!!}/sadmin/company/{{$alldata->company_id}}" class="btn btn-success btn-sm">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
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