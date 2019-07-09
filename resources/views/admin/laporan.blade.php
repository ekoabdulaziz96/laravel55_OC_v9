
{{-- calling layouts \ app.blade.php --}}
@extends('layouts.master')

@section('stylesheet')
<!-- fullCalendar -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.css')}}">
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/fullcalendar/dist/fullcalendar.print.min.css')}}" media="print">
@endsection

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
<style type="text/css">
  #calendar {
    max-width: 80%;
    max-height: 100%;
    position: relative;
    margin-left: 10%;
    margin-right: : 10%;
  }
</style>
<div>
<a href="{{ route('admin.laporan-pilih-cabang') }}" type="button" class="btn btn-success pull-right"><i class="fa fa-arrow-circle-left"> Kembali</i></a>
  
</div><br><br>

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
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right" style="background-color: #B3E6B9">
              <li class="active"><a href="#dashboard_user" data-toggle="tab">Dashboard</a></li>
              <li ><a href="#profil" data-toggle="tab">Profil</a></li>
              <li><a href="#calendar" data-toggle="tab">Calendar</a></li>
              <li class="pull-left header"><i class="fa fa-bell-o"></i> Papan Informasi</li>
            </ul>
            <div class="tab-content ">
             {{-- profil --}}
              <div class="chart tab-pane " id="profil" style="position: relative; height: 300px;padding: 1.5%">
                <div class="col-md-2" align="center">
                  <br><br>
                  @if ($user->foto != '-')
                    <img src="{{ asset($user->foto) }}" alt="belum ada foto" width="100%">
                  @else 
                    <img src="" alt="belum ada foto" width="100%">
                  @endif
                </div>
                <div class="col-md-10">
                  <table border="0" class="table table-responsive table-hover table-striped">
                    <tr>
                      <td width="2%"></td>
                      <td width="20%" >Nama</td>
                      <td width="3%" align="center">:</td>
                      <td width="75%">{{$user->nama }}</td>
                    </tr>
                    <tr>
                      <td width="2%"></td>
                      <td width="20%" >No Hp</td>
                      <td width="3%" align="center">:</td>
                      <td width="75%">{{$user->no_hp }}</td>
                    </tr> 
                    <tr>
                      <td width="2%"></td>
                      <td width="20%" >Email</td>
                      <td width="3%" align="center">:</td>
                      <td width="75%">{{$user->email }}</td>
                    </tr> 
                    <tr>
                      <td width="2%"></td>
                      <td width="20%" >Status</td>
                      <td width="3%" align="center">:</td>
                      <td width="75%">{{$user->status }}</td>
                    </tr> 
                    <tr>
                      <td width="2%" ></td>
                      <td width="20%" >Cabang</td>
                      <td width="3%" align="center">:</td>
                      <td width="75%">{{$user->cabang }}</td>
                    </tr>  
                     <tr>
                      <td width="2%"></td>
                      <td width="20%" >Wilayah</td>
                      <td width="3%" align="center">:</td>
                      <td width="75%">{{$user->wilayah }}</td>
                    </tr>      
                  </table>
                </div>
              </div>
              {{-- calendar --}}
              <div class="chart tab-pane" id="calendar" style="position: relative;">
                    <div class="col-md-8" align="center">
                          <div id="calendar" align="center"></div>
                    </div>
                    <br>
              </div>              
              {{-- dashboard user --}}
              <div class="chart tab-pane active" id="dashboard_user" style="position: relative;">
                    {{-- <div class="col-md-8" align="center"> --}}
                            <div class="col-lg-12 col-xs-12">
                              <!-- small box -->
                              <div class="small-box bg-default" style="background-color: #E38686">
                                <div class="inner">
                                  <h3>{{ $laporan_kedaluwarsa }}</h3>

                                  <p>Laporan Kedaluwarsa </p>
                                  <h6>Masa aktif pengerjaan dan pelaporan laporan habis. Aktifitas untuk melakuakn perbaikan dan pengiriman laporan tidak bisa dilakukan. <u>Segera lakukan permintaan perpanjangan laporan</u></h6>
                                </div>
                                <div class="icon">
                                  <i class="fa fa-calendar-times-o"></i>
                                </div>
                                <a href="#form-table" onclick="apiLaporan('kedaluwarsa')" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                              </div>
                            </div>        

                            <div class="col-lg-3 col-xs-6">
                              <!-- small box -->
                              <div class="small-box bg-default" style="background-color: #C1C0C0">
                                <div class="inner">
                                  <h3>{{ $laporan_baru }}</h3>

                                  <p>Laporan Baru</p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-ios-paper-outline"></i>
                                </div>
                                <a href="#form-table" onclick="apiLaporan('baru')" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                              </div>
                            </div>

                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                              <!-- small box -->
                              <div class="small-box bg-default" style="background-color: #79C7BA">
                                <div class="inner">
                                  <h3>{{ $laporan_proses }}</h3>

                                  <p>Laporan Proses</p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-ios-paperplane-outline"></i>
                                </div>
                                <a href="#form-table" onclick="apiLaporan('proses')" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                              </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                              <!-- small box -->
                              <div class="small-box bg-default" style="background-color: #E8DF54">
                                <div class="inner">
                                 <h3>{{ $laporan_perbaikan }}</h3>

                                  <p>Laporan Perbaikan</p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-edit"></i>
                                </div>
                                <a href="#form-table" onclick="apiLaporan('perbaikan')" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                              </div>
                            </div>
                            <!-- ./col -->

                             <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                              <!-- small box -->
                              <div class="small-box bg-default" style="background-color: #5FDA6A">
                                <div class="inner">
                                  <h3>{{ $laporan_disetujui}}</h3>

                                  <p>Laporan Disetujui</p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-android-checkmark-circle"></i>
                                </div>
                                <a href="#form-table" onclick="apiLaporan('disetujui')" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                              </div>
                            </div>
                    {{-- </div> --}}
              </div>

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
         <i style="font-size: 20px">Kelola Form <u >{{ $user->status }}</u></i>
          
        <div class="pull-right box-tools">
                <button type="button" class="btn btn-basic btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus "></i>
                </button>
        </div>
      </div>
    </div>
    </div>        
    <div class="box-body">
    
      <div class="panel-body">
           <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right" style="background-color: #B3E6B9">
              <li ><a data-toggle="tab" href="#form-table" onclick="apiLaporan('kedaluwarsa')">Kedaluwarsa</a></li>
              <li ><a data-toggle="tab" href="#form-table" onclick="apiLaporan('disetujui')">Disetujui</a></li>
              <li><a data-toggle="tab" href="#form-table" onclick="apiLaporan('perbaikan')">Perbaikan</a></li>
              <li><a data-toggle="tab" href="#form-table" onclick="apiLaporan('proses')">Proses</a></li>
              <li><a data-toggle="tab" href="#form-table" onclick="apiLaporan('baru')">Baru</a></li>
              <li class="active"><a data-toggle="tab" href="#form-table" onclick="apiLaporan('')">All</a></li>
              <li class="pull-left header"><i class="fa fa-hourglass-half"></i> Status Laporan </li>
            </ul>
          </div>

        <div class="table-responsive tab-content">
            <table id="form-table"  class="display responsive nowrap table table-striped  table-responsive table-bordered "  width="100%" >
                        <thead >
                            <tr class="bg-green color-palette">
                                <th width="5%">No</th>
                                <th width="18%">Tanggal Laporan</th>
                                <th  width="17%">Kedaluwarsa</th>
                                <th width="10%">Kehadiran</th>
                                <th  width="10%">Status Laporan</th>
                                <th  width="10%">Kirim</th>
                                <th  width="15%">Acc Laporan</th>
                                <th class="text-center "  width="15%" >
                                  {{-- @if ($status_laporan == 'baru') --}}
                                     <a onclick="addLaporan()" class="btn btn-success btn-sm" style="width: 100% ;background-color: #14CA77" data-toggle="tooltip" data-placement="top" title="Tambah"><i class="glyphicon glyphicon-plus"></i></a>
                                  {{-- @else --}}
                                     {{-- <a href="#" class="btn btn-default btn-sm" style="width: 100%" data-toggle="tooltip" data-placement="top" title="Tambah"><i class="glyphicon glyphicon-plus"></i></a> --}}
                                  {{-- @endif --}}
                        
                                </th>
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



@include('admin/partial/_adminLaporan_modal')
   
@endsection

@section('script')
 <!-- fullCalendar -->
<script src="{{ asset('AdminLTE/bower_components/moment/moment.js')}}"></script>
<script src="{{ asset('AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script type="text/javascript">
@if ($user->status == 'ft_admin' || $user->status == 'ft_sponsorship')
   var table = $('#form-table').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('api.admin.laporan-ftAdminSpons',[$user->id]) }}",
                columns: [
                  {data: 'nomor', name: 'nomor'},
                  {data: 'created', name: 'created'},
                  {data: 'expired', name: 'expired'},
                  {data: 'kehadiran', name: 'kehadiran'},
                  {data: 'status_laporan', name: 'status_laporan'},
                  {data: 'kirim', name: 'kirim'},
                  {data: 'acc_laporan', name: 'acc_laporan'},
                  {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
              });     
@elseif($user->status == 'ft_kacab')
   var table = $('#form-table').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('api.admin.laporan-ftKacab',[$user->id]) }}",
                columns: [
                  {data: 'nomor', name: 'nomor'},
                  {data: 'created', name: 'created'},
                  {data: 'expired', name: 'expired'},
                  {data: 'kehadiran', name: 'kehadiran'},
                  {data: 'status_laporan', name: 'status_laporan'},
                  {data: 'kirim', name: 'kirim'},
                  {data: 'acc_laporan', name: 'acc_laporan'},
                  {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
              });
@elseif($user->status == 'manajer')
   var table = $('#form-table').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('api.admin.laporan-manajer',[$user->id]) }}",
                columns: [
                  {data: 'nomor', name: 'nomor'},
                  {data: 'created', name: 'created'},
                  {data: 'expired', name: 'expired'},
                  {data: 'kehadiran', name: 'kehadiran'},
                  {data: 'status_laporan', name: 'status_laporan'},
                  {data: 'kirim', name: 'kirim'},
                  {data: 'acc_laporan', name: 'acc_laporan'},
                  {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
              });
@endif   
   
function apiLaporan(status){
  table.search( status ).draw();
}


 $(function () {
 @foreach ($form_all as $form)
  @if ($form->tipe == 'file')
    $('#{{$form->slug}}').bind('change', function() {
      if (this.files[0].size >= 2097152){
        alert('ukuran file maks 2 MB, silahkan gunakan file dengan ukuran kurang dr 2 MB');
        $('#{{$form->slug}}').val('');
      }
    });
  @endif
@endforeach
     $("#adminLaporan").attr("class","active");
      {{-- if ('{{ $laporan_status }}' == 'pantau_individual'){ --}}
        $("#acc_laporan_karyawan").attr("class","active");
      // }

    @php
      use Carbon\Carbon;
    @endphp

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      aspectRatio: 2,
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : ''
      },
      buttonText: {
        today: 'today',
        // month: 'month',
        // week : 'week',
        // day  : 'day'
      },
      //Random default events
      events    : [
        @foreach ($laporan as $lapor)
          @if ($lapor->status_laporan == 'baru')
            {
              title          : '--{{ $lapor->status_laporan }}--',
              start          : new Date({{ $lapor->created_at->year}},{{ $lapor->created_at->month}}-1, {{ $lapor->created_at->day}}),
               allDay         : true,
              backgroundColor: '#C4C1C0', //red
              borderColor    : '#C4C1C0' //red
            },
            {
              title          : 'DL H-'+ {{Carbon::now()->diffInDays($lapor->expired_at)}} ,
              start          : new Date({{ $lapor->created_at->year}},{{ $lapor->created_at->month}}-1, {{ $lapor->created_at->day}}),
               allDay         : true,
              backgroundColor: '#F4595D', //red
              borderColor    : '#F4595D' //red
            },
          @elseif($lapor->status_laporan == 'proses')
            {
              title          : '--{{ $lapor->status_laporan }}--',
              start          : new Date({{ $lapor->created_at->year}},{{ $lapor->created_at->month}}-1, {{ $lapor->created_at->day}}),
               allDay         : true,
              backgroundColor: '#00c0ef', //red
              borderColor    : '#00c0ef' //red
            },
          @elseif($lapor->status_laporan == 'perbaikan')
            {
              title          : '--{{ $lapor->status_laporan }}--',
              start          : new Date({{ $lapor->created_at->year}},{{ $lapor->created_at->month}}-1, {{ $lapor->created_at->day}}),
               allDay         : true,
              backgroundColor: '#f39c12', //red
              borderColor    : '#f39c12' //red
            },
            {
              title          : 'DL H-'+ {{Carbon::now()->diffInDays($lapor->expired_at)}} ,
              start          : new Date({{ $lapor->created_at->year}},{{ $lapor->created_at->month}}-1, {{ $lapor->created_at->day}}),
               allDay         : true,
              backgroundColor: '#F4595D', //red
              borderColor    : '#F4595D' //red
            },
          @elseif($lapor->status_laporan == 'disetujui')
            {
              title          : '--{{ $lapor->status_laporan }}--',
              start          : new Date({{ $lapor->created_at->year}},{{ $lapor->created_at->month}}-1, {{ $lapor->created_at->day}}),
               allDay         : true,
              backgroundColor: '#00a65a', //red
              borderColor    : '#00a65a' //red
            },
          @endif

        @endforeach
      ],
      editable  : false,
      droppable : false, // this allows things to be dropped onto the calendar !!!
    })
  })
</script>
@include('admin/partial/_adminLaporan_script')

@endsection
