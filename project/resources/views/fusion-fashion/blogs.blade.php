@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

  <nav class="breadcrumb-wrap" aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">{{trans('app.Blog')}}</li>
      </ol>
    </div>
  </nav>

  <div class="blog-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            @if(count($blogs) > 0)
              @foreach($blogs as $blog)
              <div class="col-md-4 col-sm-6">
                <div class="blog-grid-wrap">
                  <div class="img-box">
                    @if($blog->featured_image != '')
                      <img src="assets/images/blog/{{$blog->featured_image}}" alt="{{$blog->title}}" class="img-responsive">
                    @else
                      <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="{{$blog->title}}" class="img-responsive">
                    @endif
                  </div>
                  <div class="blog-grid-text">
                    <span>
                      <i class="far fa-calendar-alt"></i>
                      <a href="{{url('/')}}/blog/{{$blog->id}}">{{date('d M, Y',strtotime($blog->created_at))}}</a>
                    </span>
                    <h5><a href="{{url('/')}}/blog/{{$blog->id}}">{{$blog->title}}</a></h5>
                    <p>
                      {{ substr(strip_tags($blog->details), 0, 125) }}
                      {{ strlen(strip_tags($blog->details)) > 50 ? "..." : "" }}
                    </p>
                    <a href="{{url('/')}}/blog/{{$blog->id}}" class="read-more">{{trans('app.ReadMore')}}</a>
                  </div>
                </div>
              </div>
              @endforeach
            @else
              <h4 class="text-center">{{trans('app.NoDataFound')}}</h4>
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