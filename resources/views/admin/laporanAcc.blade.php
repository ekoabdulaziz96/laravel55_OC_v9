
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
                      <p>Permintaan Persetujuan</p>
                        <h6>{{ $ft_admin_direktur }} Direktur</h6>
                        <h6>{{ $ft_admin_manajer }} Manajer</h6>
                        <h6>{{ $ft_admin_ft_kacab }}  Kepala Cabang</h6>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                      <a href="{{ route('admin.laporan-acc','ft_admin')}}" class="small-box-footer">Laporan Ft Admin <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #EFE32C">
                    <div class="inner">
                      <p>Permintaan Persetujuan</p>
                        <h6>{{ $ft_sponsorship_direktur }} Direktur</h6>
                        <h6>{{ $ft_sponsorship_manajer }} Manajer</h6>
                        <h6>{{ $ft_sponsorship_ft_kacab }}  Kepala Cabang</h6>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                      <a href="{{ route('admin.laporan-acc','ft_sponsorship')}}" class="small-box-footer">Laporan Ft Sponsorship <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #F8CB5E">
                    <div class="inner">
                      <p>Permintaan Persetujuan</p>
                        <h6>{{ $ft_kacab_direktur }} Direktur</h6>
                        <h6>{{ $ft_kacab_manajer }} Manajer</h6>
                        <h6>-</h6>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle"></i>
                    </div>
                      <a href="{{ route('admin.laporan-acc','ft_kacab')}}" class="small-box-footer">Laporan Ft Kepala Cabang <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                   

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #42F052">
                    <div class="inner">
                      <p>Permintaan Persetujuan</p>
                        <h6>{{ $manajer_direktur }} Direktur</h6>
                        <h6>-</h6>
                        <h6>-</h6>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle-o"></i>
                    </div>
                      <a href="{{ route('admin.laporan-acc','manajer')}}" class="small-box-footer">Laporan Manajer <i class="fa fa-arrow-circle-right"></i></a>

                  </div>
                </div>
                <div class="col-lg-12 col-xs-12">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #B9C3BA">
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
         <i style="font-size: 20px">Kelola Persetujuan Laporan <u>{{ $status }}</u></i>
          
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
              <li ><a data-toggle="tab" href="#form-table" onclick="apiLaporan('acc_Direktur')">Acc Direktur</a></li>
              @if ($status == 'ft_admin' || $status == 'ft_sponsorship'||$status == 'ft_kacab')
                <li><a data-toggle="tab" href="#form-table" onclick="apiLaporan('acc_Manajer')">Acc Manajer</a></li>
              @endif
              @if ($status == 'ft_admin' || $status == 'ft_sponsorship')
                <li><a data-toggle="tab" href="#form-table" onclick="apiLaporan('acc_Kepala_Cabang')">Acc Kepala Cabang</a></li>
              @endif
              <li class="active"><a data-toggle="tab" href="#form-table" onclick="apiLaporan('')">All</a></li>
              <li class="pull-left header"><i class="fa fa-hourglass-half"></i>Permintaan Acc Laporan </li>
            </ul>
          </div>

        <div class="table-responsive tab-content">
            <table id="form-table"  class="display responsive nowrap table table-striped  table-responsive table-bordered "  width="100%" >
                        <thead >
                            <tr class="bg-green color-palette">
                                <th width="5%">No</th>
                                <th width="25%">Nama</th>
                                <th  width="15%">Tanggal Laporan</th>
                                <th width="10%">Status</th>
                                <th  width="10%">Cabang</th>
                                <th  width="10%">wilayah</th>
                                <th  width="15%">Permintaan Acc</th>
                                <th  width="10%">Acc Laporan</th>
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



@include('admin/partial/_adminLaporanAcc_modal')
@endsection

@section('script')

<script type="text/javascript">
@if ($status == 'ft_admin' || $status == 'ft_sponsorship')
   var table = $('#form-table').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('api.admin.laporan-acc-ftAdminSpons',[$status]) }}",
                columns: [
                  {data: 'nomor', name: 'nomor'},
                  {data: 'nama', name: 'nama'},
                  {data: 'created', name: 'created'},
                  {data: 'status', name: 'status'},
                  {data: 'cabang', name: 'cabang'},
                  {data: 'wilayah', name: 'wilayah'},
                  {data: 'acc', name: 'acc'},
                  {data: 'acc_laporan', name: 'acc_laporan', orderable: false, searchable: false}
                ]
              });     
@elseif($status == 'ft_kacab')
    var table = $('#form-table').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('api.admin.laporan-acc-ftKacab',[$status]) }}",
                columns: [
                  {data: 'nomor', name: 'nomor'},
                  {data: 'nama', name: 'nama'},
                  {data: 'created', name: 'created'},
                  {data: 'status', name: 'status'},
                  {data: 'cabang', name: 'cabang'},
                  {data: 'wilayah', name: 'wilayah'},
                  {data: 'acc', name: 'acc'},
                  {data: 'acc_laporan', name: 'acc_laporan', orderable: false, searchable: false}
                ]
              });     
@elseif($status == 'manajer')
    var table = $('#form-table').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('api.admin.laporan-acc-manajer',[$status]) }}",
                columns: [
                  {data: 'nomor', name: 'nomor'},
                  {data: 'nama', name: 'nama'},
                  {data: 'created', name: 'created'},
                  {data: 'status', name: 'status'},
                  {data: 'cabang', name: 'cabang'},
                  {data: 'wilayah', name: 'wilayah'},
                  {data: 'acc', name: 'acc'},
                  {data: 'acc_laporan', name: 'acc_laporan', orderable: false, searchable: false}
                ]
              });     
@endif   
   
function apiLaporan(status){
  table.search( status ).draw();
}


 $(function () {

     $("#adminLaporan").attr("class","active");
       if ('{{ $laporan_status }}' == 'acc_laporan'){
         $("#acc_laporan").attr("class","active");
          if('{{ $status }}' == 'ft_admin') $("#acc_laporan_ft_admin").attr("class","active");
          else if('{{ $status }}' == 'ft_sponsorship') $("#acc_laporan_ft_sponsorship").attr("class","active");
          else if('{{ $status }}' == 'ft_kacab') $("#acc_laporan_ft_kacab").attr("class","active");
          else if('{{ $status }}' == 'manajer') $("#acc_laporan_manajer").attr("class","active");
      }
    });


  </script>

@include('admin/partial/_adminLaporanAcc_script') 


@endsection
