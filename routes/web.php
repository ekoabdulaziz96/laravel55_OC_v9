<?php
use Carbon\Carbon;
use App\FtAdmin;
use App\FtSponsorship;
use App\FtKacab;
use App\Manajer;
use App\Direktur;
use App\User;
use App\Cabang;
use App\Form;
use Mockery\Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// Route::get('/cek', function () {

// })->name('cek');







Route::get('/', 'Auth\LoginController@viewLogin' )->name('/');

// Route::get('/form', function () {
//     return view('layouts/form');
// });
Auth::routes();
Route::get('auth/activate','Auth\ActivationController@activate')->name('auth.activate');
Route::get('auth/activate/resend','Auth\ActivationResendController@showResendForm')->name('auth.activate.resend');
Route::post('auth/activate/resend','Auth\ActivationResendController@resend');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/logout', 'HomeController@logoutUser')->name('user.logout');

// *********************--------profil----------------**************
Route::post('admin/profil-update', 'ProfilController@updateProfil')->name('admin.profil-update');  

// *********************--------Admin----------------**************
// ------------------------------------------------------------------
//----- Index/Dashboar
  Route::get('admin/index', 'Admin\IndexController@index')->name('admin.index');

//-----form
      Route::resource('admin/form', 'Admin\FormController',[
        // 'except' => ['create'],
        'names' => ['index' => 'admin.form']
      ]);
      Route::get('api/form/{status}', 'Admin\FormController@apiForm')->name('api.form');
      Route::get('admin/form-pilih/{status}', 'Admin\FormController@formPilih')->name('admin.form-pilih');

//-----laporan
      Route::resource('admin/laporan', 'Admin\LaporanCRUDController',[
        // 'except' => ['create'],
        'names' => ['index' => 'admin.laporan']
      ]);
      Route::get('admin/laporan/{user_id}/edit/{id}', 'Admin\LaporanCRUDController@editLaporan')->name('admin.laporan.edit.user');
      Route::delete('admin/laporan/{user_id}/delete/{id}', 'Admin\LaporanCRUDController@deleteLaporan')->name('admin.laporan.delete.user');
      Route::get('admin/laporan/{user_id}/kirim/{id}', 'Admin\LaporanController@kirimLaporan')->name('admin.laporan.kirim');  
      Route::post('admin/laporan-persetujuan/{id}', 'Admin\LaporanController@persetujuanLaporan')->name('admin.laporan-persetujuan');  
      // Route::get('admin/laporan/{user_id}/deadline-send/{id}', 'Admin\LaporanController@deadlineLaporanKirim')->name('admin.laporan.deadline-send');
      Route::get('admin/laporan/{user_id}/deadline-acc/{id}', 'Admin\LaporanController@deadlineLaporanAcc')->name('admin.laporan.deadline-acc');
      Route::get('admin/{id_user}/laporan/export-pdf/{id}', 'Admin\LaporanController@exportPdfLaporan')->name('admin.laporan.export-pdf');
      
      Route::get('cek/{id_user}/cek/{id}', 'Admin\LaporanController@exportPdfcek')->name('admin.laporan.export-pdf-cek');

      Route::get('admin/laporan-tanggal/{user}', 'Admin\LaporanController@tanggal')->name('admin.laporan.tanggal');
    //view :status laporan : baru, proses, 
      Route::get('admin/laporan-status/{status}', 'Admin\LaporanController@laporanStatus')->name('admin.laporan-status');


    // api
      Route::get('api/admin/{id}/laporan', 'Admin\LaporanApiController@apiLaporan')->name('api.admin.laporan');

//------- pantau detail 
      Route::get('admin/laporan/status/{status}', 'Admin\LaporanPilihController@cabang')->name('admin.laporan.status');
      Route::get('admin/laporan/{status}/cabang/{cabang}', 'Admin\LaporanPilihController@wilayah')->name('admin.laporan.cabang');
      Route::get('admin/laporan/{status}/cabang/{cabang}/wilayah/{wilayah}', 'Admin\LaporanPilihController@namas')->name('admin.laporan.wilayah');
      Route::get('admin/laporan/nama/{status}', 'Admin\LaporanPilihController@nama')->name('admin.laporan.nama');   
      Route::get('admin/laporan/user/{id}', 'Admin\LaporanPilihController@user')->name('admin.laporan.user');
    //ke view pantau detail  
      Route::get('admin/laporan-pilih', 'Admin\LaporanPilihController@laporanPilih')->name('admin.laporan-pilih');
    //post data
      Route::post('admin/laporan-terpilih', 'Admin\LaporanPilihController@laporanTerpilih')->name('admin.laporan-terpilih');
      Route::get('admin/laporan-terpilih-user/{user_id}', 'Admin\LaporanPilihController@laporanTerpilihUser')->name('admin.laporan-terpilih-user');
    // Api
      Route::get('api/admin/{id}/laporan-ftAdminSpons', 'Admin\ApiLaporan\ApiFtAdminSponsController@apiLaporan')->name('api.admin.laporan-ftAdminSpons');
      Route::get('api/admin/{id}/laporan-ftKacab', 'Admin\ApiLaporan\ApiFtKacabController@apiLaporan')->name('api.admin.laporan-ftKacab');
      Route::get('api/admin/{id}/laporan-manajer', 'Admin\ApiLaporan\ApiManajerController@apiLaporan')->name('api.admin.laporan-manajer');
//------- pantau detail 
      Route::get('admin/laporan-karyawan/status/{status}', 'Admin\LaporanPilihController@getUser')->name('admin.laporan-karyawan.status');

      Route::get('admin/laporan-karyawan/cabang/{cabang}', 'Admin\LaporanPilihController@getWilayah')->name('admin.laporan-karyawan.cabang');
      Route::get('admin/laporan-karyawan/{cabang}/wilayah/{wilayah}', 'Admin\LaporanPilihController@getUserCabang')->name('admin.laporan-karyawan.wilayah');

      // ke view pantau karyawan
      Route::get('admin/laporan-pilih-cabang', 'Admin\LaporanPilihController@laporanPilihCabang')->name('admin.laporan-pilih-cabang');
      // api
      Route::get('api/admin/laporan-pilih-cabang/{cabang}', 'Admin\LaporanPilihController@apiCabang')->name('api.admin.laporan-pilih-cabang');

//---acc laporan
  //view Laporan ACC
      Route::get('admin/laporan-acc/{status}', 'Admin\LaporanPilihController@laporanAcc')->name('admin.laporan-acc');
  //post data
      Route::post('admin/{user_id}/laporan-acc-ft-admin-spons/{id}', 'Admin\LaporanAccController@AccLaporanFtAdminSpons')->name('admin.laporan-acc-ft-admin-spons');  
      Route::post('admin/{user_id}/laporan-acc-ft-kacab/{id}', 'Admin\LaporanAccController@AccLaporanFtKacab')->name('admin.laporan-acc-ft-kacab');  
      Route::post('admin/{user_id}/laporan-acc-manajer/{id}', 'Admin\LaporanAccController@AccLaporanManajer')->name('admin.laporan-acc-manajer');  

      // api acc
      Route::get('api/admin/laporan-acc-ftAdminSpons/{status}', 'Admin\ApiLaporanAcc\ApiFtAdminSponsController@apiLaporan')->name('api.admin.laporan-acc-ftAdminSpons');
      Route::get('api/admin/{id}/laporan-acc-ftKacab', 'Admin\ApiLaporanAcc\ApiFtKacabController@apiLaporan')->name('api.admin.laporan-acc-ftKacab');
      Route::get('api/admin/{id}/laporan-acc-manajer', 'Admin\ApiLaporanAcc\ApiManajerController@apiLaporan')->name('api.admin.laporan-acc-manajer');
//---acc deadline laporan
  //view deadline Laporan ACC
      Route::get('admin/laporan-acc-deadline/{status}', 'Admin\LaporanPilihController@laporanAccDeadline')->name('admin.laporan-acc-deadline');
      // api deadline acc
      Route::get('api/admin/laporan-acc-deadline/{status}', 'Admin\ApiLaporanAccDeadline\ApiLaporanDeadlineController@apiLaporan')->name('api.admin.laporan-acc-deadline');

//----cabang
      Route::resource('admin/cabang', 'Admin\CabangController',[
        // 'except' => ['create'],
        'names' => ['index' => 'admin.cabang']
      ]);
      Route::get('api/cabang', 'Admin\CabangController@apiCabang')->name('api.cabang');
//----pengumuman
      Route::resource('admin/pengumuman', 'Admin\PengumumanController',[
        // 'except' => ['create'],
        'names' => ['index' => 'admin.pengumuman']
      ]);
      Route::get('api/pengumuman', 'Admin\PengumumanController@apiPengumuman')->name('api.pengumuman');

//----user
      Route::resource('admin/user', 'Admin\UserController',[
        // 'except' => ['create'],
        'names' => ['index' => 'admin.user']
      ]);
      Route::get('api/user', 'Admin\UserController@apiUser')->name('api.user');
      Route::get('admin/user/cabang/{slug}', 'Admin\UserController@cabang')->name('admin.user.cabang');
      Route::get('admin/user/foto/{id}', 'Admin\UserController@foto')->name('admin.user.foto');
      Route::get('admin/user/password/{id}', 'Admin\UserController@password')->name('admin.user.password');
  // -----------------------------------------------------------------------


//ft_admin----------------**************
  // -----------------------------------------------------------------------
  // Index/Dashboar
  Route::get('ft-admin//{user_id}/index', 'IndexController@index')->name('ft-admin.index');
  //laporan
  Route::resource('ft-admin/laporan', 'FtAdmin\LaporanController',[
    // 'except' => ['create'],
    'names' => ['index' => 'ft-admin.laporan']
  ]);
  // api
  Route::get('api/ft-admin/laporan/{status_laporan}', 'FtAdmin\LaporanController@apiLaporan')->name('api.ft-admin.laporan');
// view laporan
  Route::get('ft-admin/{user_id}/laporan-status/{status}', 'FtAdmin\LaporanController@laporanStatus')->name('ft-admin.laporan-status');

  Route::get('ft-admin/laporan/kirim/{id}', 'FtAdmin\LaporanController@kirimLaporan')->name('ft-admin.laporan.kirim');  
  Route::get('ft-admin/laporan/deadline/{id}', 'FtAdmin\LaporanController@deadlineLaporan')->name('ft-admin.laporan.deadline');
  Route::get('ft-admin/{id_user}/laporan/export-pdf/{id}', 'FtAdmin\LaporanController@exportPdfLaporan')->name('ft-admin.laporan.export-pdf');
  Route::get('ft-admin/laporan-tanggal/{user}', 'FtAdmin\LaporanController@tanggal')->name('ft-admin.laporan.tanggal');
  // -----------------------------------------------------------------------

//ft_sponsorship----------------**************
  // -----------------------------------------------------------------------
  // Index/Dashboar
  Route::get('ft-sponsorship/{user_id}/index', 'IndexController@index')->name('ft-sponsorship.index');
  //laporan
  Route::resource('ft-sponsorship/laporan', 'FtSponsorship\LaporanController',[
    // 'except' => ['create'],
    'names' => ['index' => 'ft-sponsorship.laporan']
  ]);
  // api
  Route::get('api/ft-sponsorship/{user_id}/laporan/{status_laporan}', 'FtSponsorship\LaporanController@apiLaporan')->name('api.ft-sponsorship.laporan');
  // view laporan
  Route::get('ft-sponsorship/{user_id}/laporan-status/{status}', 'FtSponsorship\LaporanController@laporanStatus')->name('ft-sponsorship.laporan-status');

  Route::get('ft-sponsorship/laporan/kirim/{id}', 'FtSponsorship\LaporanController@kirimLaporan')->name('ft-sponsorship.laporan.kirim');  
  Route::get('ft-sponsorship/laporan/deadline/{id}', 'FtSponsorship\LaporanController@deadlineLaporan')->name('ft-sponsorship.laporan.deadline');
  Route::get('ft-sponsorship/{id_user}/laporan/export-pdf/{id}', 'FtSponsorship\LaporanController@exportPdfLaporan')->name('ft-sponsorship.laporan.export-pdf');
  Route::get('ft-sponsorship/laporan-tanggal/{user}', 'FtSponsorship\LaporanController@tanggal')->name('ft-sponsorship.laporan.tanggal');
  // -----------------------------------------------------------------------


//ft_kacab----------------**************
  // -----------------------------------------------------------------------
  // ---Index/Dashboar
      Route::get('ft-kacab/{user_id}/index', 'IndexController@index')->name('ft-kacab.index');
  //---acc laporan
      //view Laporan ACC
      Route::get('ft-kacab/{user_id}/laporan-acc/{status}', 'FtKacab\LaporanAccController@laporanAcc')->name('ft-Kacab.laporan-acc');

      // api acc
      Route::get('api/ft-kacab/{user_id}/laporan-acc-ftAdminSpons/{status}', 'FtKacab\LaporanAccController@apiLaporan')->name('api.ft-kacab.laporan-acc-ftAdminSpons');
  // -----------------------------------------------------------------------


//Manajer----------------**************
  // -----------------------------------------------------------------------
  // ---Index/Dashboar
      Route::get('manajer/{user_id}/index', 'IndexController@index')->name('manajer.index');
  //---acc laporan
      //view Laporan ACC
      Route::get('manajer/{user_id}/laporan-acc/{status}', 'Manajer\LaporanAccController@laporanAcc')->name('manajer.laporan-acc');

      // api acc
      Route::get('api/manajer/{user_id}/laporan-acc/{status}', 'Manajer\LaporanAccController@apiLaporan')->name('api.manajer.laporan-acc');
  // -----------------------------------------------------------------------


//Direktur----------------**************
  // -----------------------------------------------------------------------
  // ---Index/Dashboar
      Route::get('direktur/{user_id}/index', 'IndexController@index')->name('direktur.index');
  //---acc laporan
      //view Laporan ACC
      Route::get('direktur/{user_id}/laporan-acc/{status}', 'Direktur\LaporanAccController@laporanAcc')->name('direktur.laporan-acc');

      // api acc
      Route::get('api/direktur/{user_id}/laporan-acc/{status}', 'Direktur\LaporanAccController@apiLaporan')->name('api.direktur.laporan-acc');
  // -----------------------------------------------------------------------
