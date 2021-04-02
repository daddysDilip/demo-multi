@extends('sadmin.includes.master-sadmin2')

@section('content')

    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Plan</h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Manage Plan</li>
                </ul>

            </div>
        </div>
    </div>
    <div class="container-fluid">
        
            <div class="card">
                
                <div class="body" style="float: right;">
                    
                    <a href="{!! url('sadmin/plans/create') !!}" class="btn btn-primary hidden-sm-down float-right m-l-10" type="button">Add New Plan <i class="zmdi zmdi-plus"></i>
                    </a>
                    <div id="res">
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="pricing pricing-palden">
                    @php
                        $background_colors = array('l-blush','l-slategray','l-pink','g-bg-cgreen','g-bg-blue','l-turquoise','g-bg-blush2','g-bg-soundcloud');
                    @endphp
                    @foreach($plan as $allplan)
                    @php
                    $rand_background = $background_colors[array_rand($background_colors)];
                    
                     
                    @endphp
                    <div class="pricing-item">
                        <div class="pricing-deco  {{strtolower($allplan->plantype)}} {{$rand_background}}">
                            <svg class="pricing-deco-img" enable-background="new 0 0 300 100" height="100px" id="Layer_1" preserveAspectRatio="none" version="1.1" viewBox="0 0 300 100" width="300px" x="0px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" y="0px">
                            <path class="deco-layer deco-layer--1" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729&#x000A; c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" fill="#FFFFFF" opacity="0.6"></path>
                            <path class="deco-layer deco-layer--2" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729&#x000A;    c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" fill="#FFFFFF" opacity="0.6"></path>
                            <path class="deco-layer deco-layer--3" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716&#x000A;    H42.401L43.415,98.342z" fill="#FFFFFF" opacity="0.7"></path>
                            <path class="deco-layer deco-layer--4" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428&#x000A; c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" fill="#FFFFFF"></path>
                            </svg>
                            <div class="pricing-price"><span class="pricing-currency">₹</span>{{$allplan->planamount}}
                            <span class="pricing-period">/ Mo</span>
                            </div>
                            <h3 class="pricing-title">{{$allplan->plantype}}</h3>
                        </div>
                        <ul class="feature-list">
                            {!! htmlspecialchars_decode($allplan->description) !!}
                            
                        </ul>
                        <a href="plans/{{$allplan->id}}/edit" class="{{$rand_background}} {{strtolower($allplan->plantype)}}  pricing-action ">Edit</a>
                    </div>
                    


                    @endforeach
                </div>
            </div>
        </div>
        

            <!-- Page Content -->
            
        
    </div>
    <!-- /.container-fluid -->
    
    <!-- /#page-wrapper -->

@stop

@section('footer')

<script type="text/javascript">

    function delete_data(reportid)
    {
        if(confirm('Are You sure You want to Delete ?'))
        {
            window.location = "{{url('/')}}/sadmin/plans/delete/"+reportid;
            return true;
        }
        else
        {
            return false;
        }
    }

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });
    
</script>

@stop