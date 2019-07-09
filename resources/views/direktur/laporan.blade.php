
{{-- calling layouts \ app.blade.php --}}
@extends('layouts.master')

@section('content-header')
{{--         <h1>
        Dashboard
        <small>Control panel</small>
      </h1> --}}
{{--       <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kelola Form</li>
      </ol> --}}
      {{-- <br> --}}
@endsection

@section('content-body')

<div class="row" >
  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="box box-success">
    <div class="box-title">
      <div class="panel panel-default">
      <div class="panel-heading">
         <i style="font-size: 20px">Kelola Laporan 
          <u>
              @if ($user->status == 'ft_admin')
                  FT Admin
              @elseif ($user->status == 'ft_sponsorship')
                  FT Sponsorship
              @elseif ($user->status == 'ft_kacab')
                  FT Kepala Cabang                        
              @elseif ($user->status == 'manajer')
                  Manajer                        
              @elseif ($user->status == 'direktur')
                  Direktur                        
              @endif
           </u> 
            <b> {{ $status_laporan }}</b>
         </i>
          
        <div class="pull-right box-tools">
                <button type="button" class="btn btn-basic btn-sm" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus "></i></button>
                {{-- <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button> --}}
              </div>
      </div>
    </div>
    </div>        
    <div class="box-body">
    
      <div class="panel-body">
        <div class="table-responsive">
            <table id="form-table"  class="display responsive nowrap table table-striped table-responsive table-bordered "  width="100%" >
                        <thead >
                            <tr class="bg-green color-palette">
                                <th width="5%">No</th>
                                <th width="18%">Tgl Laporan (th-bln-hr)</th>
                                <th  width="17%">Kedaluwarsa</th>
                                <th width="10%">Kehadiran</th>
                                <th  width="10%" >Status Laporan</th>
                                <th  width="10%">Kirim</th>
                                <th  width="15%">Acc Laporan</th>
                                <th class="text-center "  width="15%" >
                                  @if ($status_laporan == 'baru')
                                     <a onclick="addLaporan()" class="btn btn-success btn-sm" style="width: 100% ;background-color: #14CA77" data-toggle="tooltip" data-placement="top" title="Tambah"><i class="glyphicon glyphicon-plus"></i></a>
                                  @else
                                     <a href="#" class="btn btn-default btn-sm" style="width: 100%" data-toggle="tooltip" data-placement="top" title="Tambah"><i class="glyphicon glyphicon-plus"></i></a>
                                  @endif
                        
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



@include('ft-sponsorship/partial/_laporan_modal')
   
@endsection

@section('script')

    <script type="text/javascript">
      var table = $('#form-table').DataTable({
                      processing: false,
                      serverSide: true,
                      responsive: true,
                      ajax: "{{ route('api.ft-sponsorship.laporan',[$user->id,$status_laporan]) }}",
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


 $(function () {
    // $("tr:odd").addClass("odd");
    // $("tr:even").addClass("even");


 $("#ftSponsorshipLaporan").attr("class","active");
   if ('{{ $status_laporan }}' == 'baru'){
 $("#ftSponsorshipLaporan_baru").attr("class","active");
  }else    if ('{{ $status_laporan }}' == 'proses'){
 $("#ftSponsorshipLaporan_proses").attr("class","active");
  }else    if ('{{ $status_laporan }}' == 'perbaikan'){
 $("#ftSponsorshipLaporan_perbaikan").attr("class","active");
  }else    if ('{{ $status_laporan }}' == 'disetujui'){
 $("#ftSponsorshipLaporan_disetujui").attr("class","active");
  }else    if ('{{ $status_laporan }}' == 'kedaluwarsa'){
 $("#ftSponsorshipLaporan_kedaluwarsa").attr("class","active");
  }
    });
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
</script>
@include('ft-sponsorship/partial/_laporan_script')

@endsection
