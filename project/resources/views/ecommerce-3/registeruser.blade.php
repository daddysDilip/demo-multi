@extends('ecommerce-3.includes.newmaster')

@section('content')
    <main>
      <section id="title">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <h3>Register</h3>
            </div>
            <div class="col-xs-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Pages</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Register</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <section id="sign" class="sign">
       <div class="container sign_bg text-center" id="">
        <div class="row">
           <div class="col-md-12">
              <h2>Create your account</h2>
              <h3>Alreary have an account ? | <a href="{{route('user.account',$subdomain_name)}}">Log In</a></h3>
           </div>
        </div>
         <div class="row">
           <div class="col-md-12">
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
                                <div class="form-group">
                                    <label for="reg_email">Email Address <span>*</span></label>
                                    <input class="form-control" type="text" name="email" id="reg_email" maxlength="50" minlength="3">
                                </div>
                                <div class="form-group">
                                    <label for="reg_name">Name <span>*</span></label>
                                    <input class="form-control" type="text" name="name" id="reg_name" maxlength="50" minlength="3">
                                </div>
                                <div class="form-group">
                                    <label for="reg_Pnumber">Phone Number <span>*</span></label>
                                    <input class="form-control" type="text" name="phone" id="reg_Pnumber" maxlength="10" minlength="10" onkeypress="return isNumber(event)" >
                                </div>
                                <div class="form-group">
                                    <label for="reg_password">Password <span>*</span></label>
                                    <input class="form-control" type="password" name="password" id="reg_password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password <span>*</span></label>
                                    <input class="form-control" type="password" name="password_confirmation" id="confirm_password">
                                </div>
                             <!--    <div class="footer_link">
                                    <label class="registration"><a href="{{url('user/login')}}">Already Have Account?</a></label>
                                </div> -->
                                <button class="btn btn-info">Sign Up</button>
                            </div>
                        </form>
           </div>
         </div>
       </div>
     </section>
    </main>
    @endsection
  