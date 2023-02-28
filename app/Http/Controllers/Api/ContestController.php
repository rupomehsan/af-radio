<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\ManageNotification;
use App\Models\ParticipantList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Response;
use Validator;

class ContestController extends Controller
{

    public function index()
    {
        $getAllContest = Contest::orderBy('id', 'desc')->paginate(20);
        if ($getAllContest) {
            return response([
                "status" => "success",
                "data" => $getAllContest
            ], 200);
        }
    }

    public function getContestWithQuestions(Request $request)
    {
        //   dd(auth()->id());
        $isParticipent = "false";
        $getAllContest = Contest::with(['questions'])->whereDate("created_at",Carbon::today())->first();
        if($getAllContest){
           if(request()->user('sanctum') && $getAllContest->user_id){
            if((int)$getAllContest->user_id === request()->user('sanctum')['id']){
                $isParticipent = "true";
              }
           }
        $getAllContest->isparticipent= $isParticipent;

        if ($getAllContest) {
            return response([
                "status" => "success",
                "data" => $getAllContest
            ], 200);
        }
        }else{
              return response([
                "status" => "success",
                "data" => $getAllContest
            ], 200);
        }

    }


    public function store(Request $request)
    {

        try {
//            dd($request->all());

            $validator = Validator::make(request()->all(), [
                'title' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $contest = new Contest();
            $contest->title = $request->title;
            $contest->start_date = $request->start_date;
            $contest->end_date = $request->end_date;
            $contest->status = "Ongoing";
            $contest->save();
            return response([
                "status" => "success",
                "message" => "Contest Successfully Added"
            ], 200);

        } catch (\Exception$e) {
            return response(['status' => 'server_error',
                'message' => $e->getMessage(),], 500);
        }

    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        try {
            $validator = Validator::make(request()->all(), [
                'title' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $contest = Contest::where("id", $id)->first();
            $contest->title = $request->title ?? $contest->title;
            $contest->start_date = $request->start_date ?? $contest->start_date;
            $contest->end_date = $request->end_date ?? $contest->end_date;
            $contest->status = "Ongoing" ?? $contest->status;
            if ($contest->update()) {
                return response([
                    "status" => "success",
                    "message" => "Contest Successfully Update"
                ], 200);
            }


        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }
        $validate = Validator::make(request()->all(), [
            'question' => 'required',
        ]);


    }


    public function show($id)
    {
        $getSingleContest = Contest::where("id", $id)->first();
        if ($getSingleContest) {
            return response([
                "status" => "success",
                "data" => $getSingleContest
            ], 200);
        }
    }


    public function getParticipant($id)
    {
        $participantList = ParticipantList::where("contest_id", $id)->paginate(20);
        $contest = Contest::where("id", $id)->first();
        if ($participantList) {
            return response([
                "status" => "success",
                "data" => $participantList,
                "contest" => $contest
            ]);
        }
    }

    public function destroy($id)
    {
        $contest = Contest::where("id", $id)->delete();
        $participantList = ParticipantList::where("contest_id", $id)->get();
        return response([
            "status" => "success",
        ]);
    }

    public function participantUser(Request $request)
    {
        try {
            $validator = Validator::make(request()->all(), [
                'user_name' => 'required',
                'answer' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $contest = new ParticipantList();
            $contest->contest_id = $request->contest_id;
            $contest->user_name = $request->user_name;
            $contest->answer = $request->answer;
            if ($contest->save()) {
                return response([
                    "status" => "success",
                    "message" => "Successfully Send"
                ], 200);
            }


        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }
    }


    public function getContestSearchData(Request $request)
    {
        try {
            if ($request->value === "today") {
                $getAllContest = Contest::whereDate('created_at', today())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_day") {
                $getAllContest = Contest::whereDate('created_at', today()->subDay())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_week") {
                $getAllContest = Contest::whereDate('created_at', today()->subDays(6))->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_month") {
                $getAllContest = Contest::whereMonth('created_at', today()->subMonth())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_year") {
                $getAllContest = Contest::whereYear('created_at', today()->subYear())->paginate(20);
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


}
