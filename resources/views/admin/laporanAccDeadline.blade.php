
{{-- calling layouts \ app.blade.php --}}
@extends('layouts.master')


@section('content-header')
{{--         <h1>
        Dashboard
        <small>Control panel</small>
      </h1> --}}
     {{--  <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kelola Form</li>
      </ol>
      <br> --}}
@endsection

@section('content-body')

<div class="row" >
  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="box box-success">
    <div class="box-title">
      <div class="panel panel-default">
      <div class="panel-heading">
         <i style="font-size: 20px">Informasi Tambahan</i>
          
        <div class="pull-right box-tools">
                <button type="button" class="btn btn-basic btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">  <i class="fa fa-minus "></i></button>
              </div>
      </div>
    </div>
    </div>        
    <div class="box-body">
      <div class="panel-body">
        <div class="col-lg-12 ">
                          <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #E7F73A">
                    <div class="inner">
                     <h3>{{ $ft_admin }}</h3>
                     <p>permintaan perpanjangan</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                      <a href="{{ route('admin.laporan-acc-deadline','ft_admin')}}" class="small-box-footer">DL Laporan Ft Admin <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #EFE32C">
                    <div class="inner">
                     <h3>{{ $ft_sponsorship }}</h3>
                     <p>permintaan perpanjangan</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                      <a href="{{ route('admin.laporan-acc-deadline','ft_sponsorship')}}" class="small-box-footer">DL Laporan Ft Sponsorship <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #F8CB5E">
                    <div class="inner">
                     <h3>{{ $ft_kacab}}</h3>
                     <p>permintaan perpanjangan</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle"></i>
                    </div>
                      <a href="{{ route('admin.laporan-acc-deadline','ft_kacab')}}" class="small-box-footer">DL Laporan Ft Kepala Cabang <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                   

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #42F052">
                    <div class="inner">
                     <h3>{{ $manajer }}</h3>
                     <p>permintaan perpanjangan</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle-o"></i>
                    </div>
                      <a href="{{ route('admin.laporan-acc-deadline','manajer')}}" class="small-box-footer">DL Laporan Manajer <i class="fa fa-arrow-circle-right"></i></a>

                  </div>
                  </div>
                <div class="col-lg-12 col-xs-12">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #AAAEAA">
                      <a href="{{ route('admin.laporan-pilih-cabang') }}" class="small-box-footer">Pantau Karyawan <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>   
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<div class="row" >
  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="box box-success">
    <div class="box-title">
      <div class="panel panel-default">
      <div class="panel-heading">
         <i style="font-size: 20px">Kelola Perpanjangan Deadline Laporan 
          <u >
            @if ($status == 'ft_admin')
                  FT Admin
              @elseif ($status == 'ft_sponsorship')
                  FT Sponsorship
              @elseif ($status == 'ft_kacab')
                  FT Kepala Cabang                        
              @elseif ($status == 'manajer')
                  Manajer                        
              @elseif ($status == 'direktur')
                  Direktur                        
              @endif
          </u></i>
          
        <div class="pull-right box-tools">
                <button type="button" class="btn btn-basic btn-sm" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus "></i></button>
              </div>
      </div>
    </div>
    </div>        
    <div class="box-body">
    
      <div class="panel-body">
           <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right" style="background-color: #B3E6B9">
              @if ($status == 'ft_admin' || $status == 'ft_sponsorship'||$status == 'ft_kacab')
                @foreach ($cabang as $cab)
                  <li><a data-toggle="tab" href="#form-table" onclick="apiLaporan('{{ $cab->slug }}')">{{ $cab->nama }}</a></li>
                @endforeach
              @endif
              <li class="active"><a data-toggle="tab" href="#form-table" onclick="apiLaporan('')">All</a></li>
              <li class="pull-left header"><i class="fa fa-hourglass-half"></i> <u>Cabang</u> </li>
            </ul>
          </div>

        <div class="table-responsive tab-content">
            <table id="form-table"  class="display responsive nowrap table table-striped  table-responsive table-bordered "  width="100%" >
                        <thead >
                            <tr class="bg-green color-palette">
                                <th width="5%">No</th>
                                <th width="25%">Nama</th>
                                <th  width="20%">Tanggal Laporan</th>
                                <th width="10%">Status</th>
                                <th  width="10%">Cabang</th>
                                <th  width="10%">wilayah</th>
                                <th  width="20%">Acc Perpanjang Deadline</th>
                            </tr>
                        </thead>

                        <tbody ></tbody>
           </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>



{{-- @include('admin/partial/_adminLaporanAcc_modal') --}}
{{-- form model acc --}}
<div class="modal fade" id="modal-form-acc" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-acc" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div id="modal-header-acc" class=" modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title text-center" id="modal-form-acc-title" >hhh</h3>
                </div>
  {{-- body --}}
                <div class="modal-body">
                    <input type="hidden" id="id_user" name="id_user">
                    <input type="hidden" id="id" name="id">
                  <span id="form-profil">
                      <div class="row">
                      <div class="col-md-2" align="center">
                        <br><br>
                          <img src="" alt="belum ada foto" width="100%" id="deadline-form-profil-foto">
                      </div>
                      <div class="col-md-10">
                        <table border="0" class="table table-responsive table-hover table-striped">
                          <tr>
                            <td width="2%"></td>
                            <td width="20%" >Nama</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="deadline-form-profil-nama"></td>
                          </tr>
                          <tr>
                            <td width="2%"></td>
                            <td width="20%" >No Hp</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="deadline-form-profil-no-hp"></td>
                          </tr> 
                          <tr>
                            <td width="2%"></td>
                            <td width="20%" >Email</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="deadline-form-profil-email"></td>
                          </tr> 
                          <tr>
                            <td width="2%"></td>
                            <td width="20%" >Status</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="deadline-form-profil-status"></td>
                          </tr> 
                          <tr>
                            <td width="2%" ></td>
                            <td width="20%" >Cabang</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="deadline-form-profil-cabang"></td>
                          </tr>  
                           <tr>
                            <td width="2%"></td>
                            <td width="20%" >Wilayah</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="deadline-form-profil-wilayah"></td>
                          </tr>      
                        </table>
                      </div>
                    </div>
              </span>
           </div>
{{-- footer --}}
          <div  id="modal-footer-acc" class=" modal-footer">
              <button type="submit" class="btn btn-success" id="button-acc-submit"">Submit</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>            
          </div>
        </form>
      </div>
    </div>
</div>
    

@endsection

@section('script')

<script type="text/javascript">
   var table = $('#form-table').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('api.admin.laporan-acc-deadline',[$status]) }}",
                columns: [
                  {data: 'nomor', name: 'nomor'},
                  {data: 'nama', name: 'nama'},
                  {data: 'created', name: 'created'},
                  {data: 'status', name: 'status'},
                  {data: 'cabang', name: 'cabang'},
                  {data: 'wilayah', name: 'wilayah'},
                  {data: 'expired', name: 'expired', orderable: false, searchable: false}
                ]
              });     
   
function apiLaporan(status){
  table.search( status ).draw();
}


 $(function () {

     $("#adminLaporan").attr("class","active");
       if ('{{ $laporan_status }}' == 'dl_laporan'){
         $("#dl_laporan").attr("class","active");
          if('{{ $status }}' == 'ft_admin') $("#dl_laporan_ft_admin").attr("class","active");
          else if('{{ $status }}' == 'ft_sponsorship') $("#dl_laporan_ft_sponsorship").attr("class","active");
          else if('{{ $status }}' == 'ft_kacab') $("#dl_laporan_ft_kacab").attr("class","active");
          else if('{{ $status }}' == 'manajer') $("#dl_laporan_manajer").attr("class","active");
      }
    });

  function deadlineLaporan(user_id,id){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    swal({
        title: 'Apakah anda yakin?',
        text: "ingin perpanjang deadline laporan",
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Perpanjang deadline'
    }).then(function () {
        $.ajax({
            url: "{{ url('admin/laporan/') }}" + '/'+user_id +"/deadline-acc/"+ id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function(){
                     $("body").css("padding",'0px');
                     swal({
                          title: 'Sedang Memuat...',
                          onOpen: () => {
                            swal.showLoading()
                          }
                        }).catch(swal.noop);
                    },
            success : function(data) {
                table.ajax.reload();
                 swal({
                    title: data.title,
                    text: data.message,
                    type: data.type,
                    timer: data.timer,
                }).catch(swal.noop);
            },
            error : function () {
                swal({
                      title: 'Oops...',
                      text: 'gagal, meminta perpanjangan.\n Silahkan refresh page',
                      type: 'error',
                      timer: 5000
                  }).catch(swal.noop);
            }
        });
    }).catch(swal.noop);
  }
function viewProfil(id){

  $('#modal-header-acc').removeClass('modal-header-acc-kacab');
  $('#modal-footer-acc').removeClass('modal-footer-acc-kacab'); 
  $('#modal-header-acc').removeClass('modal-header-acc-manajer');
  $('#modal-footer-acc').removeClass('modal-footer-acc-manajer');
  $('#modal-header-acc').removeClass('modal-header-acc-direktur');
  $('#modal-header-acc').removeClass('modal-header-acc-direktur');

  $('#modal-header-acc').addClass('modal-header-acc-profil'); 
  $('#modal-footer-acc').addClass('modal-footer-acc-profil'); 

  $('#modal-form-acc').modal('show');
  $('#form-profil').show();
  $('#modal-form-acc-title').text('View Profil');

  $('#form-persetujuan').hide();
  $('#button-acc-submit').hide();
   $.ajax({
      url: "{{ url('admin/laporan/user') }}" + '/' + id,
      type: "GET",
      dataType: "JSON",
       beforeSend: function(){
           $("body").css("padding",'0px');
           swal({
              title: 'Sedang Memuat...',
               timer: 500,
              onOpen: () => {
                swal.showLoading()
              }
            }).catch(swal.noop);
        },
      success: function(data) {
           if(data.foto != '-') $('#deadline-form-profil-foto').attr('src',data.foto); 
           $('#deadline-form-profil-nama').text(data.nama); 
           $('#deadline-form-profil-no-hp').text(data.no_hp); 
           $('#deadline-form-profil-email').text(data.email); 
           $('#deadline-form-profil-status').text(data.status); 
           $('#deadline-form-profil-cabang').text(data.cabang); 
           $('#deadline-form-profil-wilayah').text(data.wilayah); 
        
      },
      error : function() {
          alert("Nothing Data");
      }
    });
}
  </script>

{{-- @include('admin/partial/_adminLaporanAcc_script')  --}}


@endsection
