@extends('themextra-e-comm.includes.newmaster')

@section('content')

<main>

    <section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
        <div class="row" style="background-color:rgba(0,0,0,0.7);">

            <div style="margin: 3% 0px 3% 0px;">
                <div class="text-center" style="color: #FFF;padding: 20px;">
                    <h1>{{$cms->title}} </h1>
                </div>
            </div>

        </div>
    </section>

    <div class="section-padding wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                
                    {!! htmlspecialchars_decode($cms->description) !!}
                </div>
            </div>
        </div>
    </div>

</main>

@stop

@section('footer')

@stop