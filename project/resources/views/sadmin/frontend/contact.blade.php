@extends('sadmin.frontend.includes.newmaster')
@section('content')

<style type="text/css">
  textarea
  {
    resize: none;
  }
</style>
<main>

  <section class="part-one bgcolor-white ptb-100" id="contact_us">
    <div class="container">
      <div class="row">
        <div class="col">
        <h2 class="text-center f-weight600 mb-30">Got a Question?</h2>

          <form action="{{url('contactus/email')}}" method="POST" id="contact_form">
            {{csrf_field()}}
            @if(Session::has('error'))
              <div class="alert alert-danger" role="alert" id="success_message">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('error') }}
              </div>
            @endif
            @if(Session::has('success'))
              <div class="alert alert-success" role="alert" id="success_message">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('success') }}
              </div>
            @endif
            <div class="row">
              <div class="form-group col-md">
                <input type="text" name="name" class="form-control" placeholder="Your Name" maxlength="30" minlength="3">
              </div>
              <div class="form-group col-md">
                <input type="text" name="phone" class="form-control" placeholder="Your Phone" maxlength="10" minlength="10" onkeypress="return isNumber(event)">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md">
                <input type="email" name="email" class="form-control" placeholder="Your Email Address" maxlength="50" minlength="5">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md">
                <textarea class="form-control" name="message" placeholder="Your Message" rows="10"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md">
                <input type="submit" name="submit" value="Send">
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>

  <section class="contact_bottom_sec text-white">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1 class="f-24 text-center mb-15 f-weight600">Convert Store into eStore</h1>
          <p class="text-center">Your can convert your eCommerce Store into full fledged Multi Vendor eStore. eStoreWhiz is available for popular eCommerce Platforms.</p>
        </div>
      </div>
    </div>
  </section>
  
</main>


@stop

@section('footer')

<script type="text/javascript">

$(':input').change(function() {
  $(this).val($(this).val().trim());
});

function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
  }
  return true;
}   

$(document).ready(function(){

  $.validator.addMethod('Validemail', function (value, element) {
    return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
  }, "Please enter a valid email address.");
  
  $("#contact_form").validate({
        
	  rules: {
	    name: {
        required:true,
        minlength: 3,
        maxlength: 30,
      },
      phone: {
        required:true,
        minlength: 10,
        maxlength: 100,
      },
      email: {
        required:true,
        Validemail: true,
        minlength: 5,
        maxlength: 50,
      },
    },
		highlight: function (element) {
      $(element).parent().addClass('has-error')
    },
    unhighlight: function (element) {
        $(element).parent().removeClass('has-error')
    },
    errorElement: 'span',
    errorClass: 'invalid-feedback',
				
  }); 
		  
});
 

</script>

@stop