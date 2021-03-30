@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Products</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Products</li>
                </ul>
            </div>
                <!-- Page Content -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="response">
                            @php 
                                $companyid = get_company_id();
                                $productlimit = get_plan_productlimit(); 
                                $total_product = App\Product::where('company_id',$companyid)->count(); 
                            @endphp
                            @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                        </div>

                        <div class="prtm-block-title mrgn-b-lg">
                          
                        <div class="caption">
                            @if(@$total_product != 0)
                            <a href="{!! url('admin/exportprodect') !!}" class="btn btn-primary btn-add"><i class="fa fa-file-excel-o"></i> Export</a>

                            @endif
                            <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#modal-default"><i class="fa fa-file-excel-o"></i> Import</button>

                            <a href="http://adminuser.multiecom.com/assets/importtile/Products.xls"><button type="button" class="btn btn-primary btn-add"><i class="fa fa-file-excel-o"></i> Demo File</button></a>
                                
                        </div>
                        
                    </div>

                        <div class="prtm-block-title mrgn-b-lg">
                            <div class="caption">
                                @if($total_product < $productlimit)
                                    <a href="{!! url('admin/products/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Product</a>
                                @else
                                    <h5 style="color:red;"><b>Product Add Limit over</b></h5>
                                @endif
                            </div>
                        </div>
                        <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr class="bg-primary">
                                    <!-- <th width="10%">ID#</th> -->
                                    <th>Product Title</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

      <!-- ============================================= MOdel import=========== -->
           <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('app.ImportFile')}}</h4>
                </div>

                <div class="modal-body">
                    <!-- Page Content -->
                    <div id="response"></div>


                         <form method="POST" action="{!! action('ProductController@import',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="blog_form">
                        {{csrf_field()}}

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Import')}} <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <img id="image_view" class="image_view">
                                <button id="upload_files" onclick="document.getElementById('imported_file').click(); return false;">{{trans('app.SelectFile')}}</button>
                                <input type="File" name="imported_file" id="imported_file" accept="application/vnd.ms-excel">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{trans('app.Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{trans('app.Save')}}</button>
                        </div> 
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- =============================================Over Model import=========== -->


@stop

@section('footer')



<script type="text/javascript">

    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsproduct') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
           
                { "data": "title"},
                { "data": "price"},
                { "data":"stock"},
                { "data": "category"},
                { "data": "status"},
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
            window.location = "{{url('/')}}/admin/products/delete/"+reportid;
            return true;
        }
        else
        {
            return false;
        }
    }
</script>

@stop