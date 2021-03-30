@extends('admin.includes.master-admin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize"><h3>Tickets</h3></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/tickets') !!}">Tickets</a></li>
                    <li class="breadcrumb-item">Manage Tickets</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="response"></div>
                    <form method="POST" action="{!! action('TicketController@store',$subdomain_name) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="ticket_form">
                        {{csrf_field()}}

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ticket Title<span class="required">*</span>
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="title" class="form-control col-md-7 col-xs-12" name="title" placeholder="Enter Ticket Title" type="text" maxlength="30" minlength="3">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Priority<span class="required">*</span>

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="priority" id="priority" required>
                                    <option value="">Select Priority</option>
                                    @foreach($tpriority as $alldata)
                                        <option value="{{$alldata->id}}">{{$alldata->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Status<span class="required">*</span>

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="ticketstatus" id="ticketstatus" required>
                                    <option value="">Select Status</option>
                                    @foreach($tstatus as $alldata)
                                        <option value="{{$alldata->id}}">{{$alldata->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

						<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Description
                                <p class="small-label">(In Any Language)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea id="content1" class="form-control col-md-7 col-xs-12" name="content" placeholder="Enter Description" type="text" rows="10" cols="50"></textarea>
                            </div>
                        </div>
                       
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Add Featured Image</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="file" accept="image/*" name="image"/>
                            </div>
                        </div>
						
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Is Active</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" data-toggle="toggle" data-on="Active" name="status" value="1" data-off="Deactive" checked>
                            </div>
                        </div>
                        
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Add New Ticket</button>
                                <a href="{!! url('admin/tickets') !!}" class="btn btn-danger btn-back"><i class="fa fa-arrow-left"></i> Cancel</a>
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

    $(document).ready(function(){

        $('#ticket_form').validate({
            rules:{
                title:{
                    required:true,
                    minlength: 3,
                    maxlength: 30,
			
                },
				priority:{
                    required:true,
                },
                ticketstatus:{
                    required:true,
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