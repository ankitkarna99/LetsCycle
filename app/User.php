<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['email','password','name','phone_number','address'];
    protected $hidden = ['password'];

    public function cycles(){
        return $this->belongsToMany('App\Cycle')->withPivot(['paid', 'created_at', 'updated_at']);
    }

    public function unpaidCycles(){
        return $this->belongsToMany('App\Cycle')->withTimestamps()->withPivot(['paid','created_at','updated_at']);
    }
}
