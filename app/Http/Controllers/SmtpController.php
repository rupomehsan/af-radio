<?php

namespace App\Http\Controllers;

use App\Models\Smtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Response;
use Validator;

class SmtpController extends Controller
{
    public function index(Request $request)
    {
        $target = Smtp::first();
        if ($target) {
            return view('smtp.edit')->with(compact('target'));
        } else {
            return view('smtp.create');
        }
    }

    public function manageApproval(Request $request)
    {

        $target         = Radio::where('id', $request->id)->first();
        $target->status = $request->status;
        if ($target->update()) {
            return Response::json(['success' => true], 200);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());


        try {

            $validate = Validator::make(request()->all(), [
                'host'       => 'required',
                'port'       => 'required',
                'encryption' => 'required',
                'username'   => 'required',
                'password'   => 'required',
            ]);
            if ($validate->fails()) {
                return Response::json(['success' => false, 'heading' => 'Validation Error', 'message' => $validate->errors()], 422);
            }

            $target             = new Smtp;
            // $target->name       = $request->name;
            $target->host       = $request->host;
            $target->port       = $request->port;
            $target->encryption = $request->encryption;
            $target->username   = $request->username;
            $target->password   = $request->password;
            if(auth()->user()->email !== "demoadmin@radio.com") {
                if ($target->save()) {
                    return Response::json(['success' => true], 200);
                }
            }else{
                return Response::json(['status' => "error", 'message' => 'Sorry You are demo user',],422);
            }


        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        try {

            $validate = Validator::make(request()->all(), [
                'host'       => 'required',
                'port'       => 'required',
                'encryption' => 'required',
                'username'   => 'required',
                'password'   => 'required',
            ]);
            if ($validate->fails()) {
                return Response::json(['success' => false, 'heading' => 'Validation Error', 'message' => $validate->errors()], 422);
            }

            $target = Smtp::first();

            // $target->name       = $request->smtp ?? $target->name;
            $target->host       = $request->host ?? $target->host;
            $target->port       = $request->port ?? $target->port;
            $target->encryption = $request->encryption ?? $target->encryption;
            $target->username   = $request->username ?? $target->username;
            // $target->email      = $request->email ?? $target->email;
            $target->password   = $request->password ?? $target->password;

            if(auth()->user()->email !== "demoadmin@radio.com") {
                if ($target->update()) {
                    return Response::json(['success' => true], 200);
                }
            }else{
                return Response::json(['status' => "error", 'message' => 'Sorry You are demo user',],422);
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
}
