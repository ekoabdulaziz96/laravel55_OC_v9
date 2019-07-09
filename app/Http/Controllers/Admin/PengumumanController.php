<?php

namespace App\Http\Controllers\Admin;

use App\Pengumuman;
use Validator;
use Illuminate\Http\Request;
use Mockery\Exception;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pengumuman');
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $input = $request->except(['_wysihtml5_mode','id']);
          $rules = array(
          'status' => 'required',
          'isi' => 'required',
        );
          $validator = Validator::make( $input, $rules);
            if ($validator->fails()){
                  return response()->json([
                    'success' => true,
                    'message' => 'Silahkan lengkapi form yg wajib diisi',
                    'title'=> 'Mohon Diperhatikan!',
                    'type'=> 'warning',
                    'timer'=> 3000
                ]);
        }else if(Pengumuman::where('status',$request->status)->exists() ){
           return response()->json([
                'success' => true,
                'message' => 'maaf, pengumuman untuk status "'.$request->status.'" sudah ada. Silahkan input dengan status berbeda',
                'title'=> 'Gagal Menambahkan!',
                'type'=> 'warning',
                'timer'=> 5000
            ]);
        }else  {
            Pengumuman::create($input);

            return response()->json([
                'success' => true,
                'message' => 'Data Pengumuman baru berhasil ditambahkan',
                'title'=> 'Sukses Menambahkan!',
                'type'=> 'success',
                'timer'=> 2500
            ]);
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $pengumuman = pengumuman::findOrFail($id);
       // console.log($pengumuman);
        return $pengumuman;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         if(Pengumuman::where('status',$request->status)->where('id','<>',$id)->exists()){
           return response()->json([
                'success' => true,
                'message' => 'maaf, pengumuman untuk status "'.$request->status.'" sudah ada. Silahkan input dengan status berbeda',
                'title'=> 'Gagal Menambahkan!',
                'type'=> 'warning',
                'timer'=> 5000
            ]);
        }else {
            $input = $request->except(['_wysihtml5_mode','id']);
            $pengumuman = Pengumuman::findOrFail($id);
            $pengumuman->update($input);

            return response()->json([
                'success' => true,
                'message' => 'Data pengumuman berhasil diperbarui',
                'title'=> 'Sukses Memperbarui!',
                'type'=> 'success',
                'timer'=> 2500
            ]);    
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Pengumuman::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data Pengumuman berhasil dihapus',
            'title'=> 'Sukses Menghapus!',
            'type'=> 'success',
            'timer'=> 2500
        ]);
    }
    public function apiPengumuman(){
        $pengumuman = Pengumuman::all();

        return Datatables::of($pengumuman)
            ->addColumn('nomor', function(){
                    global $nomor;
                    return ++$nomor;
            })->addColumn('isi_pengumuman', function($pengumuman){
                    return substr($pengumuman->isi,0,9999);
            })->addColumn('status_user', function($pengumuman){
                    if ($pengumuman->status == 'ft_admin'){
                        return 'FT Admin';
                    }else if ($pengumuman->status == 'ft_sponsorship'){
                        return 'FT Sponsorship';
                    }else if ($pengumuman->status == 'ft_kacab'){
                        return 'FT Kepala Cabang';                        
                    }else if ($pengumuman->status == 'manajer'){
                        return 'Manajer';                        
                    }else if ($pengumuman->status == 'direktur'){
                        return 'Direktur';                        
                    } 
            }) 
           ->addColumn('action', function($pengumuman){
            
            return '<div align="center" >' .
                '<a href="#" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Detail"><i class="glyphicon glyphicon-eye-open"></i></a> ' .
                '<a onclick="editPengumuman('. $pengumuman->id .')" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a> ' .
               '<a onclick="deletePengumuman('. $pengumuman->id .')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="glyphicon glyphicon-trash"></i></a>'.
               '</div>';      

            })
            ->rawColumns(['nomor', 'action','isi_pengumuman'])->make(true);
    }
}
