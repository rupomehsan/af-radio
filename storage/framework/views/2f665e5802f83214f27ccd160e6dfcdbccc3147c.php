<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = \App\Models\Setting::first();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php if($title && $title->logo): ?>
        <link rel="shortcut icon" type="image/jpg" href="<?php echo e(URL::to('/')); ?>/uploads/<?php echo e($title->logo); ?>"/>
    <?php endif; ?>
    <?php if($title && $title->system_name): ?>
        <title><?php echo e($title->system_name); ?></title>
    <?php else: ?>
        <title>Radio App</title>
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/toastr.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/nice-select.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/select2.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/autoComplete.01.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/placeholder-loading.min.css')); ?>"/>
    <!-- <link rel="stylesheet" href="<?php echo e(asset('assets/css/avnSkeleton.css')); ?>"> -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/gijgo.min.css')); ?>"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



    
    
    
</head>
<div id="preloader" class="d-none">
    <div id="status">
    </div>
</div>
<?php /**PATH /home/ccninfot/afradio.ccninfotech.com/resources/views/layouts/default/header.blade.php ENDPATH**/ ?>