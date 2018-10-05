<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rate;
use App\User;
use App\Employ;
use Auth;

class DashboardController extends Controller
{
    
    public function __construct(){    	
    	$this->middleware('auth:admin');
    }

    public function index(){

    	$topnani = User::isTopRatedNani()->with('rate')->first();
    	$topmama = User::isTopRatedMama()->with('rate')->first();
        $connects = Employ::where('status',1)->count();
    	return view('dashboard',['bestnani'=>$topnani,
                                 'bestmama'=>$topmama,
                                 'connects'=>$connects,
                              ]);
    }


    public function notification($id){
      $notification = Auth::guard('admin')->user()->notifications()->find($id); 
      $this->readIt($notification);
      return view('notification',['notification'=> $notification]);
    }

    public function readIt($n){
      $n->markAsRead();
    }
}
