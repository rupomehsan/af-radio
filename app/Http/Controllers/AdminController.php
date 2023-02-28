<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Radio;
use App\Models\User;
use App\Models\UserRole;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Redirect;
use Response;
use Session;
use Validator;

class AdminController extends Controller
{
    public function adminIndex(Request $request)
    {
        $target = User::where('user_role_id', 2)->where('status', 'active');
        //begin filtering
        $searchText = $request->fil_search;
        if (!empty($searchText)) {
            $target->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%');
            });
        }
        //end filtering
        $target = $target->paginate(20);
        return view('admin.adminIndex')->with(compact('target'));
    }

    public function superAdminIndex(Request $request)
    {
        $target = User::where('user_role_id', 1)->where('status', 'active');
        //begin filtering
        $searchText = $request->fil_search;
        if (!empty($searchText)) {
            $target->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%');
            });
        }
        //end filtering

        $target = $target->paginate(20);
        return view('admin.superAdminIndex')->with(compact('target'));
    }

    public function create(Request $request)
    {
        $userRole = UserRole::where('status', 'active')->where('id', '!=', 3)->pluck('name', 'id')->toArray();
        return view('admin.create')->with(compact('userRole'));
    }

    public function store(Request $request)
    {
        try {
//             dd($request->all());
            $validate = Validator::make(request()->all(), [
                'user_role_id' => 'required|not_in:0',
                'name'         => 'required|regex:/^[a-zA-Z-. ]+$/u',
                'email'        => 'required|unique:users|email:rfc,dns',
                'phone'        => 'required',
                'password'     => 'min:6|required',
//                'image'        => 'required',
                'status'       => Rule::in(['active', 'inactive']),
            ]);

            // if ($validate->fails()) {
            //     return Response::json(['success' => false, 'heading' => 'Validtion Error', 'message' => $validate->errors()], 422);
            // }

            if ($validate->fails()) {
                return redirect('/admin/admin/create')
                    ->withInput()
                    ->withErrors($validate);
            }

            // dd($request->all());
            $access = '';
            if (!empty($request->access)) {
                $access = json_encode($request->access);
            }


            if ($request->file('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                if (config('app.env') === 'production') {
                    $image->move('uploads/user', $imageName);
                } else {
                    $image->move(public_path('/uploads/user'), $imageName);
                }

                $protocol = request()->secure() ? 'https://' : 'http://';
                $fileName = $protocol.$_SERVER['HTTP_HOST'].'/uploads/user/'.$imageName;
            }

            // http://192.168.1.230:7000/uploads/language/1644842990.BANGLADESH-FLAG-design.jpg
            // 1645273695.0001 copy.jpg

            $target                 = new User;
            $target->user_role_id   = $request->user_role_id;
            $target->name           = $request->name;
            $target->email          = $request->email;
            $target->phone          = $request->phone;
            $target->password       = Hash::make($request->password);
            $target->access         = $access;
            $target->image          = $fileName??null;
            $target->account_status = 'confirmed';
            $target->status         = 'active';
            // dd($target);
            // $target->updated_by = auth()->id();
            // $target->created_by = auth()->id();
//            dd(auth()->user()->email);
            if(auth()->user()->email !== "demoadmin@radio.com") {
                if ($target->save()) {
                    Session::flash('success', "Admin Created Successfully!");
                    return redirect('/admin/admin');
                } else {
                    Session::flash('error', "Admin Create Unuccessfull!");
                    return redirect('/admin/admin');
                }
            }else{
//                 dd("false");
                Session::flash('error', "Sorry You Are Demo User");
                return redirect('/admin/admin');
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
        $access = [];
        if (!empty($target->access)) {
            $access = json_decode($target->access);
        }
        // dd($access);
        $userRole = UserRole::where('status', 'active')->where('id', '!=', 3)->pluck('name', 'id')->toArray();
        return view('admin.edit')->with(compact('target', 'access', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        try {
//             dd($request->all());
            $validate = Validator::make(request()->all(), [
                'user_role_id' => 'required|not_in:0',
                'name'         => 'required|regex:/^[a-zA-Z-. ]+$/u',
                'email'        => 'required|email:rfc,dns|unique:users,id,' . $request->id,
                'phone'        => 'required',
                'status'       => Rule::in(['active', 'inactive']),
            ]);

            if ($validate->fails()) {
                return redirect('admin/admin/' . $request->id . '/edit')
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

            $access = '';
            if (!empty($request->access)) {
                $access = json_encode($request->access);
            }

            $target               = User::where('id', $request->id)->first();
            $target->user_role_id = $request->user_role_id ?? $target->user_role_id;
            $target->name         = $request->name ?? $target->name;
            $target->email        = $request->email ?? $target->email;
            $target->phone        = $request->phone ?? $target->phone;
            $target->access       = $access;
            $target->image        = $fileName??null;

//            if ($target->update()) {
//                Session::flash('success', "Admin Updated Successfully!");
//                return redirect('admin');
//            } else {
//                Session::flash('error', "Admin Update Unuccessfull!");
//                return redirect('admin/' . $request->id . '/edit');
//            }
            if(auth()->user()->email !== "demoadmin@radio.com") {
                if ($target->update()) {
                    Session::flash('success', "Admin Created Successfully!");
                    return redirect('admin/admin');
                } else {
                    Session::flash('error', "Admin Create Unuccessfull!");
                    return redirect('admin/admin');
                }
            }else{
//                 dd("false");
                Session::flash('error', "Sorry You Are Demo User");
                return redirect('admin/admin');
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
        return Redirect::to('admin/admin?' . $url);
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
    public function superAdminFilter(Request $request)
    {
        $url = 'fil_search=' . urlencode($request->fil_search);
        return Redirect::to('admin/admin/super-admin?' . $url);
    }

    public function show()
    {
        $target = User::where('id', auth()->id())->first();
        return view('admin.profile')->with(compact('target'));
    }

    public function profileUpdate(Request $request, $id)
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
                return Response::json(['success' => false, 'heading' => 'Validation Error', 'message' => $validate->errors()], 422);
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

            if ($target->update()) {
                Session::flash('success', "Profile Updated Successfully!");
                return redirect('admin/profile');
            } else {
                Session::flash('error', "Profile Update Unsuccessful!");
                return redirect('admin/admin/' . $request->id . '/edit');
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
