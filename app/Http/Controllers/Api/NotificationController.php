<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ManageNotification;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Response;
use Validator;

class NotificationController extends Controller
{

    public function __construct()
    {
        if (!file_exists(storage_path('installed')) || !file_exists(base_path('vendor/licensed'))) {
            if (Route::has('/installation')) {
                return redirect('/installation');
            } else {
                abort(500);
            }
        }
    }

    public function index(Request $request)
    {
        try {
            $target = Notification::get();
            return response([
                'status' => 'success',
                'data' => $target,
            ], 200);
        } catch (\Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        if (auth()->user()->email !== "demoadmin@radio.com") {
            $target = Notification::find($id)->delete();
            return response([
                "status" => "success",
                "message" => "Item Successfully delete"
            ]);
        } else {
            return Response::json(['status' => "error", 'message' => 'Sorry You are demo user',], 422);
        }

//        return Redirect::back()->with('msg', 'Item Successfully Delete');
    }

    public function fileUploader(Request $request)
    {
        try {
            $validate = Validator::make(request()->only('file'), [
                'file' => 'required|max:10240',
            ]);
            if ($validate->fails()) {
                return response([
                    'status' => 'validation_error',
                    'data' => $validate->errors(),
                ], 422);
            }

            if (request()->has('file')) {
                $folder = $request->folder ?? 'all';
                $image = $request->file('file');
                $imageName = $folder . "/" . time() . '.' . $image->getClientOriginalName();

                if (config('app.env') === 'production') {
                    $image->move('uploads/' . $folder, $imageName);
                } else {
                    $image->move(public_path('/uploads/' . $folder), $imageName);
                }
                $protocol = request()->secure() ? 'https://' : 'http://';

                return response([
                    'status' => 'success',
                    'message' => 'File uploaded successfully',
                    'data' => $protocol . $_SERVER['HTTP_HOST'] . '/uploads/' . $imageName,
                ], 200);
            }
        } catch (\Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function sendNotification(Request $request)
    {
        try {
//            dd($request->all());
            $api = ManageNotification::where('notification_type', 'mobile')->first();
            $apiKey = $api->api_key;
            $apiId = $api->api_id;
            $validate = Validator::make(request()->all(), [
                'title' => 'required',
            ]);
            if ($validate->fails()) {
                return Response::json(['success' => false, 'heading' => 'Validation Error', 'message' => $validate->errors()], 422);
            }
            $notification = new Notification;
            $notification->title = $request->title;
            $notification->type = $request->type;
            $notification->external_link = $request->external_link ?? '';
            $notification->description = $request->description;
            $notification->schedule_date = Carbon::parse($request->schedule_date)->format('Y-m-d');
            if ($request->file('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                if (config('app.env') === 'production') {
                    $image->move('uploads/country', $imageName);
                } else {
                    $image->move(public_path('/uploads/country'), $imageName);
                }
                $protocol = request()->secure() ? 'https://' : 'http://';
                $fileName = $protocol . $_SERVER['HTTP_HOST'] . '/uploads/user' . $imageName;

                $notification->image = $fileName ;
            }


            $notification->save();

            $content = array(
                "en" => $request->description,
            );
            $headings = array(
                "en" => $request->title, // title
            );

            $hashes_array = array();
            $hashes_array[] = array(
                "id" => "like-button",
                "text" => "Like",
                "icon" => "http://i.imgur.com/N8SN8ZS.png",
                "url" => "https://yoursite.com",
            );

            $hashes_array[] = array(
                "id" => "like-button-2",
                "text" => "Like2",
                "icon" => "http://i.imgur.com/N8SN8ZS.png",
                "url" => "https://yoursite.com",
            );


            $payload = [
                'app_id' => $apiId,
                'included_segments' => array('Subscribed Users'),
                'headings' => ['en' => $request->title],
                'contents' => $content,
            ];

            if ($request->has('schedule_date') && $request->schedule_date) {
                $utcFormat = Carbon::now()->timezone->toOffsetName();
                $payload['send_after'] = Carbon::parse($request->input('schedule_date'))->format('F jS Y h:i:s a') . ' UTC'.$utcFormat;
//                $payload['send_after'] = 'November 08th 2022, 4:06:00 pm UTC+06:00';
            }

            if ($request->has('external_link') && $request->external_link) {
                $payload['url'] = $request->external_link;
            }

//            dd($payload);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => 'Basic ' . $apiKey,
            ])->post('https://onesignal.com/api/v1/notifications', $payload);
            $jsonResponse = $response->json();
            Log::info($jsonResponse);
            if (array_key_exists('errors', $jsonResponse)) {
                return response([
                    'status' => 'validate_errors',
                    'data' => $jsonResponse,
                ]);
            } else {
                return response([
                    'status' => 'success',
                    'data' => $jsonResponse,
                ]);
            }
        } catch (\Exception$e) {
            return response(['status' => 'server_error',
                'message' => $e->getMessage(),], 500);
        }
    }

    public function resendNotification(Request $request,$id){
        try {
//            dd($request->all());
            $api = ManageNotification::where('notification_type', 'mobile')->first();
            $apiKey = $api->api_key;
            $apiId = $api->api_id;

            $notification = Notification::where("id",$id)->first();

//            dd($notification);

            $content = array(
                "en" => $notification->description,
            );
            $headings = array(
                "en" => $notification->title, // title
            );

            $hashes_array = array();
            $hashes_array[] = array(
                "id" => "like-button",
                "text" => "Like",
                "icon" => "http://i.imgur.com/N8SN8ZS.png",
                "url" => "https://yoursite.com",
            );

            $hashes_array[] = array(
                "id" => "like-button-2",
                "text" => "Like2",
                "icon" => "http://i.imgur.com/N8SN8ZS.png",
                "url" => "https://yoursite.com",
            );


            $payload = [
                'app_id' => $apiId,
                'included_segments' => array('Subscribed Users'),
                'headings' => ['en' => $notification->title],
                'contents' => $content,
            ];


            if ( $notification->external_link !==null) {
                $payload['url'] = $notification->external_link;
            }

//            dd($payload);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => 'Basic ' . $apiKey,
            ])->post('https://onesignal.com/api/v1/notifications', $payload);
            $jsonResponse = $response->json();
            Log::info($jsonResponse);
            if (array_key_exists('errors', $jsonResponse)) {
                return response([
                    'status' => 'validate_errors',
                    'data' => $jsonResponse,
                ]);
            } else {
                return response([
                    'status' => 'success',
                    'data' => $jsonResponse,
                ]);
            }
        } catch (\Exception$e) {
            return response(['status' => 'server_error',
                'message' => $e->getMessage(),], 500);
        }
    }


    public function getMobileData(Request $request)
    {
        $target = ManageNotification::where('notification_type', "mobile")->first();
        return response([
            'data'=>$target
        ]);
    }


}
