@extends('ecommerce-4.includes.master')

@section('content')

<main>

    <section id="inner_banner" style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;background-color: #2278b8;">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans('app.Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$pagename}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>

    <section id="main_contact">
        <div class="container">
            <div class="col-sm-12">
                <div class="contact_us">
                    <h1>{{$service->cost}}$</h1>
                    {!! htmlspecialchars_decode($service->details) !!}
                    <a href="{{url('/services/order')}}/{{$service->id}}" class="order-btn">
                      {{trans('app.OrderNow')}}
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

@stop

@section('footer')

@stop