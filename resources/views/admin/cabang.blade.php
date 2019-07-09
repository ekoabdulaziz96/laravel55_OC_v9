
{{-- calling layouts \ app.blade.php --}}
@extends('layouts.master')

@section('content-header')
{{--         <h1>
        Dashboard
        <small>Control panel</small>
      </h1> --}}
{{--       <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kelola Cabang</li>
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
         <i style="font-size: 20px">Daftar List <u >Cabang</u></i>

       
          {{-- <a href='#'  style="float: right;" ><i class='fa fa-plus-square fa-2x' data-target="#ModalAdd" data-toggle="modal"></i></a> --}}
          
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
        <div class="table-responsive">
            <table id="form-table"  class="display responsive nowrap table table-striped table-responsive table-bordered "  width="100%" >
                        <thead >
                            <tr class="bg-green color-palette">
                                <th width="5%">No</th>
                                <th  width="30%">Nama</th>
                                <th  width="30%">Slug Nama</th>
                                <th  width="20%">Maks. Wilayah</th>
                                <th class="text-center "  width="15%" >
                         <a onclick="addCabang()" class="btn btn-success btn-sm" style="width: 100% ;background-color: #14CA77" data-toggle="tooltip" data-placement="top" title="Tambah"><i class="glyphicon glyphicon-plus"></i></a>
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



@include('admin/partial/_adminCabang_modal')
   
@endsection

@section('script')

    <script type="text/javascript">
      var table = $('#form-table').DataTable({
                      processing: false,
                      serverSide: true,
                      responsive: true,
                      ajax: "{{ route('api.cabang') }}",
                      columns: [
                        {data: 'nomor', name: 'nomor'},
                        {data: 'nama', name: 'nama'},
                        {data: 'slug', name: 'slug'},
                        {data: 'maks_wilayah', name: 'maks_wilayah'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                      ]
                    });


 $(function () {
    //Flat red color scheme for iCheck
    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
    // $("tr:odd").addClass("odd");
    // $("tr:even").addClass("even");

    
  });
  $("#adminCabang").attr("class","active");
 
</script>
@include('admin/partial/_adminCabang_script')

@endsection
