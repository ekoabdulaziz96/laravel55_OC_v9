<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use App\User;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
use App\http\Requests;
use Illuminate\Http\Request;

class UsersController extends Controller
{
	  public function index(){
	    // $post = User::paginate(4);
	    $post = User::orderBy('created_at', 'desc')->get();

	    return view('admin.user',compact('post'));
	  }

	  public function addAdminUser(Request $request){
	    $rules = array(
	      'nama' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'password' => 'required|string|min:6',
	      'status' => 'required',

	    );
	  $validator = Validator::make ( Input::select('email')->get(), $rules);
	  if ($validator->fails())
		  return Response::json(array('errors'=> $validator->getMessageBag()->toarray()));

	  else {
	    $post = new User;
	    $post->nama = $request->nama;
	    $post->email = $request->email;
	    $post->password =  bcrypt($request->password);
	    $post->status = $request->status;
	    $post->remember_token=$request->_token;
	    $post->save();
	    $posts = User::find($post->id);
	    return response()->json($posts);
	  }
	}

	public function editAdminUser(request $request){

		$post = User::find ($request->id);
		$post->nama = $request->nama;
	    $post->email = $request->email;
	    $post->password =  bcrypt($request->password);
	    $post->status = $request->status;
	    $post->avatar = $request->avatar;
	    $post->tgl_lahir = $request->tgl_lahir;
	    $post->alamat = $request->alamat;
	    $post->no_HP = $request->no_hp;
	    $post->remember_token=$request->_token;
	    $post->save();
	    $posts = User::find($post->id);

	    return response()->json($posts);
	}

	public function deleteAdminUser(request $request){
		$post = User::find ($request->id)->delete();
		return response()->json();
	}
}
