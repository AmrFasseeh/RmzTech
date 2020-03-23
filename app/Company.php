<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = ['id', 'name', 'api_url', 'phone', 'address', 'company_key'];


    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
}
