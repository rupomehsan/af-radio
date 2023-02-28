<?php
$currentControllerName = Request::segment(2);
$currentFullRouteName = Route::getFacadeRoot()
    ->current()
    ->uri();
$logo = \App\Models\Setting::first('logo');
?>

<div class="side-bar col-md-2 col-sm-6" id="sitebar">
    <span class="close close-icon" id="close">x</span>
    <div class="logo-section d-flex justify-content-center align-items-center">
        <div>
            <span class="iconify bold" data-icon="bx:bxs-user" style="float:left;font-size: 30px"></span>
        </div>
        <h4 class="bold m-3"> Admin</h4>

    </div>

    
    <nav>

        <ul>
            <li>
                <a href="/admin/dashboard" class="<?php echo e($currentControllerName == 'dashboard' || '' ? 'active' : ''); ?>">
                    <span class="iconify" data-icon="ic:sharp-space-dashboard"></span>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>

        <?php
        $accessControllArr = json_decode(auth()->user()->access) ?? [];
        ?>


        <span class="nav-section">Manage</span>
        <ul>
            <?php if((in_array('playlist', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/playlist" class="<?php echo e($currentControllerName == 'playlist' ? 'active' : ''); ?>">
                        <span class="iconify" data-icon="bxs:playlist" ></span>
                        <span>Playlist</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if((in_array('podcast', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/podcast" class="<?php echo e($currentControllerName == 'podcast' ? 'active' : ''); ?>">
                          <span class="iconify" data-icon="ic:sharp-playlist-add-circle" ></span>
                        <span>Podcast</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if((in_array('video', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/video" class="<?php echo e($currentControllerName == 'video' ? 'active' : ''); ?>">
                         <span class="iconify" data-icon="dashicons:video-alt" ></span>
                        <span>Video</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if((in_array('shoutouts', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/shoutouts" class="<?php echo e($currentControllerName == 'shoutouts' ? 'active' : ''); ?>">
                        <span class="iconify" data-icon="bxs:user-voice" ></span>
                        <span>Shoutouts</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if((in_array('live-request', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/live-request"
                       class="<?php echo e($currentControllerName == 'live-request' ? 'active' : ''); ?>">
                         <span class="iconify" data-icon="fluent:location-live-24-filled" ></span>
                        <span>Live Request</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if((in_array('birthday-wish', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/birthday-wish"
                       class="<?php echo e($currentControllerName == 'birthday-wish' ? 'active' : ''); ?>">
                        <span class="iconify" data-icon="jam:birthday-cake-f" ></span>
                        <span>Birthday Wish</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if((in_array('contest', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/contest-create"
                       class="<?php echo e($currentControllerName == 'contest-create' ? 'active' : ''); ?>">
                           <span class="iconify" data-icon="healthicons:i-exam-multiple-choice"></span>
                        <span>Contest</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if((in_array('radio', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/radio" class="<?php echo e($currentControllerName == 'radio' ? 'active' : ''); ?>">
                        <span class="iconify" data-icon="ic:sharp-radio"></span>
                        <span>Radio</span>
                    </a>
                </li>
            <?php endif; ?>


            <?php if((in_array('country', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/country" class="<?php echo e($currentControllerName == 'country' ? 'active' : ''); ?>">
                        <span class="iconify" data-icon="subway:world-1"></span>
                        <span>Station</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if((in_array('language', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/language" class="<?php echo e($currentControllerName == 'language' ? 'active' : ''); ?>">
                        <span class="iconify" data-icon="clarity:language-solid"></span>
                        <span>Language</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if((in_array('subscription', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <li>
                    <a href="/admin/subscription"
                       class="<?php echo e($currentControllerName == 'subscription' ? 'active' : ''); ?>">
                        <span class="iconify" data-icon="bx:bxs-calendar-star"></span>
                        <span>Subscription</span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>


        
        
        <ul>

        </ul>
        


        
        <?php if((in_array('admin', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
            <span class="nav-section">Administration</span>
            <ul>

                <li>
                    <a href="/admin/admin" class="<?php echo e($currentControllerName == 'admin' ? 'active' : ''); ?>">
                        <span class="iconify" data-icon="fa-solid:user-cog"></span>
                        <span>Manage Admin</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            


            <?php if((in_array('user', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                <span class="nav-section">User</span>
                <ul>
                    <li>
                        <a href="/admin/user" class="<?php echo e($currentControllerName == 'user' ? 'active' : ''); ?>">
                            <span class="iconify" data-icon="fa-solid:user-cog"></span>
                            <span>Manage User</span>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>


            
            <span class="nav-section">Settings</span>
            <ul>
                <?php if((in_array('advertisement', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                    <li>
                        <a href="/admin/advertisement"
                           class="<?php echo e($currentControllerName == 'advertisement' ? 'active' : ''); ?>">
                            <span class="iconify" data-icon="bi:badge-ad-fill"></span>
                            <span>Advertisement</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if((in_array('notification', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                    <li>
                        <a href="/admin/notification"
                           class="<?php echo e($currentControllerName == 'notification' ? 'active' : ''); ?>">
                            <span class="iconify" data-icon="ic:sharp-notification-add"></span>
                            <span>Notifications</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if((in_array('payment', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                    <li>
                        <a href="/admin/payment"
                           class="<?php echo e($currentControllerName == 'payment' ? 'active' : ''); ?>">
                            <span class="iconify" data-icon="material-symbols:payments-sharp"></span>
                            <span>Payment</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if((in_array('package', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                    <li>
                        <a href="/admin/package"
                           class="<?php echo e($currentControllerName == 'package' ? 'active' : ''); ?>">
                            <span class="iconify" data-icon="lucide:package-open"></span>
                            <span>Package</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if((in_array('basic-settings', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                    <li>
                        <a href="/admin/basic-settings"
                           class="<?php echo e($currentControllerName == 'basic-settings' ? 'active' : ''); ?>">
                            <span class="iconify" data-icon="eva:settings-2-fill"></span>
                            <span>Basic Settings</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if((in_array('smtp', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))): ?>
                    <li>
                        <a href="/admin/smtp"
                           class="<?php echo e($currentControllerName == 'sptm' ? 'active' : ''); ?> <?php echo e($currentControllerName == 'smtp' ? 'active' : ''); ?>">
                            <span class="iconify" data-icon="icon-park:email-lock"></span>
                            <span>SMTP</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            

    </nav>
    
</div>

<?php /**PATH /home/tausif/Desktop/rupom/mainProject/af_radio/resources/views/layouts/default/sidebar.blade.php ENDPATH**/ ?>