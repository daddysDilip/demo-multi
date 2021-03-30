@extends('ecommerce-4.includes.newmaster')

@section('content')

<main>
   
    <section id="signup">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="login_box">
                        <h3>{{trans('app.Login')}}</h3>
                        <form action="{{ route('user.login.submit',$subdomain_name) }}" method="POST" id="customer_login">
                            {{ csrf_field() }}
                            <div id="resp">
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>{{trans('app.EmailAddress')}}</label>
                                    <input type="email" name="email" class="form-control" placeholder="" value="{{ old('email') }}" minlength="3" maxlength="50">
                                </div>
                                <div class="form-group">
                                    <label>{{trans('app.Password')}}</label>
                                    <input type="password" class="form-control" placeholder="" name="password"  minlength="6" maxlength="12">
                                </div>
                                <div class="footer_link">
                                    <label class="registration"><a href="{{route('user.reg',$subdomain_name)}}">{{trans('app.CreateNewAccount')}}</a></label>
                                    <label class="forget"><a href="{{route('user.forgotpass',$subdomain_name)}}">{{trans('app.ForgotYourPassword')}}</a></label>
                                </div>
                                <button class="btn btn-info">{{trans('app.Login')}}</button>
                            </div>
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

    $(document).ready(function(){

        $.validator.addMethod('Validemail', function (value, element) {
            return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
        }, ValidEmailError);

        $('#customer_login').validate({
            rules:{
                email:{
                    required:true,
                    Validemail: true,
                    minlength: 3,
                    maxlength: 50,
                },
                password:{
                    required:true,
                    maxlength:12,
                    minlength:6
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