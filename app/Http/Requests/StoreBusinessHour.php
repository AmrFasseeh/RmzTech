<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessHour extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
            'sat_open_time' => 'required_if:is_sat_holi,0',
            'sat_close_time' => 'required_if:is_sat_holi,0',
            'is_sat_holi' => 'required',

            'sun_open_time' => 'required_if:is_sun_holi,0',
            'sun_close_time' => 'required_if:is_sun_holi,0',
            'is_sun_holi' => 'required',

            'mon_open_time' => 'required_if:is_mon_holi,0',
            'mon_close_time' => 'required_if:is_mon_holi,0',
            'is_mon_holi' => 'required',

            'tue_open_time' => 'required_if:is_tue_holi,0',
            'tue_close_time' => 'required_if:is_tue_holi,0',
            'is_tue_holi' => 'required',

            'wed_open_time' => 'required_if:is_wed_holi,0',
            'wed_close_time' => 'required_if:is_wed_holi,0',
            'is_wed_holi' => 'required',

            'thu_open_time' => 'required_if:is_thu_holi,0',
            'thu_close_time' => 'required_if:is_thu_holi,0',
            'is_thu_holi' => 'required',

            'fri_open_time' => 'required_if:is_fri_holi,0',
            'fri_close_time' => 'required_if:is_fri_holi,0',
            'is_fri_holi' => 'required',
        ];
    }
}
