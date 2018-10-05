<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    

    public function user(){
    	return $this->belongsToMany('App\User')->using('App\UserRole');
    }

    public function scopeNany($query){
    	return $query->where('role','nany');
    }
}
