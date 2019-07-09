<?php

namespace App\Http\Controllers\FtSponsorship;

use Carbon\Carbon;
use App\FtSponsorship;
use App\User;
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
    public function laporanStatus($user_id,$status)
    {
        $user = User::findOrFail($user_id);
        $forms = Form::where('status',$user->status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_all = Form::where('status',$user->status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $status_laporan = $status;

        
        return view('ft-sponsorship.laporan',compact(['user','status_laporan','forms','form_all']));
    }         
   

    public function tanggal($user){
        //tgl
         $users = User::findOrFail($user);
        $FtSponsorship = FtSponsorship::where('user_id',$user)->orderBy('created_at','desc')->first();
        if($FtSponsorship == null){
            $created = $users->created_at;
            if($users->created_at->isSunday()){
              return $created->startOfDay()->addDay();
            }else{
              return $created->startOfDay();
            }
        }else if($FtSponsorship->created_at->addDay()->isSunday()){
            $created = $FtSponsorship->created_at->addDays(2);
             return $created->startOfDay();
        }else{
             $created = $FtSponsorship->created_at->addDay();
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
        $user = User::findOrFail($request->id_user);
        $cabang = $user->cabang()->first();
        $input = $request->except(['id','id_user','hour','minute']);  
        $forms = Form::where('status',$user->status)->where('view','show')->get();
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
                            $input[$nama] = '/upload/'.$user->status.'/'.str_slug($user->nama, '-').'_'.$user->id.'/'.str_slug($user->nama, '-').'_'.$cabang->nama.'_'.$user->wilayah.'_'.str_slug($user->status, '-').'_'.str_slug(Carbon::now(), '-').'_'.str_random(3).'.'.$request->$nama->getClientOriginalExtension();
                            $request->$nama->move(public_path('/upload/'.$user->status.'/'.str_slug($user->nama, '-').'_'.$user->id.'/'), $input[$nama]);
                        }
                    }
                }
            }
        }
                $FtSponsorship = FtSponsorship::where('user_id',$user->id)->orderBy('created_at','desc')->first();
                if($FtSponsorship == null){
                    if($user->created_at->isSunday()){
                       $input['created_at'] = $user->created_at->startOfDay()->addDay();
                       $input['expired_at'] = $user->created_at->endOfDay()->addDays(8);
                    }else{
                       $input['created_at'] = $user->created_at->startOfDay();
                       $input['expired_at'] = $user->created_at->endOfDay()->addDays(7);
                    }
                }else if($FtSponsorship->created_at->addDay()->isSunday()){
                     $input['created_at'] = $FtSponsorship->created_at->startOfDay()->addDays(2);
                     $input['expired_at'] = $FtSponsorship->created_at->endOfDay()->addDays(9);
                }else{
                     $input['created_at'] = $FtSponsorship->created_at->startOfDay()->addDay();
                     $input['expired_at'] = $FtSponsorship->created_at->endOfDay()->addDays(8);
                }

                $input['status_laporan'] = "baru";            
                $user->FtSponsorship()->create($input);

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
     * @param  \App\FtSponsorship  $FtSponsorship
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FtSponsorship  $FtSponsorship
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $laporan = FtSponsorship::findOrFail($id);
        $user = User::findOrFail($laporan->user_id);

        $forms = Form::where('status',$user->status)->where('tipe','checkbox')->get();
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
     * @param  \App\FtSponsorship  $FtSponsorship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $laporan = FtSponsorship::findOrFail($id);
        $user = User::findOrFail($request->id_user);
        $cabang = $user->cabang()->first();
        $input = $request->except(['id','id_user','hour','minute']);
        $forms = Form::where('status',$user->status)->get();


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
     * @param  \App\FtSponsorship  $FtSponsorship
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $laporan = FtSponsorship::findOrFail($id);
        $user = User::findOrFail($laporan->user_id);

        $forms = Form::where('status',$user->status)->get();
            foreach ($forms as $form) {
                $nama = $form->slug;
                if($form->tipe=='file'){
                    if ($laporan->$nama != null){
                        unlink(public_path($laporan->$nama));
                    }
                }
            }
        // FtSponsorship::destroy($id);
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
        $laporan =FtSponsorship::where('id',$id_laporan)->first();
       $form_pagi = Form::where('status',$user->status)->where('kategori','1_formula_pagi')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_inti = Form::where('status',$user->status)->where('kategori','2_formula_inti')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_sore = Form::where('status',$user->status)->where('kategori','3_formula_sore')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $pdf=PDF::loadView('export-pdf/_pdf',compact(['laporan','form_pagi','form_inti','form_sore','user']), [], ['format' => 'A4']);
        return $pdf->download('laporan_'.substr($laporan->created_at,0,10));
    }    

    public function cek($id_user,$id_laporan){
        $user = User::findOrFail($id_user);    
        $laporan =FtSponsorship::where('id',$id_laporan)->first();
        $form_pagi = Form::where('status',$user->status)->where('kategori','1_formula_pagi')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_inti = Form::where('status',$user->status)->where('kategori','2_formula_inti')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_sore = Form::where('status',$user->status)->where('kategori','3_formula_sore')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        return view('ft-admin/export/_pdf',compact(['laporan','form_pagi','form_inti','form_sore','user']));
    }

    public function deadlineLaporan($id)
    {
        $laporan = FtSponsorship::findOrFail($id);
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
    public function kirimLaporan($id)
    {
        $laporan = FtSponsorship::findOrFail($id);
        if($laporan->acc_ft_kacab != 'disetujui'){
            $input['status_laporan'] ='proses';
            $input['send_ft_kacab'] =1;
            $input['acc_ft_kacab'] ='proses';
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
            $input['send_manajer'] =1;
            $input['acc_manajer'] ='proses';

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
            $input['send_direktur'] =1;
            $input['acc_direktur'] ='proses';
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

        public function apiLaporan($user_id,$status_laporan)
    {
        if($status_laporan == 'kedaluwarsa'){
            $laporan = FtSponsorship::where('user_id',$user_id)->where('expired_at','<=',Carbon::now())->Where('status_laporan','baru')->orWhere('status_laporan','perbaikan')->get();
        }else{
            $laporan = FtSponsorship::where('user_id',$user_id)->where('status_laporan',$status_laporan)->get();
        }

        return Datatables::of($laporan)
            ->addColumn('nomor', function(){
                    global $nomor;
                    return ++$nomor;
            })->addColumn('created', function($laporan){
                if ($laporan->status_laporan == 'disetujui'){
                    return '<span >'.
                            '<a onclick="exportPdfLaporan('.$laporan->id.')" class="btn btn-default btn-sm" style="background-color:#6C85EF;color:white;width:25%" data-toggle="tooltip" data-placement="top" title="cetak laporan"><i class="glyphicon glyphicon-print "></i></a> ' .      
                           '</span>&nbsp;&nbsp'.substr($laporan->created_at,0,10);
                }else {
                      return  '<span >'.
                            '<a href="#" class="btn btn-default btn-sm" style="width:25%" data-toggle="tooltip" data-placement="top" title="cetak laporan"><i class="glyphicon glyphicon-print "></i></a> ' .      
                           '</span>&nbsp;&nbsp'.substr($laporan->created_at,0,10);
                }
            })->addColumn('expired', function($laporan){
                  if($laporan->status_laporan =='baru' || $laporan->status_laporan =='perbaikan'){
                        if (Carbon::now()->lessThan($laporan->expired_at) ) {
                            return '<div align="center">'.
                            Carbon::now()->diffInDays($laporan->expired_at). 
                            ' hari</div>';
                        } else {
                             if($laporan->perpanjang_deadline == false){ 
                              return '<span >'.
                                '<a onclick="deadlineLaporan('.$laporan->id .')" class="btn btn-default btn-sm" style="background-color:#6C85EF;color:white;width:25%" data-toggle="tooltip" data-placement="top" title="minta perpanjangan deadline laporan"><i class="glyphicon glyphicon-time "></i></a> ' .      
                               '</span>&nbsp;&nbsp;kedaluwarsa';
                            }else{
                                return '<span >'.
                                '<a href="#" class="btn btn-default btn-sm" style="width:25%" data-toggle="tooltip" data-placement="top" title="perpanjangan deadline laporan dalam proses"><i class="glyphicon glyphicon-time "></i></a> ' .      
                               '</span>&nbsp;&nbsp;kedaluwarsa';
                            }
                        }
                    }else{
                        return '-';
                    }
                    
                    // return $laporan->expired_at->diffInDays( Carbon::now());
            })->addColumn('acc_laporan', function($laporan){
                    if($laporan->acc_ft_kacab == 'disetujui') {$btn_kacab = '#87DE8B';} 
                        else if($laporan->acc_ft_kacab == 'perbaikan') {$btn_kacab = '#E9C02F';} 
                            else {$btn_kacab = '#F97373';}
                    if($laporan->acc_manajer == 'disetujui') {$btn_manajer = '#87DE8B';}
                        else if($laporan->acc_manajer == 'perbaikan') {$btn_manajer = '#E9C02F';}
                            else {$btn_manajer = '#F97373';}
                    if($laporan->acc_direktur == 'disetujui') {$btn_direktur = '#87DE8B';}
                        else if($laporan->acc_direktur == 'perbaikan') {$btn_direktur = '#E9C02F';}
                            else {$btn_direktur = '#F97373';}
                    return '<div align="center" >' .
               '<a onclick="viewAccLaporan('.$laporan->id .',\'kacab\')" style="background-color: '.$btn_kacab.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Kepala Cabang"><i class="fa fa-user-o " style="color:white"></i></a> ' .               
               '<a onclick="viewAccLaporan('.$laporan->id .',\'manajer\')" style="background-color: '.$btn_manajer.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Manajer"><i class="fa fa-user-circle " style="color:white"></i></a> ' .                
               '<a onclick="viewAccLaporan('.$laporan->id .',\'direktur\')" style="background-color: '.$btn_direktur.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Direktur"><i class="fa fa-user-circle-o " style="color:white"></i></a> ' . 
               '</div>';
            })->addColumn('action', function($laporan){
                  if (Carbon::now()->lessThan($laporan->expired_at)) {
                        if ($laporan->status_laporan=='baru' ){
                            return '<div align="right" >'.
                            '<a onclick="showLaporan('.$laporan->id .')" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detail"><i class="glyphicon glyphicon-eye-open"></i></a> ' .
                           '<a onclick="editLaporan('.$laporan->id .')" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a> ' .
                           '<a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="glyphicon glyphicon-trash"></i></a>'.
                           '</div>';
                       }else if ($laporan->status_laporan=='perbaikan'){
                            return '<div align="right" >'.
                            '<a onclick="showLaporan('.$laporan->id .')" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detail"><i class="glyphicon glyphicon-eye-open"></i></a> ' .
                           '<a onclick="editLaporan('.$laporan->id .')" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a> ' .
                           '<a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="glyphicon glyphicon-trash"></i></a>'.
                           '</div>';
                        }else if ($laporan->status_laporan=='proses' || $laporan->status_laporan=='disetujui'){
                            return '<div align="right" >'.
                            '<a onclick="showLaporan('.$laporan->id .')" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detail"><i class="glyphicon glyphicon-eye-open"></i></a> ' .
                           '<a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a> ' .
                           '<a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="glyphicon glyphicon-trash"></i></a>'.
                           '</div>';
                       }
                }else {
                     return '<div align="right" >'.
                        '<a onclick="showLaporan('.$laporan->id .')" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detail"><i class="glyphicon glyphicon-eye-open"></i></a> ' .
                       '<a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a> ' .
                       '<a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="glyphicon glyphicon-trash"></i></a>'.
                       '</div>';    
                }


            })->addColumn('kirim', function($laporan){
                 if (Carbon::now()->lessThan($laporan->expired_at)) {
                        if ($laporan->status_laporan=='baru' || $laporan->status_laporan=='perbaikan'){
                            return '<div align="center" >'.
                            '<a onclick="kirimLaporan('.$laporan->id .')" class="btn btn-default btn-sm" style="background-color:#6C85EF;color:white;width:100%" data-toggle="tooltip" data-placement="top" title="kirim laporan">--<i class="glyphicon glyphicon-send "></i>--</a> ' .      
                           '</div>';
                       }else if ($laporan->status_laporan=='proses' || $laporan->status_laporan=='disetujui'){
                          return '<div align="center" >'.
                            '<a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" style="width:100%"  data-placement="top" title="kirim laporan">--<i class="glyphicon glyphicon-send"></i>--</a> ' .                      
                           '</div>';
                        }
                }else {
                 return '<div align="center" >'.
                    '<a href="#" style="width:100%" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="kirim laporan">--<i class="glyphicon glyphicon-send"></i>--</a> ' .                      
                   '</div>';
                }
               })
            ->rawColumns(['nomor', 'action','created','expired','acc_laporan','kirim'])->make(true);
    }
}


