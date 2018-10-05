<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    
    public function index(){
    	$role = Role::all();
	    
	    return response()->json([
	    	'status' =>'success',
	    	'data' => $role,
	    ],200);
    }
}
