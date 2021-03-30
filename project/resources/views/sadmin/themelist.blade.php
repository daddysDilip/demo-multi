@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Themes</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Themes</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
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
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            <a href="{!! url('sadmin/themes/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Theme</a>
                        </div>
                    </div>
                    <div class="prtm-block-content">
                        <div class="dataTables_wrapper">

                        @php $athemearray = array(); @endphp
                        @if(count($activetheme) > 0)
                            @foreach($activetheme as $atheme)
                                @php $athemearray[] = $atheme->theme @endphp
                            @endforeach
                        @endif
                        @foreach($theme as $alltheme)
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 mrgn-b-lg theme_details">
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
                                                <a href="themes/{{$alltheme->id}}/edit" class="btn btn-white btn-block">Edit</a> 
                                                @if(!in_array($alltheme->id, $athemearray))
                                                    @if($alltheme->id != 1)
                                                    <a href="javascript:;" onclick="return delete_data('{{$alltheme->id}}');" class="btn btn-white btn-block">Remove</a> 
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper-content">
                                        <div class="row">
                                            <div class="col-xs-7 col-sm-7 col-md-7"><h5 class="text-capitalize">{{$alltheme->themename}}</h5></div>
                                            <div class="col-xs-5 col-sm-5 col-md-5 text-right">
                                                @if($alltheme->paid == 0)<h5>Free</h5>@else<h5>${{$alltheme->themeprice}}</h5>@endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
        if(confirm('Are You sure You want to Delete ?'))
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