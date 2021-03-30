@extends('ecommerce-3.includes.newmaster')

@section('content')
    <main>
      <section id="title">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <h3>Login</h3>
            </div>
            <div class="col-xs-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
           
                  <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <section id="sign">
        <div class="sign_bg text-center">
          <h2>Log in to your account</h2>
          <h3>No account? | <a href="{{route('user.reg',$subdomain_name)}}">Create one here</a></h3>
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
                                    <label>Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="" value="{{ old('email') }}" minlength="3" maxlength="50">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="" name="password"  minlength="6" maxlength="12">
                                </div>
                                <div class="footer_link">
                                    <label class="registration"><a href="{{route('user.reg',$subdomain_name)}}">Create New Account</a></label>
                                    <label class="forget"><a href="{{route('user.forgotpass',$subdomain_name)}}"">Forgot your password?</a></label>
                                </div>
                                <button class="btn btn-info">Login</button>
                            </div>
                        </form>
        </div>
      </section>
    </main>

     
@endsection  


@section('footer')

<script type="text/javascript">

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){

        $.validator.addMethod('Validemail', function (value, element) {
            return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
        }, "Please enter a valid email address.");

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
  