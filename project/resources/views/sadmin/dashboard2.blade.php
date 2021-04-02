@extends('sadmin.includes.master-sadmin2')

@section('content')

@php $companyid = get_company_id(); @endphp
   <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Dashboard
                <small class="text-muted">Welcome to Dashboard</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">                
                <!-- <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10" type="button">
                    <i class="zmdi zmdi-plus"></i>
                </button>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item active">Dashboard </li>
                </ul>  -->               
            </div>
        </div>
    </div>

    <div class="container-fluid">
        
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <ul class="row profile_state list-unstyled">
                        <li class="col-lg-4 col-md-4 col-6">
                            <div class="body" style="background: linear-gradient(45deg, #fda582, #f7cf68) !important;">
                                <i class="fa fa-shopping-cart"></i>
                                <h4>{{ \App\Product::count() }}</h4>
                                <span>Total Products!</span>
                            </div>
                        </li>
                        <li class="col-lg-4 col-md-4 col-6">
                            <div class="body" style="    background: linear-gradient(45deg, #72c2ff, #86f0ff) !important;color: #fff !important;">
                                <i class="fa fa-usd"></i>
                                <h4>{{ \App\Order::where('payment_status','Completed')->where('status','pending')->count() }}</h4>
                                <span>Orders Pending!</span>
                            </div>
                        </li>
                        <li class="col-lg-4 col-md-4 col-6" style="background: linear-gradient(45deg, #a890d3, #edbae7) !important;color: #fff !important;">
                            <div class="body">
                                <i class="fa fa-truck"></i>
                                <h4>{{ \App\Order::where('payment_status','Completed')->where('status','processing')->count() }}</h4>
                                <span>Orders Processing!</span>
                            </div>
                        </li>
                        <li class="col-lg-4 col-md-4 col-6">
                            <div class="body" style="background: linear-gradient(45deg, #00ced1, #08e5e8) !important;color: #fff !important;">
                                <i class="fa fa-check"></i>
                                <h4>{{ \App\Order::where('payment_status','Completed')->where('status','completed')->count() }}</h4>
                                <span>Orders Completed!</span>
                            </div>
                        </li>
                        <li class="col-lg-4 col-md-4 col-6">
                            <div class="body" style="background: linear-gradient(45deg, #ec74a1, #fbc7c0) !important;color: #fff !important;">
                                <i class="fa fa-user"></i>
                                <h4>{{ \App\UserProfile::count() }}</h4>
                                <span>Total Customers!</span>
                            </div>
                        </li>  
                        <li class="col-lg-4 col-md-4 col-6">
                            <div class="body" style="background: linear-gradient(45deg, #9ce89d, #cdfa7e) !important;">
                                <i class="fa fa-at"></i>
                                <h4>{{ \App\Subscribers::count() }}</h4>
                                <span>Total Subscribers!</span>
                            </div>
                        </li> 
                        
                                                
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <ul class="row profile_state list-unstyled">
                                               
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Heading -->
        

        <div class="row clearfix ">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="prtm-block card">
                    <div class="prtm-block-title mrgn-b-lg">
                        
                        <div class="header">
                        <h2><strong>Monthly</strong> Graph </h2>
                        
                    </div>
                    </div>
                    <div class="prtm-block-content">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="prtm-block card">
                    <div class="prtm-block-title mrgn-b-lg">
                        
                        <div class="header">
                        <h2><strong>Yearly</strong> Graph </h2>
                        
                    </div>
                    </div>
                    <div class="prtm-block-content">
                        <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card" style="height: 500px;overflow-y: auto;">
                    <div class="header">
                        <h2><strong>Latest</strong> Company </h2>
                        
                    </div>
                    <div class="body">
                        <ul class="row list-unstyled c_review">
                            @if(count($newcompany) > 0) 
                                @foreach($newcompany as $row)
                                <li class="col-12">
                                    <div class="avatar">
                                        @if($row->company_logo != '')
                                        <a href="#"><img class="rounded" src="{{url('/')}}/assets/images/company/{{$row->company_logo}}" alt="user" width="60"></a>
                                        @else
                                        <a href="#"><img class="rounded" src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" alt="user" width="60"></a>
                                         @endif

                                    </div>                                
                                    <div class="comment-action">
                                        <h6 class="c_name">{{$row->comapany_name}}</h6>
                                        <p class="c_msg m-b-0">Email: {{$row->company_email}} </p>
                                        <p class="c_msg m-b-0">Phone Number: {{$row->company_phone}} </p>
                                        @if($row->status == 1)
                                        <div class="badge badge-success">Active</div>
                                        @else
                                        <div class="badge badge-warning">Deactive</div>
                                        @endif
                                        
                                        <small class="comment-date float-sm-right">{{$row->created_at->diffForHumans()}}</small>
                                    </div>                                
                                </li>

                                @endforeach
                            @else 
                                <li class="col-12">
                                    <div class="avatar">
                                       

                                    </div>                                
                                    <div class="comment-action">
                                        
                                        <p class="c_msg m-b-0">No data Found</p>
                                       
                                    </div>                                
                                </li>
                            @endif
                            
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card " style="height: 500px;overflow-y: auto;">
                   <div class="header">
                       <h2><strong>Buy</strong> Plan</h2>
                       
                   </div>
                   <div class="body">
                       <ul class="inbox-widget list-unstyled clearfix">
                            @if(count($upgradeplan) > 0)
                                @php $i=0 @endphp 
                                @foreach($upgradeplan as $row)
                                    <li class="inbox-inner"> <a href="#">
                                        </a><div class="inbox-item"><a href="#">
                                           <div class="inbox-img"> 
                                             @if($row->company_logo != '')
                                            
                                            <img src="{{url('/')}}/assets/images/company/{{$row->company_logo}}" class="rounded" alt="">
                                            @else
                                            
                                            <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" class="rounded" alt="">
                                             @endif
                                            <img src="assets/images/sm/avatar2.jpg" class="rounded" alt=""> 
                                           </div>
                                           <div class="inbox-item-info">
                                               <p class="author">{{$row->comapany_name}}</p>
                                               <p class="inbox-message">{{$row->comapany_name}} buy {{$row->plantype}} plan</p>
                                               <p class="inbox-date">{{$row->created_at->diffForHumans()}}</p>
                                           </div>
                                           </a>
                                        </div>
                                        
                                    </li>
                                    @php $i++; @endphp 
                                @endforeach 
                            @else 
                                <li class="col-12">
                                    <div class="avatar">
                                    </div>                                
                                    <div class="comment-action">
                                        <p class="c_msg m-b-0">No data Found</p>
                                    </div>                                
                                </li>
                         @endif
                            
                       </ul>
                   </div>
               </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card " style="height: 500px;overflow-y: auto;">
                   <div class="header">
                       <h2><strong>Theme</strong> Buyer</h2>
                       
                   </div>
                   <div class="body">
                       <ul class="inbox-widget list-unstyled clearfix">
                            @if(count($buytheme) > 0)
                            @php $i=0; @endphp 
                            @foreach($buytheme as $row) 
                                    <li class="inbox-inner"> <a href="#">
                                        </a><div class="inbox-item"><a href="#">
                                           <div class="inbox-img"> 
                                             @if($row->company_logo != '')
                                            
                                            <img src="{{url('/')}}/assets/images/company/{{$row->company_logo}}" class="rounded" alt="">
                                            @else
                                            
                                            <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" class="rounded" alt="">
                                             @endif
                                            <img src="assets/images/sm/avatar2.jpg" class="rounded" alt=""> 
                                           </div>
                                           <div class="inbox-item-info">
                                               <p class="author">{{$row->comapany_name}}</p>
                                               <p class="inbox-message">{{$row->comapany_name}} Buy the theme {{$row->themename}}</p>
                                               <p class="inbox-date">{{$row->created_at->diffForHumans()}}</p>
                                           </div>
                                           </a>
                                        </div>
                                        
                                    </li>
                                    @php $i++; @endphp 
                                @endforeach 
                            @else 
                                <li class="col-12">
                                    <div class="avatar">
                                    </div>                                
                                    <div class="comment-action">
                                        <p class="c_msg m-b-0">No data Found</p>
                                    </div>                                
                                </li>
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