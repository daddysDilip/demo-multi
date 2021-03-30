<!DOCTYPE html>
<html>
<head>
    <title>Company-{{$company[0]->id}}</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

 <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 3cm;
            }
            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
            }
        </style>

</head>


<body>

<div class="container" >
    
    <div class="row">
        <div class="col-md-12">
            <div class="dashboard-content">
                <div class="view-order-page">
                    <h3>Company# {{$company[0]->id}}</h3><hr/>
                   
                    <p class="order-date"><b>Comapny Date: </b>  {{$company[0]->created_at->format('jS, M Y')}}</p>

                    <div class="shipping-add-area">
                        <div class="row">
                            <div class="col-md-6" style="float: left;">
                             <address>
                <span class="fw-medium font-lg mrgn-b-md show"><b>Name : </b>{{$company[0]->comapany_name}}</span><br/>
                <!-- <span class="show" ><b>User Name : </b>{{$company[0]->username}}</span> -->
             <!--      <span class="show" ><b>Logo :</b>
                                            @if($company[0]->company_logo != '') 
                                            <img class="img-responsive display-ib"  src="{{url('/')}}/assets/images/company/{{$company[0]->company_logo}}" width="50px" height="10px">
                                            @else
                                            <img class="img-responsive display-ib img-circle"  src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" width="150" height="150"> 
                                            @endif
                                        </span> -->
                <span class="show" ><b>URL : </b>{{$company[0]->storeurl}}</span>

                                
                                                            </address>
                            </div>
                            <div class="col-md-6" style="float: right;">
                                 <address style="word-wrap:break-word">
                                                        <h5><b>To,</b></h5>
                                                                   {{$company[0]->addressline1}}
                                                                      <br>
                                                                      {{$company[0]->addressline2}}
                                                                           <br>
                                                               {{$company[0]->cityname}}-{{$company[0]->pincode}}<br>
                                     <span class="show" ><b>EmailId : </b>{{$company[0]->company_email}}</span>
                                       <span class="show" ><b>Phone No. : </b>{{$company[0]->company_phone}}</span>
                                                                   </address>
                            </div>
                        </div>
                    </div>
                              @if( count($paymentdetail) > 0 ) 
                        <br/><h4 class="text-center"><b>Plan Payment Details:</b></h4>



                          <div class="table-responsive">
                        <table class="table table-bordered veiw-details-table">
                            <thead>
                                <tr class="veiw-details-row bg-primary">
                                       <th class="text-center" width="20%">Plan Type </th>
                                                               <th class="text-center" width="20%">Plan Cost</th>
                                                                <th class="text-center" width="20%">Purchase Date</th>
                                                                <th class="text-center" width="20%">Expiry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                  @if( count($paymentdetail) > 0 ) 
                                    @foreach($paymentdetail as $pdetails)
                                    <tr >
                                        <td>{{$pdetails->plantype}}</td>
                                        <td>Rs {{$pdetails->payamount}}</td>
                                        <td>{{date('jS, M Y',strtotime($pdetails->start_date))}}</td>
                                        <td>{{date('jS, M Y',strtotime($pdetails->expiry_date))}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr align="center">
                                        <td colspan="4"><?php echo "No Data Found"; ?></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <br/><br/>

                                @if(count($buytheme) > 0) 
                     <h4 class="text-center"><b>Plan Payment Details:</b></h4>



                          <div class="table-responsive">
                        <table class="table table-bordered veiw-details-table">
                            <thead>
                              <tr class="veiw-details-row bg-primary">
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
                    @endif








                 
                </div>
            </div>
        </div>
    </div>

 <footer>
         <hr/> <p class="text-center" >Copyright &copy; <?php echo date("Y");?> </p>

</div>
</body>
</html>