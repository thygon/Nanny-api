<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Employ;
use App\History;
use App\Account;
use App\Notifications\EmploymentNotification;
use App\Payment as Pay;

class EmployController extends Controller
{
    
    public function employment(){
        $user = Auth::user();
        $role = $user->role()->first()->role;
        $employment = null;
        $confirm = null;

        if($role == 'mama' ){
           $employment = Employ::where('employer_id',$user->id)
                                 ->isValid()
                                 ->with('nani','mama')
                                 ->first();
        }else{
           $employment = Employ::where('employee_id',$user->id)
                                 ->isValid()
                                 ->with('nani','mama')
                                 ->first();
           $confirm = Employ::where('employee_id',$user->id)
                                 ->where('status',0)
                                 ->with('nani','mama')
                                 ->get();
        }
        return response()->json([
            'status' =>'success',
            'data' => $employment,
            'confirm'=> $confirm
        ],200);
    }


    public function employ($nani_id){
    	$mama_id = Auth::user()->id;
    	$nani_id = User::findOrFail($nani_id)->id;

        $employ = Employ::where('employee_id',$nani_id)->where('status',1)->count();

        if($employ < 1){
        //rejected 2
        $employ = Employ::where('employee_id',$nani_id)->where('status',2)->first();

        if($employ != null ){
            $employ = Employ::find($employ->id);
            $employ->status = 0;
            $employ->save();
        }else{

            //request not confirmed
            $employ = Employ::where('employee_id',$nani_id)->where('status',0)->first();
            if($employ != null){
                $employ = Employ::find($employ->id);
                $employ->status = 0;
                $employ->save();

            }else{

                $employ = new Employ();
                $employ->employer_id = $mama_id;
                $employ->employee_id = $nani_id;
                $employ->save();
           }
        }

    	$nani = User::find($nani_id);
    	$mama = User::find($mama_id);

        $nani->notify(new EmploymentNotification($mama,$nani));
        
       

    	return response()->json([
	    	'status' =>'success',
	    	'message'=>'Request sent',
	    	'data' => $employ,
	    ],200);

        }else{

            return response()->json([
            'status' =>'fail',
            'message'=>'Already employed!',
            'data' => $employ,
        ],200);
            
        }


    }

     function isEmployed(){
            $user = Auth::guard('user')->user();
            $status = $user->isAvailable;
            return response()->json([
            'status' =>'success',
            'message'=>'fetched',
            'isemployed' => $status
        ],200);
            
     }

    public function fire($nani_id){
    	$mama_id = Auth::user()->id;
    	$employment = Employ::where('employee_id',$nani_id)
    	                   ->where('employer_id',$mama_id)
    	                   ->first();

    	if(!empty($employment)){
    		
    		$employment->delete();

    		$nani = User::findOrFail($nani_id);
    		$nani->isAvailable = true;
    		$nani->save();
    		$mama = User::findOrFail($mama_id);
    		$mama->isAvailable = true;
    		$mama->save();
    	}

    	return response()->json([
	    	'status' =>'success',
	    	'message'=>'Successful!',
	    	'data' => $employ,
	    ],200);

    }
}
