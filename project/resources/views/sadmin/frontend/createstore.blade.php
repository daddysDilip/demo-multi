@extends('sadmin.frontend.includes.newmaster')
@section('content')

<main>
	<section class="part-one bgcolor-white ptb-100">
  		<div class="wrapper booking-template-section">
			<div class="container">
      			<div class="row pb-100">
    				<div class="col-md-12">
						<div class="signup-form-section">

							<div id="loadingIcon">
						    	<img src="{{ URL::asset('assets/images/loading.gif')}}"/>
							</div>

 							<form id="signup-store-form" method="POST" action="{{url('store/register')}}" style="display: none;">

								<h3></h3>

								<section class="booking_template_box">
									<div class="container">

										<div class="row justify-content-md-center">
									  		<div class="booking_content col-md-8">

									  			<div class="booking-title">
									  				<h4 class="step_section_title">General Information</h4><hr>
									  			</div>

												<div class="check_avail_content">
													<div class="container">
					      								<input type="hidden" name="domainname" value="{{get_subdomain()}}">

							          					<div class="form-group">
															<label class="control-label col-sm-12" for="email">Store Name*</label>
															<div class="col-sm-8">
														  		<input type="text" class="form-control"  required name="username" id="store-name" maxlength="30" minlength="3">
															</div>
													  	</div>

									   					{{csrf_field()}}

													    <div class="form-group">
															<label class="control-label col-sm-12" for="email">Email Address*</label>
															<div class="col-sm-8">
														  		<input type="email" class="form-control" required name="company_email" id="company_email" maxlength="50" minlength="3">
															</div>
													  	</div>
													  
													  	<div class="form-group">
															<label class="control-label col-sm-12" for="email">Phone Number*</label>
															<div class="col-sm-8">
														  		<input type="text" class="form-control" required name="company_phone" id="company_phone" maxlength="15" minlength="10" onkeypress="return isNumber(event)">
															</div>
													 	</div>
													  
													    <div class="form-group">
															<label class="control-label col-sm-12" for="password">Password*</label>
															<div class="col-sm-8">
														  		<input type="password" class="form-control" name="password" id="password" maxlength="12" minlength="6">
															</div>
													    </div>
													  
													    <div class="form-group">
															<label class="control-label col-sm-12" for="email">Confirm Password</label>
															<div class="col-sm-8">
														  		<input type="password" class="form-control" name="confirm" id="confirm-2" >
															</div>
													  	</div>
													</div>
							    				</div>
							     			</div>
							     		</div>
							     	</div>
							    </section>

								<h3></h3>

								<section class="booking_template_box">
								  	<div class="container">
										<div class="row justify-content-md-center">
									  		<div class="booking_content col-md-8">
									  			<div class="booking-title">
									  				<h4 class="step_section_title">Address Information</h4><hr>
									  			</div>
												<div class="check_avail_content">
													<div class="container">
							        
											          	<div class="form-group">
															<label class="control-label col-sm-12" for="address1">Address Line 1*</label>
															<div class="col-sm-8">
														  		<input type="text" class="form-control" required name="addressline1" id="addressline1" maxlength="100" minlength="3">
															</div>
													  	</div>
													   
													  	<div class="form-group">
															<label class="control-label col-sm-12" for="address1">Address Line 2</label>
															<div class="col-sm-8">
														  		<input type="text" class="form-control" name="addressline2" id="addressline2" maxlength="100" minlength="3">
															</div>
													  	</div>
													  
													   	<div class="form-group">
															<label class="control-label col-sm-12" for="password">Country*</label>
															<div class="col-sm-8">
														  		<select class="form-control" name="country" id="country" required>
																	<option value="">Select Country</option>
																	@foreach($country as $allcountry)
																		<option value="{{$allcountry->id}}">{{$allcountry->countryname}}</option>
																	@endforeach
																</select>
															</div>
													  	</div>
													  
													  	<div class="form-group">
															<label class="control-label col-sm-12" for="password">State*</label>
															<div class="col-sm-8">
														  		<div id='state_loader' style='display: none;position: absolute;'>
																	<img src='{{url('/')}}/assets/images/ajax.gif' width='32px' height='32px'>
																</div>
																<select class="form-control" name="state" id="state" required>
																	<option value="">Select State</option>
																</select>
															</div>
													  	</div>
													  
													  	<div class="form-group">
															<label class="control-label col-sm-12" for="password">City*</label>
															<div class="col-sm-8">
														  		<div id='city_loader' style='display: none;position: absolute;'>
																	<img src='{{url('/')}}/assets/images/ajax.gif' width='32px' height='32px'>
														 		</div>
																<select class="form-control" name="city" id="city" required>
																	<option value="">Select City</option>
																</select>
															</div>
													  	</div>
									  
													  	<div class="form-group">
															<label class="control-label col-sm-12" for="address1">Pincode*</label>
															<div class="col-sm-8">
														  		<input type="text" class="form-control" required name="pincode" id="pincode" maxlength="10" minlength="3" onkeypress="return isNumber(event)">
															</div>
													  	</div>
													  
													</div>
											    </div>
											</div>
										</div>
									</div>
							    </section> 

							    <h3></h3>

								<section class="booking_template_box">
								  	<div class="container">
									 	<div class="booking_content">
									  		<div class="booking-title"><h4 class="step_section_title">Overview</h4><hr></div>
											<div class="check_avail_content">
												<div class="container">
													<div class="booking-summary-container">
							             				<h4><strong><span id="storename"></span></strong></h4>
							            				<div id="emailid"></div>
											            <div id="phonenumber"></div>
											            <div id="basic-info"></div>
											            <br>
							           					<div class="cost-breakdown-table">
										 					<div class="table-wrapper">
																<table class="cost-breakdown" style="margin-bottom: 14px;font-size: 90%;border: 1px solid #e0e0e0; width: 100%;">
																  	<thead>
																		<tr><th style="background-color: #e0e0e0; padding: 15px 10px; font-weight: bold; text-align: left;">Plan</th>
																		<th style="background-color: #e0e0e0; padding: 15px 10px; font-weight: bold; text-align: left;">month</th>
																		<th style="background-color: #e0e0e0; padding: 15px 10px; text-align: right; font-weight: bold;">Cost</th>
																		<th style="background-color: #e0e0e0; padding: 15px 10px; text-align: right; font-weight: bold;">Total</th>
																	  </tr>
																	</thead>
																  	<tbody id="selected_plan">
																	 
																  	</tbody>
																</table>
															</div>
														</div>
							            				<br>
							            			</div>
										
										 		</div>
										 	</div>
							     		</div>
							     
							     	</div>
							    </section> 

							    <h3></h3>

								<section class="booking_template_box">
								<div id="overlay" class="loader_store">	<span class="loader-custom"><img src="{{url('/')}}/assets/superadmin/ajax-loader.gif">  <div>Processing.......</div></span> </div>
								
								 	<div class="container">
									 	<div class="booking_content">
										<div class="booking-title"><h4 class="step_section_title">Done</h4><hr></div>
											<div class="check_avail_content">
												<div class="container">
													<div class="booking-summary-container">
													
													
										 <div id="payment" class="checkout-payment">
						        	<ul class="payment_methods methods">
						        		<li class="payment_method_razorpay">
						        			<input id="payment_method_razorpay" type="radio" checked="checked" class="input-radio" name="payment_method" value="razorpay" data-order_button_text="">
						        			<label for="payment_method_razorpay">Credit Card/Debit Card/NetBanking </label>
									      <p>Pay securely by Credit or Debit card or Internet Banking through Razorpay.</p>
						        		</li>
										</ul>
										</div>
										</div>
										</div>
										</div>
							     		</div>
							     		</div>
							     	
							    </section> 
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

    
@stop

@section('footer')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">

function isNumber(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    return true;
	}


$(document).ready(function() {  

	$.validator.addMethod('Validemail', function (value, element) {
        return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
    }, "Please enter a valid email address.");

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	}, "Space not allowed");

	$.validator.addMethod("CheckDomainName", function(value, element) {
     	var isSuccess = false;
		  
	 	$.ajax({ url: "{{ URL('store/checkdomainname') }}", 
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
 
	$("#country").change(function(){  
	$("#state_loader").show(); 
	$("#state").hide(); 
	$.ajax({  
		url:"{{ URL('store/state_list') }}",  
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
		url:"{{ URL('store/city_list') }}",  
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

jQuery.ajax({
	url: "{{ URL('store/get_plan') }}",
	type: 'POST',
	data: {planid: getCookie('planid'), plantype: getCookie('plantype'),_token : $("input[name=_token]").val()},
	success:function(response)
	{
		//onsole.log(response);
		$("#selected_plan").html(response); 
    }
});
						
}); 


var form = $("#signup-store-form").show();
	$('#loadingIcon').hide();
	//  $('#signup-store-form').show();
form.steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
	loadingTemplate: '<span class="spinner"></span> #text#',
	transitionEffect: $.fn.steps.transitionEffect.none,
    transitionEffectSpeed: 200,
    onStepChanging: function (event, currentIndex, newIndex)
    {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex)
        {
            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 && Number($("#age-2").val()) < 18)
        {
            return false;
        }
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex)
        {
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex)
    {
        // Used to skip the "Warning" step if the user is old enough.
        if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
        {
            form.steps("next");
        }
        // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2)
        {
			var storename= $('#store-name').val();
			var company_email= $('#company_email').val();
			var company_phone= $('#company_phone').val();
			var addressline1= $('#addressline1').val();
			var addressline2= $('#addressline2').val();
			
			$('#storename').html(storename);
			$('#emailid').html(company_email);
			$('#phonenumber').html(company_phone);
			$('#basic-info').html(addressline1+' '+addressline2);
           
        }
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
       // alert("Submitted!");
	   
	   //console.log(jQuery('input[name="payment_method"]').val());
	   var payment_method= $("input[name='payment_method']:checked").val();
	   var total_amount= $("input[name='total_amount']").val();
	   var formdata= $('#signup-store-form').serialize();
	   jQuery.ajax({
			url: "{{ URL('store/temp_register') }}",
			type: 'POST',
			data: formdata,
			success:function(response)
			{
				console.log(response); //location.href= response+'/admin/login';
				//alert(response.result.amount);
				var options = {
				key: "{{ env('RAZORPAY_KEY') }}",
				amount: response.result.amount,
				name: response.result.name,
				description: response.result.description,
				image: response.result.image,
				prefill: {
				  name: response.result.name,
				  email: response.result.email,
				  contact: response.result.phone,
				},
				notes: {
		      soolegal_order_id: response.result.merchant_id,
		    },
			handler: demoSuccessHandler

			}
			window.r = new Razorpay(options);
			r.open()
		    }
		});

 /*
if(payment_method == 'razorpay'){
	
	   window.r = new Razorpay(options);
   
        r.open()
    
} */
console.log(payment_method);
		console.log($('#signup-store-form').serialize());
		
		
		
		/**/
    }
}).validate({
    errorPlacement: function errorPlacement(error, element) { element.after(error); },
    rules: {
		username:{
			required:true,
            noSpace: true,
			minlength: 3,
			maxlength: 30,
			remote: {
				type: 'post',
				url: "{{ URL('store/existstorename') }}",
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
	        },
			company_email: {
				required: true,
				Validemail: true,
                maxlength: 50,
				remote: {
					type: 'post',
					url: "{{ URL('store/existemail') }}",
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
			password: {
				required: true,
                minlength: 6,
                maxlength: 12,
			},
	        confirm: {
	            equalTo: "#password"
	        },
		    company_phone:
			{
			  	required: true,    
			  	maxlength:15, 
			  	minlength:10, 
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
			pincode:
			{
				required: true,
				minlength:5,
				maxlength:10,
			}  
	    },
		messages: {
			username: {
				remote: "Store name already exist. Please choose another.",
				CheckDomainName: "You can not domain name as store name. Please choose another."
			}, 
			company_email: {
				remote: "Email address  already exist.",
			},
	        },
			highlight: function (element) {
	            $(element).parent().addClass('has-error')
	        },
	        unhighlight: function (element) {
	            $(element).parent().removeClass('has-error')
	        },
	        errorElement: 'span',
	        errorClass: 'invalid-feedback'
		});
		
 function demoSuccessHandler(transaction) {
        // You can write success code here. If you want to store some data in database.
      
     jQuery(".loader_store").show();
        jQuery.ajax({
            method: 'post',
            url: "{!!route('dopayment')!!}",
            data: {
                "_token": "{{ csrf_token() }}",
                "razorpay_payment_id": transaction.razorpay_payment_id
            },
           success:function(data)
			{  
				console.log(data);
				if(data.result.status  == 'ok'){
					var transection_id = data.result.transection_id;
					
					jQuery.ajax({
					url: "{{ URL('store/register') }}",
					type: 'POST',
					data: { "_token": "{{ csrf_token() }}", transection_id: transection_id},
					success:function(response)
					{
						 jQuery(".loader_store").hide();
						console.log(response);
						location.href= response+'/admin/login';
						
					}
					 });
					
				}
			}  
        })
    }

</script>


@stop