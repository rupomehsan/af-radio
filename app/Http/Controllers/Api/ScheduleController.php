<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PopulerProgram;
use App\Models\Radio;
use App\Models\RadioSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ScheduleController extends Controller
{

    public function getScheduleByRadioId($id)
    {
//        dd($id);
        $schedule = RadioSchedule::where("radio_id", $id)->orderBy('id', 'desc')->paginate(20);
        $radio = Radio::where("id", $id)->first();
        if ($schedule) {
            return response([
                "status" => "success",
                "data" => $schedule,
            ]);
        }
    }

    public function getScheduleByRadioIdMb(Request $request, $id)
    {
//        dd($id);

        $timezoneUTC = \Carbon\Carbon::now()->timezone->toOffsetName();
        $day = strtolower(\Carbon\Carbon::now()->dayName);
        $schedule = RadioSchedule::where("radio_id", $id)->whereJsonContains('days',$day)->get();
        $schedule->program_start_time='';
        $schedule->program_end_time='';
        if ($schedule) {
            foreach ($schedule as $item) {
                $hourMinute = explode(':', $timezoneUTC);
                $hour = str_contains($hourMinute[0], '+') ? str_replace('+', '', $hourMinute[0]) : str_replace('-', '', $hourMinute[0]);
                $minute = $hourMinute[1];
                $item->program_start_time = str_contains($hourMinute[0], '+') ? Carbon::parse($item->start_time_utc_0)->addHours($hour)->addMinutes($minute)->format('G:i:s') : Carbon::parse($item->start_time_utc_0)->subHours($hour)->subMinutes($minute)->format('h:i:s');
                $item->program_end_time = str_contains($hourMinute[0], '+') ? Carbon::parse($item->end_time_utc_0)->addHours($hour)->addMinutes($minute)->format('G:i:s') : Carbon::parse($item->end_time_utc_0)->subHours($hour)->subMinutes($minute)->format('h:i:s');
            }
        }
        return response([
            "status" => "success",
            "data" => $schedule,
        ]);

    }


    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $validator = Validator::make(request()->all(), [
                'rss_name' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $timezoneUTC = \Carbon\Carbon::now()->timezone->toOffsetName();
//            dd($timezoneUTC);
            $contest = new RadioSchedule();
            $contest->radio_id = $request->radio_id;
            $contest->rss_name = $request->rss_name;
            $contest->title = $request->title;
            $contest->description = $request->description;
            $contest->summary = $request->summary;
            $contest->days = $request->days;
            $contest->time_zone = $request->time_zone;
            $contest->start_time = $request->start_time;
            $contest->end_time = $request->end_time;

            $hourMinute = explode(':', $timezoneUTC);
            $hour = str_contains($hourMinute[0], '+') ? str_replace('+', '', $hourMinute[0]) : str_replace('-', '', $hourMinute[0]);
            $minute = $hourMinute[1];
            $contest->start_time_utc_0 = str_contains($hourMinute[0], '+') ? Carbon::parse($request->start_time)->subHours($hour)->subMinutes($minute)->format('G:i:s') : Carbon::parse($request->start_time)->addHours($hour)->addMinutes($minute)->format('h:i:s');
            $contest->end_time_utc_0 = str_contains($hourMinute[0], '+') ? Carbon::parse($request->end_time)->subHours($hour)->subMinutes($minute)->format('G:i:s') : Carbon::parse($request->end_time)->addHours($hour)->addMinutes($minute)->format('h:i:s');
//            dd($contest);
            $contest->status = "active";

            if (request()->has('thumbnail')) {
                $folder = "uploads/schedule";
                $image = $request->file('thumbnail');
                $imageName = "/" . $folder . "/" . $contest->rss_name . '-' . rand(100, 999) . time() . '.' . $image->getClientOriginalExtension();
                $image->move($folder, $imageName);
                $contest->thumbnail = $imageName;

            }
            if (request()->has('main')) {
                $folder = "uploads/schedule";
                $image = $request->file('main');
                $imageName = "/" . $folder . "/" . $contest->rss_name . '-' . rand(100, 999) . time() . '.' . $image->getClientOriginalExtension();
                $image->move($folder, $imageName);
                $contest->main_image = $imageName;
            }

            if ($contest->save()) {
                return response([
                    "status" => "success",
                    "message" => "Schedule Successfully Create"
                ], 200);
            }


        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }

    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        try {
            $validator = Validator::make(request()->all(), [
                'rss_name' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }


            $contest = RadioSchedule::where("id", $id)->first();
            $contest->rss_name = $request->rss_name ?? $contest->rss_name;
            $contest->title = $request->title ?? $contest->title;
            $contest->description = $request->description ?? $contest->description;
            $contest->summary = $request->summary ?? $contest->summary;
            $contest->days = $request->days ?? $contest->days;
            $contest->time_zone = $request->time_zone ?? $contest->time_zone;
            $contest->start_time = $request->start_time ?? $contest->start_time;
            $contest->end_time = $request->end_time ?? $contest->end_time;

            $timezoneUTC = \Carbon\Carbon::now()->timezone->toOffsetName();
            $hourMinute = explode(':', $timezoneUTC);
            $hour = str_contains($hourMinute[0], '+') ? str_replace('+', '', $hourMinute[0]) : str_replace('-', '', $hourMinute[0]);
            $minute = $hourMinute[1];
            $contest->start_time_utc_0 = str_contains($hourMinute[0], '+') ? Carbon::parse($request->start_time)->subHours($hour)->subMinutes($minute)->format('G:i:s') : Carbon::parse($request->start_time)->addHours($hour)->addMinutes($minute)->format('h:i:s');
            $contest->end_time_utc_0 = str_contains($hourMinute[0], '+') ? Carbon::parse($request->end_time)->subHours($hour)->subMinutes($minute)->format('G:i:s') : Carbon::parse($request->end_time)->addHours($hour)->addMinutes($minute)->format('h:i:s');
//            dd($contest);


            if (request()->has('thumbnail')) {
                $folder = "uploads/schedule";
                $image = $request->file('thumbnail');
                $imageName = "/" . $folder . "/" . $contest->rss_name . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($folder, $imageName);
                $contest->thumbnail = $imageName;

            }
            if (request()->has('main')) {
                $folder = "uploads/schedule";
                $image = $request->file('main');
                $imageName = "/" . $folder . "/" . $contest->rss_name . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($folder, $imageName);
                $contest->main_image = $imageName;
            }
            if ($contest->update()) {
                return response([
                    "status" => "success",
                    "message" => "Schedule Successfully Update"
                ], 200);
            }


        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }

    }

    public function show($id)
    {
        $schedule = RadioSchedule::where("id", $id)->first();
        if ($schedule) {
            return response([
                "status" => "success",
                "data" => $schedule
            ]);
        }
    }

    public function destroy($id)
    {
        $schedule = RadioSchedule::where("id", $id)->delete();
        return response([
            "status" => "success",
        ]);
    }


    public function getRadioSearchData(Request $request)
    {
        try {
            if ($request->value === "today") {
                $getAllContest = RadioSchedule::whereDate('created_at', today())->get();
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_day") {
                $getAllContest = RadioSchedule::whereDate('created_at', today()->subDay())->get();
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_week") {
                $getAllContest = RadioSchedule::whereDate('created_at', today()->subDays(6))->get();
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_month") {
                $getAllContest = RadioSchedule::whereMonth('created_at', today()->subMonth())->get();
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_year") {
                $getAllContest = RadioSchedule::whereYear('created_at', today()->subYear())->get();
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

    public function getSearchData(Request $request)
    {
        try {
            $timezoneUTC = \Carbon\Carbon::now()->timezone->toOffsetName();
            $schedule = RadioSchedule::where('title', 'LIKE', '%' . $request->search_data . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search_data . '%')
                ->orWhere('rss_name', 'LIKE', '%' . $request->search_data . '%')
                ->get();
            $schedule->program_start_time='';
            $schedule->program_end_time='';
            if ($schedule) {
                foreach ($schedule as $item) {
                    $hourMinute = explode(':', $timezoneUTC);
                    $hour = str_contains($hourMinute[0], '+') ? str_replace('+', '', $hourMinute[0]) : str_replace('-', '', $hourMinute[0]);
                    $minute = $hourMinute[1];
                    $item->program_start_time = str_contains($hourMinute[0], '+') ? Carbon::parse($item->start_time_utc_0)->addHours($hour)->addMinutes($minute)->format('G:i:s') : Carbon::parse($item->start_time_utc_0)->subHours($hour)->subMinutes($minute)->format('h:i:s');
                    $item->program_end_time = str_contains($hourMinute[0], '+') ? Carbon::parse($item->end_time_utc_0)->addHours($hour)->addMinutes($minute)->format('G:i:s') : Carbon::parse($item->end_time_utc_0)->subHours($hour)->subMinutes($minute)->format('h:i:s');
                }
            }
            return response([
                'status' => 'success',
                'data' => $schedule,
            ], 200);

        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }
    }


    public function populerProgram(Request $request)
    {
        $populerProgram = new PopulerProgram();
        $populerProgram->radio_id = $request->radio_id;
        $populerProgram->schedule_id = $request->schedule_id;
        $populerProgram->save();
        return response([
            "status" => "success"
        ]);
    }

    public function getPopulerProgram(Request $request, $id)
    {
        $timezoneUTC = \Carbon\Carbon::now()->timezone->toOffsetName();
        $schedule = RadioSchedule::where("radio_id", $id)->withCount('populer_programs')->whereHas('populer_programs')->orderBy('populer_programs_count', 'DESC')->get();
        $schedule->program_start_time='';
        $schedule->program_end_time='';
        if ($schedule) {
            foreach ($schedule as $item) {
                $hourMinute = explode(':', $timezoneUTC);
                $hour = str_contains($hourMinute[0], '+') ? str_replace('+', '', $hourMinute[0]) : str_replace('-', '', $hourMinute[0]);
                $minute = $hourMinute[1];
                $item->program_start_time = str_contains($hourMinute[0], '+') ? Carbon::parse($item->start_time_utc_0)->addHours($hour)->addMinutes($minute)->format('G:i:s') : Carbon::parse($item->start_time_utc_0)->subHours($hour)->subMinutes($minute)->format('h:i:s');
                $item->program_end_time = str_contains($hourMinute[0], '+') ? Carbon::parse($item->end_time_utc_0)->addHours($hour)->addMinutes($minute)->format('G:i:s') : Carbon::parse($item->end_time_utc_0)->subHours($hour)->subMinutes($minute)->format('h:i:s');
            }
        }
        return response([
            "status" => "success",
            "data" => $schedule,
        ]);
    }


}
