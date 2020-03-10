<?php

namespace App\Http\Controllers;

use App\BusinessHour;
use App\Event;
use App\Holiday;
use App\Setting;
use App\User;
use App\UsRecord;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class EmployeeController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hours = BusinessHour::findorfail(1);
        $now = new Carbon();
        $thisMonth = Carbon::create($now->year, $now->month, 1, 0, 0, 0);
        $endMonth = Carbon::create($now->year, $now->month, $now->daysInMonth, 0, 0, 0);
        $events = Event::where('start', '>=', $thisMonth->toDateTimeString())->where('end', '<=', $endMonth->toDateTimeString())->count();
        $holidays = Holiday::where('start', '>=', $thisMonth->toDateTimeString())->where('end', '<=', $endMonth->toDateTimeString())->count();
        // dd($holidays);
        $today = Carbon::create($now->year, $now->month, $now->day, 0, 0, 0);
        $check_record = UsRecord::where(['user_id' => Auth::user()->id])->where('login_time_record', '>=', $today->timestamp)->first();
        // dd($checkin_record);
        $checkin = Carbon::createFromTimestamp($check_record->login_time_record)->format('h:i A');
        // $diff = $checkin->diffForHumans($now);

        // $checkout_record = UsRecord::where(['user_id' => Auth::user()->id])->where('logout_time_record', '>=', 'login_time_record')->get();
        // dd($checkout_record);
        // dd($check_record, $check_record);

        if ($check_record->logout_time_record) {
            // dd($check_record->logout_time_record);
            $checkout = Carbon::createFromTimestamp($check_record->logout_time_record)->format('h:i A');
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
            'checkin' => $checkin]);
    }

    public function viewUsers()
    {
        $emps = User::where('permissions', '<=', 0)->orderBy('fullname', 'asc')->with('image')->get();
        // $emp_date = Carbon::make($emp->user_time);
        $bg = ['info', 'danger', 'success', 'warning'];
        foreach ($emps as $emp) {
            $emp_bg[$emp->id] = $bg[rand(0,3)];
        }
        // dd($emp_bg);
        return view('employee.viewUsers', [
            'emps' => $emps,
            'bg' => $emp_bg
        ]);
    }

    public function GetEmpMonth()
    {
        $id = Auth::user()->id;
        $today = new Carbon();
        $month = $today->month;
        $userRecords = User::findOrFail($id);

        $rec = UsRecord::where(['user_id' => $id, 'login_mo_record' => $month])
            ->orderby('login_time_record', 'asc')
            ->get()
            ->unique('login_time_record');

        $sorting = UsRecord::select('user_id', 'login_mo_record')
            ->where('user_id', $id)
            ->get()
            ->unique('login_mo_record');

        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
            // in this example the cascade won't go farther than week unit
        ]);

        // dd($sorting);
        // dd($rec);
        if ($rec->contains('user_id', $id)) {
            $i = 1;
            // dd($userRecords);
            $totalHrs = new Carbon();
            foreach ($rec as $userR) {
                $login = Carbon::createFromTimestamp($userR->login_time_record);
                $wkdays[$i] = $login->toDateString();
                $i++;
                if ($userR->logout_time_record > $userR->login_time_record) {
                    $logout = Carbon::createFromTimestamp($userR->logout_time_record);
                    $worksecs = $login->diffInSeconds($logout);
                    $workmins = $login->diffInMinutes($logout);
                    $workhrs = $login->diffInHours($logout);

                    $wrkhrs[$userR->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                    // dd($workmins);
                    $total[$userR->id] = $workmins;
                } else {
                    $settings = Setting::findorfail(1);
                    $start = Carbon::create($login->year, $login->month, $login->day, $settings->start_hr ?? 7, 0, 0);
                    $end = Carbon::create($login->year, $login->month, $login->day, $settings->end_hr ?? 10, 0, 0);
                    // dd($login->day);
                    if ($login->between($start, $end, true)) {
                        $settings_workhrs = CarbonInterval::hours($settings->within_flex);
                        $worksecs = $settings_workhrs->totalSeconds;
                        $workmins = $settings_workhrs->totalMinutes;
                        $total[$userR->id] = $workmins;
                        $wrkhrs[$userR->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                    } else {
                        $settings_workhrs = CarbonInterval::hours($settings->after_flex);
                        $worksecs = $settings_workhrs->totalSeconds;
                        $workmins = $settings_workhrs->totalMinutes;
                        $total[$userR->id] = $workmins;
                        $wrkhrs[$userR->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                    }

                }
                // echo $wrkhrs[$userR->id];
                // dd($userR->login_time_record);
                // dd($wrkhrs[$userR->id]);
            }
            $n_total = array_sum($total);
            // $totalHrs = CarbonInterval::make($n_total);
            // dd($totalHrs);
            // $lang = 'it';
            // CarbonInterval::setLocale($lang);
            $totalHrs = CarbonInterval::minutes($n_total)->cascade();
            // dd($userRecords->usRecord->login_time_record);

            return view('employee.show',
                ['user' => $userRecords,
                    'records' => $rec,
                    'wkhrs' => $wrkhrs,
                    'months' => $sorting,
                    'totalhrs' => $totalHrs,
                    'currMonth' => $month,
                    'wkdays' => $wkdays ?? '']);
        } else {
            return view('employee.show', ['user' => $userRecords,
                'records' => $rec,
                'months' => $sorting,
                'currMonth' => $month]);
        }

    }


    public function GetEmpLastMonth()
    {
        $id = Auth::user()->id;
        $today = new Carbon();
        $month = $today->subMonth()->month;
        // dd($month);
        $userRecords = User::findOrFail($id);

        $rec = UsRecord::where(['user_id' => $id, 'login_mo_record' => $month])
            ->orderby('login_time_record', 'asc')
            ->get()
            ->unique('login_time_record');

        $sorting = UsRecord::select('user_id', 'login_mo_record')
            ->where('user_id', $id)
            ->get()
            ->unique('login_mo_record');

        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
            // in this example the cascade won't go farther than week unit
        ]);

        // dd($sorting);
        // dd($rec);
        if ($rec->contains('user_id', $id)) {
            $i = 1;
            // dd($userRecords);
            $totalHrs = new Carbon();
            foreach ($rec as $userR) {
                $login = Carbon::createFromTimestamp($userR->login_time_record);
                $wkdays[$i] = $login->toDateString();
                $i++;
                if ($userR->logout_time_record > $userR->login_time_record) {
                    $logout = Carbon::createFromTimestamp($userR->logout_time_record);
                    $worksecs = $login->diffInSeconds($logout);
                    $workmins = $login->diffInMinutes($logout);
                    $workhrs = $login->diffInHours($logout);

                    $wrkhrs[$userR->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                    // dd($workmins);
                    $total[$userR->id] = $workmins;
                } else {
                    $settings = Setting::findorfail(1);
                    $start = Carbon::create($login->year, $login->month, $login->day, $settings->start_hr ?? 7, 0, 0);
                    $end = Carbon::create($login->year, $login->month, $login->day, $settings->end_hr ?? 10, 0, 0);
                    // dd($login->day);
                    if ($login->between($start, $end, true)) {
                        $settings_workhrs = CarbonInterval::hours($settings->within_flex);
                        $worksecs = $settings_workhrs->totalSeconds;
                        $workmins = $settings_workhrs->totalMinutes;
                        $total[$userR->id] = $workmins;
                        $wrkhrs[$userR->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                    } else {
                        $settings_workhrs = CarbonInterval::hours($settings->after_flex);
                        $worksecs = $settings_workhrs->totalSeconds;
                        $workmins = $settings_workhrs->totalMinutes;
                        $total[$userR->id] = $workmins;
                        $wrkhrs[$userR->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                    }

                }
                // echo $wrkhrs[$userR->id];
                // dd($userR->login_time_record);
                // dd($wrkhrs[$userR->id]);
            }
            $n_total = array_sum($total);
            // $totalHrs = CarbonInterval::make($n_total);
            // dd($totalHrs);
            // $lang = 'it';
            // CarbonInterval::setLocale($lang);
            $totalHrs = CarbonInterval::minutes($n_total)->cascade();
            // dd($userRecords->usRecord->login_time_record);

            return view('employee.show',
                ['user' => $userRecords,
                    'records' => $rec,
                    'wkhrs' => $wrkhrs,
                    'months' => $sorting,
                    'totalhrs' => $totalHrs,
                    'currMonth' => $month,
                    'wkdays' => $wkdays ?? '']);
        } else {
            return view('employee.show', ['user' => $userRecords,
                'records' => $rec,
                'months' => $sorting,
                'currMonth' => $month]);
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = 'Hello';
        return Response::json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
