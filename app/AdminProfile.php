<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    
    protected $fillable = [
        'pic',
    ];

    public function admin(){
    	return $this->belongsTo('App\Admin');
    }
}
