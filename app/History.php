<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //

    public function account(){
    	return $this->belongsTo('App\Account','account_id');
    }

    public function getHistoryAttribute($value){
    	return unserialize($value);
    }
}
