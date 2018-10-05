<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use Auth;
use App\Account;
use App\History;
use App\Payment as Pay;
use App\Admin;
use App\Employ;
use App\User as Nani;
use App\User;
use App\Notifications\RequestReceived;
use App\Notifications\DistressCall;
use App\Notifications\NaniFired;
use App\Rate;

class MamaController extends Controller
{
    
    //list of close range nanis and available

    public function getNanis(){
        //use gprs to locate.

    	$nanis = Nani::where('id','!=', Auth::id())
                     ->available()
                     ->isNani()
                     ->with('role','rate','profile','friend')
                     ->get();
        

    	return response()->json([
    		'status'=>'success',
            'message' =>'List of Nanis',
    		'data' => $nanis ],200);
    }
  //getnani

    public function getNani($id){
        $nani = Nani::with('profile','rate')->where('id',$id)->first();

        return response()->json([
            'status'=>'success',
            'message' =>'Nani',
            'data' => $nani ],200);

    }

    //request nani

    public function requestNani(Request $request){
        $id = $request->get('id');
    	$nani = Nani::findOrFail($id);
    	$nani_id = $nani->id;
        //check if it is existing
        $friend = Friend::where('nani_id',$nani_id)
                        ->where('user_id',Auth::user()
                        ->id)->first(); 
        if(!empty($friend)){

            return response()->json([
            'status' => 'error',
            'message'=> 'Request not Sent.. already exist!'
            ],200);

        }else{

            $request = new Friend();
            $request->user_id = Auth::user()->id;
            $request->nani_id = $nani_id;

            $request->save();
            //notify nani
            $nani->notify(new RequestReceived($request,Auth::user()));

            return response()->json([
                'status' => 'success',
                'message'=> 'Request sent!'
            ],200);

        }
    	

    }

    public function abortRequest($id){

    	$request = Friend::findOrFail($id);
    	$request->delete();

    	return response()->json([
             'status' => 'success',
    		'message' => 'Request Aborted!'
         
    	 ],200);

    }

    public function getMyRequests(){
        $id = Auth::id();
    	$requests = Friend::where('user_id',$id)->with('nani')->get();

    	return response()->json([
    		'status' => 'success',
    		'data' => $requests->toArray(),
    	],200);
    }

   

    //account
    public function myAccount(){
        $acc = Account::where('user_id',Auth::id())->with('history')->first();
    	return response()->json([
    		     'status' => 'successful account',
    		     'data' => $acc
    	    ],200);
    }

    //detail

    public function details($id){

         $nani = Friend::with('nani')->findOrFail($id);

                return response()->json([
                  'status' =>'success',
                  'message'=>'Details',
                  'payed' =>true,
                  'data' => $nani,
        ]);

    }

    public function naniDetails($id){

        $user = Auth::user();
        $acc = $user->account()->first();

        if(empty($acc)){
            $account = new Account();
            $account->bal = 0;
            $user->account()->save($account);

            return response()->json([
              'status' =>'new',
              'data' => $account,
            ]);
        }else if(!empty($acc)){

            $bal = Account::where('id',$acc->id)->pluck('bal')->first();

            if($bal <= 499){
                $data = [ 'bal' => 500-$bal];

                return response()->json([
                  'status' =>'low',
                  'message'=>'Your balance is low!',
                  'data' => $data,
                ]);

            }else{
                $acc->bal = $acc->bal - 500;
                $acc->save();

                $pay = new Pay();
                $pay->amount = 500;
                $pay->save(); 

                //History
                $h = new History();
                $h->history = serialize($acc);
                $h->description = 'Payed Ksh. 500';
                $acc->history()->save($h);

                $nani = Friend::with('nani')->findOrFail($id);

                return response()->json([
                  'status' =>'success',
                  'message'=>'Details',
                  'payed' =>true,
                  'data' => $nani,
                ]);

            }

        }

    }
    public function fire(){
        $employ = Employ::where('employer_id',Auth::id())
                          ->where('status',true)->first();
        $employ->status = 3; 
        $employ->save(); 

        $nani = User::findOrFail($employ->employee_id);
        $nani->isAvailable = true;
        $nani->save();
        $mama = User::findOrFail($employ->employer_id);
        $mama->isAvailable = true;
        $mama->save();

        $nani->notify( new NaniFired());

        return response()->json([
                  'status' =>'success',
                  'message'=>'You just Fired your nanny!',
                ]);

    }

    public function rateNanny(Request $req){
        $this->validate( $req, [
            'clean' =>'required',
            'hardworking' =>'required',
            'respect'=> 'required',
            'cooking' =>'required',
        ]);

        $total = 0;
        $total = $total + $this->myGood($req->clean);
        $total = $total + $this->mybool($req->hardworking);
        $total = $total + $this->myGood($req->cooking);
        $total = $total + $this->mybool($req->respect);
        
        $stars = $total/5;

        $employ = Employ::where('employer_id',Auth::id())
                          ->where('status',true)->first();

        $employee = $employ->employee_id;
        $nani = Nani::findOrFail($employee);
        $rate = new Rate();

        $rates = $req->all();

        ///ratings
        $rate->stars = $stars;
        $rate->detail_rating = serialize($rates); 

        $nani->rate()->save($rate);

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

    public function deposit(){
        $user = Auth::user();
        $acc = $user->account()->first();
    }


}
