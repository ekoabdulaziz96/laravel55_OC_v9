
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
                  <div class="small-box bg-purple">
                    <div class="inner">
                      <p>Permintaan Persetujuan</p>
                        <h6>{{ $ft_admin_direktur }} Direktur</h6>
                        <h6>{{ $ft_admin_manajer }} Manajer</h6>
                        <h6>{{ $ft_admin_ft_kacab }}  Kepala Cabang</h6>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                    <div class="small-box-footer">Laporan Ft Admin</div>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <p>Permintaan Persetujuan</p>
                        <h6>{{ $ft_sponsorship_direktur }} Direktur</h6>
                        <h6>{{ $ft_sponsorship_manajer }} Manajer</h6>
                        <h6>{{ $ft_sponsorship_ft_kacab }}  Kepala Cabang</h6>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-o"></i>
                    </div>
                    <div class="small-box-footer">Laporan Ft Sponsorship</div>
                  </div>
                </div>                  

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-red">
                    <div class="inner">
                      <p>Permintaan Persetujuan</p>
                        <h6>{{ $ft_kacab_direktur }} Direktur</h6>
                        <h6>{{ $ft_kacab_manajer }} Manajer</h6>
                        <h6>-</h6>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle"></i>
                    </div>
                    <div class="small-box-footer">Laporan Ft Kepala Cabang</div>
                  </div>
                </div>                   

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                      <p>Permintaan Persetujuan</p>
                        <h6>{{ $ft_kacab_direktur }} Direktur</h6>
                        <h6>-</h6>
                        <h6>-</h6>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-circle-o"></i>
                    </div>
                    <div class="small-box-footer">Laporan Ft Manajer</div>
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
         <i style="font-size: 20px">Silahkan terlebih dahulu kategori<b> Karyawan</b> yang dituju <u ></u></i>
          
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
            <form id="form-form" action="{{ route('admin.laporan-acc-terpilih')}}" method="post" class="form-horizontal" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <div class="modal-body">
                    {{-- input form --}}
                   <span id="form-input">
                        <div class="form-group">
                          <label for="status" class="col-md-1 col-md-offset-1">Status :</label>
                            <div class="col-md-9">
                               <select  id="status" name="status" class="form-control " autofocus required style="width: 100% ;" >
                                  <option value=""> --pilih-- </option>
                                  <option value="semua">Semua</option>
                                  <option value="manajer">Manajer</option>
                                  <option value="lainnya">Ft Admin, Ft Sponsorship, Ft Kepala Cabang</option>
                                </select>
                              <span class="help-block with-errors"></span>
                           </div>
                      </div>    
                      <div id="form_cabang">

                      </div>    
                      <div id="form_wilayah" >

                      </div>                         
                      <div id="nama_karyawan">

                      </div>                          
           
                    </span>
                    {{-- end input form --}}
                    
                </div>

                <div class="modal-footer" id="modal-footer" style="background-color: ">
                    <span id="button-submit">
                      {{-- <a href=""> --}}
                        <button id="button-submit" type="submit"  class="btn btn-success btn-save">Submit</button>
                      {{-- </a> --}}
                    </span>
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
       if ('{{ $laporan_status }}' == 'acc_laporan'){
     $("#acc_laporan").attr("class","active");
      }else    if ('{{ $laporan_status }}' == 'pantau_individual'){
     $("#acc_laporan_individual").attr("class","active");
      }
});

       $('#form_cabang').find('span').remove();
       $('#form_wilayah').find('span').remove();
       $('#nama_karyawan').find('span').remove();

       $('#foto_karyawan').hide();
       $('#button-submit').hide();

// status change
      $('#status').change(function(){

         $('#form_cabang').find('span').remove();
         $('#form_wilayah').find('span').remove();
         $('#nama_karyawan').find('span').remove();
         $('#foto_karyawan').hide();
         $('#button-submit').hide();

        var status = $("#status").val();
        if (status == 'lainnya' ){
             $('#form_cabang').find('span').remove();

             $('#form_cabang').append('<span> <div class="form-group"> <label for="cabang" class="col-md-1 col-md-offset-1">Cabang :</label> <div class="col-md-9"> <select  id="cabang" name="cabang" class="form-control " autofocus required style="width: 100% ;" > </select> <span class="help-block with-errors"></span> </div> </div></span>');

               $.ajax({
                url: "{{ url('admin/laporan-acc/status') }}" ,
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
                   $('#form_cabang').find('option').remove();
                  if(data.count == 0){
                    $('#form_cabang').find('span').remove();
                    $('#form_cabang').append('<span style="color:red"><div align="center">Maaf, Belum ada karyawan yang terdaftar. </div></span>');

                  }else{
                    $('#cabang').find('option').remove();
                    $('#cabang').append('<option value=""> --pilih-- </option>');
                    $('#cabang').append('<option value="semua"> Semua </option>');
                    for(var i = 0; i <data.count;i++){
                      $('#cabang').append('<option value="'+data[i].cabang+'"> '+data[i].cabang+' </option>');
                    }
                  }
                },
                error : function() {
                    alert("Nothing Data");
                }
              });

        }else if(status =='semua' || status =='manajer' ) {
           $('#button-submit').show();
        }else {
           $('#form_cabang').find('span').remove();
           $('#form_wilayah').find('span').remove();
           $('#nama_karyawan').find('span').remove();
           $('#button-submit').hide();
        }
      });
// cabang change
  $('#form_cabang').change(function(){
     $('#form_wilayah').find('span').remove();
     $('#nama_karyawan').find('span').remove();
    var status = $("#status").val();
    var cabang = $("#cabang").val();
    if (cabang == 'semua'){
         $('#button-submit').show();
    }else if(cabang != ''){
     $('#form_wilayah').append('<span><div class="form-group"> <label for="wilayah" class="col-md-1 col-md-offset-1">Wilayah :</label> <div class="col-md-9"> <select  id="wilayah" name="wilayah" class="form-control " autofocus required style="width: 100% ;" > </select> <span class="help-block with-errors"></span> </div> </div></span>');

        $.ajax({
          url: "{{ url('admin/laporan-acc') }}"+ "/cabang/"+cabang,
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
            if(data.count == 0){
                $('#nama_karyawan').find('span').remove();
                $('#nama_karyawan').append('<span style="color:red"><div align="center">Maaf, Belum ada karyawan yang terdaftar. </div></span>');

              }else{
                $('#wilayah').find('option').remove();
                $('#wilayah').append('<option value=""> --pilih-- </option>');
                $('#wilayah').append('<option value="semua"> Semua</option>');
                for(var i = 0; i <data.count;i++){
                  $('#wilayah').append('<option value="'+data[i].wilayah+'"> '+data[i].wilayah+' </option>');
                }
              }
          
          },
          error : function() {
              alert("Nothing Data");
          }
        });
      }else {
         $('#form_wilayah').find('span').remove();
      }
  });   

  // wilayah change
    $('#form_wilayah').change(function(){
      var wilayah = $("#wilayah").val();
    if (wilayah != ''){
         $('#button-submit').show();
    }else {
         $('#button-submit').hide();
    }

  });


</script>
{{-- @include('ft-admin/partial/_ftAdminLaporan_script') --}}

@endsection
