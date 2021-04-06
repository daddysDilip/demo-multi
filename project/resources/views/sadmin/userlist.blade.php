@extends('sadmin.includes.master-sadmin2')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>User Section</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item active">User Section</li>
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
              <a href="{!! url('sadmin/user/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New User</a>
          </div>
      </div>
      <div class="row clearfix">
        <div class="col-lg-12">
          <div class="card">

           <div class="body">
            <table class="table table-bordered table-striped table-hover dataTable js-exportable" cellspacing="0"  id="posts" width="100%">

              <thead>  
                <tr class="">
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Status</th>
                  <th>Actions</th>
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
                     "url": "{{ url('sadmin/allpostuser') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "name"},
                { "data": "email"},
                { "data": "phone"},
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
            window.location = "{{url('/')}}/sadmin/user/delete/"+reportid;
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