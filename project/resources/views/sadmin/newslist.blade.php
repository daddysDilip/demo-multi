@extends('sadmin.includes.master-sadmin')

@section('content')
    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>News</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">News</li>
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
                    <!-- /.start -->
                    <div class="col-md-12" style="padding: 0">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#sectioncontent" data-toggle="tab" aria-expanded="false"><strong>News Section Content</strong></a>
                            
                        </ul>
                    </div>

                    <div class="col-xs-12" style="padding: 0">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            
                            <div class="tab-pane active" id="sectioncontent">
                                <br>
                                <div class="prtm-block-title mrgn-b-lg">
                                    <div class="caption">
                                        <a href="{!! url('sadmin/news/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New News</a>
                                    </div>
                                </div>
                                <!-- Page Content -->
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th>News Image</th>
                                                    <th>News Name</th>
                                                    <th width="15%">Publish Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($news as $allnews)
                                                <tr>
                                                    <td><img src="{{url('/assets/images/news')}}/{{$allnews->newsimage}}" alt="" class="service-icon" width="120px" height="70px"></td>
                                                    <td>{{$allnews->newstitle}}</td>
                                                    <td>{{$allnews->created_at->format('d-m-Y')}}</td>
                                                    <td>
                                                        @if($allnews->status == 1)
                                                            <a href="{!! url('sadmin/news') !!}/status/{{$allnews->id}}/0" class="btn btn-success btn-xs">Active</a>
                                                        @elseif($allnews->status == 0)
                                                            <a href="{!! url('sadmin/news') !!}/status/{{$allnews->id}}/1" class="btn btn-danger btn-xs">Deactive</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown display-ib">
                                                            <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                                                            <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                                                <li>
                                                                    <a href="/sadmin/news/{{$allnews->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" onclick="return delete_data('{{$allnews->id}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a>
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

@stop

@section('footer')

<script type="text/javascript">

    function delete_data(reportid)
    {
        if(confirm('Are You sure You want to Delete ?'))
        {
            window.location = "{{url('/')}}/sadmin/news/delete/"+reportid;
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
                news_title:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                news_text:{ 
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