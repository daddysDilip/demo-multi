@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Role Section</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/roles') !!}">Role Section</a></li>
                    <li class="breadcrumb-item">Manage Role</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{{url('sadmin/roles')}}/{{$roles->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="role_form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$roles->id}}">
                        <input type="hidden" name="_method" value="PATCH">
						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Role<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="role" class="form-control col-md-7 col-xs-12" name="role" value="{{$roles->role}}" placeholder="Enter Role Name" type="text" maxlength="30" minlength="3">
                            </div>
                        </div>
						
						<div class="form-group">
						  <label class="control-label col-md-3 col-sm-3 col-xs-12">Menu Permission :</label>
						  <div class="col-md-6 col-sm-6 col-xs-12" style="padding:0px;">
						     @foreach($allmenu as $menu)
							  @if(in_array($menu->id, $menuids))
								  
							  <div class="col-sm-6">
									<input type="checkbox" id="{{$menu->id}}" name="menuid[]" checked value="{{$menu->id}}"  data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>" >&nbsp;&nbsp;&nbsp;{{$menu->name}}<br><br>
							    </div>
								@else
									<div class="col-sm-6">
									<input type="checkbox" id="{{$menu->id}}" name="newmenuid[]" value="{{$menu->id}}"  data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>" >&nbsp;&nbsp;&nbsp;{{$menu->name}}<br><br>
							     </div>
								@endif
							  
							 	
							  @endforeach
						    
						  </div>
						</div>
                        
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update Role</button>
                                <a href="{!! url('sadmin/roles') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

        $('#role_form').validate({
            rules:{
                
				role:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
                    remote: {
                        type: 'post',
                        url: "{{ URL('sadmin/existrole') }}",
                        async: false,
                        async:false,
                        data: {
                            role: function () 
                            {
                                return $("input[name='role']").val();
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
                }
            },
            messages:{
                role:{
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