@extends('admin.includes.master-admin2')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>{{trans('app.Customers')}}</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}"><i class="zmdi zmdi-home"></i> {{trans('app.Home')}}</a></li>
        <li class="breadcrumb-item active">{{trans('app.Customers')}}</li>
      </ul>
    </div>
  </div>
</div>
<div class="container-fluid">
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
              @if(count($customers) > 0)
                <a href="{!! url('admin/exportcustomer') !!}" class="btn btn-primary btn-add"><i class="fa fa-download"></i> {{trans('app.Export')}}</a>
              @endif
          </div>
      </div>
      <div class="row clearfix">
        <div class="col-lg-12">
          <div class="card">

           <div class="body">
            <table class="table table-bordered table-striped table-hover dataTable js-exportable" cellspacing="0"  id="posts" width="100%">

              <thead>
                <tr class="">
                  <th>{{trans('app.CustomerName')}}</th>
                  <th width="10%">{{trans('app.CustomerEmail')}}</th>
                  <th>{{trans('app.Phone')}}</th>
                  <th width="10%">{{trans('app.RegisteredOn')}}</th>
                  <th>{{trans('app.Status')}}</th>
                  <th>{{trans('app.Action')}}</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@stop

@section('footer')

<script type="text/javascript">

    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsadmincustomers') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [                
                { "data": "firstname"},
                { "data": "email"},
                { "data": "phone"},
                { "data": "registeredOn"},
                { "data": "status"},
                { "data": "action"},
            ]    
        });
    });
    
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

@stop