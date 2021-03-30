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
                        <div id="account-dashboard-tab">
                            <h3 class="text-uppercase f-weight600">{{trans('app.MyDashboard')}}</h3>

                            <div class="account-info-div">
                                <h4 class="text-capitalize f-weight600">{{trans('app.AccountInformation')}}</h4>

                                <div class="single-account-info-div">
                                    <div class="row">
                                        @if(count($address) > 0)
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <p class="colored-p text-capitalize f-weight600">{{trans('app.DefaultBillingAddress')}} <a href="{{route('user.billinginfo',$subdomain_name)}}"><i class="fa fa-edit"></i></a></p>
                                            
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
                                            <p class="colored-p text-capitalize f-weight600">{{trans('app.ShippingAddress')}} <a href="{{route('user.shippinginfo',$subdomain_name)}}"><i class="fa fa-edit"></i></a></p>
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
                                            <p class="colored-p text-capitalize f-weight600">{{trans('app.DefaultBillingAddress')}}</p>
                                            <p>{{trans('app.NoAddressYet')}}</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <p class="colored-p text-capitalize f-weight600">{{trans('app.ShippingAddress')}}</p>
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
    </section>

</main>
   

@stop

@section('footer')

@stop