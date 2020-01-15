<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsRecord extends Model
{
    protected $table = 'us_record';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
