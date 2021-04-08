@extends('sadmin.includes.master-sadmin2')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>language</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="{!! url('sadmin/language') !!}">language</a></li>
        <li class="breadcrumb-item active">Manage language</li>
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
      <form method="POST" action="{{url('sadmin/language')}}/{{$lang->id}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="language_form">
        {{csrf_field()}}

        <input type="hidden" name="id" value="{{$lang->id}}">
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="hidd_image" value="{{$lang->image}}">
        <div class="row clearfix">
          <div class="col-lg-12">
            <div class="card">
              <div class="body">
                <div class="prtm-block min-height-505">
                  <div class="form-horizontal">
                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Language Name<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Enter Language Name" type="text" maxlength="50" minlength="3" value="{{$lang->name}}">
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Language Code<span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="code" id="code" maxlength="10" minlength="3" value="{{$lang->code}}">
                        </div>
                      </div>
                    </div>
           
                    <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="countryid">Direction<span class="required">*</span></label>
                      </div>
                      <div class="col-md-5 col-sm-6 col-xs-5">
                        <select name="direction" class="form-control" id="direction">
                          <option value="left" @if($lang->direction == 'left') selected @endif>Left</option>
                          <option value="right" @if($lang->direction == 'right') selected @endif>Right</option>
                        </select>
                      </div>
                    </div>

                    <div class="item form-group">
                      @if($lang->image != '')
                      <input type="hidden" name="_method" value="PATCH">
                      <div class="row clearfix">
                        <label class="col-lg-3 col-md-3 col-sm-4 form-control-label"> Current Flag</label>
                          <div class="col-lg-5 col-md-6 col-sm-5">
                            <img src="{{url('/assets/images/language')}}/{{$lang->image}}" style="max-height: 250px;width: 50%;" alt="No Theme Image" class="my_image"><br>
                            <a href="javascript:void(0);" style="color: #ff0000;" class="delete_img"><i class="fa fa-trash"></i> Delete Flag Image</a>
                          </div>
                     </div>
                      @endif    
                        <div class="item form-group">
                           <div class="row clearfix">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@if($lang->image != '')Change Flag @else Flag @endif</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" accept="image/*" name="image">

                            </div>
                        </div>     
                    </div>
                  </div>    
                  <div class="row clearfix">
                      <div class="col-lg-3 col-md-3 col-sm-4 form-control-label">
                        <label for="email_address_2">Is Active?</label>
                      </div>
                      <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="form-group ">
                          @if($lang->status == 1)
                          <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                          @elseif($lang->status == 0)
                          <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="0" data-off="Deactive" >
                          @endif
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
                  <a href="{!! url('sadmin/language') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
                </div>
              </div>
            </div>   
        </div> 
      </form>              
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
    <!-- /#page-wrapper -->
@stop

@section('footer')
<script type="text/javascript">

/*bkLib.onDomLoaded(function() {
    new nicEditor({fullPanel : true}).panelInstance('content1');
});*/

$(':input').change(function() {
    $(this).val($(this).val().trim());
});

var id = $('input[name="id"]').val();

$(document).ready(function(){

    $('#language_form').validate({
        rules:{
            name:{
                required:true,
                minlength: 3,
                maxlength: 30,
                remote: {
                    type: 'post',
                    url: "{{ URL('sadmin/existlanguname') }}",
                    async: false,
                    async:false,
                    data: {
                        name: function () 
                        {
                            return $("input[name='name']").val();
                        },
                        id: function () 
                        {
                            return $("input[name='id']").val();
                        },
                        "_token": "{{ csrf_token() }}"  
                    },

                    async:false
                   //delay: 1000
                }
            },
            code:{
                required:true,
                minlength: 2,
                maxlength: 5,
                remote: {
                    type: 'post',
                    url: "{{ URL('sadmin/codelanguname') }}",
                    async: false,
                    async:false,
                    data: {
                        code: function () 
                        {
                            return $("input[name='code']").val();
                        },
                        id: function () 
                        {
                            return $("input[name='id']").val();
                        },
                        "_token": "{{ csrf_token() }}"  
                    },

                    async:false
                   //delay: 1000
                }
            },
        },
        messages:{
            name:{
                remote:"Already exist",
            },
            code:{
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

$('.delete_img').click(function(){
    $.ajax({
        url: "{{ URL('sadmin/language/languageimage') }}/"+id,
        type: "post",
        async: false,
        data: {"_token": "{{ csrf_token() }}"},
        success: function(data)
        {
            // $('.my_image').src('');
            $(".my_image").remove();
        },
    });
});

</script>
@stop