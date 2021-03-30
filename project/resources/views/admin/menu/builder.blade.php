@extends('admin.includes.master-admin')

@section('content')

 <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Navigation </h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/navigation') !!}">Navigation Section</a></li>
                    <li class="breadcrumb-item">Manage Navigation</li>
                </ul>
            </div>
			
			 <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
					
			  <div class="row">
				<div class="col-md-6">  
				  <div class="well">
					<p class="lead"><a href="#newModal" class="btn btn-primary btn-add pull-right" data-toggle="modal"><span class="fa fa-plus"></span> Add menu item</a> Navigation:</p>
					<div class="dd" id="nestable">
					  {!! $menu !!}
					</div>

					<p id="success-indicator" style="display:none; margin-right: 10px;">
					  <span class="glyphicon glyphicon-ok"></span> Menu order has been saved
					</p>
				  </div>
				</div>
				<!--<div class="col-md-4">
				  <div class="well">
					<p>Drag items to move them in a different order</p>
				  </div>
				</div>-->
			  </div>
			</div>
			</div>
			
			 </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
  <!-- Create new item Modal -->
   <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
	    <form action="{{url('admin/navigation/new')}}" method="POST" id="navigation_form" class="form-horizontal form-label-left">
		{{csrf_field()}}
	    <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Add new navigation</h4>
          </div>
          <div class="modal-body">
		  
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="title" class="form-control" required name="title" placeholder="Enter Title Name" type="text" maxlength="30" minlength="3">
				</div>
			</div>
			
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Label</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="label" class="form-control" required name="label" placeholder="Enter Label Name" type="text" maxlength="30" minlength="3">
				</div>
			</div>
			
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Path</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="url" class="form-control" required  name="url" placeholder="Enter Url" type="text" >
				</div>
			</div>
			
            
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-primary">Create</button>
         </div>
         </form>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
  
  <!-- Delete item Modal -->
   <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
	   <form method="POST" action="{{url('admin/navigation/delete')}}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="delete_navigation_form">
          {{csrf_field()}}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this menu item?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <input type="hidden" name="delete_id" id="postvalue" value="" />
            <input type="submit" class="btn btn-danger" value="Delete Item" />
          </div>
          </form>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
   
   
   <!-- Edit item Modal -->
   <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
	    <form action="" method="POST" id="edit_navigation_form" class="form-horizontal form-label-left">
		{{csrf_field()}}
	    <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Edit new navigation</h4>
          </div>
          <div class="modal-body">
		  
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="edit_title" required class="form-control" name="title" placeholder="Enter Title Name" type="text" maxlength="30" minlength="3">
				</div>
			</div>
			
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Label</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="edit_label" required class="form-control" name="label" placeholder="Enter Label Name" type="text" maxlength="30" minlength="3">
				</div>
			</div>
			
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Path</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="edit_url" required class="form-control" name="url" placeholder="Enter Url" type="text" >
				</div>
			</div>
			
            
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-primary">Update</button>
         </div>
         </form>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
@stop

@section('footer')
<script type="text/javascript" src='{{ URL::asset("assets/vendor/nestable/jquery.nestable.js") }}'></script>
<script type="text/javascript">
$(function() {
  $('.dd').nestable({ 
    dropCallback: function(details) {
       
       var order = new Array();
       $("li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
         order[index] = $(elem).attr('data-id');
       });

       if (order.length === 0){
        var rootOrder = new Array();
        $("#nestable > ol > li").each(function(index,elem) {
          rootOrder[index] = $(elem).attr('data-id');
        });
       }

       $.post('{{url("admin/navigation/")}}', 
        { source : details.sourceId, 
          destination: details.destId, 
          order:JSON.stringify(order),
          rootOrder:JSON.stringify(rootOrder), 
          _token:"{{ csrf_token() }}"
        }, 
        function(data) {
         // console.log('data '+data); 
        })
       .done(function() { 
          $( "#success-indicator" ).fadeIn(100).delay(1000).fadeOut();
       })
       .fail(function() {  })
       .always(function() {  });
     }
   });

  $('.delete_toggle').each(function(index,elem) {
      $(elem).click(function(e){
        e.preventDefault();
        $('#postvalue').attr('value',$(elem).attr('rel'));
        $('#deleteModal').modal('toggle');
      });
  });
  
   $('.edit_toggle').each(function(index,elem) {
      $(elem).click(function(e){
        e.preventDefault();
		var title = $(this).data('title');
		var id = $(this).data('id');
		var label = $(this).data('label');
		var url = $(this).data('url');

		$("#edit_title").val(title);
		$("#edit_label").val(label);
		$("#edit_url").val(url);
		$('#edit_navigation_form').attr('action', "{{url('admin/navigation/edit')}}/"+id);
        //$('#postvalue').attr('value',$(elem).attr('rel'));
        $('#editModal').modal('toggle');
      });
  });
 
        $('#navigation_form').validate({
            rules:{
                title:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
			
                },
				label:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
				 },
				 url:{
					required:true 
				 }
            },
            messages:{
                name:{
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
		
		// 
		
		 $('#edit_navigation_form').validate({
            rules:{
                title:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
			
                },
				label:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
				 },
				 url:{
					required:true 
				 }
            },
            messages:{
                name:{
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