<?php

namespace App\Http\Controllers\Admin\ApiLaporanAccDeadline;

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

class ApiLaporanDeadlineController extends Controller
{


  public function apiLaporan($status)
  {
  // $users = User::findOrFail($id);
    if ($status == 'ft_admin'){
      $laporan = FtAdmin::where('perpanjang_deadline',true)->orderBy('created_at','asc')->get();
    }else  if ($status == 'ft_sponsorship'){
      $laporan = FtSponsorship::where('perpanjang_deadline',true)->orderBy('created_at','asc')->get();
    }else if ($status == 'ft_kacab'){
      $laporan = FtKacab::where('perpanjang_deadline',true)->orderBy('created_at','asc')->get();
    }else if ($status == 'manajer'){
      $laporan = Manajer::where('perpanjang_deadline',true)->orderBy('created_at','asc')->get();
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
         if($laporan->perpanjang_deadline == true){ 
          return '<span >'.
          '<a onclick="deadlineLaporan('.$laporan->user_id.','.$laporan->id .')" class="btn  btn-default btn-sm" style="background-color:#6C85EF;color:white;width:25%" data-toggle="tooltip" data-placement="top" title="Acc permintaan perpanjangan deadline laporan"><i class="glyphicon glyphicon-time "></i></a> ' .      
           '</span>&nbsp;&nbsp;kedaluwarsa';
        }
    })
    ->rawColumns(['nomor', 'acc','nama','status','cabang','wilayah','created','expired'])->make(true);
    }
}


