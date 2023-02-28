<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FavoriteList;
use App\Models\FavouriteList;
use App\Models\Radio;
use App\Models\RadioSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FavoritListController extends Controller
{
    /**
     * @OA\post(
     *      path="/favourite/radio/list",
     *      operationId="show",
     *      tags={"Favorite"},
     *      security={{"bearerAuth":{}}},
     *      summary="Show favorite Radio list",
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

    public function favoriteList(Request $request)
    {
        // dd($request->all());
        try {
            $target = FavouriteList::with(['schedule'])->where('user_id',auth()->id())->get();
            $timezoneUTC = \Carbon\Carbon::now()->timezone->toOffsetName();
            $target->program_start_time='';
            $target->program_end_time='';
            foreach($target as $item){
                $hourMinute = explode(':', $timezoneUTC);
                $hour = str_contains($hourMinute[0], '+') ? str_replace('+', '', $hourMinute[0]) : str_replace('-', '', $hourMinute[0]);
                $minute = $hourMinute[1];
                $item['schedule']->program_start_time = str_contains($hourMinute[0], '+') ? Carbon::parse($item['schedule']->start_time_utc_0)->addHours($hour)->addMinutes($minute)->format('G:i:s') : Carbon::parse($item['schedule']->start_time_utc_0)->subHours($hour)->subMinutes($minute)->format('h:i:s');
                $item['schedule']->program_end_time = str_contains($hourMinute[0], '+') ? Carbon::parse($item['schedule']->end_time_utc_0)->addHours($hour)->addMinutes($minute)->format('G:i:s') : Carbon::parse($item['schedule']->end_time_utc_0)->subHours($hour)->subMinutes($minute)->format('h:i:s');
            }
            return response([
                'status' => 'success',
                'data'   => $target,
            ], 200);
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * @OA\post(
     *      path="/favourite/radio/added",
     *      operationId="add",
     *      tags={"Favorite"},
     *      security={{"bearerAuth":{}}},
     *      summary="Show favorite Radio add",
    *       @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="query"
     *      ),
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

    public function favoriteListAdded(Request $request)
    {
        // dd($request->all());
        try {
            $target           = new FavouriteList();
            $target->user_id  = auth()->id();
            $target->schedule_id = $request->schedule_id;
            $target->radio_id = $request->radio_id;
            if ($target->save()) {
                return response([
                    "message" => "Added To Favorite List",
                    'status'  => 'success',
                    'data'    => $target,
                ], 200);
            }

        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

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
     * @OA\post(
     *      path="/favourite/radio/delete",
     *      operationId="radio delete",
     *      tags={"Favorite"},
     *      security={{"bearerAuth":{}}},
     *      summary="delete favorite radio list",
     *      summary="Get Radio by country",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="query"
     *      ),
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

    public function favoriteRadioDelete(Request $request)
    {
        // dd($request->all());
        try {
            $target = FavouriteList::where('user_id', auth()->id())->where('schedule_id', $request->schedule_id)->delete();
            if($target==true){
                return response([
                    'status'  => 'success',
                    'message' => "Delete From Favorite List",
                ], 200);
            }else{
                return response([
                    'status'  => 'error',
                    'message' => "Not Found",
                ], 200);
            }

        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
