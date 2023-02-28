<?php
$currentControllerName = Request::segment(2);
$currentFullRouteName = Route::getFacadeRoot()
    ->current()
    ->uri();
$logo = \App\Models\Setting::first('logo');
?>
{{-- Start:: Sidebar --}}
<div class="side-bar col-md-2 col-sm-6" id="sitebar">
    <span class="close close-icon" id="close">x</span>
    <div class="logo-section d-flex justify-content-center align-items-center">
        <div>
            <span class="iconify bold" data-icon="bx:bxs-user" style="float:left;font-size: 30px"></span>
        </div>
        <h4 class="bold m-3"> Admin</h4>

    </div>

    {{-- Start:: Nav bar --}}
    <nav>

        <ul>
            <li>
                <a href="/admin/dashboard" class="{{ $currentControllerName == 'dashboard' || '' ? 'active' : '' }}">
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
            @if ((in_array('playlist', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/playlist" class="{{ $currentControllerName == 'playlist' ? 'active' : '' }}">
                        <span class="iconify" data-icon="bxs:playlist" ></span>
                        <span>Playlist</span>
                    </a>
                </li>
            @endif
            @if ((in_array('podcast', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/podcast" class="{{ $currentControllerName == 'podcast' ? 'active' : '' }}">
                          <span class="iconify" data-icon="ic:sharp-playlist-add-circle" ></span>
                        <span>Podcast</span>
                    </a>
                </li>
            @endif
            @if ((in_array('video', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/video" class="{{ $currentControllerName == 'video' ? 'active' : '' }}">
                         <span class="iconify" data-icon="dashicons:video-alt" ></span>
                        <span>Video</span>
                    </a>
                </li>
            @endif
            @if ((in_array('shoutouts', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/shoutouts" class="{{ $currentControllerName == 'shoutouts' ? 'active' : '' }}">
                        <span class="iconify" data-icon="bxs:user-voice" ></span>
                        <span>Shoutouts</span>
                    </a>
                </li>
            @endif
            @if ((in_array('live-request', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/live-request"
                       class="{{ $currentControllerName == 'live-request' ? 'active' : '' }}">
                         <span class="iconify" data-icon="fluent:location-live-24-filled" ></span>
                        <span>Live Request</span>
                    </a>
                </li>
            @endif
            @if ((in_array('birthday-wish', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/birthday-wish"
                       class="{{ $currentControllerName == 'birthday-wish' ? 'active' : '' }}">
                        <span class="iconify" data-icon="jam:birthday-cake-f" ></span>
                        <span>Birthday Wish</span>
                    </a>
                </li>
            @endif
            @if ((in_array('contest', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/contest-create"
                       class="{{ $currentControllerName == 'contest-create' ? 'active' : '' }}">
                           <span class="iconify" data-icon="healthicons:i-exam-multiple-choice"></span>
                        <span>Contest</span>
                    </a>
                </li>
            @endif
            @if ((in_array('radio', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/radio" class="{{ $currentControllerName == 'radio' ? 'active' : '' }}">
                        <span class="iconify" data-icon="ic:sharp-radio"></span>
                        <span>Radio</span>
                    </a>
                </li>
            @endif


            @if ((in_array('country', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/country" class="{{ $currentControllerName == 'country' ? 'active' : '' }}">
                        <span class="iconify" data-icon="subway:world-1"></span>
                        <span>Station</span>
                    </a>
                </li>
            @endif
            @if ((in_array('language', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/language" class="{{ $currentControllerName == 'language' ? 'active' : '' }}">
                        <span class="iconify" data-icon="clarity:language-solid"></span>
                        <span>Language</span>
                    </a>
                </li>
            @endif
            @if ((in_array('subscription', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <li>
                    <a href="/admin/subscription"
                       class="{{ $currentControllerName == 'subscription' ? 'active' : '' }}">
                        <span class="iconify" data-icon="bx:bxs-calendar-star"></span>
                        <span>Subscription</span>
                    </a>
                </li>
            @endif

        </ul>


        {{-- @if ((in_array('video', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))) --}}
        {{-- <span class="nav-section">Video</span> --}}
        <ul>

        </ul>
        {{-- @endif --}}


        {{-- @if ((in_array('administration', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))) --}}
        @if ((in_array('admin', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
            <span class="nav-section">Administration</span>
            <ul>

                <li>
                    <a href="/admin/admin" class="{{ $currentControllerName == 'admin' ? 'active' : '' }}">
                        <span class="iconify" data-icon="fa-solid:user-cog"></span>
                        <span>Manage Admin</span>
                    </a>
                </li>
                @endif
            </ul>
            {{-- @endif --}}


            @if ((in_array('user', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                <span class="nav-section">User</span>
                <ul>
                    <li>
                        <a href="/admin/user" class="{{ $currentControllerName == 'user' ? 'active' : '' }}">
                            <span class="iconify" data-icon="fa-solid:user-cog"></span>
                            <span>Manage User</span>
                        </a>
                    </li>
                </ul>
            @endif


            {{-- @if ((in_array('settings', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1]))) --}}
            <span class="nav-section">Settings</span>
            <ul>
                @if ((in_array('advertisement', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                    <li>
                        <a href="/admin/advertisement"
                           class="{{ $currentControllerName == 'advertisement' ? 'active' : '' }}">
                            <span class="iconify" data-icon="bi:badge-ad-fill"></span>
                            <span>Advertisement</span>
                        </a>
                    </li>
                @endif

                @if ((in_array('notification', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                    <li>
                        <a href="/admin/notification"
                           class="{{ $currentControllerName == 'notification' ? 'active' : '' }}">
                            <span class="iconify" data-icon="ic:sharp-notification-add"></span>
                            <span>Notifications</span>
                        </a>
                    </li>
                @endif
                @if ((in_array('payment', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                    <li>
                        <a href="/admin/payment"
                           class="{{ $currentControllerName == 'payment' ? 'active' : '' }}">
                            <span class="iconify" data-icon="material-symbols:payments-sharp"></span>
                            <span>Payment</span>
                        </a>
                    </li>
                @endif

                @if ((in_array('package', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                    <li>
                        <a href="/admin/package"
                           class="{{ $currentControllerName == 'package' ? 'active' : '' }}">
                            <span class="iconify" data-icon="lucide:package-open"></span>
                            <span>Package</span>
                        </a>
                    </li>
                @endif

                @if ((in_array('basic-settings', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                    <li>
                        <a href="/admin/basic-settings"
                           class="{{ $currentControllerName == 'basic-settings' ? 'active' : '' }}">
                            <span class="iconify" data-icon="eva:settings-2-fill"></span>
                            <span>Basic Settings</span>
                        </a>
                    </li>
                @endif

                @if ((in_array('smtp', $accessControllArr)) || (in_array(auth()->user()->user_role_id, [1])))
                    <li>
                        <a href="/admin/smtp"
                           class="{{ $currentControllerName == 'sptm' ? 'active' : '' }} {{ $currentControllerName == 'smtp' ? 'active' : '' }}">
                            <span class="iconify" data-icon="icon-park:email-lock"></span>
                            <span>SMTP</span>
                        </a>
                    </li>
                @endif
            </ul>
            {{-- @endif --}}

    </nav>
    {{-- End:: Nav bar --}}
</div>
{{-- End:: Sidebar --}}
