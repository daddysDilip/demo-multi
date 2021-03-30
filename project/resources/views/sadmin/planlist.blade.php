@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Plan</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Plan</li>
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
                            <a href="{!! url('sadmin/plans/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Plan</a>
                        </div>
                    </div>
                    <div class="prtm-block-content plan_detail">
                        <div class="dataTables_wrapper">
                            <div class="row">
                                
                            
                        @foreach($plan as $allplan)
                            <div class="col-sm-12 col-md-12 col-lg-4 mrgn-b-lg plan_list">
                                <div class="prtm-block text-center">
                                    <div class="contextual-link" style="padding: 20px 40px;">
                                        <div class="dropdown"> 
                                            <a href="javascript:;" class="more-btn" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">more<i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown-menu dropdown-icon dropdown-menu-right">
                                            <li>
                                                <a href="plans/{{$allplan->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>
                                            </li>
                                            <li>
                                                <!-- <a href="#" onclick="return delete_data('{{$allplan->id}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a> -->
                                            </li>
                                        </ul>
                                        </div>
                                    </div>
                                    <div class="mrgn-b-lg">
                                        <h2 class="pricing-title base-dark">
                                            <sup>₹</sup>
                                            {{$allplan->planamount}}
                                            <sub class="sub-title">/Mo</sub>
                                        </h2> 
                                    </div>
                                    <div class="mrgn-b-lg">
                                        <h2 class="base-dark fw-light">{{$allplan->plantype}}</h2>
                                        <h5 class="plan_title" style="text-align: center;">{{$allplan->plantitle}}</h5>
                                    </div>
                                    <div class="pricing-content mrgn-b-lg">
                                        <ul class="list-unstyled base-dark">
                                            <li>{!! htmlspecialchars_decode($allplan->description) !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
            window.location = "{{url('/')}}/sadmin/plans/delete/"+reportid;
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