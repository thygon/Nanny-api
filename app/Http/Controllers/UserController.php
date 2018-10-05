<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Role;
use App\Admin;
use App\Notifications\DistressCall;
use App\Security;

class UserController extends Controller
{
    
    public function __construct(){
          $this->middleware('jwt.auth');
    }


    public function getUnreadNotifications(){

    	$notifications = Auth::user()->unreadNotifications;

    	return response()->json([
                'status' => 'success',
                'data'=> $notifications
            ],200);

    }
    public function countNotifications(){
        $count = Auth::user()->unreadNotifications()->count();
        return response()->json([
                'status' => 'success',
                'data'=> $count
            ],200);
    }

    public function getAllNofications(){

    	$notifications = Auth::user()->notifications; 

    	return response()->json([
                'status' => 'success',
                'data'=> $notifications
            ],200);


    }

    public function markAsRead($id){

    	$notifications = Auth::user()->unreadNotifications()->findOrFail($id); 
    	$notifications->markAsRead();

    	return response()->json([
                'status' => 'success',
                'msg'=> 'Read'
            ],200);

    }

    public function delete(){

    	$notifications = Auth::user()->unreadNotifications()->find($id); 
    	$notifications->delete();

    	return response()->json([
                'status' => 'success',
                'msg'=> 'Deleted'
            ],200);

    }

    public function sendDistressCall(Request $req){
        $location = $req->location;
        $user = Auth::user();
        $role = $user->role()->pluck('role')->first();
        $call = '';

        if ($role == 'mama') {
            $call = 'I am reporting about my Nanny!';
        }else{
            $call = 'I am reporting about my Employer!';
        }

            $notifyable = Admin::find(1);
            if($notifyable == null){
              echo "no admin";

            }else{
                $firms = Security::get()->pluck('id');
                $id = array_random($firms->toArray());

                $firm = Security::find($id);


                $notify = $notifyable->notify(new DistressCall($call,$user,$location,$firm));
                
        return response()->json([
        'status'=>'success',
        'message' => 'Call sent',
        ],200);
               

            }
            
    }



}
