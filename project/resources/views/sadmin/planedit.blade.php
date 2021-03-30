@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Plan</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/plans') !!}">Plan</a></li>
                    <li class="breadcrumb-item">Manage Plan</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('sadmin/plans')}}/{{$plan->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="plan_form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$plan->id}}">
                        <input type="hidden" name="_method" value="PATCH">
						
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plantype">Type<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="plantype" class="form-control col-md-7 col-xs-12" name="plantype" placeholder="Enter Plan Type" type="text" maxlength="30" minlength="3" value="{{$plan->plantype}}">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plantitle">Title<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="plantitle" class="form-control col-md-7 col-xs-12" name="plantitle" placeholder="Enter Plan Title" type="text" maxlength="30" minlength="3" value="{{$plan->plantitle}}">
                            </div>
                        </div>
                       
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea rows="10" class="form-control post-content" name="description" id="content1" placeholder="Enter Description"> {{$plan->description}}</textarea>

                            </div>
                        </div>
                        
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="planamount">Plan Charge<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="planamount" class="form-control col-md-7 col-xs-12" name="planamount" placeholder="Enter Plan Charge" type="text" maxlength="10" minlength="0" onkeypress="return isNumber(event)" value="{{$plan->planamount}}">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_limit">Product Add Limit<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="product_limit" class="form-control col-md-7 col-xs-12" name="product_limit" placeholder="Enter Product Limit" type="text" maxlength="5" minlength="0" onkeypress="return isNumber(event)" value="{{$plan->product_limit}}">
                            </div>
                        </div>

                        @php $planarray = array(); @endphp
                        @if(count($upgradeplan) > 0)
                            @foreach($upgradeplan as $alluplan)
                                @php $planarray[] = $alluplan->planid; @endphp
                            @endforeach
                        @endif
                        
                        @if(!in_array($plan->id, $planarray))
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                @if($plan->status == 1)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                                @elseif($plan->status == 0)
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive">
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update Plan</button>
                                <a href="{!! url('sadmin/plans') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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
        new nicEditor({fullPanel : true}).panelInstance('content1');
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    var id = $('input[name="id"]').val();

    $(document).ready(function(){

        $('#plan_form').validate({
            rules:{
                plantype:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/type_exists') }}",
                        async: false,
                        async:false,
                        data: {
                            plantype: function () 
                            {
                                return $("input[name='plantype']").val();
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
                plantitle:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                },
                planamount:
                {
                    required: true,
                    number:true,
                    maxlength:10,
                    min:1,
                },
                product_limit:
                {
                    required: true,
                    number:true,
                    minlength:2,
                    max:10000,
                    min:1,
                }
            },
            messages:{
                plantype:
                {
                    remote: "Already exist",
                },
                planamount:
                {
                    min: "Please enter valid price",
                },
                product_limit:
                {
                    min: "Please enter valid product limit",
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