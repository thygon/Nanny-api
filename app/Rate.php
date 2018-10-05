<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    
    protected $fillable = [
       'stars','detail_rating','user_id'
    ];

    protected $hidden =[
       'user_id',
    ];

    //user

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function  scopeMama($q){
        return $q->whereHas('user',function($r){
                 $r->whereHas('role',function($t){
                    $t->where('role','mama');
                 });
        });
    }

     public function  scopeNani($q){
        return $q->whereHas('user',function($r){
                 $r->whereHas('role',function($t){
                    $t->where('role','nany');
                 });
        });
    }

    public function getDetailRatingAttribute($v){
        return unserialize($v);
    }
}
