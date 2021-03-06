@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Vendor Details</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Vendor Details</li>
                </ul>
            </div>
                
            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">

                    <table class="table">
                        
                        <tbody>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Vendor ID#</strong></td>
                            <td>{{$vendor->id}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Vendors Company Name:</strong></td>
                            <td>{{$vendor->shop_name}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Total Products:</strong></td>
                            <td><strong>{{\App\Product::where('vendorid',$vendor->id)->count()}}</strong></td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Vendor Name:</strong></td>
                            <td>{{$vendor->name}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Vendor Email:</strong></td>
                            <td>{{$vendor->email}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Vendor Phone:</strong></td>
                            <td>{{$vendor->phone}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Vendor Fax:</strong></td>
                            <td>{{$vendor->fax}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Vendor Address:</strong></td>
                            <td>{{$vendor->address}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Vendor City:</strong></td>
                            <td>{{$vendor->city}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Vendor Zip:</strong></td>
                            <td>{{$vendor->zip}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><strong>Joined:</strong></td>
                            <td>{{$vendor->created_at->diffForHumans()}}</td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align: right;"><a href="email/{{$vendor->id}}" class="btn btn-primary"><i class="fa fa-send"></i> Contact Vendor</a></td>
                            <td><a href="{!! url('admin/vendors') !!}" class="btn btn-danger btn-add"><i class="fa fa-arrow-left"></i> Cancel</a></td>
                        </tr>

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