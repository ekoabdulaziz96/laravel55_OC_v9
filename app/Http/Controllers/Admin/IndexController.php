<?php

namespace App\Http\Controllers\Admin;

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
    public function index()
    {
        $ft_admin_direktur = FtAdmin::where('send_direktur',true)->count();
        $ft_admin_manajer = FtAdmin::where('send_manajer',true)->count();
        $ft_admin_ft_kacab = FtAdmin::where('send_ft_kacab',true)->count();        
            $ft_sponsorship_direktur = FtSponsorship::where('send_direktur',true)->count();
            $ft_sponsorship_manajer = FtSponsorship::where('send_manajer',true)->count();
            $ft_sponsorship_ft_kacab = FtSponsorship::where('send_ft_kacab',true)->count();
        $ft_kacab_direktur = FtKacab::where('send_direktur',true)->count();
        $ft_kacab_manajer = FtKacab::where('send_manajer',true)->count();
            $manajer_direktur = Manajer::where('send_direktur',true)->count();

        $ft_admin_dl = FtAdmin::where('perpanjang_deadline',true)->count();
        $ft_sponsorship_dl = FtSponsorship::where('perpanjang_deadline',true)->count();
        $ft_kacab_dl = FtKacab::where('perpanjang_deadline',true)->count();
        $manajer_dl = Manajer::where('perpanjang_deadline',true)->count();           

        $ft_admin = User::where('status','ft_admin')->count();
        $ft_sponsorship = User::where('status','ft_sponsorship')->count();
        $ft_kacab = User::where('status','ft_kacab')->count();
        $manajer = User::where('status','manajer')->count();    
        
        return view('admin.index',compact([
            'ft_admin_direktur','ft_admin_manajer','ft_admin_ft_kacab',
            'ft_sponsorship_direktur','ft_sponsorship_manajer','ft_sponsorship_ft_kacab',
            'ft_kacab_direktur','ft_kacab_manajer',
            'manajer_direktur',
            'ft_admin_dl','ft_sponsorship_dl','ft_kacab_dl','manajer_dl',
            'ft_admin','ft_sponsorship','ft_kacab','manajer',
        ]));
    }  
}
