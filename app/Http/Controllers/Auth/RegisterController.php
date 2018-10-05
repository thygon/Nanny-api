<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SignUpRequest as Request;
use Illuminate\Http\Request as Req;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Role;
use App\Myprofile;
use Carbon\carbon;
use Config;
use JWTAuth;
use JWTAuthException;

class RegisterController extends Controller
{
    
    public function __construct(){

    }

    public function userRegister(Request $request){

    	$dob = new Carbon($request->get('dob'));
    	$current = Carbon::now();
    	$age = $dob->diffInYears($current);

    	if($age >= 18){

    		$user = new User();
		    $user->email = $request->email;
		    $user->name = $request->name;
		    $user->password = bcrypt($request->password);
		    
		    $role = Role::findOrFail($request->role);
		    $user->save();
		    $user = User::findOrFail($user->id);
		    $user->role()->attach($role->id);

		    $profile = new Myprofile();
		    $profile->dob = $dob;
		    $profile->age = $age;
		    $profile->shortmsg = '';
		    $profile->level = '';
		    $profile->goodconduct = '';
		    $profile->address = '';
		    $profile->dpic = '';

		    $user->profile()->save($profile);
		    $token = JWTAuth::fromUser($user);
		    
		    return response()->json([
		    	'status' =>'success',
		    	'message' => ' Successfully registered',
		    	'data' => $user,
		    	'token'=>$token
		    ],200);

    	}else{

    		return response()->json([
		    	'status' =>'error',
		    	'message' => ' you are below 18yrs of Age!',
		    	'data' => $age,
		    ],200);


    	}
	    

    }

    public function profile(){
    	$profile = Myprofile::where('user_id',Auth::user()->id)->first();

    	return response()->json([
		    	'status' =>'success',
		    	'message' => 'Profile fetched',
		    	'data' => $profile,
		    	'role'=>Auth::guard('user')->user()->role()->pluck('role')
		    ],200);
    }

   public function updateProfile(Req $req){
         
         $profile = Myprofile::findOrFail($req->get('id'));
         $address = [
         	'postal'=> $req->get('postal'),
         	'city'=> $req->get('city'),
         	'code'=> $req->get('code'),
         ];
         
         $profile->address = serialize($address);
         $profile->dpic = $req->get('dpic');
         $profile->level = $req->get('level');
         $profile->shortmsg = $req->get('shortmsg');
         $profile->goodconduct = 'Some good conduct document!';
         $profile->amount = $req->amount;

         $profile->save();

         return response()->json([
		    	'status' =>'success',
		    	'message' => 'Profile Updated!',
		    ],200);

   }

}
