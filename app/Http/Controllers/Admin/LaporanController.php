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
// view kelola laporan
    public function laporanStatusView($user_id,$status)
    {
        $user = User::findOrFail($user_id);
        $forms = Form::where('status',$user->status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_all = Form::where('status',$user->status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $status_laporan = $status;

        if ($user->status == 'direktur'){
            return view('admin.laporan',compact(['user','status_laporan','forms','form_all']));
        }else if ($user->status == 'manajer'){
            return view('admin.laporan',compact(['user','status_laporan','forms','form_all']));
        }else if ($user->status == 'ft_kacab'){
            return view('admin.laporan',compact(['user','status_laporan','forms','form_all']));
        }else if ($user->status == 'ft_sponsorship'){
            return view('admin.laporan',compact(['user','status_laporan','forms','form_all']));
        }else if ($user->status == 'ft_admin'){
            return view('ft-admin.laporan',compact(['user','status_laporan','forms','form_all']));
        }
        
    } 
  // view kelola laporan
    public function laporanStatus($status)
    {
        $user = User::findOrFail(2);
        $forms = Form::where('status',$user->status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_all = Form::where('status',$user->status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $status_laporan = $status;

        
        return view('admin.laporan',compact(['user','status_laporan','forms','form_all']));
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
            if($users->created_at->isSunday()){
              return $created->startOfDay()->addDay();
            }else{
              return $created->startOfDay();
            }
        }else if($statusUser->created_at->addDay()->isSunday()){
            $created = $statusUser->created_at->addDays(2);
             return $created->startOfDay();
        }else{
             $created = $statusUser->created_at->addDay();
              return $created->startOfDay();
        }
       
    } 

    public function exportPdfLaporan($id_user,$id_laporan){
        $user = User::findOrFail($id_user);
        $cabang = $user->cabang()->first();
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

        $pdf=PDF::loadView('export-pdf/_pdf',compact(['laporan','form_pagi','form_inti','form_sore','user','cabang']), [], ['format' => 'A4']);
        return $pdf->stream('laporan_'.str_slug($user->nama, '-').'_'.substr($laporan->created_at,0,10));
    }       

    public function exportPdfcek($id_user,$id_laporan){
        $user = User::findOrFail($id_user);
        $cabang = $user->cabang()->first();
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
        
        return view('export-pdf/_pdf',compact(['laporan','form_pagi','form_inti','form_sore','user','cabang']));
    }    

    public function deadlineLaporan($user_id,$id)
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
    public function deadlineLaporanAcc($user_id,$id)
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
        $input['expired_at'] = Carbon::now()->endOfDay()->addDays(3);
        $input['perpanjang_deadline'] = false;

        $laporan->update($input);
            return response()->json([
                'success' => true,
                'message' => 'Deadline laporan berhasil diperpanjang',
                'title'=> 'Berhasil!',
                'type'=> 'success',
                'timer'=> 2500
            ]);
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
    if($users->status =='ft_admin' || $users->status == 'ft_sponsorship') {
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
    } else if($users->status == 'ft_kacab'){
       if($laporan->acc_manajer != 'disetujui'){
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
    }else if ($users->status == 'manajer'){
        if($laporan->acc_direktur != 'disetujui'){
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

}    

   // end class 
}


