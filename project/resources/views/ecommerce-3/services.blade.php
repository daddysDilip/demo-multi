@extends('ecommerce-3.includes.newmaster')

@section('content')

<main>

   
      

    <section id="title">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <h3>Blog</h3>
            </div>
            <div class="col-xs-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page" style="color: white">{{pagename}}</li>
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
                        Order Now
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

@stop

@section('footer')

@stop