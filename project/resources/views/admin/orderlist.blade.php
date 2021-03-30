@extends('admin.includes.master-admin')


@section('content')

<style type="text/css">
    .btn-default
    {
        background-color: #ccdce8;
        border-color: #c4d7e5;
    }
</style>


    <div class="prtm-content-wrapper">

        <div class="prtm-content">

            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{ trans('app.Orders') }}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{ trans('app.Home') }}</a></li>
                    <li class="breadcrumb-item">{{ trans('app.Orders') }}</li>
                </ul>
            </div>

<!-- =================================================== -->
                 <!-- Page Content -->
            <div class="order-detail">
                <div class="prtm-block">

                    <div class="prtm-block-title pos-relative">
                        <div class="caption">
                            <!-- <h3>Heleoeoeoeo</h3>  -->
                        </div>
                    </div>

                    <div class="prtm-block-content prtm-block-no-gutter">
                        <div class="line-slide-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"> <a data-toggle="tab" href="#order" aria-expanded="false">All </a> </li>
                                <li> <a data-toggle="tab" href="#pending" aria-expanded="true">Pending </a> </li>
                                <li> <a data-toggle="tab" href="#Processing" aria-expanded="false">Processing</a> </li>
                                <li> <a data-toggle="tab" href="#Completed" aria-expanded="true">Completed</a> </li>
                                <li> <a data-toggle="tab" href="#Cancelde" aria-expanded="true">Cancelde</a> </li>
                            </ul>
                        </div>


                             <div class="tab-content pad-all-lg">
                            <div id="order" class="tab-pane fade in active">
                                <div class="row">

                                    <div id="response">
                                        @if(Session::has('message'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                    </div>




                          <div class="col-xs-12" style="padding: 0">
                        
                        <!-- Page Content -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" cellspacing="0" id="posts" width="100%">
                                    <thead>
                                <tr class="bg-primary">

                                <th>OrderID</th>
                                <th>CustomerEmail</th>
                                <th>CustomerName</th>
                                <th>TotalProducts</th>
                                <th>TotalCost</th>
                                <th>PaymentMethod</th>
                                <th>Status</th>
                                <th>Action</th>



                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    
                    </div>
                  </div>
                </div>
<!-- ===================================================== Pending Start== -->
                                <div id="pending" class="tab-pane fade in">
                                <div class="row">

                                    <div id="response">
                                        @if(Session::has('message'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                    </div>



                          <div class="col-xs-12" style="padding: 0">
                        
                        <!-- Page Content -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" cellspacing="0" id="posts1" width="100%">
                                    <thead>
                                <tr class="bg-primary">

                                <th>OrderID</th>
                                <th>CustomerEmail</th>
                                <th>CustomerName</th>
                                <th>TotalProducts</th>
                                <th>TotalCost</th>
                                <th>PaymentMethod</th>
                                <th>Status</th>
                                <th>Action</th>



                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    
                    </div>


                                </div>
                            </div>

<!-- ==================================================Processing Start=== -->

                               <div id="Processing" class="tab-pane fade in">
                                <div class="row">

                                    <div id="response">
                                        @if(Session::has('message'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                    </div>



                          <div class="col-xs-12" style="padding: 0">
                        
                        <!-- Page Content -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" cellspacing="0" id="posts2" width="100%">
                                    <thead>
                                <tr class="bg-primary">

                                <th>OrderID Processing</th>
                                <th>CustomerEmail</th>
                                <th>CustomerName</th>
                                <th>TotalProducts</th>
                                <th>TotalCost</th>
                                <th>PaymentMethod</th>
                                <th>Status</th>
                                <th>Action</th>



                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    
                    </div>


                                </div>
                            </div>  


    <!-- =============================================================Completed Start-->
                           
                             <div id="Completed" class="tab-pane fade in">
                                <div class="row">

                                    <div id="response">
                                        @if(Session::has('message'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                    </div>



                          <div class="col-xs-12" style="padding: 0">
                        
                        <!-- Page Content -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" cellspacing="0" id="posts3" width="100%">
                                    <thead>
                                <tr class="bg-primary">

                                <th>OrderID Processing</th>
                                <th>CustomerEmail</th>
                                <th>CustomerName</th>
                                <th>TotalProducts</th>
                                <th>TotalCost</th>
                                <th>PaymentMethod</th>
                                <th>Status</th>
                                <th>Action</th>



                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    
                    </div>


                                </div>
                            </div>  



        <!-- =============================================================Cancelde Start-->
                           
                             <div id="Cancelde" class="tab-pane fade in">
                                <div class="row">

                                    <div id="response">
                                        @if(Session::has('message'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                    </div>



                          <div class="col-xs-12" style="padding: 0">
                        
                        <!-- Page Content -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" cellspacing="0" id="posts4" width="100%">
                                    <thead>
                                <tr class="bg-primary">

                                <th>OrderID Processing</th>
                                <th>CustomerEmail</th>
                                <th>CustomerName</th>
                                <th>TotalProducts</th>
                                <th>TotalCost</th>
                                <th>PaymentMethod</th>
                                <th>Status</th>
                                <th>Action</th>



                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    
                    </div>


                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>

<!-- =========================================================== -->

            <!-- Page Content -->
<!-- 
            <div class="panel panel-default">
                <div class="panel-body">

                    <div id="response">
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    </div>

                    <table id="example" class="table table-bordered table-hover  tree">
                        <thead>
                            <tr class="bg-primary">
                                <th>{{ trans('app.OrderID') }}</th>
                                <th>{{ trans('app.CustomerEmail') }}</th>
                                <th>{{ trans('app.CustomerName') }}</th>
                                <th>{{ trans('app.TotalProducts') }}</th>
                                <th>{{ trans('app.TotalCost') }}</th>
                                <th>{{ trans('app.PaymentMethod') }}</th>
                                <th>{{ trans('app.Status') }}</th>
                                <th>{{ trans('app.Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($orders as $order)

                                @if($order->status == "completed")
                                    @php $btn_class = 'primary'; @endphp
                                @elseif($order->status == "cancelled")
                                    @php $btn_class = 'danger'; @endphp
                                @elseif($order->status == "processing")
                                    @php $btn_class = 'info'; @endphp
                                @else
                                    @php $btn_class = 'default'; @endphp
                                @endif

                                <tr>
                                    <td>#{{$order->id}}</td>
                                    <td>{{$order->customer_email}}</td>
                                    <td>{{$order->customer_firstname}} {{$order->customer_lastname}}</td>
                                    <td>{{array_sum($order->quantities)}}</td>
                                    <td>{{$settings[0]->currency_sign}}{!! $order->pay_amount !!}</td>
                                    <td>{{$order->method}}</td>
                                    <td><button class="btn btn-{{$btn_class}} btn-xs ">{{ucfirst($order->status)}}</button></td>
                                    <td>
                                        <a href="orders/{{$order->id}}" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> {{ trans('app.ViewDetails') }} </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div> -->
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->


@stop

@section('footer')



<script type="text/javascript">

    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsallorder') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [

                {"data": "id"},
                { "data": "customeremail"},
                { "data": "customername"},
                { "data": "totalproducts"},
                { "data": "totalcost"},
                {"data": "paymentmethod"},
                { "data": "status"},
                { "data": "action"},
             
              
            ]    

        });
    });


</script>


<script type="text/javascript">

    $(document).ready(function () {
        $('#posts1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostspendingorder') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [

                {"data": "id"},
                { "data": "customeremail"},
                { "data": "customername"},
                { "data": "totalproducts"},
                { "data": "totalcost"},
                {"data": "paymentmethod"},
                { "data": "status"},
                { "data": "action"},
             
              
            ]    

        });
    });


</script>
<script type="text/javascript">

    $(document).ready(function () {
        $('#posts2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostsprocessingorder') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [

                {"data": "id"},
                { "data": "customeremail"},
                { "data": "customername"},
                { "data": "totalproducts"},
                { "data": "totalcost"},
                {"data": "paymentmethod"},
                { "data": "status"},
                { "data": "action"},
             
              
            ]    

        });
    });


</script>

<script type="text/javascript">

    $(document).ready(function () {
        $('#posts3').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostscompletedorder') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [

                {"data": "id"},
                { "data": "customeremail"},
                { "data": "customername"},
                { "data": "totalproducts"},
                { "data": "totalcost"},
                {"data": "paymentmethod"},
                { "data": "status"},
                { "data": "action"},
             
              
            ]    

        });
    });


</script>

<script type="text/javascript">

    $(document).ready(function () {
        $('#posts4').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/allpostscanceldeorder') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [

                {"data": "id"},
                { "data": "customeremail"},
                { "data": "customername"},
                { "data": "totalproducts"},
                { "data": "totalcost"},
                {"data": "paymentmethod"},
                { "data": "status"},
                { "data": "action"},
             
              
            ]    

        });
    });


</script>

@stop