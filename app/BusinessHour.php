<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    protected $fillable = ['business_id', 
    'sat_open_time', 'sat_close_time', 'is_sat_holi', 
    'sun_open_time', 'sun_close_time', 'is_sun_holi', 
    'mon_open_time', 'mon_close_time', 'is_mon_holi', 
    'tue_open_time', 'tue_close_time', 'is_tue_holi', 
    'wed_open_time', 'wed_close_time', 'is_wed_holi', 
    'thu_open_time', 'thu_close_time', 'is_thu_holi', 
    'fri_open_time', 'fri_close_time', 'is_fri_holi'];
}
