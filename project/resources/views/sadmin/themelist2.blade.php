@extends('sadmin.includes.master-sadmin2')

@section('content')

        <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <!-- <h2>Product
                <small class="text-muted">Welcome to Compass</small>
                </h2> -->
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Theme</li>
                </ul>
            </div>
        </div>
    </div>
        <div class="container-fluid">
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
            

            <!-- Page Content -->
            
            <div class="row clearfix">
            @php $athemearray = array(); @endphp
            @if(count($activetheme) > 0)
                @foreach($activetheme as $atheme)
                    @php $athemearray[] = $atheme->theme @endphp
                @endforeach
            @endif
            @foreach($theme as $alltheme)
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card product_item">
                    <div class="body">
                        <div class="cp_img">
                            @if($alltheme->themeimage != '')
                            <img src="{{url('/')}}/assets/images/themes/{{$alltheme->themeimage}}" alt="product thumbnail" class="img-fluid" >
                            @else
                            <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="product thumbnail" class="img-fluid" >
                            @endif
                            <div class="hover">
                                <a href="themes/{{$alltheme->id}}/edit" class="btn btn-primary waves-effect"><i class="zmdi zmdi-edit"></i></a>
                                @if(!in_array($alltheme->id, $athemearray))
                                    @if($alltheme->id != 1)
                                   <!--  <a href="javascript:;" onclick="return delete_data('{{$alltheme->id}}');" class="btn btn-white btn-block">Remove</a> --> 
                                    <a href="javascript:void(0);" onclick="return delete_data('{{$alltheme->id}}');" class="btn btn-primary waves-effect"><i class="zmdi zmdi-delete"></i></a>
                                    @endif
                                @endif
                                
                            </div>
                        </div>
                        <div class="product_details">
                            <h5><a href="ec-product-detail.html">{{$alltheme->themename}}</a></h5>
                            <ul class="product_price list-unstyled">
                                <!-- <li class="old_price">$16.00</li> -->
                                 <li class="new_price">@if($alltheme->paid == 0) Free @else ₹ {{$alltheme->themeprice}}@endif</li>
                               
                            </ul>
                        </div>
                    </div>
                </div>                
            </div>
            @endforeach
            
        </div>
        </div>
    
    <!-- /.container-fluid -->
    

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