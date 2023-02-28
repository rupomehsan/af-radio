<?php $__env->startSection('data_count'); ?>
    
    <div class="content-heading">
        <div class="row">
            
            <div class="col-md-8 content-title">
                <span class="title">Edit Admin</span>
                <div class="title-line"></div>

                <!-- Button trigger modal -->
            </div>
            
        </div>
    </div>
    

    
    <form id="adminCreateForm" method="POST" enctype="multipart/form-data"
        action="<?php echo e(URL::to('admin/admin/' . $target->id . '/update')); ?>">
        <?php echo csrf_field(); ?>
        <div class="row create-body margin-top-40">

            <div class="offset-md-1 col-md-10 margin-top-10">
                <div class="form-group">
                    <select name="user_role_id" id="userRole" class="form-control create-form">
                        <option value=" 0">Select Role</option>
                        <?php $__currentLoopData = $userRole; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $selected = '';
                            if ($id == $target->user_role_id) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?php echo e($id); ?>" <?php echo e($selected); ?>>
                                <?php echo e($name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="text-danger"><?php echo e($errors->first('user_role_id')); ?></span>
                </div>
            </div>

            <div class="offset-md-1 col-md-10 margin-top-10">
                <div class="form-group">
                    <input type="text" name="name" class="form-control create-form" id="name" placeholder="Name"
                        value="<?php echo e($target->name); ?>">
                    <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                </div>
            </div>

            <div class="offset-md-1 col-md-10 margin-top-10">
                <div class="form-group">
                    <input type="text" name="email" class="form-control create-form" id="email" placeholder="Email"
                        value="<?php echo e($target->email); ?>">
                    <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                </div>
            </div>

            <div class="offset-md-1 col-md-10 margin-top-10">
                <div class="form-group">
                    <input type="text" name="phone" class="form-control create-form" id="phone" placeholder="Phone"
                        value="<?php echo e($target->phone); ?>">
                    <span class="text-danger"><?php echo e($errors->first('phone')); ?></span>
                </div>
            </div>

            <div class="offset-md-1 col-md-10 margin-top-10" id="accessControl">
                <?php if($target->user_role_id != '1'): ?>
                <h4>Access Control</h4>
                <div class="row margin-top-20">
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="playlist" id="manage"
                            <?php echo in_array('playlist', $access) ? 'checked' : ''; ?> >
                        <label class="form-check-label" for="manage">
                            Playlist
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="podcast" id="podcast"
                            <?php echo in_array('podcast', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="manage">
                            Podcast
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="video" id="video"
                            <?php echo in_array('video', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="manage">
                            Video
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="shoutouts" id="manage"
                            <?php echo in_array('shoutouts', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="manage">
                            Shoutouts
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="live-request" id="manage"
                            <?php echo in_array('live-request', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="manage">
                            Live Request
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="birthday-wish" id="manage"
                            <?php echo in_array('birthday-wish', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="manage">
                            Birthday Wish
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="contest" id="manage"
                            <?php echo in_array('contest', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="manage">
                            Contest
                        </label>
                    </div>


                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="radio" id="radio"
                            <?php echo in_array('radio', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="radio">
                            Radio
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="subscription" id="subscription"
                            <?php echo in_array('subscription', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="subscription">
                            Subscription
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="country" id="country"
                            <?php echo in_array('country', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="radio">
                            Country
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="language" id="language"
                            <?php echo in_array('language', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="subscription">
                            Language
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="user" id="user"
                            <?php echo in_array('user', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="user">
                            User
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="advertisement" id="advertisement"
                            <?php echo in_array('advertisement', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="advertisement">
                            Advertisement
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="notification" id="notification"
                            <?php echo in_array('notification', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="notification">
                            Notification
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="payment" id="payment"
                            <?php echo in_array('payment', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="notification">
                            Payment
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="package" id="podcast"
                            <?php echo in_array('package', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="notification">
                            Package
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="basic-settings" id="settings"
                            <?php echo in_array('basic-settings', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="settings">
                            Settings
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="smtp" id="smtp"
                            <?php echo in_array('smtp', $access) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="settings">
                            Smtp
                        </label>
                    </div>


                </div>
                <?php endif; ?>
            </div>

            <div class="offset-md-1 col-md-10 margin-top-20">
                <div class="col-md-6">
                    <div class="file-upload-edit">
                        <div class="image-upload-wrap-edit">
                            <input value="" name="image" class="file-upload-input-edit" type='file'
                                onchange="readURLEdit(this);" accept="image/*" />
                            <div class="drag-text-edit text-center">
                                <span class="iconify" data-icon="bx:bx-image-alt"></span> <br>
                                <span>Upload Flag Or Drag Here</span>
                            </div>
                        </div>
                        <div class="file-upload-content-edit">
                            <img class="file-upload-image-edit"
                                src="<?php echo e($target->image??asset('assets/img/dummy.jpg')); ?>" alt="your image" />
                            <div class="image-title-wrap-edit">
                                <button type="button" onclick="removeUploadEdit()" class="remove-image-edit">
                                    <span class="iconify" data-icon="akar-icons:cross"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <span class="text-danger"><?php echo e($errors->first('image')); ?></span>
                </div>
            </div>


            <div class="offset-md-1 col-md-10 actions margin-top-20">
                <button class="submit" type="submit" id="editUser">Update</button>
                <a href="<?php echo e(url('/admin/admin')); ?>">Cancel</a>
            </div>
            <div class=" margin-top-40">
            </div>
        </div>
    </form>
    



<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>

    <script type="text/javascript">
        // access control
        $(document).on("change", "#userRole", function(e) {
            e.preventDefault();
            var value = $(this).val();
            $("#accessControl").html('');
            if (value === '1') {
                // alert('asd');
                $("#accessControl").html('');
            } else {
                $("#accessControl").html(`
                    <h4>Access Control</h4>
                    <div class="row margin-top-20">

                          <div class="row margin-top-20">
   <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="playlist" id="manage"
                               checked>
                        <label class="form-check-label" for="manage">
                            Playlist
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="podcast" id="manage"
                               checked>
                        <label class="form-check-label" for="manage">
                            Podcast
                        </label>
                    </div>
 <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="video" id="manage"
                               checked>
                        <label class="form-check-label" for="manage">
                            Video
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="shoutouts" id="manage"
                               checked>
                        <label class="form-check-label" for="manage">
                            Shoutouts
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="live-request" id="manage"
                               checked>
                        <label class="form-check-label" for="manage">
                            Live Request
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="birthday-wish" id="manage"
                               checked>
                        <label class="form-check-label" for="manage">
                            Birthday Wish
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="contest" id="manage"
                               checked>
                        <label class="form-check-label" for="manage">
                            Contest
                        </label>
                    </div>

                         <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="radio" id="radio" checked>
                        <label class="form-check-label" for="radio">
                            Radio
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="subscription" id="subscription" checked>
                        <label class="form-check-label" for="subscription">
                            Subscription
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="country" id="country" checked>
                        <label class="form-check-label" for="country">
                            Country
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="language" id="language" checked>
                        <label class="form-check-label" for="language">
                            Language
                        </label>
                    </div>
<!--                    <div class="form-check user-check col-md-2">-->
<!--                        <input class="form-check-input" type="checkbox" name="access[]" value="administration"-->
<!--                            id="administration" checked>-->
<!--                        <label class="form-check-label" for="administration">-->
<!--                            Administration-->
<!--                        </label>-->
<!--                    </div>-->
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="user" id="user" checked>
                        <label class="form-check-label" for="user">
                            User
                        </label>
                    </div>
                   <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="advertisement" id="advertisement"
                            checked>
                        <label class="form-check-label" for="advertisement">
                            Advertisement
                        </label>
                    </div>
 <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="notification" id="notification"
                            checked>
                        <label class="form-check-label" for="notification">
                            Notification
                        </label>
                    </div>
          <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="payment" id="notification"
                               checked>
                        <label class="form-check-label" for="notification">
                            Payment
                        </label>
                    </div>
                    <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="package" id="notification"
                               checked>
                        <label class="form-check-label" for="notification">
                            Package
                        </label>
                    </div>
 <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="basic-settings" id="settings"
                            checked>
                        <label class="form-check-label" for="settings">
                            Settings
                        </label>
                    </div>
 <div class="form-check user-check col-md-2">
                        <input class="form-check-input" type="checkbox" name="access[]" value="smtp" id="smtp"
                            checked>
                        <label class="form-check-label" for="settings">
                            Smtp
                        </label>
                    </div>

                    </div>
                `);
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/admin/edit.blade.php ENDPATH**/ ?>