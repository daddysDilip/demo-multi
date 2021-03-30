@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.Plan')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/plans') !!}">{{trans('app.Plan')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.ManagePlan')}}</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('admin/upgradeplan')}}/{{$plan->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="news_form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$plan->id}}">
                        <input type="hidden" name="_method" value="PATCH">
						@php
                        $companyid = get_company_id();
                        $total_product = App\Product::where('company_id',$companyid)->count(); 
                        $productlimit = $plan->product_limit;
                        @endphp
                        <div class="col-md-12">                                
                            <div class="prtm-block">
                                <div class="horizontal-form-style">

                                    <div class="prtm-block-title mrgn-b-lg">
                                        <h3>{{trans('app.SwitchPlan')}}</h3>
                                        <p></p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h4><b>{{trans('app.CurrentPlan')}}</b></h4>
                                            <p>{{$currentplan->plantype}}</p>
                                            <p>{{$settings[0]->currency_sign}} {{$currentplan->payamount}} / Mo</p><br><br>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="hidden" name="planid" value="{{$plan->id}}">
                                            <input type="hidden" name="payamount" value="{{$plan->planamount}}">

                                            <h4><b>{{trans('app.NewPlan')}}</b></h4>
                                            <p>{{$plan->plantype}}</p>
                                            <p>{{$settings[0]->currency_sign}} {{$plan->planamount}} / Mo</p><br><br>
                                        </div>
                                        <p></p>

                                        <div class="col-md-12">
                                            <?php if($total_product <= $productlimit) { ?>
                                                <p><b>{{trans('app.WhyYouSwitchingPlan')}}</b></p>
                                                <input type="radio" name="switch_plan" value="No longer planning to work"> {{trans('app.NoLongerPlanningWork')}} <br><br>
                                                <input type="radio" name="switch_plan" value="Changed my mind"> {{trans('app.ChangedMyMind')}} <br><br>
                                                <input type="radio" name="switch_plan" value="Costs too much"> {{trans('app.CostsTooMuch')}} <br><br>
                                                <input type="radio" name="switch_plan" value="Billing method no longer valid"> {{trans('app.BillingMethodNoLongerValid')}} <br><br>
                                                <input type="radio" name="switch_plan" value="Other"> {{trans('app.Other')}} <br><br>
                                            <?php } else { ?>
                                                <h4 class="text-red" style="color:red;"><?php echo  trans('app.ProductLimitMsg', [ 'total_product' =>  $total_product, 'productlimit' => $productlimit ]) ?></h4>
                                            <?php } ?>
                                        </div>
                
                                        <div class="form-group col-md-12">
                                            <div class="col-sm-5">
                                                <?php if($total_product <= $productlimit) { ?>
                                                    <button type="submit" name="submit" class="btn btn-primary switch_plan_btn" disabled="disabled">{{trans('app.Save')}}</button>
                                                <?php } ?>
                                                <a href="{!! url('admin/upgradeplan') !!}" name="cancel" class="btn btn-danger"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')
<script type="text/javascript">

    $(document).ready(function(){

        $('input[name="switch_plan"]').change(function(){

            if($('input[name="switch_plan"]').is(":checked"))
            {
                $('.switch_plan_btn').removeAttr('disabled','disabled');
            }
        });

    });
</script>
@stop