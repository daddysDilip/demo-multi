@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>

    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{$cms->title}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
                  <li class="breadcrumb-item active text-capitalize" aria-current="page">{{$cms->title}}</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="cms_section">
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