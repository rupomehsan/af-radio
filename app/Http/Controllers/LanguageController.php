<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Language;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Response;
use Session;
use Validator;
use Redirect;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        try {
            $target = Language::query();
            //begin filtering
            $searchText = $request->fil_search;
            if (!empty($searchText)) {
                $target->where(function ($query) use ($searchText) {
                    $query->where('name', 'LIKE', '%' . $searchText . '%');
                });
            }
            //end filtering
            $target = $target->paginate(20);
            return view('language.index')->with(compact('target'));
        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function create(Request $request)
    {
        $view = view('language.create')->render();
        return response()->json(['html' => $view]);
    }

    public function store(Request $request)
    {
//        dd(auth()->user());
        try {
            $validate = Validator::make(request()->all(), [
                'name'  => 'required|regex:/^[a-zA-Z-. ]+$/u|unique:languages',
                'image' => 'required',
            ]);

            if ($validate->fails()) {
                return Response::json(['success' => false, 'heading' => 'Validation Error', 'message' => $validate->errors()], 422);
            }

            $target             = new Language;
            $target->name       = $request->name;
            $target->image      = $request->image ?? '';
            $target->status     = 'active';
            $target->updated_by = auth()->id();
            $target->created_by = auth()->id();
            if(auth()->user()->email !== "demoadmin@radio.com"){
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

    public function manageApproval(Request $request)
    {
//        dd(auth()->user()->email);
       if(auth()->user()->email !== "demoadmin@radio.com"){
        $target         = Language::where('id', $request->id)->first();
        $target->status = $request->status;
        if ($target->update()) {
            return Response::json(['success' => true], 200);
        }
       }else{
           return Response::json(['status' => "error", 'message' => 'Sorry You are demo user',], 422);
       }
    }

    public function edit(Request $request)
    {
        $target = Language::where('id', $request->id)->first();
        $view   = view('language.edit', compact('target'))->render();
        return response()->json(['html' => $view]);
    }

    public function update(Request $request)
    {
        try {
            $validate = Validator::make(request()->all(), [
                'name' => 'required|regex:/^[a-zA-Z-. ]+$/u|unique:countries,id,' . $request->id,

            ]);
            if ($validate->fails()) {
                return Response::json(['success' => false, 'heading' => 'Validation Error', 'message' => $validate->errors()], 422);
            }

            $target        = Language::where('id', $request->id)->first();
            $target->name  = $request->name ?? $target->name;
            $target->image =  $request->imageEdit;
            if(auth()->user()->email !== "demoadmin@radio.com"){
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
    public function fileUploader(Request $request)
    {
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
    public function destroy($id)
    {
        if(auth()->user()->email !== "demoadmin@radio.com") {
            $target = Language::find($id)->delete();
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
        return Redirect::to('admin/language?' . $url);
    }
}
