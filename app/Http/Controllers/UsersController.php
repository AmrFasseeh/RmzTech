<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Image;
use App\Setting;
use App\User;
use App\UsRecord;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
        return view('Users.show', ['users' => User::where('permissions', 0)->with('image')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $validatedEmp = $request->validated();
        // dd($validatedEmp);
        // dd((string)Carbon::make($validatedEmp['time_user'])->getTimestamp());
        $create_at = (string) Carbon::make($validatedEmp['time_user'])->getTimestamp();
        // dd($request->file('image_user'));
        $newEmp = User::create([
            'fullname' => $validatedEmp['fullname'],
            'username' => $validatedEmp['username'],
            'password' => md5($validatedEmp['password']),
            'email' => $validatedEmp['email'],
            'phone' => $validatedEmp['phone'],
            'time_user' => '123456',
            'gender' => $validatedEmp['gender'],
            'permissions' => $validatedEmp['permissions'],
            'ip_user' => $request->ip(),
            'working_hrs' => (int)$validatedEmp['working_hrs']
        ]);

        $newEmp->time_user = Carbon::make($validatedEmp['time_user']);
        // dd($request->file('image_user'));
        if ($request->file('image')) {
            $path = $request->file('image')->storeAs('user_images', $newEmp->id . '.' . $request->file('image')->guessExtension());
            // dd($path);
            $newEmp->image()->save(
                Image::make(['image_path' => $path])
            );
        } else {
            $path = 'user_images/default-user.jpg';
            $newEmp->image()->save(
                Image::make(['image_path' => $path])
            );
        }
        $newEmp->save();

        $request->session()->flash('status', 'Employee was created!');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $userRecords = User::findOrFail($id);
        // dd($userRecords);
        $rec = UsRecord::where('user_id', $id)
            ->orderby('login_time_record', 'desc')
            ->get()
            ->unique('login_time_record');

        $sorting = UsRecord::select('user_id', 'login_mo_record')
            ->where('user_id', $id)
            ->get()
            ->unique('login_mo_record');
        // dd($rec);
        if ($rec->contains('user_id', $id)) {
            // dd($userRecords);
            foreach ($rec as $userR) {
                if ($userR->logout_time_record > $userR->login_time_record) {
                    $login = Carbon::createFromTimestamp($userR->login_time_record);
                    $logout = Carbon::createFromTimestamp($userR->logout_time_record);
                    $workhrs = $login->diffInSeconds($logout);

                    // dd($workhrs);

                    $wrkhrs[$userR->id] = CarbonInterval::seconds($workhrs)->cascade()->forHumans();
                    // echo $wrkhrs[$userR->id];
                    // dd($userR->login_time_record);
                    // dd($wrkhrs[$userR->id]);
                } else {
                    $settings = Setting::findorfail(1);
                    $login = Carbon::createFromTimestamp($userR->login_time_record);
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
                // dd($userRecords->usRecord->login_time_record);
            }

            return view('Users.single', ['user' => $userRecords,
                'records' => $rec,
                'wkhrs' => $wrkhrs,
                'months' => $sorting]);
        } else {
            return view('Users.single', ['user' => $userRecords,
                'records' => $rec,
                'months' => $sorting]);
        }

    }

    public function showMonthly($id, $month)
    {
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
            // dd($userRecords);
            $totalHrs = new Carbon();
            foreach ($rec as $userR) {
                if ($userR->logout_time_record > $userR->login_time_record) {
                    $login = Carbon::createFromTimestamp($userR->login_time_record);
                    $logout = Carbon::createFromTimestamp($userR->logout_time_record);
                    $worksecs = $login->diffInSeconds($logout);
                    $workmins = $login->diffInMinutes($logout);
                    $workhrs = $login->diffInHours($logout);

                    $wrkhrs[$userR->id] = CarbonInterval::seconds($worksecs)->cascade()->forHumans();
                    // dd($workmins);
                    $total[$userR->id] = $workmins;
                } else {
                    $settings = Setting::findorfail(1);
                    $login = Carbon::createFromTimestamp($userR->login_time_record);
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

            return view('Users.single',
                ['user' => $userRecords,
                    'records' => $rec,
                    'wkhrs' => $wrkhrs,
                    'months' => $sorting,
                    'totalhrs' => $totalHrs,
                    'currMonth' => $month]);
        } else {
            return view('Users.single', ['user' => $userRecords,
                'records' => $rec,
                'months' => $sorting,
                'currMonth' => $month]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('Users.edit', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        $updated_user = $request->validated();
        dd($updated_user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_user = User::findorfail($request->user);
        // dd($delete_user);
        $this->authorize('delete', Auth::user());
        DB::table('logup')->where('user_logup','=', $request->user)->delete();
        DB::table('logout')->where('user_logup','=', $request->user)->delete();
        $delete_user->delete();

        $request->session()->flash('status', 'Employee was deleted!');

        return redirect()->back();
    }
}
