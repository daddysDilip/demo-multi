@extends('ecommerce-3.includes.newmaster')

@section('content')
    <main>
      <section id="title">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <h3>About Us</h3>
            </div>
            <div class="col-xs-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <!-- <li class="breadcrumb-item"><a href="#"></a></li> -->
                  <li class="breadcrumb-item active" aria-current="page" style="color: white">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else About Us @endif</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <section id="back_qt">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="bk_qts">
                <blockquote>
                  @if($pagedata->about != '')
				
			 {!! htmlspecialchars_decode($pagedata->about) !!}
				
				@else 
					
				<p class="text-center" style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</p>
				
				@endif
                      
                </blockquote>
              </div>
             <!--  <p>
                Lorem ipsum dolor sit amet conse ctetur adipisicing elit do eiusmod tempor. Dolor sit amet conse ctetur adipisicing elit do eiusmod tempor. Lorem ipsum dolor sit amet conse ctetur adipisicing elit do eiusmod tempor.Lorem ipsum dolor sit amet conse ctetur adipisicing elit do eiusmod tempor. Dolor sit amet conse ctetur adipisicing elit do eiusmod tempor. Lorem ipsum dolor sit amet conse ctetur adipisicing elit do eiusmod tempor.
              </p> -->
            </div>
          </div>
        </div>
      </section>


      <!-- <section id="why_us">
        <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <img src="{{ URL::asset('assets/ecommerce-3/images/why_us.jpg')}}" class="img-responsive">
            </div>
            <div class="col-sm-6">
              <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><i class="fab fa-codepen"></i>Our Values</a>
                    </h4>
                  </div>
                  <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">Duis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor. Quisque quis justo ut ipsum ornare consequat. Nullam congue tristique lacinia. Praesent libero sapien, mattis quis elit sit amet, accumsan congue</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="fab fa-codiepie"></i>Our Mission</a>
                    </h4>
                  </div>
                  <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">Duis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor. Quisque quis justo ut ipsum ornare consequat. Nullam congue tristique lacinia. Praesent libero sapien, mattis quis elit sit amet, accumsan congue</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="fab fa-uikit"></i>Our Business</a>
                    </h4>
                  </div>
                  <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">Duis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor. Quisque quis justo ut ipsum ornare consequat. Nullam congue tristique lacinia. Praesent libero sapien, mattis quis elit sit amet, accumsan congue</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><i class="fas fa-cube"></i>Our Philosophy</a>
                    </h4>
                  </div>
                  <div id="collapse4" class="panel-collapse collapse">
                    <div class="panel-body">Duis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor. Quisque quis justo ut ipsum ornare consequat. Nullam congue tristique lacinia. Praesent libero sapien, mattis quis elit sit amet, accumsan congue</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
 -->



      <section id="testi" class="clearfix">
        <div class="container">
          <div class="owl-carousel" id="testi-main">
            <div class="testi_box">
              <div class="photo" style="background-image: url('images/testi_photo.jpg');"></div>
              <p>uis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor. Quisque quis justo ut ipsum </p>
              <hr>
              <div class="name">Name Surname</div>
              <div class="desg">Designation</div>
            </div>
            <div class="testi_box">
              <div class="photo" style="background-image: url('images/testi_photo.jpg');"></div>
              <p>uis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor. Quisque quis justo ut ipsum </p>
              <hr>
              <div class="name">Name Surname</div>
              <div class="desg">Designation</div>
            </div>
            <div class="testi_box">
              <div class="photo" style="background-image: url('images/testi_photo.jpg');"></div>
              <p>uis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor. Quisque quis justo ut ipsum </p>
              <hr>
              <div class="name">Name Surname</div>
              <div class="desg">Designation</div>
            </div>
            <div class="testi_box">
              <div class="photo" style="background-image: url('images/testi_photo.jpg');"></div>
              <p>uis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor. Quisque quis justo ut ipsum </p>
              <hr>
              <div class="name">Name Surname</div>
              <div class="desg">Designation</div>
            </div>
            <div class="testi_box">
              <div class="photo" style="background-image: url('images/testi_photo.jpg');"></div>
              <p>uis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor. Quisque quis justo ut ipsum </p>
              <hr>
              <div class="name">Name Surname</div>
              <div class="desg">Designation</div>
            </div>
            <div class="testi_box">
              <div class="photo" style="background-image: url('images/testi_photo.jpg');"></div>
              <p>uis tincidunt non tellus ut auctor. In vitae eros turpis. Curabitur eu venenatis magna, vitae lobortis nulla. Pellentesque quis diam dolor.<br/> Quisque quis justo ut ipsumasasasas<br/> </p>
              <hr>
              <div class="name">Name Surname</div>
              <div class="desg">Designation</div>
            </div>
          </div>
        </div>
      </section>


   <!--    <section id="special_offer">
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
              <div class="sp_of_box1">
                <i class="fas fa-gift"></i>
                <div class="text_bx">
                  <h1>GIFT CARD</h1>
                  <span>GIFT CARD</span>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="sp_of_box2">
                <i class="fas fa-shopping-bag"></i>
                <div class="text_bx">
                  <h1>STORE<span>STORE</span></h1>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="sp_of_box3">
                <i class="fas fa-life-ring"></i>
                <div class="text_bx">
                  <h1>SUPPORT</h1>
                  <span>SUPPORT</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->
    </main>

    
@endsection  
  