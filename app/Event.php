<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = ['creator_id', 'title', 'description', 'location', 'hash_tag', 'event_date', 'event_pic', 'phone'];

    public function participant()
    {
        return $this->hasMany('App\EventAttend');
    }

    public function delete()
    {
        
        $this->participant()->delete();
        
        return parent::delete();
    }
}
