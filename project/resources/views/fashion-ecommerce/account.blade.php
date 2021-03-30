@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{trans('app.AccountDashboard')}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
                  <li class="breadcrumb-item active text-capitalize" aria-current="page">{{trans('app.AccountDashboard')}}</li>
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
                        <div id="account-dashboard-tab">
                            <h4 class="text-uppercase f-weight600">{{trans('app.MyDashboard')}}</h4>
                            <div class="dashboard-breadcroumb-section">
                                <img src="{{url('/')}}/assets/img/testimonial-bg-img.jpg" alt="">
                                <div class="customer-info">
                                    <h1 class="text-capitalize">{{$user->name}}</h1>
                                    <p class="customer-id">{{$user->email}}</p>
                                    <p class="customer-points">{{$user->phone}}</p>
                                </div>
                            </div>

                            <div class="account-info-div">
                                <h3 class="text-capitalize f-weight600 f-24">{{trans('app.AccountInformation')}}</h3>
                                <div class="single-account-info-div">
                                    <div class="row">
                                          @if(count($address) > 0)
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <p class="colored-p text-capitalize">{{trans('app.DefaultBillingAddress')}}  <a href="{{route('user.billinginfo',$subdomain_name)}}"><i class="fa fa-edit"></i></a></p>

                                            <p><strong>{{trans('app.Name')}} : </strong>{{$address->billing_firstname}}  {{$address->billing_lastname}}</p>

                                            <p><strong>{{trans('app.EmailAddress')}} : </strong>{{$address->billing_email}}</p>

                                            <p><strong>{{trans('app.PhoneNumber')}} : </strong>{{$address->billing_phone}}</p>

                                            <p><strong>{{trans('app.Address')}} : </strong>{{$address->billing_address}}</p>

                                            <p><strong>{{trans('app.Country')}} : </strong>{{get_country_name($address->billing_country)}}</p>

                                            <p><strong>{{trans('app.State')}} : </strong>{{get_state_name($address->billing_state)}}</p>

                                            <p><strong>{{trans('app.City')}} : </strong>{{get_city_name($address->billing_city)}}</p>

                                            <p><strong>{{trans('app.PostalCode')}} : </strong>{{$address->billing_zip}}</p>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12 shipping_detail">
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

</main>

@stop

@section('footer')

@stop