@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize"><h3>{{ trans('app.AccessDenied') }}</h3></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{ trans('app.Home') }}</a></li>
                </ul>
            </div>

            
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ trans('app.AccessDenied') }}
            </div>
           
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')

@stop