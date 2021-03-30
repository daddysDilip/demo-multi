@extends('admin.includes.master-admin')

@section('content')

@php $companyid = get_company_id(); @endphp

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Products</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/products') !!}">Products</a></li>
                    <li class="breadcrumb-item">Manage Product</a></li>
                </ul>
            </div>

                <!-- Page Content -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="gocover"></div>
                        <div id="response"></div>
                        <form method="POST" action="{{url('admin/products')}}/{{$product->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="product_form">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$product->id}}">
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Name<span class="required">*</span>
                                    <p class="small-label">(In Any Language)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" class="form-control col-md-7 col-xs-12" name="title" value="{{$product->title}}" placeholder="e.g Atractive Stylish Jeans For Women" type="text" maxlength="50" minlength="3">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">SKU Code<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="skucode" class="form-control col-md-7 col-xs-12" name="skucode" placeholder="e.g AB012-0001" type="text" maxlength="10" minlength="3" value="{{$product->skucode}}">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Main Category<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="mainid" id="maincats">
                                        <option value="">Select Main Category</option>
                                        @foreach($categories as $category)
                                            @if($product->category[0] == $category->id)
                                                <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                            @else
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="subid" id="subs">
                                        <option value="">Select Sub Category</option>
                                        @foreach($subs as $sub)
                                            @if($product->category[1] == $sub->id)
                                                <option value="{{$sub->id}}" selected>{{$sub->name}}</option>
                                            @else
                                                <option value="{{$sub->id}}">{{$sub->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Child Category<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="childid" id="childs">
                                        <option value="">Select Child Category</option>
                                        @foreach($child as $data)
                                            @if($product->category[2] == $data->id)
                                                <option value="{{$data->id}}" selected>{{$data->name}}</option>
                                            @else
                                                <option value="{{$data->id}}">{{$data->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="loadDiv"> 
                                <div class="item form-group">
                                    @if($product->feature_image != '')
                                    <input type="hidden" name="_method" value="PATCH">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> Current Product Image</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img style="max-width: 250px;" src="{{url('assets/images/products')}}/{{$product->feature_image}}" id="adminimg" alt="No Featured Image Added">
                                            <br>
                                            <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> Delete Prodect Image</a>
                                        </div>
                                    </div>
                                    @endif  
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($product->feature_image != '')Change Product Image @else Product Image @endif
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input onchange="readURL(this)" id="uploadFile" name="photo" type="file">
                                    </div>
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

                            @if(count($gallary) > 0)

                            <div class="item form-group">
                                <div class="col-sm-offset-3 col-sm-10 images">
                                @foreach($gallary as $allgalary)
                                    <img src="{{url('assets/images/gallery')}}/{{$allgalary->image}}" style="width: 100px;height: 100px;"> 
                                
                                @endforeach
                                </div>
                                <div class="col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="galdel" value="1"/>
                                            Delete Old Gallery Images</label>
                                    </div>

                                </div>
                            </div><br>
                            @endif
                           
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
                                    <input class="form-control col-md-7 col-xs-12" name="sizes" value="{{$product->sizes}}" data-role="tagsinput"/>
                                </div>
                            </div> -->

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Description</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="description" id="description" class="form-control" rows="6">{{$product->description}}</textarea>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Price<span class="required">*</span>
                                    <p class="small-label">(In {{$settings[0]->currency_code}})</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="price" id="price" value="{{$product->price}}" type="text" onkeypress="return isNumber(event)" maxlength="10" minlength="2">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Offer Price
                                    <p class="small-label">(In {{$settings[0]->currency_code}}, Leave Blank if not Required)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="offer_price" value="{{$product->offer_price}}" type="text" onkeypress="return isNumber(event)" maxlength="10" minlength="2">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Stock</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="stock" value="{{$product->stock}}" type="text" onkeypress="return isNumber(event)" maxlength="2" minlength="1">
                                </div>
                            </div>

                            <input type="hidden" name="ship_info" id="ship_info" value="{{$settings[0]->shipping_information}}">

                            <div class="item form-group shipping_section">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Shipping Cost<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" id="shipping_cost" placeholder="e.g 15" type="text" value="{{$product->shipping_cost}}" onkeypress="return isNumber(event)" maxlength="10" minlength="0">
                                </div>
                            </div>

                            <input type="hidden" name="tax_info" id="tax_info" value="{{$settings[0]->tax_information}}">

                            <div class="item form-group tax_section">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tax (%)<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" id="tax" placeholder="e.g 15" type="text" value="{{$product->tax}}" onkeypress="return isNumber(event)" maxlength="3" minlength="0">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Buy/Return Policy
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="policy" id="policy" class="form-control" rows="6">{{$product->policy}}</textarea>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">
                                </label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    @if($product->featured == 1)
                                        <label class="btn btn-default active">
                                            <input type="checkbox" name="featured" value="1" autocomplete="off" checked>
                                            Add to Featured Product
                                        </label>
                                    @else
                                        <label class="">
                                            <input type="checkbox" name="featured" value="1" autocomplete="off">
                                            Add to Featured Product
                                        </label>
                                    @endif
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Tags
                                    <p class="small-label">(Write your product tags Separated by Comma[,])</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="tags" value="{{$product->tags}}" data-role="tagsinput"/>
                                </div>
                            </div>
                                 <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Title<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="metatitle" id="metatitle" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="60" value="{{$product->metatitle}}"> 
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Description<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12" name="metadec" id="metadec" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="120">{{$product->metadec}}</textarea>
                                </div>
                            </div>

                             <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta Keyword<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12" name="metakey" id="metakey" placeholder="e.g ABCS" type="text"  minlength="3" maxlength="160">{{$product->metakey}}</textarea>
                                </div>
                            </div>



                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    @if($product->status == 1)
                                    <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                                    @elseif($product->status == 0)
                                    <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
                                    @endif
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="add_ads" type="submit" class="btn btn-success">Update Product</button>
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

<script>
    bkLib.onDomLoaded(function() {
        new nicEditor().panelInstance('description');
        new nicEditor().panelInstance('policy');
    });

    $("#allow").change(function () {
        $("#pSizes").toggle();
    });
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#adminimg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

     function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
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

        var id = $('input[name="id"]').val();

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
                mainid:{
                    required:true,
                },
                subid:{
                    required:true,
                },
                childid:{
                    required:true,
                },
                price:{
                    required:true,
                    number: true,
                    minlength:2,
                    maxlength:10
                },
                OfferPrice: 
                {
                    required: false,
                    number: true,
                    lesserThan: "#Price"
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
                  metatitle:{
                    minlength:3,
                    maxlength:60,
                },
                metadec:{
                    minlength:3,
                    maxlength:120,  
                },
                metakey:{
                    minlength:3,
                    maxlength:160,
                }
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

        var id = $('input[name="id"]').val();


    $('.delete_img').click(function(){
        $.ajax({
            url: "{{ URL('admin/delete/feature_image') }}/"+id,
            type: "get",
            async: false,
            data: {},
            success: function(data)
            {
                $('.loadDiv').load(' .loadDiv');
            },
        });
    });

</script>

@stop