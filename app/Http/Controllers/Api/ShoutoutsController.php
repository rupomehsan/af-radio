<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shoutout;
use Illuminate\Http\Request;
use Validator;

class ShoutoutsController extends Controller
{
    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $validator = Validator::make(request()->all(), [
//                'text' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $shoutout = new Shoutout();
            $shoutout->text = $request->text;

            if (request()->has('audio')) {
                $folder = "uploads/audio";
                $audio = $request->file('audio');
                $audioName = "/" . $folder . "/" . rand(10000, 99900) . time() . '.' . $audio->getClientOriginalExtension();
                $audio->move($folder, $audioName);
            }
            $shoutout->audio = $audioName??"";


            if ($shoutout->save()) {
                return response([
                    "status" => "success",
                    "message" => "Shoutout Successfully Send"
                ], 200);
            }

        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }
    }

    public function index(){
        $showtouts= Shoutout::orderBy('id', 'desc')->paginate(20);
        if($showtouts){
            return response([
                "status"=>"success",
                "data"=>$showtouts
            ]);
        }
    }

    public function update(Request $request,$id){
        $showtouts= Shoutout::where("id",$id)->first();
        $showtouts->status= "yes";
        $showtouts->update();
        return response([
            "status"=>"success",
            "message"=>"Responsed Successfully"
        ]);
    }

    public function destroy($id){
        Shoutout::find($id)->delete();
        return response([
            "status"=>"success",
            "message"=>"Successfully Delete"
        ]);
    }

    public function getSearchData(Request $request){
        try {
            if($request->value==="today"){
                $getAllContest = Shoutout::whereDate('created_at', today())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_day"){
                $getAllContest = Shoutout::whereDate('created_at', today()->subDay())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_week"){
                $getAllContest = Shoutout::whereDate('created_at', today()->subDays(7))->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_month"){
                $getAllContest = Shoutout::whereMonth('created_at', today()->subMonth())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_year"){
                $getAllContest = Shoutout::whereYear('created_at',today()->subYear())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else {
                return response([
                    "status" => "error",
                    "message" => "Data Not Found"
                ], 200);

            }

        }catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }
    }


}
