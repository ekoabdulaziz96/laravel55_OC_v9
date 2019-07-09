<?php

namespace App\Http\Controllers\Admin\ApiLaporanAcc;

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

class ApiFtAdminSponsController extends Controller
{


  public function apiLaporan($status)
  {
  // $users = User::findOrFail($id);
    if ($status == 'ft_sponsorship'){
      $laporan = FtSponsorship::where('send_ft_kacab',true)->orWhere('send_manajer',true)->orWhere('send_direktur',true)->orderBy('created_at','asc')->get();
    }else if ($status == 'ft_admin'){
      $laporan = FtAdmin::where('send_ft_kacab',true)->orWhere('send_manajer',true)->orWhere('send_direktur',true)->orderBy('created_at','asc')->get();
    }


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

    })->addColumn('expired', function($laporan){
            if (Carbon::now()->lessThan($laporan->expired_at)) {
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
                    '<a href="#" class="btn btn-default btn-sm" style="width:25%" data-toggle="tooltip" data-placement="top" title="pemintaan perpanjangan deadline laporan telah dikirim"><i class="glyphicon glyphicon-time "></i></a> ' .      
                   '</span>&nbsp;&nbsp;kedaluwarsa';
                }
            }
            
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
               '<a onclick="viewAccLaporan('.$laporan->user_id.','.$laporan->id .',\'manajer\')" style="background-color: '.$btn_manajer.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Manajer"><i class="fa fa-user-circle " style="color:white"></i></a> ' .                
               '<a onclick="viewAccLaporan('.$laporan->user_id.','.$laporan->id .',\'direktur\')" style="background-color: '.$btn_direktur.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Direktur"><i class="fa fa-user-circle-o " style="color:white"></i></a> ' . 
               '</div>';          
    })
    ->rawColumns(['nomor', 'acc','nama','status','cabang','wilayah','created','expired','acc_laporan'])->make(true);
    }
}


