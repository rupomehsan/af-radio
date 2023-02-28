<?php $__env->startSection('data_count'); ?>
    
    <div class="content-heading">
        <div class="row">
            
            <div class="col-md-8 content-title">
                <span class="title">Add User</span>
                <div class="title-line"></div>

                <!-- Button trigger modal -->
            </div>
            
        </div>
    </div>
    

    
    <form id="userCreateForm" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/admin/user/store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="row create-body margin-top-40">

            <div class="offset-md-1 col-md-10 margin-top-10">
                <div class="form-group">
                    <input type="text" name="name" class="form-control create-form" id="name" placeholder="Name" value="<?php echo e(old('name')); ?>">
                    <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                </div>
            </div>

            <div class="offset-md-1 col-md-10 margin-top-10">
                <div class="form-group">
                    <input type="text" name="email" class="form-control create-form" id="email" placeholder="Email" value="<?php echo e(old('email')); ?>">
                    <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                </div>
            </div>

            <div class="offset-md-1 col-md-10 margin-top-10">
                <div class="form-group">
                    <input type="text" name="phone" class="form-control create-form" id="phone" placeholder="Phone" value="<?php echo e(old('phone')); ?>">
                    <span class="text-danger"><?php echo e($errors->first('phone')); ?></span>
                </div>
            </div>

            <div class="offset-md-1 col-md-10 margin-top-10">
                <div class="form-group">
                    <input type="password" name="password" class="form-control create-form" id="password"
                        placeholder="Password" value="<?php echo e(old('password')); ?>">
                    <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                </div>
            </div>

            <div class="offset-md-1 col-md-10 margin-top-20">
                <div class="col-md-6">
                    <div class="file-upload">
                        <div class="image-upload-wrap">
                            <input name="image" id="image" class="file-upload-input" type='file' onchange="readURL(this);"
                                accept="image/*" />
                            <div class="drag-text text-center">
                                <span class="iconify" data-icon="teenyicons:user-square-outline"></span> <br>
                                <span>Upload Image Or Drag Here</span>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image" src="#" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" onclick="removeUpload()" class="remove-image">
                                    <span class="iconify" data-icon="akar-icons:cross"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <span class="text-danger"><?php echo e($errors->first('image')); ?></span>
                </div>
            </div>

            <div class="offset-md-1 col-md-10 actions margin-top-20">
                <button class="submit">Add User</button>
                <a href="/admin/user">Cancel</a>
            </div>
            <div class=" margin-top-40">
            </div>
        </div>
    </form>
    



<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>

    <script type="text/javascript">

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/user/create.blade.php ENDPATH**/ ?>