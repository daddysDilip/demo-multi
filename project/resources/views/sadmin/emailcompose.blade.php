@extends('sadmin.includes.master-sadmin')

@section('content')

    <div class="prtm-content-wrapper">
        <div class="prtm-content">
            <div class="prtm-page-bar">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item text-cepitalize">
                        <h3>Mail Services</h3> </li>
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Email Compose</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-lg-6 col-md-6 col-sm-6 mail-content">
                        <div id="response">
                            @if(Session::has('error'))
                                <div class="alert alert-danger alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            @if(Session::has('success'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                        </div>

                        <form method="POST" action="{!! action('Sadmin\EmailcomposeController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="email_form">
                            {{csrf_field()}}

                            <div class="compose-header">
                                <div class="compose-field">
                                    <div class="compose-field-right">
                                        <div class="btn-group">
                                            <button class="btn btn-link link-muted collapsed cc_email" title="Show Cc" data-target="#cc" data-toggle="collapse" type="button" aria-expanded="false"> <small>Cc</small> </button>
                                            <button class="btn btn-link link-muted collapsed bcc_email" title="Show Bcc" data-target="#bcc" data-toggle="collapse" type="button" aria-expanded="false"> <small>Bcc</small> </button>
                                        </div>
                                    </div>
                                    <div class="compose-field-left">
                                        <button class="compose-label" type="button">To</button>
                                    </div>
                                    <div class="compose-field-body">
                                        <input class="compose-input" type="text" name="to" id="to" autocomplete="off" spellcheck="false"> 
                                    </div>
                                </div>
                                <div class="compose-fields mrgn-b-xs">
                                    <div class="collapse" id="cc" aria-expanded="false" style="height: 0px;">
                                        <div class="compose-field">
                                            <div class="compose-field-left">
                                            <button class="compose-label" type="button">Cc</button>
                                            </div>
                                            <div class="compose-field-body">
                                                <input class="compose-input" type="text" id="cc" autocomplete="off" spellcheck="false"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" id="bcc" aria-expanded="false" style="height: 0px;">
                                        <div class="compose-field">
                                            <div class="compose-field-left">
                                                <button class="compose-label" type="button">Bcc</button>
                                            </div>
                                            <div class="compose-field-body">
                                                <input class="compose-input" type="text" id="bcc" autocomplete="off" spellcheck="false"> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="compose-field">
                                    <div class="compose-field-body">
                                        <input class="compose-input" type="text" name="subject" placeholder="Add a subject"> 
                                    </div>
                                </div>

                                <div class="compose-body">
                                    <div class="compose-message pad-all-xs">
                                        <textarea name="message" id="content1" rows="10" cols="50"></textarea>
                                    </div>
                                    <div class="compose-actions">
                                        <button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp;Send</button>
                                        <button class="btn btn-inverse btn-lg discard_btn" type="reset"><i class="fa fa-times" aria-hidden="true"></i> &nbsp;Discard</button>
                                    </div>
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

    $('.cc_email').click(function(e){
        var menuItem = $(e.currentTarget);
        console.log(menuItem.attr("aria-expanded"));
        if(menuItem.attr("aria-expanded") == 'true')
        {
            $('input#cc').removeAttr('name','cc');
        }
        else
        {
            $('input#cc').attr('name','cc');
        }
       
    });

    $('.bcc_email').click(function(e){
        var menuItem = $(e.currentTarget);
        console.log(menuItem.attr("aria-expanded"));
        if(menuItem.attr("aria-expanded") == 'true')
        {
            $('input#bcc').removeAttr('name','bcc');
        }
        else
        {
            $('input#bcc').attr('name','bcc');
        }
       
    });

    $('.discard_btn').click(function(){
        $('.nicEdit-main').html('');
    });

    $(document).ready(function(){

        $.validator.addMethod('Validemail', function (value, element) {
            return this.optional(element) ||  value.match(/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/);
        }, "Please enter a valid email address.");

        $('#email_form').validate({
            rules:{
                to: 
                {
                    required: true,
                    Validemail: true
                },
                cc: 
                {
                    required: true,
                    Validemail: true
                },
                bcc: 
                {
                    required: true,
                    Validemail: true
                },
                subject: 
                {
                    required: true,
                    maxlength: 150,
                    minlength: 3,
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