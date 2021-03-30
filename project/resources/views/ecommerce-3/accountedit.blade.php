@extends('ecommerce-3.includes.newmaster')

@section('content')

<main>

    <section id="order_list">
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
                @include('ecommerce-3.includes.usermenu')
            </div>
            <div class="col-sm-8">
                <div class="dashboard-content">
                    <div class="table_box">
                        <h3>Edit Acconut Information</h3>
                        <hr>
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <p class="text-danger"><span>*</span> required field</p>
                        <div class="single-account-info-div">
                            <form action="{{url('user/update')}}/{{$user->id}}" method="POST" id="edit_form">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="dash_fname">Full name <span>*</span></label>
                                        <input class="form-control" type="text" name="name" id="dash_fname" value="{{$user->name}}" placeholder="first name" maxlength="50" minlength="3">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="dash_email">email address <span>*</span></label>
                                        <input class="form-control" type="email" name="mail" value="{{$user->email}}" id="dash_email" placeholder="email address" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="dash_email">Phone Number <span>*</span></label>
                                        <input class="form-control" type="text" name="phone" value="{{$user->phone}}" placeholder="Phone Number" maxlength="10" minlength="10">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="dash_email">Address <span>*</span></label>
                                        <textarea name="address" placeholder="Address" class="form-control" maxlength="255" minlength="3">{{$user->address}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="dash_email">City <span>*</span></label>
                                        <input name="city" placeholder="City" value="{{$user->city}}" class="form-control" type="text" maxlength="30" minlength="3">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="dash_email">Postal Code <span>*</span></label>
                                        <input name="zip" placeholder="Postal Code" class="form-control" value="{{$user->zip}}" type="text" maxlength="8" minlength="6" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <a class="btn btn-md back-btn" href="{{route('user.account',$subdomain_name)}}">back</a>
                                        <input class="btn btn-md save-btn" type="submit" value="save">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                name:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                },
                phone:{
                    required:true,
                    digits:true,
                    maxlength:10,
                    minlength:10
                },
                address:{
                    required:true,
                    maxlength:255
                },
                city:{
                    required:true,
                    minlength: 3,
                    maxlength:30
                },
                zip:{
                    required:true,
                    digits:true,
                    maxlength: 8,
                    minlength:6,
                }
            },
            messages:{
                city:{
                    lettersonly:"Please enter only characters",
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