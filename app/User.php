<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Auth;
use App\Rate;

class User extends Authenticatable implements JWTSubject
{
    
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','isAvailable'
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $appends = [
        'pic','requested'
    ];


    //msg

    public function messageSender(){
        return $this->hasMany('App\Message','sender');
    }

    public function messageReceiver(){
        return $this->hasMany('App\Message','receiver');
    }

    //employ

    public function employee(){
        return $this->hasOne('App\Employ','employee_id');
    }

    public function employer(){
        return $this->hasOne('App\Employ','employer_id');
    }

    //profile

    public function profile(){
    	return $this->hasOne('App\Myprofile');
    }

    //ratings
    public function rate(){
    	return $this->hasMany('App\Rate','user_id');
    }

    //request
    public function request(){
    	return $this->hasMany('App\Friend');
    }

    public function friend(){
        return $this->hasmany('App\Friend','nani_id');
    }
    //roles
    public function role(){
    	return $this->belongsToMany('App\Role','user_roles');
    }

    //account
    public function account(){
    	return $this->hasOne('App\Account','user_id');
    }

    //jwt

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    //scopes
    public function scopeAvailable($query){        
        return $query->where('isAvailable',1);
    }

    public function scopeIsNani($query){
        return $query->whereHas('role',function($q){
                        $q->where('role','nany');
                     });
    }

    public function scopeIsMama($query){
        return $query->whereHas('role',function($q){
                        $q->where('role','mama');
                     });
    }

    public function scopeIsTopRatedNani($qry){
        return $qry->whereHas('rate',function($q){
                $q->where('stars',Rate::nani()->max('stars'));
        });
    }
    public function scopeIsTopRatedMama($qry){
        return $qry->whereHas('rate',function($q){
                $q->where('stars',Rate::mama()->max('stars'));
        });
    }


    public function getPicAttribute($value){
        $pic = $this->profile()->where('user_id',$this->id)->first()->dpic;
        return $pic;
    }

    public function getRequestedAttribute($value){
        $friend = $this->friend()->where('nani_id',$this->id)
                                 ->where('user_id',Auth::id())->count();
        return $friend == 1;
    }
}
