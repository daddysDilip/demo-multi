@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
          <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{$pagetitle[0]->title}}</div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{$pagetitle[0]->title}}</li>
            </ol>
          </nav>
        </div>
    </section>

    <section class="blog-grid">
        <div class="container">
            <div class="row">
                @if(count($blogs) > 0)
                  @foreach($blogs as $blog)
                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="blog-wrap mb-15 mt-15">
                        <div class="bimg-wrap">
                        @if($blog->featured_image != '')
                          <img src="assets/images/blog/{{$blog->featured_image}}" alt="{{$blog->title}}" class="img-fluid mx-auto">
                        @else
                          <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="{{$blog->title}}" class="img-fluid">
                        @endif
                        </div>
                        <div class="btext-wrap">
                          <div class="date mb-15">
                            <i class="far fa-calendar-alt"></i>
                            <a href="{{url('/')}}/blog/{{$blog->id}}" class="">{{date('F d, Y',strtotime($blog->created_at))}}</a>
                          </div>
                          <div class="blog-name mb-15"><a href="{{url('/')}}/blog/{{$blog->id}}" class="f-16 clr-secondary">{{$blog->title}}</a></div>
                          <div class="blog-desc f-14 clr-secondary-light">
                            {{ substr(strip_tags($blog->details), 0, 125) }}
                            {{ strlen(strip_tags($blog->details)) > 50 ? "..." : "" }}
                          </div>
                          <a href="{{url('/')}}/blog/{{$blog->id}}" class="btn-main clr-secondary text-uppercase f-12 mt-15">{{trans('app.ReadMore')}}<span><i class="fas fa-long-arrow-alt-right"></i></span></a>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @else
                    <h4 class="text-center">{{trans('app.NoDataFound')}}</h4>
                @endif
            </div>
        </div>
    </section>
</main>

@stop

@section('footer')

@stop