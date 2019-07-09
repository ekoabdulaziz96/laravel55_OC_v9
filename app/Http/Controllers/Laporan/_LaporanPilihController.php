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
        return $user;
    }
    public function laporanTerpilih(Request $request)
    // public function laporanTerpilih()
    {
        $user = User::findOrFail($request->nama);
        // $user = User::findOrFail(10);
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
 // // acc laporan----------------------------------------
      // view kelola Acc laporan
    public function laporanAcc($status)
    {
        // $user = User::findOrFail(2);
        $forms = Form::where('status',$status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_all = Form::where('status',$status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $status_laporan = $status;
        $laporan_status = 'acc_laporan';

         $ft_admin_direktur = FtAdmin::where('acc_direktur','proses')->count();
        $ft_admin_manajer = FtAdmin::where('acc_manajer','proses')->count();
        $ft_admin_ft_kacab = FtAdmin::where('acc_ft_kacab','proses')->count();        

        $ft_sponsorship_direktur = FtSponsorship::where('acc_direktur','proses')->count();
        $ft_sponsorship_manajer = FtSponsorship::where('acc_manajer','proses')->count();
        $ft_sponsorship_ft_kacab = FtSponsorship::where('acc_ft_kacab','proses')->count();        

        $ft_kacab_direktur = FtKacab::where('acc_direktur','proses')->count();
        $ft_kacab_manajer = FtKacab::where('acc_manajer','proses')->count();
        
        $manajer_direktur = Manajer::where('acc_direktur','proses')->count();

        
        return view('admin.laporanAcc',compact(['status_laporan','laporan_status','forms','form_all','status',
            'ft_admin_direktur','ft_admin_manajer','ft_admin_ft_kacab',
            'ft_sponsorship_direktur','ft_sponsorship_manajer','ft_sponsorship_ft_kacab',
            'ft_kacab_direktur','ft_kacab_manajer',
            'manajer_direktur',
        ]));
    } 
 //    //utk menuju ke view 
 //    public function laporanAccPilih()
 //    {
 //        $laporan_status = 'acc_laporan';
 //        $status = User::select('status')->where('status','<>','super_admin')->groupBy('status')->get();

 //        $ft_admin_direktur = FtAdmin::where('acc_direktur','proses')->count();
 //        $ft_admin_manajer = FtAdmin::where('acc_manajer','proses')->count();
 //        $ft_admin_ft_kacab = FtAdmin::where('acc_ft_kacab','proses')->count();        

 //        $ft_sponsorship_direktur = FtSponsorship::where('acc_direktur','proses')->count();
 //        $ft_sponsorship_manajer = FtSponsorship::where('acc_manajer','proses')->count();
 //        $ft_sponsorship_ft_kacab = FtSponsorship::where('acc_ft_kacab','proses')->count();        

 //        $ft_kacab_direktur = FtKacab::where('acc_direktur','proses')->count();
 //        $ft_kacab_manajer = FtKacab::where('acc_manajer','proses')->count();
        
 //        $manajer_direktur = Manajer::where('acc_direktur','proses')->count();

 //        return view('admin.laporanAccPilih',compact(['status','laporan_status',
 //            'ft_admin_direktur','ft_admin_manajer','ft_admin_ft_kacab',
 //            'ft_sponsorship_direktur','ft_sponsorship_manajer','ft_sponsorship_ft_kacab',
 //            'ft_kacab_direktur','ft_kacab_manajer',
 //            'manajer_direktur',
 //        ]));
 //    }
 //    //untuk form pilihan cabang 
 //    public function cabangAcc()
 //    {
 //        $cabang = User::select('cabang')->where('status','ft_admin')->orWhere('status','ft_sponsorship')->orWhere('status','ft_kacab')->groupBy('cabang')->get();
 //        if($cabang != null){
 //            $cabang['count'] = $cabang->count();
 //        }
 //        return $cabang;
 //    }
 //      //untuk form pilihan wilayah 
 //    public function wilayahAcc($cabang)
 //    {
 //         $wilayah = User::select('wilayah')->where('cabang',$cabang)->groupBy('wilayah')->get();
 //        if($wilayah != null){
 //            $wilayah['count'] = $wilayah->count();
 //        }
 //        return $wilayah;
 //    }
 //        public function laporanAccTerpilih(Request $request)
 //    // public function laporanTerpilih()
 //    {

 //        $form_all = Form::where('status',$user->status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
 //         $laporan_status = 'acc_laporan';
        
 //        return view('admin.laporanAcc',compact(['request','laporan_status','form_all']));
 //    }
}


