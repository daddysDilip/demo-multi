@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{trans('app.ChangePassword')}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
                  <li class="breadcrumb-item active text-capitalize" aria-current="page">{{trans('app.ChangePassword')}}</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="my-cart-wrap">
        <div class="container">
            <div class="row wrapper">
                <div class="col-md-4">
                    @include('fashion-ecommerce.includes.usermenu')
                </div>
                <div class="col-md-8">
                    <div class="dashboard-content">
                        <div id="account-information-tab">
                            <h4 class="text-uppercase f-weight600">{{trans('app.ChangePassword')}}</h4>
                            <div class="edit-account-info-div">
                                @if(Session::has('message'))
                                    <div class="alert alert-success alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ Session::get('message') }}
                                    </div>
                                @endif
                                <p class="text-danger"><span>*</span> {{trans('app.RequiredField')}}</p>
                                <form action="{{url('user/passchange')}}/{{$user->id}}" method="POST" id="changepass_form">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            <label for="dash_password">{{trans('app.CurrentPassword')}} <span>*</span></label>
                                            <input class="form-control" type="password" name="cpass" id="dash_password" placeholder="01234567" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            <label for="new_password">{{trans('app.NewPassword')}} <span>*</span></label>
                                            <input class="form-control" type="password" name="newpass" id="new_password" placeholder="01234567" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            <label for="change_password">{{trans('app.ChangePassword')}} <span>*</span></label>
                                            <input class="form-control" type="password" name="renewpass" id="change_password" placeholder="01234567" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            <input class="btn btn-md save-btn" type="submit" value="{{trans('app.ChangePassword')}}">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

@stop

@section('footer')

<script type="text/javascript">

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){

        var id = $('input[name="id"]').val();

        $('#changepass_form').validate({
            rules:{
                cpass:{
                    required:true,
                    remote: {
                        type: 'post',
                        url: "{{ URL('user/old_password') }}",
                        async: false,
                        async:false,
                        data: {
                            cpass: function () 
                            {
                                return $("input[name='cpass']").val();
                            },
                            id: function ()
                            {
                                return id;
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                },
                newpass:{
                    required:true,
                    minlength: 6,
                    maxlength: 12,
                },
                renewpass:{
                    required:true,
                    equalTo:"#new_password",
                }
            },
            messages:{
                cpass:{
                    remote: CurrentPassIncorrect,
                },
                renewpass:{
                    equalTo: PasswordNoMatch
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