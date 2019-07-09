<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\FtAdmin;
use App\FtSponsorship;
use App\FtKacab;
use App\Manajer;
use App\Direktur;

use App\User;
use App\Form;
use App\Pengumuman;
use Validator;
use Mockery\Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use PDF;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
public function index($id)
{
    $user = User::findOrFail($id);

if ($user->status == 'direktur'){

        $pengumuman = Pengumuman::where('status', $user->status)->first();

        $ft_admin_direktur = FtAdmin::where('send_direktur',true)->count();
        $ft_sponsorship_direktur = FtSponsorship::where('send_direktur',true)->count();
        $ft_kacab_direktur = FtKacab::where('send_direktur',true)->count();
        $manajer_direktur = Manajer::where('send_direktur',true)->count();

        return view('direktur.index',compact(['laporan','laporan_baru','laporan_proses','laporan_perbaikan','laporan_disetujui','pengumuman','laporan_kedaluwarsa','ft_admin_direktur','ft_sponsorship_direktur','ft_kacab_direktur','manajer_direktur']));

}else if ($user->status == 'manajer'){
        $laporan = FtAdmin::where('user_id',$user->id)->get();
        $laporan_baru = FtAdmin::where('user_id',$user->id)->where('status_laporan','baru')->count();
        $laporan_proses = FtAdmin::where('user_id',$user->id)->where('status_laporan','proses')->count();
        $laporan_perbaikan = FtAdmin::where('user_id',$user->id)->where('status_laporan','perbaikan')->count();
        $laporan_disetujui = FtAdmin::where('user_id',$user->id)->where('status_laporan','disetujui')->count();
        $laporan_kedaluwarsa = FtSponsorship::where('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','baru')->orWhere('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','perbaikan')->count();

        $pengumuman = Pengumuman::where('status', $user->status)->first();

        $ft_admin_manajer = FtAdmin::where('send_manajer',true)->count();
        $ft_sponsorship_manajer = FtSponsorship::where('send_manajer',true)->count();
        $ft_kacab_manajer = FtKacab::where('send_manajer',true)->count();

        return view('manajer.index',compact(['laporan','laporan_baru','laporan_proses','laporan_perbaikan','laporan_disetujui','pengumuman','laporan_kedaluwarsa','ft_admin_manajer','ft_sponsorship_manajer','ft_kacab_manajer']));

}else if ($user->status == 'ft_kacab'){
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
        // $ft_sponsorship_ft_kacab = FtSponsorship::where('send_ft_kacab',true)->count();
        $laporan = FtAdmin::where('user_id',$user->id)->get();
        $laporan_baru = FtAdmin::where('user_id',$user->id)->where('status_laporan','baru')->count();
        $laporan_proses = FtAdmin::where('user_id',$user->id)->where('status_laporan','proses')->count();
        $laporan_perbaikan = FtAdmin::where('user_id',$user->id)->where('status_laporan','perbaikan')->count();
        $laporan_disetujui = FtAdmin::where('user_id',$user->id)->where('status_laporan','disetujui')->count();
        $laporan_kedaluwarsa = FtSponsorship::where('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','baru')->orWhere('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','perbaikan')->count();

        $pengumuman = Pengumuman::where('status', $user->status)->first();
        return view('ft-kacab.index',compact(['laporan','laporan_baru','laporan_proses','laporan_perbaikan','laporan_disetujui','pengumuman','laporan_kedaluwarsa','ft_admin_ft_kacab','ft_sponsorship_ft_kacab']));

}else if ($user->status == 'ft_sponsorship'){
        $laporan = FtSponsorship::where('user_id',$user->id)->get();
        $laporan_baru = FtSponsorship::where('user_id',$user->id)->where('status_laporan','baru')->count();
        $laporan_proses = FtSponsorship::where('user_id',$user->id)->where('status_laporan','proses')->count();
        $laporan_perbaikan = FtSponsorship::where('user_id',$user->id)->where('status_laporan','perbaikan')->count();
        $laporan_disetujui = FtSponsorship::where('user_id',$user->id)->where('status_laporan','disetujui')->count();
        $laporan_kedaluwarsa = FtSponsorship::where('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','baru')->orWhere('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','perbaikan')->count();
        
        $pengumuman = Pengumuman::where('status', $user->status)->first();
        return view('ft-sponsorship.index',compact(['laporan','laporan_baru','laporan_proses','laporan_perbaikan','laporan_disetujui','pengumuman','laporan_kedaluwarsa']));

}else if ($user->status == 'ft_admin'){
        $laporan = FtAdmin::where('user_id',$user->id)->get();
        $laporan_baru = FtAdmin::where('user_id',$user->id)->where('status_laporan','baru')->count();
        $laporan_proses = FtAdmin::where('user_id',$user->id)->where('status_laporan','proses')->count();
        $laporan_perbaikan = FtAdmin::where('user_id',$user->id)->where('status_laporan','perbaikan')->count();
        $laporan_disetujui = FtAdmin::where('user_id',$user->id)->where('status_laporan','disetujui')->count();
        $laporan_kedaluwarsa = FtAdmin::where('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','baru')->orWhere('user_id',$user->id)->where('expired_at','<=',Carbon::now())->where('status_laporan','perbaikan')->count();
        
        $pengumuman = Pengumuman::where('status', $user->status)->first();
        return view('ft-admin.index',compact(['laporan','laporan_baru','laporan_proses','laporan_perbaikan','laporan_disetujui','pengumuman','laporan_kedaluwarsa']));
    }
 }  
}
