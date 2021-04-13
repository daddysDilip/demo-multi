@extends('sadmin.includes.master-sadmin2')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>City</h2>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <ul class="breadcrumb float-md-right">
        <li class="breadcrumb-item"><a href="{!! url('sadmin/dashboard') !!}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li class="breadcrumb-item active">City</li>
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
      <div class="row clearfix">
        <div class="col-lg-12">
          <div class="card">
            
            <div class="prtm-block-title mrgn-b-lg">
              <div class="caption" style="width: 100%;margin-bottom: 50px;">
                <a href="{!! url('sadmin/city/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New City</a>
                <div class="pull-right">
                  <label class="control-label" >Select State :</label>
                  <select name="state" id="state" class="form-control"  autocomplete="off" style="width: 200px;">									
                    @foreach($state as $states)                                          
                      @if($states->id == $sid)
                        <option value="{{$states->id}}" selected="selected">{{$states->statename}}</option>
                      @else
                        <option value="{{$states->id}}">{{$states->statename}}</option>
                      @endif
                    @endforeach  
                  </select>
                </div>

                <div class="pull-right" style="margin-right: 20px;">
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

              </div>
            </div>
            <div class="body">
            <table class="table table-bordered table-striped table-hover dataTable js-exportable" cellspacing="0"  id="posts" width="100%">
              <thead>
                <tr class="">
                  <th>City Name</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($city as $alldata)
                  <tr>
                    <td>{{$alldata->cityname}}</td>
                    <td>
                      @if($alldata->status == 1)
                        <a href="{!! url('sadmin/city') !!}/status/{{$alldata->id}}/0" class="btn btn-success btn-xs">Active</a>
                      @elseif($alldata->status == 0)
                        <a href="{!! url('sadmin/city') !!}/status/{{$alldata->id}}/1" class="btn btn-danger btn-xs">Deactive</a>
                      @endif
                    </td>
                    <td>
                      <div class="dropdown display-ib">
                        <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>
                        <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                          <li>
                            <a href="{!! url('sadmin/city') !!}/{{$alldata->id}}/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>
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
    </div>
  </div>
</div>
</div>
@stop

@section('footer')

<script type="text/javascript">

    $(document).ready(function(){
         $("#country").change(function(){   

            var country = $('#country').val();  
            var op ='';
            $.ajax({
                type:'get',
                url:"{{url('/')}}/sadmin/city/statelist/"+country,
                //data:{id:1},
                success:function(res){
                    var stateval = res.state;
                    if(stateval == ''){
                       op +='<option value="">Select State</option>';
                    }else{
                        $.each(stateval,function(index,value){
                            op +='<option value="'+value.id+'">'+value.statename+'</option>';
                        });
                    }
                    
                    $('#state').html(op);
                    document.location = "{{url('/')}}/sadmin/city/citylist/"+country+"/"+stateval[0].id;          
                }

            });        
        }); 
      
        $("#state").change(function(){  
            var countryval = $('#country').val();  
            var sval = $(this).val();
            document.location = "{{url('/')}}/sadmin/city/citylist/"+countryval+"/"+sval;          
        }); 

    });

    function delete_data(reportid)
    {
        if(confirm('Are You sure You want to Delete ?'))
        {
            window.location = "{{url('/')}}/sadmin/city/delete/"+reportid;
            return true;
        }
        else
        {
            return false;
        }
    }
    $('#posts').DataTable({
      "order": [[ 1, "asc" ]], //or asc 
    });
</script>

@stop