@extends('sadmin.includes.master-sadmin2')

@section('content')

<style type="text/css">
    textarea
    {
        resize: none;
    }
</style>

        <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Tickets 
                
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Tickets</li>
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
                    <!-- /.start -->
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs  nav-tabs-primary">
                            <li class="nav-item"><a class="nav-link active" href="#all" data-toggle="tab" aria-expanded="true">All &nbsp;<span class="badge badge-inverse">{{ \App\Ticket::count() }}</span></a>
                            </li>
                            <li class="nav-item"><a class="nav-link " href="#new" data-toggle="tab" aria-expanded="false">New &nbsp;<span class="badge badge-primary">{{ \App\Ticket::where('ticketstatus',1)->count() }}</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="#open" data-toggle="tab" aria-expanded="false">Open &nbsp;<span class="badge badge-info">{{ \App\Ticket::where('ticketstatus',2)->count() }}</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="#inprogress" data-toggle="tab" aria-expanded="false">In Progress &nbsp;<span class="badge badge-warning">{{ \App\Ticket::where('ticketstatus',3)->count() }}</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="#closed" data-toggle="tab" aria-expanded="false">Closed &nbsp;<span class="badge badge-success">{{ \App\Ticket::where('ticketstatus',4)->count() }}</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="#rejected" data-toggle="tab" aria-expanded="false">Rejected &nbsp;<span class="badge badge-danger">{{ \App\Ticket::where('ticketstatus',5)->count() }}</span></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xs-12">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="all">
                                <br>
                            <div class="card">
                                <div class="header">
                                    <h2><strong>All</strong> List </h2>
                                    <div class="prtm-block-title mrgn-b-lg">
                                    </div>
                                    
                                </div>
                                <div class="body">
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
                        </div>
                                
                            </div>
                            <div class="tab-pane" id="new">
                                <br>
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>New</strong> List </h2>
                                        <div class="prtm-block-title mrgn-b-lg">
                                        </div>
                                        
                                    </div>
                                    <div class="body">
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
                                </div>
                            </div>

                            <div class="tab-pane" id="open">
                                <br>
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>Open</strong> List </h2>
                                        <div class="prtm-block-title mrgn-b-lg">
                                        </div>
                                        
                                    </div>
                                    <div class="body">
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
                                </div>
                            </div>

                            <div class="tab-pane" id="inprogress">
                                <br>
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>In Progress</strong> List </h2>
                                        <div class="prtm-block-title mrgn-b-lg">
                                        </div>
                                        
                                    </div>
                                    <div class="body">
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
                                </div>
                            </div>

                            <div class="tab-pane" id="closed">
                                <br>
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>Closed</strong> List </h2>
                                        <div class="prtm-block-title mrgn-b-lg">
                                        </div>
                                        
                                    </div>
                                    <div class="body">
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
                                </div>
                            </div>

                            <div class="tab-pane" id="rejected">
                                <br>
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>Rejected</strong> List </h2>
                                        <div class="prtm-block-title mrgn-b-lg">
                                        </div>
                                        
                                    </div>
                                    <div class="body">
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
                    </div>
                </div>
                <!-- /.end -->
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    
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