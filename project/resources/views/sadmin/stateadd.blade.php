@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>State</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/state') !!}">State</a></li>
                    <li class="breadcrumb-item">Manage State</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{!! action('Sadmin\StateController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="state_form">
                        {{csrf_field()}}

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="countryid">Country<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="countryid" id="countryid">
                                    <option value="">Select Country</option>
                                    @foreach($country as $countries)
                                        <option value="{{$countries->id}}">{{$countries->countryname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statename">State Name<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="statename" class="form-control col-md-7 col-xs-12" name="statename" placeholder="Enter State Name" type="text" maxlength="25" minlength="3">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Add State</button>
                                <a href="{!! url('sadmin/state') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')

<script type="text/javascript">
    $(document).ready(function(){
        
        $(':input').change(function() {
            $(this).val($(this).val().trim());
        });

        jQuery.validator.addMethod("lettersonly", function(value, element) 
        {
        return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "Please enter valid state"); 

        $('#state_form').validate({
            rules:{
                countryid:{
                    required: true,  
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/state_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            countryid: function () 
                            {
                                return $("#countryid").val();
                            },
                            statename: function () 
                            {
                                return $("input[name='statename']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                    }
                },
                statename:{
                    required: true,
                    maxlength: 25,
                    minlength:2,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/state_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            statename: function () 
                            {
                                return $("input[name='statename']").val();
                            },
                            countryid: function () 
                            {
                                return $("#countryid").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                },
            },
            messages:{
                countryid:{
                    remote:"",
                },
                statename:{
                    remote:"Already exist",
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