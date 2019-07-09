<?php

namespace App\Http\Controllers;
use Validator;
use App\User;
use App\Cabang;
use Illuminate\Http\Request;
use Mockery\Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Events\Auth\UserActivationEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
 public function updateProfil(Request $request){
        $user = User::findOrFail($request->id_user_profil);
    if ($request->type == 'profil'){
              $input = $request->only(['nama','no_hp','foto']);
              $rules = array(
               'nama' => 'required|string',
               'no_hp' => 'required',
            );
             $validator = Validator::make( $input, $rules);
                if ($validator->fails()){
                      return response()->json([
                        'success' => true,
                        'message' => 'Silahkan lengkapi form yg wajib diisi',
                        'title'=> 'Mohon Diperhatikan!',
                        'type'=> 'warning',
                        'timer'=> 2500
                    ]);
                }else {
                    $input['foto'] = $user->foto;

                    if ($request->hasFile('foto')){
                        if ($user->foto != '-'){
                            unlink(public_path($user->foto));
                        }
                        $input['foto'] = '/upload/foto/'.$user->id.str_slug($input['nama'], '-').'.'.$request->foto->getClientOriginalExtension();
                        $request->foto->move(public_path('/upload/foto/'), $input['foto']);
                    }
                    $user->update($input);

                    return response()->json([
                        'success' => true,
                        'message' => 'Data Profil berhasil diperbarui',
                        'title'=> 'Sukses Memperbarui!',
                        'type'=> 'success',
                        'timer'=> 1000
                    ]);
            }
    }else if ($request->type == 'password'){
             $input = $request->only(['password_lama','password_baru','password_baru_ulangi']);
                $rules = array(
                   'password_lama' => 'required|string|min:6',
                   'password_baru' => 'required|string|min:6',
                   'password_baru_ulangi' => 'required|string|min:6',
                );
            $validator = Validator::make( $input, $rules);
            if ($validator->fails()){
                  return response()->json([
                    'success' => true,
                    'message' => 'Silahkan lengkapi form yg wajib diisi, dan pastikan password terisi minimal 6 karakter',
                    'title'=> 'Mohon Diperhatikan!',
                    'type'=> 'warning',
                    'timer'=> 2500
                ]);
            }else if(!Hash::check($request->password_lama, $user->password)){
               return response()->json([
                    'success' => true,
                    'message' => 'Password lama tidak cocok, silahkan ketik lagi',
                    'title'=> 'Mohon Diperhatikan!',
                    'type'=> 'warning',
                    'timer'=> 2500
                ]);
            } else if($request->password_baru != $request->password_baru_ulangi){
               return response()->json([
                    'success' => true,
                    'message' => 'input password pertama dan kedua tidak sama',
                    'title'=> 'Mohon Diperhatikan!',
                    'type'=> 'warning',
                    'timer'=> 2500
                ]);
            }else {
                $inputs['password'] = bcrypt($request->password_baru);
                $user->update($inputs);
                return response()->json([
                    'success' => true,
                    'message' => 'Password berhasil diperbarui',
                    'title'=> 'Sukses Memperbarui!',
                    'type'=> 'success',
                    'timer'=> 2500
                ]);
            }
    }else if ($request->type == 'email'){
             $input = $request->only(['email','password']);
                $rules = array(
                   'email' => 'required|string',
                   'password' => 'required|string|min:6',
                );
            $validator = Validator::make( $input, $rules);
            if ($validator->fails()){
                  return response()->json([
                    'success' => true,
                    'message' => 'Silahkan lengkapi form yg wajib diisi, dan pastikan password terisi minimal 6 karakter',
                    'title'=> 'Mohon Diperhatikan!',
                    'type'=> 'warning',
                    'timer'=> 2500
                ]);
            }else if(!Hash::check($request->password, $user->password)){
               return response()->json([
                    'success' => true,
                    'message' => 'Password tidak cocok, silahkan ketik lagi',
                    'title'=> 'Mohon Diperhatikan!',
                    'type'=> 'warning',
                    'timer'=> 2500
                ]);
            }else if(User::where('email',$request->email)->where('id','<>',$user->id)->exists() ){
               return response()->json([
                    'success' => true,
                    'message' => 'maaf, email user "'.$request->email.'" sudah ada. Silahkan input dengan email berbeda',
                    'title'=> 'Mohon Diperhatikan!',
                    'type'=> 'warning',
                    'timer'=> 5000
                ]);
            }else {
                $inputs['email'] = $request->email;
                $inputs['active'] = false;
                $inputs['activation_token'] = str_random(255);
                $user->update($inputs);
                event (new UserActivationEmail($user));
                return response()->json([
                    'success' => true,
                    'message' => 'Email berhasil diperbarui dan email aktivasi berhasil dikirim',
                    'title'=> 'Sukses Memperbarui Email!',
                    'type'=> 'success',
                    'timer'=> 2500
                ]);
            }
    }
    
}

}
