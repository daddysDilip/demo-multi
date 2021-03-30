@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ url('/blogs') }}">{{trans('app.Blog')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$blog->title}}</li>
          </ol>
        </div>
    </nav>

    <div class="blog-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="blog-detail">
                        @if($blog->featured_image != '')
                        <div class="img-box">
                          <img src="{{url('assets/images/blog')}}/{{$blog->featured_image}}" class="img-responsive">
                        </div>
                        @endif
                        <div class="detail-text">
                        <h4>{{$blog->title}}</h4>
                        <div class="info">
                            <span>
                                <i class="fa fa-calendar-o"></i>
                                <a href="#">{{date('d M, Y',strtotime($blog->created_at))}}</a>
                            </span>
                        </div>
                        <p>{!! htmlspecialchars_decode($blog->details) !!}</p>
                        <!-- <hr>
                        <div class="share-on-social">
                            <ul>
                                @if($sociallinks[0]->f_status == "enable")
                                  <li><a href="{{$sociallinks[0]->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                                @endif
                                @if($sociallinks[0]->g_status == "enable")
                                  <li><a href="{{$sociallinks[0]->g_plus}}"><i class="fab fa-google"></i></a></li>
                                @endif
                                @if($sociallinks[0]->t_status == "enable")
                                  <li><a href="{{$sociallinks[0]->twiter}}"><i class="fab fa-twitter"></i></a></li> 
                                @endif
                                @if($sociallinks[0]->link_status == "enable")
                                  <li><a href="{{$sociallinks[0]->linkedin}}"><i class="fab fa-linkedin"></i></a></li>
                                @endif
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="blog-sidebar">
                    <div class="title">
                      <h4>{{trans('app.LatestBlogs')}}</h4>
                    </div>

                    <ul class="blog">
                      @foreach($recents as $recent)
                      <li>
                        <a href="#">
                          <strong class="name">{{$recent->title}}</strong><br>
                          <span class="date">{{date('d M, Y',strtotime($recent->created_at))}}</span>
                        </a>
                      </li>
                      @endforeach
                    </ul>
                </div>
            </div>

          </div>
        </div>
    </div>

</main>

@stop

@section('footer')

@stop