<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot

class UserRole extends Pivot
{
    
    protected $fillable =[
       'user_id','role_id',
    ];
}
