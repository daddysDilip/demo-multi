@extends('ecommerce-3.includes.newmaster')

@section('content')

<main>

    <section id="order_list">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    @include('ecommerce-3.includes.usermenu')
                </div>
                <div class="col-sm-8">
                    <div class="dashboard-content">
                        <div class="table_box">
                            <h3>Acconut Information</h3>
                            <hr>
                            <div class="single-account-info-div">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 billing_detail">
                                        <p class="colored-p text-capitalize"><b>default billing address</b></p>
                                        <p><strong>Name: </strong>{{$user->name}}</p>
                                        <p><strong>Email: </strong>{{$user->email}}</p>
                                        <p><strong>Phone: </strong>{{$user->phone}}</p>
                                        <p><strong>Address: </strong>{{$user->address}}</p>
                                        <p><strong>City: </strong>{{$user->city}}</p>
                                        <p><strong>Post Code: </strong>{{$user->zip}}</p>
                                    </div>
                                    @if(count($orders) > 0)
                                    <div class="col-lg-6 col-md-6 col-sm-12 shipping_detail">
                                        <p class="colored-p text-capitalize"><b>Shipping Address</b></p>
                                        <p><strong>Name: </strong>{{$orders[0]->shipping_name}}</p>
                                        <p><strong>Email: </strong>{{$orders[0]->shipping_email}}</p>
                                        <p><strong>Phone: </strong>{{$orders[0]->shipping_phone}}</p>
                                        <p><strong>Address: </strong>{{$orders[0]->shipping_address}}</p>
                                        <p><strong>City: </strong>{{$orders[0]->shipping_city}}</p>
                                        <p><strong>Post Code: </strong>{{$orders[0]->shipping_zip}}</p>
                                    </div>
                                    @endif
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

@stop