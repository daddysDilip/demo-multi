@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.CustomerDetails')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.CustomerDetails')}}</li>
                </ul>
            </div>


       <!--      ================================>

                <div class="order-detail">
                <div class="prtm-block">

                    <div class="prtm-block-title pos-relative">
                        <div class="caption">
                            <h3>Heleoeoeoeo</h3> 
                        </div>
                    </div>


                </div>
            </div> -->

             <div class="prtm-block-content prtm-block-no-gutter">
                        <div class="line-slide-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"> <a data-toggle="tab" href="#order" aria-expanded="false">View Ditels</a> </li>
                                <li> <a data-toggle="tab" href="#pending" aria-expanded="true">Address Detiles </a> </li>
                               <!--  <li> <a data-toggle="tab" href="#Processing" aria-expanded="false">Processing</a> </li>
                                <li> <a data-toggle="tab" href="#Completed" aria-expanded="true">Completed</a> </li>
                                <li> <a data-toggle="tab" href="#Cancelde" aria-expanded="true">Cancelde</a> </li> -->
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
                                           <table class="table customer_details">
                        <tbody>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerID')}}#</strong></td>
                                <td>{{$customer->id}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerName')}}:</strong></td>
                                <td>{{$customer->firstname}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerEmail')}}:</strong></td>
                                <td>{{$customer->email}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerPhone')}}:</strong></td>
                                <td>{{$customer->phone}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerAddress')}}:</strong></td>
                                <td>{{$customer->address}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerCity')}}:</strong></td>
                                <td>{{$customer->city}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerZip')}}:</strong></td>
                                <td>{{$customer->zip}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.Joined')}}:</strong></td>
                                <td>{{$customer->created_at->diffForHumans()}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"></td>
                                <td><a href="{!! url('admin/customers') !!}" class="btn btn-danger btn-add"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a></td>
                            </tr>
                        </tbody>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="order-detail">
                <div class="prtm-block">

                    <div class="prtm-block-title pos-relative">
                        <div class="caption">
                            <h3>Billing Address</h3> <hr/>
                  

                            <h5><b>Name:-</b> {{$billingadd->billing_firstname}} {{$billingadd->billing_lastname}}</h5>
                            <h5><b>Email:-</b> {{$billingadd->billing_email}}</h5>
                            <h5><b>Phone:-</b> {{$billingadd->billing_phone}}</h5>

                            <h5><b>Address:-</b> {{$billingadd->billing_address}}</h5>

                             <h5><b>country:-</b>{{$country}}</h5>
                                <h5><b>state:-</b>{{ $state}}</h5>
                                <h5><b>city:-</b>{{ $city}}</h5>
                              <h5><b>Zip:-</b> {{$billingadd->billing_zip}}</h5>
   
                        </div>
                    </div>


                </div>
            </div>
                                        <!-- <span style="text-align: center;" ><b>hello demo </b></span> -->
                                        
                                    </div>

                                    <div class="col-md-6">

                                        <div class="order-detail">
                <div class="prtm-block">

                    <div class="prtm-block-title pos-relative">
                        <div class="caption">
                            <h3>Shipping Address</h3> <hr/>


                                <h5><b>Name:-</b>{{$billingadd->shipping_firstname}}{{$billingadd->shipping_lastname}}</h5>
                                <h5></h5>
                                <h5><b>Email:-</b>{{$billingadd->shipping_email}}</h5>
                                <h5><b>Phone:-</b>{{$billingadd->shipping_phone}}</h5>
                                <h5><b>Address:-</b>{{$billingadd->shipping_address}}</h5>
                                 <h5><b>country:-</b>{{$scountry}}</h5>
                                <h5><b>state:-</b>{{ $sstate}}</h5>
                                <h5><b>city:-</b>{{ $scity}}</h5>
                                <h5><b>Zip:-</b>{{$billingadd->shipping_zip}}</h5>
                                <!-- <h3><b>Info:-</b>{{$billingadd->shipping_info}}</h3> -->
                                
                        </div>
                    </div>


                </div>
            </div>
                                        <!-- <span style="text-align: center;'"><b>hello demo </b></span> -->
                                        
                                    </div>
                                    
                                    
                                </div>
                       
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>

            </div>






            <!-- =================> -->

            <!-- Page Content -->
    <!--         <div class="panel panel-default">
                <div class="panel-body">

                    <table class="table customer_details">
                        <tbody>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerID')}}#</strong></td>
                                <td>{{$customer->id}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerName')}}:</strong></td>
                                <td>{{$customer->name}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerEmail')}}:</strong></td>
                                <td>{{$customer->email}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerPhone')}}:</strong></td>
                                <td>{{$customer->phone}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerAddress')}}:</strong></td>
                                <td>{{$customer->address}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerCity')}}:</strong></td>
                                <td>{{$customer->city}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.CustomerZip')}}:</strong></td>
                                <td>{{$customer->zip}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"><strong>{{trans('app.Joined')}}:</strong></td>
                                <td>{{$customer->created_at->diffForHumans()}}</td>
                            </tr>
                            <tr>
                                <td width="30%" style="text-align: right;"></td>
                                <td><a href="{!! url('admin/customers') !!}" class="btn btn-danger btn-add"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a></td>
                            </tr>
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

@stop