@extends('sadmin.includes.master-sadmin')

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
                            <p class="base-dark">Total Products!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Product::count() }}">{{ \App\Product::count() }}</span> </div>
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
                            <p class="base-dark">Orders Pending!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Order::where('payment_status','Completed')->where('status','pending')->count() }}">{{ \App\Order::where('payment_status','Completed')->where('status','pending')->count() }}</span> </div>
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
                            <p class="base-dark">Orders Processing!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Order::where('payment_status','Completed')->where('status','processing')->count() }}">{{ \App\Order::where('payment_status','Completed')->where('status','processing')->count() }}</span> </div>
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
                            <p class="base-dark">Orders Completed!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Order::where('payment_status','Completed')->where('status','completed')->count() }}">{{ \App\Order::where('payment_status','Completed')->where('status','completed')->count() }}</span> </div>
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
                            <p class="base-dark">Total Customers!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\UserProfile::count() }}">{{ \App\UserProfile::count() }}</span> </div>
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
                            <p class="base-dark">Total Subscribers!</p><span class="spark-v2-counter show text-primary count-item" data-count="{{ \App\Subscribers::count() }}">{{ \App\Subscribers::count() }}</span> </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="prtm-block">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            <h3>Monthly Graph</h3>
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
                            <h3>Yearly Graph</h3>
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
                        <div class="caption"><h3 class="mrgn-all-none">Latest Company</h3> </div>
                    </div>
                    <div class="prtm-block-content">
                        <div class="prtm-customer-support">
                        @if(count($newcompany) > 0) 
                            @foreach($newcompany as $row)
                            <div class="prtm-customer-list">
                                <div class="row mrgn-b-xs">
                                    <div class="col-xs-7 col-sm-3 col-md-6 col-lg-8">
                                        <div class="pull-left mrgn-r-sm img-circle" style="background: #ccc;"> 
                                            @if($row->company_logo != '')
                                                <img class="img-responsive display-ib img-circle" src="{{url('/')}}/assets/images/company/{{$row->company_logo}}" width="64" height="64" alt="User Photo" style="height: 64px;"> 
                                            @else
                                                <img class="img-responsive display-ib img-circle" src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" width="64" height="64" alt="User Photo" style="height: 64px;">
                                            @endif
                                        </div>
                                        <div class="pull-left">
                                            <h6 class="text-primary">{{$row->comapany_name}}</h6>
                                            <div class="post-meta"> 
                                                <span>Email: {{$row->company_email}}</span> <br>
                                                <span>Phone Number: {{$row->company_phone}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-9 col-md-6 col-lg-4">
                                        @if($row->status == 1)
                                        <span class="text-right text-success show"><i class="fa fa-dot-circle-o"></i> Active</span>
                                        @elseif($row->status == 0)
                                        <span class="text-right text-warning show"><i class="fa fa-dot-circle-o"></i> Deactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else 
                            <p class="text-center" style="margin-top: 20%;">No data found</p>
                        @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="prtm-block custom_scrollbar" style="height: 500px;overflow-y: auto;">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3>Buy Plan</h3></div>
                    </div>
                    <div class="prtm-block-content">
                        <ul class="list-unstyled list-custom-width prtm-recent-checklist">
                        @if(count($upgradeplan) > 0)
                            @php $i=0 @endphp 
                            @foreach($upgradeplan as $row)
                            <li class="clearfix pad-all-sm gray <?php echo $i % 2 == 0 ? 'bg-default' : '';?>">
                                <div class="pull-left prtm-9">
                                    <span class="prtm-3 display-ib pull-left base-reverse">
                                        <i class="fa fa-check border-rad-xs square-30 bg-success"></i>
                                    </span>
                                    <span class="display-ib prtm-9 pull-left">{{$row->comapany_name}} buy {{$row->plantype}} plan</span>
                                </div>
                                <div class="pull-right prtm-3 text-right"><span>{{$row->created_at->diffForHumans()}}</span></div>
                            </li>
                            @php $i++; @endphp 
                            @endforeach 
                        @else 
                            <p class="text-center" style="margin-top: 20%;">No data found</p>
                        @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="prtm-block custom_scrollbar" style="height: 500px;overflow-y: auto;">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3>Theme Buyer</h3></div>
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
                                    <span class="display-ib prtm-9 pull-left">{{$row->comapany_name}} Buy the theme {{$row->themename}}</span>
                                </div>
                                <div class="pull-right prtm-3 text-right"><span>{{$row->created_at->diffForHumans()}}</span></div>
                            </li>
                            @php $i++; @endphp 
                            @endforeach 
                        @else 
                            <p class="text-center" style="margin-top: 20%;">No data found</p>
                        @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="prtm-block custom_scrollbar" style="height: 500px;overflow-y: auto;">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3>Plan Expire</h3></div>
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
                                            <span class="list-description pull-left">{{$row->comapany_name}} plan hase been expired on <b>{{date('jS, M Y' ,strtotime($row->expiry_date))}}</b></span> 
                                        </div>
                                    </div>
                                </li>
                                @endforeach 
                            @else 
                                <p class="text-center" style="margin-top: 20%;">No data found</p> 
                            @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="prtm-block custom_scrollbar" style="height: 500px;overflow-y: auto;">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3>New Inquiry</h3></div>
                    </div>
                    <div class="prtm-block-content">
                        <div class="table-responsive">
                            <table class="table table-hover table-middle th-fw-light base-dark">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>EmailID</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($newinquiry) > 0)
                                        @foreach($newinquiry as $row)
                                        <tr>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->email}}</td>
                                            <td>
                                            @if($row->status == 1)
                                                <span class="label label-success label-md btn-rounded">Active</span>
                                            @else
                                                <span class="label label-danger label-md btn-rounded">Deactive</span>
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else 
                                        <tr>
                                            <td class="text-center" colspan="6">No data found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="prtm-block custom_scrollbar" style="height: 500px;overflow-y: auto;">
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption"><h3>New Ticket</h3></div>
                    </div>
                    <div class="prtm-block-content">
                        <div class="prtm-to-do">
                            <ul class="list-unstyled border-list-xs">
                            @if(count($newticket) > 0)
                                @foreach($newticket as $row) 
                                <li>
                                    <div class="row">
                                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"> 
                                            <span class="to-do-icon pull-left">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </span> 
                                            <span class="list-description pull-left">{{$row->comapany_name}} has been added new ticket</span> 
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-right">
                                            <a href="tickets/{{$row->id}}"><i class="fa fa-edit mrgn-r-sm"></i></a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @else 
                                <p class="text-center" style="margin-top: 20%;">No data found</p>
                            @endif
                            </ul>
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
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script type="text/javascript">
    
window.onload = function () {
   
    $.getJSON("{!! url('sadmin/monthlygraph') !!}", function(result){
        var dps= [];
        var dpss= [];

        //Insert Array Assignment function here
        for(var i=0; i<result.length;i++) {
            dps.push({"label":result[i].ts, "y":result[i].d1});
            dpss.push({"label":result[i].ts, "y":result[i].d2});
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
                color: "#5e6db3",    
                name: "Upgrade Plan",
                dataPoints:dps
            },
            {
                type: "splineArea",
                showInLegend: true,
                color:"#fd7b6c",
                name: "Buy Theme",
                dataPoints:dpss
            }]
        });
        chart.render();
    });

    $.getJSON("{!! url('sadmin/yearlygraph') !!}", function(result){
        var dps= [];
        var dpss= [];

        //Insert Array Assignment function here
        for(var i=0; i<result.length;i++) {
            dps.push({"label":result[i].ts, "y":result[i].d1});
            dpss.push({"label":result[i].ts, "y":result[i].d2});
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
                color:"#00ca95",
                name: "Upgrade Plan",
                dataPoints:dps
            },
            {
                type: "splineArea",
                showInLegend: true,
                color:"#31cff9",
                name: "Buy Theme",
                dataPoints:dpss
            }]
        });
        chart.render();
    });
}

</script>


@stop