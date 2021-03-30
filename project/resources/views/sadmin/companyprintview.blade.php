<!DOCTYPE html>
<html>
<head>
	<title>company View - PDF</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style type="text/css">
		.invoice_content
		{
			width: 100%;
		}
		.invoice_content h3.title
		{
			font-size:20px;
		}
		.invoice_content .invoice
		{
			border: 6px solid #777;
			margin-bottom: 40px;
			padding: 20px 10px;
		}
		.invoice .table td
		{
			border-bottom: none;
			border-top: none;
		}
		.invoice .table tr td h5{ margin: 4px 0px 0px; }
	</style>
</head>
<body>
	<section class="content invoice_content">
		<div class="row">
			<div class="col-md-12">
								
				<h3 class="title"><b>General Details</b></h3>
				<div class="box box-primary invoice quotes print">
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">								
								<table class="table">
									<thead></thead>
									<tbody>
										<tr>
											<td rowspan="6">Company Details</td>
											<td width="23%"><h5><b>Company Name : </b></h5></td>
											<td>{{$company[0]->comapany_name}}</td>
										</tr>
										<tr>
	                                        <td width="45%"><h5><b>User Name : </b></h5></td>
	                                        <td>{{$company[0]->username}}</td>
	                                    </tr>
	                                    <tr>
	                                        <td width="45%"><h5><b>Company Logo : </b></h5></td>
	                                        <td width="22%">
	                                            @if($company[0]->company_logo != '') <img class="img-responsive display-ib" src="{{url('/')}}/assets/images/company/{{$company[0]->company_logo}}" height="100px" width="100px" style="margin-bottom: 5px;"/>
	                                            @else
	                                            <img class="img-responsive display-ib img-circle"  src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" height="100" width="100" style="margin-bottom: 5px;"/> 
	                                            @endif
	                                        </td>
	                                    </tr>
										<tr>
											<td><h5><b>URL : </b></h5></td>
											<td>{{$company[0]->storeurl}}</td>
										</tr>
										<tr>
											<td><h5><b>Company EmailId : </b></h5></td>
											<td>{{$company[0]->company_email}}</td>
										</tr>
										<tr>
											<td><h5><b>Company Phone No. : </b></h5></td>
											<td>{{$company[0]->company_phone}}</td>
										</tr>
									</tbody>
								</table>
							</div> 							
							<div class="col-md-6">
								<table class="table">
									<thead></thead>
									<tbody>
										<tr>
											<td>Address</td>
											<td width="58%">
												<address style="float:left;word-wrap:break-word;margin-left: -8%;">
													{{$company[0]->addressline1}}
				                                    <br>
				                                    {{$company[0]->addressline2}}
				                                    <br>
													{{$company[0]->cityname}}-{{$company[0]->pincode}}<br>
												</address>
											</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
				<h3 class="title"><b>Account Details</b></h3>
				<div class="box box-primary invoice quotes print" >
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">								
								<table class="table">
									<thead></thead>
									<tbody>
										<tr>
											<td rowspan="5">Current Plan </td>
											<td width="42%"><h5><b>Plan :</b></h5></td>
											<td width="35%">{{$upgradeplan->plantype}}</td>
										</tr>
										<tr>
											<td width="42%"><h5><b>Plan Cost : </b></h5></td>
											<td>Rs. {{$upgradeplan->payamount}}</td>
										</tr>
										<tr>
											<td width="42%"><h5><b>Duration : </b></h5></td>
											<td>{{$upgradeplan->duration}}</td>
										</tr>
										<tr>
											<td width="42%"><h5><b>Purchase Date : </b></h5></td>
											<td>{{date("jS, M Y", strtotime($upgradeplan->start_date))}}</td>
										</tr>
										<tr>
											<td width="42%"><h5><b>Expiry Date : </b></h5></td>
											<td>{{date('jS, M Y',strtotime($upgradeplan->expiry_date))}}</td>
										</tr>
									</tbody>
								</table>
							</div> 								
							<div class="col-md-6">
								<table class="table">
									<thead></thead>
									<tbody>
										<tr>
											<td>Current Plan</td>
											<td width="58%"><h5><b>@if($company[0]->status == 1) Active @else Deactive @endif</b></h5></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-6">
								<table class="table">
									<thead></thead>
									<tbody>
										<tr>
											<td>Member Since</td>
											<td width="58%"><h5><b>{{date("M d, Y", strtotime($company[0]->created_at))}}</b></h5></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<br>
				<h3 class="title"><b>Theme Details</b></h3>
				<div class="box box-primary invoice quotes print" >
					<div class="box-body">
						<div class="row">
							<table class="table">
								<thead></thead>
								<tbody>
									<tr>
										<td>Current Theme</td>
										<td width="22%">
											@if($activetheme[0]->themeimage != '')
											<img src="{{url('/')}}/assets/images/themes/{{$activetheme[0]->themeimage}}" height="100" width="100" style="margin-bottom: 5px;"/>
											@else
												<img src="{{url('/')}}/assets/images/default.jpg" height="100" width="100" style="margin-bottom: 5px;"/>
											@endif
											<h4 style="margin-top: 2px;"><b>{{$activetheme[0]->themename}}</b></h4>
										</td>
										<td></td>
									</tr>
									<tr><td colspan="3"></td></tr>
									<tr>
										<td>Bought Theme</td>								
										<td width="22%">
											@if(count($buytheme) > 0)
												@foreach($buytheme as $buythemes)
													@if($buythemes->themeimage != '')
													<img src="{{url('/')}}/assets/images/themes/{{$buythemes->themeimage}}" height="50" width="50"  style="margin-bottom: 25px;"/><br>
													@else
													<img src="{{url('/')}}/assets/images/default.jpg" height="50" width="50" style="margin-bottom: 25px;"/><br>
													@endif
											
												@endforeach 
											@else  
												@php echo "<p>--</p>"; @endphp
											@endif
										</td>
										<td>
											@if(count($buytheme) > 0)
												@foreach($buytheme as $buythemes)
													<p><b>{{$buythemes->themename}}</b><br><b>Price: </b>{{$buythemes->payment}}<br><b>Purchase Date: </b> {{date("M d, Y", strtotime($buythemes->created_at))}}</p>
												@endforeach 
											@else 
												@php echo "<p>--</p>"; @endphp
											@endif	
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<br>
				<h3 class="title"><b>Payment Details</b></h3>
				<div class="box box-primary invoice quotes print">
					<div class="box-body">
						<div class="row">
							<h4 align="center"><b>Plan Payment Details</b></h4>
							<table class="table table-hover table-striped table-bordered text-center"  border="1" style="width: 98.4%;margin: 0px auto 20px;">
								<thead>
									<tr>
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
											<td>{{$pdetails->plantype}}</td>
	                                        <td>Rs. {{$pdetails->payamount}}</td>
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
						<div class="row">
							<h4 align="center"><b>Theme Payment Details</b></h4>
							<table class="table table-hover table-striped table-bordered text-center" border="1" style="width: 98.4%;margin: 0px auto;">
								<thead>
									<tr align="center">
										<th>Theme Name </th>
										<th>Theme Price</th>
										<th>Purchase Date</th>
									</tr>
								</thead>
								<tbody>
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
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>