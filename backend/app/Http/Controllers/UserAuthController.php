<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Hash;
use Str;

class UserAuthController extends Controller
{
    public function login(Request $request){
    	// dd($request->all());
    	$this->validate($request, [
    		'email' => 'required',
    		'password' => 'required'
        ]);

        $user = Users::where('email', $request->email)->first();
        if (empty($user)) {
        	return response()->json(['code' => '0', 'message' => 'Email is not matched!'], 401);
        } else {
        	if(Hash::check($request->password, $user->password)) {
	        	$token = strtotime(date('Y-m-d')).Str::random(20);
	        	$user->token = $token;
	        	$user->save();
	        	
	        	return response()->json(['code' => '1', 'message' => 'Login Successfully!', 'data' => ['token' => $token] ], 200);
	        } else {
        		return response()->json(['code' => '0', 'message' => 'Password is not matched!'], 401);
	        }
        }
    }

    public function logout(Request $request) {
    	$user = Users::where('token', $request->token)->first();
    	if (!empty($user)) {
    		$user->token = '';
    		$user->save();
    	} 
        
        return response()->json(['code' => '1', 'message' => 'Logout Successfully!'], 200);
    }
}
