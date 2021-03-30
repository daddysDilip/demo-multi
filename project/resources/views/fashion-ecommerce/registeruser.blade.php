@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
          <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{trans('app.Registration')}}</div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
              <li class="breadcrumb-item active text-capitalize" aria-current="page">{{trans('app.Registration')}}</li>
            </ol>
          </nav>
        </div>
    </section>
     
    <section class="login">
        <div class="container">
            <div class="row wrapper">
                <div class="col">
                    <form action="{{route('user.reg.submit',$subdomain_name)}}" method="POST" id="form_customer">
                        {{ csrf_field() }}
                        <div id="resp">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>* {{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>* {{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>* {{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="reg_name">{{trans('app.FirstName')}} <span>*</span></label>
                                <input class="form-control" type="text" name="firstname" id="firstname" maxlength="30" minlength="3">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="reg_name">{{trans('app.LastName')}} <span>*</span></label>
                                <input class="form-control" type="text" name="lastname" id="lastname" maxlength="30" minlength="3">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="reg_email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                <input class="form-control" type="text" name="email" id="reg_email" maxlength="50" minlength="3">
                            </div>
                       
                            <div class="form-group col-md-12">
                                <label for="reg_Pnumber">{{trans('app.PhoneNumber')}} <span>*</span></label>
                                <input class="form-control" type="text" name="phone" id="reg_Pnumber" maxlength="10" minlength="10" onkeypress="return isNumber(event)" >
                            </div>
                            <div class="form-group col-md-12">
                                <label for="reg_password">{{trans('app.Password')}} <span>*</span></label>
                                <input class="form-control" type="password" name="password" id="reg_password">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="confirm_password">{{trans('app.ConfirmPassword')}} <span>*</span></label>
                                <input class="form-control" type="password" name="password_confirmation" id="confirm_password">
                            </div>
                            <div class="footer_link col-md-12">
                                <label class="registration"><a href="{{url('user/login')}}">{{trans('app.AlreadyAccount')}}</a></label>
                            </div>
                            <button class="checkout add-cart text-uppercase">{{trans('app.SignUp')}}</button>
                        </div>
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
    }, ValidEmailError);

    $('#form_customer').validate({
        rules:{
            email:{
                required: true,
                Validemail: true,
                minlength: 3,
                maxlength: 50,
                remote: {
                    type: 'post',
                    url: "{{ URL('user/exist_email') }}",
                    async: false,
                    async:false,
                    data: {
                        email: function () 
                        {
                            return $("input[name='email']").val();
                        },
                        "_token": "{{ csrf_token() }}"  
                    },

                    async:false
                }
            },
            firstname:{
                required:true,
                minlength: 3,
                maxlength: 30,
            },
            lastname:{
                required:true,
                minlength: 3,
                maxlength: 30,
            },
            phone:{
                required:true,
                number:true,
                maxlength:10,
                minlength:10
            },
            password:{
                required:true,
                maxlength:12,
                minlength:6
            },
            password_confirmation:{
                equalTo:"#reg_password",
                required:true,
            }
        },
        messages:{
            email:{
                remote: AlreadyExist,
            },
            password_confirmation:{
                equalTo: PasswordNoMatch
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