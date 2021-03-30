@extends('themextra-e-comm.includes.newmaster')

@section('content')

<main>
    
    <section id="sign">
        <div class="col sign_bg">

            <h2 class="login-title">{{trans('app.ResetPassword')}}</h2>

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
                    <input class="form-control" type="password" name="new_password" id="new_password" placeholder="Enter New Password">
                </div>

                <div class="form-group">
                    <label for="email">{{trans('app.ConfirmPassword')}} <span>*</span></label>
                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Re-enter Password">
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="btn btn-md login-btn" type="submit" value="{{trans('app.Submit')}}">
                        </div>
                    </div>
                </div>
            </form>
            
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