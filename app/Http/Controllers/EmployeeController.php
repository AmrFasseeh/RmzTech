<?php

namespace App\Http\Controllers;

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
        //
    }

    public function viewUsers()
    {
        $emps = User::where('permissions', '<=', 0)->orderBy('fullname', 'asc')->with('image')->get();
        // $emp_date = Carbon::make($emp->user_time);
        $bg = ['info', 'danger', 'success', 'warning'];
        foreach ($emps as $emp) {
            $emp_bg[$emp->id] = $bg[rand(0, 3)];
        }
        // dd($emp_bg);
        return view('employee.viewUsers', [
            'emps' => $emps,
            'bg' => $emp_bg,
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
                [   'user' => $userRecords,
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

    public function getAllRecords()
    {
        return view('employee.allrecords');
    }

    public function listYears()
    {
        $years = UsRecord::select('user_id', 'login_yr_record')
            ->where('user_id', Auth::user()->id)
            ->orderby('login_yr_record', 'desc')
            ->get()
            ->unique('login_yr_record');

        return response()->json($years);
    }

    public function listMonths($year)
    {
        $months = UsRecord::select('user_id', 'login_yr_record', 'login_mo_record')
            ->orderby('login_mo_record', 'desc')
            ->where([
                'login_yr_record' => $year,
                'user_id' => Auth::user()->id,
            ])
            ->get()
            ->unique('login_mo_record');

        return response()->json($months);

    }

    public function showYearMonth($year, $month)
    {
        $users = UsRecord::where(['login_yr_record' => $year, 'login_mo_record' => $month])
            ->where(['user_id' => Auth::user()->id])
            ->orderby('logout_time_record', 'desc')
            ->with('user')
            ->get();

        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
            // in this example the cascade won't go farther than hour unit
        ]);
        $settings = Setting::findorfail(1);

        if (!$users->isEmpty()) {
            // Getting the total working hours expected on the selected month
            $thisMonth = Carbon::createFromTimestamp($users[0]->login_time_record);
            $dt = Carbon::create($thisMonth->year, $thisMonth->month, 1);
            $dt2 = Carbon::create($thisMonth->year, $thisMonth->month, $thisMonth->daysInMonth);
            $workingDays = $dt->diffInDaysFiltered(function (Carbon $date) {
                return !$date->isWeekend();
            }, $dt2);
            if ($workingDays == 20) {
                $Hours = $dt->diffInHoursFiltered(function (Carbon $date) {
                    return !$date->isWeekend();
                }, $dt2);
                $workingHours = $Hours - 320;
            } else if ($workingDays == 21) {
                $Hours = $dt->diffInHoursFiltered(function (Carbon $date) {
                    return !$date->isWeekend();
                }, $dt2);
                $workingHours = $Hours - 336;
            } else if ($workingDays == 22) {
                $Hours = $dt->diffInHoursFiltered(function (Carbon $date) {
                    return !$date->isWeekend();
                }, $dt2);
                $workingHours = $Hours - 352;
            } else if ($workingDays == 23) {
                $Hours = $dt->diffInHoursFiltered(function (Carbon $date) {
                    return !$date->isWeekend();
                }, $dt2);
                $workingHours = $Hours - 368;
            }
        }

        foreach ($users as $user) {
            if ($user->logout_time_record > $user->login_time_record) {
                $login = Carbon::createFromTimestamp($user->login_time_record);
                $logout = Carbon::createFromTimestamp($user->logout_time_record);
                $worksecs = $login->diffInSeconds($logout);
                $workmins = $login->diffInMinutes($logout);
                $workhrs = $login->diffInHours($logout);
                $expectedUserHours[$user->user_id] = $workingHours;

                $wrkhrs[$user->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();

                // dd($workhrs, $worksecs, $wrkhrs[$user->id]);
                $total[$user->id] = $workmins;
                $empTotal[$user->user_id][$user->id] = $workmins;
                $end = Carbon::create($login->year, $login->month, $login->day, $settings->end_hr ?? 10, 0, 0);
                $diff = $login->floatDiffInHours($end);
                if ($diff > 0) {
                    // dd(ceil($diff)*2);
                    $extraHours[$user->user_id][$user->id] = $diff;
                }
            } else {
                $today = $user->login_time_record;
                $login = Carbon::createFromTimestamp($user->login_time_record);
                $start = Carbon::create($login->year, $login->month, $login->day, $settings->start_hr ?? 7, 0, 0);
                $end = Carbon::create($login->year, $login->month, $login->day, $settings->end_hr ?? 10, 0, 0);
                // dd($login->day);
                if ($login->between($start, $end, true)) {
                    $settings_workhrs = CarbonInterval::hours($settings->within_flex);
                    $worksecs = $settings_workhrs->totalSeconds;
                    $workmins = $settings_workhrs->totalMinutes;
                    $total[$user->id] = $workmins;
                    $empTotal[$user->user_id][$user->id] = $workmins;
                    $wrkhrs[$user->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                } else {
                    $settings_workhrs = CarbonInterval::hours($settings->after_flex);
                    $worksecs = $settings_workhrs->totalSeconds;
                    $workmins = $settings_workhrs->totalMinutes;
                    $total[$user->id] = $workmins;
                    $empTotal[$user->user_id][$user->id] = $workmins;
                    $wrkhrs[$user->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                    $diff = $login->floatDiffInHours($end);
                    if ($diff > 0) {
                        $extraHours[$user->user_id][$user->id] = $diff;
                    }
                }
            }
        }
        // print_r($total);
        if (isset($total)) {
            $n_total = array_sum($total);
            foreach ($users as $user) {
                $totalemphrs[$user->user_id] = CarbonInterval::minutes(array_sum($empTotal[$user->user_id]))->cascade();
                if (isset($extraHours)) {
                    $finalExtra[$user->user_id] = ceil(array_sum($extraHours[$user->user_id]));
                    $expectedUserHours[$user->user_id] = $workingHours + (ceil($finalExtra[$user->user_id]) * $settings->penalty_multiplier);
                }

                if (isset($workingHours)) {
                    $diff = $workingHours - $totalemphrs[$user->user_id]->hours;
                    // dd($diff, $user->user->working_hrs/2, $totalemphrs[$user->user_id]->hours);
                    // dd(( ($diff <= $user->user->working_hrs / 1.5 )), $diff);
                    if (($workingHours / 2) <= $diff) {
                        $class[$user->user_id] = 'bad';
                    } elseif (($workingHours - ($workingHours / 1.5) <= $diff)) {
                        $class[$user->user_id] = 'ok';
                        // dd($diff);
                    } elseif (($workingHours - ($workingHours / 1.1) <= $diff)) {
                        $class[$user->user_id] = 'good';
                    } else {
                        $class[$user->user_id] = 'excellent';
                        // dd($diff);
                    }
                }
            }
            // dd($totalemphrs[35]);
            // print_r($empTotal);
            // $totalemphrs = array_sum(array_column($empTotal, ));
            // print_r($totalemphrs[35]);
            $totalHrs = CarbonInterval::minutes($n_total)->cascade();

            if (isset($wrkhrs)) {
                if (!isset($expectedUserHours)) {
                    return view('Records.show', ['users' => $users->unique('name_record'), 'wkhrs' => $wrkhrs, 'totalhrs' => $totalHrs,
                        'month' => $month, 'emptotal' => $totalemphrs, 'status' => $class, 'wkHours' => $workingHours]);
                } else {
                    return view('Records.show', ['users' => $users->unique('name_record'), 'wkhrs' => $wrkhrs, 'totalhrs' => $totalHrs,
                        'month' => $month, 'emptotal' => $totalemphrs, 'status' => $class, 'expected_wkHours' => $expectedUserHours, 'wkHours' => $workingHours]);
                }
            }
        }

        return view('Records.show', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editUser()
    {
        $user = Auth::user();
        return view('employee.editUser', ['user' => $user]);
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
        return response()->json($data);
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
