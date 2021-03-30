@extends('themextra-e-comm.includes.newmaster')

@section('content')

<main>

    <section id="sign">
        <div class="col sign_bg">
            <h2 class="login-title">{{trans('app.ForgotPassword')}}</h2>
            <h2><a href="{{url('user/login')}}">{{trans('app.Login')}}</a></h2>

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

                <div class="form-row">
                    <div class="form-group">
                        <label>{{trans('app.EmailAddress')}}</label>
                        <input type="email" name="email" class="form-control" placeholder="" value="{{ old('email') }}" minlength="3" maxlength="50">
                    </div>

                    <button class="checkout add-cart text-uppercase">{{trans('app.Submit')}}</button>
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