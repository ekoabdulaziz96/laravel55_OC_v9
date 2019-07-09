
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
         <i style="font-size: 20px">Daftar List <u >User</u></i>

       
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
            <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right" style="background-color: #B3E6B9">
              <li ><a data-toggle="tab" href="#form-table" onclick="apiUser('ft_admin')">FT Admin</a></li>
              <li ><a data-toggle="tab" href="#form-table" onclick="apiUser('ft_sponsorship')">FT Sponsorship</a></li>
              <li><a data-toggle="tab" href="#form-table" onclick="apiUser('ft_kacab')">FT Kepala Cabang</a></li>
              <li><a data-toggle="tab" href="#form-table" onclick="apiUser('manajer')">Manajer</a></li>
              <li><a data-toggle="tab" href="#form-table" onclick="apiUser('direktur')">Direktur</a></li>
              <li><a data-toggle="tab" href="#form-table" onclick="apiUser('super_admin')">Super Admin</a></li>
              <li class="active"><a data-toggle="tab" href="#form-table" onclick="apiUser('')">All</a></li>
              <li class="pull-left header"><i class="fa fa-hourglass-half"></i> Status User </li>
            </ul>
          </div>            

        <div class="table-responsive tab-content">
            <table id="form-table"  class="display responsive nowrap table  table-striped table-responsive table-bordered "  width="100%" >
                        <thead >
                            <tr class="bg-green color-palette">
                                <th width="5%">No</th>
                                <th  width="22%">Nama</th>
                                <th  width="23%">Email</th>
                                <th  width="5%">Active</th>
                                <th  width="15%">Status</th>
                                <th  width="5%">Cabang</th>
                                <th  width="10%">Reset</th>
                                <th class="text-center "  width="15%" >
                         <a onclick="addUser()" class="btn btn-success btn-sm" style="width: 100% ;background-color: #14CA77" data-toggle="tooltip" data-placement="top" title="Tambah"><i class="glyphicon glyphicon-plus"></i></a>
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



@include('admin/partial/_adminUser_modal')
   
@endsection

@section('script')

    <script type="text/javascript">
      var table = $('#form-table').DataTable({
                      processing: false,
                      serverSide: true,
                      responsive: true,
                      ajax: "{{ route('api.user') }}",
                      columns: [
                        {data: 'nomor', name: 'nomor'},
                        {data: 'nama', name: 'nama'},
                        {data: 'email', name: 'email'},
                        {data: 'active', name: 'active'},
                        {data: 'status', name: 'status'},
                        {data: 'cawil' , name: 'cawil'},
                        {data: 'reset', name: 'reset'},
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

function apiUser(status){
  table.search( status ).draw();
}
 
  $("#adminUser").attr("class","active");
 
</script>
@include('admin/partial/_adminUser_script')

@endsection
