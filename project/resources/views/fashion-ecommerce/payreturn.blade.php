@extends('fashion-ecommerce.includes.newmaster')

@section('content')

    <div class="section-padding dashboard-account-wrapper wow fadeInUp">
        <div class="row">
            <div class="container">
                <div class="col-md-12 text-center services">
                    <div class="services-div">
                        <h1 class="text-center f-weight600 f-36" style="color: #008000;"> {{trans('app.Congratulation')}} !!</h1>
                        <h2 class="f-24 f-weight600">{{trans('app.OrderConfirmedMsg')}}</h2>
                        <p></p>
                        <a href="{{url('user/dashboard')}}" class="button style-10 order_confirm_btn">{{trans('app.MyAccount')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('footer')

@stop