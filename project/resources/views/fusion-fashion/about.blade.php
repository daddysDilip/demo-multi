@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else About Us @endif</li>
            </ol>
        </div>
    </nav>


    <div class="main-wrapper">
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