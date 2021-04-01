@extends('sadmin.includes.master-sadmin2')

@section('content')

        <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Company</h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/company') !!}">Company</a></li>
                    <li class="breadcrumb-item active">Manage Company</li>
                </ul>
            </div>
        </div>
    </div>
    </div>
        <div class="container-fluid">

            <!-- <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize"><h3>Company</h3></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/company') !!}">Company</a></li>
                    <li class="breadcrumb-item">Manage Company</li>
                </ul>
            </div> -->

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
                    </div>

                    
					<div class="col-xs-12">
                    	<div class="ln_solid"></div>
							
               			<form method="POST" action="{!! action('Sadmin\CompanyController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="general_form">

                    		{{csrf_field()}}

                    		<input type="hidden" name="domainname" value="{{get_subdomain()}}">

							<div class="col-md-6 col-lg-6">
								<div class="card">
				                    <div class="header">
				                        <h2><strong>General</strong> <small> Information</small> </h2>                        
				                    </div>
				                    <div class="body">                                
										<div class="prtm-block min-height-505">
											<div class="form-horizontal">

												
                                            <div class="row clearfix">
                                            	<div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
				                                    <label for="email_address_2">Company Name<span class="required">*</span></label>
				                                </div>
				                                <div class="col-lg-9 col-md-9 col-sm-8">
				                                    <div class="form-group">
				                                        <input id="comapany_name" class="form-control" name="comapany_name" placeholder="Enter Company Name" type="text" maxlength="30" minlength="3">
				                                    </div>
				                                </div>
												
											</div>

												<div class=" form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User Name<span class="required">*</span></label>

													<div class="col-md-6 col-sm-6 col-xs-12">
														<input id="username" class="form-control col-md-7 col-xs-12" name="username" placeholder="Enter User Name" type="text" maxlength="30" minlength="3" style="text-transform: lowercase;">
													</div>
												</div>

												<div class=" form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email Adress<span class="required">*</span></label>

													<div class="col-md-6 col-sm-6 col-xs-12">
														<input id="company_email" class="form-control col-md-7 col-xs-12" name="company_email" placeholder="Enter Email Address" type="email" maxlength="50" minlength="3">
													</div>
												</div>

												<div class=" form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Phone Number<span class="required">*</span></label>

													<div class="col-md-6 col-sm-6 col-xs-12">
														<input id="company_phone" class="form-control col-md-7 col-xs-12" name="company_phone" placeholder="Enter Phone Number" type="text" maxlength="15" minlength="10" onkeypress="return isNumber(event)" >
													</div>
												</div>

												<div class=" form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Select Plan<span class="required">*</span></label>

													<div class="col-md-6 col-sm-6 col-xs-12">
														<select class="form-control" name="planid" id="planid" required>
															<option value="">Select Plan</option>
															@foreach($plans as $allplan)
																<option value="{{$allplan->id}}">{{$allplan->plantype}}</option>
															@endforeach
														</select>
													</div>
												</div>

												<div class="item form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Select Language<span class="required">*</span></label>

													<div class="col-md-6 col-sm-6 col-xs-12">
														<select class="form-control multipleSelect" multiple name="language[]" id="language" required>
															<option value="">Select Language</option>
															@foreach($languages as $alllanguage)
																<option value="{{$alllanguage->code}}">{{$alllanguage->name}}</option>
															@endforeach
														</select>
													</div>
												</div>

												<!-- <input type="hidden" name="id" value="1"> -->

			                                    <div class="item form-group">
			                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Company Logo <span class="required">*</span> </label>

			                                        <div class="col-md-6 col-sm-6 col-xs-12">
			                                            <input type="file" id="company_logo" name="company_logo" accept="image/*" />
			                                        </div>
			                                    </div>
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
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Address Line 1<span class="required">*</span></label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="addressline1" class="form-control col-md-7 col-xs-12" name="addressline1" placeholder="Enter Address Line 1" type="text" maxlength="100" minlength="3" >

											</div>
										</div>

										<div class="item form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Address Line 2</label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="addressline2" class="form-control col-md-7 col-xs-12" name="addressline2" placeholder="Enter Address Line 2" type="text" maxlength="100" minlength="3" >
											</div>
										</div>

										<div class="item form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Country<span class="required">*</span></label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<select class="form-control" name="country" id="country" required>
													<option value="">Select Country</option>
													@foreach($country as $allcountry)
														<option value="{{$allcountry->id}}">{{$allcountry->countryname}}</option>
													@endforeach
												</select>
											</div>
										</div>

										<div class="item form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">State<span class="required">*</span></label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<div id='state_loader' style='display: none;position: absolute;'>
													<img src='{{url('/')}}/assets/images/ajax.gif' width='32px' height='32px'>
												</div>

												<select class="form-control" name="state" id="state" required>
													<option value="">Select State</option>
												</select>
											</div>
										</div>

										<div class="item form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">City<span class="required">*</span></label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<div id='city_loader' style='display: none;position: absolute;'>
													<img src='{{url('/')}}/assets/images/ajax.gif' width='32px' height='32px'>
												</div>

												<select class="form-control" name="city" id="city" required>
													<option value="">Select City</option>
												</select>
											</div>
										</div>

										<div class="item form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Pincode<span class="required">*</span></label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="pincode" class="form-control col-md-7 col-xs-12" name="pincode" placeholder="Enter pincode" type="text" maxlength="10" minlength="3" onkeypress="return isNumber(event)">
											</div>
										</div>




										<div class="item form-group">
				                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>

				                            <div class="col-md-6 col-sm-6 col-xs-12">
				                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
				                            </div>
				                        </div>
									</div>
								</div>
							</div>

                            <div class="ln_solid"></div>

                            <div class="form-group">

                                <div class="col-md-6 col-md-offset-5">
                                    <button type="submit" class="btn btn-success">Submit</i></button>
									<a href="{!! url('sadmin/company') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
                                </div>

                            </div>

                        </form>

                    </div>

				</div>

			</div>
    	</div>
    	<!-- /.container-fluid -->
    

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

    $(document).ready(function(){

    	$.validator.addMethod('Validemail', function (value, element) {
            return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
        }, "Please enter a valid email address.");

    	jQuery.validator.addMethod("noSpace", function(value, element) { 
		  return value.indexOf(" ") < 0 && value != ""; 
		}, "Space not allowed");

		$.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param) 
        }, "File must be less than 2MB");

		$.validator.addMethod("CheckDomainName", function(value, element) {
	     	var isSuccess = false;
			  
		 	$.ajax({ url: "{{ URL('sadmin/company/checkdomainname') }}", 
		 		type: "POST",
            	data: {
            		username: function () 
                    {
                        return $("input[name='username']").val();
                    },
                    domian: function ()
                    {
                    	return $("input[name='domainname']").val();
                    },
                    "_token": "{{ csrf_token() }}"  
                }, 
            	async: false, 
            	success:  function(msg) 
            	{ 
            		if(msg == true)
            		{
            			isSuccess = true;
            		}
            		else
            		{
            			isSuccess = false;
            		}
            	}
          	});
	   		return isSuccess;
		});

       	$("#general_form").validate({

	        rules: {
	            comapany_name: {
				   	required: true,
				   	minlength:3,
				   	maxlength:30 
				},

			 	username:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                    noSpace: true,
					remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/company/existusernametitle') }}",
                        async: false,
                        async:false,
                        data: {
                            username: function () 
                            {
                                return $("input[name='username']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },
                        async:false
                    },
                    CheckDomainName: true,

                } ,

	            company_email: {
	                required: true,
	                Validemail: true,
                    maxlength: 50,
					remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/company/existemail') }}",
                        async: false,
                        async:false,
                        data: {
                            company_email: function () 
                            {
                                return $("input[name='company_email']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },
                        async:false
                    }
	            },				
	            company_phone:
				{
				  	required: true,    
				  	maxlength:15, 
				  	minlength:10, 
				},
	            company_logo:{
	            	required: true,
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
	        messages: {
	            username: {
	            	remote: "Already exist",
	            	CheckDomainName: "You can not domain name as username. Please choose another."
	            }, 
	            company_email: {
	            	remote: "Already exist",
	            },
	        },
			highlight: function (element) 
			{
	            $(element).parent().addClass('has-error')
	        },
	        unhighlight: function (element) 
	        {
	            $(element).parent().removeClass('has-error')
	        },
	        errorElement: 'span',
	        errorClass: 'text-danger',   
    	}); 
    });

</script>

@stop