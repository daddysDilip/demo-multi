@extends('fusion-fashion.includes.newmaster')

@section('content')

<main>

    <nav class="breadcrumb-wrap" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">{{trans('app.AccountInformation')}}</li>
          </ol>
        </div>
    </nav>

    <div id="order_list" class="my-cart-wrap">
        <div class="container">
            <div class="row wrapper">
                <div class="col-md-4 col-sm-4">
                    @include('fusion-fashion.includes.usermenu')
                </div>
                <div class="col-sm-8 col-sm-8">
                <div class="dashboard-content">
                    <div class="table_box">
                        <h3>{{trans('app.EditAccountInformation')}}</h3>
                        <hr>
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <p class="text-danger"><span>*</span> {{trans('app.RequiredField')}}</p>
                        <div class="single-account-info-div">
                            <form action="{{url('user/update')}}/{{$user->id}}" method="POST" id="edit_form">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="dash_fname">{{trans('app.FirstName')}} <span>*</span></label>
                                         <input class="form-control" type="text" name="firstname" id="firstname" value="{{$user->firstname}}" maxlength="30" minlength="3">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="dash_email">{{trans('app.LastName')}} <span>*</span></label>
                                       <input class="form-control" type="text" name="lastname" id="lastname" value="{{$user->lastname}}" maxlength="30" minlength="3">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="dash_email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                        <input class="form-control" type="email" name="mail" value="{{$user->email}}" id="dash_email" disabled>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="dash_email">{{trans('app.PhoneNumber')}} <span>*</span></label>
                                        <input class="form-control" type="text" name="phone" value="{{$user->phone}}" maxlength="10" minlength="10">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <a class="btn btn-md back-btn" href="{{route('user.account',$subdomain_name)}}">{{trans('app.Back')}}</a>
                                        <input class="btn btn-md save-btn" type="submit" value="{{trans('app.Save')}}">
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