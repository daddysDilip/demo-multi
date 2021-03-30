@extends('includes.newmaster')

@section('content')

    <div class="home-wrapper">
        <!-- Starting of login area -->
        <div class="section-padding login-area-wrapper wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="signIn-area">
                            <h2 class="signIn-title">{{trans('app.ForgotPassword')}}</h2>
                            <hr/>
                            <form action="{{ route('user.forgotpass.submit',$subdomain_name) }}" method="POST" id="forgotpassword">
                                {{ csrf_field() }}


                                <div id="resp">
                                    @if(Session::has('success'))
                                        <div class="alert alert-success alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    @if(Session::has('error'))
                                        <div class="alert alert-danger alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            {{ Session::get('error') }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                    <input class="form-control" value="{{ old('email') }}" type="email" name="email" id="email" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                            <a href="{{url('user/login')}}">{{trans('app.LoginNow')}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-md login-btn" type="submit" value="{{trans('app.Submit')}}">
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

        $('#forgotpassword').validate({
            rules:{
                email:{
                    required:true,
                    Validemail: true,
                    minlength: 3,
                    maxlength: 50,
                },
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