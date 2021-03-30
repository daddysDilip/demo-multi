@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.UpgradePlanOptions')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.UpgradePlanOptions')}}</li>
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
                    
                    <div class="prtm-block-content mrgn-b-lg plan_detail">
                        <div class="standered-table">
                        @foreach($plan as $allplan)
                            @if($upgradeplan->planid == $allplan->id)
                            <div class="col-sm-12 col-md-12 col-lg-4 mrgn-b-lg pad-all-none z-index plan_list">
                                <div class="prtm-block text-center active">
                            @else
                            <div class="col-sm-12 col-md-12 col-lg-4 mrgn-b-lg pad-all-none plan_list">
                                <div class="prtm-block text-center">
                            @endif
                                    <div class="mrgn-b-lg">
                                        <h2 class="pricing-title base-dark">
                                            <sup>₹</sup>
                                            {{$allplan->planamount}}
                                            <sub class="sub-title">/Mo</sub>
                                        </h2> 
                                    </div>
                                    <div class="mrgn-b-lg">
                                        <h2 class="plan_title base-dark fw-light">{{$allplan->plantype}}</h2>
                                        @if($upgradeplan->planid == $allplan->id)<h5 style="text-align: center;color: #fff;">{{$allplan->plantitle}}</h5>@else<h5 style="text-align: center;">{{$allplan->plantitle}}</h5>@endif
                                    </div>
                                    <div class="pricing-content mrgn-b-lg">
                                        <ul class="list-unstyled base-dark">
                                            <li>{!! htmlspecialchars_decode($allplan->description) !!}</li>
                                        </ul>
                                    </div>
                                    <div class="get-started">
                                        @php
                                            $todaydate = date('Y-m-d'); 
                                            $expirydate = date('Y-m-d',strtotime($upgradeplan->expiry_date));
                                        @endphp
                                        @if($expirydate > $todaydate)
                                        <a href="#" class="btn btn-primary" disabled="">{{trans('app.SwitchtoBasic')}}</a>
                                        @else
                                        <a href="{{ url('/') }}/admin/upgradeplan/buyplan/{{$allplan->id}}" class="btn btn-primary">{{trans('app.SwitchtoBasic')}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
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