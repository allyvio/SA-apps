<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded =[];
    public function lead()
    {
        return $this->belongsToMany(User::class, 'leads', 'events_id', 'users_id');
    }
}
