<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    //user

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function nani(){
    	return $this->belongsTo('App\User','nani_id');
    }
}
