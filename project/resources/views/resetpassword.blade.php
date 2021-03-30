@extends('includes.newmaster')

@section('content')

    <div class="home-wrapper">
        <!-- Starting of login area -->
        <div class="section-padding login-area-wrapper wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="signIn-area">
                            <h2 class="signIn-title">{{trans('app.ResetPassword')}}</h2>
                            <hr/>
                            <form action="{!! action('Auth\ProfileResetPassController@usernewpassword',$subdomain_name) !!}" method="POST" id="reset_form">
                                {{ csrf_field() }}

                                <input type="hidden" name="id" value="{{$id}}">
                                
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
                                    <label for="email">{{trans('app.NewPassword')}} <span>*</span></label>
                                    <input class="form-control" type="password" name="new_password" id="new_password" placeholder="{{trans('app.EnterNewPassword')}}">
                                </div>

                                <div class="form-group">
                                    <label for="email">{{trans('app.ConfirmPassword')}} <span>*</span></label>
                                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="{{trans('app.ReenterPassword')}}">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input class="btn btn-md login-btn" type="submit" value="{{trans('app.Submit')}}">
                                        </div>
                                    </div>
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

        $('#reset_form').validate({
            rules:{
                new_password:{
                    required: true,
                    minlength: 6,
                    maxlength: 12,
                },
                confirm_password:{
                    equalTo: '#new_password',
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