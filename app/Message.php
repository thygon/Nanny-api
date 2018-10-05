<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Text;
use Auth;

class Message extends Model
{
    

    protected $appends = ['latest','count','profile'];

    public function getLatestAttribute($value){
       $text = Text::where('message_id',$this->id)->latest()->first();
       return $text;
    }

    public function getCountAttribute($value){
       $count = Text::where('isRead',0)
                      ->where('user_id','!=',Auth::id())
                      ->where('message_id',$this->id)
                      ->count();
       return $count;
    }
    public function getProfileAttribute($value){
      $profile = User::where('id',$this->sender)->first()->profile()->first();
      return $profile->dpic;
    }

    
    public function userSender(){
        return $this->belongsTo('App\User','sender');
    }

    public function userReceiver(){
        return $this->belongsTo('App\User','receiver');
    }

    public function texts(){
    	return $this->hasMany('App\Text','message_id');
    }
}
