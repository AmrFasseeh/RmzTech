<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['start_hr', 'end_hr', 'within_flex', 'after_flex'];
}
