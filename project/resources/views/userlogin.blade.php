@extends('includes.newmaster')

@section('content')

    <div class="home-wrapper">
        <!-- Starting of login area -->
        <div class="section-padding login-area-wrapper wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="signIn-area">
                            <h2 class="signIn-title">{{trans('app.CustomerSignIn')}}</h2>
                            <hr/>
                            <form action="{{ route('user.login.submit',$subdomain_name) }}" method="POST" id="customer_login">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                    <input class="form-control" value="{{ old('email') }}" type="email" name="email" id="email" minlength="3" maxlength="50">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{trans('app.Password')}} <span>*</span></label>
                                    <input class="form-control" type="password" name="password" id="password" minlength="6" maxlength="12">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <a href="{{route('user.reg',$subdomain_name)}}">{{trans('app.CreateNewAccount')}}</a>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                            <a href="{{route('user.forgotpass',$subdomain_name)}}">{{trans('app.ForgotYourPassword')}}</a>
                                        </div>
                                    </div>
                                </div>
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
                                <div class="form-group">
                                    <input class="btn btn-md login-btn" type="submit" value="{{trans('app.Login')}}">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Ending of login area -->
    </div>
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