@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>

    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{$pagetitle[0]->title}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
                  <li class="breadcrumb-item active text-capitalize" aria-current="page">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else FAQ @endif</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="cms_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(count($faqs) > 0)
                    <div class="faq accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                        @php $i = 0; @endphp
                        @foreach($faqs as $faq)
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne1">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne{{$i}}" aria-expanded="true" aria-controls="collapseOne{{$i}}">
                                    <h5 class="mb-0 f-weight600 text-dark">{{$faq->question}}<i class="fas fa-angle-down rotate-icon"></i></h5>
                                </a>
                            </div>
                            <div id="collapseOne{{$i}}" class="collapse <?php echo ($i == 0) ? 'show' : ''; ?>" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                                <div class="card-body">
                                {!! htmlspecialchars_decode($faq->answer) !!}
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

</main>

@stop

@section('footer')

@stop