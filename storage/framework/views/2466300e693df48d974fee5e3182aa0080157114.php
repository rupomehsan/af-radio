<?php $__env->startSection('data_count'); ?>
    
    


    <img src="<?php echo e(asset('img/Hello.png')); ?>" alt="Hello">
    <h4 class="margin-top-20">
        <span class="bold">Welcome</span> <span class="bold red">Onboard</span>
    </h4>
    <div class=" margin-top-20">
        <span class="red">User Overview</span>
        <div class="line margin-top-10"></div>
    </div>
    

    <div class="row">
        <div class="col-md-6 col-lg-8 col-sm-12 col-12 margin-top-20">
            
            <div class="menu-carts ">
                <div class="row">
                    
                    <div class="col-md-10 col-lg-4 col-xl-3 col-sm-6 cart">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-9">
                                <h4 class="bold"><?php echo e($totalActiveUser ?? '0'); ?></h4>
                                <span class="cart-title">Total Live Now</span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3 d-flex align-items-center">
                                <iconify-icon icon="material-symbols:category" width="30" height="30" style="color: red;border:1px solid rgba(0, 0, 0, 0.25);border-radius: 50%;padding: 5px;box-shadow: 0px 12.5216px 10.0172px rgb(0 0 0 / 10%);"></iconify-icon>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 col-lg-4 col-xl-3 col-sm-6 cart mt-md-1 mt-sm-1 mt-xm-1">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-9">
                                <h4 class="bold"><?php echo e($totalUser ?? '0'); ?></h4>
                                <span class="cart-title">Total User</span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3 d-flex align-items-center">
                                <iconify-icon icon="bxs:user" width="30" height="30" style="color: red;border:1px solid rgba(0, 0, 0, 0.25);border-radius: 50%;padding: 5px;box-shadow: 0px 12.5216px 10.0172px rgb(0 0 0 / 10%);"></iconify-icon>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 col-lg-4 col-xl-3 col-sm-6 cart mt-lg-1 mt-md-1 mt-sm-1 mt-xm-1">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-9">
                                <h4 class="bold"><?php echo e($totalLsHor ??'0'); ?></h4>
                                <span class="cart-title">Listening Hours</span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3 d-flex align-items-center">
                                <iconify-icon icon="bxs:radio" width="30" height="30" style="color: red;border:1px solid rgba(0, 0, 0, 0.25);border-radius: 50%;padding: 5px;box-shadow: 0px 12.5216px 10.0172px rgb(0 0 0 / 10%);"></iconify-icon>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            


            
            <div class="visitors-count margin-top-40">
                <img src="<?php echo e(asset('img/graph.png')); ?>" alt="" style="width: 85%">
            </div>
            

        </div>
        <div class="col-md-6 col-lg-4 col-sm-12 col-12 ">
            
            <div class="right-cart">
            

            
            <div class="top-category-cart margin-top-20">
                <span class="category-cart-title bold">Popular Station</span>
                <div class="row">
                    <?php $__empty_1 = true; $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-6  col-lg-4  col-sm-6 margin-top-20">
                            <div class="d-flex">
                                <div class="">
                                    <?php if(!empty($country['image'])): ?>
                                        <img src="<?php echo e($country['image']); ?>"
                                             alt="image" title="<?php echo e($country['name']); ?>" height="50" width="50"/>
                                    <?php else: ?>
                                        <img height="50" width="80" src="<?php echo e(asset('assets/img/dummy.jpg')); ?>" alt=""/>
                                    <?php endif; ?>
                                </div>
                                <div class="">
                                    <div class="text-center">
                                        <span class="category-cart-content-title px-1"><?php echo e(substr($country['name'],0,10)); ?></span>
                                    </div>
                                    <div class="category-cart-content-number text-center">
                                        <?php if($country['growth'] > 0): ?>
                                            <span class="iconify" data-icon="oi:caret-top"></span>
                                            +<?php echo e($country['growth']); ?>%
                                        <?php else: ?>
                                            <span class="iconify" data-icon="oi:caret-bottom"></span>
                                            <?php echo e($country['growth']); ?>%
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p>No Data Found</p>
                    <?php endif; ?>

                </div>

            </div>




        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-js'); ?>
    <script type="text/javascript">
        $(function () {

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.default.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/dashboard.blade.php ENDPATH**/ ?>