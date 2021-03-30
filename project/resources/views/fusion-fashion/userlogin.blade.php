@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">{{trans('app.SignIn')}}</li>
          </ol>
        </div>
    </nav>

    <section class="sign-inwrap">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-box">
                        <h2>{{trans('app.SignIn')}}</h2>
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

                            <div class="form-group">
                                <label>{{trans('app.EmailAddress')}}</label>
                                <input type="email" name="email" class="form-control" placeholder="" value="{{ old('email') }}" minlength="3" maxlength="50">
                            </div>

                            <div class="form-group">
                                <label>{{trans('app.Password')}}</label>
                                <input type="password" class="form-control" placeholder="" name="password"  minlength="6" maxlength="12">
                            </div>

                            <div class="checkbox">
                                <label></label>
                                <label class="forget"><a href="{{route('user.forgotpass',$subdomain_name)}}">{{trans('app.ForgotYourPassword')}}</a></label>
                            </div>

                            <button type="submit" class="btn btn-default">{{trans('app.Submit')}}</button>
                        </form>

                        <p class="hr-login"><span>{{trans('app.Or')}}</span></p>
                        <a class="btn btn-default green" href="{{route('user.reg',$subdomain_name)}}">{{trans('app.CreateanAccount')}}/a>
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