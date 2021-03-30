@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.Discount')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/discount') !!}">{{trans('app.Discount')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.ManageDiscount')}}</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">

                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#default_lang" data-toggle="tab" aria-expanded="true">{{get_language_name(get_defaultlanguage())}}</a></li>

                        @php $current_language = explode(",", $companydetails[0]->language); @endphp
                        @foreach($current_language as $alllang)
                            @if($alllang != get_defaultlanguage())
                                <li class="store_lang"><a href="#{{$alllang}}" data-toggle="tab" aria-expanded="true">{{get_language_name($alllang)}}</a></li>
                            @endif
                        @endforeach
                    </ul>

                    <div id="response"></div>

                    <div class="col-xs-12">
                        <form method="POST" action="{!! action('DiscountController@store',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="discount_form">
                            {{csrf_field()}}
                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">{{trans('app.VoucherCode')}}<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="code" class="form-control col-md-7 col-xs-12" name="code" type="text" style="text-transform: uppercase;" maxlength="6" minlength="1">
                                        </div>
                                    </div>
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">{{trans('app.Title')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="title" class="form-control col-md-7 col-xs-12" name="title" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amounttype">{{trans('app.SelectPercentageAmount')}}
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" name="amounttype" id="amounttype" onchange="if(this.value == 2){$('#voucher_amount').attr('placeholder','Rs.');$('#dis_span').hide();}else{if(this.value == 1){$('#voucher_amount').attr('placeholder','%');$('#dis_span').show();}}">
                                                <option value="2">{{trans('app.Amount')}}</option>
                                                <option value="1">{{trans('app.Percentage')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Discount')}}</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="voucher_amount" class="form-control col-md-7 col-xs-12" name="discount" type="text" placeholder="Rs" onkeypress="return isNumber(event)">
                                            <span id="dis_span" style="display:none;"> 0-100</span>
                                        </div>
                                    </div>
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MinPrice')}}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="minprice" class="form-control col-md-7 col-xs-12" name="minprice" type="text" maxlength="10" minlength="0" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                    <div class="item form-group maxprice_section">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MaxPrice')}}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="maxprice" class="form-control col-md-7 col-xs-12" type="text" maxlength="10" minlength="0"  onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.StartDate')}}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="startdate" class="form-control col-md-7 col-xs-12 datepicker" name="startdate" type="text" maxlength="10" minlength="3" >
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.ExpiryDate')}}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="enddate" class="form-control col-md-7 col-xs-12 datepicker" name="enddate" type="text" maxlength="30" minlength="3" >
                                        </div>
                                    </div>
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Description')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea rows="6" class="form-control post-content" name="description" id="content1" ></textarea>
                                        </div>
                                    </div>
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.FeaturedImage')}}
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img id="image_view" class="image_view">
                                            <button id="upload_files" onclick="document.getElementById('file').click(); return false;">{{trans('app.SelectImage')}}</button>
                                           <input type="file" accept="image/*" name="image" id="file" onchange="readURL(this);">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">{{trans('app.IsActive')}}?</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="1" data-off="{{trans('app.Deactive')}}" checked>
                                        </div>
                                    </div>
                                </div>
                                @foreach($current_language as $alllang)
                                    @if($alllang != get_defaultlanguage())
                                        <div class="tab-pane" id="{{$alllang}}">
                                            <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">
                                           <br><br>

                                           <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Title')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="trans_title_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_title[]" type="text" maxlength="50" minlength="3">
                                                </div>
                                            </div>
                                            
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Description')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea rows="10" class="form-control post-content" name="trans_description[]" id="trans_description_{{$alllang}}" onchange="testfunction();"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">{{trans('app.Save')}}</button>
                                    <a href="{!! url('admin/discount') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')
<script type="text/javascript">

    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('content1');
    });

    $('.langcode').each(function(){
        var code = $(this).val();

        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true}).panelInstance('trans_description_'+code);
        });
    });


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

        var data = $('#amounttype').val(); 
        if(data == 1)
        {
            $('.maxprice_section').show();
            $('#maxprice').attr('name','maxprice');
            $('#voucher_amount').attr('maxlength',3);
            $('#voucher_amount').addClass('percentage');
        }
        else
        {
            $('.maxprice_section').hide();
            $('#maxprice').removeAttr('name','maxprice');
            $('#voucher_amount').attr('maxlength',10);
            $('#voucher_amount').removeClass('percentage');
        }
        $('#amounttype').change(function(){
            var data = $('#amounttype').val(); 
            if(data == 1)
            {
                $('.maxprice_section').show();
                $('#maxprice').attr('name','maxprice');
                $('#voucher_amount').addClass('percentage');
                $('#voucher_amount').attr('maxlength',3);
            }
            else
            {
                $('.maxprice_section').hide();
                $('#maxprice').removeAttr('name','maxprice');
                $('#voucher_amount').removeClass('percentage');
                $('#voucher_amount').attr('maxlength',10);
            }
        });

        jQuery.validator.addMethod("greaterThan", 
            function(value, element, params) {

                if (!/Invalid|NaN/.test(new Date(value))) {
                    return new Date(value) > new Date($(params).val());
                }

                return isNaN(value) && isNaN($(params).val()) 
                    || (Number(value) > Number($(params).val())); 
            }, EnddateGreaterFromdate);

            jQuery.validator.addClassRules("percentage", {
                required: true,
                max: 100,
                min: 0
            });

        $('#discount_form').validate({
            rules:{
                code:{
                    required:true,
                    minlength: 3,
                    maxlength: 6,
                    remote: {
                        type: 'post',
                        url: "{{ URL('admin/exist_discode') }}",
                        async: false,
                        async:false,
                        data: {
                            name: function () 
                            {
                                return $("input[name='code']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                },
				title:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                discount: {
                    required: true,
                    maxlength: 10,
                    min: 0,
                },
                minprice: {
                    required: true,
                    number: true,
                    maxlength: 10,
                    min: 0,
                },
                maxprice: {
                    required: true,
                    number: true,
                    maxlength: 10,
                    min: 0,
                },
                startdate: {
                    required: true,
                }, 
                enddate: {
                    required: true,
                    greaterThan: "#startdate"
                },   
            },
            messages:{
                code:{
                    remote: AlreadyExist,
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

        $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});

        $('input').on('blur keyup', function() {
            if ($("#discount_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });  

    });
</script>
@stop