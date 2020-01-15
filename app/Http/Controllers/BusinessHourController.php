<?php

namespace App\Http\Controllers;

use App\BusinessHour;
use App\Http\Requests\StoreBusinessHour;
use Illuminate\Http\Request;

class BusinessHourController extends Controller
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
    public function calendarEvents()
    {
        if(request()->ajax()) 
        {
 
         $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
         $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
 
         $data = BusinessHour::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
         return Response::json($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $week_day = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'];
        $week = BusinessHour::findorfail(1);
        return view('settings.bushours', ['bushours' => $week, 'week_day' => $week_day]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusinessHour $request)
    {
        $validatedHours = $request->validated();
        // dd($validatedHours);
        $week_day = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'];
        $week = BusinessHour::findorfail(1);
        if (!$week) {
            $week = new BusinessHour();
            dd('hi');
        }

        foreach ($week_day as $day) {
            if ($validatedHours['is_' . $day . '_holi'] == 1) {
                $week->{$day . '_open_time'} = null;
                $week->{$day . '_close_time'} = null;
                $week->{'is_' . $day . '_holi'} = $validatedHours['is_' . $day . '_holi'];
            } else {
                $week->{$day . '_open_time'} = $validatedHours[$day . '_open_time'];
                $week->{$day . '_close_time'} = $validatedHours[$day . '_close_time'];
                $week->{'is_' . $day . '_holi'} = $validatedHours['is_' . $day . '_holi'];
            }
        }
        $week->business_id = 1;
        $week->save();

        $request->session()->flash('status', 'Business Hours was updated!');
        return view('settings.showbushours', ['bushours' => $week, 'week_day' => $week_day]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BusinessHour  $businessHour
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $week_day = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'];
        $week = BusinessHour::findorfail($id);
        // dd($week);

        return view('settings.showbushours', ['bushours' => $week, 'week_day' => $week_day]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusinessHour  $businessHour
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessHour $businessHour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BusinessHour  $businessHour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessHour $businessHour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusinessHour  $businessHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessHour $businessHour)
    {
        //
    }
}
