@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>
    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">{{trans('app.ResetPassword')}}</li>
          </ol>
        </div>
    </nav>

    <section class="sign-inwrap">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-box">
                        <h2>{{trans('app.ResetPassword')}}</h2>
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
                                <div class="form-group">
                                    <label>{{trans('app.NewPassword')}} <span>*</span></label>
                                    <input class="form-control" type="password" name="new_password" id="new_password" placeholder="Enter New Password">
                                </div>
                                <div class="form-group">
                                    <label>{{trans('app.ConfirmPassword')}} <span>*</span></label>
                                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Re-enter Password">
                                </div>
                                
                                <button type="submit" class="btn btn-default">{{trans('app.Submit')}}</button>
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