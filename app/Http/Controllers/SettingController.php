<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSetting;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
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
    public function store(StoreSetting $request)
    {
        $validatedSettings = $request->validated();
        $currentSetting = Setting::findorfail(1);
        $currentSetting->start_hr = $validatedSettings['start_hr'];
        $currentSetting->end_hr = $validatedSettings['end_hr'];
        $currentSetting->within_flex = $validatedSettings['within_flex'];
        $currentSetting->after_flex = $validatedSettings['after_flex'];

        $currentSetting->save();

        $request->session()->flash('status', 'Settings was updated!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $setting = Setting::findorfail($id);
        if (Setting::findorfail(1)) {
            return view('settings.attendance', ['settings' => $setting]);
        } else {
            $setting = Setting::create([
                'start_hr' => 7,
                'end_hr' => 10,
                'within_flex' => 8,
                'after_flex' => 6,
            ]);
            return view('settings.attendance', ['settings' => $setting]);
        }
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
