<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Auth;

class LoginController extends Controller
{
    

    use AuthenticatesUsers;


    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');   
    }

    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){

    	$this->validate( $request, [
            'email' =>'required',
            'password'=> 'required'
        ]);

        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password],
        	$request->remember)){
            Session::flash('status','success');
            Session::flash('title','success');
            Session::flash('message','Logged in');
        	return $this->sendLoginResponse($request);

        }
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $req){

        $req->session()->regenerate();

        $user = Auth::guard('admin')->user();
        $user->online = true;
        $user->save();

        return $this->authenticated($req, Auth::guard('admin')->user())
                ?: redirect()->intended($this->redirectPath());

    }

    public function logout(Request $request){

        $user = Auth::guard('admin')->user();
        $user->online = false;
        $user->save();

    	Auth::guard('admin')->logout();

        $request->session()->invalidate();

        return redirect(route('admin.login'))->with([
            'status'=>'info',
            'message'=>'Logged Out'
        ]);
    }


}
