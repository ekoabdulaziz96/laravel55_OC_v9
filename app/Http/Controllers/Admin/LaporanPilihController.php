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

class LaporanPilihController extends Controller
{ 

 // pantau detail----------------------------------------

     //utk menuju ke view 
    public function laporanPilih()
    {
        $laporan_status = 'pantau_individual';
        $status = User::select('status')->where('status','<>','super_admin')->where('status','<>','direktur')->groupBy('status')->get();
        return view('admin.laporanPilih',compact(['status','laporan_status']));
    }
     //untuk form pilihan cabang 
    public function cabang($status)
    {
        $cabang = User::select('cabang')->where('status',$status)->groupBy('cabang')->get();
        if($cabang != null){
            $cabang['count'] = $cabang->count();
        }
        return $cabang;
    }
     //untuk form pilihan wilayah 
    public function wilayah($status,$cabang)
    {
         $wilayah = User::select('wilayah')->where('status',$status)->where('cabang',$cabang)->groupBy('wilayah')->get();
        if($wilayah != null){
            $wilayah['count'] = $wilayah->count();
        }
        return $wilayah;
    }
     //untuk form pilihan nama 
    public function nama($status)
    {
        $nama = User::select('id as id_user', 'nama')->where('status',$status)->get();
        if($nama != null){
            $nama['count'] = $nama->count();
        }
        return $nama;
    }      
    //untuk form pilihan nama 
    public function namas($status,$cabang,$wilayah)
    {
        $nama = User::select('id as id_user', 'nama')->where('status',$status)->where('cabang',$cabang)->where('wilayah',$wilayah)->get();
        if($nama != null){
            $nama['count'] = $nama->count();
        }
        return $nama;
    } 
    //return data user 
    public function user($id)
    {
        $user = User::findOrFail($id);
        $cabang = $user->cabang()->first();
        $user['cabang'] = $cabang->nama;
        return $user;
    }
    public function laporanTerpilih(Request $request)
    // public function laporanTerpilih()
    {
        $user = User::findOrFail($request->nama);
        return redirect()->route('admin.laporan-terpilih-user',$request->nama);
    }    

    public function laporanTerpilihUser($user_id)
    // public function laporanTerpilih()
    {
        $user = User::findOrFail($user_id);
        // $user = User::findOrFail(10);
       if ($user->status == 'direktur'){
          $laporan = Direktur::where('user_id',$user->id)->get();
            $laporan_baru = Direktur::where('user_id',$user->id)->where('status_laporan','baru')->count();
            $laporan_proses = Direktur::where('user_id',$user->id)->where('status_laporan','proses')->count();
            $laporan_perbaikan = Direktur::where('user_id',$user->id)->where('status_laporan','perbaikan')->count();
            $laporan_disetujui = Direktur::where('user_id',$user->id)->where('status_laporan','disetujui')->count();
            $laporan_kedaluwarsa = Direktur::where('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','baru')->orWhere('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','perbaikan')->count();
        }else if ($user->status == 'manajer'){
          $laporan = Manajer::where('user_id',$user->id)->get();
            $laporan_baru = Manajer::where('user_id',$user->id)->where('status_laporan','baru')->count();
            $laporan_proses = Manajer::where('user_id',$user->id)->where('status_laporan','proses')->count();
            $laporan_perbaikan = Manajer::where('user_id',$user->id)->where('status_laporan','perbaikan')->count();
            $laporan_disetujui = Manajer::where('user_id',$user->id)->where('status_laporan','disetujui')->count();
            $laporan_kedaluwarsa = Manajer::where('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','baru')->orWhere('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','perbaikan')->count();
        }else if ($user->status == 'ft_kacab'){
          $laporan = FtKacab::where('user_id',$user->id)->get();
            $laporan_baru = FtKacab::where('user_id',$user->id)->where('status_laporan','baru')->count();
            $laporan_proses = FtKacab::where('user_id',$user->id)->where('status_laporan','proses')->count();
            $laporan_perbaikan = FtKacab::where('user_id',$user->id)->where('status_laporan','perbaikan')->count();
            $laporan_disetujui = FtKacab::where('user_id',$user->id)->where('status_laporan','disetujui')->count();
            $laporan_kedaluwarsa = FtKacab::where('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','baru')->orWhere('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','perbaikan')->count();
        }else if ($user->status == 'ft_sponsorship'){
          $laporan = FtSponsorship::where('user_id',$user->id)->get();
            $laporan_baru = FtSponsorship::where('user_id',$user->id)->where('status_laporan','baru')->count();
            $laporan_proses = FtSponsorship::where('user_id',$user->id)->where('status_laporan','proses')->count();
            $laporan_perbaikan = FtSponsorship::where('user_id',$user->id)->where('status_laporan','perbaikan')->count();
            $laporan_disetujui = FtSponsorship::where('user_id',$user->id)->where('status_laporan','disetujui')->count();
            $laporan_kedaluwarsa = FtSponsorship::where('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','baru')->orWhere('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','perbaikan')->count();
        }else if ($user->status == 'ft_admin'){
          $laporan = FtAdmin::where('user_id',$user->id)->get();
            $laporan_baru = FtAdmin::where('user_id',$user->id)->where('status_laporan','baru')->count();
            $laporan_proses = FtAdmin::where('user_id',$user->id)->where('status_laporan','proses')->count();
            $laporan_perbaikan = FtAdmin::where('user_id',$user->id)->where('status_laporan','perbaikan')->count();
            $laporan_disetujui = FtAdmin::where('user_id',$user->id)->where('status_laporan','disetujui')->count();
            $laporan_kedaluwarsa = FtAdmin::where('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','baru')->orWhere('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','perbaikan')->count();
        }    
        $form_all = Form::where('status',$user->status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
         $laporan_status = 'pantau_individual';
        
        return view('admin.laporan',compact(['user','laporan','form_all','laporan_status','laporan_baru','laporan_proses','laporan_perbaikan','laporan_disetujui','laporan_kedaluwarsa']));
    }
 // // acc laporan----------------------------------------
      // view kelola Acc laporan
    public function laporanAcc($status)
    {
        // $user = User::findOrFail(2);
        $forms = Form::where('status',$status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_all = Form::where('status',$status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $laporan_status = 'acc_laporan';

        $ft_admin_direktur = FtAdmin::where('send_direktur',true)->count();
        $ft_admin_manajer = FtAdmin::where('send_manajer',true)->count();
        $ft_admin_ft_kacab = FtAdmin::where('send_ft_kacab',true)->count();        
            $ft_sponsorship_direktur = FtSponsorship::where('send_direktur',true)->count();
            $ft_sponsorship_manajer = FtSponsorship::where('send_manajer',true)->count();
            $ft_sponsorship_ft_kacab = FtSponsorship::where('send_ft_kacab',true)->count();
        $ft_kacab_direktur = FtKacab::where('send_direktur',true)->count();
        $ft_kacab_manajer = FtKacab::where('send_manajer',true)->count();
            $manajer_direktur = Manajer::where('send_direktur',true)->count();
        
        return view('admin.laporanAcc',compact(['laporan_status','forms','form_all','status',
            'ft_admin_direktur','ft_admin_manajer','ft_admin_ft_kacab',
            'ft_sponsorship_direktur','ft_sponsorship_manajer','ft_sponsorship_ft_kacab',
            'ft_kacab_direktur','ft_kacab_manajer',
            'manajer_direktur',
        ]));
    } 
 // // acc deadline laporan----------------------------------------
      // view kelola Acc laporan
    public function laporanAccDeadline($status)
    {
        // $user = User::findOrFail(2);
        $forms = Form::where('status',$status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_all = Form::where('status',$status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $laporan_status = 'dl_laporan';
        $cabang = Cabang::all();

        $ft_admin = FtAdmin::where('perpanjang_deadline',true)->count();
        $ft_sponsorship = FtSponsorship::where('perpanjang_deadline',true)->count();
        $ft_kacab = FtKacab::where('perpanjang_deadline',true)->count();
        $manajer = Manajer::where('perpanjang_deadline',true)->count();

        return view('admin.laporanAccDeadline',compact(['laporan_status','forms','form_all','status','cabang',
           'ft_admin','ft_sponsorship','ft_kacab','manajer'
        ]));
    }

// pantau detail karyawan----------------------------------------
     //utk menuju ke view 
    public function laporanPilihCabang()
    {
        $laporan_status = 'pantau_karyawan';
        $cabang = Cabang::where('nama','<>','-')->get();
        return view('admin.laporanPilihCabang',compact(['cabang','laporan_status']));
    } 
    //untuk form pilihan wilayah 
    public function getWilayah($cabang)
    {
         $wilayah = User::select('wilayah')->where('cabang_id',$cabang)->groupBy('wilayah')->get();
        if($wilayah != null){
            $wilayah['count'] = $wilayah->count();
        }
        return $wilayah;
    }

    // public function apiCabang($cabang,$wilayah){
    //     $user = User::where("cabang_id",$cabang)->where('wilayah',$wilayah)->get();
    //     return Datatables::of($user)
    //         ->addColumn('nomor', function(){
    //                 global $nomor;
    //                 return ++$nomor;
    //         }) 
    //        ->addColumn('action', function($user){
    //         return '<div align="center" >' .
    //            '<a onclick="detailKaryawan('. $user->id .')" style="background-color: #B1EDF6"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Reset Password: onecareindonesia"><i class="glyphicon glyphicon-erase"></i></a> ' . 
    //            '</div>';
    //         })
    //         ->rawColumns(['nomor', 'action'])->make(true);
    // }

    public function getUserCabang($cabang,$wilayah){
        $user = User::where("cabang_id",$cabang)->where("wilayah",$wilayah)->get();
        $user['count'] = $user->count();
 
        return $user;
    }    
    public function getUser($status){
        $user = User::where("status",$status)->get();
        $user['count'] = $user->count();
 
        return $user;
    }
}


