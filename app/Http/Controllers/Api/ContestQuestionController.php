<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\ContestQuestion;
use App\Models\ManageNotification;
use App\Models\ParticipantList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Validator;
class ContestQuestionController extends Controller
{
    public function index(Request $request)
    {
//        dd($request->all());
        $getAllContest = ContestQuestion::with(["contest_list"])->where("contest_id",$request->contestId)->orderBy('id', 'desc')->paginate(20);
        if ($getAllContest) {
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
                'question' => 'required',
                'option_one' => 'required',
                'option_two' => 'required',
                'option_three' => 'required',
                'option_four' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

             if (!$request->answer){
                 return response([
                     "status" => "error",
                     "message" => "Pleas Select the right answer"
                 ], 422);
             }

            $contest = new ContestQuestion();
            $contest->contest_id = $request->contest_id;
            $contest->question = $request->question;
            $contest->option_one = $request->option_one;
            $contest->option_two = $request->option_two;
            $contest->option_three = $request->option_three;
            $contest->option_four = $request->option_four;
            $contest->answer = $request->answer;
            $contest->status = "Ongoing";
            $contest->save();

            $api = ManageNotification::where('notification_type', 'mobile')->first();
            $apiKey = $api->api_key;
            $apiId = $api->api_id;
            $content = array(
                "en" => $request->question??"",
            );
            $headings = array(
                "en" => $request->question, // title
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
                'headings' => ['en' => $request->question],
                'contents' => $content,
            ];


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
                    'message' => "Notification Successfully Send",
                ]);
            }
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
                'question' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $contest = ContestQuestion::where("id", $id)->first();
            $contest->question = $request->question ?? $contest->question;
            $contest->option_one = $request->option_one ?? $contest->option_one;
            $contest->option_two = $request->option_two ?? $contest->option_two;
            $contest->option_three = $request->option_three ?? $contest->option_three;
            $contest->option_four = $request->option_four ?? $contest->option_four;
            $contest->answer = $request->answer ?? $contest->answer;
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
        $getSingleContest = ContestQuestion::where("id", $id)->first();
        if ($getSingleContest) {
            return response([
                "status" => "success",
                "data" => $getSingleContest
            ], 200);
        }
    }


    public function getParticipant($id)
    {
//        dd($id);
        $participantList = ParticipantList::where("contest_question_id", $id)->paginate(20);
        $contest = ContestQuestion::where("id", $id)->first();
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
        $contest = ContestQuestion::where("id", $id)->delete();
        $participantList = ParticipantList::where("contest_id", $id)->get();
        return response([
            "status" => "success",
        ]);
    }

    public function participantUser(Request $request)
    {
        try {

            //  dd(auth()->id());
            // dd($request->all());
            foreach($request->answer as $data){
                // dd($data['question_id']);
                $contest = new ParticipantList();
                $contest->contest_id = $request->contest_id;
                $contest->user_id = auth()->id();
                $contest->user_name = auth()->user()->name;
                $contest->contest_question_id = $data['question_id'];
                $contest->answer = $data['answer'];
                $contest->save();
            }

            $contestUser = Contest::where("id",$request->contest_id)->first();
            $contestUser->user_id = auth()->id();
            $contestUser->update();

                return response([
                    "status" => "success",
                    "message" => "Successfully Send"
                ], 200);



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
                $getAllContest = ContestQuestion::with(["contest_list"])->whereDate('created_at', today())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_day") {
                $getAllContest = ContestQuestion::with(["contest_list"])->whereDate('created_at', today()->subDay())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_week") {
                $getAllContest = ContestQuestion::with(["contest_list"])->whereDate('created_at', today()->subDays(6))->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_month") {
                $getAllContest = ContestQuestion::with(["contest_list"])->whereMonth('created_at', today()->subMonth())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_year") {
                $getAllContest = ContestQuestion::with(["contest_list"])->whereYear('created_at', today()->subYear())->paginate(20);
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
