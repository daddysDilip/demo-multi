@extends('admin.includes.master-admin')

@section('content')

@php $userid = get_user_id(); @endphp

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Ticket - #{{$ticket->id}}</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/tickets') !!}">Ticket</a></li>
                    <li class="breadcrumb-item">Ticket - #{{$ticket->id}}</li>
                </ul>
            </div>
               
            <!-- Page Content -->
            <div class="form-style">
                <div class="row">
                    <div class="col-md-12">

                        <div class="typography-widget col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="prtm-block">
                                <div class="prtm-block-title mrgn-b-lg">
                                    <h3>Ticket - #{{$ticket->id}}</h3>
                                    <p></p>
                                </div>
                                <div class="des-style">
                                    <dl>
                                        <dt class="mrgn-b-xs">Ticket Title</dt>
                                        <dd>{{$ticket->title}}</dd><br>
                                    </dl>
                                </div>
                                <h4>Content</h4>
                                <hr>
                                <div class="des-style-2">
                                    <p>{!! $ticket->content !!}</p>
                                </div>
                            </div>
                        </div>

                        <div class="typography-widget col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="prtm-block">
                                <div class="prtm-block-title">
                                    <h3>
                                        @if($settings[0]->logo != '')
                                            <img src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" class="square-50 display-ib img-circle" alt="User Image">{{$company[0]->comapany_name}}
                                        @else
                                            <img class="img-responsive display-ib img-circle"  src="{!! url('assets/images/company') !!}/logo.png" width="50" height="50">
                                        @endif
                                    </h3>
                                    <p></p>
                                    <div class="prtm-block pos-relative">
                                        <div class="prtm-block-title mrgn-b-md">
                                            <div class="caption">
                                                <h5 class="text-capitalize"></h5> 
                                            </div>
                                        </div>
                                        <div class="prtm-block-content">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-9">

                                                    <div class="row mrgn-b-md">
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span>Ticket #:</span> </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">Ticket - #{{$ticket->id}} </span> </div>
                                                    </div>

                                                    <div class="row mrgn-b-md">
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span>Craeted Date &amp; Time : </span> </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$ticket->created_at->format('jS, M Y H:i:sA')}}</span> </div>
                                                    </div>

                                                    <div class="row mrgn-b-md">
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span>Priority : </span> </div>

                                                        @if($ticket->priority == 1)
                                                            <?php $prior = 'info'; ?>
                                                        @elseif($ticket->priority == 2)
                                                            <?php $prior = 'warning'; ?>
                                                        @elseif($ticket->priority == 3)
                                                            <?php $prior = 'danger'; ?>
                                                        @endif
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span class="label label-<?php echo $prior; ?> btn-rounded font-sm">{{ \App\TicketPriority::find($ticket->priority)->name }}</span> </div>
                                                    </div>

                                                    <div class="row mrgn-b-md">
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span>Last Updated : </span> </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span class="value">{{$ticket->updated_at->format('jS, M Y H:i:sA')}}</span> </div>
                                                    </div>

                                                    <div class="row mrgn-b-md">
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span>Status : </span> </div>
                                                        @if($ticket->ticketstatus == 1)
                                                            <?php $status = 'primary'; ?>
                                                        @elseif($ticket->ticketstatus == 2)
                                                            <?php $status = 'info'; ?>
                                                        @elseif($ticket->ticketstatus == 3)
                                                            <?php $status = 'warning'; ?>
                                                        @elseif($ticket->ticketstatus == 4)
                                                            <?php $status = 'success'; ?>
                                                        @elseif($ticket->ticketstatus == 5)
                                                            <?php $status = 'danger'; ?>
                                                        @endif
                                                        <div class="col-xs-6 col-sm-6 col-md-6"> <span class="label label-<?php echo $status; ?> btn-rounded font-sm">{{ \App\TicketStatus::find($ticket->ticketstatus)->name }}</span> </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-offset-3 col-xs-12 col-sm-12 col-md-12 col-lg-9">  
                        <div class="prtm-block">
                            <div class="horizontal-form-style">

                                <div class="prtm-block-title mrgn-b-lg">
                                    <h3>Reply To Ticket </h3>
                                    <p></p>
                                </div>

                                <div class="chat-window pad-l-lg  clearfix">
                                    <div class="tab-content mrgn-b-lg">
                                        <div class="tab-pane active" id="tab-panel-1">
                                            <div class="prtm-messages-list">
                                            @if(count($treply) != null)
                                                @foreach($treply as $reply)

                                                    @php $ticketfiles = get_ticket_files($reply->id); @endphp

                                                    @if($userid == $reply->userid)
                                                    <div class="sent-msg mrgn-b-lg">
                                                        <div class="clearfix">

                                                            <div class="thumb-wid mrgn-l-sm pull-right"> 
                                                                @if($settings[0]->logo != '')
                                                                <img class="img-responsive img-circle" src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" alt="message reciever image" style="height: 80px;width: 150px;"> 
                                                                @else
                                                                <img class="img-responsive img-circle" src="{!! url('assets/images/company') !!}/logo.png" alt="message reciever image" style="height: 80px;width: 150px;"> 
                                                                @endif
                                                            </div>

                                                            <div class="thumb-content">
                                                                <div class="pad-all-md mrgn-b-xs pos-relative msg-wrap fw-light arrow-box-right">
                                                                    <p class="mrgn-all-none">{{$reply->content}}</p>
                                                                </div>

                                                                <div class="clearfix">  
                                                                    <span class="pull-left base-dark display-ib">{{\App\User::find($reply->userid)->name}}</span> <span class="pull-right display-ib"><?php echo date("jS, M Y H:i:sA",strtotime($reply->timestamp)); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        @if(count($ticketfiles) != '')
                                                        <h4>Attached Files</h4>
                                                        <table role="presentation" class="table table-striped">
                                                            <tbody class="files">
                                                                @foreach($ticketfiles as $allfile)
                                                                <tr class="template-upload fade in">
                                                                    <td>
                                                                        <span class="preview"><a href="{{url('/')}}/assets/images/ticket/{{$allfile->filename}}" target="_blank"><p class="name">{{$allfile->filename}}</p></a></span>
                                                                    </td>
                                                                    <td>
                                                                        <p class="name">{{$allfile->filetype}}</p>
                                                                        <strong class="error text-danger"></strong>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @endif
                                                    @else 
                                                    <div class="mrgn-b-lg">
                                                        <div class="clearfix">
                                                            @php $sadminlogo = \App\Settings::where('company_id',0)->get(); @endphp
                                                            <div class="thumb-wid mrgn-r-sm pull-left"> <img class="img-responsive img-circle" src="{!! url('assets/images/company') !!}/{{$sadminlogo[0]->logo}}" alt="message reciever image" style="height: 80px;width: 150px;"></div>

                                                            <div class="thumb-content pull-left">
                                                                <div class="pad-all-md mrgn-b-xs msg-wrap arrow-box pos-relative">
                                                                    <p class="mrgn-all-none">{{$reply->content}}</p>
                                                                </div>

                                                                <div class="clearfix"> 
                                                                    <span class="pull-left base-dark display-ib"></span>
                                                                    {{\App\User::find($reply->userid)->name}}
                                                                    <span class="pull-right display-ib"><?php echo date("jS, M Y H:i:sA",strtotime($reply->timestamp)); ?></span> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        @if(count($ticketfiles) != '')
                                                        <h4>Attached Files</h4>
                                                        <table role="presentation" class="table table-striped">
                                                            <tbody class="files">
                                                                @foreach($ticketfiles as $allfile)
                                                                <tr class="template-upload fade in">
                                                                    <td>
                                                                        <span class="preview"><a href="{{url('/')}}/assets/images/ticket/{{$allfile->filename}}" target="_blank"><p class="name">{{$allfile->filename}}</p></a></span>
                                                                    </td>
                                                                    <td>
                                                                        <p class="name">{{$allfile->filetype}}</p>
                                                                        <strong class="error text-danger"></strong>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{action('TicketController@addreply',$subdomain_name)}}" method="post" enctype="multipart/form-data" id="reply_ticket">
                                        {{csrf_field()}}

                                        <div class="send-msg-form col-sm-12 col-xs-12 col-md-12 col-lg-12 pull-right pad-all-none">

                                            <div class="form-group clearfix">
                                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
                                                    <textarea id="content1" class="pad-all-sm form-control mrgn-b-sm" name="content" placeholder="Write a message" style="height: 250px;" maxlength="255"></textarea>
                                                </div>
                                            </div>

                                            <input name="ticketid" type="hidden" value="{{$ticket->id}}">

                                            <div class="form-group clearfix">
                                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
                                                    <label class="file-field-label">
                                                        <input type="file" id="file" name="files[]" accept="image/*" multiple />
                                                        <span><i class="fa fa-paperclip mrgn-r-sm" aria-hidden="true"></i></span> Attach Files
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group clearfix">
                                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                    <input class="btn btn-primary btn-lg btn-block pad-all-sm" name="send_message" value="Send" type="submit">
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                    <input class="btn btn-danger btn-lg btn-block pad-all-sm" value="Cancel" type="reset" id="reset"> 
                                                </div>
                                            </div>

                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@stop

@section('footer')

<script type="text/javascript">

    $('#reset').click(function(){
        $('.nicEdit-main').html('');
    });

    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('content1');
    });

    $(':input').change(function() {
        $(this).val($(this).val().trim());
    });

    $(document).ready(function(){
        $('#reply_ticket').validate({
            ignore: [],
            rules:{
                content:{
                    required: true,
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
