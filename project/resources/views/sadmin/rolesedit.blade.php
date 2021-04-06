@extends('sadmin.includes.master-sadmin2')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>Roles Section</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="{!! url('sadmin/roles') !!}">Roles Section</a></li>
        <li class="breadcrumb-item active">Manage Role</li>
      </ul>
    </div>
  </div>
</div>
<div class="container-fluid">
            <!-- Page Content -->
  <div class="panel panel-default">
    <div class="panel-body">
      <div id="res">
          @if(Session::has('message'))
              <div class="alert alert-success alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  {{ Session::get('message') }}
              </div>
          @endif
      </div>
      <form method="POST" action="{{url('sadmin/roles')}}/{{$roles->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="state_form">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$roles->id}}">
              <input type="hidden" name="_method" value="PATCH">

        <div class="row clearfix">
          <div class="col-lg-12">
            <div class="card">
              <div class="body">
                <div class="prtm-block min-height-505">
                  <div class="form-horizontal"> 
                        
                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Role<span class="required">*</span><p class="small-label">(In Any Language)</p></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="role" class="form-control col-md-7 col-xs-12" name="role" placeholder="Enter Role Name" type="text" maxlength="30" minlength="3" value="{{$roles->role}}">
                        </div>
                      </div>
                    </div>

						        <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Menu Permission<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <div class="row">
                          
                            <div class="col-md-6 col-sm-6 col-xs-12" style="padding:0px; display: contents;">
                              @foreach($allmenu as $menu)
                                @if(in_array($menu->id, $menuids))
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                  <input type="checkbox" id="{{$menu->id}}" checked name="menuid[]" value="{{$menu->id}}"  data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">&nbsp;&nbsp;&nbsp;{{$menu->name}}<br><br>
                                </div>
                                @else
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                  <input type="checkbox" id="{{$menu->id}}" name="newmenuid[]" value="{{$menu->id}}"  data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">&nbsp;&nbsp;&nbsp;{{$menu->name}}<br><br>
                                </div>
                                @endif
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
            </div>  
          </div>    
          <div class="ln_solid"></div>
          <div class="col-md-12 col-lg-12">
              <div class="card">
                <div class="body" style="float: right;">
                  <button type="submit" class="btn btn-success">Submit</button>
                  <a href="{!! url('sadmin/roles') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
                </div>
              </div>
            </div>   
        </div> 
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    
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