<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Myprofile extends Model
{
    

    protected $fillable = [
        'name', 'email', 'password','isAvailable','amount'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function getAddressAttribute($value){
    	return unserialize($value);
    }
}
