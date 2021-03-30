@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>{{trans('app.RoleSection')}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">{{trans('app.Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/roles') !!}">{{trans('app.RoleSection')}}</a></li>
                    <li class="breadcrumb-item">{{trans('app.ManageRole')}}</li>
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
                        <form method="POST" action="{!! action('RolesController@store',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="role_form">
                            {{csrf_field()}}

                            <div class="tab-content">
                                <div class="tab-pane active" id="default_lang">
                                    <input type="hidden" name="default_langcode" value="{{get_defaultlanguage()}}">
                                    <br><br>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Role')}}<span class="required">*</span><p class="small-label">({{get_language_name(get_defaultlanguage())}})</p></label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="role" class="form-control col-md-7 col-xs-12" name="role" type="text" maxlength="30" minlength="3">
                                        </div>
                                    </div>
            						
            						
            						<div class="form-group">
            						    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{trans('app.MenuPermission')}} :</label>
            						    <div class="col-md-6 col-sm-6 col-xs-12" style="padding:0px;">
            						        @foreach($allmenu as $menu)
            							 	<div class="col-sm-6">
            									<input type="checkbox" id="{{$menu->id}}" name="menuid[]" value="{{$menu->id}}"  data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">&nbsp;&nbsp;&nbsp;{{trans('app.'.$menu->name)}}<br><br>
            							     </div>
            							    @endforeach
            						    </div>
            						</div>  
                                </div>

                                @foreach($current_language as $alllang)
                                    @if($alllang != get_defaultlanguage())
                                        <div class="tab-pane" id="{{$alllang}}">
                                            <input type="hidden" name="langcode[]" value="{{$alllang}}" class="langcode">
                                            <br><br>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{trans('app.Role')}}<p class="small-label">({{get_language_name($alllang)}})</p></label>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="trans_role_{{$alllang}}" class="form-control col-md-7 col-xs-12" name="trans_role[]" type="text" maxlength="50" minlength="3">
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
                                    <a href="{!! url('admin/roles') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> {{trans('app.Cancel')}}</a>
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

    $(document).ready(function(){

        $('#role_form').validate({
            rules:{
               
				role:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
					remote: {
                        type: 'post',
                        url: "{{ URL('admin/existrole') }}",
                        async: false,
                        async:false,
                        data: {
                            role: function () 
                            {
                                return $("input[name='role']").val();
                            },
                            "_token": "{{ csrf_token() }}"  
                        },

                        async:false
                       //delay: 1000
                    }
                }
            },
            messages:{
                role:{
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
            if ($("#role_form").valid()) {
                $('.store_lang').css({'pointer-events':'unset', 'opacity':'1'});
            } else {
                $('.store_lang').css({'pointer-events':'none', 'opacity':'0.5'});
            }
        });  

    });
</script>
@stop