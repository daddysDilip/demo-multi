@extends('includes.newmaster')

@section('content')


    <section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
        <div class="row" style="background-color:rgba(0,0,0,0.7);">

            <div style="margin: 3% 0px 3% 0px;">
                <div class="text-center" style="color: #FFF;padding: 20px;">
                    <h1>@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else About Us @endif</h1>
                </div>
            </div>

        </div>
    </section>

    <div class="home-wrapper">
        <!-- Starting of contact us area -->
        <div class="section-padding contact-area-wrapper wow fadeInUp">
            <div class="container">
                <div class="row">
                <div class="col-md-12">
				
               @if($pagedata->about != '')
				
				{!! $pagedata->about !!}  
				
				@else 
					
				<p class="text-center" style="margin-bottom: 0px;">{{trans('app.NoDataFound')}}</p>
				
				@endif
                </div>
            </div>
        </div>
        </div>
    </div>

@stop

@section('footer')

@stop