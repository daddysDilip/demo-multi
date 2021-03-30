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
                <li class="breadcrumb-item"><a href="{{ url('/') }}/blogs">{{trans('app.Blog')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$blog->title}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>
    
    <section id="blog_grid" class="blog_detail">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="blgr_box">

              @if($blog->featured_image != '')
                <img src="{{url('assets/images/blog')}}/{{$blog->featured_image}}" class="img-fluid mx-auto">
              @endif

              <span class="date">{{date('M d, Y',strtotime($blog->created_at))}}</span>
              <a href="{{url('/')}}/blog/{{$blog->id}}" class="b_title blog_detail">{{$blog->title}}</a>
              <hr>
              <p class="blog_detail">{!! htmlspecialchars_decode($blog->details) !!}</p>
              <hr class="detail">
              <!-- <div class="category">
                <span class="pull-right social">
                  @if($sociallinks[0]->f_status == "enable")
                  <a href="{{$sociallinks[0]->facebook}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                  @endif

                  @if($sociallinks[0]->t_status == "enable")
                  <a href="{{$sociallinks[0]->twiter}}" target="_blank"><i class="fab fa-twitter"></i></a>
                  @endif

                  @if($sociallinks[0]->link_status == "enable")
                  <a href="{{$sociallinks[0]->linkedin}}" target="_blank"><i class="fab fa-linkedin"></i></a>
                  @endif

                  @if($sociallinks[0]->g_status == "enable")
                  <a href="{{$sociallinks[0]->g_plus}}" target="_blank"><i class="fab fa-google-plus-g"></i></a>
                  @endif
                </span>
              </div> 
              <hr> -->

            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

@stop

@section('footer')

@stop