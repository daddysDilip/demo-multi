@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Country</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/country') !!}">Country</a></li>
                    <li class="breadcrumb-item">Manage Country</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('sadmin/country')}}/{{$country->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="country_form">
                        {{csrf_field()}}
                        
                        <input type="hidden" name="id" value="{{$country->id}}">
                        <input type="hidden" name="_method" value="PATCH">

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="countryname">Country Name<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="countryname" class="form-control col-md-7 col-xs-12" name="countryname" placeholder="Enter Country Name" type="text" maxlength="15" minlength="3" value="{{$country->countryname}}">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sortname">Short Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="sortname" class="form-control col-md-7 col-xs-12" name="sortname" placeholder="Enter Country Sort Name" type="text" maxlength="3" minlength="2" value="{{$country->sortname}}">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phonecode">Phone Code</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="phonecode" class="form-control col-md-7 col-xs-12" name="phonecode" placeholder="Enter Phone Code" type="phonecode" maxlength="5" minlength="2" value="{{$country->phonecode}}" onkeypress="return isNumber(event)">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                @if($country->status == 1)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                                @elseif($country->status == 0)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
                                @endif
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update Country</button>
                                <a href="{!! url('sadmin/country') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')

<script type="text/javascript">

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(document).ready(function(){

        $(':input').change(function() {
            $(this).val($(this).val().trim());
        });
        
        var id = $('input[name="id"]').val();

        jQuery.validator.addMethod("lettersonly", function(value, element) 
        {
            return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "Please enter valid country"); 

        $('#country_form').validate({
            rules:{
                countryname:{
                    required: true,
                    maxlength: 15,
                    minlength:2,
                    lettersonly:true,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/country_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            countryname: function () 
                            {
                                return $("input[name='countryname']").val();
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
                sortname:{
                    maxlength: 3,
                    minlength:2,
                    lettersonly:true,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/sortname_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            sortname: function () 
                            {
                                return $("input[name='sortname']").val();
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
                phonecode:{
                    number: true,
                    minlength: 2,
                    maxlength: 5,
                }
            },
            messages:{
                countryname:{
                    remote:"Already exist",
                },
                sortname:{
                    remote:"Already exist",
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