<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;

use App\FtAdmin;
use App\FtSponsorship;
use App\FtKacab;
use App\Manajer;
use App\Direktur;

use App\User;
use App\Cabang;
use App\Form;
use Validator;
use Mockery\Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use PDF;
use App\Http\Controllers\Controller;

class LaporanCRUDController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
    $users = User::findOrFail($request->id_user);
    $cabang = $users->cabang()->first();
    $input = $request->except(['id','id_user','hour','minute']);  
    $forms = Form::where('status',$users->status)->where('view','show')->get();
    foreach ($forms as $form) {
        if(substr($form->nama,0,10) != 'keterangan'){
            $rules[$form->slug] = 'required';
        }
    }
   if ($request->kehadiran == null){
     return response()->json([
                'success' => true,
                'message' => 'Silahkan lengkapi form yg wajib diisi',
                'title'=> 'Mohon Diperhatikan!',
                'type'=> 'warning',
                'timer'=> 2500
            ]);
   }else          
   if ($request->kehadiran == "hadir"){
        $validator = Validator::make( $input, $rules);
        if ($validator->fails()){
              return response()->json([
                'success' => true,
                'message' => 'Silahkan lengkapi form yg wajib diisi',
                'title'=> 'Mohon Diperhatikan!',
                'type'=> 'warning',
                'timer'=> 2500
            ]);
        }else{
            foreach ($forms as $form) {
                $nama = $form->slug;
                if($form->tipe=='checkbox'){
                    $input[$nama] = implode(", ",$request->$nama);  
                    // dd($request->$nama);    
                }
                if($form->tipe=='file'){
                    if ($request->hasFile($nama)){
                         $input[$nama] = '/upload/'.$users->status.'/'.str_slug($users->nama, '-').'_'.$users->id.'/'.str_slug($users->nama, '-').'_'.$cabang->nama.'_'.$users->wilayah.'_'.str_slug($users->status, '-').'_'.str_slug(Carbon::now(), '-').'_'.str_random(3).'.'.$request->$nama->getClientOriginalExtension();
                        $request->$nama->move(public_path('/upload/'.$users->status.'/'.str_slug($users->nama, '-').'_'.$users->id.'/'), $input[$nama]);
                    }
                }
            }
        }
    }
    if ($users->status == 'direktur'){
        $statusUser = Direktur::where('user_id',$users->id)->orderBy('created_at','desc')->first();
    }else if ($users->status == 'manajer'){
        $statusUser = Manajer::where('user_id',$users->id)->orderBy('created_at','desc')->first();         
    }else if ($users->status == 'ft_kacab'){
        $statusUser = FtKacab::where('user_id',$users->id)->orderBy('created_at','desc')->first();
    }else if ($users->status == 'ft_sponsorship'){
        $statusUser = FtSponsorship::where('user_id',$users->id)->orderBy('created_at','desc')->first();
    }else if ($users->status == 'ft_admin'){
        $statusUser = FtAdmin::where('user_id',$users->id)->orderBy('created_at','desc')->first();
    }
        if($statusUser == null){
            if($users->created_at->isSunday()){
               $input['created_at'] = $users->created_at->startOfDay()->addDay();
               $input['expired_at'] = $users->created_at->endOfDay()->addDays(8);
            }else{
               $input['created_at'] = $users->created_at->startOfDay();
               $input['expired_at'] = $users->created_at->endOfDay()->addDays(7);
            }
        }else if($statusUser->created_at->addDay()->isSunday()){
             $input['created_at'] = $statusUser->created_at->startOfDay()->addDays(2);
             $input['expired_at'] = $statusUser->created_at->endOfDay()->addDays(9);
        }else{
             $input['created_at'] = $statusUser->created_at->startOfDay()->addDay();
             $input['expired_at'] = $statusUser->created_at->endOfDay()->addDays(8);
        }

        $input['status_laporan'] = "baru";

    if ($users->status == 'direktur'){
        $users->direktur()->create($input);
    }else if ($users->status == 'manajer'){
        $users->manajer()->create($input);
    }else if ($users->status == 'ft_kacab'){
        $users->ftKacab()->create($input);
    }else if ($users->status == 'ft_sponsorship'){
        $users->ftSponsorship()->create($input);
    }else if ($users->status == 'ft_admin'){
        $users->ftAdmin()->create($input);
    }            
        return response()->json([
            'success' => true,
            'message' => 'Data Laporan baru berhasil ditambahkan',
            'title'=> 'Sukses Menambahkan!',
            'type'=> 'success',
            'timer'=> 2500
        ]);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\FtAdmin  $ftAdmin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FtAdmin  $ftAdmin
     * @return \Illuminate\Http\Response
     */
    public function editLaporan($user_id,$id)
    {
        $users = User::findOrFail($user_id);

        if ($users->status == 'direktur'){
          $laporan = Direktur::findOrFail($id);
        }else if ($users->status == 'manajer'){
          $laporan = Manajer::findOrFail($id);
        }else if ($users->status == 'ft_kacab'){
          $laporan = FtKacab::findOrFail($id);
        }else if ($users->status == 'ft_sponsorship'){
          $laporan = FtSponsorship::findOrFail($id);
        }else if ($users->status == 'ft_admin'){
          $laporan = FtAdmin::findOrFail($id);
        }
        $forms = Form::where('status',$users->status)->where('tipe','checkbox')->get();
        foreach ($forms as $form) {
            $nama = $form->slug;
            if($laporan->$nama != null){
                $laporan[$nama] = explode(", ",$laporan->$nama);      
            }
        }
        return $laporan;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FtAdmin  $ftAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($request->id_user);
        $cabang = $user->cabang()->first();
         $input = $request->except(['id','id_user','hour','minute']);  
           $forms = Form::where('status',$user->status)->get();  

        if ($user->status == 'direktur'){
          $laporan = Direktur::findOrFail($id);
        }else if ($user->status == 'manajer'){
          $laporan = Manajer::findOrFail($id);
        }else if ($user->status == 'ft_kacab'){
          $laporan = FtKacab::findOrFail($id);
        }else if ($user->status == 'ft_sponsorship'){
          $laporan = FtSponsorship::findOrFail($id);
        }else if ($user->status == 'ft_admin'){
          $laporan = FtAdmin::findOrFail($id);
        }
 

       if ($request->kehadiran == null){
         return response()->json([
                    'success' => true,
                    'message' => 'Silahkan lengkapi form yg wajib diisi.',
                    'title'=> 'Mohon Diperhatikan!',
                    'type'=> 'warning',
                    'timer'=> 2500
                ]);

       }else  if ($request->kehadiran == "hadir" ){
          if ($laporan->kehadiran =='hadir') {
            foreach ($forms as $form) {
                $nama = $form->slug;
                if(substr($form->nama,0,10) != 'keterangan' && $laporan->$nama != null && $form->tipe != 'file' ){
                    $rules[$form->slug] = 'required';
                }
            }
          }else{
            $cek = false;
            foreach ($forms as $form) {
                $nama = $form->slug;
                if($laporan->$nama != null ){
                   $cek= true;
                }
            }
              if ($cek == false){
                foreach ($forms as $form) {
                    if(substr($form->nama,0,10) != 'keterangan' && $form->view =='show'){
                        $rules[$form->slug] = 'required';
                    }
                }
              }else {
                $rules['kehadiran'] = 'required';
              }
          }
            $validator = Validator::make( $input, $rules);
            if ($validator->fails()){
                  return response()->json([
                    'success' => true,
                    'message' => 'Silahkan lengkapi form yg wajib diisi ',
                    'title'=> 'Mohon Diperhatikan!',
                    'type'=> 'warning',
                    'timer'=> 2500
                ]);
            }else {
              foreach ($forms as $form) {
                  $nama = $form->slug;
                  if ($request->has([$nama])){
                      if($form->tipe=='checkbox'){
                          $input[$nama] = implode(", ",$request->$nama);      
                      }
                      if($form->tipe=='file'){
                          if ($request->hasFile($nama)){
                              $input[$nama] = '/upload/'.$user->status.'/'.str_slug($user->nama, '-').'_'.$user->id.'/'.str_slug($user->nama, '-').'_'.$cabang->nama.'_'.$user->wilayah.'_'.str_slug($user->status, '-').'_'.str_slug(Carbon::now(), '-').'_'.str_random(3).'.'.$request->$nama->getClientOriginalExtension();
                              $request->$nama->move(public_path('/upload/'.$user->status.'/'.str_slug($user->nama, '-').'_'.$user->id.'/'), $input[$nama]);
                          }
                      }
                  }
              }
            }
        }
            

            $laporan->update($input);
            return response()->json([
                'success' => true,
                'message' => 'Data Laporan berhasil diperbarui',
                'title'=> 'Sukses Memperbarui!',
                'type'=> 'success',
                'timer'=> 2500
            ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FtAdmin  $ftAdmin
     * @return \Illuminate\Http\Response
     */
    public function deleteLaporan($user_id,$id)
    {
        $users = User::findOrFail($user_id);

        if ($users->status == 'direktur'){
          $laporan = Direktur::findOrFail($id);
        }else if ($users->status == 'manajer'){
          $laporan = Manajer::findOrFail($id);
        }else if ($users->status == 'ft_kacab'){
          $laporan = FtKacab::findOrFail($id);
        }else if ($users->status == 'ft_sponsorship'){
          $laporan = FtSponsorship::findOrFail($id);
        }else if ($users->status == 'ft_admin'){
          $laporan = FtAdmin::findOrFail($id);
        }

        $forms = Form::where('status',$users->status)->get();
            foreach ($forms as $form) {
                $nama = $form->slug;
                if($form->tipe=='file'){
                    if ($laporan->$nama != null){
                        unlink(public_path($laporan->$nama));
                    }
                }
            }
        $laporan->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Laporan berhasil dihapus',
            'title'=> 'Sukses Menghapus!',
            'type'=> 'success',
            'timer'=> 2500
        ]);
    }   
   
   // end class 
}


