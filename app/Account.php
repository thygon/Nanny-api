<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    

    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function history(){
    	return $this->hasMany('App\History','account_id');
    }
}
