@extends('fashion-ecommerce.includes.master')

@section('content')

<main>
    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{$pagename}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                  <li class="breadcrumb-item active text-capitalize" aria-current="page">{{$pagename}}</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="cms_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{$service->cost}}$</h1>
                    {!! htmlspecialchars_decode($service->details) !!}
                    <a href="{{url('/services/order')}}/{{$service->id}}" class="order-btn">
                        {{trans('app.OrderNow')}}
                    </a>
                </div>
            </div>
        </div>
    </div>

</main>

@stop

@section('footer')

@stop