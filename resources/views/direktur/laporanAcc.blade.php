
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
                  <div class="small-box bg-default" style="background-color: #E7F73A">
                    <div class="inner">
                      <h3>{{ $ft_admin_direktur }}</h3>
                      <p>Laporan FT Admin</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                      <a href="{{ route('direktur.laporan-acc',[Auth::user()->id,'ft_admin']) }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <div class="small-box bg-default" style="background-color: #EFE32C">
                    <div class="inner">
                       <h3>{{ $ft_sponsorship_direktur }}</h3>
                       <p>Laporan FT Sponsorsip</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                      <a href="{{ route('direktur.laporan-acc',[Auth::user()->id,'ft_sponsorship']) }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <div class="small-box bg-default" style="background-color: #F8CB5E">
                    <div class="inner">
                       <h3>{{ $ft_kacab_direktur }}</h3>
                       <p>Laporan FT Kepala Cabang</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle"></i>
                    </div>
                      <a href="{{ route('direktur.laporan-acc',[Auth::user()->id,'ft_kacab']) }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                 
                <div class="col-lg-3 col-xs-6">
                  <div class="small-box bg-default" style="background-color: #42F052">
                    <div class="inner">
                       <h3>{{ $manajer_direktur }}</h3>
                       <p>Laporan Manajer</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle-o"></i>
                    </div>
                      <a href="{{ route('direktur.laporan-acc',[Auth::user()->id,'manajer']) }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
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
        <i style="font-size: 20px">Kelola Persetujuan Laporan 
          <u>
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
              @foreach ($cabang as $cab)
                <li ><a data-toggle="tab" href="#form-table" onclick="apiLaporan('{{$cab->nama }}')">{{$cab->nama }}</a></li>
              @endforeach

              <li class="active"><a data-toggle="tab" href="#form-table" onclick="apiLaporan('')">All</a></li>
              <li class="pull-left header"><i class="fa fa-hourglass-half"></i>Status User</li>
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
   var table = $('#form-table').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('api.direktur.laporan-acc',[$user->id,$status]) }}",
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

function apiLaporan(status){
  table.search( status ).draw();
}


 $(function () {

     $("#direktur_Laporan").attr("class","active");
       if ('{{ $laporan_status }}' == 'acc_laporan'){
         $("#direktur_acc_laporan").attr("class","active");
          if('{{ $status }}' == 'ft_admin') $("#direktur_acc_laporan_ft_admin").attr("class","active");
          else if('{{ $status }}' == 'ft_sponsorship') $("#direktur_acc_laporan_ft_sponsorship").attr("class","active");
          else if('{{ $status }}' == 'ft_kacab') $("#direktur_acc_laporan_ft_kacab").attr("class","active");
          else if('{{ $status }}' == 'manajer') $("#direktur_acc_laporan_manajer").attr("class","active");
      }
    });


  </script>

@include('admin/partial/_adminLaporanAcc_script') 


@endsection
