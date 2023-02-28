<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PaymentHistory;
use App\Models\PaymentSetting;
use App\Models\PostPayment;
use App\Models\PremiumUser;
use App\Models\PrePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Response;
use Validator;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
//         dd($request->all());
        $paymentSettings = PaymentSetting::first();
//        dd($paymentSettings);
        if ($paymentSettings) {
            $paymentSettings->paypal_client_id = $request->paypal_client_id ?? $paymentSettings->paypal_client_id;
            $paymentSettings->paypal_secret_key = $request->paypal_secret_key ?? $paymentSettings->paypal_secret_key;
            $paymentSettings->stripe_publishable_key = $request->stripe_publishable_key ?? $paymentSettings->stripe_publishable_key;
            $paymentSettings->stripe_secret_key = $request->stripe_secret_key ?? $paymentSettings->stripe_secret_key;
            $paymentSettings->wyre_client_id = $request->wyre_client_id ?? $paymentSettings->wyre_client_id;
            $paymentSettings->wyre_secret_key = $request->wyre_secret_key ?? $paymentSettings->wyre_secret_key;
            $paymentSettings->update();
            return response([
                "status" => "success",
                "message" => "SuccessFully Update"
            ]);
        } else {
            $paymentSettings = new PaymentSetting();
            $paymentSettings->paypal_client_id = $request->paypal_client_id;
            $paymentSettings->paypal_secret_key = $request->paypal_secret_key;
            $paymentSettings->stripe_publishable_key = $request->stripe_publishable_key;
            $paymentSettings->stripe_secret_key = $request->stripe_secret_key;
            $paymentSettings->wyre_client_id = $request->wyre_client_id;
            $paymentSettings->wyre_secret_key = $request->wyre_secret_key;
            $paymentSettings->save();
            return response([
                "status" => "success",
                "message" => "Payment SuccessFully Create"
            ]);
        }
    }

    public function index()
    {
        $payment = PaymentSetting::first();
        if ($payment) {
            return response([
                "status" => "success",
                "data" => $payment
            ]);
        }
    }

    public function paypalCreateOrder(Request $request)
    {
//        dd(auth()->id());
        $accessToken = $this->paypalAuthentication();
        $client = \Illuminate\Support\Facades\Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Bearer $accessToken",
            "PayPal-Request-Id" => \Illuminate\Support\Str::random(),
        ])->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', [
            "intent" => 'CAPTURE',
            'purchase_units' => $request->purchase_units,
            "payment_source" => [
                'paypal' => [
                    "experience_context" => [
                        "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                        "payment_method_selected" => "PAYPAL",
                        "user_action" => "PAY_NOW",
                        "return_url" => config('app.url') . "/paypal/success",
                        "cancel_url" => config('app.url') . "/paypal/cancel",
                    ]
                ]
            ]
        ]);


        $data = $client->json();
//        dd($data);
        if ($data['status'] === "PAYER_ACTION_REQUIRED") {
            $prePayment = new PrePayment();
            $prePayment->user_id = auth()->id();
            $prePayment->payment_type = "paypal";
            $prePayment->order_id = $data['id'];
            $prePayment->payment_details = $data;
            $prePayment->save();

        }
        return $client->json();
    }

    public function paypalAuthentication()
    {
        $getPayment = PaymentSetting::first();
        if ($getPayment) {
            $client = \Illuminate\Support\Facades\Http::asForm()->withBasicAuth((string)$getPayment->paypal_client_id, (string)$getPayment->paypal_secret_key)
                ->withHeaders(["Content-Type" => "application/x-www-form-urlencoded"])
                ->post("https://api-m.sandbox.paypal.com/v1/oauth2/token", [
                    "grant_type" => "client_credentials"
                ]);

            if ($client->successful()) {
                $res = $client->json();
                return $res['access_token'];
            } else {
                return 'Something is wrong went happened';
            }
        }
    }

    public function paypalCheckOrderStatus(Request $request)
    {
//        dd($request->all());
        $accessToken = $this->paypalAuthentication();
        $client = \Illuminate\Support\Facades\Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessToken"
        ])->get('https://api-m.sandbox.paypal.com/v2/checkout/orders/' . request('token'));

        $result = $client->json();
        if ($result['status'] === "APPROVED") {
            $getUserId = PrePayment::where("order_id", $result['id'])->first();
//            dd($getUserId);
            $postPayment = new PostPayment();
            $postPayment->user_id = $getUserId->user_id;
            $postPayment->payment_type = "paypal";
            $postPayment->order_id = $result['id'];
            $postPayment->payment_details = $result;
            $postPayment->save();
            if ($postPayment->save()) {
                $postPay = PostPayment::where("user_id", $getUserId->user_id)->first();
                $packageId = $postPay['payment_details']['purchase_units'][0]['reference_id'];
                $packageUser = Package::where("id", $packageId)->first();
                $validity = $packageUser->validity;
                $paymentUser = new PremiumUser();
                $paymentUser->user_id = $getUserId->user_id;
                $paymentUser->order_id = $postPayment->order_id;
                $paymentUser->validity = Carbon::now()->addDays($validity);
                $paymentUser->status = "active";
                $paymentUser->save();
            }
        }
        return $result;
    }

    // Stripe Rest Api

    public function stripeCreateOrder(Request $request)
    {
        $package = Package::where("id", $request->input('package_id'))->first();
        if (!$package) {
            return response([
                'status' => 'error',
                'message' => 'Package not found'
            ], 404);
        }

        $uuid = Str::random();
        $payload = [
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => $package->name
                        ],
                        "currency" => "usd",
                        "unit_amount" => (float)$package->price * 100
                    ],
                    "quantity" => 1
                ]
            ],
            'metadata' => [
                'package_id' => $package->id
            ],
            'success_url' => config('app.url') . "/stripe/success?uuid={$uuid}",
            'cancel_url' => config('app.url') . "/stripe/cancel?uuid={$uuid}",
            'mode' => 'payment',
        ];

        $getPayment = PaymentSetting::first();
        $stripe = new \Stripe\StripeClient($getPayment->stripe_secret_key);
        $data = $stripe->checkout->sessions->create($payload);
        if ($data['status'] === "open") {
            $prePayment = new PrePayment();
            $prePayment->uuid = $uuid;
            $prePayment->user_id = auth()->id();
            $prePayment->payment_type = "stripe";
            $prePayment->order_id = $data['id'];
            $prePayment->payment_details = $data;
            $prePayment->save();
        }
        return response([
            'status' => 'success',
            'data' => $data
        ], 201);
    }

    public function stripeOrderStatus(Request $request)
    {
//       dd( $request->user_id);
        $getPayment = PaymentSetting::first();
        $stripe = new \Stripe\StripeClient($getPayment->stripe_secret_key);
        $data = $stripe->checkout->sessions->retrieve(
            request('session_id'),
            []
        );

        $status = false;
        if ($data['status'] === "complete" || $data['status'] === "succeeded") {
            $status = true;
            $postPayment = new PostPayment();
            $postPayment->user_id = $request->user_id;
            $postPayment->payment_type = "stripe";
            $postPayment->order_id = $data['id'];
            $postPayment->payment_details = $data;
            if ($postPayment->save()) {
                $postPay = PostPayment::where("user_id", $request->user_id)->first();
                $packageId = $postPay['payment_details']['metadata']['package_id'];
                $packageUser = Package::where("id", $packageId)->first();
                $validity = $packageUser->validity;
                $paymentUser = new PremiumUser();
                $paymentUser->user_id = $request->user_id;
                $paymentUser->order_id = $packageId;
                $paymentUser->validity = Carbon::now()->addDays($validity);
                $paymentUser->status = "active";
                $paymentUser->save();
            }
        }
        return response([
            'status' => $status ? 'success' : 'error',
            'message' => $status ? 'Payment successful' : 'Payment failed'
        ], $status ? 200 : 400);
    }

//    public function stripeCreateEvent(Request $request)
//    {
//        $getPayment = PaymentSetting::first();
//        $stripe = new \Stripe\StripeClient($getPayment->stripe_secret_key);
//        return $stripe->events->all(['limit' => 10]);
//    }

    public function stripeCheckToken(Request $request)
    {
        $getPayment = PrePayment::where("uuid", $request->token)->first();
        return response([
            "status" => "success",
            "data" => $getPayment
        ]);
    }


    public function sendwyreCreateOrder(Request $request)
    {
        try {
            $getPayment = PaymentSetting::first();
//            dd($getPayment);
            $uuid = Str::random();
            $client = Http::withHeaders([
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $getPayment->wyre_secret_key,
                "Content-Type" => "application/json",
            ])->post('https://api.testwyre.com/v3/orders/reserve', [
                "amount" => $request->input('amount'),
                "sourceCurrency" => "USD",
                "redirectUrl" => config('app.url') . "/sendwyre/success?uuid={$uuid}",
                "autoRedirect" => true,
                "failureRedirectUrl" => config('app.url') . "/sendwyre/cancel",
                "referrerAccountId" => $getPayment->wyre_client_id,
                "referenceId" => $request->input('package_id')
            ]);

            $data = $client->json();
            $orderHistory = $this->getPaymentHistory($data['reservation']);

            if ($data['reservation']) {
                $prePayment = new PrePayment();
                $prePayment->user_id = auth()->id();
                $prePayment->uuid = $uuid;
                $prePayment->payment_type = "sendwyre";
                $prePayment->order_id = $data['reservation'];
                $prePayment->payment_details = $orderHistory;
                $prePayment->save();
            }

            return response([
                "status" => "success",
                "data" => $data,
                "orderHistory" => $orderHistory
            ], 200);

        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e
            ], 500);
        }

    }

    public function getPaymentHistory($id)
    {
        $getPayment = PaymentSetting::first();
        $client = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $getPayment->wyre_secret_key,
        ])->get("https://api.testwyre.com/v3/orders/reservation/$id");
        return $client->json();
    }

    public function sendwyreOrderStatus(Request $request)
    {
//        dd($request->orderId);
        $client = Http::withHeaders([
            "Accept" => "application/json",
        ])->get('https://api.testwyre.com/v3/orders/' . $request->orderId);
        $data = $client->json();
        $status = false;
        if ($data['status'] === "COMPLETE") {
            $status = true;
            $prePayment = PrePayment::where("uuid", $request->uuid)->first();
            $postPayment = new PostPayment();
            $postPayment->user_id = $prePayment->user_id;
            $postPayment->payment_type = "sendwyre";
            $postPayment->order_id = $data['id'];
            $postPayment->payment_details = $data;
            if ($postPayment->save()) {
                $prePayment = PrePayment::where("uuid", $request->uuid)->first();
//                dd($prePayment['payment_details']['referenceId']);
                $packageId = $prePayment['payment_details']['referenceId'];
                $packageUser = Package::where("id", $packageId)->first();
                $validity = $packageUser->validity;
                $paymentUser = new PremiumUser();
                $paymentUser->user_id = $prePayment->user_id;
                $paymentUser->order_id = $packageId;
                $paymentUser->validity = Carbon::now()->addDays($validity);
                $paymentUser->status = "active";
                $paymentUser->save();
            }
        }
        return response([
            'status' => $status ? 'success' : 'error',
            'message' => $status ? 'Payment successful' : 'Payment failed'
        ], $status ? 200 : 400);

    }



}
