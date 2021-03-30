@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else FAQ @endif</li>
            </ol>
        </div>
    </nav>

    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(count($faqs) > 0)
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
                    @else
                        <p class="text-center" style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</main>

@stop

@section('footer')

@stop