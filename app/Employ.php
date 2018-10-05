<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employ extends Model
{
    

    public function mama(){
    	return $this->belongsTo('App\User','employer_id');
    }

    public function nani(){
    	return $this->belongsTo('App\User','employee_id');
    }

    public function scopeIsValid($query){
    	return $query->where('status',1);
    }
}
