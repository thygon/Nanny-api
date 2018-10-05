<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Admin;
use App\User;
use App\Friend;
use App\Rate;
use App\Employ;
use App\Myprofile as profile;
use App\Notifications\RequestConfirmed;
use App\Notifications\DistressCall;
use App\Notifications\NaniQuit;
use App\Account;
use App\History;
use App\Payment as Pay;

class NaniController extends Controller
{
    
    public function getMamas(){

        $mamas = User::where('id','!=', Auth::id())
                     ->available()
                     ->isMama()
                     ->with('role','rate','profile','friend')
                     ->get();

        return response()->json([
            'status' => 'success',
            'data' => $mamas
        ],200);

    }

    //getAllrequests

    public function getRequests(){

    	$id = Auth::id();
        $requests = Friend::where('nani_id',$id)->with('user')->get();

        return response()->json([
            'status' => 'success',
            'data' => $requests->toArray()
        ],200);
    }
    

    public function confirmRequest($id){

    	$request = Friend::findOrFail($id);
    	//1= confirmed/agreed.
    	$request->confirmed = 2;

    	$request->save();

        //send notification
        User::findOrFail($request->user_id)
        ->notify(new RequestConfirmed(Auth::user(),$request));

    	return response()->json([
            'status' =>'success',
            'message' =>'Request Confirmed!',
            'data'=> $request,
    ],201);

    }

    function confirmEmployment($id){
        $emp = Employ::find($id);

        $mama_id = $emp->employer_id;



         //debit acc -1000
        $mama = User::find($mama_id);
        $acc = Account::where('user_id',$mama->id)->first();
        if($acc == null || $acc->bal < 1000){

            return response()->json([
                'status' =>'error',
                'message'=>'Employer Account is low on cash!',
            ],200);


        }else{
            $acc->bal = $acc->bal - 1000;
            $acc->save();
        }
        
        //pay
        $pay = new Pay();
        $pay->amount = 1000;
        $pay->save(); 
        //History
        $h = new History();
        $h->history = serialize($acc);
        $h->description = 'Payed Ksh. 1000';
        $acc->history()->save($h);

        $emp->status = 1;
        $emp->save();

        $nani = User::find($emp->employee_id);
        $nani->isAvailable = false;
        $nani->save();
        $mama = User::find($emp->employer_id);
        $mama->isAvailable = false;
        $mama->save();
        return response()->json([
            'status' =>'success',
            'message' =>'You are now employed!'
    ],201);

    }

     function rejectEmployment($id){
        $emp = Employ::find($id);
        $emp->status = 2;
        $emp->save();

        $nani = User::find($emp->nani_id);
        $nani->isAvailable = true;
        $nani->save();
        $mama = User::find($emp->user_id);
        $mama->isAvailable = true;
        $mama->save();

        return response()->json([
            'status' =>'success',
            'message' =>'Request rejected',
    ],201);

    }


    public function rejectRequest($id){

    	$request = Friend::findOrFail($id);
    	//2 = rejected.
    	$request->confirmed = 3;

    	$request->save();

    	return response()->json([
            'status' =>'success',
            'message' =>'Request rejected!',
            'data'=> $request,
    ],201);

    }
   
   //rate mama

    public function rateMama(Request $req){
        //login nani
        $this->validate( $req, [
            'respect' =>'required',
            'timely'=> 'required'
        ]);
        //worst 0,good 4,better 6, best 10
        //yes 10 ,no 0
        $respect = $req->get('respect');
        $timely = $req->get('timely');

        $total = 0;
        $total = $total + $this->myGood($timely);
        $total = $total + $this->mybool($respect);
        
        $stars = $total/5;

        $employ = Employ::where('employee_id',Auth::id())->where('status',true)->first();
        $employer = $employ->employer_id;
        $mama = User::findOrFail($employer);
        $rate = new Rate();

        $rates = [
            'respect' =>$respect,
            'timely' =>$timely,
            'more'=>$req->get('more')
        ];

        ///ratings
        $rate->stars = $stars;
        $rate->detail_rating = serialize($rates); 

        $mama->rate()->save($rate);

        return response()->json([
                  'status' =>'success',
                  'message'=>'Successful Rating, Thanks',
                ]);


    }

    public function mybool($bool){
        $total = 0; 
        switch ($bool) {
            case 1:
                $total = 10; 
                break;
            case 0:
                $total = 0; 
                break;
        }
        return $total;

    }

    public function myGood($good){
        $total= 0; 
        switch ($good) {
            case 'worst':
                $total = 0;
                break;
            case 'good':
                $total = 4;
                break;
            case 'better':
                $total = 6;
                break;
            case 'best':
                $total = 10;
                break;
        }

       return $total;
    }


    //profile

    public function getProfile(){

        $profile = Auth::user()->with('profile')->get();

        return response()->json([
            'status' => 'Profile Successful',
            'data' => $profile
        ],201);

    }

    //quit
    public function quit(){
        $employ = Employ::where('employee_id',Auth::id())
                          ->where('status',true)->first();
        $employ->status = 3;
        $employ->save(); 

        $nani = User::findOrFail($employ->employee_id);
        $nani->isAvailable = true;
        $nani->save();
        $mama = User::findOrFail($employ->employer_id);
        $mama->isAvailable = true;
        $mama->save();

        $mama->notify(new NaniQuit());

        return response()->json([
                  'status' =>'success',
                  'message'=>'You just quit your employment!',
                ]);
    }

    

}
