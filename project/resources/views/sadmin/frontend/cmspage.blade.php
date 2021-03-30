@extends('sadmin.frontend.includes.newmaster')
@section('content')

    <section class="part-one bgcolor-white ptb-100" id="cms_data">
        <div class="section-padding contact-area-wrapper wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {!! $cms->description !!}
                        {{-- {!! htmlspecialchars_decode($cms->description) !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@stop

@section('footer')