<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Radio;
use App\Models\TopListen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RadioController extends Controller
{
    /**
     * @OA\Get(
     ** path="/radio/by-country",
     *   operationId="GetData",
     *   tags={"Radio"},
     *   summary="Get Radio by country",
     *      @OA\Parameter(
     *          name="id",
     *          description="country_id",
     *          required=true,
     *          in="query"
     *      ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/

    public function indexByCountry(Request $request)
    {
        // dd($request->all());
        //    dd(request()->user('sanctum')['id']);
        try {
            $target = Radio::
                where('country_id', $request->id)->orderBy('id', 'desc')->get();
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
     * @OA\Post(
     ** path="/radio/show-by-country",
     *   operationId="Get single data by country",
     *   tags={"Radio"},
     *   summary="Get single Radio by country with radioId",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"device_id", "radio_id"},
     *               @OA\Property(property="device_id", type="string"),
     *               @OA\Property(property="radio_id", type="integer"),
     *               @OA\Property(property="user_id", type="integer"),
     *            ),
     *        ),
     *    ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/

    public function showByCountry(Request $request)
    {
        // dd($request->all());
        try {
            $target = Radio::where('id', $request->radio_id)->first();
            // dd($target);
            if ($target) {
                $topListen            = new TopListen;
                $topListen->radio_id  = $request->radio_id;
                $topListen->device_id = $request->device_id;
                $topListen->user_id   = $request->user_id ?? null;
                if ($topListen->save()) {
                    return response([
                        'status' => 'success',
                        'data'   => $target,
                    ], 200);
                }
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     ** path="/radio/by-language",
     *   operationId="get language",
     *   tags={"Radio"},
     *   summary="Get Radio by Language",
     *      @OA\Parameter(
     *          name="id",
     *          description="language_id",
     *          required=true,
     *          in="query"
     *      ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/

    public function indexByLanguage(Request $request)
    {
        // dd($languageId);
        try {
            $data = Radio::where('language_id', $request->id)->get();
            return response([
                'status' => 'success',
                // 'totalRadioByLanguage' => $totalRadioByLanguage,
                'data'   => $data,
            ], 200);
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     ** path="/radio/top-listen",
     *   operationId="Get Top Listen Radio",
     *   tags={"Radio"},
     *   summary="Get Top Listen Radio List",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"device_id"},
     *               @OA\Property(property="device_id", type="string"),
     *            ),
     *        ),
     *    ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/


    public function topListenRadio(Request $request)
    {
        // dd($request->all());
        try {
            $target = null;
            if ($request->user('sanctum')) {
                $target = Radio::withCount('top_listens')->whereHas('top_listens', function ($query) use ($request) {
                    $query->where('user_id', $request->user('sanctum')->id)->orWhere('device_id', $request->device_id);
                })->orderBy('top_listens_count', 'desc')->get();
            } else {
                $target = TopListen::where('device_id', $request->device_id)->where("user_id",auth()->id())->get();
                $target = Radio::withCount('top_listens')->whereHas('top_listens', function ($query) use ($request) {
                    $query->where('device_id', $request->device_id);
                })->orderBy('top_listens_count', 'desc')->get();
            }
            // dd($target);
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
     * @OA\get(
     ** path="/radio/free-channels",
     *   operationId="Get free channels",
     *   tags={"Radio"},
     *   summary="Get free channels Radio List",
     *   @OA\Parameter(
     *        name        = "id",
     *        description = "country_id",
     *        required    = true,
     *        in        = "query",
     *    ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/

    public function freeChannels(Request $request)
    {
        // dd($request->all());
        try {
            $target = Radio::where('country_id', $request->id)
                ->where('category', "free")
                ->get();
            // dd($target);
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
     * @OA\get(
     ** path="/radio/premium-channels",
     *   operationId="Get premium channels",
     *   tags={"Radio"},
     *   summary="Get premium channels Radio List",
     *   @OA\Parameter(
     *        name        = "id",
     *        description = "country_id",
     *        required    = true,
     *        in        = "query",
     *    ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/

    public function premiumChannels(Request $request)
    {
        // dd($request->all());
        try {
            $target = Radio::where('country_id', $request->id)
                ->where('category', "premium")
                ->get();
            // dd($target);
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
     * @OA\get(
     ** path="/radio/popular-channels",
     *   operationId="Get popular channels",
     *   tags={"Radio"},
     *   summary="Get popular channels Radio List",
     *   @OA\Parameter(
     *        name        = "id",
     *        description = "countryId",
     *        required    = true,
     *        in        = "query",
     *    ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/

    public function popularChannels(Request $request)
    {
        // dd($request->all());
        try {
            $radios = Radio::withCount('top_listens')
                ->has('top_listens')
                ->where('country_id', $request->id)
                ->orderBy('top_listens_count', 'desc')
                ->take(20)
                ->get();
            return response([
                'status' => 'success',
                'data'   => $radios,
            ], 200);
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\get(
     ** path="/radio/recent-played-channels",
     *   operationId="Get recent played channels",
     *   tags={"Radio"},
     *   security={{"bearerAuth":{}}},
     *   summary="Get recent played Radio List",
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/
    public function recentPlayed()
    {
         dd(auth()->id());

        try {
            $radios = TopListen::with(['radio','user'])
                ->where("user_id", auth()->id())->latest()->take(20)->get();
            return response([
                'status' => 'success',
                'data'   => $radios,
            ], 200);
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // $radios = Radio
    //             ::where('country_id', $countryId)
    //             ->whereHas('top_listens', function ($query) {
    //                 $query->where('user_id', auth()->id())->whereBetween('created_at', [today()->subDays(7), now()]);
    //             })->get();

    /**
     * @OA\Post(
     ** path="/radio/search",
     *   operationId="Get radio channels",
     *   tags={"Radio"},
     *   summary="Get radio search List",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"search_data"},
     *               @OA\Property(property="search_data", type="string"),
     *            ),
     *         ),
     *      ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Validation error"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/

    public function radioSearch(Request $request)
    {
        // dd($request->search_data);
        try {
            $result = Radio::where('radio_name', 'LIKE', '%' . $request->search_data . '%')->get();
            return response([
                'status' => 'success',
                'data'   => $result,
            ], 200);
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
