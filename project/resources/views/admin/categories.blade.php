@extends('admin.includes.master-admin')

@section('content')
<style type="text/css">
    html[langdir="right"] .pull-right.count_data
    {
        float: right !important;
        margin-right: 20px;
    }
</style>
    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.Categories')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.Categories')}}</li>
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
                            <a href="{!! url('admin/exportcategories') !!}" class="btn btn-primary btn-add"><i class="fa fa-download"></i> {{trans('app.Export')}}</a>

                               <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#modal-default"><i class="fa fa-file-excel-o"></i>{{trans('app.Import')}} </button>

                                <a href="http://adminuser.multiecom.com/assets/importtile/Category.xls"><button type="button" class="btn btn-primary btn-add"><i class="fa fa-file-excel-o"></i> Demo File</button></a>

                        </div>
                    </div>

                    <!-- /.start -->
                    <div class="col-md-12" style="padding: 0">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#maincat" data-toggle="tab" aria-expanded="false"><strong>{{trans('app.MainCategory')}}</strong></a></li>
                            <li><a href="#subcat" data-toggle="tab" aria-expanded="true"><strong>{{trans('app.SubCategory')}}</strong></a></li>
                            <li><a href="#childcat" data-toggle="tab" aria-expanded="true"><strong>{{trans('app.ChildCategory')}}</strong></a></li>
                        </ul>
                    </div>

                    <div class="col-xs-12" style="padding: 0">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="maincat">
                                <br>

                                <div class="prtm-block-title mrgn-b-lg">
                                    <div class="caption">
                                        <a href="{!! url('admin/categories/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> {{trans('app.AddNew')}}</a>
                                    </div>
                                </div>
                                <!-- Page Content -->
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th>{{trans('app.CategoryName')}}</th>
                                                <th>{{trans('app.Slug')}}</th>
                                                <th>{{trans('app.Status')}}</th>
                                                <th>{{trans('app.Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($categories as $category)
                                                <tr>
                                                    <td>
                                                        <!-- @if(\App\CategoryTranslations::where('categoryid',$category->id)->where('langcode',get_defaultlanguage() )->count() > 0)
                                                            {{\App\CategoryTranslations::where('categoryid',$category->id)->where('langcode',get_defaultlanguage())->first()->name}}
                                                            
                                                        @endif -->
                                                        {{$category->name}}
                                                    @if($category->featured == 1)
                                                        <label class="label label-primary">{{trans('app.Featured')}}</label>
                                                    @endif
                                                        <small class="pull-right count_data">{{trans('app.CountProduct')}}: <span class="badge bg-yellow">{{get_main($category->id)}}</span></small>
                                                    </td>
                                                    <td>{{$category->slug}}</td>
                                                    <td>
                                                        @if($category->status == 1)
                                                            <a href="#"  onclick="return count_prodect('{{$category->id}}','{{get_main($category->id)}}','{{$category->status}}');" class="btn btn-success btn-xs">{{trans('app.Active')}}</a>
                                                        @elseif($category->status == 0)
                                                            <a href="#"  onclick="return count_prodect('{{$category->id}}','{{get_main($category->id)}}','{{$category->status}}');" class="btn btn-danger btn-xs">{{trans('app.Deactive')}}</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown display-ib">
                                                            <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                                                            <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                                                <li>
                                                                    <a href="categories/{{$category->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">{{trans('app.Edit')}} </span> </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" onclick="return delete_data('{{$category->id}}','{{get_main($category->id)}}','{{$category->role}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">{{trans('app.Delete')}} </span></a>
                                                                </li>
                                                            </ul>  
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
<!-- ============================================> -->


       <!--              <div class="row">
            <div class="col-xs-12">
                <div class="box-body table-responsive">


                      <table class="table table-bordered" id="posts">
                    <thead>  
                              <tr class="bg-primary">
                                       <th>Name</th>
                                                <th>Slug</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                            </tr>
                    </thead> 
                         
               </table>


                </div>
            </div>
        </div>
         -->

<!-- ======================================== -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="subcat">
                                <br>
                                <div class="prtm-block-title mrgn-b-lg">
                                    <div class="caption">
                                        <a href="{!! url('admin/subcategory/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> {{trans('app.AddNew')}}</a>
                                    </div>
                                </div>
                                <!-- Page Content -->
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered" cellspacing="0" id="example2" width="100%">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th>{{trans('app.CategoryName')}}</th>
                                                    <th>{{trans('app.MainCategory')}}</th>
                                                    <th>{{trans('app.Slug')}}</th>
                                                    <th>{{trans('app.Status')}}</th>
                                                    <th>{{trans('app.Action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($subs as $sub)
                                                <tr>
                                                    <td>
                                                       <!--  @if(\App\CategoryTranslations::where('categoryid',$sub->id)->where('langcode',get_defaultlanguage() )->count() > 0)
                                                            {{\App\CategoryTranslations::where('categoryid',$sub->id)->where('langcode',get_defaultlanguage())->first()->name}}
                                                        @endif -->
                                                        {{$sub->name}}
                                                        @if($sub->featured == 1)
                                                            <label class="label label-primary">{{trans('app.Featured')}}</label>
                                                        @endif
                                                        <small class="pull-right count_data">{{trans('app.CountProduct')}}: <span class="badge bg-yellow">{{get_main($sub->id)}}</span></small>
                                                    </td>
                                                    <td>{{$sub->mainid->name}} </td>
                                                    <td>{{$sub->slug}}</td>
                                                    <td>
                                                        @if($sub->status == 1)
                                                            <a href="#"  onclick="return count_prodect('{{$sub->id}}','{{get_main($sub->id)}}','{{$sub->status}}');" class="btn btn-success btn-xs">{{trans('app.Active')}}</a>
                                                        @elseif($sub->status == 0)
                                                            <a href="#"  onclick="return count_prodect('{{$sub->id}}','{{get_main($sub->id)}}','{{$sub->status}}');" class="btn btn-danger btn-xs">{{trans('app.Deactive')}}</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown display-ib">
                                                            <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                                                            <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                                                <li>
                                                                    <a href="subcategory/{{$sub->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">{{trans('app.Edit')}} </span> </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" onclick="return delete_data('{{$sub->id}}','{{get_main($sub->id)}}','{{$sub->role}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">{{trans('app.Delete')}} </span></a>
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
                            <div class="tab-pane" id="childcat">
                                <br>
                                <div class="prtm-block-title mrgn-b-lg">
                                    <div class="caption">
                                        <a href="{!! url('admin/childcategory/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> {{trans('app.AddNew')}}</a>
                                    </div>
                                </div>
                                <!-- Page Content -->
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered" cellspacing="0" id="example3" width="100%">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th>{{trans('app.CategoryName')}}</th>
                                                <th>{{trans('app.MainCategory')}}</th>
                                                <th>{{trans('app.SubCategory')}}</th>
                                                <th>{{trans('app.Slug')}}</th>
                                                <th>{{trans('app.Status')}}</th>
                                                <th>{{trans('app.Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($child as $data)
                                                <tr>
                                                    <td>
                                                        {{$data->name}}
                                                       <!--  @if(\App\CategoryTranslations::where('categoryid',$data->id)->where('langcode',get_defaultlanguage() )->count() > 0)
                                                            {{\App\CategoryTranslations::where('categoryid',$data->id)->where('langcode',get_defaultlanguage())->first()->name}}
                                                        @endif -->
                                                        @if($data->featured == 1)
                                                            <label class="label label-primary">{{trans('app.Featured')}}</label>
                                                        @endif
                                                        <small class="pull-right count_data">{{trans('app.CountProduct')}}: <span class="badge bg-yellow">{{get_main($data->id)}}</span></small>
                                                    </td>
                                                    <td>{{$data->mainid->name}}</td>
                                                    <td>{{$data->subid->name}}</td>
                                                    <td>{{$data->slug}}</td>
                                                    <td>
                                                        @if($data->status == 1)
                                                            <a href="#" onclick="return count_prodect('{{$data->id}}','{{get_main($data->id)}}','{{$data->status}}');" class="btn btn-success btn-xs">{{trans('app.Active')}}</a>
                                                        @elseif($data->status == 0)
                                                            <a href="#" onclick="return count_prodect('{{$data->id}}','{{get_main($data->id)}}','{{$data->status}}');" class="btn btn-danger btn-xs">{{trans('app.Deactive')}}</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown display-ib">
                                                            <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                                                            <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                                                <li>
                                                                    <a href="childcategory/{{$data->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">{{trans('app.Edit')}} </span> </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" onclick="return delete_data('{{$data->id}}','{{get_main($data->id)}}','{{$data->role}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">{{trans('app.Delete')}} </span></a>
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
                <!-- /.end -->
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
                    <form method="POST" action="{!! action('CategoryController@import',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="blog_form">
                        {{csrf_field()}}


                               <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Category Import <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <img id="image_view" class="image_view">
                                <button id="upload_files" onclick="document.getElementById('imported_file').click(); return false;">{{trans('app.SelectFile')}}</button>
                                <input type="File" name="imported_file" id="imported_file" accept="application/vnd.ms-excel">

                              <!--   <input type="File" name="imported_file" id="imported_file" accept="application/vnd.ms-excel" required=""> -->

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

<script type="text/javascript">

    function delete_data(reportid,count)
    {
        if(count > 0)
        {
            alert('You can not delete this category Because this category use by another. Please contact to admin.');
        }
        else
        {

            if(confirm('Are You sure You want to Delete ?'))
            {
                window.location = "{{url('/')}}/admin/categories/delete/"+reportid;
                return true;
            }
            else
            {
                return false;
            }
        }

    }


    function count_prodect(reportid,prodect,status)
    {
        if(prodect > 0)
        {
            alert('You can not change status this category Because this category use by another. Please contact to admin.');
        }
        else
        {       
            if(status == 1)
            {   
                window.location = "{{url('/')}}/admin/categories/status/"+reportid+"/0";
                return true;
            }
            else
            {
                window.location = "{{url('/')}}/admin/categories/status/"+reportid+"/1";
                return true;
            }                                 
        }

     
    }

            $(document).ready(function(){
          $('#blog_form').validate({
            rules:{
            imported_file:{
            required: true,
            extension: "xlsx|xls"
            }
            },
            messages:{
                    imported_file:{
                        extension:"Please uplaod xlsx and xls file",
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