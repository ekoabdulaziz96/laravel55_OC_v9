
{{-- calling layouts \ app.blade.php --}}
@extends('layouts.master')

@section('content-header')
        <h1>
        Dashboard
        <small>Super Admin</small>
      </h1>
{{--       <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
      <br> --}}
@endsection

@section('content-body')
{{-- User --}}
<div class="row" >
  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="box box-success">
    <div class="box-title">
      <div class="panel panel-default">
      <div class="panel-heading">
         <i style="font-size: 20px">Karyawan yang Terdaftar</i>
          
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
                     <p>Ft Admin</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                      <a href="{{ route('admin.laporan-pilih-cabang') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #EFE32C">
                    <div class="inner">
                     <h3>{{ $ft_sponsorship }}</h3>
                     <p>Ft Sponsorship </p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                      <a href="{{ route('admin.laporan-pilih-cabang') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #F8CB5E">
                    <div class="inner">
                     <h3>{{ $ft_kacab}}</h3>
                     <p>Ft Kepala Cabang</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle"></i>
                    </div>
                      <a href="{{ route('admin.laporan-pilih-cabang') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>                   

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-default" style="background-color: #42F052">
                    <div class="inner">
                     <h3>{{ $manajer }}</h3>
                     <p>Manajer</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle-o"></i>
                    </div>
                      <a href="{{ route('admin.laporan-pilih-cabang') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>

                  </div>
                  </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
{{-- Acc Laporan --}}
<div class="row" >
  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="box box-success">
    <div class="box-title">
      <div class="panel panel-default">
      <div class="panel-heading">
         <i style="font-size: 20px">Persetujuan Laporan</i>
          
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
                  <div class="small-box bg-default" style="background-color: #B8BDB8">
                      <a href="{{ route('admin.laporan-pilih-cabang') }}" class="small-box-footer">Pantau Karyawan <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>   
        </div>
      </div>
    </div>
  </div>
</div>
</div>
{{-- Permintaan Perpanjangan deadline laporan --}}
<div class="row" >
  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="box box-success">
    <div class="box-title">
      <div class="panel panel-default">
      <div class="panel-heading">
         <i style="font-size: 20px">Permintaan Perpanjangan Deadline Laporan</i>
          
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
                     <h3>{{ $ft_admin_dl }}</h3>
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
                     <h3>{{ $ft_sponsorship_dl }}</h3>
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
                     <h3>{{ $ft_kacab_dl}}</h3>
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
                     <h3>{{ $manajer_dl }}</h3>
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
                  <div class="small-box bg-default" style="background-color: #B8BDB8">
                      <a href="{{ route('admin.laporan-pilih-cabang') }}" class="small-box-footer">Pantau Karyawan <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>   
        </div>
      </div>
    </div>
  </div>
</div>
</div>
              
@endsection


@section('script')
<script>
  $("#adminDashboard").attr("class","active");

</script>

@endsection