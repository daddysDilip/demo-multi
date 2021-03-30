@extends('ecommerce-4.includes.newmaster')

@section('content')

<main>

    <section id="order_list">
        <div class="container">
            <div class="row wrapper">
                <div class="col-md-4">
                    @include('ecommerce-4.includes.usermenu')
                </div>
                <div class="col-md-8">
                   <div class="table_box">
                        <h3>{{trans('app.OrderList')}}</h3>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover order_table">
                                <thead>
                                    <tr>
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