<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Text extends Model
{  

	protected $fillable = [ 'user_id','content','isRead','message_id'];

	protected $appends = ['selfText'];
    

    public function message(){
    	return $this->belongsTo('App\Message','message_id');
    }

    public function getSelfTextAttribute($value){
    	return $this->user_id ===  Auth::id() ;
    }
}
