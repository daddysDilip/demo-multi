@extends('admin.includes.master-admin')

@section('content')

@php $companyid = get_company_id(); @endphp

<div class="prtm-content-wrapper">
    <div class="prtm-content">
        <!-- Page Heading -->
        <div class="row prtm-sparkline-v2">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="mrgn-b-lg prtm-card-box pad-all-sm prtm-sparkline-v2-list">
                    <div class="row">
                        <div class="dashboard-product-image col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <p class="base-dark">{{ trans('app.TotalProducts') }}!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Product::where('company_id',$companyid)->count() }}">{{ \App\Product::where('company_id',$companyid)->count() }}</span> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="mrgn-b-lg prtm-card-box pad-all-sm prtm-sparkline-v2-list">
                    <div class="row">
                        <div class="dashboard-product-image col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <i class="fa fa-usd"></i>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <p class="base-dark">{{ trans('app.OrdersPending') }}!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Order::where('payment_status','Completed')->where('status','pending')->where('company_id',$companyid)->count() }}">{{ \App\Order::where('payment_status','Completed')->where('status','pending')->where('company_id',$companyid)->count() }}</span> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="mrgn-b-lg prtm-card-box pad-all-sm prtm-sparkline-v2-list">
                    <div class="row">
                        <div class="dashboard-product-image col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <p class="base-dark">{{ trans('app.OrdersProcessing') }}!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Order::where('payment_status','Completed')->where('status','processing')->where('company_id',$companyid)->count() }}">{{ \App\Order::where('payment_status','Completed')->where('status','processing')->where('company_id',$companyid)->count() }}</span> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="mrgn-b-lg prtm-card-box pad-all-sm prtm-sparkline-v2-list">
                    <div class="row">
                        <div class="dashboard-product-image col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <p class="base-dark">{{ trans('app.OrdersCompleted') }}!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Order::where('payment_status','Completed')->where('status','completed')->where('company_id',$companyid)->count() }}">{{ \App\Order::where('payment_status','Completed')->where('status','completed')->where('company_id',$companyid)->count() }}</span> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="mrgn-b-lg prtm-card-box pad-all-sm prtm-sparkline-v2-list">
                    <div class="row">
                        <div class="dashboard-product-image col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <p class="base-dark">{{ trans('app.TotalCustomers') }}!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\UserProfile::where('company_id',$companyid)->count() }}">{{ \App\UserProfile::where('company_id',$companyid)->count() }}</span> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="mrgn-b-lg prtm-card-box pad-all-sm prtm-sparkline-v2-list">
                    <div class="row">
                        <div class="dashboard-product-image col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <i class="fa fa-at"></i>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <p class="base-dark">{{ trans('app.TotalSubscribers') }}!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Subscribers::where('company_id',$companyid)->count() }}">{{ \App\Subscribers::where('company_id',$companyid)->count() }}</span> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="prtm-block">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            <h3>{{ trans('app.MonthlyGraph') }}</h3>
                        </div>
                    </div>
                    <div class="prtm-block-content">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="prtm-block">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            <h3>{{ trans('app.YearlyGraph') }}</h3>
                        </div>
                    </div>
                    <div class="prtm-block-content">
                        <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="prtm-block pad-all-md custom_scrollbar" style="height: 500px;overflow-y: auto;">
                    <div class="prtm-block-title">
                        <div class="caption"><h3 class="mrgn-all-none">{{ trans('app.NewCustomer') }}</h3> </div>
                    </div>
                    <div class="prtm-block-content">
                        <div class="table-responsive">
                            <table class="table table-hover table-middle th-fw-light base-dark">
                                <thead>
                                    <tr>
                                        <th>{{ trans('app.Name') }}</th>
                                        <th>{{ trans('app.EmailAddress') }}</th>
                                        <th>{{ trans('app.Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($newcustomer) == '')
                                    <tr>
                                        <td class="text-center" colspan="6">{{ trans('app.NoDataFound') }}</td>
                                    </tr>
                                    @else 
                                        @foreach($newcustomer as $row)
                                        <tr>
                                            <td>{{$row->firstname}} {{$row->lastname}}</td>
                                            <td>{{$row->email}}</td>
                                            <td>
                                            @if($row->status == 1)
                                                <span class="label label-success label-md btn-rounded">{{ trans('app.Active') }}</span>
                                            @elseif($row->status == 0)
                                                <span class="label label-danger label-md btn-rounded">{{ trans('app.Deactive') }}</span>
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="prtm-block custom_scrollbar" style="height: 240px;overflow-y: auto;">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3>{{ trans('app.UpgradePlan') }}</h3></div>
                    </div>
                    <div class="prtm-block-content">
                        <ul class="list-unstyled list-custom-width prtm-recent-checklist">
                        @if(count($upgradeplan) > 0)
                            @php $i=0; @endphp
                            @foreach($upgradeplan as $row)
                                <li class="clearfix pad-all-sm gray <?php echo $i % 2 == 0 ? 'bg-default' : '';?>">
                                    <div class="pull-left prtm-9">
                                        <span class="prtm-3 display-ib pull-left base-reverse">
                                            <i class="fa fa-check border-rad-xs square-30 bg-success"></i>
                                        </span>
                                        <span class="display-ib prtm-9 pull-left">Upgrade the {{$row->plantype}} plan</span>
                                    </div>
                                    <div class="pull-right prtm-3 text-right"><span>{{$row->created_at->diffForHumans()}}</span></div> 
                                </li>
                            @php $i++; @endphp
                            @endforeach
                        @else 
                            <p class="text-center" style="margin-top: 10%;">{{ trans('app.NoDataFound') }}</p>
                        @endif
                        </ul>
                    </div>
                </div>

                <div class="prtm-block custom_scrollbar" style="height: 230px;overflow-y: auto;">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3>{{ trans('app.PlanExpire') }}</h3></div>
                    </div>
                    <div class="prtm-block-content">
                        <div class="prtm-to-do">
                            <ul class="list-unstyled border-list-xs">
                            @if(count($expireplan) > 0)
                                @foreach($expireplan as $row)
                                <li>
                                    <div class="row">
                                        <div class="col-md-12"> 
                                            <span class="to-do-icon pull-left">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </span> 
                                            <span class="list-description pull-left">{{ trans('app.YourPlanExpiredOn') }} <b><?php echo date('jS, M Y' ,strtotime($row->expiry_date)); ?></b></span> 
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @else
                                <p class="text-center" style="margin-top: 10%;">{{ trans('app.NoDataFound') }}</p>
                            @endif
                            </ul>
                        </div> 
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="prtm-block custom_scrollbar" style="height: 500px;overflow-y: auto;">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3 style="text-transform: capitalize;">{{ trans('app.BuyTheme') }}</h3></div>
                    </div>
                    <div class="prtm-block-content">
                        <ul class="list-unstyled list-custom-width prtm-recent-checklist">
                        @if(count($buytheme) > 0)
                            @php $i=0; @endphp
                            @foreach($buytheme as $row)
                            <li class="clearfix pad-all-sm gray <?php echo $i % 2 == 0 ? 'bg-default' : '';?>">
                                <div class="pull-left prtm-9">
                                    <span class="prtm-3 display-ib pull-left base-reverse">
                                        <i class="fa fa-user-secret border-rad-xs square-30 bg-info"></i>
                                    </span>
                                    <span class="display-ib prtm-9 pull-left">{{ trans('app.BuyTheme') }} {{$row->themename}}</span>
                                </div>
                                <div class="pull-right prtm-3 text-right"><span>{{$row->created_at->diffForHumans()}}</span></div>
                            </li>
                            @php $i++; @endphp
                            @endforeach 
                        @else
                            <p class="text-center" style="margin-top: 20%;">{{ trans('app.NoDataFound') }}</p>
                        @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="prtm-block custom_scrollbar" style="height: 610px;overflow-y: auto;">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3>{{ trans('app.TicketStatus') }}</h3></div>
                    </div>
                    <div class="prtm-block-content">
                        <div class="prtm-to-do">
                            <ul class="list-unstyled border-list-xs">
                            @if(isset($ticket) && count(array($ticket)) > 0 && $ticket != "")
                                @foreach($ticket as $row)
                                    @if($row->ticketstatus  != 1)
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                                <span class="to-do-icon pull-left">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </span>
                                                @if($row->ticketstatus  == 2)
                                                    <span class="list-description pull-left"><b>{{$row->title}}</b> {{ trans('app.TicketOpenOn') }} <?php echo date('jS, M Y' ,strtotime($row->updated_at)); ?></span> 
                                                @endif
                                                @if($row->ticketstatus  == 3)
                                                    <span class="list-description pull-left"><b>{{$row->title}}</b> {{ trans('app.TicketInProgress') }}</span> 
                                                @endif
                                                @if($row->ticketstatus  == 4)
                                                    <span class="list-description pull-left"><b>{{$row->title}}</b> {{ trans('app.TicketClosedOn') }} <?php echo date('jS, M Y' ,strtotime($row->updated_at)); ?></span> 
                                                @endif
                                                @if($row->ticketstatus  == 5)
                                                    <span class="list-description pull-left"><b>{{$row->title}}</b> {{ trans('app.TicketRejectedOn') }} <?php echo date('jS, M Y' ,strtotime($row->updated_at)); ?></span> 
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                @endforeach
                            @else 
                                <p class="text-center" style="margin-top: 20%;">{{ trans('app.NoDataFound') }}</p>
                            @endif
                            </ul>
                        </div>
                    </div> 
                </div>
            </div> 

            <div class="col-lg-6 col-md-6 col-sm-12 mail-content">
                <div id="response">
                    @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('success') }}
                        </div>
                    @endif
                </div>
                <div class="prtm-block">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3>{{ trans('app.QuickMail') }}</h3></div>
                    </div>
                    <div class="prtm-block-content">
                        <form action="{!! action('HomeController@qucikmail',$subdomain_name) !!}" method="POST" id="email_form">
                            {{csrf_field()}}
                            <div class="compose" style="border: none;">
                                <div class="compose-header">
                                    <div class="compose-field" style="margin-bottom: 6px;">
                                        <div class="compose-field-left">
                                            <button class="compose-label" type="button">{{ trans('app.To') }}</button>
                                        </div>
                                        <div class="compose-field-body">
                                            <input class="compose-input" type="text" name="to" id="to" autocomplete="off" spellcheck="false"> 
                                        </div>
                                    </div>
                                    <div class="compose-field">
                                        <div class="compose-field-left">
                                            <button class="compose-label" type="button">{{ trans('app.Subject') }}</button>
                                        </div>
                                        <div class="compose-field-body">
                                            <input class="compose-input" type="text" name="subject"> 
                                        </div>
                                    </div>

                                    <div class="compose-body">
                                        <div class="compose-message pad-all-xs">
                                            <textarea name="message" id="content1" rows="12" cols="50"></textarea>
                                        </div>
                                        <div class="compose-actions">
                                            <button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>{{ trans('app.Send') }}</button>
                                            <button class="btn btn-inverse btn-lg" type="reset"><i class="fa fa-times" aria-hidden="true"></i> &nbsp;{{ trans('app.Discard') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script type="text/javascript">

bkLib.onDomLoaded(function() {
    new nicEditor({fullPanel : true}).panelInstance('content1');
});

window.onload = function () {

    $.getJSON("{!! url('admin/monthlygraph') !!}", function(result){
        var dps= [];

        //Insert Array Assignment function here
        for(var i=0; i<result.length;i++) {
            dps.push({"label":result[i].ts, "y":result[i].d1});
        }

        //Insert Chart-making function here
        var chart = new CanvasJS.Chart("chartContainer", {
            zoomEnabled:true,
            panEnabled:true,
            animationEnabled:true,
            title:{
                text: ""
            },

            axisX:{
                title: ""
            },

            axisY:{
                title: "",
                minimum: 0
            },

            data: [{
                type: "splineArea",
                showInLegend: true,
                name: "{{ trans('app.OrderIncome') }}",
                dataPoints:dps
            },]
        });
        chart.render();
    });

    $.getJSON("{!! url('admin/yearlygraph') !!}", function(result){
        var dps= [];
        var dpss= [];

        //Insert Array Assignment function here
        for(var i=0; i<result.length;i++) {
            dps.push({"label":result[i].ts, "y":result[i].d1});
        }

        //Insert Chart-making function here
        var chart = new CanvasJS.Chart("chartContainer1", {
            zoomEnabled:true,
            panEnabled:true,
            animationEnabled:true,
            title:{
                text: ""
            },

            axisX:{
                title: ""
            },

            axisY:{
                title: "",
                minimum: 0
            },

            data: [{
                    type: "splineArea",
                    showInLegend: true,
                    color:"#BF514F",
                    name: "{{ trans('app.OrderIncome') }}",
                    dataPoints:dps
                },]
        });
        chart.render();
    });
}

$(document).ready(function(){

    $.validator.addMethod('Validemail', function (value, element) {
        return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
    }, "Please enter a valid email address.");

    $('#email_form').validate({
        rules:{
            to: 
            {
                required: true,
                Validemail: true
            },
            subject: 
            {
                required: true,
                maxlength: 150,
                minlength: 3,
            },
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