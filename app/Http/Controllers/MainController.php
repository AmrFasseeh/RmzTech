<?php

namespace App\Http\Controllers;

use App\BusinessHour;
use App\Event;
use App\Holiday;
use App\User;
use App\UsRecord;
use Carbon\Carbon;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hours = BusinessHour::findorfail(1);
        $emps = User::where('permissions', '==', 0)->count();
        $now = new Carbon();
        $thisMonth = Carbon::create($now->year, $now->month, 1, 0, 0, 0);
        $endMonth = Carbon::create($now->year, $now->month, $now->daysInMonth, 0, 0, 0);
        $events = Event::where('start', '>=', $thisMonth->toDateTimeString())->where('end', '<=', $endMonth->toDateTimeString())->count();
        $holidays = Holiday::where('start', '>=', $thisMonth->toDateTimeString())->where('end', '<=', $endMonth->toDateTimeString())->count();
        // dd($holidays);
        $today = Carbon::create($now->year, $now->month, $now->day, 0, 0, 0);
        $checkins = UsRecord::where('login_time_record', '>=', $today->timestamp)->count();

        if ($hours->is_sat_holi == 1) {
            $days['sat'] = 20;
        } else {
            $days['sat'] = 6;
        }
        if ($hours->is_sun_holi == 1) {
            $days['sun'] = 20;
        } else {
            $days['sun'] = 0;
        }
        if ($hours->is_mon_holi == 1) {
            $days['mon'] = 20;
        } else {
            $days['mon'] = 1;
        }
        if ($hours->is_tue_holi == 1) {
            $days['tue'] = 20;
        } else {
            $days['tue'] = 2;
        }
        if ($hours->is_wed_holi == 1) {
            $days['wed'] = 20;
        } else {
            $days['wed'] = 3;
        }
        if ($hours->is_thu_holi == 1) {
            $days['thu'] = 20;
        } else {
            $days['thu'] = 4;
        }
        if ($hours->is_fri_holi == 1) {
            $days['fri'] = 20;
        } else {
            $days['fri'] = 5;
        }
        // dd($emps);
        return view('home',
            ['work' => $hours,
                'days' => $days,
                'emps' => $emps,
                'thisMonth' => $now->shortEnglishMonth,
                'holidays' => $holidays,
                'events' => $events,
                'checkins' => $checkins]);
    }
}
