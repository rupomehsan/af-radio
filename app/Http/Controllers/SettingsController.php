<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\SubCategory;
use App\Models\VideoSetting;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Response;
use Session;
use Validator;

class SettingsController extends Controller
{
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

    public function basicSettings(Request $request)
    {
        $target = Setting::first();
        if ($target) {
            return view('settings.basicSettings')->with(compact('target'));
        } else {
            return view('settings.index');
        }
    }

    public function Settings(Request $request)
    {
        $target = Setting::first();
        if ($target) {
            return response([
                'status' => "success",
                'data' => $target
            ]);
        }

    }

    public function basicSettingsUpdate(Request $request)
    {
        try {
//             dd($request->all());


            if (auth()->user()->email !== "demoadmin@radio.com") {

                $validate = Validator::make(request()->all(), [
                    'system_name' => 'required',
                ]);

                if ($validate->fails()) {
                    return redirect('admin/basic-settings')
                        ->withInput()
                        ->withErrors($validate);
                }

                $target = Setting::first();
                $fileName = $target->logo;
                $target->system_name = $request->system_name ?? $target->system_name;
                $target->app_version = $request->app_version ?? $target->app_version;
                $target->mail_address = $request->mail_address ?? $target->mail_address;
                $target->update_app = $request->update_app;
                $target->developed_by = $request->developed_by ?? $target->developed_by;
                $target->facebook = $request->facebook;
                $target->instagram = $request->instagram;
                $target->twitter = $request->twitter;
                $target->youtube = $request->youtube;
                $target->copyright = $request->copyright ?? $target->copyright;
                $target->banner_image = $request->banner_image;
                $target->description = $request->description;
                $target->privacy_policy = $request->privacy_policy ?? $target->privacy_policy;
                $target->cookies_policy = $request->cookies_policy;
                $target->terms_policy = $request->terms_policy ?? $target->terms_policy;
                if (!empty($request->file('logo'))) {
                    $image = $request->file('logo');
                    $imageName = time() . '.' . $image->getClientOriginalName();

                    if (config('app.env') === 'production') {
                        $image->move('uploads/settings', $imageName);
                    } else {
                        $image->move(public_path('/uploads/settings'), $imageName);
                    }

                    $protocol = request()->secure() ? 'https://' : 'http://';
                    $fileName = $protocol . $_SERVER['HTTP_HOST'] . '/uploads/settings/' . $imageName;
                }
                $target->logo = $fileName;

                if ($target->update()) {
                    Session::flash('success', "Basic Settings Updated Successfully!");
                    return redirect('admin/basic-settings');
                } else {
                    Session::flash('error', "Basic Settings  Update Unsuccessfull!");
                    return redirect('admin/basic-settings');
                }
            } else {
                Session::flash('error', "Sorry You Are Demo User");
                return redirect('admin/basic-settings');
            }
        } catch (\Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function basicSettingsCreate(Request $request)
    {
        try {
//             dd($request->all());

            $validate = Validator::make(request()->all(), [
                'system_name' => 'required',
            ]);

            if ($validate->fails()) {
                return redirect('admin/basic-settings')
                    ->withInput()
                    ->withErrors($validate);
            }
            $fileName = '';
            if (!empty($request->file('logo'))) {
                $image = $request->file('logo');
                $imageName = time() . '.' . $image->getClientOriginalName();

                if (config('app.env') === 'production') {
                    $image->move('uploads/settings', $imageName);
                } else {
                    $image->move(public_path('/uploads/settings'), $imageName);
                }
                $protocol = request()->secure() ? 'https://' : 'http://';
                $fileName = $protocol . $_SERVER['HTTP_HOST'] . '/uploads/settings/' . $imageName;
            }

            $target = new Setting;
            $target->system_name = $request->system_name;
            $target->app_version = $request->app_version;
            $target->mail_address = $request->mail_address;
            $target->update_app = $request->update_app;
            $target->developed_by = $request->developed_by;
            $target->facebook = $request->facebook;
            $target->instagram = $request->instagram;
            $target->twitter = $request->twitter;
            $target->youtube = $request->youtube;
            $target->copyright = $request->copyright;
            $target->logo = $fileName;
            $target->banner_image = $request->banner_image;
            $target->description = $request->description;
            $target->privacy_policy = $request->privacy_policy;
            $target->cookies_policy = $request->cookies_policy;
            $target->terms_policy = $request->terms_policy;

            if ($target->save()) {
                Session::flash('success', "Basic Settings Create Successfully!");
                return redirect('admin/basic-settings');
            } else {
                Session::flash('error', "Basic Settings  Create Unsuccessfull!");
                return redirect('admin/basic-settings');
            }
        } catch (\Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function videoSettings(Request $request)
    {
        $target = VideoSetting::where('show_page', 'home')->get();
        $categoryList = Category::where('status', 'active')->pluck('name', 'id')->toArray();
        // dd($categoryList);
        return view('settings.videoSettings')->with(compact('target', 'categoryList'));
    }

    public function getCategoryContent(Request $request)
    {
        $target = VideoSetting::where('show_page', 'home')->get();
        $category = Category::where('id', $request->category_id)->first();
        // dd($category);
        $view = view('settings.getCategoryContent', compact('target', 'category'))->render();
        return response()->json(['html' => $view]);
    }

    public function videoSettingsCategory(Request $request)
    {
        $categoryList = Category::where('status', 'active')->pluck('name', 'id')->toArray();
        return view('settings.videoSettingsCategory')->with(compact('categoryList'));
    }

    public function getSettingsCategory(Request $request)
    {
        // dd($request->all());
        $category = Category::where('id', $request->category_id)->first();
        $target = VideoSetting::where('show_page', '!=', 'home')
            ->where('category_id', $request->category_id)
            ->get();
        $subCategoryList = SubCategory::where('category_id', $request->category_id)
            ->where('status', 'active')
            ->pluck('name', 'id')->toArray();

        $view = view('settings.getSettingsCategory', compact('category', 'target', 'subCategoryList'))->render();
        return response()->json(['html' => $view]);
    }

    public function getSubCategoryContent(Request $request)
    {
        $subCategory = SubCategory::where('id', $request->sub_category_id)->first();
        // dd($category);
        $view = view('settings.getSubCategoryContent', compact('subCategory'))->render();
        return response()->json(['html' => $view]);
    }

    public function videoSettingsUpdate(Request $request)
    {
        try {
            // dd($request->all());
            $data = $target = [];
            if (!empty($request->name)) {
                foreach ($request->name as $name) {
                    $data[$name]['show_page'] = $request->show_page;
                    $data[$name]['name'] = $name;
                    $data[$name]['created_at'] = date('Y-m-d H:i:s');
                    $data[$name]['updated_at'] = date('Y-m-d H:i:s');
                    if ($request->show_page != 'home') {
                        $data[$name]['category_id'] = $request->category_id;
                    }
                }
            }
            if (!empty($request->vertical_image)) {
                foreach ($request->vertical_image as $name => $image) {
                    $data[$name]['vertical_image'] = $image ?? 'off';
                }
            }
            if (!empty($request->horizontal_image)) {
                foreach ($request->horizontal_image as $name => $image) {
                    $data[$name]['horizontal_image'] = $image ?? 'off';
                }
            }
            if (!empty($request->video_number)) {
                foreach ($request->video_number as $name => $number) {
                    $data[$name]['video_number'] = $number ?? 0;
                }
            }
            if ((!empty($request->category_id)) && ($request->show_page == 'home')) {
                foreach ($request->category_id as $name => $id) {
                    $data[$name]['category_id'] = $id ?? 0;
                }
            }
            if (!empty($request->sub_category_id)) {
                foreach ($request->sub_category_id as $name => $id) {
                    $data[$name]['sub_category_id'] = $id ?? 0;
                }
            }

            if (!empty($data)) {
                foreach ($data as $fieldName => $column) {
                    $target[$fieldName]['show_page'] = $column['show_page'];
                    $target[$fieldName]['category_id'] = $column['category_id'] ?? '0';
                    $target[$fieldName]['sub_category_id'] = $column['sub_category_id'] ?? '0';
                    $target[$fieldName]['name'] = $column['name'];
                    $target[$fieldName]['vertical_image'] = $column['vertical_image'] ?? 'off';
                    $target[$fieldName]['horizontal_image'] = $column['horizontal_image'] ?? 'off';
                    $target[$fieldName]['video_number'] = $column['video_number'] ?? '0';
                    $target[$fieldName]['created_at'] = $column['created_at'];
                    $target[$fieldName]['updated_at'] = $column['updated_at'];
                }
            }

            // dd($target);

            VideoSetting::where('show_page', $request->show_page)->delete();

            if (VideoSetting::insert($target)) {
                Session::flash('success', "Video Settings Updated Successfully!");
                return redirect()->back();
            } else {
                Session::flash('error', "Video Settings  Update Unsuccessfull!");
                return redirect()->back();
            }
        } catch (\Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
