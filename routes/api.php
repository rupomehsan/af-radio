<?php

use App\Http\Controllers\Api\AdsMobileController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\FavoritListController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RadioController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {

    /*
    Image Upload
     */
    Route::post('/image-upload', [AuthController::class, "fileUploader"]);
    /*
    Authentication Routes
    register, login, forget-password, verify, resend-code
     */
    Route::prefix('auth/user')->group(function () {
        Route::post('/register', [AuthController::class, "register"]);
        Route::post('/login', [AuthController::class, "login"]);
        Route::post('/forgot-password', [AuthController::class, "forgotPassword"]);
        Route::post('/user-verify', [AuthController::class, "UserVerify"]);
        Route::post('/resend-code', [AuthController::class, "resendCode"]);
        Route::post('/recover-password', [AuthController::class, "changePassword"]);
        //user
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/profile', [AuthController::class, "profile"]);
            Route::patch('/profile/update', [AuthController::class, "updateProfile"]);
            Route::patch('/update-password', [AuthController::class, "profileChangePassword"]);

        });
    });
    /*
    Favorite List
    add, remove,logout,list show
     */
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthController::class, "logout"]);
        });
        // fetchme
        Route::get('fetchme', [AuthController::class, "fetchMe"]);
        //Favorite
        Route::get('favourite/radio/schedule/list', [FavoritListController::class, "favoriteList"]);
        Route::post('favourite/radio/added', [FavoritListController::class, "favoriteListAdded"]);
        Route::post('favourite/radio/delete', [FavoritListController::class, "favoriteRadioDelete"]);
        //subscription
        Route::post('subscription/store', [SubscriptionController::class, "store"]);
        Route::post('subscription/package/store', [SubscriptionController::class, "packageStore"]);
    });

    //subscription
    Route::get('subscription/get-all', [SubscriptionController::class, "index"]);
    Route::get('subscription/package/get-all', [SubscriptionController::class, "packageIndex"]);
    //advertisements
    Route::get('ads-mobile', [AdsMobileController::class, "index"]);
    //country
    Route::get('country/get-all', [CountryController::class, "index"]);
    //notification
    Route::get('notification', [AdsMobileController::class, "notification"]);
    Route::get('get_immediate_schedule_search_data', [AdsMobileController::class, "getSearchData"]);
    Route::post('send-notification', [NotificationController::class, "sendNotification"]);
    Route::post('notification/file-upload', [NotificationController::class, "fileUploader"]);
    Route::post('notification-resend/{id}', [NotificationController::class, "resendNotification"]);
    Route::get('notification/manage-notification/get-mobile-data', [NotificationController::class, "getMobileData"]);
    //About us
    //About us
    Route::get('about/about-us', [AdsMobileController::class, "about"]);
    //set_premium_status
    //set_premium_status
    Route::post('set_premium_status', [AdsMobileController::class, "setPremiumStatus"]);
    Route::get('get_premium_status', [AdsMobileController::class, "getPremiumStatus"]);
    /*
   shoutouts
     */
    Route::resource('shoutouts', \App\Http\Controllers\Api\ShoutoutsController::class);
    Route::get('get_shoutouts_search_data', [\App\Http\Controllers\Api\ShoutoutsController::class, "getSearchData"]);
    /*
     live-request
       */
    Route::resource('live-request', \App\Http\Controllers\Api\LiveRequestController::class);
    Route::get('get_live_request_search_data', [\App\Http\Controllers\Api\LiveRequestController::class, "getSearchData"]);
    /*
     birthday-wish
       */
    Route::resource('birthday-wish', \App\Http\Controllers\Api\BirthdayWishController::class);
    Route::get('get_birthday_wish_search_data', [\App\Http\Controllers\Api\BirthdayWishController::class, "getSearchData"]);

    /*
    video
   */
    Route::resource('video', \App\Http\Controllers\Api\VideoController::class);
    Route::post('video/{id}', [\App\Http\Controllers\Api\VideoController::class, "update"]);
    Route::get('get_video_search_data', [\App\Http\Controllers\Api\VideoController::class, "getPlaylistSearchData"]);
    Route::get('get_all_video', [\App\Http\Controllers\Api\VideoController::class, "getAllVideoData"]);
    /*
    playlist
   */
    Route::resource('playlist', \App\Http\Controllers\Api\PlaylistController::class);
    Route::post('playlist/{id}', [\App\Http\Controllers\Api\PlaylistController::class, "update"]);
    Route::post('audio-file-delete', [\App\Http\Controllers\Api\PlaylistController::class, "audioDelete"]);
    Route::get('get_playlist_search_data', [\App\Http\Controllers\Api\PlaylistController::class, "getPlaylistSearchData"]);
    /*
playlist
*/
    Route::resource('package', \App\Http\Controllers\Api\PackageController::class);
    Route::post('package/{id}', [\App\Http\Controllers\Api\PackageController::class, "update"]);
    Route::get('get_package_search_data', [\App\Http\Controllers\Api\PackageController::class, "getPlaylistSearchData"]);
    Route::get('get_all_package_mb', [\App\Http\Controllers\Api\PackageController::class, "getPackageMb"]);
    /*
   OnDemand
  */
    Route::resource('on_demand', \App\Http\Controllers\Api\OnDemandController::class);
    Route::post('on_demand/{id}', [\App\Http\Controllers\Api\OnDemandController::class, "update"]);
    Route::post('audio-file-delete-podcast', [\App\Http\Controllers\Api\OnDemandController::class, "audioDelete"]);
    Route::get('get_on_demand_search_data', [\App\Http\Controllers\Api\OnDemandController::class, "getPlaylistSearchData"]);
    /*
     Contest
   */
    Route::resource('contest', \App\Http\Controllers\Api\ContestController::class);
    Route::get('get_contest_search_data', [\App\Http\Controllers\Api\ContestController::class, "getContestSearchData"]);
    Route::get('get_contest_with_questions', [\App\Http\Controllers\Api\ContestController::class, "getContestWithQuestions"])->middleware('auth:sanctum');
    /*
      Contest questions
    */
    Route::resource('contest_questions', \App\Http\Controllers\Api\ContestQuestionController::class);
    Route::get('get_contest_questions_search_data', [\App\Http\Controllers\Api\ContestQuestionController::class, "getContestSearchData"]);
    Route::get('get_contest_participant/{id}', [\App\Http\Controllers\Api\ContestQuestionController::class, "getParticipant"]);
    Route::post('participant_user', [\App\Http\Controllers\Api\ContestQuestionController::class, "participantUser"])->middleware('auth:sanctum');
    /*
     Schedule
   */
    Route::resource('schedule', \App\Http\Controllers\Api\ScheduleController::class)->except(['create', 'edit', 'update', 'delete']);
    Route::post('schedule/{id}', [\App\Http\Controllers\Api\ScheduleController::class, 'update']);
    Route::get('get_schedule_by_radio_id/{id}', [\App\Http\Controllers\Api\ScheduleController::class, "getScheduleByRadioId"]);
    Route::get('get_schedule_by_radio_id_mb/{id}', [\App\Http\Controllers\Api\ScheduleController::class, "getScheduleByRadioIdMb"]);
    Route::get('get_radio_schedule_search_data', [\App\Http\Controllers\Api\ScheduleController::class, "getRadioSearchData"]);
    Route::post('get_schedule_search_data', [\App\Http\Controllers\Api\ScheduleController::class, "getSearchData"]);
    Route::post('popular_program', [\App\Http\Controllers\Api\ScheduleController::class, "populerProgram"]);
    Route::get('get_popular_program/{id}', [\App\Http\Controllers\Api\ScheduleController::class, "getPopulerProgram"]);
    /*
    Radio Management
     */
    Route::get('radio/by-country', [RadioController::class, "indexByCountry"]);
    Route::get('radio/by-language', [RadioController::class, "indexByLanguage"]);
    Route::post('radio/show-by-country', [RadioController::class, "showByCountry"]);
    Route::post('radio/top-listen', [RadioController::class, "topListenRadio"]);
    Route::get('radio/free-channels', [RadioController::class, "freeChannels"]);
    Route::get('radio/premium-channels', [RadioController::class, "premiumChannels"]);
    Route::get('radio/popular-channels', [RadioController::class, "popularChannels"]);
    Route::post('radio/search', [RadioController::class, "radioSearch"]);
    Route::get('radio/recent-played-channels', [RadioController::class, "recentPlayed"])->middleware('auth:sanctum');
    //language
    Route::get('language/get-all', [LanguageController::class, "index"]);
    Route::get('payment_settings_get', [\App\Http\Controllers\Api\PaymentController::class, "index"]);
    Route::post('payment_settings_store', [\App\Http\Controllers\Api\PaymentController::class, "store"]);
    //user activity
    Route::post('open-app', [\App\Http\Controllers\Api\UserActivityController::class, "statusChecker"]);
    Route::get('active-user', [\App\Http\Controllers\Api\UserActivityController::class, "activeUserCount"]);

// Paypal Rest Api
    /*
        1. Authentication
        2. Create Order
        3. Retrieve Data
    */
    Route::post('paypal-create-order', [\App\Http\Controllers\Api\PaymentController::class, "paypalCreateOrder"])->middleware('auth:sanctum');
    Route::post('paypal-check-order-status', [\App\Http\Controllers\Api\PaymentController::class, "paypalCheckOrderStatus"]);

// Stripe Rest Api
    /*
        1. create-order
        2. check-order-status
        3. events
    */
    Route::post('stripe-create-order', [\App\Http\Controllers\Api\PaymentController::class, "stripeCreateOrder"])->middleware('auth:sanctum');
    Route::post('stripe-check-order-status', [\App\Http\Controllers\Api\PaymentController::class, "stripeOrderStatus"]);
    Route::get('stripe-events', [\App\Http\Controllers\Api\PaymentController::class, "stripeCreateEvent"]);
    Route::post('stripe-check-pre-payment-token', [\App\Http\Controllers\Api\PaymentController::class, "stripeCheckToken"]);

    // sendWyre Rest Api
    /*
        1. create-order
        2. check-order-status
        3. events
    */
    Route::post('sendwyre-create-order', [\App\Http\Controllers\Api\PaymentController::class, "sendwyreCreateOrder"])->middleware('auth:sanctum');
    Route::post('sendwyre-check-order-status', [\App\Http\Controllers\Api\PaymentController::class, "sendwyreOrderStatus"]);

});





