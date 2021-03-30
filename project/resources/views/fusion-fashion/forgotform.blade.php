@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item active text-capitalize" aria-current="page">{{trans('app.ForgotPassword')}}</li>
            </ol>
        </div>
    </nav>
     
    <section class="sign-inwrap">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-box">
                        <h2>{{trans('app.ForgotPassword')}}</h2>
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
                                    <label>{{trans('app.EmailAddress')}} <span>*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="" value="{{ old('email') }}" minlength="3" maxlength="50">
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