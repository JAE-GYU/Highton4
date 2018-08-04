<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventAttend extends Model
{
    //
    protected $fillable = ['event_id', 'user_id'];
}
