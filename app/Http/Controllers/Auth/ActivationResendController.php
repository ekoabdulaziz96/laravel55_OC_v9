<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Events\Auth\UserActivationEmail;
class ActivationResendController extends Controller
{
    public function showResendForm(){
    	return view('auth.activate.resend');
    }    
    public function resend(Request $request){
    	$this->validateResend($request);
    	$user= User::where('email',$request->email)->first();
        if($user->active){
            return redirect()->route('login')->withWarning('account (email) anda sudah aktif');
        }
    	event (new UserActivationEmail($user));
    	return redirect()->route('login')->withSuccess('email aktivasi telah dikirim');
    	// return view('auth.activate.resend');
    }

    protected function validateResend(Request $request){
    	$this->validate($request,[
    		'email'=>'required|email|exists:users,email'
    	],[
    		'email.exists'=>'Email yang anda masukkan belum terdafdar.'
    	]);
    }
}
