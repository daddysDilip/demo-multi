@extends('sadmin.includes.master-sadmin2')
@section('content')

<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>Country
            
      </h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item active">Country</li>
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
      <div class="row clearfix">
        <div class="col-lg-12">
          <div class="card">
            <div class="header">
              <h2><strong>Country</strong> List </h2>
              <div class="prtm-block-title mrgn-b-lg">
              </div>
              <div class="caption">
                <a href="{!! url('sadmin/country/create') !!}" class="btn btn-primary hidden-sm-down float-right m-l-10" type="button">Add New Country <i class="zmdi zmdi-plus"></i>
                  </a>
              </div>
            </div>
            <div class="body">
              <table class="table table-bordered table-striped table-hover dataTable js-exportable" cellspacing="0"  id="posts" width="100%">
                <thead>  
                  <tr class="">
                    <th>Country Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead> 
                <tbody>
                  <tr>
                    <td>helloo</td>
                    <td>hellooo2</td>
                    <td>heleoeoeo4</td>
                  </tr>
                </tbody>            
              </table>
            </div>
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
          "url": "{{ url('sadmin/allpostcountry') }}",
          "dataType": "json",
          "type": "POST",
          "data":{ _token: "{{csrf_token()}}"}
       },
       "columns": [
          { "data": "countryname"},
          { "data": "status"},
          { "data": "actions"},
        ]    
    });
  });
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