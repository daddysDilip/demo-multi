@extends('fusion-fashion.includes.newmaster')

@section('content')

    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center confirm_order">
                    <div class="services-div">
                        <h1 class="text-center f-weight600" style="color: #008000;"> {{trans('app.Congratulation')}} !!</h1>
                        <h2 class="f-weight600">{{trans('app.OrderConfirmedMsg')}}</h2>
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