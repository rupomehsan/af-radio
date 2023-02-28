<?php $__env->startSection('data_count'); ?>
    
    <div class="content-heading">
        <div class="row">
            
            <div class="col-md-8 content-title">
                <span class="title">Manage Notification</span>
                <div class="title-line"></div>
            </div>
            
            
            <div class="col-md-4 text-right">
                

                <a href="/admin/notification" class="btn btn-outline-dark btn-sm"><span class="iconify"
                                                                                        data-icon="akar-icons:arrow-back-thick"></span>&nbsp; Back Notification</a>

            </div>
            

        </div>
    </div>
    

    
    <div class="row margin-top-40 create-body content-details">

        <?php
        $ses_msg = Session::has('success');
        if (!empty($ses_msg)) {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <p><i class="fa fa-bell-o fa-fw"></i> <?php echo Session::get('success'); ?></p>
        </div>
        <?php
        }//
        $ses_msg = Session::has('error');
        if (!empty($ses_msg)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <p><i class="fa fa-bell-o fa-fw"></i> <?php echo Session::get('error'); ?></p>
        </div>
        <?php
        }// ?>

        
        <div class="col-md-6 for-mobile" id="showMobileNotification">
            <form method="POST" enctype="multipart/form-data"
                  action="<?php echo e(URL::to('admin/notification/manage-notification-update')); ?>">
                <?php echo csrf_field(); ?>
                <input name="notification_type" type="hidden" value="mobile">


                <div class="row notification-manage-content-mobile">
                    <div class="col-md-10">
                        <div class="form-group margin-top-40">
                            <label for="mobileApiKey">OneSignal Api Key</label>
                            <input name="mobile_api_key" type="text" class="form-control create-form" id="mobileApiKey"
                                   placeholder="Api key" value="<?php echo $target->api_key ?? ''; ?>">
                            <span class="text-danger"><?php echo e($errors->first('mobile_api_key')); ?></span>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="form-group margin-top-40">
                            <label for="mobileApiId">OneSignal Api ID</label>
                            <input name="mobile_api_id" type="text" class="form-control create-form" id="mobileApiId"
                                   placeholder="Api ID" value="<?php echo $target->api_id ?? ''; ?>">
                            <span class="text-danger"><?php echo e($errors->first('mobile_api_id')); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 actions margin-top-10">
                    <button type="submit" class="submit">Save</button>
                </div>
            </form>
        </div>
        



    </div>
    


<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajax({
                url: window.origin+"/admin/notification/manage-notification/get-mobile-data",
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    notification_type: 'mobile'
                },
                success: function(res) {
                    console.log("dataa",res)
                    $("#mobileApiKey").val(res.data.api_key)
                    $("#mobileApiId").val(res.data.api_id)
                    localStorage.setItem("appId",res.data.api_id)

                },
                error: function(jqXhr, ajaxOptions, thrownError) {}
            }); //ajax

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/notification/manageNotification.blade.php ENDPATH**/ ?>