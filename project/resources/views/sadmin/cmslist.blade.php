@extends('sadmin.includes.master-sadmin2')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>Page Section</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item active">Page Section</li>
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
              <a href="{!! url('sadmin/cms/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Page</a>
          </div>
      </div>
      <div class="row clearfix">
        <div class="col-lg-12">
          <div class="card">

           <div class="body">
            <table class="table table-bordered table-striped table-hover dataTable js-exportable" cellspacing="0"  id="posts" width="100%">
              <thead>
                <tr class="">
                    <th>Page Name</th>
                    <th>Page Title</th>
                    <th>Publish Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
              </thead> 
              <tbody>
              </tbody>            
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
                     "url": "{{ url('sadmin/allpostscms') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "name"},
                { "data": "title"},
                { "data": "date"},
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
            window.location = "{{url('/')}}/sadmin/cms/delete/"+reportid;
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
    
    $(document).ready(function(){

        $('#website_form').validate({
            rules:{
                cms_title:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                cms_text:{ 
                    minlength: 3,
                    maxlength: 255,
                }
            },
            highlight: function (element) {
                $(element).parent().addClass('has-error')
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('has-error')
            },
            errorElement: 'span',
            errorClass: 'text-danger',
        });

    });
</script>

@stop
