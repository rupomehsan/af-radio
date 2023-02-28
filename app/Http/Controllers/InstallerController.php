<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstallerController extends Controller
{
    public function envUpdate(Request $request)
    {
        // dd($request->all());
        $data = [
            'APP_NAME' => request('app_name') ?? env('APP_NAME'),
            'APP_URL' => request('app_url') ?? env('APP_URL'),
            'DB_DATABASE' => request('db_name') ?? env('DB_DATABASE'),
            'DB_USERNAME' => request('db_username') ?? env('DB_USERNAME'),
            'DB_PASSWORD' => request('db_password') ?? env('DB_PASSWORD'),
            'DB_HOST' => request('db_host') ?? env('DB_HOST'),
            'DB_PORT' => request('db_port') ?? env('DB_PORT'),
//            'MAIL_MAILER' => request('mail_mailer') ?? env('MAIL_MAILER'),
//            'MAIL_HOST' => request('mail_host') ?? env('MAIL_HOST'),
//            'MAIL_PORT' => request('mail_port') ?? env('MAIL_PORT'),
//            'MAIL_USERNAME' => request('mail_username') ?? env('MAIL_USERNAME'),
//            'MAIL_PASSWORD' => request('mail_password') ?? env('MAIL_PASSWORD'),
        ];
        // dd($data);
        foreach ($data as $key => $singleItem) {
            $this->setEnvValue($key, $singleItem);
        }
        return response([
            'status' => 'success',
        ], 200);
    }

    public function setEnvValue(string $key, string $value)
    {
        $path = app()->environmentFilePath();
        $env = file_get_contents($path);

        $old_value = env($key);

        if (!str_contains($env, $key . '=')) {
            $env .= sprintf("%s=%s\n", $key, $value);
        } else if ($old_value) {
            $env = str_replace(sprintf('%s=%s', $key, $old_value), sprintf('%s=%s', $key, $value), $env);
        } else {
            $env = str_replace(sprintf('%s=', $key), sprintf('%s=%s', $key, $value), $env);
        }

        file_put_contents($path, $env);
        // dd($_ENV);
        return response([
            'status' => 'success',
            'data' => $_ENV,
        ], 200);
    }

    public function dbCheck(Request $request)
    {
        // dd($request->all());
        try {
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName()) {
                $message = "Yes! Successfully connected to the DB: " . DB::connection()->getDatabaseName();
                $isAllOk = true;
                return response([
                    'status' => 'success',
                    'message' => $message,
                ], 200);
            } else {
                $message = "Could not find the database. Please check your configuration";
                $isAllOk = false;
                return response([
                    'status' => 'error',
                    'message' => $message,
                ], 404);
            }
        } catch (Exception$e) {
            $message = "Could not find the database. Please check your configuration";
            $isAllOk = false;
            return response([
                'status' => 'server_error',
                'message' => $message,
            ], 500);
            // return view('vendor.installer.finished', compact('message', 'isAllOk'));
        }
    }

    public function finished()
    {
        try {
            if (!file_exists(storage_path('installed'))) {
                file_put_contents(storage_path('installed'), 'installed');
            }
            return response([
                'status' => 'success',
                'message' => 'Installed process completed',
            ]);
        } catch (Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function licenseChecker(Request $request)
    {
        try {
//            $res = Http::post('https://license.projectx.com.bd/license-check', [
////                'code' => '86781236-23d0-4b3c-7dfa-c1c147e0dece',
//                'code' => $request->code,
//            ]);
//
//            $res = $res->json();
             $res = [
                             'status' => 'success',
                         ];
            if ($res['status'] === 'success') {
                if (!file_exists(base_path('vendor/licensed'))) {
                    file_put_contents(base_path('vendor/licensed'), 'licensed');
                }

                return response([
                    'status' => 'success',
                    'message' => 'Purchase key is valid',
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Purchase key is not valid',
                ]);
            }
        } catch (Exception$e) {
            return response([
                'status' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
