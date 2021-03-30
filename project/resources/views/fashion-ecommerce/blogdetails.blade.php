@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{$blog->title}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans('app.Home')}}</a></li>
                  <li class="breadcrumb-item"><a href="{{ url('/') }}/blogs">{{trans('app.Blog')}}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$blog->title}}</li>
                </ol>
            </nav>
        </div>
    </section>
      
    <section class="blog-grid detail">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="blog-wrap mb-15 mt-15">
                        <div class="bimg-wrap">
                            @if($blog->featured_image != '')
                                <img src="{{url('assets/images/blog')}}/{{$blog->featured_image}}" class="img-fluid mx-auto">
                            @endif
                        </div>
                        <div class="btext-wrap">
                            <div class="date mb-15">
                                <i class="far fa-calendar-alt"></i>
                                <a href="{{url('/')}}/blog/{{$blog->id}}" class="">{{date('F d, Y',strtotime($blog->created_at))}}</a>
                            </div>
                            <div class="blog-name f-20 clr-secondary mb-15">{{$blog->title}}</div>
                            <div class="blog-desc f-16 clr-secondary-light">
                                {!! htmlspecialchars_decode($blog->details) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@stop

@section('footer')

@stop