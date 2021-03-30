@extends('sadmin.includes.master-sadmin')



@section('content')



    <div class="prtm-content-wrapper">

        <div class="prtm-content">

            <div class="prtm-page-bar">

                <ul class="breadcrumb">

                    <li class="breadcrumb-item text-cepitalize">

                        <h3>State</h3> </li>

                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}">Home</a></li>

                    <li class="breadcrumb-item">State</li>

                </ul>

            </div>

                

            <!-- Page Content -->

            <div class="panel panel-default">

                <div class="panel-body">

                    <div id="response">

                        @if(Session::has('message'))

                            <div class="alert alert-success alert-dismissable">

                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                                {{ Session::get('message') }}

                            </div>

                        @endif

                    </div>
                    <div class="prtm-block-title mrgn-b-lg">

                        <div class="caption" style="width: 100%;margin-bottom: 50px;">

                            <a href="{!! url('sadmin/state/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New State</a>



                            <div class="pull-right">

                                <label class="control-label" >Select Country :</label>

                                <select name="country" id="country" class="form-control"  autocomplete="off">

                                    @foreach($country as $countries) { ?>  

                                        @if($countries->id == $cid)                    

                                        <option value="{{$countries->id}}" selected="selected">{{$countries->countryname}}</option>

                                        @else

                                        <option value="{{$countries->id}}">{{$countries->countryname}}</option>

                                        @endif

                                    @endforeach  

                                </select>

                            </div>

                            <!-- <a href="{!! url('sadmin/state/create') !!}" class="btn btn-primary btn-add pull-right" style="right: 0px;position: absolute;"><i class="fa fa-plus"></i> Add New State</a> -->

                        </div>

                    </div>

                    <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">

                        <thead>

                        <tr class="bg-primary">

                            <th>State Name</th>

                            <th>Status</th>

                            <th>Actions</th>

                        </tr>

                        </thead>

                        <tbody>

                            @foreach($state as $alldata)

                                <tr>

                                    <td>{{$alldata->statename}}</td>

                                    <td>

                                        @if($alldata->status == 1)

                                            <a href="{!! url('sadmin/state') !!}/status/{{$alldata->id}}/0" class="btn btn-success btn-xs">Active</a>

                                        @elseif($alldata->status == 0)

                                            <a href="{!! url('sadmin/state') !!}/status/{{$alldata->id}}/1" class="btn btn-danger btn-xs">Deactive</a>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="dropdown display-ib">

                                            <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>

                                            <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">

                                                <li>

                                                    <a href="{!! url('sadmin/state') !!}/{{$alldata->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>

                                                </li>

                                                <li>

                                                    <a href="#" onclick="return delete_data('{{$alldata->id}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a>

                                                </li>

                                            </ul>  

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- /.container-fluid -->

    </div>

    <!-- /#page-wrapper -->



@stop



@section('footer')



<script type="text/javascript">



    $(document).ready(function(){

        var countryval = $('#country').val();

      

        $("#country").change(function(){    

            var cval = $(this).val();

            document.location = "{{url('/')}}/sadmin/state/statelist/"+cval;          

        }); 

    });



    function delete_data(reportid)

    {

        if(confirm('Are You sure You want to Delete ?'))

        {

            window.location = "{{url('/')}}/sadmin/state/delete/"+reportid;

            return true;

        }

        else

        {

            return false;

        }

    }



</script>



@stop