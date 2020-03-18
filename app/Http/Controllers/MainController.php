<?php

namespace App\Http\Controllers;

use App\BusinessHour;
use App\Event;
use App\Holiday;
use App\User;
use App\UsRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeeController;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->permissions == 1) {
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

        } else {
            $hours = BusinessHour::findorfail(1);
        $now = new Carbon();
        $thisMonth = Carbon::create($now->year, $now->month, 1, 0, 0, 0);
        $endMonth = Carbon::create($now->year, $now->month, $now->daysInMonth, 0, 0, 0);
        $events = Event::where('start', '>=', $thisMonth->toDateTimeString())->where('end', '<=', $endMonth->toDateTimeString())->count();
        $holidays = Holiday::where('start', '>=', $thisMonth->toDateTimeString())->where('end', '<=', $endMonth->toDateTimeString())->count();
        // dd($holidays);
        $today = Carbon::create($now->year, $now->month, $now->day, 0, 0, 0);
        $check_record = UsRecord::where(['user_id' => Auth::user()->id])->where('login_time_record', '>=', $today->timestamp)->first();
        // dd($check_record);
        if ($check_record != null) {
            $checkin = Carbon::createFromTimestamp($check_record->login_time_record)->format('h:i A');
            // $diff = $checkin->diffForHumans($now);

            // $checkout_record = UsRecord::where(['user_id' => Auth::user()->id])->where('logout_time_record', '>=', 'login_time_record')->get();
            // dd($checkout_record);
            // dd($check_record, $check_record);

            if ($check_record->logout_time_record) {
                // dd($check_record->logout_time_record);
                $checkout = Carbon::createFromTimestamp($check_record->logout_time_record)->format('h:i A');
            }
        }

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

        // dd(bcrypt('password'));
        return view('employee.home', [
            'work' => $hours,
            'days' => $days,
            'checkout' => $checkout ?? 'Not yet!',
            'thisMonth' => $now->shortEnglishMonth,
            'holidays' => $holidays,
            'events' => $events,
            'checkin' => $checkin ?? 'Not Yet!']);
        }
    }
}
