@extends('includes.newmaster')

@section('content')

<div class="home-wrapper">
    <!-- Starting of Account Dashboard area -->
    <div class="section-padding dashboard-account-wrapper wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-md-3 account_sidebar">
                    @include('includes.usermenu')
                </div>
                <div class="col-md-9">
                    <div class="dashboard-content">
                        <div id="my-orders-tab">
                            <h1>{{trans('app.MyOrders')}}</h1>
                            
                            <div class="table-responsive">
                                <table class="table" id="userOrders">
                                    <thead>
                                    <tr class="table-header-row">
                                        <th>{{trans('app.Order')}}#</th>
                                        <th>{{trans('app.Date')}}</th>
                                        <th>{{trans('app.OrderTotal')}}</th>
                                        <th>{{trans('app.OrderStatus')}}</th>
                                        <th>{{trans('app.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->order_number}}</td>
                                        <td>{{$order->booking_date}}</td>

                                        <td>{{$settings[0]->currency_sign}}{{$order->pay_amount}}</td>
                                        <td>{{$order->status}}</td>
                                        <td><a class="btn btn-default btn-sm" href="{{url('user/order/')}}/{{$order->id}}">{{trans('app.ViewOrder')}}</a></td>
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
    </div>
    <!-- Ending of Account Dashboard area -->
</div>

@stop

@section('footer')
<script>
    $('#userOrders').DataTable( {
        "order": []
    });
</script>
@stop

