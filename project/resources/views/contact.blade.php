@extends('includes.newmaster')

@section('content')

<style type="text/css">
    textarea
    {
        resize: none;
    }
    .comments-form input, .comments-form textarea
    {
        margin-bottom: 0px;
    }
</style>

    <section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
        <div class="row" style="background-color:rgba(0,0,0,0.7);">

            <div style="margin: 3% 0px 3% 0px;">
                <div class="text-center" style="color: #FFF;padding: 20px;">
                    <h1>@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else Contact Us @endif</h1>
                </div>
            </div>

        </div>
    </section>

    <div class="home-wrapper">
        <!-- Starting of contact us area -->
        <div class="section-padding contact-area-wrapper wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-sm-7">
                        <div class="contact-area-fullDiv">
                            <p>{{trans('app.ContactUsToday')}}!</p>
                            <div class="comments-area">
                                <div class="comments-form">
                                    <form action="{{url('contact/email')}}" method="POST" id="contact_form">
                                        {{csrf_field()}}
                                        <input type="hidden" name="to" value="{{$pagedata->contact_email}}">
                                        <!-- Success message -->
                                        @if(Session::has('cmail'))
                                            <div class="alert alert-success" role="alert" id="success_message">
                                                {{ Session::get('cmail') }}
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input name="name" type="text" placeholder="{{trans('app.YourName')}}" maxlength="50" minlength="3">
                                            </div>
                                            <div class="col-md-6">
                                                <input name="phone" type="tel" placeholder="{{trans('app.YourPhone')}}" maxlength="10" minlength="10" onkeypress="return isNumber(event)" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input name="email" type="email" placeholder="{{trans('app.YourEmail')}}" maxlength="50" minlength="3">
                                            </div>
                                        </div>
                                        <p><textarea name="message" id="comment" placeholder="{{trans('app.WriteReply')}}" cols="30" rows="10" maxlength="255" minlength="3"></textarea></p>
                                        <input name="contact_btn" type="submit" value="{{trans('app.SendMessage')}}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <div class="contact-info-div">
                            @if($settings[0]->address != null)
                            <p class="contact-info">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                {{$settings[0]->address}}
                            </p>
                            @endif
                            @if($settings[0]->phone != null)
                                <p class="contact-info">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    {{trans('app.PhoneNumber')}} :  <a href="tel:{{$settings[0]->phone}}">{{$settings[0]->phone}}</a><br/>
                                </p>
                            @endif
                            @if($settings[0]->email != null)
                            <p class="contact-info">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                {{trans('app.EmailAddress')}} :  <a href="mailto:{{$settings[0]->email}}">{{$settings[0]->email}}</a>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ending of contact us area -->
    </div>

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
        }, ValidEmailError);

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