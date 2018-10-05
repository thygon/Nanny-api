<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
	use Notifiable;
    
    protected $fillable = [
        'name','email','online','password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile(){
    	return $this->hasOne('App\AdminProfile');
    }
}
