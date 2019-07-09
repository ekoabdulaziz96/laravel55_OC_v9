
      <script>

function addLaporanSet() {
  save_method = "add";
  $('input[name=_method]').val('POST');
   $('#modal-form').modal('show');
  $('#modal-form form')[0].reset();
  $('.modal-title').text('Form Tambah ');
      $('#modal-header').addClass('modal-header-add');
      $('#modal-footer').addClass('modal-footer-add'); 
      $('#modal-header').removeClass('modal-header-edit');
      $('#modal-footer').removeClass('modal-footer-edit');
      $('#modal-header').removeClass('modal-header-delete');
      $('#modal-footer').removeClass('modal-footer-delete'); 
      $('#modal-header').removeClass('modal-header-show');
      $('#modal-footer').removeClass('modal-footer-show');

      $('#form-delete').hide();
      $('#form-show').hide();
      $('#form-input').show();
      $('#form-input-hadir').hide();

      $('#button-submit').show();
      $('#button-submit').removeClass('btn-primary');
      $('#button-submit').removeClass('btn-danger');
      $('#button-submit').addClass('btn-success');
      $('#button-submit').removeClass('btn-warning');
      $('#button-submit-text').text('Tambah');
}
function addLaporan() {

  addLaporanSet();
      var user =  $('#id_user').val();
        $.ajax({
            url: "{{ url('admin/laporan-tanggal') }}"+ '/' + user ,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              $('#created_at').val(data.date.substring(0,10));
              console.log(data);

            },
            error : function() {
                alert("Nothing Data");
            }
          });

    $('#kehadiran').change(function(){
      var kehadiran= $("#kehadiran").val();
      if (kehadiran == 'hadir'){
        $('#form-input-hadir').show();
          editLaporanSetBaru();
      }else {
          editLaporanSetTidakhadir(); 
      }
   });
  }

  function editLaporanSet() {
        $('#modal-form').modal('show');
        $('.modal-title').text('Form Edit');
        
        $('#modal-header').removeClass('modal-header-add');
        $('#modal-footer').removeClass('modal-footer-add'); 
        $('#modal-header').addClass('modal-header-edit');
        $('#modal-footer').addClass('modal-footer-edit');
        $('#modal-header').removeClass('modal-header-delete');
        $('#modal-footer').removeClass('modal-footer-delete'); 
        $('#modal-header').removeClass('modal-header-show');
        $('#modal-footer').removeClass('modal-footer-show');

        $('#form-input').show();
        $('#form-delete').hide();
        $('#form-show').hide();

        $('#button-submit').show();
        $('#button-submit').removeClass('btn-primary');
        $('#button-submit').removeClass('btn-danger');
        $('#button-submit').removeClass('btn-success');
        $('#button-submit').addClass('btn-warning');
        $('#button-submit-text').text('Perbarui');
  }

function editLaporanSetTidakhadir() {
    $('#form-input-hadir').hide();
    @foreach ($form_all as $form)
         $('#{{$form->slug}}').removeAttr('name','{{$form->slug}}');
         $('#{{$form->slug}}').removeAttr('required','required');
         $('#{{$form->slug}}').removeAttr('autofokus','autofokus');
        @php
           $pilihans = $form->pilihan->all();
        @endphp
        @foreach ($pilihans as $pilihan)
             if('{{ $form->tipe }}' =='radio') {
              $('#{{ $form->slug.$pilihan->slug }}').removeAttr('name','{{$form->slug}}');
              $('#{{ $form->slug.$pilihan->slug }}').removeAttr('required','required');
              $('#{{ $form->slug.$pilihan->slug }}').removeAttr('autofokus','autofokus');
             }
             if('{{ $form->tipe }}' =='checkbox') {
              $('#{{ $form->slug.$pilihan->slug }}').removeAttr('name','{{$form->slug}}[]');
            }
           
        @endforeach
    @endforeach       
}
function editLaporanSetBaru() {
  var i = 1;
            @foreach ($form_all as $form)
              if('{{$form->view}}'=='hidden'){
                 $('#view_{{$form->slug}}').hide();
                 $('#{{$form->slug}}').removeAttr('name','{{$form->slug}}');
                 $('#{{$form->slug}}').removeAttr('required','required');
                 $('#{{$form->slug}}').removeAttr('autofokus','autofokus');
                 
              } else {
                 $('#view_{{$form->slug}}').show();
                 $('#{{$form->slug}}').attr('name','{{$form->slug}}');

                 if ('{{ $form->nama }}'.substring(0,10) != 'keterangan') {
                    $('#{{$form->slug}}').attr('required','required');
                    $('#{{$form->slug}}').attr('autofokus','autofokus');
                    $('#view_no_{{$form->slug}}').text(i+'.');
                    i = i +1;
                 }
                if ('{{$form->tipe}}' == 'file' ){
                   $('#{{$form->slug}}').attr('required','required');
                   $('#{{$form->slug}}').attr('autofokus','autofokus');
                   $('#file_{{$form->slug}}').hide();
                }
              }

              @php
                 $pilihans = $form->pilihan->all();
              @endphp
              @foreach ($pilihans as $pilihan)
                if('$form->view'=='hidden'){
                   if('{{ $form->tipe }}' =='radio') {
                    $('#{{ $form->slug.$pilihan->slug }}').removeAttr('name','{{$form->slug}}');
                    $('#{{ $form->slug.$pilihan->slug }}').removeAttr('required','required');
                    $('#{{ $form->slug.$pilihan->slug }}').removeAttr('autofokus','autofokus');
                   }
                   if('{{ $form->tipe }}' =='checkbox') {
                    $('#{{ $form->slug.$pilihan->slug }}').removeAttr('name','{{$form->slug}}[]');
                  }
                 }else{
                   if('{{ $form->tipe }}' =='radio') {
                    $('#{{ $form->slug.$pilihan->slug }}').attr('name','{{$form->slug}}');
                    $('#{{ $form->slug.$pilihan->slug }}').attr('required','required');
                    $('#{{ $form->slug.$pilihan->slug }}').attr('autofokus','autofokus');
                   }
                   if('{{ $form->tipe }}' =='checkbox') {
                    $('#{{ $form->slug.$pilihan->slug }}').attr('name','{{$form->slug}}[]');
                  }
                 }

                if('{{ $form->tipe }}' =='radio' || '{{ $form->tipe }}' =='checkbox'){
                    $('#{{ $form->slug.$pilihan->slug }}').removeAttr('checked','checked');
                }
              @endforeach
            @endforeach
}

function editLaporanSetHadir(data) {
      $('#form-input-hadir').show();

        //normalisasi show all
        var i = 1;
        @foreach ($form_all as $form)
        if(data.{{ $form->slug }} == null && '{{ $form->nama }}'.substring(0,10) != 'keterangan'){ 
           $('#view_{{$form->slug}}').hide();
           $('#view_ket_{{$form->slug}}').hide();
           $('#{{$form->slug}}').removeAttr('name','{{$form->slug}}');
            $('#{{$form->slug}}').removeAttr('required','required');
            $('#{{$form->slug}}').removeAttr('autofokus','autofokus');
        }else if(data.{{ $form->slug }} != null){ 
           $('#view_{{$form->slug}}').show();
           $('#view_ket_{{$form->slug}}').show();
           $('#{{$form->slug}}').attr('name','{{$form->slug}}');

           if ('{{ $form->nama }}'.substring(0,10) != 'keterangan') {
            $('#view_no_{{$form->slug}}').text(i+'.');
            i = i +1;

            $('#{{$form->slug}}').attr('required','required');
            $('#{{$form->slug}}').attr('autofokus','autofokus');
          }

        }
          @php
             $pilihans = $form->pilihan->all();
          @endphp
          @foreach ($pilihans as $pilihan)
               if('$form->view'=='hidden'){
                   if('{{ $form->tipe }}' =='radio') {
                    $('#{{ $form->slug.$pilihan->slug }}').removeAttr('name','{{$form->slug}}');
                    $('#{{ $form->slug.$pilihan->slug }}').removeAttr('required','required');
                    $('#{{ $form->slug.$pilihan->slug }}').removeAttr('autofokus','autofokus');
                   }
                   if('{{ $form->tipe }}' =='checkbox') {
                    $('#{{ $form->slug.$pilihan->slug }}').removeAttr('name','{{$form->slug}}[]');
                  }
                 }else{
                   if('{{ $form->tipe }}' =='radio') {
                    $('#{{ $form->slug.$pilihan->slug }}').attr('name','{{$form->slug}}');
                    $('#{{ $form->slug.$pilihan->slug }}').attr('required','required');
                    $('#{{ $form->slug.$pilihan->slug }}').attr('autofokus','autofokus');
                   }
                   if('{{ $form->tipe }}' =='checkbox') {
                    $('#{{ $form->slug.$pilihan->slug }}').attr('name','{{$form->slug}}[]');
                  }
                 }

            if('{{ $form->tipe }}' =='radio' || '{{ $form->tipe }}' =='checkbox'){
                $('#{{ $form->slug.$pilihan->slug }}').removeAttr('checked','checked');
            }
          @endforeach
        @endforeach

        //view berdasarkan tgl
        $('#id').val(data.id); 
          @foreach ($form_all as $form)
            if('{{$form->tipe}}' != 'file' && '{{$form->tipe}}' != 'checkbox'){
               $('#{{$form->slug}}').val(data.{{ $form->slug }});
            }else if ('{{$form->tipe}}' == 'file'){
               $('#{{$form->slug}}').removeAttr('required','required');
               $('#{{$form->slug}}').removeAttr('autofokus','autofokus');

               $('#file_{{$form->slug}}').show();
               $('#file_download_{{$form->slug}}').attr('href',data.{{ $form->slug }});
               $('#file_text_{{$form->slug}}').text(data.{{ $form->slug }});
            }
            @php
               $pilihans = $form->pilihan->all();
            @endphp
            @foreach ($pilihans as $pilihan)
              if('{{ $form->tipe }}' =='radio' ){
                if (data.{{ $form->slug }} == '{{ $pilihan->nama }}'){
                  $('#{{ $form->slug.$pilihan->slug }}').attr('checked','checked');
                }
              }else if ('{{ $form->tipe }}' =='checkbox'){
                if (jQuery.inArray("{{ $pilihan->slug }}",  data.{{ $form->slug }}) != -1){
                  $('#{{ $form->slug.$pilihan->slug }}').attr('checked','checked');
                }
              }
            @endforeach
          @endforeach
}

function editLaporan(id) {
  save_method = 'edit';
  $('input[name=_method]').val('PATCH');
  $('#modal-form form')[0].reset();
  $.ajax({
    url: "{{ url('admin/laporan') }}" + '/' + '{{ $user->id }}' + "/edit/"+id,
    type: "GET",
    dataType: "JSON",
    success: function(data) {
     editLaporanSet();
     $('#id').val(data.id); 

      $('#created_at').val(data.created_at.substring(0,10));
      $('#kehadiran').val(data.kehadiran);
     
    if(data.kehadiran == 'hadir'){   
      editLaporanSetHadir(data);

    }else{
      editLaporanSetTidakhadir();  
    }

//change form  
   $('#kehadiran').change(function(){
      var kehadiran= $("#kehadiran").val();
       if(data.kehadiran =='hadir'){
          if (kehadiran == 'hadir'){
            $('#form-input-hadir').show();
            editLaporanSetHadir(data);
          }else {
            editLaporanSetTidakhadir();            
          }
        }else{
          var cek = false;
          @foreach ($form_all as $form)
              if(data.{{ $form->slug }} != null && '{{ $form->nama }}'.substring(0,10) != 'keterangan'){
                cek = true;
              } 
          @endforeach
          console.log(cek);
          if (kehadiran == 'hadir'){
            if (cek == true){
              $('#form-input-hadir').show();
              editLaporanSetHadir(data);
            }else {
              $('#form-input-hadir').show();
              editLaporanSetBaru();
            }
          }else {
            editLaporanSetTidakhadir(); 
          }
        }
   });
   {{-- console.log('{{ $form_all[0]->nama }}'); --}}
  },
    error : function() {
        alert("Nothing Data");
    }
  });
}   

     function showLaporan(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin/laporan') }}" + '/' + '{{ $user->id }}' + "/edit/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            
            $('#modal-form').modal('show');
            $('.modal-title').text('Form Detail ');
            
            $('#modal-header').removeClass('modal-header-add');
            $('#modal-footer').removeClass('modal-footer-add'); 
            $('#modal-header').removeClass('modal-header-edit');
            $('#modal-footer').removeClass('modal-footer-edit');
            $('#modal-header').removeClass('modal-header-delete');
            $('#modal-footer').removeClass('modal-footer-delete'); 
            $('#modal-header').addClass('modal-header-show');
            $('#modal-footer').addClass('modal-footer-show');

            
            $('#form-input').hide();
            $('#form-delete').hide();
            
            $('#form-show').show();
            $('#form-show-laporan-title').text('Laporan Tanggal '+data.created_at.substring(0,10));
            $('#form-show-tgl').text(data.created_at.substring(0,10));
            $('#form-show-kehadiran').text(data.kehadiran);
            $('#button-submit').hide();

            if(data.kehadiran != 'hadir'){
              $('#form-show-hadir').hide();
              @foreach ($form_all as $form)
                if(data.{{ $form->slug }} == null && '{{ $form->nama }}'.substring(0,10) != 'keterangan'){ 
                   $('#form-show-{{ $form->slug }}').hide();
                   $('#form-show-file-{{ $form->slug }}').hide();
                   $('#form-show-ket_{{ $form->slug }}').hide();
                }
              @endforeach
            }else {
                $('#form-show-hadir').show();
               //normalisasi show all
                var i = 1;
                @foreach ($form_all as $form)
                if(data.{{ $form->slug }} == null && '{{ $form->nama }}'.substring(0,10) != 'keterangan'){ 
                   $('#form-show-{{ $form->slug }}').hide();
                   $('#form-show-file-{{ $form->slug }}').hide();
                   $('#form-show-ket_{{ $form->slug }}').hide();

                }else if(data.{{ $form->slug }} != null){ 
                   $('#form-show-{{ $form->slug }}').show();
                   $('#form-show-ket_{{ $form->slug }}').show();

                   if ('{{ $form->nama }}'.substring(0,10) != 'keterangan') {
                    $('#form-show-no-{{ $form->slug }}').text(i+'.');
                    i = i +1;
                  }
                }
                @endforeach

              //view berdasarkan tgl
              $('#id').val(data.id); 
                @foreach ($form_all as $form)

                 if ('{{$form->tipe}}' == 'file'){
                    $('#form-show-file-{{ $form->slug }}').show();
                    $('#form-show-file-text-{{$form->slug }}').text(data.{{ $form->slug }});
                    $('#form-show-file-download-{{$form->slug }}').attr('href',data.{{ $form->slug }})
                  }else  if('{{$form->tipe}}' != 'file'){
                    if(data.{{$form->slug}} == null){
                      $('#form-show-data-{{ $form->slug }}').text('-');
                    }else {
                      $('#form-show-data-{{ $form->slug }}').text(data.{{ $form->slug }});
                    } 
                    }
                @endforeach
            }
          },
          error : function() {
              alert("Nothing Data");
          }
        });
      }      

  function viewAccLaporan(id,status) {
    save_method = 'edit';
    $('input[name=_method]').val('PATCH');
    $('#modal-form-acc form')[0].reset();
    $.ajax({
      url: "{{ url('admin/laporan') }}" + '/' + '{{ $user->id }}' + "/edit/"+id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#modal-form-acc').modal('show');
        if(status == 'ft_kacab'){
          $('#modal-form-acc-title').text('Persetujuan Laporan oleh Kepala Cabang ');
          // $('#form-acc-show-status').text(data.acc_ft_kacab);
          // $('#form-acc-show-komentar').text(data.komentar_ft_kacab);
          $('#persetujuan_dari').val(status);
          $('#status_acc_laporan').val(data.acc_ft_kacab);
          $('#komentar').val(data.komentar_ft_kacab);
          
          $('#status_acc_laporan').change(function(){
           if ( $('#status_acc_laporan').val() == 'disetujui'){
              $('#komentar').val('-');
           }else {
              $('#komentar').val(data.komentar_ft_kacab);
           }
         });
          $('#modal-header-acc').addClass('modal-header-acc-kacab');
          $('#modal-footer-acc').addClass('modal-footer-acc-kacab'); 
          $('#modal-header-acc').removeClass('modal-header-acc-manajer');
          $('#modal-footer-acc').removeClass('modal-footer-acc-manajer');
          $('#modal-header-acc').removeClass('modal-header-acc-direktur');
          $('#modal-footer-acc').removeClass('modal-footer-acc-direktur'); 
          
        }else if(status == 'manajer'){
          $('#modal-form-acc-title').text('Persetujuan Laporan oleh Manajer ');
          // $('#form-acc-show-status').text(data.acc_manajer);
          // $('#form-acc-show-komentar').text(data.komentar_manajer);
          $('#persetujuan_dari').val(status);
          $('#status_acc_laporan').val(data.acc_manajer);
          $('#komentar').val(data.komentar_manajer);
          
          $('#status_acc_laporan').change(function(){
           if ( $('#status_acc_laporan').val() == 'disetujui'){
              $('#komentar').val('-');
           }else {
              $('#komentar').val(data.komentar_manajer);
           }
         });
          $('#modal-header-acc').removeClass('modal-header-acc-kacab');
          $('#modal-footer-acc').removeClass('modal-footer-acc-kacab'); 
          $('#modal-header-acc').addClass('modal-header-acc-manajer');
          $('#modal-footer-acc').addClass('modal-footer-acc-manajer');
          $('#modal-header-acc').removeClass('modal-header-acc-direktur');
          $('#modal-footer-acc').removeClass('modal-footer-acc-direktur'); 
        }else if(status == 'direktur'){
          $('#modal-form-acc-title').text('Persetujuan Laporan oleh Direktur ');
          // $('#form-acc-show-status').text(data.acc_direktur);
          // $('#form-acc-show-komentar').text(data.komentar_direktur);
          $('#persetujuan_dari').val(status);
          $('#status_acc_laporan').val(data.acc_direktur);
          $('#komentar').val(data.komentar_direktur);

          $('#status_acc_laporan').change(function(){
           if ( $('#status_acc_laporan').val() == 'disetujui'){
              $('#komentar').val('-');
           }else {
              $('#komentar').val(data.komentar_direktur);
           }
         });
          $('#modal-header-acc').removeClass('modal-header-acc-kacab');
          $('#modal-footer-acc').removeClass('modal-footer-acc-kacab'); 
          $('#modal-header-acc').removeClass('modal-header-acc-manajer');
          $('#modal-footer-acc').removeClass('modal-footer-acc-manajer');
          $('#modal-header-acc').addClass('modal-header-acc-direktur');
          $('#modal-footer-acc').addClass('modal-footer-acc-direktur'); 
        }
        
        $('#id').val(data.id);
        $('#form-acc-show-laporan-title').text('Laporan Tanggal '+data.created_at.substring(0,10));
        $('#form-acc-show-tgl').text(data.created_at.substring(0,10));
        $('#form-acc-show-kehadiran').text(data.kehadiran);
       if(data.kehadiran != 'hadir'){
          $('#form-acc-show-laporan').hide();
          @foreach ($form_all as $form)
            if(data.{{ $form->slug }} == null && '{{ $form->nama }}'.substring(0,10) != 'keterangan'){ 
               $('#form-acc-show-{{ $form->slug }}').hide();
               $('#form-acc-show-file-{{ $form->slug }}').hide();
               $('#form-acc-show-ket_{{ $form->slug }}').hide();
            }
          @endforeach
        }else {
              $('#form-acc-show-laporan').show();
         //normalisasi show all
            var i = 1;
            @foreach ($form_all as $form)
            if(data.{{ $form->slug }} == null && '{{ $form->nama }}'.substring(0,10) != 'keterangan'){ 
               $('#form-acc-show-{{ $form->slug }}').hide();
               $('#form-acc-show-file-{{ $form->slug }}').hide();
               $('#form-acc-show-ket_{{ $form->slug }}').hide();

            }else if(data.{{ $form->slug }} != null){ 
               $('#form-acc-show-{{ $form->slug }}').show();
               $('#form-acc-show-ket_{{ $form->slug }}').show();

               if ('{{ $form->nama }}'.substring(0,10) != 'keterangan') {
                $('#form-acc-show-no-{{ $form->slug }}').text(i+'.');
                i = i +1;
              }
            }
            @endforeach

          //view berdasarkan tgl
          $('#id').val(data.id); 
            @foreach ($form_all as $form)

             if ('{{$form->tipe}}' == 'file'){
                $('#form-acc-show-file-{{ $form->slug }}').show();
                $('#form-acc-show-file-text-{{$form->slug }}').text(data.{{ $form->slug }});
                $('#form-acc-show-file-download-{{$form->slug }}').attr('href',data.{{ $form->slug }})
              }else  if('{{$form->tipe}}' != 'file'){
                if(data.{{$form->slug}} == null){
                  $('#form-acc-show-data-{{ $form->slug }}').text('-');
                }else {
                  $('#form-acc-show-data-{{ $form->slug }}').text(data.{{ $form->slug }});
                } 
                  }
            @endforeach
        }
      },
      error : function() {
          alert("Nothing Data");
      }
    });
  } 

  function deadlineLaporan(id){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    swal({
        title: 'Apakah anda yakin?',
        text: "ingin meminta perpanjangan deadline laporan",
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Minta Perpanjangan'
    }).then(function () {
        $.ajax({
            url: "{{ url('admin/laporan/deadline') }}" + '/' + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function(){
                     $("body").css("padding",'0px');
                     swal({
                          title: 'Sedang Memuat...',
                          onOpen: () => {
                            swal.showLoading()
                          }
                        }).catch(swal.noop);
                    },
            success : function(data) {
                table.ajax.reload();
                 swal({
                    title: data.title,
                    text: data.message,
                    type: data.type,
                    timer: data.timer,
                }).catch(swal.noop);
            },
            error : function () {
                swal({
                      title: 'Oops...',
                      text: 'gagal, meminta perpanjangan.\n Silahkan refresh page',
                      type: 'error',
                      timer: 5000
                  }).catch(swal.noop);
            }
        });
    }).catch(swal.noop);
  }
      function deleteLaporan(id) {
        save_method = 'delete';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin/laporan') }}" + '/' + '{{ $user->id }}' + "/edit/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            $('#modal-form').modal('show');
            $('.modal-title').text('Form Hapus ');
            
            $('#modal-header').removeClass('modal-header-add');
            $('#modal-footer').removeClass('modal-footer-add'); 
            $('#modal-header').removeClass('modal-header-edit');
            $('#modal-footer').removeClass('modal-footer-edit');
            $('#modal-header').addClass('modal-header-delete');
            $('#modal-footer').addClass('modal-footer-delete'); 
            $('#modal-header').removeClass('modal-header-show');
            $('#modal-footer').removeClass('modal-footer-show');

            $('#form-input').hide();
            $('#form-delete').show();
            $('#form-delete-text').text('Apakah anda yakin ingin menghapus data pada tanggal '+'"'+data.created_at.substring(0,10)+'"');
            $('#form-show').hide();

            $('#button-submit').show();
            $('#button-submit').removeClass('btn-primary');
            $('#button-submit').addClass('btn-danger');
            $('#button-submit').removeClass('btn-success');
            $('#button-submit').removeClass('btn-warning');
            $('#button-submit-text').text('Hapus');

            $('#id').val(data.id);
          },
          error : function() {
              alert("Nothing Data");
          }
        });
      }
      function exportPdfLaporan(id){
         $.ajax({
            url: "{{ url('admin') }}" + '/'+ {{ $user->id }}+'/laporan/export-pdf/' + id,
            type: "GET",
          });
      }  
      function kirimLaporan(id){
          var csrf_token = $('meta[name="csrf-token"]').attr('content');
          swal({
              title: 'Apakah anda yakin?',
              text: "akan mengirim laporan ini untuk diperiksa atasan anda\n {sementara waktu laporan ini tidak bisa diubah}",
              type: 'warning',
              showCancelButton: true,
              cancelButtonColor: '#d33',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Kirim'
          }).then(function () {
              $.ajax({
                  url: "{{ url('admin/laporan') }}"+ '/' + '{{ $user->id }}' + "/kirim/"+id,
                  type: "GET",
                  dataType: "JSON",
                  beforeSend: function(){
                     $("body").css("padding",'0px');
                     swal({
                          title: 'Sedang Memuat...',
                          onOpen: () => {
                            swal.showLoading()
                          }
                        }).catch(swal.noop);
                    },
                  success : function(data) {
                     $("body").css("padding",'0px');
                      table.ajax.reload();
                       swal({
                          title: data.title,
                          text: data.message,
                          type: data.type,
                          timer: data.timer,
                      }).catch(swal.noop);
                  },
                  error : function () {
                      swal({
                            title: 'Oops...',
                            text: 'gagal, silahkan refresh page terlebih dahulu',
                            type: 'error',
                            timer: 5000
                        }).catch(swal.noop);
                  }
              });
          }).catch(swal.noop);
        }

      $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                // if (!e.isDefaultPrevented()){
                    var id = $('#id').val();

                  if(save_method == 'delete'){
                    var csrf_token = $('meta[name="csrf-token"]').attr('content');
                      $.ajax({
                      url : "{{ url('admin/laporan') }}"+ '/' + '{{ $user->id }}' + "/delete/"+id,
                      type : "POST",
                      data : {'_method' : 'DELETE', '_token' : csrf_token},
                      beforeSend: function(){
                            $("body").css("padding",'0px');
                           swal({
                                title: 'Sedang Memuat...',
                                onOpen: () => {
                                  swal.showLoading()
                                }
                              }).catch(swal.noop);
                            },
                        success : function(data) {
                          $("body").css("padding",'0px');
                          $('#modal-form').modal('hide');
                            table.ajax.reload();
                            console.log(data);
                            swal({
                                title: data.title,
                                text: data.message,
                                type: data.type,
                                timer: data.timer,
                            }).catch(swal.noop);
                      },
                      error : function () {
                           swal({
                                title: 'Oops...',
                                text: 'gagal, menghapus',
                                type: 'error',
                                timer: 5000
                            }).catch(swal.noop);
                      }
                  });
                    return false;
                      
                  }else{
                    if (save_method == 'add') url = "{{ url('admin/laporan') }}";
                    else url = "{{ url('admin/laporan') . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
//                        data : $('#modal-form form').serialize(),
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                             $("body").css("padding",'0px');
                          swal({
                                title: 'Sedang Memuat...',
                                onOpen: () => {
                                  swal.showLoading()
                                }
                              }).catch(swal.noop);
                            },
                          success : function(data) {
                           $("body").css("padding",'0px');
                            if (data.title =='Mohon Diperhatikan!'){
                              swal({
                                  title: data.title,
                                  text: data.message,
                                  type: data.type,
                                  timer: data.timer,
                              }).catch(swal.noop);
                            }else{
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: data.title,
                                text: data.message,
                                type: data.type,
                                timer: data.timer,
                            }).catch(swal.noop);
                           }
                        },
                        error : function(data){
                            swal({
                                title: 'Oops...',
                                text: 'Maaf, pastikan semua kolom terisi dengan format yang benar',
                                type: 'error',
                                timer: 5000
                            }).catch(swal.noop);
                        }
                    });
                    return false;
                  }
            });
        });  

    $(function(){
            $('#modal-form-acc form').validator().on('submit', function (e) {
                // if (!e.isDefaultPrevented()){
                  var id = $('#id').val();
                    $.ajax({
                        url :"{{ url('admin/laporan-persetujuan')}}"+ '/' + id,
                        type : "POST",
                        data: new FormData($("#modal-form-acc form")[0]),
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                             $("body").css("padding",'0px');
                          swal({
                                title: 'Sedang Memuat...',
                                onOpen: () => {
                                  swal.showLoading()
                                }
                              }).catch(swal.noop);
                            },
                          success : function(data) {
                           $("body").css("padding",'0px');
                            if (data.title =='Mohon Maaf!'){
                              swal({
                                  title: data.title,
                                  text: data.message,
                                  type: data.type,
                                  timer: data.timer,
                              }).catch(swal.noop);
                            }else{
                            $('#modal-form-acc').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: data.title,
                                text: data.message,
                                type: data.type,
                                timer: data.timer,
                            }).catch(swal.noop);
                           }
                        },
                        error : function(data){
                            swal({
                                title: 'Oops...',
                                text: 'Maaf, pastikan semua kolom terisi dengan format yang benar',
                                type: 'error',
                                timer: 5000
                            }).catch(swal.noop);
                        }
                    });
                  return false;
                  });
          
        });

    </script>