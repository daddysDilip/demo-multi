@extends('ecommerce-4.includes.newmaster')

@section('content')
<main>

    <section id="inner_banner" style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;background-color: #2278b8;">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{trans('app.Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else Contact Us @endif</li>
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
                  <h2>{{trans('app.ContactUs')}}</h2>
                    @if($settings[0]->address != null)
                        <label>{{trans('app.Address')}}:</label>
                        <p>{{$settings[0]->address}}</p>
                    @endif

                    @if($settings[0]->phone != null)
                        <label>{{trans('app.PhoneNumber')}}:</label>
                        <p><a href="tel:{{$settings[0]->phone}}">{{$settings[0]->phone}}</a></p>
                    @endif

                    @if($settings[0]->email != null)
                        <label>{{trans('app.EmailAddress')}}:</label>
                        <p><a href="mailto:{{$settings[0]->email}}">{{$settings[0]->email}}</a></p>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="keep_touch">
                    <h2>{{trans('app.ContactUsToday')}}!</h2>
                    <form action="{{url('contact/email')}}" method="POST" id="contact_form">
                        {{csrf_field()}}
                        <input type="hidden" name="to" value="{{$pagedata->contact_email}}">
                        <!-- Success message -->
                        @if(Session::has('cmail'))
                            <div class="alert alert-success" role="alert" id="success_message">
                                {{ Session::get('cmail') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <input type="text" name="name" placeholder="{{trans('app.YourName')}}">
                        </div>

                        <div class="form-group">
                            <input type="text" name="phone" placeholder="{{trans('app.YourPhone')}}">
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" placeholder="{{trans('app.YourEmail')}}">
                        </div>

                        <div class="form-group">
                            <textarea placeholder="{{trans('app.WriteReply')}}" id="comment"  rows="5"></textarea>
                        </div>

                        <button type="submit">{{trans('app.SendMessage')}}</button>
                    </form>
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