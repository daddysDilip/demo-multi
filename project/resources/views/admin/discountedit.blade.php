@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Discount</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/discount') !!}">Discount</a></li>
                    <li class="breadcrumb-item">Manage Discount</li>
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
                        <form method="POST" action="{{url('admin/discount')}}/{{$discount->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="discount_form">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$discount->id}}">
                            <input type="hidden" name="_method" value="PATCH">

                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    @php 
                                        $title = ''; 
                                        $description = ''; 
                                    @endphp
                                    @if(\App\DiscountTranslations::where('langcode',get_defaultlanguage())->where('discountid',$discount->id)->count() > 0)
                                        @php 
                                            $title = \App\DiscountTranslations::where('langcode',get_defaultlanguage())->where('discountid',$discount->id)->first()->title; 
                                            $description = \App\DiscountTranslations::where('langcode',get_defaultlanguage())->where('discountid',$discount->id)->first()->description;
                                        @endphp
                                    @endif
            						<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">{{trans('app.VoucherCode')}}<span class="required">*</span></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="code" class="form-control col-md-7 col-xs-12" name="code" placeholder="eg. VF12O5" type="text" style="text-transform: uppercase;" maxlength="6" minlength="1" value="{{$discount->code}}">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">{{trans('app.Title')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="title" class="form-control col-md-7 col-xs-12" name="title" placeholder="Enter Title" type="text" maxlength="30" minlength="3" value="{{$title}}">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amounttype">{{trans('app.SelectPercentageAmount')}}
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" name="amounttype" id="amounttype" onchange="if(this.value == 2){$('#voucher_amount').attr('placeholder','Rs.');$('#dis_span').hide();}else{if(this.value == 1){$('#voucher_amount').attr('placeholder','%');$('#dis_span').show();}}">
                                                <option <?php if($discount->amounttype == 2) { ?>selected="selected"<?php } ?> value="2">Amount</option>
                                                <option <?php if($discount->amounttype == 1) { ?>selected="selected"<?php } ?> value="1">Percentage</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Discount')}}</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="voucher_amount" class="form-control col-md-7 col-xs-12" name="discount" type="text" placeholder="Rs" onkeypress="return isNumber(event)" value="{{$discount->discount}}">
                                            <span id="dis_span" style="display:none;"> 0-100</span>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MinPrice')}}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="minprice" class="form-control col-md-7 col-xs-12" name="minprice" type="text" maxlength="10" minlength="0" placeholder="Enter Min Price" onkeypress="return isNumber(event)" value="{{$discount->minprice}}">
                                        </div>
                                    </div>
                                    <div class="item form-group maxprice_section">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.MaxPrice')}}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="maxprice" class="form-control col-md-7 col-xs-12" type="text" maxlength="10" minlength="0" placeholder="Enter Max Price" onkeypress="return isNumber(event)" value="{{$discount->maxprice}}">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.StartDate')}}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="startdate" class="form-control col-md-7 col-xs-12 datepicker" name="startdate" type="text" maxlength="10" minlength="3" placeholder="Enter Start Date" value="<?php echo date('d/m/Y',strtotime($discount->startdate)); ?>">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.ExpiryDate')}}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="enddate" class="form-control col-md-7 col-xs-12 datepicker" name="enddate" type="text" maxlength="30" minlength="3" placeholder="Enter End Date" value="<?php echo date('d/m/Y',strtotime($discount->enddate)); ?>">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Description')}}<p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea rows="6" class="form-control post-content" name="description" id="content1" placeholder="Enter Description">{{$description}}</textarea>
                                        </div>
                                    </div>
                                    @if($discount->image != '')
                                    <div class="item form-group">
                                        <div class="loadDiv"> 
                                         
                                            <input type="hidden" name="_method" value="PATCH">
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">{{trans('app.CurrentImage')}}</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                        
                                                    <img src="{{url('/assets/images/discount')}}/{{$discount->image}}" class="" alt="No Image Added" style="width: 50%;max-height: 200px;">

                                                    <br>
                                                    <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> {{trans('app.DeleteImage')}}</a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>                            
                                    @endif     
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($discount->image != ''){{trans('app.ChangeImage')}} @else {{trans('app.FeaturedImage')}} @endif

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
                                            @if($discount->status == 1)
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="1" data-off="{{trans('app.Deactive')}}" checked>
                                            @elseif($discount->status == 0)
                                            <input type="checkbox" data-toggle="toggle" data-on="{{trans('app.Active')}}" name="status" value="0" data-off="{{trans('app.Deactive')}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @foreach($current_language as $alllang)
                                    @if($alllang != get_defaultlanguage())
                                        @php 
                                            $title = ''; 
                                            $description = ''; 
                                        @endphp
                                        @if(\App\DiscountTranslations::where('langcode',$alllang)->where('discountid',$discount->id)->count() > 0)
                                            @php 
                                                $title = \App\DiscountTranslations::where('langcode',$alllang)->where('discountid',$discount->id)->first()->title; 
                                                $description = \App\DiscountTranslations::where('langcode',$alllang)->where('discountid',$discount->id)->first()->description;
                                            @endphp
                                        @endif
                                        <div class="tab-pane" id="{{$alllang}}">
                                            <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">
                                            <br><br>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Title')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="trans_title_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_title[]" type="text" maxlength="50" minlength="3" value="{{$title}}">
                                                </div>
                                            </div>
                                            
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Description')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea rows="10" class="form-control post-content" name="trans_description[]" id="trans_description_{{$alllang}}" onchange="testfunction();">{{$description}}</textarea>
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

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $('.langcode').each(function(){
        var code = $(this).val();

        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true}).panelInstance('trans_description_'+code);
        });
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
        },'End date should be greater than from date.');

        jQuery.validator.addClassRules("percentage", {
            required: true,
            max: 100,
            min: 0
        });

        var id = $('input[name="id"]').val();

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
                enddate: {
                    required: true,
                    greaterThan: "#startdate"
                },
                startdate: {
                    required: true,
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

        if ($("#discount_form").valid()) {
            $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
        } else {
            $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
        }

        $('input').on('blur keyup', function() {
            if ($("#discount_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });  

    });

    var id = $('input[name="id"]').val();

    $('.delete_img').click(function(){
        $.ajax({
            url: "{{ URL('admin/delete/discount') }}/"+id,
            type: "get",
            async: false,
            data: {"_token": "{{ csrf_token() }}"},
            success: function(data)
            {
                $('.loadDiv').load(' .loadDiv');
            },
        });
    });

</script>
@stop