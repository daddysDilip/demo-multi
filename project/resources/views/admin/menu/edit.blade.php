@extends('admin.includes.master-admin')
@section('content')
  <div class="row">
    <div class="col-md-8">  
      <div class="well">
        <p class="lead"><a href="{{ url('admin/navigation')}}" class="btn btn-default pull-right">Go Back</a> Menu:</p>
		 <form action="{{url('admin/navigation/edit')}}/{{$item->id}}" method="POST" id="contact_form">
		{{csrf_field()}}
		<div class="form-group">
		    <label for="title" class="col-lg-2 control-label">Title</label>
		    <div class="col-lg-10">
			<input id="title" class="form-control" name="title" placeholder="Enter Title Name" type="text" maxlength="30" minlength="3" value="{{$item->title}}">
		     
		    </div>
		</div>
		<div class="form-group">
		    <label for="label" class="col-lg-2 control-label">Label</label>
		    <div class="col-lg-10">
		      <input id="label" class="form-control" name="label" placeholder="Enter Label Name" type="text" maxlength="30" minlength="3" value="{{$item->label}}">
		    </div>
		</div>
		<div class="form-group">
		    <label for="url" class="col-lg-2 control-label">URL</label>
		    <div class="col-lg-10">
		     <input id="url" class="form-control" name="url" placeholder="Enter Url" type="text" value="{{$item->url}}">
		    </div>
		</div>
		<div class="form-group">
		    <div class="col-md-6 col-md-offset-6 text-right">
		      <button type="submit" class="btn btn-lg btn-default">Update item</button>
		    </div>
		</div>
		</form>
      </div>
    </div>
    
  </div>
@stop

