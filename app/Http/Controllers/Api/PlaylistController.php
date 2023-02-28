<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Validator;

class PlaylistController extends Controller
{
    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $validator = Validator::make(request()->all(), [
                'date' => 'required',
                'audio_type' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $todayList = Playlist::where('date', $request->date)->first();

            if ($todayList) {
                return response([
                    "status" => "error",
                    "message" => "Sorry you already created playlist on this date"
                ], 422);
            } else {
                $playlist = new Playlist();
                $playlist->date = $request->date;
                $playlist->audio_type = $request->audio_type;
                $playlist->image = $request->image;
                $playlist->status = "active";
                $audioArray = [];
                $linkArray = [];
                if (request()->has('audio')) {
//                    dd($request->audio);
                    foreach ($request->audio['title'] as $index => $title) {
//                        dd($request->audio['link'][$index]);
                        if ($title===null){
                            return response([
                                "status" => "error",
                                "message" => "Sorry item field must not be empty"
                            ], 422);
                        }else if ($request->audio['link'][$index]===null){
                            return response([
                                "status" => "error",
                                "message" => "Sorry item field must not be empty"
                            ], 422);
                        }else{

                            $linkArray[] = [
                                "title" => $title,
                                "link" => $request->audio['link'][$index]
                            ];
                        }

                    }
                }

                if (request()->has('audio_title')){
                    foreach ($request->audio_title as $index => $title) {
                        if($title===null){
                            return response([
                                "status" => "error",
                                "message" => "Sorry item field must not be empty"
                            ], 422);
                        }

                    }
                    if (!request()->has('audio_file')) {
                        return response([
                            "status" => "error",
                            "message" => "Sorry you do not select file"
                        ], 422);
                    }

                }

                if (request()->has('audio_file')) {
                    foreach ($request->file('audio_file') as $index => $files) {
                        if($request->audio_title[$index]===null){
                            return response([
                                "status" => "error",
                                "message" => "Sorry item field must not be empty"
                            ], 422);
                        }else{
                            $folder = "uploads/audio";
                            $image = $files;
                            $imageName = "/" . $folder . "/" . rand(10000, 99900) . time() . '.' . $image->getClientOriginalExtension();
                            $image->move($folder, $imageName);
                            $audioArray[] = [
                                'title' => $request->audio_title[$index],
                                'file' => $imageName
                            ];
                        }

                    }
                }

//            dd($audioArray);

                $playlist->audio_file = $audioArray;
                $playlist->audio_link = $linkArray;
                if ($playlist->save()) {
                    return response([
                        "status" => "success",
                        "message" => "Playlist Successfully Create"
                    ], 200);
                }
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
            $exist = Playlist::where("id", "!=", $id)->where("date", $request->date)->first();

            if (!$exist) {
                $playlist = Playlist::where("id", $id)->first();
                $playlist->date = $request->date ??$playlist->date;
                $playlist->image = $request->imageEdit ??$playlist->image;
                $playlist->audio_type = $request->audio_type;
                $existDataArray = [];
                $existDataArray = $playlist->audio_file;
                $audioArray = [];
                $linkArray = [];
                if (request()->has('audio')) {
                    foreach ($request->audio['title'] as $index => $title) {

                        $linkArray[] = [
                            "title" => $title,
                            "link" => $request->audio['link'][$index]
                        ];
                    }
                }

                if (request()->has('audio_file')) {
                    foreach ($request->file('audio_file') as $index => $files) {
                        $folder = "uploads/audio";
                        $image = $files;
                        $imageName = "/" . $folder . "/" . rand(10000, 99900) . time() . '.' . $image->getClientOriginalExtension();
                        $image->move($folder, $imageName);
                        $audioArray[] = [
                            'title' => $request->audio_title[$index],
                            'file' => $imageName
                        ];
                    }
                }

                $margetArray = array_merge($existDataArray, $audioArray);
                $playlist->audio_link = $linkArray;
                $playlist->audio_file = $margetArray;
                if ($playlist->update()) {
                    return response([
                        "status" => "success",
                        "message" => "Playlist Successfully Update"
                    ], 200);
                }
            } else {
                return response([
                    "status" => "error",
                    "message" => "Sorry you already created playlist on this date"
                ], 422);
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
        $playlist = Playlist::orderBy('id', 'desc')->paginate(20);
        return response([
            "status" => "success",
            "data" => $playlist
        ]);
    }

    public function show($id)
    {
        $playlist = Playlist::where("id", $id)->first();
        return response([
            "status" => "success",
            "data" => $playlist
        ]);
    }

    public function destroy($id)
    {
        Playlist::where("id", $id)->delete();
        return response([
            "status" => "success",
        ]);
    }

    public function getPlaylistSearchData(Request $request)
    {
        try {
            if ($request->value === "today") {
                $getAllContest = Playlist::whereDate('date', today())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_day") {
                $getAllContest = Playlist::whereDate('date', today()->subDay())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_week") {
                $getAllContest = Playlist::whereDate('date', today()->subWeek())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_month") {
                $getAllContest = Playlist::whereMonth('date', today()->subMonth())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_year") {
                $getAllContest = Playlist::whereYear('date', today()->subYear())->paginate(20);
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
        $playlist = Playlist::where("id", $request->contestId)->first();
        foreach ($playlist->audio_file as $index => $file) {
//            dd($index);
            if ((int)$request->id !== $index) {
                $audioArray[] = [
                    "title" => $file['title'],
                    "file" => $file['file'],
                ];
            }
        }
//        dd($audioArray);
        $playlist->audio_file = $audioArray;
        $playlist->update();
        return response([
            "status" => "success",
            "message" => "Successfully remove"
        ]);
    }


}
