<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

            $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
            return response()->json($data);
        }
        
        return view('home');
    }

    public function countEvents()
    {
        if (request()->ajax()) {
            // $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            // $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
            $now = new Carbon();
            $thisMonth = Carbon::create($now->year, $now->month, 1, 0, 0, 0);
            $endMonth = Carbon::create($now->year, $now->month, $now->daysInMonth, 0, 0, 0);
            
            $counter = Event::where('start', '>=', $thisMonth->toDateTimeString())->where('end', '<=', $endMonth->toDateTimeString())->count();
            return response()->json($counter);
        }
    }


    public function populateCalendar()
    {
        if (request()->ajax()) {
            $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

            $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
            return response()->json($data);
        }
        return view('home');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createEvent(Request $request)
    {
        $insertArr = ['title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
        ];
        $event = Event::insert($insertArr);
        // dd($event);
        return response()->json($event);
    }

    public function updateEvent(Request $request)
    {   
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Event::where($where)->update($updateArr);
 
        return response()->json($event);
    } 

    public function deleteEvent(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();
   
        return response()->json($event);
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
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
