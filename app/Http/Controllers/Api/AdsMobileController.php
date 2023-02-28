<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MobileAd;
use App\Models\Notification;
use App\Models\Premium;
use App\Models\Setting;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AdsMobileController extends Controller
{
    public function __construct()
    {
        if (!file_exists(storage_path('installed')) || !file_exists(base_path('vendor/licensed'))) {
            if (Route::has('/installation')) {
                return redirect('/installation');
            } else {
                abort(500);
            }
        }
    }

    /**
     * @OA\Get(
     *      path="/ads-mobile",
     *      operationId="index",
     *      tags={"Mobile Ads"},
     *      summary="Get list of Mobile Ads",
     *      description="Returns list of Mobile Ads",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="server error"
     *      )
     *     )
     */
    public function index(Request $request)
    {
        try {
            $target = MobileAd::get();
            return response([
                'status' => 'success',
                'data' => $target,
            ], 200);
        } catch (\Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/about/about-us",
     *      operationId="index",
     *      tags={"About Us"},
     *      summary="Get  About us",
     *      description="Returns list of About Us",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="server error"
     *      )
     *     )
     */
    public function about(Request $request)
    {
        try {
            $target = Setting::first();
            return response([
                'status' => 'success',
                'data' => $target,
            ], 200);
        } catch (\Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/notification",
     *      operationId="index",
     *      tags={"Notification"},
     *      summary="Get Notification",
     *      description="Returns list of About Us",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="server error"
     *      )
     *   )
     */
    public function notification(Request $request)
    {
        try {
            $target = Notification::with(['radio'])->orderBy('id', 'desc')->get();
            return response([
                'status' => 'success',
                'data' => $target,
            ], 200);
        } catch (\Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function setPremiumStatus(Request $request)
    {
        if ($request->value === "playlist") {
            $exist = Premium::where("service_name",$request->value)->first();
            if ($exist) {
                $exist->service_name = $request->value;
                $exist->status = $request->status;
                $exist->update();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            } else {
                $premium = new Premium();
                $premium->service_name = $request->value;
                $premium->status = $request->status;
                $premium->save();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            }

        } else if ($request->value === "on-demand") {
            $exist = Premium::where("service_name",$request->value)->first();
            if ($exist) {
                $exist->service_name = $request->value;
                $exist->status = $request->status;
                $exist->update();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            } else {
                $premium = new Premium();
                $premium->service_name = $request->value;
                $premium->status = $request->status;
                $premium->save();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            }
        } else if ($request->value === "video") {
            $exist = Premium::where("service_name",$request->value)->first();
            if ($exist) {
                $exist->service_name = $request->value;
                $exist->status = $request->status;
                $exist->update();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            } else {
                $premium = new Premium();
                $premium->service_name = $request->value;
                $premium->status = $request->status;
                $premium->save();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            }
        } else if ($request->value === "shoutouts") {
            $exist = Premium::where("service_name",$request->value)->first();
            if ($exist) {
                $exist->service_name = $request->value;
                $exist->status = $request->status;
                $exist->update();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            } else {
                $premium = new Premium();
                $premium->service_name = $request->value;
                $premium->status = $request->status;
                $premium->save();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            }
        } else if ($request->value === "live-request") {
            $exist = Premium::where("service_name",$request->value)->first();
            if ($exist) {
                $exist->service_name = $request->value;
                $exist->status = $request->status;
                $exist->update();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            } else {
                $premium = new Premium();
                $premium->service_name = $request->value;
                $premium->status = $request->status;
                $premium->save();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            }
        } else if ($request->value === "birthday-wish") {
            $exist = Premium::where("service_name",$request->value)->first();
            if ($exist) {
                $exist->service_name = $request->value;
                $exist->status = $request->status;
                $exist->update();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            } else {
                $premium = new Premium();
                $premium->service_name = $request->value;
                $premium->status = $request->status;
                $premium->save();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            }
        } else if ($request->value === "contest") {
            $exist = Premium::where("service_name",$request->value)->first();
            if ($exist) {
                $exist->service_name = $request->value;
                $exist->status = $request->status;
                $exist->update();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            } else {
                $premium = new Premium();
                $premium->service_name = $request->value;
                $premium->status = $request->status;
                $premium->save();
                return response([
                    "status" => "success",
                    "message" => "Status Successfully Change"
                ]);
            }
        }
    }

    public function  getPremiumStatus(){
        $getData = Premium::get();
        if ($getData){
            return response([
                "status"=>"success",
                "data"=>$getData
            ]);
        }
    }


    public function getSearchData(Request $request){
        try {
//            dd($request->all());
            if($request->value==="today"){
                $getAllContest = Notification::where("type",$request->type)->whereDate('created_at', today())->get();
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_day"){
                $getAllContest = Notification::where("type",$request->type)->whereDate('created_at', today()->subDay())->get();
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_week"){
                $getAllContest = Notification::where("type",$request->type)->whereDate('created_at', today()->subDays(6))->get();
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_month"){
                $getAllContest = Notification::where("type",$request->type)->whereMonth('created_at', today()->subMonth())->get();
                if ($getAllContest) {
                    return response([
                        "status" => "success",
                        "data" => $getAllContest
                    ], 200);
                }
            }else if($request->value==="last_year"){
                $getAllContest = Notification::where("type",$request->type)->whereYear('created_at',today()->subYear())->get();
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
