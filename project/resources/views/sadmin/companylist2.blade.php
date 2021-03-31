@extends('sadmin.includes.master-sadmin2')



@section('content')



    
       <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Company
                
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Company</li>
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

                    
<!-- 
                     <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">

                        <thead>
                            <tr class="bg-primary">
                                <th>Logo</th>
                                <th>Company</th>
                                <th>Store Url</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($company as $allcompany)
                            <tr>

                                <td> @if($allcompany->company_logo != '') <img class="img-responsive display-ib img-circle" width="50" height="50" src="{{url('/')}}/assets/images/company/{{$allcompany->company_logo}}">
								@else
								<img class="img-responsive display-ib img-circle"  src="{!! url('assets/images/company') !!}/{{$settings[0]->logo}}" width="50" height="50"> 
                                @endif

                                </td></td>

                                <td>{{ $allcompany->comapany_name }}</td>

                                <td><a href="{{ $allcompany->storeurl }}/admin" target="_blank" class="store_list">{{ $allcompany->storeurl }}</a> <img src="{{ $allcompany->storeurl }}/setcookie?id={{ Session::getId() }}" style="display:none;" /></td>
                                <td>{{ $allcompany->company_email }}</td>

                                <td>{{ $allcompany->company_phone }}</td>

                                <td>

                                    @if($allcompany->status == 1)

                                        <a href="{!! url('sadmin/company') !!}/status/{{$allcompany->id}}/0" class="btn btn-success btn-xs">Active</a>

                                    @elseif($allcompany->status == 0)

                                        <a href="{!! url('sadmin/company') !!}/status/{{$allcompany->id}}/1" class="btn btn-danger btn-xs">Deactive</a>

                                    @endif

                                </td>

                                <td>

                                    <div class="dropdown display-ib">

                                        <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>

                                        <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                            <li>
                                                <a href="{!! url('/')!!}/sadmin/company/{{$allcompany->id}}"><i class="fa fa-eye"></i> <span class="mrgn-l-sm">View </span> </a>
                                            </li>
											<li>
                                                <a href="{!! url('/')!!}/sadmin/company/{{$allcompany->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>
                                            </li> -->
                                      <!--        <li>
                                                <a href="#" onclick="return delete_data('{{$allcompany->id}}');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a>
                                            </li> -->
                                  <!--       </ul>  

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table> -->




                            <div class="row clearfix">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="header">
                                            <h2><strong>Exportable</strong> Examples </h2>
                                            <div class="prtm-block-title mrgn-b-lg">

                                            
                                            
                                        </div>
                                        <div class="caption">

                                                    <a href="{!! url('sadmin/company/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add Company</a>

                                                </div>

                                            </div>


                                    <div class="body">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="posts">
                                                <thead>  
                                                          <tr >
                                                            <th>Logo</th>
                                                            <th>Company</th>
                                                            <th>Store Url</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                </thead> 
                                        </table>
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

<input type="hidden" name="seesionid" value="{{Session::getId()}}">

@stop

@section('footer')




<script type="text/javascript">

    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('sadmin/allpostscompany') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [

                { "data": "company_logo"},
                { "data": "comapny"},
                { "data": "storeurl"},
                { "data": "email"},
                { "data": "phone"},
                { "data": "status"},
                { "data": "actions"},
            ]    

        });
    });
</script>

<script type="text/javascript">

    $('.store_list').click(function(){
        var sessionid = $('input[name=seesionid]').val();

        $.ajax({
            url: "{{ URL('setcookie') }}/",
            type: "get",
            async: false,
            data: {id:sessionid},
            success: function(data)
            {
                $('.loadDiv').load(' .loadDiv');
            },
        });
    });

    function delete_data(reportid)

    {

        if(confirm('Are You sure You want to Delete ?'))

        {

            window.location = "{{url('/')}}/sadmin/company/delete/"+reportid;

            return true;

        }

        else

        {

            return false;

        }

    }



    $(':input').change(function() {

        $(this).val($(this).val().trim());

    });

    

    $(document).ready(function(){



        $('#website_form').validate({

            rules:{

                cms_title:{

                    required:true,

                    minlength: 3,

                    maxlength: 30,

                },

                cms_text:{ 

                    minlength: 3,

                    maxlength: 255,

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