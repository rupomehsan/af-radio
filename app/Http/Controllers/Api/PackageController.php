<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Response;
use Validator;

class PackageController extends Controller
{
    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $validator = Validator::make(request()->all(), [
                'name' => 'required',
                'price' => 'required',
                'validity' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $package = new Package();
            $package->name = $request->name;
            $package->price = $request->price;
            $package->validity = $request->validity;
            $package->description = $request->description;
            $package->status = $request->status;
            if ($package->save()) {
                return response([
                    "status" => "success",
                    "message" => "Package Successfully Create"
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
            $package = Package::where("id", $id)->first();
            $package->name = $request->name ?? $package->name;
            $package->price = $request->price ?? $package->price;
            $package->validity = $request->validity ?? $package->validity;
            $package->description = $request->description ?? $package->description;
            $package->status = $request->status ?? $package->status;
            if ($package->update()) {
                return response([
                    "status" => "success",
                    "message" => "Package Successfully Update"
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
        $playlist = Package::orderBy('id', 'desc')->paginate(20);
        return response([
            "status" => "success",
            "data" => $playlist
        ]);
    }

    public function getPackageMb()
    {
        $playlist = Package::get();
        return response([
            "status" => "success",
            "data" => $playlist
        ]);
    }

    public function show($id)
    {
        $playlist = Package::where("id", $id)->first();
        return response([
            "status" => "success",
            "data" => $playlist
        ]);
    }

    public function destroy($id)
    {
        Package::where("id", $id)->delete();
        return response([
            "status" => "success",
        ]);
    }

    public function getPlaylistSearchData(Request $request)
    {
        try {
            if ($request->value === "today") {
                $getAllContest = Package::whereDate('date', today())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_day") {
                $getAllContest = Package::whereDate('date', today()->subDay())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_week") {
                $getAllContest = Package::whereDate('date', today()->subWeek())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_month") {
                $getAllContest = Package::whereMonth('date', today()->subMonth())->paginate(20);
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            } else if ($request->value === "last_year") {
                $getAllContest = Package::whereYear('date', today()->subYear())->paginate(20);
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
