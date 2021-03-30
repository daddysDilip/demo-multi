@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Vendors</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Vendors</li>
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
                            <a href="{{url('admin/vendors/pending')}}" class="btn btn-primary"><strong>Pending Vendors ({{\App\Vendors::where('status', 0)->count()}})</strong></a>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                        <thead>
                        <tr class="bg-primary">
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
                                <td>
                                    @if($vendor->status == 1)
                                        <a href="{!! url('admin/vendors') !!}/status/{{$vendor->id}}/0" class="btn btn-success btn-xs">Active</a>
                                    @elseif($vendor->status == 0)
                                        <a href="{!! url('admin/vendors') !!}/status/{{$vendor->id}}/1" class="btn btn-danger btn-xs">Deactive</a>
                                    @endif
                                </td>
                                <td>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="vendors/{{$vendor->id}}" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> View Details </a>

                                    <a href="vendors/email/{{$vendor->id}}" class="btn btn-primary btn-xs"><i class="fa fa-send"></i> Send Email</a>

                                    <a href="javascript:;" data-href="{{url('/')}}/admin/vendors/delete/{{$vendor->id}}" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove</a><br>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>


@stop

@section('footer')

<script type="text/javascript">
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

@stop