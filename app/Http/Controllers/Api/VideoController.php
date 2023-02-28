<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Validator;
class VideoController extends Controller
{
    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $validator = Validator::make(request()->all(), [
                'video_link' => 'required',
                'video_title' => 'required',
                'video_type' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $video = new Video();
            $video->video_title = $request->video_title;
            $video->video_type = $request->video_type;
            $video->video_link = $request->video_link;
            $video->status = "active";

            if ($video->save()) {
                return response([
                    "status" => "success",
                    "message" => "Video  Successfully Create"
                ], 200);
            }

        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }
    }

    function update(Request $request, $id)
    {
//        dd($request->all());
        try {
            $validator = Validator::make(request()->all(), [
//                'data' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $video = Video::where("id", $id)->first();
            $video->video_title = $request->video_title;
            $video->video_type = $request->video_type ??$video->video_type;
            $video->video_link = $request->video_link ?? $video->video_link;

            if ($video->update()) {
                return response([
                    "status" => "success",
                    "message" => "Video Successfully Update"
                ], 200);
            }

        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }
    }

    public function index()
    {
        $video = Video::orderBy('id', 'desc')->paginate(20);
        return response([
            "status" => "success",
            "data" => $video
        ]);
    }

    public function show($id)
    {
        $video = Video::where("id", $id)->first();
        return response([
            "status" => "success",
            "data" => $video
        ]);
    }

    public function destroy($id)
    {
        Video::where("id", $id)->delete();
        return response([
            "status" => "success",
        ]);
    }

    public  function getAllVideoData(){
        $getData = Video::get();
        if($getData){
            return response([
                "status"=>"success",
                "data"=>$getData
            ]);
        }
    }

    public function getPlaylistSearchData(Request $request)
    {
        try {
            if ($request->value === "today") {
                $getAllContest = Video::whereDate('date', today())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_day") {
                $getAllContest = Video::whereDate('date', today()->subDay())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_week") {
                $getAllContest = Video::whereDate('date', today()->subDays(7))->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_month") {
                $getAllContest = Video::whereMonth('date', today()->subMonth())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_year") {
                $getAllContest = Video::whereYear('date', today()->subYear())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else {
                return response([
                    "status" => "error",
                    "message" => "Data Not Found"
                ], 200);

            }

        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }
    }

    public function audioDelete(Request $request)
    {
//        dd($request->all());
        $audioArray = [];
        $video = Video::where("id", $request->contestId)->first();
        foreach ($video->audio_file as $index => $file) {
//            dd($index);
            if ((int)$request->id !== $index) {
                $audioArray[] = [
                    "title" => $file['title'],
                    "file" => $file['file'],
                ];
            }
        }
//        dd($audioArray);
        $video->audio_file = $audioArray;
        $video->update();
        return response([
            "status" => "success",
            "message" => "Successfully remove"
        ]);
    }


}
