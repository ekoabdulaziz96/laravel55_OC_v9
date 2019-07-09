<?php

namespace App\Http\Controllers\Laporan;

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
    public function laporanStatus($status)
    {
        $user = User::findOrFail(2);
        $forms = Form::where('status',$user->status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $form_all = Form::where('status',$user->status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        $status_laporan = $status;

        
        return view('admin.laporan',compact(['user','status_laporan','forms','form_all']));
    } 

  // // view kelola Acc laporan
  //   public function laporanAcc($status)
  //   {
  //       // $user = User::findOrFail(2);
  //       $forms = Form::where('status',$status)->where('view','show')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
  //       $form_all = Form::where('status',$status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
  //       $status_laporan = $status;
  //       $laporan_status = 'acc_laporan';

        
  //       return view('admin.laporanAcc',compact(['status_laporan','laporan_status','forms','form_all','status']));
  //   }  

    // public function laporanTerpilih(Request $request)
    // // public function laporanTerpilih()
    // {
    //     $user = User::findOrFail($request->nama);
    //     // $user = User::findOrFail(10);
    //    if ($user->status == 'direktur'){
    //       $laporan = Direktur::where('user_id',$user->id)->get();
    //     }else if ($user->status == 'manajer'){
    //       $laporan = Manajer::where('user_id',$user->id)->get();
    //     }else if ($user->status == 'ft_kacab'){
    //       $laporan = FtKacab::where('user_id',$user->id)->get();
    //     }else if ($user->status == 'ft_sponsorship'){
    //       $laporan = FtSponsorship::where('user_id',$user->id)->get();
    //     }else if ($user->status == 'ft_admin'){
    //       $laporan = FtAdmin::where('user_id',$user->id)->get();
    //     }    
    //     $form_all = Form::where('status',$user->status)->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
    //      $laporan_status = 'pantau_individual';
        
    //     return view('admin.laporan',compact(['user','laporan','form_all','laporan_status']));
    // }

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
             return $created->startOfDay();
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

        $pdf=PDF::loadView('export-pdf/_pdf',compact(['laporan','form_pagi','form_inti','form_sore','user']), [], ['format' => 'A4']);
        return $pdf->download('laporan_'.substr($laporan->created_at,0,10));
    }    

    // public function cek($id_user,$id_laporan){
    //     $user = User::findOrFail($id_user);    
    //     $laporan =ftAdmin::where('id',$id_laporan)->first();
    //     $form_pagi = Form::where('status',$user->status)->where('kategori','1_formula_pagi')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
    //     $form_inti = Form::where('status',$user->status)->where('kategori','2_formula_inti')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
    //     $form_sore = Form::where('status',$user->status)->where('kategori','3_formula_sore')->orderBy('kategori', 'asc')->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
    //     return view('ft-admin/export/_pdf',compact(['laporan','form_pagi','form_inti','form_sore','user']));
    // }

    public function deadlineLaporanKirim($id)
    {
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

    public function deadlineLaporanAcc($id)
    {
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
        $input['expired_at'] = Carbon::now()->addDays(3);
        $laporan->update($input);
            return response()->json([
                'success' => true,
                'message' => 'Deadline laporan berhasil diperpanjang',
                'title'=> 'Proses!',
                'type'=> 'warning',
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
public function persetujuanLaporan(request $request,$id)
{
    // dd($user_id,$id);
    $users = User::findOrFail($request->id);
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
if($request->persetujuan_dari == 'ft_kacab'){
  $input['status_laporan'] ='-';
  if ($request->status_acc_laporan == 'disetujui'){
      $input['status_laporan'] ='proses';
      $input['acc_ft_kacab'] ='disetujui';
      $input['send_ft_kacab'] =0;
      $input['komentar_ft_kacab'] ='-';

      $input['acc_manajer'] ='proses';
      $input['send_manajer'] =1;
  }else if ($request->status_acc_laporan == 'perbaikan'){
      $input['status_laporan'] ='perbaikan';
      $input['acc_ft_kacab'] ='perbaikan';
      $input['send_ft_kacab'] =0;
      $input['komentar_ft_kacab'] =$request->komentar;
      $input['expired_at'] =$laporan->expired_at->addDays(3);
  }
    if( $input['status_laporan'] =='-'){
          return response()->json([
              'success' => true,
              'message' => 'update status persetujuan "baru" dan "proses" dilakuakan otomatis oleh sistem',
              'title'=> 'Mohon Maaf!',
              'type'=> 'warning',
              'timer'=> 3000
          ]);
      }else {
          $laporan->update($input);
          return response()->json([
              'success' => true,
              'message' => 'Persetujuan  Laporan berhasil diperbarui',
              'title'=> 'Sukses Mengirim!',
              'type'=> 'success',
              'timer'=> 2500
          ]);
      }
} else if($request->persetujuan_dari == 'manajer'){
    if($laporan->acc_ft_kacab == 'disetujui'){
      $input['status_laporan'] ='-';
      if ($request->status_acc_laporan == 'disetujui'){
          $input['status_laporan'] ='proses';
          $input['acc_manajer'] ='disetujui';
          $input['send_manajer'] =0;
          $input['komentar_manajer'] ='-';

          $input['acc_direktur'] ='proses';
          $input['send_direktur'] =1;
      }else if ($request->status_acc_laporan == 'perbaikan'){
          $input['status_laporan'] ='perbaikan';
          $input['acc_manajer'] ='perbaikan';
          $input['send_manajer'] =0;
          $input['komentar_manajer'] =$request->komentar;
          $input['expired_at'] =$laporan->expired_at->addDays(3);
      }
           if( $input['status_laporan'] =='-'){
              return response()->json([
                  'success' => true,
                  'message' => 'update status persetujuan "baru" dan "proses" dilakuakan otomatis oleh sistem',
                  'title'=> 'Mohon Maaf!',
                  'type'=> 'warning',
                  'timer'=> 3000
              ]);
          }else {
              $laporan->update($input);
              return response()->json([
                  'success' => true,
                  'message' => 'Persetujuan  Laporan berhasil diperbarui',
                  'title'=> 'Sukses Mengirim!',
                  'type'=> 'success',
                  'timer'=> 2500
              ]);
          }
    }else{
        return response()->json([
            'success' => true,
            'message' => 'untuk memperoleh persetujuan Manajer, laporan ini harus disetujui "Kepala Cabang"',
            'title'=> 'Mohon Maaf!',
            'type'=> 'warning',
            'timer'=> 3000
        ]); 

      }
} else if($request->persetujuan_dari == 'direktur'){
    if($laporan->acc_manajer == 'disetujui' && $laporan->acc_ft_kacab == 'disetujui'){
      $input['status_laporan'] ='-';
      if ($request->status_acc_laporan == 'disetujui'){
          $input['status_laporan'] ='disetujui';
          $input['acc_direktur'] ='disetujui';
          $input['send_direktur'] =0;
          $input['komentar_direktur'] ='-';

      }else if ($request->status_acc_laporan == 'perbaikan'){
          $input['status_laporan'] ='perbaikan';
          $input['acc_direktur'] ='perbaikan';
          $input['send_direktur'] =0;
          $input['komentar_direktur'] =$request->komentar;
          $input['expired_at'] =$laporan->expired_at->addDays(3);
      }
          if( $input['status_laporan'] =='-'){
              return response()->json([
                  'success' => true,
                  'message' => 'update status persetujuan "baru" dan "proses" dilakuakan otomatis oleh sistem',
                  'title'=> 'Mohon Maaf!',
                  'type'=> 'warning',
                  'timer'=> 3000
              ]);
          }else {
              $laporan->update($input);
              return response()->json([
                  'success' => true,
                  'message' => 'Persetujuan  Laporan berhasil diperbarui',
                  'title'=> 'Sukses Mengirim!',
                  'type'=> 'success',
                  'timer'=> 2500
              ]);
          }
    }else{ 
         return response()->json([
            'success' => true,
            'message' => 'untuk memperoleh persetujuan Direktur, laporan ini harus disetujui "Kepala Cabang" dan "manajer"',
            'title'=> 'Mohon Maaf!',
            'type'=> 'warning',
            'timer'=> 3000
        ]);

      }
  } 
}

public function persetujuanLaporanAcc(request $request,$user_id,$id)
{
    // dd($user_id,$id);
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
if($request->persetujuan_dari == 'ft_kacab'){
  $input['status_laporan'] ='-';
  if ($request->status_acc_laporan == 'disetujui'){
      $input['status_laporan'] ='proses';
      $input['acc_ft_kacab'] ='disetujui';
      $input['send_ft_kacab'] =0;
      $input['komentar_ft_kacab'] ='-';

      $input['acc_manajer'] ='proses';
      $input['send_manajer'] =1;
  }else if ($request->status_acc_laporan == 'perbaikan'){
      $input['status_laporan'] ='perbaikan';
      $input['acc_ft_kacab'] ='perbaikan';
      $input['send_ft_kacab'] =0;
      $input['komentar_ft_kacab'] =$request->komentar;
      $input['expired_at'] =$laporan->expired_at->addDays(3);
  }
    if( $input['status_laporan'] =='-'){
          return response()->json([
              'success' => true,
              'message' => 'update status persetujuan "baru" dan "proses" dilakuakan otomatis oleh sistem',
              'title'=> 'Mohon Maaf!',
              'type'=> 'warning',
              'timer'=> 3000
          ]);
      }else {
          $laporan->update($input);
          return response()->json([
              'success' => true,
              'message' => 'Persetujuan  Laporan berhasil diperbarui',
              'title'=> 'Sukses Mengirim!',
              'type'=> 'success',
              'timer'=> 2500
          ]);
      }
} else if($request->persetujuan_dari == 'manajer'){
    if($laporan->acc_ft_kacab == 'disetujui'){
      $input['status_laporan'] ='-';
      if ($request->status_acc_laporan == 'disetujui'){
          $input['status_laporan'] ='proses';
          $input['acc_manajer'] ='disetujui';
          $input['send_manajer'] =0;
          $input['komentar_manajer'] ='-';

          $input['acc_direktur'] ='proses';
          $input['send_direktur'] =1;
      }else if ($request->status_acc_laporan == 'perbaikan'){
          $input['status_laporan'] ='perbaikan';
          $input['acc_manajer'] ='perbaikan';
          $input['send_manajer'] =0;
          $input['komentar_manajer'] =$request->komentar;
          $input['expired_at'] =$laporan->expired_at->addDays(3);
      }
           if( $input['status_laporan'] =='-'){
              return response()->json([
                  'success' => true,
                  'message' => 'update status persetujuan "baru" dan "proses" dilakuakan otomatis oleh sistem',
                  'title'=> 'Mohon Maaf!',
                  'type'=> 'warning',
                  'timer'=> 3000
              ]);
          }else {
              $laporan->update($input);
              return response()->json([
                  'success' => true,
                  'message' => 'Persetujuan  Laporan berhasil diperbarui',
                  'title'=> 'Sukses Mengirim!',
                  'type'=> 'success',
                  'timer'=> 2500
              ]);
          }
    }else{
        return response()->json([
            'success' => true,
            'message' => 'untuk memperoleh persetujuan Manajer, laporan ini harus disetujui "Kepala Cabang"',
            'title'=> 'Mohon Maaf!',
            'type'=> 'warning',
            'timer'=> 3000
        ]); 

      }
} else if($request->persetujuan_dari == 'direktur'){
    if($laporan->acc_manajer == 'disetujui' && $laporan->acc_ft_kacab == 'disetujui'){
      $input['status_laporan'] ='-';
      if ($request->status_acc_laporan == 'disetujui'){
          $input['status_laporan'] ='disetujui';
          $input['acc_direktur'] ='disetujui';
          $input['send_direktur'] =0;
          $input['komentar_direktur'] ='-';

      }else if ($request->status_acc_laporan == 'perbaikan'){
          $input['status_laporan'] ='perbaikan';
          $input['acc_direktur'] ='perbaikan';
          $input['send_direktur'] =0;
          $input['komentar_direktur'] =$request->komentar;
          $input['expired_at'] =$laporan->expired_at->addDays(3);
      }
          if( $input['status_laporan'] =='-'){
              return response()->json([
                  'success' => true,
                  'message' => 'update status persetujuan "baru" dan "proses" dilakuakan otomatis oleh sistem',
                  'title'=> 'Mohon Maaf!',
                  'type'=> 'warning',
                  'timer'=> 3000
              ]);
          }else {
              $laporan->update($input);
              return response()->json([
                  'success' => true,
                  'message' => 'Persetujuan  Laporan berhasil diperbarui',
                  'title'=> 'Sukses Mengirim!',
                  'type'=> 'success',
                  'timer'=> 2500
              ]);
          }
    }else{ 
         return response()->json([
            'success' => true,
            'message' => 'untuk memperoleh persetujuan Direktur, laporan ini harus disetujui "Kepala Cabang" dan "manajer"',
            'title'=> 'Mohon Maaf!',
            'type'=> 'warning',
            'timer'=> 3000
        ]);

      }
  } 
}

   // end class 
}


