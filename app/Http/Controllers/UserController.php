<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Redirect;
use Response;
use Session;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $target = User::where('user_role_id', 3)->where('status', 'active');
        //begin filtering
        $searchText = $request->fil_search;
        if (!empty($searchText)) {
            $target->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%');
            });
        }
        //end filtering

        $target = $target->paginate(20);
        return view('user.index')->with(compact('target'));
    }

    public function create(Request $request)
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $validate = Validator::make(request()->all(), [
                'name'     => 'required|regex:/^[a-zA-Z-. ]+$/u',
                'email'    => 'required|unique:users|email:rfc,dns',
                'phone'    => 'required|unique:users',
                'password' => 'min:6|required',
                'status'   => Rule::in(['active', 'inactive']),
            ]);

            // if ($validate->fails()) {
            //     return Response::json(['success' => false, 'heading' => 'Validtion Error', 'message' => $validate->errors()], 422);
            // }

            if ($validate->fails()) {
                return redirect('admin/user/create')
                    ->withInput()
                    ->withErrors($validate);
            }

            // dd($request->all());
            if (!empty($request->file('image'))) {
                $image     = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                if (config('app.env') === 'production') {
                    $image->move('uploads/user', $imageName);
                } else {
                    $image->move(public_path('/uploads/user'), $imageName);
                }

                $protocol = request()->secure() ? 'https://' : 'http://';
                $fileName = $protocol.$_SERVER['HTTP_HOST'].'/uploads/user/'.$imageName;
            }

            $target                 = new User;
            $target->user_role_id   = 3;
            $target->name           = $request->name;
            $target->email          = $request->email;
            $target->phone          = $request->phone;
            $target->password       = Hash::make($request->password);
            $target->image          = $fileName??null ;
            $target->account_status = 'confirmed';
            $target->status         = 'active';
            // $target->updated_by = auth()->id();
            // $target->created_by = auth()->id();
            if(auth()->user()->email !== "demoadmin@radio.com") {
                if ($target->save()) {
                    Session::flash('success', "User Created Successfully!");
                    return redirect('admin/user');
                } else {
                    Session::flash('error', "User Create Unuccessfull!");
                    return redirect('admin/user');
                }
            }else{
//                 dd("false");
                Session::flash('error', "Sorry You Are Demo User");
                return redirect('admin/user');
            }





        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $target = User::where('id', $id)->first();
        return view('user.edit')->with(compact('target'));
    }

    public function update(Request $request, $id)
    {
        try {
            // dd($request->all());

            $validate = Validator::make(request()->all(), [
                'name'   => 'required|regex:/^[a-zA-Z-. ]+$/u',
                'email'  => 'required|email:rfc,dns|unique:users,id,' . $request->id,
                'phone'  => 'required',
                'status' => Rule::in(['active', 'inactive']),
            ]);

            if ($validate->fails()) {
                return redirect('admin/user/' . $request->id . '/edit')
                    ->withInput()
                    ->withErrors($validate);
            }

            if (!empty($request->file('image'))) {
                $image     = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                if (config('app.env') === 'production') {
                    $image->move('uploads/user', $imageName);
                } else {
                    $image->move(public_path('/uploads/user'), $imageName);
                }
                $protocol = request()->secure() ? 'https://' : 'http://';
                $fileName = $protocol.$_SERVER['HTTP_HOST'].'/uploads/user/'.$imageName;
            }

            $target        = User::where('id', $request->id)->first();
            $target->name  = $request->name ?? $target->name;
            $target->email = $request->email ?? $target->email;
            $target->phone = $request->phone ?? $target->phone;
            $target->image = $fileName ?? null;

            if(auth()->user()->email !== "demoadmin@radio.com") {
                if ($target->update()) {
                    Session::flash('success', "User Update Successfully!");
                    return redirect('admin/user');
                } else {
                    Session::flash('error', "User Update  Unuccessfull!");
                    return redirect('admin/user');
                }
            }else{
//                 dd("false");
                Session::flash('error', "Sorry You Are Demo User");
                return redirect('admin/user');
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        if(auth()->user()->email !== "demoadmin@radio.com") {
            $target = User::find($id)->delete();
            return  response([
                "status" => "success",
                "message" => "Item Successfully delete"
            ]);
        }else{
            return Response::json(['status' => "error", 'message' => 'Sorry You are demo user',],422);
        }
//        return Redirect::back()->with('msg', 'Item Successfully Delete');
    }
    public function filter(Request $request)
    {
        $url = 'fil_search=' . urlencode($request->fil_search);
        return Redirect::to('admin/user?' . $url);
    }

    public function registration(Request $request)
    {
        try {
            // dd($request->all());
            $validate = Validator::make(request()->all(), [
                'name'     => 'required|regex:/^[a-zA-Z-. ]+$/u',
                'email'    => 'required|unique:users|email:rfc,dns',
                'phone'    => 'required|regex:/(01[3-9]\d{8})$/',
                'password' => 'min:6|required',
                'status'   => Rule::in(['active', 'inactive']),
            ]);

            if ($validate->fails()) {
                return response()->json(['success' => false, 'heading' => 'Validation Error', 'message' => $validate->errors()], 422);
            }

            $target                 = new User;
            $target->user_role_id   = 3;
            $target->name           = $request->name;
            $target->email          = $request->email;
            $target->phone          = $request->phone;
            $target->password       = Hash::make($request->password);
            $target->image          = $imageName ?? null;
            $target->account_status = 'confirmed';
            $target->status         = 'active';
            // $target->updated_by = auth()->id();
            // $target->created_by = auth()->id();

            if ($target->save()) {
                return Response::json(['success' => true], 200);
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $view = view('settings.changePassword')->render();
        return response()->json(['html' => $view]);
    }

    public function updatePassword(Request $request)
    {
        $validate = Validator::make(request()->all(), [
            'old_password'          => 'required',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        if ($validate->fails()) {
            return Response::json(['success' => false, 'heading' => 'Validtion Error', 'message' => $validate->errors()], 422);
        }

        $hashedPassword = auth()->user()->password;
        if (\Hash::check($request->old_password, $hashedPassword)) {
            $target           = User::where('id', auth()->id())->first();
            $target->password = Hash::make($request->password) ?? $target->password;

            if ($target->update()) {
                return Response::json(['success' => true], 200);
            }

        } else {
            return Response::json(['success' => false, 'heading' => 'Error', 'message' => 'old password doesnt matched '], 404);
        }
    }

    public function profile(Request $request)
    {
        $profile = User::where('id', auth()->id())->select('name', 'image', 'email', 'phone')->first();
        // dd($target);
        return view('frontend.client.profile')->with(compact('profile'));
    }
    public function editProfile(Request $request)
    {
        $profile = User::where('id', auth()->id())->select('name', 'image', 'email', 'phone')->first();
        return view('frontend.client.editProfile')->with(compact('profile'));
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

    public function profileUpdate(Request $request)
    {

        // dd($request->all());
        $password = $oldPass = '';
        $user     = auth()->user();
        if (!empty($request->password)) {
            $password = 'min:6|confirmed|different:old_password';
            $oldPass  = [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Your password was not updated, since the provided current password does not match.');
                    }
                },
            ];
        }
        $validate = Validator::make(request()->all(), [
            'name'         => 'regex:/^[a-zA-Z-. ]+$/u',
            'email'        => 'email:rfc,dns|unique:users,id,' . auth()->id(),
            'phone'        => 'regex:/(01[3-9]\d{8})$/|unique:users,id,' . auth()->id(),
            'old_password' => $oldPass,
            'password'     => $password,
        ]);
        if ($validate->fails()) {
            return Response::json(['success' => false, 'heading' => 'Validtion Error', 'message' => $validate->errors()], 422);
        }

        $target = User::where('id', auth()->id())->first();

        if (!empty($request->file('image'))) {
            $image     = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalName();
            if (config('app.env') === 'production') {
                $image->move('uploads/user', $imageName);
            } else {
                $image->move(public_path('/uploads/user'), $imageName);
            }

            $protocol = request()->secure() ? 'https://' : 'http://';
            $fileName = $protocol.$_SERVER['HTTP_HOST'].'/uploads/user/'.$imageName;
        }

        $target->name     = $request->name ?? $target->name;
        $target->email    = $request->email ?? $target->email;
        $target->phone    = $request->phone ?? $target->phone;
        $target->image    = $fileName ?? null;
        $target->password = !empty($request->password) ? Hash::make($request->password) : $target->password;

        if ($target->update()) {
            return Response::json(['success' => true], 200);
        }

    }

}
