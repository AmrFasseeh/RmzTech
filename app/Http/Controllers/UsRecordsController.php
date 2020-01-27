<?php

namespace App\Http\Controllers;

use App\Setting;
use App\UsRecord;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class UsRecordsController extends Controller
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
        $users = UsRecord::whereRaw('logout_time_record > login_time_record')->orderby('logout_time_record', 'desc')->get();
        foreach ($users as $user) {
            $login = Carbon::createFromTimestamp($user->login_time_record);
            $logout = Carbon::createFromTimestamp($user->logout_time_record);
            $workhrs = $login->diffInSeconds($logout);

            // dd($workhrs);

            $wrkhrs[$user->id] = CarbonInterval::seconds($workhrs)->cascade()->forHumans();
        }
        // dd($users->login_time_record);
        // $login_time = Carbon::createFromTimestamp($users->login_time_record)->toDateTimeString();
        // $logout_time = Carbon::createFromTimestamp($users->logout_time_record)->toDateTimeString();

        // $working_hrs = $logout_time - $login_time;
        return view('Records.show', ['users' => $users, 'wkhrs' => $wrkhrs]);
        dd(Carbon::createFromTimestamp(time())->toHour);
    }

    public function listYears()
    {
        $years = UsRecord::select('user_id', 'login_yr_record')
            ->orderby('login_yr_record', 'desc')
            ->get()
            ->unique('login_yr_record');

        return view('Records.date', ['years' => $years]);
    }

    public function listMonths($year)
    {
        $months = UsRecord::select('user_id', 'login_yr_record', 'login_mo_record')
            ->orderby('login_mo_record', 'desc')
            ->where('login_yr_record', $year)
            ->get()
            ->unique('login_mo_record');

        return view('Records.date', ['months' => $months]);

    }
    public function listMonthDays($year, $month)
    {
        $days = UsRecord::select('user_id', 'login_yr_record', 'login_mo_record', 'login_dy_record')
            ->orderby('login_mo_record', 'desc')
            ->where(['login_yr_record' => $year,
                'login_mo_record' => $month])
            ->get()
            ->unique('login_dy_record');

        return view('Records.date', ['days' => $days]);
    }

    public function showMonthDays($year, $month, $day)
    {
        $users = UsRecord::with('user')
            ->where(['login_yr_record' => $year, 'login_mo_record' => $month, 'login_dy_record' => $day])
            ->orderby('logout_time_record', 'desc')
            ->get(); // query database to get the records of all users with that day, month and year

        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
            //  cascade won't go farther than hour unit
        ]);
        foreach ($users as $user) { // loop over all users to extract their data
            if ($user->logout_time_record > $user->login_time_record) { // if the logout time is greater than the login time which is the (normal case)
                $login = Carbon::createFromTimestamp($user->login_time_record); // get login time and parse it to Carbon object
                $logout = Carbon::createFromTimestamp($user->logout_time_record); // get logout time and parse it to Carbon object
                $worksecs = $login->diffInSeconds($logout); // get time between logout and login time in seconds
                $workmins = $login->diffInMinutes($logout); // get time between logout and login time in minutes
                $workhrs = $login->diffInHours($logout); // get time between logout and login time in hours
                // dd($user->user->fullname);
                $wrkhrs[$user->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                // change seconds into hours and add them into work hours array with user id as index

                // dd($workhrs, $worksecs, $wrkhrs[$user->id]);
                $total[$user->id] = $workmins; // add wrkmins to total array with index as user id

                $empTotal[$user->user_id][$user->id] = $workmins;
                $today = $user->login_time_record; // get the record's date to send to the view
            } else { // if the logout time is not greater the login time (irregular case)
                $settings = Setting::findorfail(1);
                $today = $user->login_time_record;
                $login = Carbon::createFromTimestamp($user->login_time_record); // get login time and parse it to Carbon object
                $start = Carbon::create($login->year, $login->month, $login->day, $settings->start_hr ?? 7, 0, 0);
                $end = Carbon::create($login->year, $login->month, $login->day, $settings->end_hr ?? 10, 0, 0);
                // set interval to calculate whether this user arrived within flexible hours or not
                // dd($login->day);
                if ($login->between($start, $end, true)) { // check if the login time is between the flexible hours
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
                }
            }
        }
        if (isset($total)) {
            $n_total = array_sum($total);
            foreach ($users as $user) {
                // dd($empTotal[$user->user_id]);
                $totalemphrs[$user->user_id] = CarbonInterval::minutes(array_sum($empTotal[$user->user_id]))->cascade();
            }
            // dd($totalemphrs[35]);
            // print_r($empTotal);
            // $totalemphrs = array_sum(array_column($empTotal, ));
            // print_r($totalemphrs[35]);
            $totalHrs = CarbonInterval::minutes($n_total)->cascade();

            if (isset($wrkhrs)) {
                return view('Records.show', ['users' => $users->unique('name_record'), 'wkhrs' => $wrkhrs, 'totalhrs' => $totalHrs, 'month' => $month, 'emptotal' => $totalemphrs, 'day' => Carbon::createFromTimestamp($today)]);
            }
        }
        return view('Records.show', ['users' => $users]);
    }

    public function showYearMonth($year, $month)
    {
        $users = UsRecord::where(['login_yr_record' => $year, 'login_mo_record' => $month])
        // ->whereRaw('logout_time_record > login_time_record')
            ->orderby('logout_time_record', 'desc')
            ->with('user')
            ->get();

        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
            // in this example the cascade won't go farther than week unit
        ]);
        foreach ($users as $user) {
            if ($user->logout_time_record > $user->login_time_record) {
                $login = Carbon::createFromTimestamp($user->login_time_record);
                $logout = Carbon::createFromTimestamp($user->logout_time_record);
                $worksecs = $login->diffInSeconds($logout);
                $workmins = $login->diffInMinutes($logout);
                $workhrs = $login->diffInHours($logout);

                $wrkhrs[$user->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();

                // dd($workhrs, $worksecs, $wrkhrs[$user->id]);
                $total[$user->id] = $workmins;
                $empTotal[$user->user_id][$user->id] = $workmins;
            } else {
                $today = $user->login_time_record;
                $settings = Setting::findorfail(1);
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
                }
            }
        }
        // print_r($total);
        if (isset($total)) {
            $n_total = array_sum($total);
            foreach ($users as $user) {
                $totalemphrs[$user->user_id] = CarbonInterval::minutes(array_sum($empTotal[$user->user_id]))->cascade();
                if (isset($user->user->working_hrs)) {
                    $diff = $user->user->working_hrs - $totalemphrs[$user->user_id]->hours;
                    // dd($diff, $user->user->working_hrs/2, $totalemphrs[$user->user_id]->hours);
                    // dd(( ($diff <= $user->user->working_hrs / 1.5 )), $diff);
                    if (($user->user->working_hrs / 2) <= $diff) {
                        $class[$user->user_id] = 'bad';
                    } elseif (($user->user->working_hrs - ($user->user->working_hrs / 1.5) <= $diff)) {
                        $class[$user->user_id] = 'ok';
                        // dd($diff);
                    } elseif (($user->user->working_hrs - ($user->user->working_hrs / 1.1) <= $diff)) {
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
                return view('Records.show', ['users' => $users->unique('name_record'), 'wkhrs' => $wrkhrs, 'totalhrs' => $totalHrs, 'month' => $month, 'emptotal' => $totalemphrs, 'status' => $class]);
            }
        }

        return view('Records.show', ['users' => $users]);
    }

    public function showTodayReport()
    {
        $now = new Carbon();
        $users = UsRecord::where(['login_yr_record' => $now->year, 'login_mo_record' => $now->month, 'login_dy_record' => $now->day])
            ->orderby('logout_time_record', 'desc')
            ->get();

        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
            // in this example the cascade won't go farther than week unit
        ]);
        foreach ($users as $user) {
            if ($user->logout_time_record > $user->login_time_record) {
                $login = Carbon::createFromTimestamp($user->login_time_record);
                $logout = Carbon::createFromTimestamp($user->logout_time_record);
                $worksecs = $login->diffInSeconds($logout);
                $workmins = $login->diffInMinutes($logout);
                $workhrs = $login->diffInHours($logout);

                $wrkhrs[$user->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();

                // dd($workhrs, $worksecs, $wrkhrs[$user->id]);
                $total[$user->id] = $workmins;

                $empTotal[$user->user_id][$user->id] = $workmins;
                $today = $user->login_time_record;
            }
        }
        if (isset($total)) {
            $n_total = array_sum($total);
            // dd($users);
            foreach ($users as $user) {
                if (isset($empTotal[$user->user_id])) {
                    $totalemphrs[$user->user_id] = CarbonInterval::minutes(array_sum($empTotal[$user->user_id]))->cascade();
                } else {
                    $totalemphrs[$user->user_id] = "";
                }
            }
            // dd($totalemphrs[35]);
            // print_r($empTotal);
            // $totalemphrs = array_sum(array_column($empTotal, ));
            // print_r($totalemphrs[35]);
            $totalHrs = CarbonInterval::minutes($n_total)->cascade();

            if (isset($wrkhrs)) {
                return view('Records.show', ['users' => $users->unique('name_record'), 'wkhrs' => $wrkhrs, 'totalhrs' => $totalHrs, 'month' => $now->month, 'emptotal' => $totalemphrs, 'day' => $now]);
            }
        }
        // dd($now->getTimestamp());
        return view('Records.show', ['users' => $users->unique('name_record'), 'month' => $now->month, 'day' => $now]);
    }

    public function showThisMonth()
    {
        $now = new Carbon();
        $users = UsRecord::where(['login_yr_record' => $now->year, 'login_mo_record' => $now->month])
        // ->whereRaw('logout_time_record > login_time_record')
            ->orderby('logout_time_record', 'desc')
            ->with('user')
            ->get();

        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
            // in this example the cascade won't go farther than week unit
        ]);
        foreach ($users as $user) {
            if ($user->logout_time_record > $user->login_time_record) {
                $login = Carbon::createFromTimestamp($user->login_time_record);
                $logout = Carbon::createFromTimestamp($user->logout_time_record);
                $worksecs = $login->diffInSeconds($logout);
                $workmins = $login->diffInMinutes($logout);
                $workhrs = $login->diffInHours($logout);

                $wrkhrs[$user->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();

                // dd($workhrs, $worksecs, $wrkhrs[$user->id]);
                $total[$user->id] = $workmins;
                $empTotal[$user->user_id][$user->id] = $workmins;
            } else {
                $today = $user->login_time_record;
                $settings = Setting::findorfail(1);
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
                }
            }
        }
        // print_r($total);
        if (isset($total)) {
            $n_total = array_sum($total);
            foreach ($users as $user) {
                $totalemphrs[$user->user_id] = CarbonInterval::minutes(array_sum($empTotal[$user->user_id]))->cascade();
                if (isset($user->user->working_hrs)) {
                    $diff = $user->user->working_hrs - $totalemphrs[$user->user_id]->hours;
                    // dd($diff, $user->user->working_hrs/2, $totalemphrs[$user->user_id]->hours);
                    // dd(( ($diff <= $user->user->working_hrs / 1.5 )), $diff);
                    if (($user->user->working_hrs / 2) <= $diff) {
                        $class[$user->user_id] = 'bad';
                    } elseif (($user->user->working_hrs - ($user->user->working_hrs / 1.5) <= $diff)) {
                        $class[$user->user_id] = 'ok';
                        // dd($diff);
                    } elseif (($user->user->working_hrs - ($user->user->working_hrs / 1.1) <= $diff)) {
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
                return view('Records.show', ['users' => $users->unique('name_record'), 'wkhrs' => $wrkhrs, 'totalhrs' => $totalHrs, 'month' => $now->month, 'emptotal' => $totalemphrs, 'status' => $class]);
            }
        }

        return view('Records.show', ['users' => $users]);
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
     * @param  \App\UsRecord  $usRecord
     * @return \Illuminate\Http\Response
     */
    public function show(UsRecord $usRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UsRecord  $usRecord
     * @return \Illuminate\Http\Response
     */
    public function edit($record)
    {
        $record_single = UsRecord::find($record);
        // dd($record_single);

        return view('Users.editRecord', ['record' => $record_single]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UsRecord  $usRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $log = $request->date . ' ' . substr($request->logout_time_record,0,5);
        $logout = Carbon::create($request->date);
        $logout->setTimeFromTimeString(substr($request->logout_time_record, 0, 5));
        $record = UsRecord::findorfail($request->id);
        $record->logout_time_record = $logout->getTimeStamp();
        // dd($logout->minute);
        $record->logout_yr_record = $logout->year;
        $record->logout_mo_record = $logout->month;
        $record->logout_dy_record = $logout->day;
        $record->logout_hr_record = $logout->hour;
        $record->logout_mn_record = $logout->minute;
        $record->logout_sc_record = $logout->second;

        $record->save();

        $request->session()->flash('status', 'Record was updated!');
        return redirect()->route('show.single', ['user' => $record->user_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UsRecord  $usRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsRecord $usRecord)
    {
        //
    }
}
