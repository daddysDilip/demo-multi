@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Company</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/company') !!}">Company</a></li>
                    <li class="breadcrumb-item">Manage Company</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>

                    <form method="POST" action="{{url('sadmin/company')}}/{{$company->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="general_form">
                        {{csrf_field()}}
						
                        <input type="hidden" name="id" value="{{$company->id}}">
                        <input type="hidden" name="_method" value="PATCH">
						
						<div class="col-md-6 col-lg-6">                                
							<div class="prtm-block min-height-505">
								<div class="horizontal-form-style">

									<div class="prtm-block-title mrgn-b-lg">
										<h3>General Information</h3>
										<p></p>
									</div>

									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Company Name<span class="required">*</span>
											
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="comapany_name" class="form-control col-md-7 col-xs-12" name="comapany_name" readonly placeholder="Enter Company Name" type="text" maxlength="30" minlength="3" value="{{$company->comapany_name}}">
										</div>
									</div>
									
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User Name<span class="required">*</span>
											
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="username" readonly class="form-control col-md-7 col-xs-12" name="username" placeholder="Enter User Name" type="text" maxlength="30" minlength="3"  value="{{$company->username}}" style="text-transform: lowercase;">
										</div>
									</div>
									
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email Adress<span class="required">*</span>
											
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="company_email" readonly class="form-control col-md-7 col-xs-12" name="company_email" placeholder="Enter Email Address" type="email" maxlength="50" minlength="3" value="{{$company->company_email}}">
										</div>
									</div>
										
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Phone Number<span class="required">*</span>
											
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="company_phone" class="form-control col-md-7 col-xs-12" name="company_phone" placeholder="Enter Phone Number" type="text" maxlength="15" minlength="10" onkeypress="return isNumber(event)" value="{{$company->company_phone}}">
										</div>
									</div>

									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Select Language<span class="required">*</span></label>


										<div class="col-md-6 col-sm-6 col-xs-12">
											@php $selected = explode(",", $company->language); @endphp

											<select class="form-control multipleSelect" multiple name="language[]" id="language" required>
												<option value="">Select Language</option>
												@foreach($languages as $alllanguage)
													<option value="{{$alllanguage->code}}" @if(in_array($alllanguage->code, $selected)) selected @endif>{{$alllanguage->name}}</option>
												@endforeach
											</select>
										</div>
									</div>

									
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> Current Company Logo <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											@if($company->company_logo != '')
											<img src="{!! url('/') !!}/assets/images/company/{{$company->company_logo}}" style="max-height: 50px;width: 50%;margin-bottom: 15px;" alt="No Company logo"><br>
											@else
											<img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" style="max-height: 50px;width: 50%;margin-bottom: 15px;" alt="No Company logo"><br>
											@endif
											<input type="file" id="company_logo" name="company_logo" accept="image/*" />
										</div>
									</div>
																			
								</div>
							</div>
						</div>
						
						<div class="col-md-6 col-lg-6">                                
							<div class="prtm-block min-height-505">
								<div class="horizontal-form-style">

									<div class="prtm-block-title mrgn-b-lg">
										<h3>Address Information</h3>
										<p></p>
									</div>	
							
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Address Line 1<span class="required">*</span>
											
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="addressline1" class="form-control col-md-7 col-xs-12" name="addressline1" placeholder="Enter Address Line 1" type="text" maxlength="100" minlength="3" value="{{$company->addressline1}}">
										</div>
									</div>
									
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Address Line 2
											
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="addressline2" class="form-control col-md-7 col-xs-12" name="addressline2" placeholder="Enter Address Line 2" type="text" maxlength="100" minlength="3" value="{{$company->addressline2}}">
										</div>
									</div>
									
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Country<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12"> 
											<select class="form-control" name="country" id="country" required>
												<option value="">Select Country</option>
												@foreach($country as $allcountry)
											  		<option value="{{$allcountry->id}}" {{ ($company->country == $allcountry->id ? 'selected': '') }}>{{$allcountry->countryname}}</option>
												@endforeach
											</select>
										</div>
									</div>
									
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">State<span class="required">*</span>
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<div id='state_loader' style='display: none;position: absolute;'>
												<img src="{{url('/')}}/assets/images/ajax.gif" width='32px' height='32px'>
											</div>
											<select class="form-control" name="state" id="state" required>
												<option value="">Select State</option>
												@foreach($state as $allstate)
													<option value="{{$allstate->id}}" {{ ($company->state == $allstate->id ? 'selected': '') }}>{{$allstate->statename}}</option>
												@endforeach
											</select>
										</div>
									</div>
									
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">City<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div id='city_loader' style='display: none;position: absolute;'>
												<img src="{{url('/')}}/assets/images/ajax.gif" width='32px' height='32px'>
											</div>
											<select class="form-control" name="city" id="city" required>
												<option value="">Select City</option>
												@foreach($city as $allcity)
													<option value="{{$allcity->id}}" {{ ($company->city == $allcity->id ? 'selected': '') }}>{{$allcity->cityname}}</option>
												@endforeach
											</select>
										</div>
									</div>
									
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Pincode<span class="required">*</span>
											
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="pincode" class="form-control col-md-7 col-xs-12" name="pincode" placeholder="Enter pincode" type="text" maxlength="10" minlength="3" onkeypress="return isNumber(event)" value="{{$company->pincode}}">
										</div>
									</div>
									
								  	<div class="item form-group">
			                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
			                            <div class="col-md-6 col-sm-6 col-xs-12">
			                                @if($company->status == 1)
			                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
			                                @elseif($company->status == 0)
			                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
			                                @endif
			                            </div>
		                       		</div>
									
								</div>
							</div>
						</div>	
						
                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-5">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{!! url('sadmin/company') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')

<script type="text/javascript">

$(function() {
              

    $('.multipleSelect').fastselect();
                
});
</script>


<script type="text/javascript">
    function isNumber(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    return true;
	}

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });
	
	$(document).ready(function() {  
	 
	 	$("#country").change(function(){  
				$("#state_loader").show(); 
				$("#state").hide(); 
			$.ajax({  
				url:"{{ URL('sadmin/company/state_list') }}",  
				data: {countryid: $(this).val(),_token : $("input[name=_token]").val()},  
				type: "POST", 
				success:function(data)
				{  
					
					$("#state").show();  
					$("#state").html(data);  
					$("#state_loader").hide();
				}  
		  	});  
	   	});
	 
			 $("#state").change(function(){  
			 	$("#city_loader").show(); 
				$("#city").hide(); 
			 $.ajax({  
				url:"{{ URL('sadmin/company/city_list') }}",  
				data: {stateid: $(this).val(),_token : $("input[name=_token]").val()},  
				type: "POST",  
				success:function(data)
				{  
					$("#city").show();  
					$("#city").html(data);  
					$("#city_loader").hide();
				}  
		  });  
	   });  
	});  

    var id = $('input[name="id"]').val();
	
	$(document).ready(function(){

		$.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param) 
        }, "File must be less than 2MB");

       $("#general_form").validate({
        
	        rules: {
	            comapany_name: {
				   required: true,
				   minlength:3,
				   maxlength:30 
				},		
	            company_phone:
				{
				  	required: true,    
				  	maxlength:15, 
				  	minlength:10, 
				},
	           	company_logo:{
					extension: "jpg|jpeg|png",
					filesize: 2097152
				},
				addressline1:
				{
					required: true,
					minlength:3,
					maxlength:100,

				},
				addressline2:
				{
					minlength:3,
					maxlength:100,
				},
				country: 
			  	{
				  required: true,
				},
				state:
				{
					required: true,
				},
				city:
				{
					required: true,
				},
				planid:
				{
					required: true,
				},
				pincode:
				{
					required: true,
					minlength:5,
					maxlength:10,
				},
	     
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