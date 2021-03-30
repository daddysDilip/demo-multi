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
                <li class="breadcrumb-item active" aria-current="page">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else FAQ @endif</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>

    <div id="main_contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="styled-faf-fullDiv">
                        @if(count($faqs) > 0)
                        <div class="panel-group product-faq" id="asked-questions">
                            @php $i = 0; @endphp
                            @foreach($faqs as $faq)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a href="#asked-questions-{{$faq->id}}" data-parent="#asked-questions" data-toggle="collapse" aria-expanded="false">
                                            {{$faq->question}}
                                        </a>
                                    </div>
                                    <div id="asked-questions-{{$faq->id}}" class="panel-collapse collapse" aria-expanded="false">
                                        <div class="panel-body">
                                            <p>{!! $faq->answer !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @php $i++; @endphp
                            @endforeach
                        </div>
                        @else
                            <p class="text-center" style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

@stop

@section('footer')

@stop