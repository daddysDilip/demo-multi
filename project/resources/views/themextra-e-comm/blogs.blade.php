@extends('themextra-e-comm.includes.newmaster')

@section('content')

    <section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
        <div class="row" style="background-color:rgba(0,0,0,0.7);">

            <div style="margin: 3% 0px 3% 0px;">
                <div class="text-center" style="color: #FFF;padding: 20px;">
                    <h1>{{$pagetitle[0]->title}}</h1>
                </div>
            </div>

        </div>
    </section>


    <div class="section-padding wow fadeInUp" id="blogs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(count($blogs) > 0)
                        @foreach($blogs as $blog)
                            <div class="col-sm-6 col-md-4 col-lg-4 single-blog">
                                <div class="bolg_listing">
                                    <a href="{{url('/')}}/blog/{{$blog->id}}">
                                        <div class="blog-thumb-wrapper">
                                            @if($blog->featured_image != '')
                                                <img src="assets/images/blog/{{$blog->featured_image}}" alt="Blog Image">
                                            @else
                                                <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="Blog Image">
                                            @endif
                                        </div>
                                        <div class="blog-text">
                                            <p class="blog-meta">{{date('d M Y',strtotime($blog->created_at))}}</p>
                                            <h4>{{$blog->title}}</h4>
                                            <p>
                                                {{ substr(strip_tags($blog->details), 0, 125) }}
                                                {{ strlen(strip_tags($blog->details)) > 50 ? "..." : "" }}
                                            </p>
                                        </div>
                                    </a>
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

@stop

@section('footer')

@stop