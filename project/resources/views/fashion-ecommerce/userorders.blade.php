@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{trans('app.Orders')}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
                  <li class="breadcrumb-item active text-capitalize" aria-current="page">{{trans('app.Orders')}}</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="my-cart-wrap">
        <div class="container">
            <div class="row wrapper">
                <div class="col-md-4">
                    @include('fashion-ecommerce.includes.usermenu')
                </div>
                <div class="col-md-8">
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
    </div>

</main>

@stop

@section('footer')
<script>
    $('#userOrders').DataTable( {
        "order": []
    });
</script>
@stop