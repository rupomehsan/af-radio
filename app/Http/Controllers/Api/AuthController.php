<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ForgotPasswordCode;
use App\Mail\SendVerificationCodeMail;
use App\Models\ForgotPasswordRequest;
use App\Models\User;
use App\Models\Smtp;
use App\Models\PremiumUser;
use App\Models\PostPayment;
use App\Models\Package;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['logout', 'me', 'update']]);
    }

    /**
     * @OA\Post(
     ** path="/auth/user/register",
     *   operationId="register",
     *   tags={"Auth"},
     *   summary="Register new user",
     *
     * @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name","email","password","phone"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="password_confirmation", type="password"),
     *               @OA\Property(property="phone", type="int")
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
    public function register(Request $request)
    {
        try {
            $validator = Validator::make(request()->all(), [
                'name'     => 'required|regex:/^[a-zA-Z-. ]+$/u',
                'email'    => 'required|unique:users|email:rfc,dns',
                'phone'    => 'required|unique:users',
                'password' => 'min:6|required|confirmed',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $user                 = new User;
            $user->user_role_id   = 3;
            $user->name           = $request->name;
            $user->email          = $request->email;
            $user->password       = Hash::make($request->password);
            $user->phone          = $request->phone;
            $user->image          = '';
            $user->account_status = 'confirmed';
            $user->status         = 'active';
            if ($user->save()) {

                // $userVeri                    = new UserVerification;
                // $userVeri->phone             = $user->phone;
                // $userVeri->verification_code = $this->generateRandomString(6);
                // if ($userVeri->save()) {
                // Mail::to($user->email)->send(new SendVerificationCode($userVeri->email, $userVeri->verification_code));

                return response([
                    'status'  => 'success',
                    'message' => 'Registration successfully done.',
                    // 'phone'             => $user->phone,
                    // 'verification_code' => $userVeri->verification_code,
                ], 200);
                // }
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     ** path="/auth/user/resend-code",
     *   operationId="resendCode",
     *   tags={"Auth"},
     *   summary="Resend email verification code which can use email validation.",
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/
    public function resendCode(Request $request)
    {
        // dd($request->all());
        try {
            $target = ForgotPasswordCode::where('email', $request->email)->first();
            if (empty($target)) {
                return response([
                    'status'  => 'error',
                    'message' => 'No code found.',
                ], 404);
            }

            $target->verification_code = $this->generateRandomString(6);
            if ($target->update()) {
                // Mail::to($request->email)->send(new SendVerificationCode($request->email, $target->verification_code));
                Mail::to($request->email)->send(new SendVerificationCodeMail($target->verification_code));
                return response([
                    'status'  => 'success',
                    'message' => 'code send your email, please check your email.',
                    'email'   => $target->email,
                    'code'    => $target->verification_code
                ]);
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Post(
     *      path="/auth/user/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="This api work for login this project",
     *      description="Returns list of projects",
     *      @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *            @OA\Property(
     *              property="status",
     *              type="string",
     *              description = "success"
     *            ),
     *            @OA\Property(
     *              property="message",
     *              type="string",
     *              description = "success message"
     *            ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication error"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Phone verification pending"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="server error"
     *      ),
     *     )
     */
    public function login(Request $request)
    {

//        dd($request->all());

        try {
            $validator = Validator::make(request()->all(), [
                'email'    => 'required|exists:users',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }
            if (!auth()->attempt($validator->validated())) {
                return response([
                    'status'  => 'error',
                    'message' => "Credentials doesn't matched...",
                ], 401);
            }

            // if ((auth()->user()->status) == 'pending') {
            //     return response([
            //         'status'  => 'error',
            //         'message' => 'Please verified your email.',
            //     ], 404);
            // }

            $accessToken = auth()->user()->createToken('authToken');

            return response([
                'status'  => 'success',
                'message' => 'Successfully logged in...',
                'data'    => [
                    'token' => 'Bearer ' . $accessToken->plainTextToken,
                    'user'  => auth()->user(),
                ],
            ], 200);
        } catch (Exception $e) {
            return response([
                'status'  => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * @OA\Post(
     ** path="/auth/logout",
     *   operationId="logout",
     *   tags={"Auth"},
     *   security={{"bearerAuth":{}}},
     *   summary="Log out from this application.",
     *
     *
     *   @OA\Response(
     *      response=200,
     *      description="Success"
     *   ),
     *   @OA\Response(
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/

    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return response([
                'status'  => 'done',
                'message' => 'Successfully logout...',
            ], 200);
        } catch (Exception $e) {
            return response([
                'status'  => 'serverError',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Post(
     ** path="/auth/user/forgot-password",
     *   operationId="forgotPassword",
     *   tags={"Auth"},
     *   summary="Send email verification code which can use verify, you are a valid user.",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email"},
     *               @OA\Property(property="email", type="email"),
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
     *      response=500,
     *      description="Server error"
     *   )
     *)
     **/
    public function forgotPassword(Request $request)
    {
        // dd($request->email);
        try {
            $validator = Validator::make(request()->all(), [
                'email'    => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }
            $user = User::where('email', $request->email)->first();
            // dd($user);
            if (!$user) {
                return response([
                    'status'  => 'error',
                    'message' => 'No user found with this Email.',
                ], 404);
            }
            $prevCode = ForgotPasswordCode::where('email', $request->email)->first();
            if (!empty($prevCode)) {
                $prevCode->delete();
            }
            $prevRequest = ForgotPasswordRequest::where('email', $request->email)->first();
            if (!empty($prevRequest)) {
                $prevRequest->delete();
            }
            $code                    = new ForgotPasswordCode;
            $code->email             = $request->email;
            $code->verification_code = $this->generateRandomString(6);
            $code->save();

            $forgotRequest         = new ForgotPasswordRequest;
            $forgotRequest->email  = $request->email;
            $forgotRequest->status = 'request';
            $forgotRequest->save();

            if (($code->save()) && ($forgotRequest->save())) {
                    $smtpSettings = Smtp::first();
                    if($smtpSettings){
                        config([
                            'mail.default'                 => 'smtp',
                            'mail.mailers.smtp.host'       => $smtpSettings->host ?? '',
                            'mail.mailers.smtp.port'       => $smtpSettings->port ?? '',
                            'mail.mailers.smtp.encryption' => $smtpSettings->encryption ?? '',
                            'mail.mailers.smtp.username'   => $smtpSettings->username ?? '',
                            'mail.mailers.smtp.password'   => $smtpSettings->password ?? '',
                        ]);
                        Mail::to($request->email)->send(new SendVerificationCodeMail($code->verification_code));
                        return response([
                            'status'            => 'success',
                            'message'           => 'Account verification code send your email, please check your email.',
                            'email'             => $code->email,
                            'verification_code' => $code->verification_code,
                        ], 200);
                    }else{
                        return response([
                            'status'  => 'error',
                            'message' => 'Please configure your smtp server.',
                        ], 400);
                    }
                }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Post(
     ** path="/auth/user/user-verify",
     *   operationId="UserVerify",
     *   tags={"Auth"},
     *   summary="user verify using verification code which sending your email.",
     * @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email","code"},
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="otp_code", type="int"),
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

    public function UserVerify(Request $request)
    {

        try {

            $validator = Validator::make(request()->all(), [
                'email'             => 'required|email|exists:users',
                'otp_code'              => 'required|min:6|max:6'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }
//            dd($request->otp_code);
            $code = ForgotPasswordCode::where('email', $request->email)
                ->where('verification_code', $request->otp_code)
                ->first();
//            dd($code);

            if (empty($code)) {
                return response([
                    'status'  => 'error',
                    'message' => 'No code found.',
                ], 404);
            }

            //validation expire check
            if (($code->updated_at->addHour(1)) < (now())) {
                return response([
                    'status'  => 'error',
                    'message' => 'Your code is expired! Please resend code.',
                    'code' => $code->verification_code
                ], 404);
            }

            if (($code->verification_code) == ($request->otp_code)) {
                $forgotRequest         = ForgotPasswordRequest::where('email', $request->email)->first();
                $forgotRequest->status = "matched";
                if ($forgotRequest->update()) {
                    $code->delete();
                    return response([
                        'status'  => 'success',
                        'message' => 'User verified. Go forword for next step.',
                    ], 200);
                }

            }
            return response([
                'status'  => 'error',
                'message' => 'Code not matched',
            ], 404);
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     ** path="/auth/user/recover-password",
     *   operationId="changePassword",
     *   tags={"Auth"},
     *   summary="User forgot password and recovery password",
     *
     *  @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email","password", "password_confirmation"},
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="password_confirmation", type="password"),
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
    public function changePassword(Request $request)
    {

        try {
//   dd($request->all());

    //   $request->email = "kazal@gmail.com";


            $validator = Validator::make(request()->all(), [
                'email'    => 'required',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $forgotRequest = ForgotPasswordRequest::where('email', $request->email)->first();

            if ($forgotRequest->status != 'matched') {
                return response([
                    'status'  => 'error',
                    'message' => 'You have no access to change password. please do before step again.',
                ], 404);
            }

            $target           = User::where('email', $request->email)->first();
            $target->password = Hash::make($request->password);

            $forgotRequest->status = 'changed';

            if (($target->update()) && ($forgotRequest->update())) {
                return response([
                    'status'  => 'success',
                    'message' => "Password successfully changed!",
                ], 200);
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function generateRandomString($length)
    {
        $characters       = '0123456789';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function recoveryPassword()
    {
        return view('auth.forgotpassword');
    }
    public function verification()
    {
        dd("lasdjflas");
        return view('auth.verification');
    }
/**
 * @OA\Patch(
 ** path="/auth/user/update-password",
 *   operationId="User Change Password",
 *   tags={"Auth"},
 *   security={{"bearerAuth":{}}},
 *   summary="User  Password Change",
 *
 *   @OA\RequestBody(
 *         @OA\JsonContent(),
 *         @OA\MediaType(
 *            mediaType="multipart/form-data",
 *            @OA\Schema(
 *               type="object",
 *               required={"current_password","new_password"},
 *               @OA\Property(property="current_password", type="password"),
 *               @OA\Property(property="new_password", type="password"),
 *               @OA\Property(property="password_confirmation", type="password"),
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

    public function profileChangePassword(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make(request()->all(), [
            'current_password' => 'required|min:6',
            'new_password'     => 'required|min:6',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->messages();
            return validateError($errors);
        }

        try {
            $user = auth()->user();
            if (Hash::check(request('current_password'), $user->password)) {
                $user->password = Hash::make(request('new_password'));
                $user->update();
                return response([
                    'status'  => 'success',
                    'message' => 'Password changed successfully',
                ], 200);
            } else {
                $errors = [
                    'current_password' => ['Current password not matched...'],
                ];
                return validateError($errors);
                // return response([
                //     'status' => 'validate_error',
                //     'data'   => [
                //         'current_password' => ['Current password not matched...'],
                //     ],
                // ], 422);
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Patch(
     ** path="/auth/user/profile/update",
     *   operationId="Update User Profile",
     *    security={{"bearerAuth":{}}},
     *   tags={"Auth"},
     *   summary="Update User Profile",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="phone", type="integer"),
     *               @OA\Property(property="image", type="text"),
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
    public function updateProfile(Request $request)
    {
        try {


            $validate = Validator::make(request()->all(), [
                'name'  => 'regex:/^[a-zA-Z-. ]+$/u',
            ]);
//            dd( $validate);
            if ($validate->fails()) {
                $errors = $validate->errors()->messages();
                return validateError($errors);
            }

            $target = User::where('id', auth()->id())->first();
//             dd($target);

            $target->name  = $request->name ?? $target->name;
            $target->phone = $request->phone ?? $target->phone;
            $target->image = $request->image ?? $target->image;
            if ($target->update()) {
                return response([
                    'status'  => 'success',
                    'message' => 'User updated successfully',
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
     *      path="/auth/user/profile",
     *      operationId="profile",
     *      tags={"Auth"},
     *      security={{"bearerAuth":{}}},
     *      summary="Show Login user profile data",
     *      description="Show Login user profile information",
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

    public function profile(Request $request)
    {
        try {
            // if (empty(auth()->id())) {
            //     return response([
            //         'status'  => 'error',
            //         'message' => 'Unauthenticated',
            //     ], 401);
            // }

            // $target = User::where('id', auth()->id())->first();

            return response([
                'status' => 'success',
                'data'   => auth()->user(),
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
     ** path="/image-upload",
     *   operationId="Image",
     *   tags={"Auth"},
     *   summary="Image Uploads",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"file"},
     *               @OA\Property(property="file", type="file"),
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

    public function fileUploader(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make(request()->only('file'), [
            'file' => 'required|max:10240',
        ]);
        if ($validate->fails()) {
            return response([
                'status' => 'validation_error',
                'data'   => $validate->errors(),
            ], 422);
        }
        try {
            if (request()->has('file')) {
                $folder    = $request->folder ?? 'all';
                $image     = $request->file('file');
                $imageName = $folder . "/" . time() . '.' . $image->getClientOriginalName();
                if (config('app.env') === 'production') {
                    $image->move('uploads/' . $folder, $imageName);
                } else {
                    $image->move(public_path('/uploads/' . $folder), $imageName);
                }

                $protocol = request()->secure() ? 'https://' : 'http://';
                return response([
                    'status'  => 'success',
                    'message' => 'File uploaded successfully',
                    'data'    => $protocol . $_SERVER['HTTP_HOST'] . '/uploads/' . $imageName,
                ], 200);
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    function fetchMe(Request $request){
        try{
            $isPremium = "false";
            $package = [];
            $getUser = User::where("id",auth()->id())->first();
            if($getUser){
                $premiumChck = PremiumUser::where("user_id",$getUser->id)->first();
                if($premiumChck){
                   $getUser->isPremium = "true";
                }else{
                    $getUser->isPremium = "false";
                }
                $postPay   = PostPayment::where("user_id",$getUser->id)->first();
                if($postPay){
                    $packageId='';
                    if ($postPay->payment_type==="paypal"){
                      $packageId =  $postPay['payment_details']['purchase_units'][0]['reference_id'];
                    }else if($postPay->payment_type==="stripe"){
                        $packageId = $postPay['payment_details']['metadata']['package_id'];
                    }
                    $packageUser= Package::where("id",$packageId)->first();
                    array_push($package,$packageUser);
                    $getUser->package = $package;
                    if(Carbon::now() > $premiumChck->validity){
                        $isPremium = 'false';
                    }
                }
                 return response([
                'status'  => 'success',
                'data'    => $getUser,
                'validity'    => $premiumChck,
                   ], 200);
            }else{
                  return response([
                'status'  => 'error',
                'message'  => 'Data Not Found',
           
            ], 404);
            }
            
           
        }catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
