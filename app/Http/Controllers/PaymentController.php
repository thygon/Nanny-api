<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Account;
use App\History;

class PaymentController extends Controller
{
    

    public function makePayment(Request $req){
        $user = Auth::user();
    	$acc = Account::where('user_id',$user->id)->first();
        $req->validate([
            'amount'=>'required'
        ]);
        $total = $req->get('amount');

    	if($acc){

    		$acc->bal = $acc->bal + $this->getAmount($total);

    	}else{

    		$acc = new Account();
    		$acc->bal = $acc->bal +$this->getAmount($total);

    	}

    	//if successful eg via mpesa
    	$user->account()->save($acc);

    	//make payment history
        $acc = Account::findOrFail($acc->id);
        $history = new History();
        $history->history = serialize($acc); //unserialize
        $history->description = 'Deposited'; 
        $acc->history()->save($history);

        return response()->json([
        	'status' => 'success',
            'message'=> 'Successful Payment!', 
        	'data' => $acc
        ],200);


    }

    public function makeDeposit(Request $req){
        $user = Auth::user();
        $account = $user->account()->first();
        
        $req->validate([
            'amount'=>'required',
            't_id'=>'required'
        ]);
        $total = $req->get('amount');
        $amount =  $this->getAmount($total);

        if($account){

            $account->bal = $account->bal + $amount;
            $account->save();

            //history
            $history = new History();
            $history->history = serialize($account); //unserialize
            //deposited $amount
            $history->description = 'Deposited '.$amount;
            $account->history()->save($history);

        }else{
            $account = new Account();
            $account->bal = $amount;
            $user->account()->save($account);

            //history
            $history = new History();
            $history->history = serialize($account); //unserialize
            //deposited $amount
            $history->description = 'Deposited '.$amount;
            $account->history()->save($history);

        }

        return response()->json([
            'status' => 'success',
            'message'=> 'Deposited '.$amount, 
            'data' => $account
        ],200);
    }

    public function getAmount($total){
        $amount = $total;
        return $amount;
    }
}
