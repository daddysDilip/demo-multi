@extends('ecommerce-4.includes.newmaster')

@section('content')

<main>

    <section id="inner_banner" style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;background-color: #2278b8;">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans('app.Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$cms->title}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>

    <div  id="main_contact" class="cms_section">
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