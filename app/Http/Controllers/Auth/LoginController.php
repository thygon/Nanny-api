<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Config;
use JWTAuth;
use JWTAuthException;
use App\User;
use Auth;

class LoginController extends Controller
{
  
   
    public function __construct()
    {
        $this->user = new User;
    }

    public function userLogin(Request $request){

        //login nani
        $this->validate( $request, [
            'email' =>'required',
            'password'=> 'required'
        ]);

        Config::set('jwt.user', 'App\User'); 
        Config::set('auth.providers.users.model', \App\User::class);

        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'invalid_email_or_password',
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'failed_to_create_token',
            ]);
        }
        return response()->json([
            'response' => 'success',
            'result' => [
                'token' => $token,
                'role'=> Auth::guard('user')->user()->role()->pluck('role'),
                'myrole'=>Auth::guard('user')->user()->role()->first(),
                'user'=>Auth::guard('user')->user(),
                'message' => 'Successful Login'
            ],
        ]);
    }

    public function resetPassword(Request $request){

        $this->validate( $request, [
            'email' =>'required:email'
        ]);

        $email = $request->email;
        $user = User::where('email',$email)->first();
        if($user != null){

            $password = 123456;
            $user->password = bcrypt($password);
            $user->save();

            return response([
                'status' => 'success',
                'message' => 'Successful, your password '.$password
            ], 200);

        }else{

            return response([
                'status' => 'failed',
                'message' => 'We cannot find you!'
            ], 200);

        }

    }

    public function user(){
        $id   = Auth::guard('api')->id();
        $user = $this->user::with('role','profile')->findOrFail($id);
        return response()->json(['user'=> $user],200);
    }

    public function myUser($id){
        $user = $this->user::with('role')->findOrFail($id);
        return response()->json(['user'=> $user],200);
    }

    public function logout(){
        //logout
        //Config::set('jwt.user', 'App\User'); 
        //Config::set('auth.providers.users.model', \App\Mama::class);
        
        JWTAuth::invalidate();
        return response([
                'status' => 'success',
                'message' => 'Logged out Successfully.'
            ], 200);
    }

    
}
