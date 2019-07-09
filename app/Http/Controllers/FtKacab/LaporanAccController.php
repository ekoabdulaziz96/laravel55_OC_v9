<?php

namespace App\Http\Controllers\FtKacab;

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

class LaporanAccController extends Controller
{
// // acc laporan----------------------------------------
      // view kelola Acc laporan
    public function laporanAcc($user_id,$status)
    {
        $user = User::findOrFail($user_id);
        $forms = Form::where('status',$status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_all = Form::where('status',$status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $laporan_status = 'acc_laporan';

        $user_ft_admin = User::where('status','ft_admin')->where('cabang_id',$user->cabang_id)->where('wilayah',$user->wilayah)->get();
        $ft_admin_ft_kacab = 0;
        foreach ($user_ft_admin as $ft_admin) {
            $count = FtAdmin::where('send_ft_kacab',true)->where('user_id',$ft_admin->id)->count();
            $ft_admin_ft_kacab = $count + $ft_admin_ft_kacab;        
        }        
        $user_ft_sponsorship = User::where('status','ft_sponsorship')->where('cabang_id',$user->cabang_id)->where('wilayah',$user->wilayah)->get();
        $ft_sponsorship_ft_kacab = 0;
        foreach ($user_ft_sponsorship as $ft_sponsorship) {
            $count = FtSponsorship::where('send_ft_kacab',true)->where('user_id',$ft_sponsorship->id)->count();
            $ft_sponsorship_ft_kacab = $count + $ft_sponsorship_ft_kacab;        
        }

        return view('ft-kacab.laporanAcc',compact(['laporan_status','forms','form_all','status','user',
            'ft_admin_ft_kacab','ft_sponsorship_ft_kacab'
        ]));
    } 



   public function apiLaporan($user_id,$status)
  {
    $user = User::findOrFail($user_id);
    $user_ft_admin = User::where('status','ft_admin')->where('cabang_id',$user->cabang_id)->where('wilayah',$user->wilayah)->get();
      
    $user_ft_sponsorship = User::where('status','ft_sponsorship')->where('cabang_id',$user->cabang_id)->where('wilayah',$user->wilayah)->get();
       $laporans =[];
    if ($status == 'ft_sponsorship'){
      foreach ($user_ft_sponsorship as $ft_sponsorship) {
        $laporan_ft_sponsorship = FtSponsorship::where('send_ft_kacab',true)->where('user_id',$ft_sponsorship->id)->orderBy('created_at','asc')->get();
        $laporans = array_merge($laporans,$laporan_ft_sponsorship->toArray());
      }
    }else if ($status == 'ft_admin'){
      foreach ($user_ft_admin as $ft_admin) {
        $laporan_ft_admin = FtAdmin::where('send_ft_kacab',true)->where('user_id',$ft_admin->id)->orderBy('created_at','asc')->get();
        $laporans = array_merge($laporans,$laporan_ft_admin->toArray());

      }
    }
$laporan = json_decode(json_encode($laporans));

  return Datatables::of($laporan)
    ->addColumn('nomor', function(){
            global $nomor;
            return ++$nomor;
    })->addColumn('nama', function($laporan){
       $user = User::findOrFail($laporan->user_id);
            return '<span >'.
                    '<a onclick="viewProfil('.$laporan->user_id.')" class="btn btn-default btn-sm" style="background-color:#6C85EF;color:white;width:25%" data-toggle="tooltip" data-placement="top" title="view profil"><i class="fa fa-user-o"></i></a> ' .      
                   '</span>&nbsp;&nbsp'.$user->nama;
    })->addColumn('status', function($laporan){
       $user = User::findOrFail($laporan->user_id);
            return $user->status;
    })->addColumn('cabang', function($laporan){
       $user = User::findOrFail($laporan->user_id);
       $cabang = $user->cabang()->first();
            return $cabang->nama;
    })->addColumn('wilayah', function($laporan){
       $user = User::findOrFail($laporan->user_id);
            return $user->wilayah;
    })->addColumn('created', function($laporan){
            return substr($laporan->created_at,0,10);
    })->addColumn('acc', function($laporan){
        if ($laporan->send_ft_kacab == true) return 'acc_Kepala_Cabang';
        else if ($laporan->send_manajer == true) return 'acc_Manajer';
        else if ($laporan->send_direktur == true) return 'acc_Direktur';
            
            // return $laporan->expired_at->diffInDays( Carbon::now());
    })->addColumn('acc_laporan', function($laporan){
            $user = User::findOrFail($laporan->user_id);
            if($laporan->acc_ft_kacab == 'disetujui') {$btn_kacab = '#87DE8B';} 
                else if($laporan->acc_ft_kacab == 'perbaikan') {$btn_kacab = '#E9C02F';} 
                    else {$btn_kacab = '#F97373';}
            if($laporan->acc_manajer == 'disetujui') {$btn_manajer = '#87DE8B';}
                else if($laporan->acc_manajer == 'perbaikan') {$btn_manajer = '#E9C02F';}
                    else {$btn_manajer = '#F97373';}
            if($laporan->acc_direktur == 'disetujui') {$btn_direktur = '#87DE8B';}
                else if($laporan->acc_direktur == 'perbaikan') {$btn_direktur = '#E9C02F';}
                    else {$btn_direktur = '#F97373';}

            // if ($users->status == 'ft_admin' && $users->status == 'ft_sponsorship'){
                 return '<div align="center" >' .
               '<a onclick="viewAccLaporan('.$laporan->user_id.','.$laporan->id .',\'ft_kacab\')" style="background-color: '.$btn_kacab.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Kepala Cabang"><i class="fa fa-user-o " style="color:white"></i></a> ' .               
               '<a href="#" class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Manajer"><i class="fa fa-user-circle "></i></a> ' .                
               '<a href="#" class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Direktur"><i class="fa fa-user-circle-o "></i></a> ' . 
               '</div>';          
    })
    ->rawColumns(['nomor', 'acc','nama','status','cabang','wilayah','created','expired','acc_laporan'])->make(true);
    }

   // end class 
} 


  // return Datatables::of($laporan)
  //   ->addColumn('nomor', function(){
  //           global $nomor;
  //           return ++$nomor;
  //   })->addColumn('nama', function($laporan){
  //      $user = User::findOrFail($laporan["user_id"]);
  //           return '<span >'.
  //                   '<a onclick="viewProfil('.$laporan["user_id"].')" class="btn btn-default btn-sm" style="background-color:#6C85EF;color:white;width:25%" data-toggle="tooltip" data-placement="top" title="view profil"><i class="fa fa-user-o"></i></a> ' .      
  //                  '</span>&nbsp;&nbsp'.$user->nama;
  //   })->addColumn('status', function($laporan){
  //      $user = User::findOrFail($laporan["user_id"]);
  //           return $user->status;
  //   })->addColumn('cabang', function($laporan){
  //      $user = User::findOrFail($laporan["user_id"]);
  //      $cabang = $user->cabang()->first();
  //           return $cabang->nama;
  //   })->addColumn('wilayah', function($laporan){
  //      $user = User::findOrFail($laporan["user_id"]);
  //           return $user->wilayah;
  //   })->addColumn('created', function($laporan){
  //           return substr($laporan["created_at"],0,10);
  //   })->addColumn('expired', function($laporan){
  //           if (Carbon::now()->lessThan($laporan["expired_at"])) {
  //               return '<div align="center">'.
  //               Carbon::now()->diffInDays($laporan["expired_at"]). 
  //               ' hari</div>';
  //           } else {
  //                if($laporan["perpanjang_deadline"] == false){ 
  //                 return '<span >'.
  //                   '<a onclick="deadlineLaporan('.$laporan["id"] .')" class="btn btn-default btn-sm" style="background-color:#6C85EF;color:white;width:25%" data-toggle="tooltip" data-placement="top" title="minta perpanjangan deadline laporan"><i class="glyphicon glyphicon-time "></i></a> ' .      
  //                  '</span>&nbsp;&nbsp;kedaluwarsa';
  //               }else{
  //                   return '<span >'.
  //                   '<a href="#" class="btn btn-default btn-sm" style="width:25%" data-toggle="tooltip" data-placement="top" title="pemintaan perpanjangan deadline laporan telah dikirim"><i class="glyphicon glyphicon-time "></i></a> ' .      
  //                  '</span>&nbsp;&nbsp;kedaluwarsa';
  //               }
  //           }
            
  //           // return $laporan->expired_at->diffInDays( Carbon::now());
  //   })->addColumn('acc_laporan', function($laporan){
  //           $user = User::findOrFail($laporan["user_id"]);
  //           if($laporan["acc_ft_kacab"] == 'disetujui') {$btn_kacab = '#87DE8B';} 
  //               else if($laporan["acc_ft_kacab"] == 'perbaikan') {$btn_kacab = '#E9C02F';} 
  //                   else {$btn_kacab = '#F97373';}
  //           if($laporan["acc_manajer"] == 'disetujui') {$btn_manajer = '#87DE8B';}
  //               else if($laporan["acc_manajer"] == 'perbaikan') {$btn_manajer = '#E9C02F';}
  //                   else {$btn_manajer = '#F97373';}
  //           if($laporan["acc_direktur"] == 'disetujui') {$btn_direktur = '#87DE8B';}
  //               else if($laporan["acc_direktur"] == 'perbaikan') {$btn_direktur = '#E9C02F';}
  //                   else {$btn_direktur = '#F97373';}

  //           // if ($users->status == 'ft_admin' && $users->status == 'ft_sponsorship'){
  //                return '<div align="center" >' .
  //              '<a onclick="viewAccLaporan('.$laporan["user_id"].','.$laporan["id"] .',\'ft_kacab\')" style="background-color: '.$btn_kacab.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Kepala Cabang"><i class="fa fa-user-o " style="color:white"></i></a> ' .               
  //              // '<a onclick="viewAccLaporan('.$laporan["user_id"].','.$laporan["id"] .',\'manajer\')" style="background-color: '.$btn_manajer.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Manajer"><i class="fa fa-user-circle " style="color:white"></i></a> ' .                
  //              // '<a onclick="viewAccLaporan('.$laporan["user_id"].','.$laporan["id"] .',\'direktur\')" style="background-color: '.$btn_direktur.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Direktur"><i class="fa fa-user-circle-o " style="color:white"></i></a> ' . 
  //              '</div>';          
  //   })
  //   ->rawColumns(['nomor', 'acc','nama','status','cabang','wilayah','created','expired','acc_laporan'])->make(true);
  //   }