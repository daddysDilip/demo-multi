@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">{{$cms->title}}</li>
          </ol>
        </div>
    </nav>

    <div class="main-wrapper">
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