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
                  <li class="breadcrumb-item active" aria-current="page" style="color: white">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else FAQ @endif</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>

       <section id="blog_main" class="two_colm">
        <div class="container">
          <div class="row">
                 <div class="col-md-12">
                    <div class="styled-faf-fullDiv">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

@stop

@section('footer')

@stop