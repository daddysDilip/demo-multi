@extends('ecommerce-4.includes.newmaster')

@section('content')

<main>

    <section id="order_list">
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
                @include('ecommerce-4.includes.usermenu')
            </div>
            <div class="col-sm-8">
                <div class="dashboard-content">
                    <div class="table_box">
                        <h3>{{trans('app.EditShippingAddress')}}</h3>
                        <hr>
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <p class="text-danger"><span>*</span> {{trans('app.RequiredField')}}</p>
                        <div class="single-account-info-div">
                            <form action="{{route('user.editshipping',$subdomain_name)}}" method="POST" id="edit_form">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="shipping_firstname">{{trans('app.FirstName')}} <span>*</span></label>
                                            <input class="form-control" type="text" name="shipping_firstname" id="shipping_firstname" value="{{$shippingadd->shipping_firstname}}" maxlength="30" minlength="3">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="shipping_lastname">{{trans('app.LastName')}} <span>*</span></label>
                                            <input class="form-control" type="text" name="shipping_lastname" id="shipping_lastname" value="{{$shippingadd->shipping_lastname}}" maxlength="30" minlength="3">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="shipping_email">{{trans('app.EmailAddress')}} <span>*</span></label>
                                            <input class="form-control" type="email" name="shipping_email" id="shipping_email" value="{{$shippingadd->shipping_email}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="shipping_phone">{{trans('app.PhoneNumber')}} <span>*</span></label>
                                            <input class="form-control" type="text" name="shipping_phone" id="shipping_phone" value="{{$shippingadd->shipping_phone}}" maxlength="10" minlength="10">
                                        </div>
                                    </div>

                                    
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="shipping_address">{{trans('app.Address')}} <span>*</span></label>
                                            <textarea class="form-control" name="shipping_address" id="shipping_address" maxlength="255">{{$shippingadd->shipping_address}}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="shipping_country">{{trans('app.Country')}} <span>*</span></label>
                                            <select class="form-control" name="shipping_country" id="country" required>
                                                <option value="">{{trans('app.SelectCountry')}}</option>
                                                @foreach($country as $allcountry)
                                                    <option value="{{$allcountry->id}}" {{ ($shippingadd->shipping_country == $allcountry->id ? 'selected': '') }}>{{$allcountry->countryname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="shipping_state">{{trans('app.State')}} <span>*</span></label>
                                            <div id='state_loader' style='display: none;position: absolute;'>
                                                <img src="{{url('/')}}/assets/images/ajax.gif" width='32px' height='32px'>
                                            </div>
                                            <select class="form-control" name="shipping_state" id="state" required>
                                                <option value="">{{trans('app.SelectState')}}</option>
                                                @foreach($state as $allstate)
                                                    <option value="{{$allstate->id}}" {{ ($shippingadd->shipping_state == $allstate->id ? 'selected': '') }}>{{$allstate->statename}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="shipping_city">{{trans('app.City')}} <span>*</span></label>
                                            <div id='city_loader' style='display: none;position: absolute;'>
                                                <img src="{{url('/')}}/assets/images/ajax.gif" width='32px' height='32px'>
                                            </div>
                                            <select class="form-control" name="shipping_city" id="city" required>
                                                <option value="">{{trans('app.SelectCity')}}</option>
                                                @foreach($city as $allcity)
                                                    <option value="{{$allcity->id}}" {{ ($shippingadd->shipping_city == $allcity->id ? 'selected': '') }}>{{$allcity->cityname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="dash_email">{{trans('app.PostalCode')}} <span>*</span></label>
                                            <input name="shipping_zip" id="shipping_zip" class="form-control" value="{{$shippingadd->shipping_zip}}" type="text" maxlength="8" minlength="6" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
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

    $(document).ready(function() {  
        $("#country").change(function(){  
            $("#state_loader").show(); 
            $("#state").hide(); 
            $.ajax({  
                url:"{{ URL('user/state_list') }}",  
                data: {countryid: $(this).val(),_token : $("input[name=_token]").val()},  
                type: "POST", 
                success:function(data)
                {  
                    
                    $("#state").show();  
                    $("#state").html(data);  
                    $("#state_loader").hide();
                }  
            });  
        });
     
        $("#state").change(function(){  
            $("#city_loader").show(); 
            $("#city").hide(); 
            $.ajax({  
                url:"{{ URL('user/city_list') }}",  
                data: {stateid: $(this).val(),_token : $("input[name=_token]").val()},  
                type: "POST",  
                success:function(data)
                {  
                    $("#city").show();  
                    $("#city").html(data);  
                    $("#city_loader").hide();
                }  
            });
        });  
    }); 

    $(document).ready(function(){

        $.validator.addMethod('Validemail', function (value, element) {
            return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
        }, ValidEmailError);

        $('#edit_form').validate({
            rules:{
                shipping_firstname:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                shipping_lastname:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                shipping_email:{
                    required:true,
                    Validemail:true,
                    maxlength:50,
                    minlength:3
                },
                shipping_phone:{
                    required:true,
                    digits:true,
                    maxlength:10,
                    minlength:10
                },
                shipping_address:{
                    required:true,
                    maxlength:255
                },
                shipping_country:{
                    required:true,
                },
                shipping_state:{
                    required:true,
                },
                shipping_city:{
                    required:true,
                },
                shipping_zip:{
                    required:true,
                    digits:true,
                    maxlength: 8,
                    minlength:6,
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