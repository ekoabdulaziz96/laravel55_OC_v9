<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
class ActivationController extends Controller
{
    public function activate(Request $request){
    	$user = User::where('email',$request->email)->where('activation_token',$request->token)->firstorfail();
    	$user->update([
    		'active'=> true,
    		'activation_token'=>null
    	]);
    	// Auth::loginUsingId($user->id);

    	return redirect()->route('login')->withSuccess('Account (email) anda sukses di aktivasi');
    }
}
