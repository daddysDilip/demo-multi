@extends('themextra-e-comm.includes.newmaster')

@section('content')

<main>
    
    <section id="sign">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar accountSidebar"> 
                    <div class="side-menu animate-dropdown outer-bottom-xs">
                        @include('themextra-e-comm.includes.usermenu')
                    </div>
                </div>
                <div class="col-md-9 detail_box"><div class="dashboard-content">

                    <div class="dashboard-content">
                        <div id="account-information-tab">
                            <h4 class="text-uppercase f-weight600">{{trans('app.MyOrders')}}</h4>
                            <div class="edit-account-info-div">
                                @if(Session::has('message'))
                                    <div class="alert alert-success alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ Session::get('message') }}
                                    </div>
                                @endif
                               
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
                                            <td>{{$settings[0]->currency_sign}}{{number_format($order->pay_amount,2)}}</td>
                                            <td>{{$order->status}}</td>
                                            <td><a class="btn btn-default btn-sm vieworder_btn" href="{{url('user/order/')}}/{{$order->id}}">{{trans('app.ViewOrder')}}</a></td>
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
    </section>

</main>

@stop

@section('footer')
<script>
    $('#userOrders').DataTable( {
        "order": []
    });
</script>
@stop