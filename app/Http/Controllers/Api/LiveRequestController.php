<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveRequest;
use Illuminate\Http\Request;
use Validator;
class LiveRequestController extends Controller
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

            $liveRequest = new LiveRequest();
            $liveRequest->text = $request->text;

            if (request()->has('audio')) {
                $folder = "uploads/audio";
                $audio = $request->file('audio');
                $audioName = "/" . $folder . "/" . rand(10000, 99900) . time() . '.' . $audio->getClientOriginalExtension();
                $audio->move($folder, $audioName);
            }
            $liveRequest->audio = $audioName??"";


            if ($liveRequest->save()) {
                return response([
                    "status" => "success",
                    "message" => "LiveRequest Successfully Send"
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
        $liveRequest= LiveRequest::orderBy('id', 'desc')->paginate(20);
        if($liveRequest){
            return response([
                "status"=>"success",
                "data"=>$liveRequest
            ]);
        }
    }

    public function update(Request $request,$id){
        $liveRequest= LiveRequest::where("id",$id)->first();
        $liveRequest->status= "yes";
        $liveRequest->update();
        return response([
            "status"=>"success",
            "message"=>"Responsed Successfully"
        ]);
    }

    public function destroy($id){
        LiveRequest::find($id)->delete();
        return response([
            "status"=>"success",
            "message"=>"Successfully Delete"
        ]);
    }

    public function getSearchData(Request $request){
        try {
            if($request->value==="today"){
                $getAllContest = LiveRequest::whereDate('created_at', today())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_day"){
                $getAllContest = LiveRequest::whereDate('created_at', today()->subDay())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_week"){
                $getAllContest = LiveRequest::whereDate('created_at', today()->subDays(7))->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_month"){
                $getAllContest = LiveRequest::whereMonth('created_at', today()->subMonth())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_year"){
                $getAllContest = LiveRequest::whereYear('created_at',today()->subYear())->paginate(20);
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
