@extends('ecommerce-4.includes.newmaster')

@section('content')

  <main>
    
    <section id="blog_innerbanner" style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;background-color: #2278b8;">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans('app.Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$pagetitle[0]->title}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>
    <section id="blog_grid">
      <div class="container">
        <div class="row">
          @if(count($blogs) > 0)
            @foreach($blogs as $blog)
              <div class="col-md-4 col-sm-6">
                <div class="blgr_box">

                  @if($blog->featured_image != '')
                    <img src="assets/images/blog/{{$blog->featured_image}}" alt="Blog Image" class="img-responsive blog_img">
                  @else
                    <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="Blog Image" class="img-responsive blog_img">
                  @endif

                  <span class="date">{{date('M d, Y',strtotime($blog->created_at))}}</span>
                  
                  <a href="{{url('/')}}/blog/{{$blog->id}}" class="b_title">{{$blog->title}}</a>
                  <hr>
                  
                  <p>{{ substr(strip_tags($blog->details), 0, 120) }}
                  {{ strlen(strip_tags($blog->details)) > 50 ? "..." : "" }}</p>
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