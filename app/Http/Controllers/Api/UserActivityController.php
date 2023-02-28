<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    public function statusChecker(Request $request)
    {
        try {
            if($request->type==="open"){
                $userActivity = UserActivity::where("device_id", $request->device_id)->first();
                if ($userActivity) {
                    $userActivity->status = 'online';
                    $userActivity->update();
                } else {
                    $usrAct = new UserActivity();
                    $usrAct->device_id = $request->device_id;
                    $usrAct->status = "online";
                    $usrAct->save();
                }
            }else{
                $userActivity = UserActivity::where("device_id", $request->device_id)->first();
                if ($userActivity) {
                    $userActivity->status = 'offline';
                    $userActivity->update();
                }
            }

            return response([
                "status" => "success",
            ], 200);
        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }

    }


    public function activeUserCount(){
        $acitveUser = UserActivity::where("status","online")->count();
        return response([
            "status"=>"success",
            "data"=>$acitveUser
        ]);
    }
}
