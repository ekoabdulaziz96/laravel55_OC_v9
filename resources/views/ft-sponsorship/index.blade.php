{{-- calling layouts \ app.blade.php --}}
@extends('layouts.master')
@section('stylesheet')
<!-- fullCalendar -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.css')}}">
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/fullcalendar/dist/fullcalendar.print.min.css')}}" media="print">
@endsection
@section('content-header')
       <h1 >
        Dashboard
        <small>Full Time Sponsorship</small>
      </h1>
{{--       <ol class="breadcrumb">
        <li><a href="{{ route('ft-admin.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> --}}
@endsection

@section('content-body')
      <!-- Small boxes (Stat box) -->
      
      <div class="row">
        <div class="col-lg-12 col-xs-12">
          <div class="small-box bg-default" style="background-color: #E38686">
            <div class="inner">
              <h3>{{ $laporan_kedaluwarsa }}</h3>

              <p>Laporan Kedaluwarsa</p>
              <h6>Masa aktif pengerjaan dan pelaporan laporan habis. Aktifitas untuk melakuakn perbaikan dan pengiriman laporan tidak bisa dilakukan. Segera lakukan permintaan perpanjangan laporan</h6>
            </div>
            <div class="icon">
              <i class="fa fa-calendar-times-o"></i>
            </div>
            <a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'kedaluwarsa']) }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>        

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-default" style="background-color: #D5D3D3">
            <div class="inner">
              <h3>{{ $laporan_baru }}</h3>

              <p>Laporan Baru</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper-outline"></i>
            </div>
            <a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'baru']) }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-default" style="background-color: #97D8CD">
            <div class="inner">
              <h3>{{ $laporan_proses }}</h3>

              <p>Laporan Proses</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paperplane-outline"></i>
            </div>
            <a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'proses']) }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-default" style="background-color: #F8EE4F">
            <div class="inner">
             <h3>{{ $laporan_perbaikan }}</h3>

              <p>Laporan Perbaikan</p>
            </div>
            <div class="icon">
              <i class="ion ion-edit"></i>
            </div>
            <a href="{{route('ft-sponsorship.laporan-status',[Auth::user()->id,'perbaikan']) }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-default" style="background-color: #57EF65">
            <div class="inner">
              <h3>{{ $laporan_disetujui}}</h3>

              <p>Laporan Disetujui</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-checkmark-circle"></i>
            </div>
            <a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'disetujui']) }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <section class="col-lg-12 ">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right" style="background-color: #B3E6B9">
              <li class="active"><a href="#pengumuman" data-toggle="tab">Pengumuman</a></li>
              <li><a href="#calendar" data-toggle="tab">Calendar</a></li>
              <li class="pull-left header"><i class="fa fa-bell-o"></i> Papan Informasi</li>
            </ul>
            <div class="tab-content ">
               {{-- pengumuman --}}
                <div class="chart tab-pane active" id="pengumuman" style="position: relative; height: 300px;padding: 1.5%">
                  @if ($pengumuman != null)
                    {!!$pengumuman->isi!!}
                  @else
                    belum ada pengumuman ,..
                  @endif
                </div>
                {{-- calendar --}}
                <div class="chart tab-pane" id="calendar" style="position: relative;">
                      <div class="col-md-8" align="center">
                            <div id="calendar" align="center"></div>
                      </div>
                      <br>
                </div>
              </div>
            </div>
        </section>
      </div>
<style type="text/css">
  #calendar {
    max-width: 80%;
    max-height: 100%;
    position: relative;
    margin-left: 10%;
    margin-right: : 10%;
  }
</style>


              
@endsection


@section('script')
<!-- fullCalendar -->
<script src="{{ asset('AdminLTE/bower_components/moment/moment.js')}}"></script>
<script src="{{ asset('AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script>
  $("#ftSponsorshipDashboard").attr("class","active");
  $(function() {
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
@endsection