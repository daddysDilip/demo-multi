@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Vendors</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/vendors') !!}">Vendors</a></li>
                    <li class="breadcrumb-item">Vendors Pending</li>
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
                    <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                        <thead>
                        <tr>
                            <th>Vendor Name</th>
                            <th width="10%">Vendor Email</th>
                            <th>Phone</th>
                            <th width="10%">Address</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vendors as $vendor)
                            <tr>
                                <td>{{$vendor->name}}</td>
                                <td>{{$vendor->email}}</td>
                                <td>{{$vendor->phone}}</td>
                                <td>{{$vendor->address}}</td>
                                <td>Pending</td>

                                <td>

                                    <a href="{{url('admin/vendors')}}/{{$vendor->id}}" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> View Details </a>

                                    <a href="{{url('admin/vendors/accept')}}/{{$vendor->id}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Accept</a>
                                    <a href="{{url('admin/vendors/reject')}}/{{$vendor->id}}" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Reject</a>

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