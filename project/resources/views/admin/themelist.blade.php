@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.Themes')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.Themes')}}</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default theme_details">
                <div class="panel-body">
                    <div id="res">
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#all" data-toggle="tab" aria-expanded="true">{{trans('app.All')}}</a></li>
                            <li class=""><a href="#free" data-toggle="tab" aria-expanded="true">{{trans('app.Free')}}</a></li>
                            <li class=""><a href="#premium" data-toggle="tab" aria-expanded="false">{{trans('app.Premium')}}</a></li>
                        </ul>
                    </div>

                    <div class="col-xs-12">
                        <div class="tab-content">
                            @if(count($themeplan) > 0)
                                @foreach($themeplan as $plan)
                                    @php $plantheme[]= $plan->themeid; @endphp
                                @endforeach
                            @else
                                @php $plantheme[]= 0; @endphp
                            @endif

                            @foreach($buytheme as $buythemes)
                                @php $buythemesarray[]= $buythemes->themeid; @endphp
                            @endforeach
        
                            <div class="tab-pane active" id="all">
                                <br><br>
                                <div class="ln_solid"></div>
                                @foreach($theme as $alltheme)
                                    @php $free=0; @endphp   
                                    @if(in_array($alltheme->id,$plantheme))
                                        @php $free= 1;  @endphp                          
                                    @endif
                                    @php $brought = 0; @endphp
                                    @if(count($buytheme) > 0)
                                        @if(in_array($alltheme->id,$buythemesarray))
                                            @php $brought= 1;  @endphp  
                                        @endif
                                    @endif
                                @if($alltheme->id == $settings[0]->theme)
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 mrgn-b-lg active_theme">
                                @else
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 mrgn-b-lg deactive_theme">
                                @endif
                                    <div class="prtm-block">
                                        <div class="overlay-wrap text-center mrgn-b-md">
                                            <div class="">
                                                @if($alltheme->themeimage != '')
                                                <img src="{{url('/')}}/assets/images/themes/{{$alltheme->themeimage}}" alt="product thumbnail" class="img-responsive" width="300" height="300" style="height: 300px;">
                                                @else
                                                <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="product thumbnail" class="img-responsive" width="300" height="300" style="height: 300px;">
                                                @endif
                                            </div>
                                            <div class="hover-overlay pos-center primary-tp-layer">
                                                <div class="center-holder"> 
                                                    @if($alltheme->paid == 0 || $free == 1 || $brought == 1)
                                                        @if($alltheme->id == $settings[0]->theme)
                                                        <a href="#" class="btn btn-white btn-block">{{trans('app.Preview')}}</a>
                                                        @else
                                                        <a href="themesettings/active/{{$alltheme->id}}" class="btn btn-white btn-block active">{{trans('app.Active')}}</a>
                                                        @endif
                                                    @else
                                                        <a href="themesettings/buytheme/{{$alltheme->id}}" class="btn btn-white btn-block">{{trans('app.Buy')}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrapper-content">
                                            <div class="row">
                                                <div class="col-xs-7 col-sm-7 col-md-7"><h5 class="text-capitalize">{{$alltheme->themename}}</h5></div>
                                                <div class="col-xs-5 col-sm-5 col-md-5 text-right">
                                                    @if($alltheme->paid == 0 || $free == 1)<h5>{{trans('app.Free')}}</h5>@else<h5>${{$alltheme->themeprice}}</h5>@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="tab-pane" id="free">
                                <br><br>
                                <div class="ln_solid"></div>
                                @foreach($theme as $alltheme)
                                    @php $free=0; @endphp   
                                    @if(in_array($alltheme->id,$plantheme))
                                        @php $free= 1;  @endphp                          
                                    @endif
                                    @php $brought = 0; @endphp
                                    @if(count($buytheme) > 0)
                                        @if(in_array($alltheme->id,$buythemesarray))
                                            @php $brought= 1;  @endphp  
                                        @endif
                                    @endif
                                @if($alltheme->paid == 0 || $free == 1)
                                    @if($alltheme->id == $settings[0]->theme)
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 mrgn-b-lg active_theme theme_details">
                                    @else
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 mrgn-b-lg deactive_theme theme_details">
                                    @endif
                                        <div class="prtm-block">
                                            <div class="overlay-wrap text-center mrgn-b-md">
                                                <div class="">
                                                    @if($alltheme->themeimage != '')
                                                    <img src="{{url('/')}}/assets/images/themes/{{$alltheme->themeimage}}" alt="product thumbnail" class="img-responsive" width="300" height="300" style="height: 300px;">
                                                    @else
                                                    <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="product thumbnail" class="img-responsive" width="300" height="300" style="height: 300px;">
                                                    @endif
                                                </div>
                                                <div class="hover-overlay pos-center primary-tp-layer">
                                                    <div class="center-holder"> 
                                                        @if($alltheme->paid == 0 || $free == 1 || $brought == 1)
                                                            @if($alltheme->id == $settings[0]->theme)
                                                            <a href="#" class="btn btn-white btn-block">{{trans('app.Preview')}}</a>
                                                            @else
                                                            <a href="themesettings/active/{{$alltheme->id}}" class="btn btn-white btn-block active">{{trans('app.Active')}}</a>
                                                            @endif
                                                        @else
                                                            <a href="themesettings/buytheme/{{$alltheme->id}}" class="btn btn-white btn-block">{{trans('app.Buy')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wrapper-content">
                                                <div class="row">
                                                    <div class="col-xs-7 col-sm-7 col-md-7"><h5 class="text-capitalize">{{$alltheme->themename}}</h5></div>
                                                    <div class="col-xs-5 col-sm-5 col-md-5 text-right">
                                                        @if($alltheme->paid == 0 || $free == 1)<h5>{{trans('app.Free')}}</h5>@else<h5>${{$alltheme->themeprice}}</h5>@endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endforeach
                            </div>
                            <div class="tab-pane" id="premium">
                                <br><br>
                                <div class="ln_solid"></div>
                                @foreach($theme as $alltheme)
                                    @php $free=0; @endphp   
                                    @if(in_array($alltheme->id,$plantheme))
                                        @php $free= 1;  @endphp                          
                                    @endif
                                    @php $brought = 0; @endphp
                                    @if(count($buytheme) > 0)
                                        @if(in_array($alltheme->id,$buythemesarray))
                                            @php $brought= 1;  @endphp
                                        @endif
                                    @endif
                                @if($alltheme->paid == 1)
                                    @if($free == 0)
                                    @if($alltheme->id == $settings[0]->theme)
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 mrgn-b-lg active_theme">
                                    @else
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 mrgn-b-lg deactive_theme">
                                    @endif
                                        <div class="prtm-block">
                                            <div class="overlay-wrap text-center mrgn-b-md">
                                                <div class="">
                                                    @if($alltheme->themeimage != '')
                                                    <img src="{{url('/')}}/assets/images/themes/{{$alltheme->themeimage}}" alt="product thumbnail" class="img-responsive" width="300" height="300" style="height: 300px;">
                                                    @else
                                                    <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="product thumbnail" class="img-responsive" width="300" height="300" style="height: 300px;">
                                                    @endif
                                                </div>
                                                <div class="hover-overlay pos-center primary-tp-layer">
                                                    <div class="center-holder"> 
                                                        @if($alltheme->paid == 0 || $free == 1 || $brought == 1)
                                                            @if($alltheme->id == $settings[0]->theme)
                                                            <a href="#" class="btn btn-white btn-block">{{trans('app.Preview')}}</a>
                                                            @else
                                                            <a href="themesettings/active/{{$alltheme->id}}" class="btn btn-white btn-block active">{{trans('app.Active')}}</a>
                                                            @endif
                                                        @else
                                                            <a href="themesettings/buytheme/{{$alltheme->id}}" class="btn btn-white btn-block">{{trans('app.Buy')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wrapper-content">
                                                <div class="row">
                                                    <div class="col-xs-7 col-sm-7 col-md-7"><h5 class="text-capitalize">{{$alltheme->themename}}</h5></div>
                                                    <div class="col-xs-5 col-sm-5 col-md-5 text-right">
                                                        @if($alltheme->paid == 0 || $free == 1)<h5>{{trans('app.Free')}}</h5>@else<h5>${{$alltheme->themeprice}}</h5>@endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.end -->
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

@stop

@section('footer')

<script type="text/javascript">

    function delete_data(reportid)
    {
        if(confirm(DeleteConfirmation))
        {
            window.location = "{{url('/')}}/sadmin/themes/delete/"+reportid;
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