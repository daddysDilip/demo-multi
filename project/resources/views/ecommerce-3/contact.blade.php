@extends('ecommerce-3.includes.newmaster')

@section('content')
<main>




    <section id="title">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <h3>Contact Us</h3>
            </div>
            <div class="col-xs-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page" style="color: white">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else Contact Us @endif</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>


    <section id="main_contact">
        <div class="container">
            <div class="col-sm-6">
                <div class="contact_us">
                 <br/> <h2>Contact Us</h2><br/>
                    @if($settings[0]->address != null)
                        <label>Address:</label>
                        <p>{{$settings[0]->address}}</p>
                    @endif

                    @if($settings[0]->phone != null)
                        <label>Phone Number:</label>
                        <p><a href="tel:{{$settings[0]->phone}}">{{$settings[0]->phone}}</a></p>
                    @endif

                    @if($settings[0]->email != null)
                        <label>Email:</label>
                        <p><a href="mailto:{{$settings[0]->email}}">{{$settings[0]->email}}</a></p>
                    @endif
                </div>
            </div>
           <div class="row">
           <div class="col-md-6">
                <div class="keep_touch">
                   <br/> <h2>{{$language->contact_us_today}}</h2><br/>
                      <form action="{{url('contact/email')}}" method="POST" id="contact_form">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control"name="to" value="{{$pagedata->contact_email}}">
                        <!-- Success message -->
                        @if(Session::has('cmail'))
                            <div class="alert alert-success" role="alert" id="success_message">
                                {{ Session::get('cmail') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Your Name">
                        </div>

                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" placeholder="Your Phone">
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Your Email">
                        </div>

                        <div class="form-group">
                            <textarea placeholder="message" class="form-control" id="comment"  rows="5"></textarea>
                        </div>

                        <button type="submit">Send Message</button>
                    </form>
                </div>
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

        $('#contact_form').validate({
            rules:{
                name:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                },
                phone:{
                    required:true,
                    minlength: 10,
                    maxlength: 10,
                    number:true
                },
                email:{
                    required:true,
                    Validemail:true,
                    minlength: 3,
                    maxlength: 50,
                },
                message:{
                    required:true,
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