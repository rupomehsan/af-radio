<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ManageNotification;
use App\Models\Notification;
use App\Models\Radio;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Response;
use Session;
use Validator;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $target = Notification::where("type","immediate")->paginate(20);
//             dd($target);
            return view('notification.index')->with(compact('target'));
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function scheduleIndex(Request $request)
    {
        try {
            $target = Notification::where("type","schedule")->paginate(20);
//             dd($target);
            return view('notification.schedule')->with(compact('target'));
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function linkedIndex(Request $request)
    {
        try {
            $target = Notification::where("type","linked")->paginate(20);
//             dd($target);
            return view('notification.linked')->with(compact('target'));
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function manageNotification(Request $request)
    {
        try {
            return view('notification.manageNotification');
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getMobileData(Request $request)
    {
        $target = ManageNotification::where('notification_type', $request->notification_type)->first();
//        $view   = view('notification.getMobileData', compact('target'))->render();
        return response([
            'data'=>$target
        ]);
    }
    public function getWebData(Request $request)
    {
        $target = ManageNotification::where('notification_type', $request->notification_type)->first();
        $view   = view('notification.getWebData', compact('target'))->render();
        return response()->json(['html' => $view]);
    }

    public function manageNotificationUpdate(Request $request)
    {
        try {
            // dd($request->all());

            if(auth()->user()->email !== "demoadmin@radio.com") {


            $rules = [];
            if ($request->notification_type == 'mobile') {
                $rules = [
                    'mobile_api_key' => 'required',
                    'mobile_api_id'  => 'required',
                ];
            }
            if ($request->notification_type == 'web') {
                $rules = [
                    'web_api_key' => 'required',
                    'web_api_id'  => 'required',
                ];
            }
            $validate = Validator::make(request()->all(), $rules);
            if ($validate->fails()) {
                return redirect('admin/notification/manage-notification')
                    ->withInput()
                    ->withErrors($validate);
            }

            $target                    = new ManageNotification;
            $target->notification_type = $request->notification_type;

            if ($request->notification_type == 'mobile') {
                $target->api_key = $request->mobile_api_key;
                $target->api_id  = $request->mobile_api_id;
            }

            if ($request->notification_type == 'web') {
                $target->api_key = $request->web_api_key;
                $target->api_id  = $request->web_api_id;
            }

            $prev = ManageNotification::where('notification_type', $request->notification_type)->first();
            if (!empty($prev)) {
                $prev->delete();
            }

            if ($target->save()) {
                Session::flash('success', "Manage Notification Updated Successfully!");
                return redirect('admin/notification/manage-notification');
            } else {
                Session::flash('error', "Manage Notification  Update Unsuccessfull!");
                return redirect('admin/notification/manage-notification');
            }

            }else{
                Session::flash('error', "Sorry You Are Demo User");
                return redirect('admin/notification/manage-notification');
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function create(Request $request)
    {
        $videoList = Radio::where('status', 'active')->pluck('radio_name', 'id')->toArray();
//        dd($videoList);
        $view      = view('notification.create', compact('videoList'))->render();
        return response()->json(['html' => $view]);
    }

    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $validate = Validator::make(request()->all(), [
                'title'  => 'required',
                'status' => Rule::in(['active', 'inactive']),
            ]);

            if ($validate->fails()) {
                return Response::json(['success' => false, 'heading' => 'Validtion Error', 'message' => $validate->errors()], 422);
            }
            $imageName = '';
            if (!empty($request->file('image'))) {
                $image     = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                if (config('app.env') === 'production') {
                    $image->move('uploads/notification', $imageName);
                } else {
                    $image->move(public_path('/uploads/notification'), $imageName);
                }
                $protocol = request()->secure() ? 'https://' : 'http://';
                $fileName = $protocol.$_SERVER['HTTP_HOST'].'/uploads/notification/'.$imageName;

            }

            $target                = new Notification;
            $target->title         = $request->title;
            $target->description   = $request->description;
            $target->image         = $fileName ?? '';
            $target->video_id      = $request->video_id;
            $target->external_link = $request->external_link;
            $target->status        = 'active';
            if ($target->save()) {
                return Response::json(['success' => true], 200);
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        if(auth()->user()->email !== "demoadmin@radio.com"){
            $target = Notification::find($id)->delete();
            return  response([
                "status" => "success",
                "message" => "Item Successfully delete"
            ]);
        }else{
            return Response::json(['status' => "error", 'message' => 'Sorry You are demo user',],422);
        }
    }

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


}
