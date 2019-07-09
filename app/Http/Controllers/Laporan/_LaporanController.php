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

class LaporanController extends Controller
{
                  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function laporanStatus($status)
    {
        $user = User::findOrFail(2);
        $forms = Form::where('status',$user->status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_all = Form::where('status',$user->status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $status_laporan = $status;

        
        return view('ft-admin.laporan',compact(['user','status_laporan','forms','form_all']));
    } 
    // public function laporanTerpilih(Request $request)
    public function laporanTerpilih()
    {
        // $user = User::findOrFail($request->nama);
        $user = User::findOrFail(6);
       if ($user->status == 'direktur'){
          $laporan = Direktur::where('user_id',$user->id)->get();
        }else if ($user->status == 'manajer'){
          $laporan = Manajer::where('user_id',$user->id)->get();
        }else if ($user->status == 'ft_kacab'){
          $laporan = FtKacab::where('user_id',$user->id)->get();
        }else if ($user->status == 'ft_sponsorship'){
          $laporan = FtSponsorship::where('user_id',$user->id)->get();
        }else if ($user->status == 'ft_admin'){
          $laporan = FtAdmin::where('user_id',$user->id)->get();
        }    
        $form_all = Form::where('status',$user->status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
         $laporan_status = 'pantau_individual';
        
        return view('admin.laporan',compact(['user','laporan','form_all','laporan_status']));
    }

 //auto tgl 
    public function tanggal($user){
        //tgl
        $users = User::findOrFail($user);
        if ($users->status == 'direktur'){
            $statusUser = Direktur::where('user_id',$user)->orderBy('created_at','desc')->first();
        }else if ($users->status == 'manajer'){
            $statusUser = Manajer::where('user_id',$user)->orderBy('created_at','desc')->first();         
        }else if ($users->status == 'ft_kacab'){
            $statusUser = FtKacab::where('user_id',$user)->orderBy('created_at','desc')->first();
        }else if ($users->status == 'ft_sponsorship'){
            $statusUser = FtSponsorship::where('user_id',$user)->orderBy('created_at','desc')->first();
        }else if ($users->status == 'ft_admin'){
            $statusUser = FtAdmin::where('user_id',$user)->orderBy('created_at','desc')->first();
        }
        if($statusUser == null){
            $created = $users->created_at;
             return $created->startOfDay();
        }else if($statusUser->created_at->addDay()->isSunday()){
            $created = $statusUser->created_at->addDays(2);
             return $created->startOfDay();
        }else{
             $created = $statusUser->created_at->addDay();
              return $created->startOfDay();
        }
       
    } 
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
                        $input[$nama] = '/upload/'.$users->status.'/'.str_slug($users->nama, '-').'_'.$users->id.'/'.str_slug(Carbon::now(), '-').'.'.$request->$nama->getClientOriginalExtension();
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
             $input['created_at'] = $users->created_at->startOfDay();
             $input['expired_at'] = $users->created_at->endOfDay()->addDays(7);
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
        $input = $request->except(['id','id_user','hour','minute']);  
        
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

       }else  if ($request->kehadiran == "hadir"){
            $user = User::findOrFail($request->id_user);
            $input = $request->except(['id','id_user','hour','minute']);  
            $forms = Form::where('status',$user->status)->get();
           
            foreach ($forms as $form) {
                $nama = $form->slug;
                if ($request->has([$nama])){
                    if($form->tipe=='checkbox'){
                        $input[$nama] = implode(", ",$request->$nama);      
                    }
                    if($form->tipe=='file'){
                        if ($request->hasFile($nama)){
                            $input[$nama] = '/upload/'.$user->status.'/'.str_slug($user->nama, '-').'_'.$user->id.'/'.str_slug(Carbon::now(), '-').'.'.$request->$nama->getClientOriginalExtension();
                            $request->$nama->move(public_path('/upload/'.$user->status.'/'.str_slug($user->nama, '-').'_'.$user->id.'/'), $input[$nama]);
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
    public function exportPdfLaporan($id_user,$id_laporan){
        $user = User::findOrFail($id_user);
       if ($user->status == 'direktur'){
          $laporan = Direktur::where('id',$id_laporan)->first();
        }else if ($user->status == 'manajer'){
          $laporan = Manajer::where('id',$id_laporan)->first();
        }else if ($user->status == 'ft_kacab'){
          $laporan = FtKacab::where('id',$id_laporan)->first();
        }else if ($user->status == 'ft_sponsorship'){
          $laporan = FtSponsorship::where('id',$id_laporan)->first();
        }else if ($user->status == 'ft_admin'){
          $laporan = FtAdmin::where('id',$id_laporan)->first();
        }    
       $form_pagi = Form::where('status',$user->status)->where('kategori','1_formula_pagi')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_inti = Form::where('status',$user->status)->where('kategori','2_formula_inti')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_sore = Form::where('status',$user->status)->where('kategori','3_formula_sore')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();

        $pdf=PDF::loadView('export-pdf/_pdf',compact(['laporan','form_pagi','form_inti','form_sore','user']), [], ['format' => 'A4']);
        return $pdf->download('laporan_'.substr($laporan->created_at,0,10));
    }    

    // public function cek($id_user,$id_laporan){
    //     $user = User::findOrFail($id_user);    
    //     $laporan =ftAdmin::where('id',$id_laporan)->first();
    //     $form_pagi = Form::where('status',$user->status)->where('kategori','1_formula_pagi')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
    //     $form_inti = Form::where('status',$user->status)->where('kategori','2_formula_inti')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
    //     $form_sore = Form::where('status',$user->status)->where('kategori','3_formula_sore')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
    //     return view('ft-admin/export/_pdf',compact(['laporan','form_pagi','form_inti','form_sore','user']));
    // }

    public function deadlineLaporan($id)
    {
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
        if($laporan->perpanjang_deadline == false){
             $input['perpanjang_deadline'] =true;
            $laporan->update($input); 
            
            return response()->json([
                'success' => true,
                'message' => 'Permintaan perpanjangan deadline laporan berhasil dikirim',
                'title'=> 'Sukses Mengirim!',
                'type'=> 'success',
                'timer'=> 2500
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Permintaan perpanjangan deadline laporan sudah dikirim',
                'title'=> 'Proses!',
                'type'=> 'warning',
                'timer'=> 2500
            ]);
        }

    }
    public function kirimLaporan($user_id,$id)
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
        if($laporan->acc_ft_kacab != 'disetujui'){
            $input['status_laporan'] ='proses';
            $input['acc_ft_kacab'] ='proses';
            $input['send_ft_kacab'] =1;
            $laporan->update($input);

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dikirim',
                'title'=> 'Sukses Mengirim!',
                'type'=> 'success',
                'timer'=> 2500
            ]);
        }else  if($laporan->acc_manajer != 'disetujui'){
            $input['status_laporan'] ='proses';
            $input['acc_manajer'] ='proses';
            $input['send_manajer'] =1;
            $laporan->update($input);

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dikirim',
                'title'=> 'Sukses Mengirim!',
                'type'=> 'success',
                'timer'=> 2500
            ]);
        }else  if($laporan->acc_direktur != 'disetujui'){
            $input['status_laporan'] ='proses';
            $input['acc_direktur'] ='proses';
            $input['send_direktur'] =1;
            $laporan->update($input);
            
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dikirim',
                'title'=> 'Sukses Mengirim!',
                'type'=> 'success',
                'timer'=> 2500
            ]);
        }
    }    
    public function persetujuanLaporan(request $request,$id)
    {
        // dd($user_id,$id);
        $users = User::findOrFail($request->id_user);
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
        if($request->persetujuan_dari == 'ft_kacab'){
            $input['status_laporan'] ='-';

            if ($request->status_acc_laporan == 'disetujui'){
                $input['status_laporan'] ='proses';
                $input['acc_ft_kacab'] ='disetujui';
                $input['send_ft_kacab'] =0;
                $input['komentar_ft_kacab'] ='-';

                $input['acc_manajer'] ='proses';
                $input['send_manajer'] =1;
            }else if ($request->status_acc_laporan == 'perbaikan'){
                $input['status_laporan'] ='perbaikan';
                $input['acc_ft_kacab'] ='perbaikan';
                $input['send_ft_kacab'] =0;
                $input['komentar_ft_kacab'] =$request->komentar;


            }
              if( $input['status_laporan'] =='-'){
                    return response()->json([
                        'success' => true,
                        'message' => 'update status persetujuan "baru" dan "proses" dilakuakan otomatis oleh sistem',
                        'title'=> 'Mohon Maaf!',
                        'type'=> 'warning',
                        'timer'=> 3000
                    ]);
                }else {
                    $laporan->update($input);
                    return response()->json([
                        'success' => true,
                        'message' => 'Persetujuan  Laporan berhasil diperbarui',
                        'title'=> 'Sukses Mengirim!',
                        'type'=> 'success',
                        'timer'=> 2500
                    ]);
                }
        } else if($request->persetujuan_dari == 'manajer'){
            $input['status_laporan'] ='-';

            if ($request->status_acc_laporan == 'disetujui'){
                $input['status_laporan'] ='proses';
                $input['acc_manajer'] ='disetujui';
                $input['send_manajer'] =0;
                $input['komentar_manajer'] ='-';

                $input['acc_direktur'] ='proses';
                $input['send_direktur'] =1;
            }else if ($request->status_acc_laporan == 'perbaikan'){
                $input['status_laporan'] ='perbaikan';
                $input['acc_manajer'] ='perbaikan';
                $input['send_manajer'] =0;
                $input['komentar_manajer'] =$request->komentar;
            }
                 if( $input['status_laporan'] =='-'){
                    return response()->json([
                        'success' => true,
                        'message' => 'update status persetujuan "baru" dan "proses" dilakuakan otomatis oleh sistem',
                        'title'=> 'Mohon Maaf!',
                        'type'=> 'warning',
                        'timer'=> 3000
                    ]);
                }else {
                    $laporan->update($input);
                    return response()->json([
                        'success' => true,
                        'message' => 'Persetujuan  Laporan berhasil diperbarui',
                        'title'=> 'Sukses Mengirim!',
                        'type'=> 'success',
                        'timer'=> 2500
                    ]);
                }
        } else if($request->persetujuan_dari == 'direktur'){
            $input['status_laporan'] ='-';
            if ($request->status_acc_laporan == 'disetujui'){
                $input['status_laporan'] ='disetujui';
                $input['acc_direktur'] ='disetujui';
                $input['send_direktur'] =0;
                $input['komentar_direktur'] ='-';

            }else if ($request->status_acc_laporan == 'perbaikan'){
                $input['status_laporan'] ='perbaikan';
                $input['acc_direktur'] ='perbaikan';
                $input['send_direktur'] =0;
                $input['komentar_direktur'] =$request->komentar;
            }
                if( $input['status_laporan'] =='-'){
                    return response()->json([
                        'success' => true,
                        'message' => 'update status persetujuan "baru" dan "proses" dilakuakan otomatis oleh sistem',
                        'title'=> 'Mohon Maaf!',
                        'type'=> 'warning',
                        'timer'=> 3000
                    ]);
                }else {
                    $laporan->update($input);
                    return response()->json([
                        'success' => true,
                        'message' => 'Persetujuan  Laporan berhasil diperbarui',
                        'title'=> 'Sukses Mengirim!',
                        'type'=> 'success',
                        'timer'=> 2500
                    ]);
                }

        } 
    }

   // end class 
}


