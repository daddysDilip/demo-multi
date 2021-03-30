@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Withdraws</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Withdraws</li>
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
                            <a href="{{url('admin/withdraws/pending')}}" class="btn btn-primary"><strong>Pending Withdraws ({{\App\Withdraw::where('status','pending')->count()}})</strong></a>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                        <thead>
                        <tr class="bg-primary">
                            <th>Company Name</th>
                            <th width="10%">Vendors Email</th>
                            <th>Phone</th>
                            <th width="10%">Method</th>
                            <th width="10%">Status</th>
                            <th>Withdraw Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($withdraws as $withdraw)
                            <tr>
                                <td><a href="{{url('admin/vendors')}}/{{$withdraw->vendorid->id}}" target="_blank">{{$withdraw->vendorid->shop_name}}</a></td>
                                <td>{{$withdraw->vendorid->email}}</td>
                                <td>{{$withdraw->vendorid->phone}}</td>
                                <td>{{$withdraw->method}}</td>
                                <td>{{ucfirst($withdraw->status)}}</td>
                                <td>{{$withdraw->created_at}}</td>
                                <td>
                                    <a href="withdraws/{{$withdraw->id}}" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> View Details </a>
                                    @if($withdraw->status == "pending")
                                    <a href="withdraws/accept/{{$withdraw->id}}" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i> Accept</a>

                                    <a href="withdraws/reject/{{$withdraw->id}}" class="btn btn-danger btn-xs"><i class="fa fa-times-circle"></i> Reject</a>
                                    @endif
                                </td>
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

@stop