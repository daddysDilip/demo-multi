@extends('ecommerce-4.includes.newmaster')

@section('content')

<main>

    <section id="inner_banner" style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;background-color: #2278b8;">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans('app.Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else About Us @endif</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>

    <div id="main_contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
				 @if($pagedata->about != '')
				
				 {!! htmlspecialchars_decode($pagedata->about) !!}
				
				@else 
					
				<p class="text-center" style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</p>
				
				@endif
                   
                </div>
            </div>
        </div>
    </div>

</main>
   

@stop

@section('footer')

@stop