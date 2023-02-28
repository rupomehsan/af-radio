<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseSubscription;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Validator;

class SubscriptionController extends Controller
{
    /**
     * @OA\Get(
     *      path="/subscription/get-all",
     *      operationId="index",
     *      tags={"Subscription Management"},
     *      summary="All Subscription data",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Success"
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error"
     *      )
     *     )
     */
    public function index(Request $request)
    {
        try {
            $target = PurchaseSubscription::with(['user'])->get();
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
     ** path="/subscription/store",
     *   operationId="store",
     *   security={{"bearerAuth":{}}},
     *   tags={"Subscription Management"},
     *   summary="Add a new Subscription",
     *
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="orderId", type="text"),
     *               @OA\Property(property="packageName", type="text"),
     *               @OA\Property(property="productId", type="text"),
     *               @OA\Property(property="purchaseTime", type="text"),
     *               @OA\Property(property="purchaseState", type="text"),
     *               @OA\Property(property="purchaseToken", type="text"),
     *               @OA\Property(property="quantity", type="text"),
     *               @OA\Property(property="autoRenewing", type="int"),
     *               @OA\Property(property="acknowledged", type="int"),
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
     *  @OA\Response(
     *      response=404,
     *      description="Bad Request"
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
    public function store(Request $request)
    {
        try {
            $subscription                = new PurchaseSubscription();
            $subscription->user_id       = auth()->id();
            $subscription->orderId       = $request->orderId;
            $subscription->packageName   = $request->packageName;
            $subscription->productId     = $request->productId;
            $subscription->purchaseTime  = $request->purchaseTime;
            $subscription->purchaseState = $request->purchaseState;
            $subscription->purchaseToken = $request->purchaseToken;
            $subscription->quantity      = $request->quantity;
            $subscription->autoRenewing  = $request->autoRenewing;
            $subscription->acknowledged  = $request->acknowledged;

            if ($subscription->save()) {
                return response([
                    'status'  => 'success',
                    'message' => 'Subscription Purchase Successfully',
                ], 200);
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
     *      path="/subscription/package/get-all",
     *      operationId="packageIndex",
     *      tags={"Subscription Management"},
     *      summary="All Subscription data",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Success"
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error"
     *      )
     *     )
     */
    public function packageIndex(Request $request)
    {
        try {
            $target = SubscriptionPackage::get();
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
     * @OA\Post(
     ** path="/subscription/package/store",
     *   operationId="packageStore",
     *   tags={"Subscription Management"},
     *   summary="Add a new Subscription",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="productId", type="text"),
     *               @OA\Property(property="type", type="text"),
     *               @OA\Property(property="title", type="text"),
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="price", type="text"),
     *               @OA\Property(property="price_amount_micros", type="text"),
     *               @OA\Property(property="price_currency_code", type="text"),
     *               @OA\Property(property="description", type="text"),
     *               @OA\Property(property="subscriptionPeriod", type="text"),
     *               @OA\Property(property="skuDetailsToken", type="text"),
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
     *  @OA\Response(
     *      response=404,
     *      description="Bad Request"
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
    public function packageStore(Request $request)
    {
        // $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
        //     'packages' => 'required|array',
        // ]);

        // if ($validator->fails()) {
        //     return response([
        //         'status' => 'validation_error',
        //         'data'   => $validator->errors(),
        //     ], 422);
        // }

        try {
            SubscriptionPackage::truncate();

            if (request()->has('packages')) {
                foreach (request('packages') as $package) {
                    $item = SubscriptionPackage::create($package);
                }
                return response([
                    'status'  => 'success',
                    'message' => 'Subscription Package Successfully Added',
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