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
                        <div id="account-dashboard-tab">
                            <h2>{{trans('app.MyDashboard')}}</h2>
                            <div class="dashboard-breadcroumb-section">
                                <img src="{{url('/')}}/assets/img/testimonial-bg-img.jpg" alt="">
                                <div class="customer-info">
                                    <h1>{{$user->name}}</h1>
                                    <p class="customer-id">{{$user->email}}</p>
                                    <p class="customer-points">{{$user->phone}}</p>
                                </div>
                            </div>
                            <div class="account-info-div">
                                <h3>{{trans('app.AccountInformation')}}</h3>
                                <div class="single-account-info-div">
                                    <div class="row">
                                        @if(count($address) > 0)
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <p class="colored-p">{{trans('app.DefaultBillingAddress')}} <a href="{{route('user.billinginfo',$subdomain_name)}}"><i class="fa fa-edit"></i></a></p>

                                            <p><strong>{{trans('app.Name')}} : </strong>{{$address->billing_firstname}}  {{$address->billing_lastname}}</p>

                                            <p><strong>{{trans('app.EmailAddress')}} : </strong>{{$address->billing_email}}</p>

                                            <p><strong>{{trans('app.PhoneNumber')}} : </strong>{{$address->billing_phone}}</p>

                                            <p><strong>{{trans('app.Address')}} : </strong>{{$address->billing_address}}</p>

                                            <p><strong>{{trans('app.Country')}} : </strong>{{get_country_name($address->billing_country)}}</p>

                                            <p><strong>{{trans('app.State')}} : </strong>{{get_state_name($address->billing_state)}}</p>

                                            <p><strong>{{trans('app.City')}} : </strong>{{get_city_name($address->billing_city)}}</p>

                                            <p><strong>{{trans('app.PostalCode')}} : </strong>{{$address->billing_zip}}</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <p class="colored-p text-capitalize">{{trans('app.ShippingAddress')}} <a href="{{route('user.shippinginfo',$subdomain_name)}}"><i class="fa fa-edit"></i></a></p>
                                            @if($address->shipping_info == 1)
                                                <p><strong>{{trans('app.Name')}} : </strong>{{$address->shipping_firstname}} {{$address->shipping_lastname}}</p>

                                                <p><strong>{{trans('app.EmailAddress')}} : </strong>{{$address->shipping_email}}</p>

                                                <p><strong>{{trans('app.PhoneNumber')}} : </strong>{{$address->shipping_phone}}</p>

                                                <p><strong>{{trans('app.Address')}} : </strong>{{$address->shipping_address}}</p>

                                                <p><strong>{{trans('app.Country')}} : </strong>{{get_country_name($address->shipping_country)}}</p>

                                                <p><strong>{{trans('app.State')}} : </strong>{{get_state_name($address->shipping_state)}}</p>

                                                <p><strong>{{trans('app.City')}} : </strong>{{get_city_name($address->shipping_city)}}</p>

                                                <p><strong>{{trans('app.PostalCode')}} : </strong>{{$address->shipping_zip}}</p>
                                            @else
                                                <p><strong>{{trans('app.Name')}} : </strong>{{$address->billing_firstname}}  {{$address->billing_lastname}}</p>

                                                <p><strong>{{trans('app.EmailAddress')}} : </strong>{{$address->billing_email}}</p>

                                                <p><strong>{{trans('app.PhoneNumber')}} : </strong>{{$address->billing_phone}}</p>

                                                <p><strong>{{trans('app.Address')}} : </strong>{{$address->billing_address}}</p>

                                                <p><strong>{{trans('app.Country')}} : </strong>{{get_country_name($address->billing_country)}}</p>

                                                <p><strong>{{trans('app.State')}} : </strong>{{get_state_name($address->billing_state)}}</p>

                                                <p><strong>{{trans('app.City')}} : </strong>{{get_city_name($address->billing_city)}}</p>

                                                <p><strong>{{trans('app.PostalCode')}} : </strong>{{$address->billing_zip}}</p>
                                            @endif
                                        </div>
                                        @else
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <p class="colored-p">{{trans('app.DefaultBillingAddress')}}</p>
                                            <p>{{trans('app.NoAddressYet')}}</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <p class="colored-p text-capitalize">{{trans('app.ShippingAddress')}}</p>
                                            <p>{{trans('app.NoAddressYet')}}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
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

@stop