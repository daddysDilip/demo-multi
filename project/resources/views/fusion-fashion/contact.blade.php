@extends('fusion-fashion.includes.newmaster')

@section('content')

<style type="text/css">
    textarea
    {
        resize: none;
    }
</style>

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">@if(count($pagetitle) > 0){{$pagetitle[0]->title}}  @else Contact Us @endif</li>
          </ol>
        </div>
    </nav>

    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-5">
                    <div class="contact-info-div">
                        @if($settings[0]->address != null)
                        <div class="contact-info">
                            <p><i class="fa fa-map-marker-alt" aria-hidden="true"></i></p>
                            <p class="contact_text">{{$settings[0]->address}}</p>
                        </div>
                        @endif

                        @if($settings[0]->phone != null)
                        <div class="contact-info">
                            <p><i class="fa fa-phone" aria-hidden="true"></i></p>
                            <a href="tel:{{$settings[0]->phone}}" class="contact_text">{{$settings[0]->phone}}</a><br/>
                        </div>
                        @endif

                        @if($settings[0]->email != null)
                        <div class="contact-info">
                            <p><i class="fa fa-envelope" aria-hidden="true"></i></p>
                            <a href="mailto:{{$settings[0]->email}}" class="contact_text">{{$settings[0]->email}}</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-7 col-sm-7">
                    <div class="contact-area-fullDiv">
                        <h3 class="text-center">{{trans('app.ContactUsToday')}}</h3>
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
                                    
                                    <div class="form-group col-md-6">
                                        <input name="name" type="text" class="form-control" placeholder="{{trans('app.YourName')}}" maxlength="50" minlength="3">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input name="phone" type="text" class="form-control" placeholder="{{trans('app.YourPhone')}}" maxlength="10" minlength="10" onkeypress="return isNumber(event)" >
                                    </div>
                                
                                    <div class="form-group col-md-12">
                                        <input name="email" type="email" class="form-control" placeholder="{{trans('app.YourEmail')}}" maxlength="50" minlength="3">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <p><textarea name="message" id="comment" class="form-control" placeholder="{{trans('app.WriteReply')}}" cols="30" rows="10" maxlength="255" minlength="3"></textarea></p>
                                        <input name="contact_btn" type="submit" value="{{trans('app.SendMessage')}}" class="btn contact_btn">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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