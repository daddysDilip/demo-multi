@extends('sadmin.includes.master-sadmin2')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>State</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item active">State</li>
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
              <div class="row">
                <div class="col-lg-6">
                  <h2><strong>State</strong> List </h2>
                  <div class="prtm-block-title mrgn-b-lg">
                  </div>
                  {{-- <label class="control-label" >Select Country :</label> --}}
                  <select name="country" id="country" class="form-control"  autocomplete="off">
                    <option value="0" selected="selected">Select Country</option>
                    @foreach($country as $countries) { ?>  
                      @if($countries->id == $cid)           
                      <option value="{{$countries->id}}" selected="selected">{{$countries->countryname}}</option>
                      @else
                      <option value="{{$countries->id}}">{{$countries->countryname}}</option>
                      @endif
                    @endforeach  
                  </select>
                </div>
                <div class="col-lg-6">
                  <div class="caption">
                <a href="{!! url('sadmin/state/create') !!}" class="btn btn-primary hidden-sm-down float-right m-l-10" type="button">Add New State <i class="zmdi zmdi-plus"></i>
                  </a>
                
              </div>
                </div>

              </div>
              
              
            </div>
            <div class="body">
              <table class="table table-bordered table-striped table-hover dataTable js-exportable" cellspacing="0"  id="posts" width="100%">
                <thead>
                  <tr class="">
                    <th>State Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
              <tbody>
              @foreach($state as $alldata)
              <tr>
                <td>{{$alldata->statename}}</td>
                  <td>
                    @if($alldata->status == 1)
                      <a href="{!! url('sadmin/state') !!}/status/{{$alldata->id}}/0" class="btn btn-success btn-xs">Active</a>
                    @elseif($alldata->status == 0)
                      <a href="{!! url('sadmin/state') !!}/status/{{$alldata->id}}/1" class="btn btn-danger btn-xs">Deactive</a>
                    @endif
                  </td>
                  <td>
                    <div class="dropdown display-ib">
                      <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                      <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                        <li>
                          <a href="{!! url('sadmin/state') !!}/{{$alldata->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>
                        </li>
                        <li>
                          <a href="#" onclick="return delete_data('{{$alldata->id}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a>
                        </li>
                      </ul>  
                    </div>
                  </td>
                </tr>
              @endforeach
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

@stop
@section('footer')
<script type="text/javascript">
  $(document).ready(function(){
    var countryval = $('#country').val();
    $("#country").change(function(){    
      var cval = $(this).val();
      document.location = "{{url('/')}}/sadmin/state/statelist/"+cval;          
    }); 
  });
  function delete_data(reportid)
  {
    if(confirm('Are You sure You want to Delete ?'))
    {
      window.location = "{{url('/')}}/sadmin/state/delete/"+reportid;
        return true;
    }
    else
    {
      return false;
    }
  }
  $('#posts').DataTable({
      "order": [[ 1, "asc" ]], //or asc 
    });
</script>
@stop