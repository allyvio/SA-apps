<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    protected $guarded = [];
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id','events_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'users_id');
    }
}
