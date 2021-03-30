@extends('fusion-fashion.includes.master')

@section('content')

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">{{$pagename}}</li>
          </ol>
        </div>
    </nav>

    <div class="main-wrapper">
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