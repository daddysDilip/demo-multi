@extends('admin.includes.master-admin')

@section('content')
@php $companyid = get_company_id(); @endphp
<style type="text/css">
    textarea
    {
        resize: none;
    }
</style>

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Tickets</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Tickets</li>
                </ul>
            </div>

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
                    <div class="prtm-block-title mrgn-b-lg">
                        <div class="caption">
                            <a href="{!! url('admin/tickets/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Ticket</a>
                        </div>
                    </div>
                    <!-- /.start -->
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#all" data-toggle="tab" aria-expanded="true">All &nbsp;<span class="badge badge-inverse">{{ \App\Ticket::where('company_id',$companyid)->count() }}</span></a>
                            </li>
                            <li><a href="#new" data-toggle="tab" aria-expanded="false">New &nbsp;<span class="badge badge-primary">{{ \App\Ticket::where('ticketstatus',1)->where('company_id',$companyid)->count() }}</span></a></li>
                            <li><a href="#open" data-toggle="tab" aria-expanded="false">Open &nbsp;<span class="badge badge-info">{{ \App\Ticket::where('ticketstatus',2)->where('company_id',$companyid)->count() }}</span></a></li>
                            <li><a href="#inprogress" data-toggle="tab" aria-expanded="false">In Progress &nbsp;<span class="badge badge-secondary">{{ \App\Ticket::where('ticketstatus',3)->where('company_id',$companyid)->count() }}</span></a></li>
                            <li><a href="#closed" data-toggle="tab" aria-expanded="false">Closed &nbsp;<span class="badge badge-success">{{ \App\Ticket::where('ticketstatus',4)->where('company_id',$companyid)->count() }}</span></a></li>
                            <li><a href="#rejected" data-toggle="tab" aria-expanded="false">Rejected &nbsp;<span class="badge badge-danger">{{ \App\Ticket::where('ticketstatus',5)->where('company_id',$companyid)->count() }}</span></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xs-12">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="all">
                                <br>

                                <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ticket as $allticket)

                                            @if($allticket->priority == 1)
                                                <?php $priority = 'info'; ?>
                                            @elseif($allticket->priority == 2)
                                                <?php $priority = 'warning'; ?>
                                            @elseif($allticket->priority == 3)
                                                <?php $priority = 'danger'; ?>
                                            @endif

                                            @if($allticket->ticketstatus == 1)
                                                <?php $status = 'primary'; ?>
                                            @elseif($allticket->ticketstatus == 2)
                                                <?php $status = 'info'; ?>
                                            @elseif($allticket->ticketstatus == 3)
                                                <?php $status = 'warning'; ?>
                                            @elseif($allticket->ticketstatus == 4)
                                                <?php $status = 'success'; ?>
                                            @elseif($allticket->ticketstatus == 5)
                                                <?php $status = 'danger'; ?>
                                            @endif

                                            <tr>
                                                <td>{{$allticket->id}}</td> 
                                                <td><span class="label label-<?php echo $status; ?> btn-rounded">{{ \App\TicketStatus::find($allticket->ticketstatus)->name }}</span></td> 
                                                <td>{{$allticket->title}}</td> 
                                                <td><span class="label label-<?php echo $priority; ?> btn-default">{{ \App\TicketPriority::find($allticket->priority)->name }}</span></td>
                                                <td>{{$allticket->created_at->format('d/m/Y H:i a')}}</td> 
                                                <td><a href="tickets/{{$allticket->id}}"><i class="fa fa-cog fa-lg base-dark" aria-hidden="true"></i></a></td> 
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                            <div class="tab-pane" id="new">
                                <br>

                                <table class="table table-striped table-bordered tickettable" cellspacing="0" id="example" width="100%">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ticket as $allticket)
                                        @if($allticket->ticketstatus == 1)
                                            @if($allticket->priority == 1)
                                                <?php $priority = 'info'; ?>
                                            @elseif($allticket->priority == 2)
                                                <?php $priority = 'warning'; ?>
                                            @elseif($allticket->priority == 3)
                                                <?php $priority = 'danger'; ?>
                                            @endif

                                            <tr>
                                                <td>{{$allticket->id}}</td> 
                                                <td><span class="label label-primary btn-rounded">{{ \App\TicketStatus::find($allticket->ticketstatus)->name }}</span></td> 
                                                <td>{{$allticket->title}}</td> 
                                                <td><span class="label label-<?php echo $priority; ?> btn-default">{{ \App\TicketPriority::find($allticket->priority)->name }}</span></td>
                                                <td>{{$allticket->created_at->format('d/m/Y H:i a')}}</td> 
                                                <td><a href="tickets/{{$allticket->id}}"><i class="fa fa-cog fa-lg base-dark" aria-hidden="true"></i></a></td> 
                                            </tr> 
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="open">
                                <br>

                                <table class="table table-striped table-bordered tickettable" cellspacing="0" id="example" width="100%">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ticket as $allticket)
                                        @if($allticket->ticketstatus == 2)
                                            @if($allticket->priority == 1)
                                                <?php $priority = 'info'; ?>
                                            @elseif($allticket->priority == 2)
                                                <?php $priority = 'warning'; ?>
                                            @elseif($allticket->priority == 3)
                                                <?php $priority = 'danger'; ?>
                                            @endif

                                            <tr>
                                                <td>{{$allticket->id}}</td> 
                                                <td><span class="label label-info btn-rounded">{{ \App\TicketStatus::find($allticket->ticketstatus)->name }}</span></td> 
                                                <td>{{$allticket->title}}</td> 
                                                <td><span class="label label-<?php echo $priority; ?> btn-default">{{ \App\TicketPriority::find($allticket->priority)->name }}</span></td>
                                                <td>{{$allticket->created_at->format('d/m/Y H:i a')}}</td> 
                                                <td><a href="tickets/{{$allticket->id}}"><i class="fa fa-cog fa-lg base-dark" aria-hidden="true"></i></a></td> 
                                            </tr> 
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="inprogress">
                                <br>

                                <table class="table table-striped table-bordered tickettable" cellspacing="0" id="example" width="100%">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ticket as $allticket)
                                        @if($allticket->ticketstatus == 3)
                                            @if($allticket->priority == 1)
                                                <?php $priority = 'info'; ?>
                                            @elseif($allticket->priority == 2)
                                                <?php $priority = 'warning'; ?>
                                            @elseif($allticket->priority == 3)
                                                <?php $priority = 'danger'; ?>
                                            @endif

                                            <tr>
                                                <td>{{$allticket->id}}</td> 
                                                <td><span class="label label-warning btn-rounded">{{ \App\TicketStatus::find($allticket->ticketstatus)->name }}</span></td> 
                                                <td>{{$allticket->title}}</td> 
                                                <td><span class="label label-<?php echo $priority; ?> btn-default">{{ \App\TicketPriority::find($allticket->priority)->name }}</span></td>
                                                <td>{{$allticket->created_at->format('d/m/Y H:i a')}}</td> 
                                                <td><a href="tickets/{{$allticket->id}}"><i class="fa fa-cog fa-lg base-dark" aria-hidden="true"></i></a></td> 
                                            </tr> 
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="closed">
                                <br>

                                <table class="table table-striped table-bordered tickettable" cellspacing="0" id="example" width="100%">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ticket as $allticket)
                                        @if($allticket->ticketstatus == 4)
                                            @if($allticket->priority == 1)
                                                <?php $priority = 'info'; ?>
                                            @elseif($allticket->priority == 2)
                                                <?php $priority = 'warning'; ?>
                                            @elseif($allticket->priority == 3)
                                                <?php $priority = 'danger'; ?>
                                            @endif

                                            <tr>
                                                <td>{{$allticket->id}}</td> 
                                                <td><span class="label label-success btn-rounded">{{ \App\TicketStatus::find($allticket->ticketstatus)->name }}</span></td> 
                                                <td>{{$allticket->title}}</td> 
                                                <td><span class="label label-<?php echo $priority; ?> btn-default">{{ \App\TicketPriority::find($allticket->priority)->name }}</span></td>
                                                <td>{{$allticket->created_at->format('d/m/Y H:i a')}}</td> 
                                                <td><a href="tickets/{{$allticket->id}}"><i class="fa fa-cog fa-lg base-dark" aria-hidden="true"></i></a></td> 
                                            </tr> 
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="rejected">
                                <br>
                                
                                <table class="table table-striped table-bordered tickettable" cellspacing="0" id="example" width="100%">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ticket as $allticket)
                                        @if($allticket->ticketstatus == 5)
                                            @if($allticket->priority == 1)
                                                <?php $priority = 'info'; ?>
                                            @elseif($allticket->priority == 2)
                                                <?php $priority = 'warning'; ?>
                                            @elseif($allticket->priority == 3)
                                                <?php $priority = 'danger'; ?>
                                            @endif

                                            <tr>
                                                <td>{{$allticket->id}}</td> 
                                                <td><span class="label label-danger btn-rounded">{{ \App\TicketStatus::find($allticket->ticketstatus)->name }}</span></td> 
                                                <td>{{$allticket->title}}</td> 
                                                <td><span class="label label-<?php echo $priority; ?> btn-default">{{ \App\TicketPriority::find($allticket->priority)->name }}</span></td>
                                                <td>{{$allticket->created_at->format('d/m/Y H:i a')}}</td> 
                                                <td><a href="tickets/{{$allticket->id}}"><i class="fa fa-cog fa-lg base-dark" aria-hidden="true"></i></a></td> 
                                            </tr> 
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.end -->
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

@stop

@section('footer')
<script type="text/javascript">

    $('.tickettable').DataTable();

    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('content1');
    });

    function delete_faqdata(reportid)
    {
        if(confirm('Are You sure You want to Delete ?'))
        {
            window.location = "faq/"+reportid+"/delete";
            return true;
        }
        else
        {
            return false;
        }
    }

</script>

@stop