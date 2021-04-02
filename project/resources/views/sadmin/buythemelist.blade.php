@extends('sadmin.includes.master-sadmin2')

@section('content')

   {{--  <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Theme Buyer List</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Theme Buyer List</li>
                </ul>
            </div> --}}
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Theme Buyer List
                
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Theme Buyer List</li>
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
                            <a href="{!! url('sadmin/exportthemebuyer') !!}" class="btn btn-primary btn-add"><i class="fa fa-file-excel-o"></i> Export</a>
                        </div>
                    </div>
                    <div class="row clearfix">
                      <div class="col-lg-12">
                        <div class="card">
                          <div class="header">
                            <h2><strong>Theme Buyer</strong> List </h2>
                            <div class="prtm-block-title mrgn-b-lg">
                            </div>
                            <div class="caption">
                                <a href="{!! url('sadmin/company/create') !!}" class="btn btn-primary hidden-sm-down float-right m-l-10" type="button">Add Company <i class="zmdi zmdi-plus"></i>
                                </a>

                            </div>
                          </div>
                    <div class="body">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" cellspacing="0"  id="posts" width="100%">
                        <thead>
                        <tr class="">
                            <th>Theme Name</th>
                            <th>Company Name</th>
                            <th>Payment</th>
                            <th>Payment Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        {{-- <tbody>
                            @foreach($buytheme as $alldata)
                                <tr>
                                    <td>{{$alldata->themename}}</td>
                                    <td><a href="{!! url('/')!!}/sadmin/company/{{$alldata->company_id}}">{{$alldata->comapany_name}}</a></td>
                                    <td>{{$alldata->payment}}</td>
                                    <td>{{$alldata->created_at->format('jS M Y')}}</td>
                                    <td><a href="{!! url('/')!!}/sadmin/company/{{$alldata->company_id}}" class="btn btn-success btn-sm">View</a></td>
                                </tr>
                            @endforeach
                        </tbody> --}}
                    </table>
                </div>
                </div>
              </div>
            </div>
                         <!--                <div class="row">
                        <div class="col-xs-12">
                            <div class="box-body table-responsive">


                                  <table class="table table-bordered" id="posts">
                                <thead>  
                                          <tr class="bg-primary">
                                         <th>Theme Name</th>
                                        <th>Company Name</th>
                                        <th>Payment</th>
                                        <th>Payment Date</th>
                                        <th>Actions</th>
                                        </tr>
                                </thead> 
                                <tbody>
                                   
                                </tbody>            
                           </table>


                            </div>
                        </div>
                    </div> -->

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
                     "url": "{{ url('sadmin/allpoststhemebuyer') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                    


                { "data": "themeid"},
                { "data": "companyname"},
                { "data": "payment"},
                { "data": "paymentdate"},
                { "data": "action"},

            ]    

        });
    });
</script>

<script type="text/javascript">

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