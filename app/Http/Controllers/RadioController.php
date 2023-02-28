<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Language;
use App\Models\Radio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Redirect;
use Response;
use Validator;

class RadioController extends Controller
{
    public function index(Request $request)
    {
        $target = Radio::paginate(20);
        // $target = Radio::with(['language'])->where("status", "active")->get();
        // dd($target);
        $languages = Language::where("status", "active")->get();
        $country   = Country::where("status", "active")->get();
        //news view count
        return view('radio.index')->with(compact('target', 'languages', 'country'));
    }

    public function manageApproval(Request $request)
    {
        if (auth()->user()->email !== "demoadmin@radio.com") {
            $target = Radio::where('id', $request->id)->first();
            $target->status = $request->status;
            if ($target->update()) {
                return Response::json(['success' => true], 200);

            } else {
                return Response::json(['status' => "error", 'message' => 'Sorry You are demo user',], 422);
            }

        }
    }
    public function statusControl(Request $request)
    {
        try {

            if(auth()->user()->email !== "demoadmin@radio.com") {
                if ($request->status === 'enable') {
                    $target = $request->id;
                    if ($target) {
                        foreach ($target as $data) {
                            $target2 = Radio::where('id', $data)->first();
                            $target2->status = 'active';
                            $target2->update();
                        }
                        return Response::json(['success' => true], 200);
                    }

                } else if ($request->status === 'disable') {
                    $target = $request->id;
                    if ($target) {
                        foreach ($target as $data) {
                            $target2 = Radio::where('id', $data)->first();
                            $target2->status = 'inactive';
                            $target2->update();
                        }
                        return Response::json(['success' => true], 200);

                    }

                } else if ($request->status === 'delete') {
                    $target = $request->id;
                    if ($target) {
                        foreach ($target as $data) {
                            $target2 = Radio::where('id', $data)->delete();
                        }
                        return Response::json(['success' => true], 200);

                    }

                } else {
                    return response([
                        'status' => 'error',
                        'message' => 'Status Did Not Match',
                    ], 500);

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
//       dd($request->all());
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


    public function radioFilter(Request $request)
    {

        // dd($request->all());

        try {
            if ($request->category && $request->country_id && $request->language_id) {
                $target = Radio::with('language')
                    ->where('category', $request->category)
                    ->where('language_id', $request->language_id)
                    ->where('country_id', $request->country_id)
                    ->get();
                if ($target) {
                    return response([
                        'status' => 'success',
                        'data'   => $target,
                    ], 200);
                }
            } else if ($request->category && $request->country_id) {
                $target = Radio::with('language')
                    ->where('category', $request->category)
                    ->where('country_id', $request->country_id)
                    ->get();
                if ($target) {
                    return response([
                        'status' => 'success',
                        'data'   => $target,
                    ], 200);
                }
            } else if ($request->category && $request->language_id) {
                $target = Radio::with('language')
                    ->where('category', $request->category)
                    ->where('language_id', $request->language_id)
                    ->get();
                if ($target) {
                    return response([
                        'status' => 'success',
                        'data'   => $target,
                    ], 200);
                }

            } else if ($request->category) {

                if ($request->category === 'all') {
                    $target = Radio::with('language')->get();
                    if ($target) {
                        return response([
                            'status' => 'success',
                            'data'   => $target,
                        ], 200);
                    }

                } else {
                    $target = Radio::with('language')
                        ->where('category', $request->category)
                        ->get();
                    if ($target) {
                        return response([
                            'status' => 'success',
                            'data'   => $target,
                        ], 200);
                    }
                }
            }

        } catch (\Exception$e) {
            return response([
                'status'  => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function create(Request $request)
    {
        $languages = Language::where('status', 'active')->pluck('name', 'id')->toArray();
        $countries = Country::where('status', 'active')->pluck('name', 'id')->toArray();
        return view('radio.create')->with(compact('languages', 'countries'));
        // return response()->json(['html' => $view]);
    }
    public function store(Request $request)
    {
//        dd($request->all());

        try {

            $validate = Validator::make(request()->all(), [
                'language_id'     => 'required',
                'station_id'      => 'required',
                'category'        => 'required',
                'radio_name'      => 'required',
                'radio_url'       => 'required',
                'radio_frequency' => 'required',
                'description'     => 'required',
//                'image'           => 'required',
                // 'status'      => Rule::in(['active', 'inactive']),
            ]);
            if ($validate->fails()) {
                return Response::json(['success' => false, 'heading' => 'Validation Error', 'message' => $validate->errors()], 422);
            }
            $domain    = request()->getHttpHost();
//            $image     = $request->file('image');
//            $imageName = time() . '.' . $image->getClientOriginalName();
//            $image->move(public_path('/uploads/radio'), $imageName);
            $target                  = new Radio;
            $target->language_id     = $request->language_id;
            $target->country_id      = $request->station_id;
            $target->category        = $request->category;
            $target->radio_name      = $request->radio_name;
            $target->radio_url       = $request->radio_url;
            $target->radio_frequency = $request->radio_frequency;
            $target->description     = $request->description;
            $target->image           = $request->image;
            $target->link            = $domain . "/" . $request->radio_name . "/" . $request->radio_frequency;
            $target->status = 'active';
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

    public function edit($id)
    {
        $target    = Radio::where('id', $id)->first();
        $languages = Language::where('status', 'active')->pluck('name', 'id')->toArray();
        $countries = Country::where('status', 'active')->pluck('name', 'id')->toArray();
        return view('radio.edit', compact('target', 'languages', 'countries'));
    }

    public function update(Request $request)
    {
//        dd($request->all());
        try {

            $validate = Validator::make(request()->all(), [
                'language_id'     => 'required',
                'radio_name'      => 'required',
                'radio_url'       => 'required',
                'radio_frequency' => 'required',
                'description'     => 'required',
            ]);
            if ($validate->fails()) {
                return Response::json(['success' => false, 'heading' => 'Validation Error', 'message' => $validate->errors()], 422);
            }

//            if (!empty($request->file('image'))) {
//                $image     = $request->file('image');
//                $imageName = time() . '.' . $image->getClientOriginalName();
//                $image->move(public_path('/uploads/radio'), $imageName);
//            }
            $target                  = Radio::where('id', $request->id)->first();
            $target->language_id     = $request->language_id ?? $target->language_id;
            $target->country_id      = $request->country_id ?? $target->country_id;
            $target->category        = $request->category ?? $target->category;
            $target->radio_name      = $request->radio_name ?? $target->radio_name;
            $target->radio_url       = $request->radio_url ?? $target->radio_url;
            $target->radio_frequency = $request->radio_frequency ?? $target->radio_frequency;
            $target->description     = $request->description ?? $target->description;
            $target->image           = $request->imageEdit;
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
    // public function newsFilter(Request $request)
    // {
    //     $url = 'fil_search=' . urlencode($request->fil_search);
    //     return Redirect::to('category?' . $url);
    // }

    //destroy
    public function destroy($id)
    {
        // dd(auth()->id());
        if(auth()->user()->email !== "demoadmin@radio.com"){
            $target = Radio::find($id)->delete();
            return  response([
                "status" => "success",
                "message" => "Item Successfully delete"
            ]);
        }else{
            return Response::json(['status' => "error", 'message' => 'Sorry You are demo user',],422);
        }

//        return Redirect::back()->with('msg', 'Item Successfully Delete');
    }
}
