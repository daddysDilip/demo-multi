@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>

    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{$pagetitle[0]->title}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
                  <li class="breadcrumb-item active text-capitalize" aria-current="page">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else About Us @endif</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="cms_section">
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