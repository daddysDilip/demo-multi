@extends('sadmin.includes.master-sadmin')

@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .order_invoice * {
            visibility: visible;
        }
        .order_invoice{
            visibility: hidden;
        }
        .order_invoice {
            position: absolute;
            margin-top: -300px;
            margin-left: -300px;
        }
        
    }
</style>


<div class="prtm-content-wrapper">
    <div class="prtm-content">
        <div class="prtm-page-bar">
            <ul class="breadcrumb">
                <li class="breadcrumb-item text-cepitalize">
                    <h3>Company</h3> </li>
                <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                <li class="breadcrumb-item"><a href="{!! url('sadmin/company') !!}">Company</a></li>
                <li class="breadcrumb-item">Company View</li>
            </ul>
        </div>

<!-- ==========================================================================> -->

                     <div class="order-detail">
                <div class="prtm-block">
            <div class="prtm-block-content prtm-block-no-gutter">
                        <div class="line-slide-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"> <a data-toggle="tab" href="#order" aria-expanded="false">Comapny Details</a> </li>
                                <li> <a data-toggle="tab" href="#invoice" aria-expanded="true">Invoice </a> </li>
                            </ul>
                        </div>
                    </div>



                            <div class="tab-content pad-all-lg">
                            <div id="order" class="tab-pane fade in active">
                                <div class="row">

                                    <div id="response">
                                        @if(Session::has('message'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                    </div>
                                        <div class="text-right">                     
                    <a href="{!! url('sadmin/company') !!}" class="btn btn-default btn-sm back-btn"> <i class="fa  fa-angle-double-left"></i> Back</a>
                    <a href="{!! url('sadmin/company/viewprint') !!}/{{$company[0]->id}}" class="btn btn-primary btn-sm print-order-btn">Print</a>
                </div>
                <h3><b>General Details</b></h3>
                <div class="box box-primary invoice quotes print" >
                    <div class="box-body">
                        <div class="row">
                            <div class="box-header page-header">
                                <div class="col-md-8">Company Details</div>
                                <!-- <div class="col-md-4">User Details</div>-->
                                <div class="col-md-4">Address Details</div>
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td width="45%">
                                            <h5><b>Company Name : </b></h5>
                                        </td>
                                        <td>{{$company[0]->comapany_name}}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%"><h5><b>User Name : </b></h5></td>
                                        <td>{{$company[0]->username}}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%"><h5><b>Company Logo : </b></h5></td>
                                        <td>
                                            @if($company[0]->company_logo != '') <img class="img-responsive display-ib" width="150" height="150" src="{{url('/')}}/assets/images/company/{{$company[0]->company_logo}}">
                                            @else
                                            <img class="img-responsive display-ib img-circle"  src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" width="150" height="150"> 
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td>
                                            <h5><b>URL : </b></h5>
                                        </td>
                                        <td>{{$company[0]->storeurl}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5><b>Company EmailId : </b></h5>
                                        </td>
                                        <td>{{$company[0]->company_email}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5><b>Company Phone No. : </b></h5>
                                        </td>
                                        <td>{{$company[0]->company_phone}}</td>
                                    </tr>
                                </table>
                            </div>                      
                            <div class="col-md-4">
                                <address style="word-wrap:break-word">
                                    {{$company[0]->addressline1}}
                                    <br>
                                    {{$company[0]->addressline2}}
                                    <br>
                                    {{$company[0]->cityname}}-{{$company[0]->pincode}}<br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div><br/><br/>    


                  <h3><b>Account Details</b></h3>
                <div class="box box-primary invoice quotes print">
                    <div class="box-body">
                        <div class="row">
                            <div class="box-header page-header">
                                <div class="col-md-6">Current Plan</div>
                                <div class="col-md-3">Account Status</div>
                                <div class="col-md-3">Member Since</div>
                            </div>
                            <div class="col-md-6">
                                <table>
                                    <tr>
                                        <td width="20%" ><h5><b>Plan Type :</h5></b></td>
                                        <td width="20%">{{$upgradeplan->plantype}}</td>
                                    
                                        <td width="20%"><h5><b>Purchase Date :</b></h5></td>
                                        <td width="20%">{{date("jS, M Y", strtotime($upgradeplan->start_date))}}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><h5><b>Plan Cost :</b></h5></td>
                                        <td width="20%">&#8377; {{$upgradeplan->payamount}}</td>
                                    
                                        <td width="20%"><h5><b>Expiry Date : </b></h5></td>
                                        <td width="20%">{{date("jS, M Y", strtotime($upgradeplan->expiry_date))}}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><h5><b>Duration : </b></h5></td>
                                        <td width="20%">{{$upgradeplan->duration}}</td>
                                    </tr>
                                </table>
                            </div>                      
                            <div class="col-md-3">
                                <table>
                                    <tr>
                                        <td>@if($company[0]->status == 1) @php echo "Active"; @endphp @else  @php echo "Deactive" @endphp @endif</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table>
                                    <tr>
                                        <td>
                                            {{date("jS, M Y", strtotime($company[0]->created_at))}}
                                        </td>
                                    </tr>                                   
                                </table>
                            </div>
                        </div>
                    </div>
                </div><br/><br/>

                 <h3><b>Theme Details</b></h3>
                <div class="box box-primary invoice quotes print" >
                    <div class="box-body">
                        <div class="row">
                            <div class="box-header page-header">
                                <div class="col-md-6">Current Theme</div>
                                <div class="col-md-6">Bought Theme</div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-6">
                                    @if($activetheme[0]->themeimage != '')
                                        <img src="{{url('/')}}/assets/images/themes/{{$activetheme[0]->themeimage}}" height="200" width="200" style="width:100%;margin-bottom: 10px;"/>
                                    @else
                                        <img src="{{url('/')}}/assets/images/placeholder.jpg" height="200" width="200" style="width:100%;margin-bottom: 10px;"/>
                                    @endif
                                    <h4 align="center"><b>{{$activetheme[0]->themename}}</b></h4>
                                </div>
                            </div>                      
                            <div class="col-md-6">
                                @if(count($buytheme) > 0)
                                    @php $i = 1; @endphp
                                    @foreach($buytheme as $buythemes)
                                        @if($i % 2 === 0)
                                        <div class="row">
                                        @endif
                                            <div class="col-md-2">
                                                @if($buythemes->themeimage != '') 
                                                <img src="{{url('/')}}/assets/images/themes/{{$buythemes->themeimage}}" height="50" width="50" style="width:100%;margin-bottom: 10px;"/>
                                                @else
                                                    <img src="{{url('/')}}/assets/images/default.jpg}}" height="50" width="50" style="width:100%;margin-bottom: 10px;"/>
                                                @endif</br>
                                                <p align="center"><b>{{$buythemes->themename}}</b></p>
                                            </div>
                                            <div class="col-md-4">
                                                <p><b>Price: </b>{{$buythemes->payment}}</br> <b>Purchase Date: </b>{{date("jS, M Y", strtotime($buythemes->created_at))}}</p>
                                            </div>
                                        @if($i % 2 === 0)
                                        </div>
                                        @endif
                                    @php $i++; @endphp
                                    @endforeach 
                                @endif
                            </div>
                        </div>
                    </div>
                </div><br><br>

                    <h3><b>Payment Details</b></h3>
                <div class="box box-primary invoice quotes print" >
                    <div class="box-body">
                        <div class="row">
                            <h4 align="center"><b>Plan Payment Details</b></h4>
                            <table class="table table-bordered text-center">
                                <tr class="bg-primary">
                                    <th class="text-center" width="20%">Plan Type </th>
                                    <th class="text-center" width="20%">Plan Cost</th>
                                    <th class="text-center" width="20%">Purchase Date</th>
                                    <th class="text-center" width="20%">Expiry Date</th>
                                </tr>
                                @if( count($paymentdetail) > 0 ) 
                                    @foreach($paymentdetail as $pdetails)
                                    <tr>
                                        <td>{{$pdetails->plantype}}</td>
                                        <td>&#8377; {{$pdetails->payamount}}</td>
                                        <td>{{date('jS, M Y',strtotime($pdetails->start_date))}}</td>
                                        <td>{{date('jS, M Y',strtotime($pdetails->expiry_date))}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr align="center">
                                        <td colspan="4"><?php echo "No Data Found"; ?></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="row">
                            <h4 align="center"><b>Theme Payment Details</b></h4>
                            <table class="table table-bordered text-center">
                                <tr class="bg-primary">
                                    <th class="text-center" width="20%">Theme Name </th>
                                    <th class="text-center" width="20%">Theme Price</th>
                                    <th class="text-center" width="20%">Purchase Date</th>
                                </tr>
                                @if(count($buytheme) > 0) 
                                    @foreach($buytheme as $buythemes) 
                                    <tr>
                                        <td>{{$buythemes->themename}}</td>
                                        <td>{{$buythemes->payment}}</td>
                                        <td>{{$buythemes->created_at->format('jS, M Y')}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr align="center">
                                        <td colspan="3"><?php echo "No Data Found"; ?></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>




                              
                                </div>
                             </div>


         <!-- ==============================================================>                     -->

     <div id="invoice"  class="tab-pane fade in ">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-8">
                                        <div class="prtm-block">
                                            <div class="order_invoice">
                                                <div class="mrgn-b-lg clearfix">

                                                    <div class="pull-left">
                                                        <div class="invoice_from">
                                                            <address>
                <span class="fw-medium font-lg mrgn-b-md show"><b>Name : </b>{{$company[0]->comapany_name}}</span>
                <!-- <span class="show" ><b>User Name : </b>{{$company[0]->username}}</span> -->
                  <span class="show" ><b>Logo :</b>
                                            @if($company[0]->company_logo != '') 
                                            <img class="img-responsive display-ib" width="150" height="150" src="{{url('/')}}/assets/images/company/{{$company[0]->company_logo}}">
                                            @else
                                            <img class="img-responsive display-ib img-circle"  src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" width="150" height="150"> 
                                            @endif
                                        </span>
                <span class="show" ><b>URL : </b>{{$company[0]->storeurl}}</span>

                <span class="show" ><b>Company EmailId : </b>{{$company[0]->company_email}}</span>
                <span class="show" ><b>Company Phone No. : </b>{{$company[0]->company_phone}}</span>                     
                                                            </address>
                                                        </div>
                                                    </div>

                                                    <div class="pull-right text-right">
                                                        <div class="invoice_to">
                                                            <div class="mrgn-b-lg">
                                                                <h5 class="text-uppercase">{{trans('app.InvoiceNo')}}: 7897897898</h5> 
                                                            </div>
                                                          
                                                                <h5>{{trans('app.To')}},</h5>
                                                                <h5></h5> 
                                                                <address style="word-wrap:break-word">
                                                                   {{$company[0]->addressline1}}
                                                                      <br>
                                                                      {{$company[0]->addressline2}}
                                                                           <br>
                                                               {{$company[0]->cityname}}-{{$company[0]->pincode}}<br>
                                        <span class="show" >EmailId :  {{$company[0]->company_email}}</span>
                                       <span class="show" >Phone No. :{{$company[0]->company_phone}}</span> 
                                                                   </address>
                                                       
                                                       <!--          <h5>{{trans('app.To')}},</h5>
                                                                <address>
                                                                    <span  class="show">h2</span>
                                                                    <span  class="show">h22</span>
                                                                    <span  class="show">h23</span>
                                                                    <span  class="show">h234</span>
                                                                    <span  class="show">h34rt</span>
                                                                </address>
                                                       -->
                                                        </div>
                                                      </div>
                                                </div>

                                                <div class="table-responsive mrgn-b-lg prtm-block-no-gutter">
                                                     <h4 align="center"><b>Plan Payment Details</b></h4>
                                                    <table class="table table-striped table-hover">
                                                        <thead class="thead-primary">
                                                            <tr class="bg-primary">
                                                              <th class="text-center" width="20%">Plan Type </th>
                                                               <th class="text-center" width="20%">Plan Cost</th>
                                                                <th class="text-center" width="20%">Purchase Date</th>
                                                                <th class="text-center" width="20%">Expiry Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        
                                                          
                                                                
                                                                 @if( count($paymentdetail) > 0 ) 
                                    @foreach($paymentdetail as $pdetails)
                                    <tr>
                                        <td class="text-center">{{$pdetails->plantype}}</td>
                                        <td class="text-center">&#8377; {{$pdetails->payamount}}</td>
                                        <td class="text-center">{{date('jS, M Y',strtotime($pdetails->start_date))}}</td>
                                        <td class="text-center">{{date('jS, M Y',strtotime($pdetails->expiry_date))}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr align="center">
                                        <td colspan="4"><?php echo "No Data Found"; ?></td>
                                    </tr>
                                @endif
                                                           
                                                        </tbody>
                                                    </table>

                                                               <h4 align="center"><b>Plan Payment Details</b></h4>
                                                    <table class="table table-striped table-hover">
                                                        <thead class="thead-primary">
                                                                <tr class="bg-primary">
                                    <th class="text-center" width="20%">Theme Name </th>
                                    <th class="text-center" width="20%">Theme Price</th>
                                    <th class="text-center" width="20%">Purchase Date</th>
                                </tr>
                                                        </thead>
                                                        <tbody>
                                        @if(count($buytheme) > 0) 
                                    @foreach($buytheme as $buythemes) 
                                    <tr>
                                        <td class="text-center">{{$buythemes->themename}}</td>
                                        <td class="text-center">{{$buythemes->payment}}</td>
                                        <td class="text-center">{{$buythemes->created_at->format('jS, M Y')}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr align="center">
                                        <td colspan="3"><?php echo "No Data Found"; ?></td>
                                    </tr>
                                @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
                                        </div>
                                    </div>
                                  
                                    <div class="col-sm-12 col-md-12 col-lg-4">
                                        <div class="prtm-block-content">
                                            <a href="{{url('sadmin/companypdf/')}}/{{$company[0]->id}}"><button class="btn btn-block btn-success btn-lg mrgn-b-xs">
                                            {{ trans('app.DownloadInvoice') }}
                                            </button></a>
                                            <button class="btn btn-block btn-default btn-lg mrgn-b-xs" onclick="window.print();">{{ trans('app.Print') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>






</div>
    <!-- /#page-wrapper -->

@stop

@section('footer')

<script type="text/javascript">

    function delete_data(reportid)
    {
        if(confirm('Are You sure You want to Delete ?'))
        {
            window.location = "{{url('/')}}/sadmin/company/delete/"+reportid;
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
    
    $(document).ready(function(){

        $('#website_form').validate({
            rules:{
                cms_title:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                cms_text:{ 
                    minlength: 3,
                    maxlength: 255,
                }
            },
            highlight: function (element) {
                $(element).parent().addClass('has-error')
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('has-error')
            },
            errorElement: 'span',
            errorClass: 'text-danger',
        });

    });
</script>

@stop