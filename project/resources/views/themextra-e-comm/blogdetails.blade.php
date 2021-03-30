@extends('themextra-e-comm.includes.newmaster')

@section('content')

    <!-- Blog Post area -->
    <div class="section-padding blog-post-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>{{$blog->title}}</h2>
                        <ul class="blog-info">
                            <li><i class="fa fa-clock"></i> {{$blog->created_at->diffForHumans()}}</li>
                            @if($blog->source != null)
                                <li>Source: {{$blog->source}}</li>
                            @endif
                            <li><i class="fa fa-eye"></i> {{$blog->views}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            @if($blog->featured_image != '')
                            <p><img src="{{url('assets/images/blog')}}/{{$blog->featured_image}}" alt=""></p>
                            @endif
                            <div class="entry-content" style="padding: 20px 0px;">
                                {!! $blog->details !!}
                            </div>
                            <!-- <div class="social-sharing">
                                <p>{{$language->share_in_social}}:</p>
                                
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                    <a class="a2a_button_facebook"></a>
                                    <a class="a2a_button_twitter"></a>
                                    <a class="a2a_button_pinterest"></a>
                                    <a class="a2a_dd" href="#"></a>
                                </div>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                               
                            </div> -->
                        </div>
                        <div class="col-md-4">
                            <div class="post-sidebar-area">
                                <h2 class="post-heading">{{$language->latest_blogs}}</h2>
                                <ul>
                                    @foreach($recents as $recent)
                                        <li><i class="fa fa-angle-right"></i> <a href="{{$recent->id}}">{{$recent->title}}</a> <span>{{$recent->created_at->diffForHumans()}}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('footer')

@stop