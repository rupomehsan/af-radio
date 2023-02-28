

<?php
// $notificationNumber = \App\Models\Report::where('status', 'active')->where('view_status', 'pending')->count();
?>
<div class="top-header   text-right margin-top-10">
    <ul>
        
        
        <li>
            <!-- Example single danger button -->
            <div class="btn-group">

                <div class="d-flex align-items-center justify-content-center">
                    <div>

                    <?php if(!empty(Auth::user()->image)): ?>
                        <img src="<?php echo e(Auth::user()->image); ?>"
                             alt="img" class="header-user-img" />
                    <?php else: ?>
                        <img  src="<?php echo e(asset('assets/img/dummy.jpg')); ?>" class="header-user-img border" />
                    <?php endif; ?>
                    </div>
                    <div class="mx-1">
                    <?php echo e(Auth::user()->name); ?>


                    </div>

                </div>
                <button type="button" class="btn profile-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                        </button>

                <div class="dropdown-menu">
                    <a href="<?php echo e(url('admin/profile')); ?>"> <span class="iconify" data-icon="healthicons:ui-user-profile"></span> My Profile</a> <br>
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                        <span class="iconify" data-icon="carbon:logout"></span>  Logout
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>


                </div>
            </div>


        </li>
    </ul>

</div>

<?php /**PATH /home/ccninfot/afradio.ccninfotech.com/resources/views/layouts/default/topNavbar.blade.php ENDPATH**/ ?>