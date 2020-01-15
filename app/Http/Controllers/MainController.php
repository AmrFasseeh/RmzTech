<?php

namespace App\Http\Controllers;

use App\BusinessHour;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hours = BusinessHour::findorfail(1);
        if($hours->is_sat_holi == 1){
            $days['sat'] = 20;  
        } else {
            $days['sat'] = 6;
        }
        if($hours->is_sun_holi == 1){
            $days['sun'] = 20;  
        } else {
            $days['sun'] = 0;
        }
        if($hours->is_mon_holi == 1){
            $days['mon'] = 20;  
        } else {
            $days['mon'] = 1;
        }
        if($hours->is_tue_holi == 1){
            $days['tue'] = 20;  
        } else {
            $days['tue'] = 2;
        }
        if($hours->is_wed_holi == 1){
            $days['wed'] = 20;  
        } else {
            $days['wed'] = 3;
        }
        if($hours->is_thu_holi == 1){
            $days['thu'] = 20;  
        } else {
            $days['thu'] = 4; 
        }
        if($hours->is_fri_holi == 1){
            $days['fri'] = 20;  
        } else {
            $days['fri'] = 5;
        }
        return view('home', ['work' => $hours, 'days' => $days]);
    }
}
