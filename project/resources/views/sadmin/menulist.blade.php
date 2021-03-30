@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Menu Section</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Menu Section</li>
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
                            <a href="{!! url('sadmin/menus/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Menu</a>
                        </div>
                    </div>
                     <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                        <thead>
                            <tr class="bg-primary">
                                <th>Menu Name</th>
                                <th>Path</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($allmenus as $allmenu)
                            <tr>
                                <td>{{$allmenu->name}}</td>
                                <td>{{$allmenu->path}}</td>
                                <td>{{$allmenu->menuorder}}</td>
                                
                                <td>
                                    @if($allmenu->status == 1)
                                        <a href="{!! url('sadmin/menus') !!}/status/{{$allmenu->id}}/0" class="btn btn-success btn-xs">Active</a>
                                    @elseif($allmenu->status == 0)
                                        <a href="{!! url('sadmin/menus') !!}/status/{{$allmenu->id}}/1" class="btn btn-danger btn-xs">Deactive</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown display-ib">
                                        <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                                        <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                            <li>
                                                <a href="menus/{{$allmenu->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>
                                            </li>
                                            <li>
                                                <a href="#" onclick="return delete_data('{{$allmenu->id}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a>
                                            </li>
                                        </ul>  
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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

    function delete_data(reportid)
    {
        if(confirm('Are You sure You want to Delete ?'))
        {
            window.location = "{{url('/')}}/sadmin/menus/delete/"+reportid;
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