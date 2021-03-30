

    <!-- ======================================== -->

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
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$language->blog}}</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <section id="blog_main" class="two_colm">
        <div class="container">
          <div class="row">
              @if(count($blogs) > 0)
            @foreach($blogs as $blog)

            <div class="col-md-6">
           
                  @if($blog->featured_image != '')
                    <img src="assets/images/blog/{{$blog->featured_image}}" alt="Blog Image" class="img-responsive ">
                  @else

                      <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="Blog Image" class="img-responsive">
                  @endif
                

                
              <div class="blog_text">
                <h3 class="full_width"><a href="">{{$blog->title}}</a></h3>
                 <span style="text-align: center; color: #2694d3; border: 1px solid #2694d3 ">{{date('M d, Y',strtotime($blog->created_at))}}</span>
                 
                <!-- <span class="full_width">by John 2 Feb 2018 - Uncategorized</span> -->
                <p class="full_width">{{ substr(strip_tags($blog->details), 0, 120) }}
                  {{ strlen(strip_tags($blog->details)) > 50 ? "..." : "" }}</p>
                     <div class="off">
                   </div>
                <div class="set_al full_width"><a href="{{url('/')}}/blog/{{$blog->id}}" class="read_moretr">read more</a></div>
                <div class="social full_width">
                  <!-- <a href="" target="_blank"><i class="fab fa-facebook-f"></i></a> -->
                  <!-- <a href="" target="_blank"><i class="fab fa-twitter"></i></a> -->
                  <!-- <a href="" target="_blank"><i class="fab fa-google-plus-g"></i></a> -->
                  <!-- <a href="" target="_blank"><i class="fab fa-linkedin-in"></i></a> -->
                  <!-- <a href="" target="_blank"><i class="fab fa-instagram"></i></a> -->
                </div>
              </div>
            </div><br/>
              @endforeach
          @else
            <h4 class="text-center">No data found.</h4>
          @endif

          </div>





        </div>
      </section>
    </main>
    @endsection