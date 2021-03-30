@extends('fashion-ecommerce.includes.newmaster')

@section('content')

<main>
    <section class="inner-page-banner bgclr-primary pd-30">
        <div class="container">
            <div class="page-name f-24 text-uppercase f-weight600 clr-white text-center">{{trans('app.AccountInformation')}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('app.Home')}}</a></li>
                  <li class="breadcrumb-item active text-capitalize" aria-current="page">{{trans('app.AccountInformation')}}</li>
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
                            <h4 class="text-uppercase f-weight600">{{trans('app.EditAccountInformation')}}</h4>
                            <div class="edit-account-info-div">
                                <h5 class="text-capitalize">{{trans('app.AccountInformation')}}</h5>
                                @if(Session::has('message'))
                                    <div class="alert alert-success alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ Session::get('message') }}
                                    </div>
                                @endif
                                <p class="text-danger"><span>*</span> {{trans('app.RequiredField')}}</p>
                                <form action="{{url('user/update')}}/{{$user->id}}" method="POST" id="edit_form">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="dash_fname">{{trans('app.FirstName')}} <span>*</span></label>
                                             <input class="form-control" type="text" name="firstname" id="firstname" value="{{$user->firstname}}" maxlength="30" minlength="3">
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="dash_email">{{trans('app.LastName')}} <span>*</span></label>
                                            <input class="form-control" type="text" name="lastname" id="lastname" value="{{$user->lastname}}" maxlength="30" minlength="3">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="dash_email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                            <input class="form-control" type="email" name="mail" value="{{$user->email}}" id="dash_email" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="dash_email">{{trans('app.PhoneNumber')}} <span>*</span></label>
                                            <input class="form-control" type="text" name="phone" value="{{$user->phone}}" maxlength="10" minlength="10">
                                        </div>
                                    </div>

                               
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <input class="btn btn-md save-btn" type="submit" value="{{trans('app.Save')}}">
                                            <a class="btn btn-md back-btn" href="{{route('user.account',$subdomain_name)}}">{{trans('app.Back')}}</a>
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

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(document).ready(function(){

        $('#edit_form').validate({
            rules:{
                firstname:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                lastname:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                phone:{
                    required:true,
                    digits:true,
                    maxlength:10,
                    minlength:10
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