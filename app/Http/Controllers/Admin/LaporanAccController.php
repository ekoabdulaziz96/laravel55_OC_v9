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

class LaporanAccController extends Controller
{
// persetujuan deadline 
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
      if(Carbon::now()->lessThan($laporan->expired_at)){
        $input['expired_at'] =$laporan->expired_at->endOfDay()->addDays(3);
      }else {
        $input['expired_at'] =Carbon::now()->endOfDay()->addDays(3);
      }
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
            if(Carbon::now()->lessThan($laporan->expired_at)){
              $input['expired_at'] =$laporan->expired_at->endOfDay()->addDays(3);
            }else {
              $input['expired_at'] =Carbon::now()->endOfDay()->addDays(3);
            }
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
            if(Carbon::now()->lessThan($laporan->expired_at)){
              $input['expired_at'] =$laporan->expired_at->endOfDay()->addDays(3);
            }else {
              $input['expired_at'] =Carbon::now()->endOfDay()->addDays(3);
            }
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

public function AccLaporanFtAdminSpons(request $request,$user_id,$id)
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
            if(Carbon::now()->lessThan($laporan->expired_at)){
              $input['expired_at'] =$laporan->expired_at->endOfDay()->addDays(3);
            }else {
              $input['expired_at'] =Carbon::now()->endOfDay()->addDays(3);
            }
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
              if(Carbon::now()->lessThan($laporan->expired_at)){
              $input['expired_at'] =$laporan->expired_at->endOfDay()->addDays(3);
            }else {
              $input['expired_at'] =Carbon::now()->endOfDay()->addDays(3);
            }
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
            if(Carbon::now()->lessThan($laporan->expired_at)){
              $input['expired_at'] =$laporan->expired_at->endOfDay()->addDays(3);
            }else {
              $input['expired_at'] =Carbon::now()->endOfDay()->addDays(3);
            }
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

public function AccLaporanFtKacab(request $request,$user_id,$id)
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
if($request->persetujuan_dari == 'manajer'){
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
              if(Carbon::now()->lessThan($laporan->expired_at)){
              $input['expired_at'] =$laporan->expired_at->endOfDay()->addDays(3);
            }else {
              $input['expired_at'] =Carbon::now()->endOfDay()->addDays(3);
            }
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

} else if($request->persetujuan_dari == 'direktur'){
    if($laporan->acc_manajer == 'disetujui'){
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
            if(Carbon::now()->lessThan($laporan->expired_at)){
              $input['expired_at'] =$laporan->expired_at->endOfDay()->addDays(3);
            }else {
              $input['expired_at'] =Carbon::now()->endOfDay()->addDays(3);
            }
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
            'message' => 'untuk memperoleh persetujuan Direktur, laporan ini harus disetujui "manajer"',
            'title'=> 'Mohon Maaf!',
            'type'=> 'warning',
            'timer'=> 3000
        ]);

      }
  } 
}

public function AccLaporanManajer(request $request,$user_id,$id)
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
 if($request->persetujuan_dari == 'direktur'){
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
            if(Carbon::now()->lessThan($laporan->expired_at)){
              $input['expired_at'] =$laporan->expired_at->endOfDay()->addDays(3);
            }else {
              $input['expired_at'] =Carbon::now()->endOfDay()->addDays(3);
            }
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

  } 
}

   // end class 
}


