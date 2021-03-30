@extends('themextra-e-comm.includes.master')

@section('content')

<main>

    <section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
        <div class="row" style="background-color:rgba(0,0,0,0.7);">

            <div style="margin: 3% 0px 3% 0px;">
                <div class="text-center" style="color: #FFF;padding: 20px;">
                    <h1>{{$pagename}}</h1>
                </div>
            </div>

        </div>
    </section>

    <div class="section-padding wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{$service->cost}}$</h1>
                    {!! htmlspecialchars_decode($service->details) !!}
                    <a href="{{url('/services/order')}}/{{$service->id}}" class="order-btn">
                        Order Now
                    </a>
                </div>
            </div>
        </div>
    </div>

</main>

@stop

@section('footer')

@stop