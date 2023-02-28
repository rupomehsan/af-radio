<?php $__env->startSection('data_count'); ?>
    
    <div class="content-heading">
        <div class="row">
            
            <div class="col-md-8 content-title">
                <span class="title">Manage Ad</span>
                <div class="title-line"></div>
            </div>
            
        </div>
    </div>
    

    

    
    <div class="row margin-top-40">






        

    </div>
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
    
    <form id="mobileAdForm" method="POST" enctype="multipart/form-data"
        action="<?php echo e(URL::to('admin/advertisement/mobileAdUpdate')); ?>">
        <?php echo csrf_field(); ?>

        <div class="row margin-top-40">
            
            <?php if(!$target->isEmpty()): ?>
                <?php $__currentLoopData = $target; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($data->ad_type == 'google'): ?>
                        <div class="col-md-6 google-ad">
                            <div class="add-content">
                                <div class="ad-title">
                                    <div class="row">
                                        <div class="col-md-10"><span class="title">Google Ad</span></div>

                                        <input type="hidden" name="ad_type[]" value="google">

                                        <div class="col-md-2">
                                            <div class="switch">
                                                <label class="">
                                                    <input class="form-check-input" name="google_status[google]" type="checkbox"
                                                           id="googleStatus" <?php echo $data->google_status == 'on' ? 'checked' : ''; ?>>
                                                    <div class="slider round"></div>
                                                </label>
                                            </div>




                                        </div>
                                    </div>
                                </div>

                                <div class="ad-body">
                                    <div class="form-group">
                                        <label for="googleBannerAdmob">Banner Admob ID</label>
                                        <input type="text" name="banner_id[google]" class="form-control create-form"
                                            id="googleBannerAdmob" value="<?php echo $data->banner_id ?? ''; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="googleInteresticialAdmob">Interesticial Admob ID</label>
                                        <input type="text" name="interesticial_id[google]" class="form-control create-form"
                                            id="googleInteresticialAdmob" value="<?php echo $data->interesticial_id ?? ''; ?>">
                                    </div>
                                    <div class="interesticial-details">
                                        <div class="form-group">
                                            <label for="googleInteresticialAdmobClick">Interesticial Admob Click</label>
                                            <input type="number" name="interesticial_click[google]"
                                                value="<?php echo $data->interesticial_click ?? ''; ?>" class="form-control create-form"
                                                id="googleInteresticialAdmobClick">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="googleNativeAdmob">Native Admob ID</label>
                                        <input type="text" name="native_id[google]" class="form-control create-form"
                                            id="googleNativeAdmob" value="<?php echo $data->native_id ?? ''; ?>">
                                    </div>

                                    <div class="native-details">
                                        <div class="form-group">
                                            <label for="googlNativeAddPerVideo">Native Ad Per Radio</label>
                                            <input type="number" name="native_per_radio[google]"
                                                value="<?php echo $data->native_per_radio ?? ''; ?>" class="form-control create-form"
                                                id="googlNativeAddPerVideo">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>

                <div class="col-md-6 google-ad">
                    <div class="add-content">
                        <div class="ad-title">
                            <div class="row">
                                <div class="col-md-10"><span class="title">Google Ad</span></div>

                                <input type="hidden" name="ad_type[]" value="google">

                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="google_status[google]" type="checkbox"
                                            id="googleStatus">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ad-body">
                            <div class="form-group">
                                <label for="googleBannerAdmob">Banner Admob ID</label>
                                <input type="text" name="banner_id[google]" class="form-control create-form"
                                    id="googleBannerAdmob">
                            </div>

                            <div class="form-group">
                                <label for="googleInteresticialAdmob">Interesticial Admob ID</label>
                                <input type="text" name="interesticial_id[google]" class="form-control create-form"
                                    id="googleInteresticialAdmob">
                            </div>
                            <div class="interesticial-details">
                                <div class="form-group">
                                    <label for="googleInteresticialAdmobClick">Interesticial Admob Click</label>
                                    <input type="number" name="interesticial_click[google]" class="form-control create-form"
                                        id="googleInteresticialAdmobClick">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="googleNativeAdmob">Native Admob ID</label>
                                <input type="text" name="native_id[google]" class="form-control create-form"
                                    id="googleNativeAdmob">
                            </div>

                            <div class="native-details">
                                <div class="form-group">
                                    <label for="googlNativeAddPerVideo">Native Ad Per Radoi </label>
                                    <input type="number" name="native_per_radio[google]" class="form-control create-form"
                                        id="googlNativeAddPerVideo">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            

            
            <?php if(!$target->isEmpty()): ?>
                <?php $__currentLoopData = $target; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($data->ad_type == 'facebook'): ?>
                        <div class="col-md-6 fb-ad">
                            <div class="add-content">
                                <div class="ad-title">
                                    <div class="row">
                                        <div class="col-md-10"><span class="title">Facebook Ad</span></div>

                                        <input type="hidden" name="ad_type[]" value="facebook">

                                        <div class="col-md-2">
                                            <div class="switch">
                                                <label class="">
                                                    <input class="form-check-input" name="facebook_status[facebook]"
                                                           type="checkbox" id="facebookStatus" <?php echo $data->facebook_status == 'on' ? 'checked' : ''; ?>>
                                                    <div class="slider round"></div>
                                                </label>
                                            </div>




                                        </div>
                                    </div>
                                </div>

                                <div class="ad-body">
                                    <div class="form-group">
                                        <label for="facebookBannerAdmob">Banner Admob ID</label>
                                        <input type="text" name="banner_id[facebook]" class="form-control create-form"
                                            id="facebookBannerAdmob" value="<?php echo $data->banner_id ?? ''; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="facebookInteresticialAdmob">Interesticial Admob ID</label>
                                        <input type="text" name="interesticial_id[facebook]" value="<?php echo $data->interesticial_id ?? ''; ?>"
                                            class="form-control create-form" id="facebookInteresticialAdmob">
                                    </div>
                                    <div class="interesticial-details">
                                        <div class="form-group">
                                            <label for="facebookInteresticialAdmobClick">Interesticial Admob Click</label>
                                            <input type="number" name="interesticial_click[facebook]"
                                                value="<?php echo $data->interesticial_click ?? ''; ?>" class="form-control create-form"
                                                id="facebookInteresticialAdmobClick">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="facebookNativeAdmob">Native Admob ID</label>
                                        <input type="text" name="native_id[facebook]" class="form-control create-form"
                                            id="facebookNativeAdmob" value="<?php echo $data->native_id ?? ''; ?>">
                                    </div>

                                    <div class="native-details">
                                        <div class="form-group">
                                            <label for="facebookNativeAddPerVideo">Native Ad Per Radio</label>
                                            <input type="number" name="native_per_radio[facebook]"
                                                value="<?php echo $data->native_per_radio ?? ''; ?>" class="form-control create-form"
                                                id="facebookNativeAddPerVideo">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col-md-6 fb-ad">
                    <div class="add-content">
                        <div class="ad-title">
                            <div class="row">
                                <div class="col-md-10"><span class="title">Facebook Ad</span></div>

                                <input type="hidden" name="ad_type[]" value="facebook">

                                <div class="col-md-2">
                                    <div class="switch">
                                        <label class="">
                                            <input class="form-check-input" name="facebook_status[facebook]" type="checkbox"
                                                   id="facebookStatus">
                                            <div class="slider round"></div>
                                        </label>
                                    </div>





                                </div>
                            </div>
                        </div>

                        <div class="ad-body">
                            <div class="form-group">
                                <label for="facebookBannerAdmob">Banner Admob ID</label>
                                <input type="text" name="banner_id[facebook]" class="form-control create-form"
                                    id="facebookBannerAdmob">
                            </div>

                            <div class="form-group">
                                <label for="facebookInteresticialAdmob">Interesticial Admob ID</label>
                                <input type="text" name="interesticial_id[facebook]" class="form-control create-form"
                                    id="facebookInteresticialAdmob">
                            </div>
                            <div class="interesticial-details">
                                <div class="form-group">
                                    <label for="facebookInteresticialAdmobClick">Interesticial Admob Click</label>
                                    <input type="number" name="interesticial_click[facebook]"
                                        class="form-control create-form" id="facebookInteresticialAdmobClick">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="facebookNativeAdmob">Native Admob ID</label>
                                <input type="text" name="native_id[facebook]" class="form-control create-form"
                                    id="facebookNativeAdmob">
                            </div>

                            <div class="native-details">
                                <div class="form-group">
                                    <label for="facebookNativeAddPerVideo">Native Ad Per Radio</label>
                                    <input type="number" name="native_per_radio[facebook]"
                                        class="form-control create-form" id="facebookNativeAddPerVideo">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            



            <?php if(!$target->isEmpty()): ?>
                <?php $__currentLoopData = $target; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($data->ad_type == 'custom'): ?>
                        <div class="col-md-12 custom-ad margin-top-40">
                            <div class="add-content">
                                <div class="ad-title">
                                    <div class="row">
                                        <div class="col-md-10"><span class="title">Custom Ad</span></div>
                                        <input type="hidden" name="ad_type[]" value="custom">
                                        <div class="col-md-2">
                                            <div class="switch">
                                                <label class="">
                                                    <input class="form-check-input" name="custom_status[custom]"
                                                           type="checkbox" id="customStatus" <?php echo $data->custom_status == 'on' ? 'checked' : ''; ?>>
                                                    <div class="slider round"></div>
                                                </label>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                                <div class="ad-body">
                                    <div class="row">
                                        <div class="col-md-6 custom-banner">
                                            <div class="form-group">
                                                <img src="<?php echo e($data->banner_image); ?>" alt="" height="80" width="100"><br>
                                                <label for="bannerImage">Upload Banner Image</label>
                                                <input type="file" name="banner_image[custom]" value="<?php echo e($data->banner_image ?? ''); ?>" class="form-control-file"
                                                    id="bannerImage">
                                            </div>
                                            <div class="form-group margin-top-20">
                                                <label for="customBannerAdmob">Banner Admob Link</label>
                                                <input type="text" name="banner_link[custom]"
                                                    value="<?php echo $data->banner_link ?? ''; ?>" class="form-control create-form"
                                                    id="customBannerAdmob">
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-interseticial">
                                            <img src="<?php echo e($data->interesticial_image); ?>" alt="" height="80" width="100"><br>
                                            <div class="form-group">
                                                <label for="interesticialImage">Upload Interesticial Image</label>
                                                <input type="file" name="interesticial_image[custom]" value="<?php echo e($data->interesticial_image ?? ''); ?>"
                                                    class="form-control-file" id="interesticialImage">
                                            </div>

                                            <div class="form-group margin-top-20">
                                                <label for="interesticialBannerLink">Interesticial AD Link</label>
                                                <input type="text" name="interesticial_link[custom]"
                                                    value="<?php echo $data->interesticial_link ?? ''; ?>" class="form-control create-form"
                                                    id="interesticialBannerLink">
                                            </div>


                                            <div class="form-group">
                                                <label for="customInteresticialAdmobClick">Interesticial Admob Click</label>
                                                <input type="number" name="interesticial_click[custom]"
                                                    value="<?php echo $data->interesticial_click ?? ''; ?>" class="form-control create-form"
                                                    id="customInteresticialAdmobClick">
                                            </div>
                                        </div>

                                        <div class="col-md-6 native-interseticial">
                                            <img src="<?php echo e($data->native_image); ?>" alt="" height="80" width="100"><br>
                                            <div class="form-group">
                                                <label for="nativeImage">Upload Native Image</label>
                                                <input type="file" name="native_image[custom]" value="<?php echo e($data->native_image ?? ''); ?>" class="form-control-file"
                                                    id="nativeImage">
                                            </div>

                                            <div class="form-group margin-top-20">
                                                <label for="nativeNativeAdmob">Native AD Link</label>
                                                <input type="text" name="native_link[custom]"
                                                    value="<?php echo $data->native_link ?? ''; ?>" class="form-control create-form"
                                                    id="nativeNativeAdmob">
                                            </div>

                                            <div class="form-group">
                                                <label for="customNativeAddPerVideo">Native Ad Per Radio </label>
                                                <input type="number" name="native_per_radio[custom]"
                                                    value="<?php echo $data->native_per_radio ?? ''; ?>" class="form-control create-form"
                                                    id="customNativeAddPerVideo">
                                            </div>

                                            

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col-md-12 custom-ad margin-top-40">
                    <div class="add-content">
                        <div class="ad-title">
                            <div class="row">
                                <div class="col-md-10"><span class="title">Custom Ad</span></div>

                                <input type="hidden" name="ad_type[]" value="custom">


                                <div class="col-md-2">
                                    <div class="switch">
                                        <label class="">
                                            <input class="form-check-input" name="custom_status[custom]" type="checkbox"
                                                   id="customStatus">
                                            <div class="slider round"></div>
                                        </label>
                                    </div>




                                </div>
                            </div>
                        </div>
                        <div class="ad-body">
                            <div class="row">
                                <div class="col-md-6 custom-banner">

                                    <div class="form-group">
                                        <label for="bannerImage">Upload Banner Image</label>
                                        <input type="file" name="banner_image[custom]" class="form-control-file"
                                            id="bannerImage">
                                    </div>

                                    <div class="form-group margin-top-20">
                                        <label for="customBannerAdmob">Banner Admob Link</label>
                                        <input type="text" name="banner_link[custom]" class="form-control create-form"
                                            id="customBannerAdmob">
                                    </div>


                                </div>
                                <div class="col-md-6 custom-interseticial">

                                    <div class="form-group">
                                        <label for="interesticialImage">Upload Interesticial Image</label>
                                        <input type="file" name="interesticial_image[custom]" class="form-control-file"
                                            id="interesticialImage">
                                    </div>

                                    <div class="form-group margin-top-20">
                                        <label for="interesticialBannerLink">Interesticial AD Link</label>
                                        <input type="text" name="interesticial_link[custom]"
                                            class="form-control create-form" id="interesticialBannerLink">
                                    </div>


                                    <div class="form-group">
                                        <label for="customInteresticialAdmobClick">Interesticial Admob Click</label>
                                        <input type="number" name="interesticial_click[custom]"
                                            class="form-control create-form" id="customInteresticialAdmobClick">
                                    </div>
                                </div>

                                <div class="col-md-6 native-interseticial">

                                    <div class="form-group">
                                        <label for="nativeImage">Upload Native Image</label>
                                        <input type="file" name="native_image[custom]" class="form-control-file"
                                            id="nativeImage">
                                    </div>

                                    <div class="form-group margin-top-20">
                                        <label for="nativeNativeAdmob">Native AD Link</label>
                                        <input type="text" name="native_link[custom]" class="form-control create-form"
                                            id="nativeNativeAdmob">
                                    </div>

                                    <div class="form-group">
                                        <label for="customNativeAddPerVideo">Native Ad Per Radio </label>
                                        <input type="number" name="native_per_radio[custom]"
                                            class="form-control create-form" id="customNativeAddPerVideo">
                                    </div>

                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>




            <?php if(!$target->isEmpty()): ?>
                <?php $__currentLoopData = $target; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($data->ad_type == 'startup'): ?>
                        <div class="col-md-12 startup-ad margin-top-40">
                            <div class="add-content">
                                <div class="ad-title">
                                    <div class="row">
                                        <div class="col-md-10"><span class="title">Startup Ad</span></div>

                                        <input type="hidden" name="ad_type[]" value="startup">


                                        <div class="col-md-2">
                                            <div class="switch">
                                                <label class="">
                                                    <input class="form-check-input" name="startup_status[startup]"
                                                           type="checkbox" id="startupStatus" <?php echo $data->startup_status == 'on' ? 'checked' : ''; ?>>
                                                    <div class="slider round"></div>
                                                </label>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                                <div class="ad-body">
                                    <div class="row">
                                        <div class="col-md-6 startup-banner">

                                            <div class="form-group margin-top-20">
                                                <label for="startupBannerAdmob">Startup AD ID</label>
                                                <input type="text" name="startup_id[startup]" value="<?php echo $data->startup_id ?? ''; ?>"
                                                    class="form-control create-form" id="startupBannerAdmob">
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col-md-12 startup-ad margin-top-40">
                    <div class="add-content">
                        <div class="ad-title">
                            <div class="row">
                                <div class="col-md-10"><span class="title">Startup Ad</span></div>

                                <input type="hidden" name="ad_type[]" value="startup">


                                <div class="col-md-2">
                                    <div class="switch">
                                        <label class="">
                                            <input class="form-check-input" name="startup_status[startup]" type="checkbox"
                                                       id="startupStatus">
                                            <div class="slider round"></div>
                                        </label>
                                    </div>




                                </div>
                            </div>
                        </div>
                        <div class="ad-body">
                            <div class="row">
                                <div class="col-md-6 startup-banner">

                                    <div class="form-group margin-top-20">
                                        <label for="startupBannerAdmob">Startup AD ID</label>
                                        <input type="text" name="startup_id[startup]" class="form-control create-form"
                                            id="startupBannerAdmob">
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <div class="col-md-12 actions margin-top-20 mb-5">
                <button type="submit" class="submit">Update</button>
                <a href="/admin/dashboard">Cancel</a>
            </div>

        </div>
    </form>
    


<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script type="text/javascript">
        $(document).on("change", "#googleStatus", function(e) {
            e.preventDefault();
            if (this.checked == true) {
                $('#facebookStatus').prop('checked', false);
                $('#customStatus').prop('checked', false);
                $('#startupStatus').prop('checked', false);
            }
        });
        $(document).on("change", "#facebookStatus", function(e) {
            e.preventDefault();
            if (this.checked == true) {
                $('#googleStatus').prop('checked', false);
                $('#customStatus').prop('checked', false);
                $('#startupStatus').prop('checked', false);
            }
        });
        $(document).on("change", "#customStatus", function(e) {
            e.preventDefault();
            if (this.checked == true) {
                $('#googleStatus').prop('checked', false);
                $('#facebookStatus').prop('checked', false);
                $('#startupStatus').prop('checked', false);
            }
        });

        $(document).on("change", "#startupStatus", function(e) {
            e.preventDefault();
            if (this.checked == true) {
                $('#googleStatus').prop('checked', false);
                $('#facebookStatus').prop('checked', false);
                $('#customStatus').prop('checked', false);
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/advertisement/mobileAd.blade.php ENDPATH**/ ?>