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
                               <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            
                            <a href="{!! url('admin/products') !!}" class="btn btn-primary btn-add"> Back</a>
                        
                                  
                        
                        </div>
                    </div>


                        <div id="response">





                                @php $count=count($prodectarray);
                                       $i=1; 
                                         @endphp
        
                    
                        @forelse(@$prodectarray as $alldata)


                            @if(@$alldata['status'] == 'YES')
                                <div class="alert alert-success alert-dismissable">
                                 <!--    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                                    <p> <?php echo  $i."/".$count;?></p>
                                    <p>Prodect :- {{$alldata['product']}}</p>
                                    <p>New Product Added Successfully</p>   

                                </div>
                            @else


                                <div class="alert alert-danger alert-dismissable">
                                  <!--   <a href="#" class="close" data-dismiss="alert" aria-label="close"></a> -->
                                    <p><?php echo $i."/".$count;?></p>
                                    <p>Prodect :- {{$alldata['product']}}</p>
                                    <p>Status :- Already exist</p> 
                                </div>
                            @endif
                            <?php $i++; ?>

                            @empty
                            @endforelse

                        </div>

                 
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import File</h4>
              </div>

              <div class="modal-body">
                 <!-- Page Content -->
            <!-- <div class="panel panel-default"> -->
                <!-- <div class="panel-body"> -->
                    <div id="response"></div>
                <form method="POST" action="{!! action('ProductController@import',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="blog_form">
                        {{csrf_field()}}


                               <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Import <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                          

                                <input type="File" name="imported-file" id="imported-file" accept="application/vnd.ms-excel">

                            </div>
                        </div>

                                <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div> 


                   </form>
                   <!-- </div> -->
                   <!-- </div> -->
               


   </div>

           <!--    <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div> -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

          <!-- =============================================Over MOdel import=========== -->

@stop

@section('footer')

@stop