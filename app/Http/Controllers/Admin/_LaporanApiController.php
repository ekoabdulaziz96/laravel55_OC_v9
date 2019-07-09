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

class LaporanApiController extends Controller
{


public function apiLaporan($id)
{
$users = User::findOrFail($id);
    if ($users->status == 'direktur'){
      $laporan = Direktur::where('user_id',$id)->get();
    }else if ($users->status == 'manajer'){
      $laporan = Manajer::where('user_id',$id)->get();
    }else if ($users->status == 'ft_kacab'){
      $laporan = FtKacab::where('user_id',$id)->get();
    }else if ($users->status == 'ft_sponsorship'){
      $laporan = FtSponsorship::where('user_id',$id)->get();
    }else if ($users->status == 'ft_admin'){
      $laporan = FtAdmin::where('user_id',$id)->get();
    }


return Datatables::of($laporan)
    ->addColumn('nomor', function(){
            global $nomor;
            return ++$nomor;
    })->addColumn('created', function($laporan){
        if ($laporan->status_laporan == 'disetujui'){
            return '<span >'.
                    '<a onclick="exportPdfLaporan('.$laporan->id.')" class="btn btn-default btn-sm" style="background-color:#6C85EF;color:white;width:25%" data-toggle="tooltip" data-placement="top" title="minta perpanjangan deadline laporan"><i class="glyphicon glyphicon-print "></i></a> ' .      
                   '</span>&nbsp;&nbsp'.substr($laporan->created_at,0,10);
        }else {
              return  '<span >'.
                    '<a onclick="exportPdfLaporan('.$laporan->id.')" class="btn btn-default btn-sm" style="background-color:#6C85EF;color:white;width:25%" data-toggle="tooltip" data-placement="top" title="minta perpanjangan deadline laporan"><i class="glyphicon glyphicon-print "></i></a> ' .      
                   '</span>&nbsp;&nbsp'.substr($laporan->created_at,0,10);
        }
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
                    '<a href="#" class="btn btn-default btn-sm" style="width:25%" data-toggle="tooltip" data-placement="top" title="minta perpanjangan deadline laporan"><i class="glyphicon glyphicon-time "></i></a> ' .      
                   '</span>&nbsp;&nbsp;kedaluwarsa';
                }
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

            // if ($users->status == 'ft_admin' && $users->status == 'ft_sponsorship'){
                 return '<div align="center" >' .
               '<a onclick="viewAccLaporan('.$laporan->id .',\'ft_kacab\')" style="background-color: '.$btn_kacab.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Kepala Cabang"><i class="fa fa-user-o " style="color:white"></i></a> ' .               
               '<a onclick="viewAccLaporan('.$laporan->id .',\'manajer\')" style="background-color: '.$btn_manajer.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Manajer"><i class="fa fa-user-circle " style="color:white"></i></a> ' .                
               '<a onclick="viewAccLaporan('.$laporan->id .',\'direktur\')" style="background-color: '.$btn_direktur.'"  class="btn btn-default btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Acc Laporan Direktur"><i class="fa fa-user-circle-o " style="color:white"></i></a> ' . 
               '</div>';

           
    })->addColumn('action', function($laporan){
          if (Carbon::now()->lessThan($laporan->expired_at)) {
                if ($laporan->status_laporan=='baru' ){
                    return '<div align="right" >'.
                    '<a onclick="showLaporan('.$laporan->id .')" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detail"><i class="glyphicon glyphicon-eye-open"></i></a> ' .
                   '<a onclick="editLaporan('.$laporan->id .')" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a> ' .
                   '<a onclick="deleteLaporan('.$laporan->id .')" href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="glyphicon glyphicon-trash"></i></a>'.
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


