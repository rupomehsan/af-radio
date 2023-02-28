<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RadioController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SmtpController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::view('/main', 'main');
//Route::get('info', function (){
//    echo phpinfo();
//});

Route::prefix("installation")->group(function () {
    Route::view('/', 'installation.installer');
    Route::post('/env-update', [\App\Http\Controllers\InstallerController::class, "envUpdate"]);
    Route::post('/db-check', [\App\Http\Controllers\InstallerController::class, "dbCheck"]);
    Route::post('/finished', [\App\Http\Controllers\InstallerController::class, "finished"]);
    Route::post('/license-checker', [\App\Http\Controllers\InstallerController::class, "licenseChecker"]);
});

Route::group(['middleware' => 'installationCheck'], function () {
    Auth::routes();
    Route::get('forgotpassword', [AuthController::class, "recoveryPassword"]);
    Route::post('verification', [AuthController::class, "forgotPassword"]);
    Route::post('user-verification', [AuthController::class, "UserVerify"]);

    Route::group(['middleware' => 'auth'], function () {
        Route::redirect('/', '/admin/dashboard', 301);
        Route::group(['middleware' => 'userAccessControl'], function () {
            Route::prefix('admin')->group(function () {
                Route::get('/dashboard', [DashboardController::class, "index"]);
                //Playlist
                Route::view('playlist', "playlist.index");
                //Shoutouts
                Route::view('podcast', "onDemand.index");
                Route::view('podcast/playlist/{id}', "onDemand.view");
                ///video
                Route::view('video', "video.index");
                ///Shoutouts
                Route::view('shoutouts', "shoutouts.index");
                //Shoutouts
                Route::view('live-request', "liveRequest.index");
                //Shoutouts
                Route::view('birthday-wish', "birthdayWish.index");
                //package
                Route::view('package', "package.index");
                //Shoutouts
                Route::view('contest-create', "contest.index");
                Route::view('contest/question/{id}', "contest.question");
                Route::view('contest/participant-list/{id}', "contest.participant_list");
                //country
                Route::get('country', [CountryController::class, "index"]);
                Route::post('country/create', [CountryController::class, "create"]);
                Route::post('country/store', [CountryController::class, "store"]);
                Route::post('country/edit', [CountryController::class, "edit"]);
                Route::post('country/update', [CountryController::class, "update"]);
                Route::post('country/filter', [CountryController::class, "filter"]);
                Route::delete('country/{id}', [CountryController::class, "destroy"]);
                Route::post('manage-countryApproval', [CountryController::class, "manageApproval"]);
                Route::post('country/file-upload', [CountryController::class, "fileUploader"]);
                //radio
                Route::get('radio', [RadioController::class, "index"]);
                Route::get('radio/create', [RadioController::class, "create"]);
                Route::post('radio/store', [RadioController::class, "store"]);
                Route::get('radio/edit/{id}', [RadioController::class, "edit"]);
                Route::post('radio/update', [RadioController::class, "update"]);
                Route::post('radio/filter', [RadioController::class, "filter"]);
                Route::delete('radio/{id}', [RadioController::class, "destroy"]);
                Route::post('radio/file-upload', [RadioController::class, "fileUploader"]);
                Route::view("radio/schedule/{id}","radio.schedule");
                //management status
                Route::post('manage-radioApproval', [RadioController::class, "manageApproval"]);
                Route::post('status-radioApproval', [RadioController::class, "statusControl"]);
//            Route::post('enable-radioApproval', [RadioController::class, "enable"]);
//            Route::post('disable-radioApproval', [RadioController::class, "disable"]);
//            Route::post('delete-radioApproval', [RadioController::class, "delete"]);
                Route::post('filter-radio', [RadioController::class, "radioFilter"]);
                //Language
                Route::get('language', [LanguageController::class, "index"]);
                Route::get('language/create', [LanguageController::class, "create"]);
                Route::post('language/store', [LanguageController::class, "store"]);
                Route::post('language/edit', [LanguageController::class, "edit"]);
                Route::post('language/update', [LanguageController::class, "update"]);
                Route::post('language/filter', [LanguageController::class, "filter"]);
                Route::delete('language/{id}', [LanguageController::class, "destroy"]);
                Route::post('language/file-upload', [LanguageController::class, "fileUploader"]);
                //management status
                Route::post('manage-languageApproval', [LanguageController::class, "manageApproval"]);
                //subscription
                Route::get('subscription', [SubscriptionController::class, "index"]);
                // });Welcome Onboard
                // Route::group(['middleware' => 'adminUser'], function () {
                //user management
                Route::get('user', [UserController::class, "index"]);
                Route::get('user/create', [UserController::class, "create"]);
                Route::post('user/store', [UserController::class, "store"]);
                Route::post('user/filter', [UserController::class, "filter"]);
                Route::get('user/{id}/edit', [UserController::class, "edit"]);
                Route::post('user/{id}/update', [UserController::class, "update"]);
                Route::delete('user/{id}', [UserController::class, "destroy"]);
                //comment
                // });
                //subscription
                Route::get('subscription/get-all', [SubscriptionController::class, "index"]);
                Route::get('subscription/all-package', [SubscriptionController::class, "packageIndex"]);

                // Route::group(['middleware' => 'adminAdministration'], function () {
                //admin management
                Route::get('admin', [AdminController::class, "adminIndex"]);
                Route::get('admin/super-admin', [AdminController::class, "superAdminIndex"]);
                Route::get('admin/create', [AdminController::class, "create"]);
                Route::post('admin/store', [AdminController::class, "store"]);
                Route::post('admin/filter', [AdminController::class, "filter"]);
                Route::post('admin/super-admin/filter', [AdminController::class, "superAdminFilter"]);
                Route::get('admin/{id}/edit', [AdminController::class, "edit"]);
                Route::post('admin/{id}/update', [AdminController::class, "update"]);
                Route::delete('admin/{id}', [AdminController::class, "destroy"]);

                Route::view('admin-management', 'admin.index');
                Route::view('admin-management/create', 'admin.create');
                Route::get('profile', [AdminController::class, "show"]);
                Route::post('profile/{id}/update', [AdminController::class, "profileUpdate"]);
                // });

                // Route::group(['middleware' => 'adminSettings'], function () {

                //basic-settings
                //basic-settings
                Route::view('payment',"payment.create" );
                //basic-settings
                Route::get('basic-settings', [SettingsController::class, "basicSettings"]);
                Route::post('basic-settings/update', [SettingsController::class, "basicSettingsUpdate"]);
                Route::post('basic-settings/create', [SettingsController::class, "basicSettingsCreate"]);
                Route::post('basic-settings/change-password', [UserController::class, "changePassword"]);
                Route::post('basic-settings/update-password', [UserController::class, "updatePassword"]);


                //advertisement
                Route::get('advertisement', [AdController::class, "mobileAd"]);
                Route::post('advertisement/mobileAdUpdate', [AdController::class, "mobileAdUpdate"]);

                Route::get('advertisement/web-ad', [AdController::class, "webAd"]);
                Route::post('advertisement/webAdUpdate', [AdController::class, "webAdUpdate"]);

                Route::view('advertisement/web', 'advertisement.web');

                //notification
                Route::get('notification', [NotificationController::class, "index"]);
                Route::get('notification/schedule', [NotificationController::class, "scheduleIndex"]);
                Route::get('notification/linked', [NotificationController::class, "linkedIndex"]);
                Route::post('notification/create', [NotificationController::class, "create"]);
                Route::post('notification/store', [NotificationController::class, "store"]);
                Route::post('notification/filter', [NotificationController::class, "filter"]);
                Route::delete('notification/{id}', [NotificationController::class, "destroy"]);
                Route::get('notification/manage-notification', [NotificationController::class, "manageNotification"]);
                Route::post('notification/manage-notification-update', [NotificationController::class, "manageNotificationUpdate"]);
                Route::post('notification/manage-notification/get-mobile-data', [NotificationController::class, "getMobileData"]);
                Route::post('notification/manage-notification/get-web-data', [NotificationController::class, "getWebData"]);
                //SMTP
                Route::get('smtp', [SmtpController::class, "index"]);
                Route::get('smtp/create', [SmtpController::class, "create"]);
                Route::post('smtp/store', [SmtpController::class, "store"]);
                Route::post('smtp/update', [SmtpController::class, "update"]);

                // });
            });

        });

        Route::view('sendwyre',  "payment.index", );
//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
    Route::get('settings', [SettingsController::class, "Settings"]);
});

Route::view("{paymentType}/success","payment.success");
Route::view("{paymentType}/cancel","payment.cancel");



