@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{trans('app.ResetPassword')}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
                  <li class="breadcrumb-item active text-capitalize" aria-current="page">{{trans('app.ResetPassword')}}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="login">
        <div class="container">
            <div class="row wrapper">
                <div class="col">
                    <form action="{!! action('Auth\ProfileResetPassController@usernewpassword',$subdomain_name) !!}" method="POST" id="reset_form">
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

                        <input type="hidden" name="id" value="{{$id}}">

                        
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>{{trans('app.NewPassword')}} <span>*</span></label>
                                <input class="form-control" type="password" name="new_password" id="new_password" placeholder="{{trans('app.EnterNewPassword')}}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{trans('app.ConfirmPassword')}} <span>*</span></label>
                                <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="{{trans('app.ReenterPassword')}}">
                            </div>
                            
                            <button class="checkout add-cart text-uppercase">{{trans('app.Submit')}}</button>
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