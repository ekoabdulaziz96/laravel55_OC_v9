
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
         <i style="font-size: 20px">Manager</i>
          
        <div class="pull-right box-tools">
                <button type="button" class="btn btn-basic btn-sm" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus "></i></button>
              </div>
      </div>
    </div>
    </div>        
    <div class="box-body" style="min-height: 50%">
      <div class="panel-body">
        <div class="table-responsive">
           <form method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                <div class="modal-body">
                    {{-- input form --}}
                   <span>
                        <div class="form-group">
                          <label for="status" class="col-md-1 col-md-offset-1">status :</label>
                            <div class="col-md-9">
                               <select  id="status" name="status" class="form-control " autofocus required style="width: 100% ;" >
                                  <option value=""> --pilih-- </option>
                                  <option value="manajer"> Manajer </option>
                                </select>
                              <span class="help-block with-errors"></span>
                           </div>
                      </div>      
      
                      <br><hr>                         
                      <div id="nama_pegawai">
                        <div class="col-md-12">
                            <table id="form-table-pegawai"  class="table  table-responsive table-bordered table-striped ">
                                        <thead >
                                            <tr class="bg-green color-palette">
                                                <th width="5%">No</th>
                                                <th  width="20%">Foto</th>
                                                <th  width="20%">Nama</th>
                                                <th  width="20%">No. Telp</th>
                                                <th  width="15%">Status</th>
                                                <th  width="20%">Lihat Detail</th>
                                            </tr>
                                        </thead>

                                        <tbody id="pegawai">

                                        </tbody>
                           </table>
                        </div>
                      </div>                          
                    </span>
                    {{-- end input form --}}
                    
                </div>
              </form>
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
         <i style="font-size: 20px">FT Admin, FT Sponsorship, FT Kepala Cabang</i>
          
        <div class="pull-right box-tools">
                <button type="button" class="btn btn-basic btn-sm" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus "></i></button>
              </div>
      </div>
    </div>
    </div>        
    <div class="box-body" style="min-height: 50%">
      <div class="panel-body">
        <div class="table-responsive">
           <form method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                <div class="modal-body">
                    {{-- input form --}}
                   <span id="form-input">
                        <div class="form-group">
                          <label for="cabang" class="col-md-1 col-md-offset-1">cabang :</label>
                            <div class="col-md-9">
                               <select  id="cabang" name="cabang" class="form-control " autofocus required style="width: 100% ;" >
                                  <option value=""> --pilih-- </option>
                                  @foreach ($cabang as $cabs)
                                      <option value="{{ $cabs->id }}" >{{ $cabs->nama }}</option>
                                  @endforeach
                                </select>
                              <span class="help-block with-errors"></span>
                           </div>
                      </div>      
                      <div id="form_wilayah" >

                      </div>
                      <br><hr>                         
                      <div id="nama_karyawan">
                        <div class="col-md-12">
                            <table id="form-table"  class="table  table-responsive table-bordered table-striped ">
                                        <thead >
                                            <tr class="bg-green color-palette">
                                                <th width="5%">No</th>
                                                <th  width="20%">Foto</th>
                                                <th  width="20%">Nama</th>
                                                <th  width="20%">No. Telp</th>
                                                <th  width="15%">Status</th>
                                                <th  width="20%">Lihat Detail</th>
                                            </tr>
                                        </thead>

                                        <tbody id="karyawan">

                                        </tbody>
                           </table>
                        </div>
                      </div>                          
                    </span>
                    {{-- end input form --}}
                    
                </div>
              </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<style type="text/css">
  label {
    padding: 0px;
  }
</style>

{{-- @include('ft-admin/partial/_ftAdminLaporan_modal') --}}
   
@endsection

@section('script')

    <script type="text/javascript">


 $(function () {
     $("#adminLaporan").attr("class","active");
       if ('{{ $laporan_status }}' == 'baru'){
     $("#adminLaporan_baru").attr("class","active");
      }else    if ('{{ $laporan_status }}' == 'pantau_karyawan'){
     $("#acc_laporan_karyawan").attr("class","active");
      }
});

       $('#form_cabang').find('span').remove();
       $('#form_wilayah').find('span').remove();

       $('#nama_karyawan').hide();
       $('#nama_pegawai').hide();

// cabang change
      $('#cabang').change(function(){
         $('#form_wilayah').find('span').remove();
        $('#nama_karyawan').hide();


         $('#form_wilayah').append('<span><div class="form-group"> <label for="wilayah" class="col-md-1 col-md-offset-1">Wilayah :</label> <div class="col-md-9"> <select  id="wilayah" name="wilayah" class="form-control " autofocus required style="width: 100% ;" > </select> <span class="help-block with-errors"></span> </div> </div></span>');

        var cabang = $("#cabang").val();
         if(cabang != ''){
            $.ajax({
              url: "{{ url('admin/laporan-karyawan/cabang/') }}"+ '/'+cabang,
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
                    $('#wilayah').find('option').remove();
                    $('#wilayah').append('<option value=""> --pilih-- </option>');
                    for(var i = 0; i <data.count;i++){
                      $('#wilayah').append('<option value="'+data[i].wilayah+'"> '+data[i].wilayah+' </option>');
                    }              
              },
              error : function() {
                  alert("Nothing Data");
              }
            });
          }else {
             $('#nama_karyawan').hide();
             $('#form_wilayah').find('span').remove();
         
          }
      });   

  // wilayah change
      $('#form_wilayah').change(function(){

        var cabang = $("#cabang").val();
        var wilayah = $("#wilayah").val();
         if(wilayah != ''&& cabang != ''){
             $.ajax({
              url: "{{ url('admin/laporan-karyawan') }}"+ '/'+cabang+"/wilayah/"+wilayah,
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
              $('#nama_karyawan').show();
              $('#karyawan').find('tr').remove();
              $('#karyawan').find('td').remove();
              for (var i = 0; i < data.count; i++) {
                j = i+1;
                    if (data[i].status == 'ft_admin'){
                        statuss = 'FT Admin';
                    }else if (data[i].status == 'ft_sponsorship'){
                        statuss = 'FT Sponsorship';
                    }else if (data[i].status == 'ft_kacab'){
                        statuss = 'FT Kepala Cabang';                        
                    }else if (data[i].status == 'manajer'){
                        statuss = 'Manajer';                        
                    }else if (data[i].status == 'direktur'){
                        statuss = 'Direktur';                        
                    }
                if(data[i].foto != '-'){
                  $('#karyawan').append('<tr>'+
                      '<td>'+j+'</td>'+
                      '<td> <img src="'+data[i].foto+'" alt="belum ada foto" width="50%" /></td>'+
                      '<td>'+data[i].nama+'</td>'+
                      '<td>'+data[i].no_hp+'</td>'+
                      '<td>'+statuss+'</td>'+
                      '<td><a onclick="detailKaryawan('+ data[i].id +')"  class="btn btn-default btn-sm btn-flat" style="background-color: #B1EDF6;width:100%;color:white"  data-toggle="tooltip" data-placement="top" title="lihat detail"><i class="fa fa-share-square-o fa-2x " ></i></a>  </td>'+
                      '</tr>');                  
                }else{
                  $('#karyawan').append('<tr>'+
                      '<td>'+j+'</td>'+
                      '<td> <img src="#" alt="belum ada foto" width="50%" /></td>'+
                      '<td>'+data[i].nama+'</td>'+
                      '<td>'+data[i].no_hp+'</td>'+
                      '<td>'+statuss+'</td>'+
                      '<td><a onclick="detailKaryawan('+ data[i].id +')"  class="btn btn-default btn-sm btn-flat" style="background-color: #B1EDF6;width:100%;color:white"  data-toggle="tooltip" data-placement="top" title="lihat detail"><i class="fa fa-share-square-o fa-2x " ></i></a>  </td>'+
                      '</tr>');                  

                }
                
              }
            },
            error : function() {
              alert("Nothing Data");
              }
            });
      }else {
        $('#nama_karyawan').hide();

      }
  });  


  //////////////// status change
      $('#status').change(function(){

        var status = $("#status").val();
         if(status != ''){
             $.ajax({
              url: "{{ url('admin/laporan-karyawan') }}"+ '/status/'+status,
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
              $('#nama_pegawai').show();
              $('#pegawai').find('tr').remove();
              $('#pegawai').find('td').remove();
              for (var i = 0; i < data.count; i++) {
                j = i+1;
                    if (data[i].status == 'ft_admin'){
                        statuss = 'FT Admin';
                    }else if (data[i].status == 'ft_sponsorship'){
                        statuss = 'FT Sponsorship';
                    }else if (data[i].status == 'ft_kacab'){
                        statuss = 'FT Kepala Cabang';                        
                    }else if (data[i].status == 'manajer'){
                        statuss = 'Manajer';                        
                    }else if (data[i].status == 'direktur'){
                        statuss = 'Direktur';                        
                    }
                if(data[i].foto != '-'){
                  $('#pegawai').append('<tr>'+
                      '<td>'+j+'</td>'+
                      '<td> <img src="'+data[i].foto+'" alt="belum ada foto" width="50%" /></td>'+
                      '<td>'+data[i].nama+'</td>'+
                      '<td>'+data[i].no_hp+'</td>'+
                      '<td>'+statuss+'</td>'+
                      '<td><a onclick="detailKaryawan('+ data[i].id +')" class="btn btn-default btn-sm btn-flat" style="background-color: #B1EDF6;width:100%;color:white"  data-toggle="tooltip" data-placement="top" title="lihat detail"><i class="fa fa-share-square-o fa-2x "></i></a>  </td>'+
                      '</tr>');                  
                }else{
                  $('#pegawai').append('<tr>'+
                      '<td>'+j+'</td>'+
                      '<td> <img src="#" alt="belum ada foto" width="50%" /></td>'+
                      '<td>'+data[i].nama+'</td>'+
                      '<td>'+data[i].no_hp+'</td>'+
                      '<td>'+statuss+'</td>'+
                      '<td><a onclick="detailKaryawan('+ data[i].id +')" class="btn btn-default btn-sm btn-flat" style="background-color: #B1EDF6;width:100%;color:white"  data-toggle="tooltip" data-placement="top" title="lihat detail"><i class="fa fa-share-square-o fa-2x "></i></a>  </td>'+
                      '</tr>');                  

                }
                
              }
            },
            error : function() {
              alert("Nothing Data");
              }
            });
      }else {
        $('#nama_pegawai').hide();

      }
  });


function detailKaryawan(id){
  $(location).attr('href','{{ url('admin/laporan-terpilih-user/') }}'+'/'+id);
}
</script>
{{-- @include('ft-admin/partial/_ftAdminLaporan_script') --}}

@endsection
