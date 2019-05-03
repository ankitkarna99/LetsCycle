<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    public function users(){
        return $this->belongsToMany('App\User')->withTimestamps()->wherePivot('paid', 0);
    }
}