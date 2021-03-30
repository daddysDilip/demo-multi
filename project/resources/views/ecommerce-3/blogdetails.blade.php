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
                  <li class="breadcrumb-item"><a href="{{ url('/') }}"">Home</a></li>

                  <li class="breadcrumb-item"><a href="{{ url('/') }}/blogs">{{$language->blog}}</a></li>
                  <li style="color: #fff" class="breadcrumb-item active" aria-current="page"><a href="{{ url('/') }}/blogs" ></a>{{$blog->title}}</li>

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
                @else
                    <img src="{{url('/')}}/assets/images/placeholder.jpg" class="img-fluid mx-auto">
                @endif

                <span class="date">{{date('M d, Y',strtotime($blog->created_at))}}</span>
                <a href="{{url('/')}}/blog/{{$blog->id}}" class="b_title blog_detail">{{$blog->title}}</a>
                <hr>
                <p class="blog_detail">{!! htmlspecialchars_decode($blog->details) !!}</p>
                <hr class="detail">
                <div class="category">
                  <span class="pull-right social">
                    @if($sociallinks[0]->f_status == "enable")
                    <a href="{{$sociallinks[0]->facebook}}"><i class="fab fa-facebook-f"></i></a>
                    @endif

                    @if($sociallinks[0]->t_status == "enable")
                    <a href="{{$sociallinks[0]->twiter}}"><i class="fab fa-twitter"></i></a>
                    @endif

                    @if($sociallinks[0]->link_status == "enable")
                    <a href="{{$sociallinks[0]->linkedin}}"><i class="fab fa-linkedin"></i></a>
                    @endif

                    @if($sociallinks[0]->g_status == "enable")
                    <a href="{{$sociallinks[0]->g_plus}}"><i class="fab fa-google-plus-g"></i></a>
                    @endif
                  </span>
                </div>
                <hr>

              </div>
            </div>
          </div>
        </div>
    </section>
    </main>

@endsection    
 