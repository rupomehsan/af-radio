<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BirthdayWish;
use Illuminate\Http\Request;
use Validator;
class BirthdayWishController extends Controller
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

            $birthdayWish = new BirthdayWish();
            $birthdayWish->text = $request->text;

            if (request()->has('audio')) {
                $folder = "uploads/audio";
                $audio = $request->file('audio');
                $audioName = "/" . $folder . "/" . rand(10000, 99900) . time() . '.' . $audio->getClientOriginalExtension();
                $audio->move($folder, $audioName);
            }
            $birthdayWish->audio = $audioName??"";


            if ($birthdayWish->save()) {
                return response([
                    "status" => "success",
                    "message" => "Birthday Wish Successfully Send"
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
        $birthdayWish= BirthdayWish::orderBy('id', 'desc')->paginate(20);
        if($birthdayWish){
            return response([
                "status"=>"success",
                "data"=>$birthdayWish
            ]);
        }
    }

    public function update(Request $request,$id){
        $birthdayWish= BirthdayWish::where("id",$id)->first();
        $birthdayWish->status= "yes";
        $birthdayWish->update();
        return response([
            "status"=>"success",
            "message"=>"Responsed Successfully"
        ]);
    }

    public function destroy($id){
        BirthdayWish::find($id)->delete();
        return response([
            "status"=>"success",
            "message"=>"Successfully Delete"
        ]);
    }

    public function getSearchData(Request $request){
        try {
            if($request->value==="today"){
                $getAllContest = BirthdayWish::whereDate('created_at', today())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_day"){
                $getAllContest = BirthdayWish::whereDate('created_at', today()->subDay())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_week"){
                $getAllContest = BirthdayWish::whereDate('created_at', today()->subDays(7))->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_month"){
                $getAllContest = BirthdayWish::whereMonth('created_at', today()->subMonth())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_year"){
                $getAllContest = BirthdayWish::whereYear('created_at',today()->subYear())->paginate(20);
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
