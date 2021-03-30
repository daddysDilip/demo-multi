@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Page Section</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Page Section</li>
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
                            <a href="{!! url('sadmin/cms/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Page</a>
                        </div>
                    </div>

                </div>
                <!-- /.end -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box-body table-responsive">


                      <table class="table table-bordered" id="posts">
                    <thead>  
                              <tr class="bg-primary">
                                <th>Page Name</th>
                                <th>Page Title</th>
                                <th>Publish Date</th>
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
