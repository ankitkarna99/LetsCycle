<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    public function users(){
        return $this->belongsToMany('App\User')->withTimestamps()->withPivot(['paid', 'billed', 'bill_amount', 'created_at', 'updated_at'])->wherePivot('paid', 0);
    }
}