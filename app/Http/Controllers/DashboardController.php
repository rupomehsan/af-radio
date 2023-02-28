<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Language;
use App\Models\Radio;
use App\Models\RadioSchedule;
use App\Models\RadioShare;
use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalLanguage = Language::count();
        $totalRadioChannel = Radio::count();
        $totalCountry = Country::count();
        $totalUser = User::where('user_role_id', '3')->count();
        $totalListening = RadioSchedule::count();
        $totalActiveUser = UserActivity::where("status","online")->count();
        $totalLsHor = $totalListening * $totalUser * 24;
//        $countryList = Country::where('status', 'active')->get();

        $lastdayTotalBroadCasting = Radio::where('created_at', '>=', Carbon::now()->subDays(1))->count();
        $lastWeekTotalBroadCasting = Radio::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $lastMonthTotalBroadCasting = Radio::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $lastdayTotalShare = RadioShare::where('created_at', '>=', Carbon::now()->subDays(1))->count();
        $lastWeekTotalShare = RadioShare::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $lastMonthTotalShare = RadioShare::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $currentMonthCountries = Country::with(['radios' => function ($radioQuery) {
            $radioQuery->with(['top_listens' => function ($listenQuery) {
                $listenQuery->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth()->month);
            }]);
        }])->get()->toArray();

        $prevMonthCountries = Country::with(['radios' => function ($radioQuery) {
            $radioQuery->with(['top_listens' => function ($listenQuery) {
                $listenQuery->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth()->month);
            }]);
        }])->get()->toArray();

        $countries = [];
        $current = [];
        $prev = [];

        foreach ($currentMonthCountries as $country) {
            $totalCount = 0;
            if ($country['radios']) {
                foreach ($country['radios'] as $radio) {
                    $totalCount += count($radio['top_listens']);
                }
            }

            array_push($current, [
                'name' => $country['name'],
                'image' => $country['image'],
                'listen_count' => $totalCount
            ]);
        }

        foreach ($prevMonthCountries as $country) {
            $totalCount = 0;
            if ($country['radios']) {
                foreach ($country['radios'] as $radio) {
                    $totalCount += count($radio['top_listens']);
                }
            }

            array_push($prev, [
                'name' => $country['name'],
                'image' => $country['image'],
                'listen_count' => $totalCount
            ]);
        }

        foreach ($current as $currentItem) {
//            $diff = 0;
//            $growth = 0;
            foreach ($prev as $prevItem) {
                if ($currentItem['name'] === $prevItem['name']) {
                    $prevCount = $prevItem['listen_count'] === 0 ? 1 : $prevItem['listen_count'];
                    $diff = $currentItem['listen_count'] - $prevCount;
                    $growth = ($diff / $prevCount) * 100;

                    array_push($countries, [
                        'name' => $currentItem['name'],
                        'image' => $currentItem['image'],
                        'growth' => $growth
                    ]);
                }
            }
        }
        // dd($countryList);
        return view('dashboard')->with(compact(
            'totalLanguage',
            'totalRadioChannel',
            'totalCountry',
            'totalUser',
            'countries',
            'lastdayTotalBroadCasting',
            'lastWeekTotalBroadCasting',
            'lastMonthTotalBroadCasting',
            'lastdayTotalShare',
            'lastWeekTotalShare',
            'lastMonthTotalShare',
            "totalLsHor",
            "totalActiveUser"
        ));
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
