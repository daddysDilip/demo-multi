@extends('sadmin.frontend.includes.newmaster')
@section('content')


<style type="text/css">
.themeBtn {
    background: #ff3957;
    border-radius: 32px;
    color: #fff;
    display: inline-block;
    font-size: 16px;
    padding: 10px 26px;
    border: 2px solid #ff3957;
    font-weight: 700;
    text-transform: uppercase;
}
a {
    text-decoration: none;
    line-height: inherit;
    outline: none;
    -webkit-transition: 0.5s all ease-in-out;
    -moz-transition: 0.5s all ease-in-out;
    -o-transition: 0.5s all ease-in-out;
    transition: 0.5s all ease-in-out;
}
.post-txt > p {
    color: #555;
    font-size: 17px;
    line-height: 30px;
    padding: 0 0 15px 0;
    letter-spacing: 0.02em;
}
.borderWrap {
    display: inline-block;
    height: 50px;
    width: 100%;
}
.social{
	padding-right: 10px;
	/*border: 1px solid green;*/
	text-align: center;
}
.form-wrap-side {
    margin-top: 50px;
}
.form-widget-side {
    background-color: #28b466;
    padding: 20px 30px 20px;
    text-align: left;
}
.top-section-side {
    padding-bottom: 20px;
}
.top-section-side > h2 {
    color: #ffffff;
    font-size: 30px;
    line-height: 1.2;
    font-weight: bold;
}
.top-section-side > h3 {
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    line-height: 1.2;
}
table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
}
.widget-contact-form-side table td {
    padding-bottom: 15px;
}
.widget-contact-form-side input[type="text"], .widget-contact-form-side input[type="email"], .widget-contact-form-side input[type="phone"], .widget-contact-form-side input[type="search"], .widget-contact-form-side input[type="password"], .widget-contact-form-side textarea, .widget-contact-form-side select, .widget-contact-form-side input[type="number"], .widget-contact-form-side input[type="file"] {
    background-color: #fff;
    border: 1px solid #fff;
    border-radius: 2px;
    height: 40px;
    padding: 0 15px;
    width: 100%;
    color: #000;
    font-size: 1em;
    line-height: 100%;
    outline: none;
    font-family: inherit;
    -webkit-transition: 0.3s all ease-in-out;
    transition: 0.3s all ease-in-out;
}

.widget-contact-form-side input[type="submit"], .widget-contact-form-side input[type="button"] {
    font-size: 1em;
    padding: 0 20px;
    position: relative;
    cursor: pointer;
    height: 44px;
    line-height: 44px;
    color: #fff;
    border-radius: 2px;
    font-weight: 600;
    border: none;
    background-color: #222;
    cursor: pointer;
    margin: 0 0 0;
    width: 100%;
    font-family: inherit;
    -webkit-transition: 0.3s all ease-in-out;
    transition: 0.3s all ease-in-out;
}


</style>
 <section class="part-one bgcolor-white ptb-100" id="contact_us">
    <div class="container">
      <div class="row">
  
            <div class="col-md-8">
              @if(count($blogs) > 0)
            @foreach($blogs as $blog)

        <h2 class="f-weight600 mb-30">{{$blog->title}}</h2>
           
                  @if($blog->featured_image != '')
                    <img src="assets/images/blog/{{$blog->featured_image}}" alt="Blog Image" width="100%">
                  @else

                      <img src="{{url('/')}}/assets/images/placeholder.jpg" alt="Blog Image" width="80%" >
                  @endif
                

                
              <div class="blog_text">
              	<br/>
          <!--       <h3 class="full_width"><a href="">{{$blog->title}}</a></h3> -->
                 <span >{{date('M d, Y',strtotime($blog->created_at))}}</span>
                 
                <!-- <span class="full_width">by John 2 Feb 2018 - Uncategorized</span> -->
                <p class="post-txt">{{ substr(strip_tags($blog->details), 0, 120) }}
                  {{ strlen(strip_tags($blog->details)) > 50 ? "..." : "" }}</p>
                     <div class="off">
                   </div>
                <div class="set_al full_width"><a href="{{url('/')}}/blog/{{$blog->id}}" class="themeBtn">read more</a></div><br/>
                <div >
                  <a href="{{$blog->fackbbok}}" target="_blank" class="social"><i  class="fab fa-facebook-f"></i></a>
                  <a href="{{$blog->twiter}}" target="_blank" class="social"><i style="width:10px;" class="fab fa-twitter"></i></a>
                  <!-- <a href="" target="_blank"><i style="width:10px;" class="fab fa-google-plus-g"></i></a> -->
                  <a href="{{$blog->g_plus}}" target="_blank" class="social"><i style="width:10px;" class="fab fa-linkedin-in"></i></a>
               
                </div>
              </div>
         
        
            <br/>
              @endforeach
          @else
            <h4 class="text-center">No data found.</h4>
          @endif
             </div>


                 <div class="col-md-4" >
       <div class="form-wrap-side">
			<div class="form-widget-side">
				<div class="top-section-side">
					<h2>Start your online store with <span>multivendor eCommerce platform</span></h2>
					<h3>Get a feature rich and ready to launch ecommerce platform</h3>
				</div>
				<div class="bottom-section-side">
					<form method="POST"  id="widget-form" class="widget-contact-form-side"  >
             {{csrf_field()}}
              @if(Session::has('error'))
              <div class="alert alert-danger" role="alert" id="success_message">
                <a  href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('error') }}
              </div>
            @endif
						<table>
						<tbody><tr>
							<td> <input type="text" id="name" name="name" placeholder="Your Name" maxlength="30" minlength="3"></td>
						</tr>
						<tr>
							<td>  <input type="email" id="email" name="email"  placeholder="Your Email Address" maxlength="50" minlength="5"></td>
						</tr>
						<tr>
							<td> <input type="text" name="phone"  placeholder="Your Phone" maxlength="10" minlength="10" onkeypress="return isNumber(event)"></td>
						</tr>
						<tr>
							<td>
							 <textarea  name="message" placeholder="Your Message" rows="10"></textarea>
								
							</td>
						</tr>

            <tr>
              <td>
                  <div id="captchaBackground">
      <!-- <span style="text-align: center;" id="captcha">captcha text</span> -->
      <h4 style="  font-weight: bold; text-align: center;"><span style=" background-color: white;" id="captcha" >captcha text</span></h4>
      <br/>
      <input id="textBox" type="text" name="text" placeholder="Enter captcha Code">
      
        <!-- <input id="submit" type="submit"> -->
    
     <h5 style="font-weight: bold; text-align: center;"> <span id="output"></span></h5>
    </div>
  </td>
            </tr>



            <tr>
              <td>
                <div id="buttons">
        <button id="refresh" type="submit">Refresh</button>

                  <br/>

                  <!-- <input type="submit" id="submit"  name="submit" value="GET FREE CONSULTATION"> -->

                  <button  id="submit"  name="submit" value="GET FREE CONSULTATION" >GET FREE CONSULTATION</button>
		          </div>
          </td>
						</tr>

          
						</tbody></table>
					</form>
					<div id="formMsg"></div>
				</div>
			</div>
        </div>
            </div>

        





 


    	<!-- </div> -->
	  </div>
	</div>
</section>




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
  
  $("#widget-form").validate({
        
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


<script type="text/javascript">

  $(document).ready(function(){


  let captchaText = document.querySelector('#captcha');
let userText = document.querySelector('#textBox');
let submitButton = document.querySelector('#submit');
let output = document.querySelector('#output');
let refreshButton = document.querySelector('#refresh');

let alphaNums = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
let emptyArr = [];
for(let i = 1; i <= 7; i++) {
  emptyArr.push(alphaNums[Math.floor(Math.random() * alphaNums.length)]);
}
captchaText.innerHTML = emptyArr.join('');

userText.addEventListener('keyup', function(e) {
  if(e.keyCode === 13) {
    if(userText.value === captchaText.innerHTML) {
      output.classList.add("greenText");
      output.innerHTML = "Correct!";
       alert('heleleeoeooeoe11111');
    } else {
      output.classList.add("redText");
      output.innerHTML = "Incorrect, please try again";
    }
  }
});

submitButton.addEventListener('click',  function() {
  if(userText.value === captchaText.innerHTML) {
    output.classList.add("greenText");
    output.innerHTML = "Correct!";
    alert('heleleeoeooeoe22222');

    var name=$('#name').val();
    var email=$('#email').val();

    console.log(name,email);

     $(document).ready(function(){

  $.validator.addMethod('Validemail', function (value, element) {
    return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
  }, "Please enter a valid email address.");
  
  $("#widget-form").validate({
        
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
      submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "{{route('cepcher')}}",
                    data: $(form).serialize(),
                    success:function(data){
                        console.log(data);

                },
                    error: function (data) {
                      console.log(data);
                    }        
                });
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

  } else {
    output.classList.add("redText");
    output.innerHTML = "Incorrect, please try again";
  }
});

refreshButton.addEventListener('click', function () {
  userText.value = "";
  let refreshArr = [];
  for(let j = 1; j <= 7; j++) {
    refreshArr.push(alphaNums[Math.floor(Math.random() * alphaNums.length)]);
  }
  captchaText.innerHTML = refreshArr.join('');
  output.innerHTML = "";
});

submitButton.addEventListener('keyup', function(e) {
  if(e.keyCode === 13) {
  if(userText.value === captchaText.innerHTML) {



    console.log("correct!");
    output.classList.add("greenText");

    output.innerHTML = "Correct!";




  } else {
    output.classList.add("redText");
    output.innerHTML = "Incorrect, please try again";
  }
  }
});
});
</script>
@stop