@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Products</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/products') !!}">Products</a></li>
                    <li class="breadcrumb-item">Manage Product</li>
                </ul>
            </div>

                <!-- Page Content -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="gocover"></div>
                        <div id="response"></div>
                        <form method="POST" action="{!! action('ProductController@store',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="product_form">
                            {{csrf_field()}}
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Name<span class="required">*</span>
                                    <p class="small-label">(In Any Language)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" class="form-control col-md-7 col-xs-12" name="title" placeholder="e.g Atractive Stylish Jeans For Women" type="text" maxlength="50" minlength="3">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">SKU Code<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="skucode" class="form-control col-md-7 col-xs-12" name="skucode" placeholder="e.g AB012-0001" type="text" maxlength="10" minlength="3">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Main Category<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="mainid" id="maincats">
                                        <option value="">Select Main Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="subid" id="subs" disabled>
                                        <option value="">Select Sub Category</option>
                                    </select>
                                    <button class="btn subcat_btn" style="display: none;">Add Sub Category</button>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Child Category<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="childid" id="childs" disabled>
                                        <option value="">Select Child Category</option>
                                    </select>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Current Featured Image <span class="required">*</span>
                                </label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input onchange="readURL(this)" id="uploadFile" accept="image/*" name="photo" type="file">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> Product Gallery Images
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" accept="image/*" name="gallery[]" multiple/>
                                    <br>
                                    <p class="small-label">Multiple Image Allowed</p>
                                </div>
                            </div>

                            <!-- <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="pallow" id="allow" value="1"><strong>Allow Product Sizes</strong></label>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="item form-group" id="pSizes">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Sizes
                                    <p class="small-label">(Write your own size Separated by Comma[,])</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="sizes" value="" data-role="tagsinput"/>
                                </div>
                            </div> -->

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Description
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="Description" id="description" class="form-control" rows="6"></textarea>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Price<span class="required">*</span>
                                    <p class="small-label">(In {{$settings[0]->currency_code}})</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="price" id="price" placeholder="e.g 20" type="text" onkeypress="return isNumber(event)" maxlength="10" minlength="2">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Offer Price
                                    <p class="small-label">(In {{$settings[0]->currency_code}}, Leave Blank if not Required)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="offer_price" placeholder="e.g 25" type="text" onkeypress="return isNumber(event)" maxlength="10" minlength="2">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Stock
                                    <p class="small-label">(Leave Empty will Show Always Available)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="stock" placeholder="e.g 15" type="text" onkeypress="return isNumber(event)" maxlength="2" minlength="0">
                                </div>
                            </div>

                            <input type="hidden" name="ship_info" id="ship_info" value="{{$settings[0]->shipping_information}}">

                            <div class="item form-group shipping_section">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Shipping Cost<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" id="shipping_cost" placeholder="e.g 15" type="text" onkeypress="return isNumber(event)" maxlength="10" minlength="0">
                                </div>
                            </div>

                            <input type="hidden" name="tax_info" id="tax_info" value="{{$settings[0]->tax_information}}">

                            <div class="item form-group tax_section">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tax (%)<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" id="tax" placeholder="e.g 15" type="text" onkeypress="return isNumber(event)" maxlength="3" minlength="0">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Buy/Return Policy
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="policy" id="policy" class="form-control" rows="6"></textarea>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">
                                </label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <label class="">
                                        <input type="checkbox" name="featured" value="1">Add to Featured Product
                                    </label>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Tags
                                    <p class="small-label">(Write your product tags Separated by Comma[,])</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="tags"  data-role="tagsinput"/>
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
                                    <button id="add_ads" type="submit" class="btn btn-success">Add New Product</button>
                                    <a href="{!! url('admin/products') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

    bkLib.onDomLoaded(function() {
        new nicEditor().panelInstance('description');
        new nicEditor().panelInstance('policy');
    });

    $("#allow").change(function () {
       $("#pSizes").toggle();
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#adminimg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){

        $.validator.addMethod("lesserThan", function (value, element, param) {
            var $otherElement = $(param);
            return parseInt(value, 10) < parseInt($otherElement.val(), 10);
        }, 'Offer Price must be less than price');

        var shippingval = $('#ship_info').val();
        //alert('123');
        if(shippingval == 'Per Product')
        {
            $('.shipping_section').show();
            $('#shipping_cost').attr('name','shipping_cost');
        }
        else if(shippingval == 'Per Order')
        {
            $('.shipping_section').hide();
        }

        var taxval = $('#tax_info').val();

        if(taxval == 'Per Product')
        {
            $('.tax_section').show();
            $('#tax').attr('name','tax');
        }
        else if(taxval == 'Per Order')
        {
            $('.tax_section').hide();
        }

        $('#product_form').validate({
            rules:{
                title:{
                    required:true,
                    minlength: 3,
                    maxlength: 50,
                },
                skucode:{
                    required:true,
                    maxlength: 10,
                    minlength: 3,
                    remote: {
                        type: 'post',
                        url: "{{ URL('admin/exist_skucode') }}",
                        async: false,
                        async:false,
                        data: {
                            skucode: function () 
                            {
                                return $("input[name='skucode']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                },
                mainid:{
                    required:true,
                },
                subid:{
                    required:true,
                },
                childid:{
                    required:true,
                },
                photo:{
                    required:true,
                },
                price:{
                    required:true,
                    minlength:2,
                    number: true,
                    maxlength:10
                },
                offer_price:{
                    lesserThan: "#price",
                    number: true,
                    maxlength:10
                },
                stock:{
                    max:50,
                    number: true,
                },
                tax: {
                    required: true,
                    number: true,
                    range: [0, 100]
                },
                shipping_cost:{
                    required: true,
                    number: true,
                },
            },
            messages:{
                title:{
                    remote:"Already exist",
                },
                skucode:{
                    remote:"Already exist",
                },
                price:{
                    minlength:"Please enter at least 2 decimal places.",
                },
                offer_price:{
                    minlength:"Please enter at least 2 decimal places.",
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