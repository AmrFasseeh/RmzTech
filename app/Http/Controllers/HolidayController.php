<?php

namespace App\Http\Controllers;

use App\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Response;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $now = new Carbon();
        if (request()->ajax()) {
            // $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            // $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
            $now = new Carbon();
            $this_year = Carbon::create($now->year, 1, 1, 0, 0, 0);
            
            $data = Holiday::where('start', '>=', $this_year->toDateTimeString())->get();
            return Response::json($data);
        }
        // $data = Holiday::where('id', '>=', 0)->get(['id','title','start', 'end', 'color']);
        // dd($data);
        // $data = Holiday::where('start', '>=', $now->today()->toDateTimeString())->get();
        // dd(Carbon::create($now->year, 1, 1, 0, 0, 0)->toDateTimeString());
        return view('settings.holidays');
    }

    public function getHolidays()
    {
        if (request()->ajax()) {
            // $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            // $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
            $now = new Carbon();
            $this_year = Carbon::create($now->year, 1, 1, 0, 0, 0);
            
            $data = Holiday::where('start', '>=', $this_year->toDateTimeString())->get();
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
        $insertArr = ['title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'color' => $request->color
        ];
        $event = Holiday::insert($insertArr);
        // dd($event);
        $done = 'done';
        // foreach ($request->holiday as $req) {
        //     $color = $req['title'];
        // }
        
        // dd($color);
        return Response::json($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        //
    }
}
