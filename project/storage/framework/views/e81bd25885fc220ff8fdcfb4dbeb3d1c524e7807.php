



<?php $__env->startSection('content'); ?>



    <div class="prtm-content-wrapper">

        <div class="prtm-content">

            <div class="prtm-page-bar">

                <ul class="breadcrumb">

                    <li class="breadcrumb-item text-cepitalize">

                        <h3>Company</h3> </li>

                    <li class="breadcrumb-item"><a href="<?php echo url('sadmin/dashboard'); ?>">Home</a></li>

                    <li class="breadcrumb-item">Company</li>

                </ul>

            </div>



            <!-- Page Content -->

            <div class="panel panel-default">

                <div class="panel-body">

                    <div id="res">

                        <?php if(Session::has('message')): ?>

                            <div class="alert alert-success alert-dismissable">

                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                                <?php echo e(Session::get('message')); ?>


                            </div>

                        <?php endif; ?>

                    </div>

                    <div class="prtm-block-title mrgn-b-lg">

                        <div class="caption">

                            <a href="<?php echo url('sadmin/company/create'); ?>" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add Company</a>

                        </div>

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
                        <?php $__currentLoopData = $company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allcompany): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>

                                <td> <?php if($allcompany->company_logo != ''): ?> <img class="img-responsive display-ib img-circle" width="50" height="50" src="<?php echo e(url('/')); ?>/assets/images/company/<?php echo e($allcompany->company_logo); ?>">
								<?php else: ?>
								<img class="img-responsive display-ib img-circle"  src="<?php echo url('assets/images/company'); ?>/<?php echo e($settings[0]->logo); ?>" width="50" height="50"> 
                                <?php endif; ?>

                                </td></td>

                                <td><?php echo e($allcompany->comapany_name); ?></td>

                                <td><a href="<?php echo e($allcompany->storeurl); ?>/admin" target="_blank" class="store_list"><?php echo e($allcompany->storeurl); ?></a> <img src="<?php echo e($allcompany->storeurl); ?>/setcookie?id=<?php echo e(Session::getId()); ?>" style="display:none;" /></td>
                                <td><?php echo e($allcompany->company_email); ?></td>

                                <td><?php echo e($allcompany->company_phone); ?></td>

                                <td>

                                    <?php if($allcompany->status == 1): ?>

                                        <a href="<?php echo url('sadmin/company'); ?>/status/<?php echo e($allcompany->id); ?>/0" class="btn btn-success btn-xs">Active</a>

                                    <?php elseif($allcompany->status == 0): ?>

                                        <a href="<?php echo url('sadmin/company'); ?>/status/<?php echo e($allcompany->id); ?>/1" class="btn btn-danger btn-xs">Deactive</a>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <div class="dropdown display-ib">

                                        <a href="javascript:;" class="mrgn-l-xs" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-cog fa-lg base-dark"></i></a>

                                        <ul class="dropdown-menu dropdown-arrow dropdown-menu-right">
                                            <li>
                                                <a href="<?php echo url('/'); ?>/sadmin/company/<?php echo e($allcompany->id); ?>"><i class="fa fa-eye"></i> <span class="mrgn-l-sm">View </span> </a>
                                            </li>
											<li>
                                                <a href="<?php echo url('/'); ?>/sadmin/company/<?php echo e($allcompany->id); ?>/edit"><i class="fa fa-edit"></i> <span class="mrgn-l-sm">Edit </span> </a>
                                            </li> -->
                                      <!--        <li>
                                                <a href="#" onclick="return delete_data('<?php echo e($allcompany->id); ?>');"><i class="fa fa-trash"></i> <span class="mrgn-l-sm">Delete </span></a>
                                            </li> -->
                                  <!--       </ul>  

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table> -->




                              <div class="row">
            <div class="col-xs-12">
                <div class="box-body table-responsive">


                      <table class="table table-bordered" id="posts">
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

<input type="hidden" name="seesionid" value="<?php echo e(Session::getId()); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>




<script type="text/javascript">

    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "<?php echo e(url('sadmin/allpostscompany')); ?>",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "<?php echo e(csrf_token()); ?>"}
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
            url: "<?php echo e(URL('setcookie')); ?>/",
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

            window.location = "<?php echo e(url('/')); ?>/sadmin/company/delete/"+reportid;

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



<?php $__env->stopSection(); ?>
<?php echo $__env->make('sadmin.includes.master-sadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp\www\on_git\multi-ecomm\project\resources\views/sadmin/companylist.blade.php ENDPATH**/ ?>