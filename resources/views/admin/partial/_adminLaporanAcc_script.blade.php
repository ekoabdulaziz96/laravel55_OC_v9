<script>
function viewAccLaporan(user_id,id,status) {
  console.log(user_id +'|'+ id+status);
    save_method = 'edit';
    $('input[name=_method]').val('PATCH');
    $('#modal-form-acc form')[0].reset();
    $.ajax({
      url: "{{ url('admin/laporan') }}" + '/' + user_id+ "/edit/"+id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#modal-header-acc').removeClass('modal-header-acc-profil'); 
        $('#modal-footer-acc').removeClass('modal-footer-acc-profil'); 

        $('#modal-form-acc').modal('show');
        $('#form-profil').hide();
        $('#form-persetujuan').show();
        $('#button-acc-submit').show();
          $('#id').val(data.id); 
          $('#id_user').val(user_id); 

        if(status == 'ft_kacab'){
          $('#modal-form-acc-title').text('Persetujuan Laporan oleh Kepala Cabang ');
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

function viewProfil(id){

  $('#modal-header-acc').removeClass('modal-header-acc-kacab');
  $('#modal-footer-acc').removeClass('modal-footer-acc-kacab'); 
  $('#modal-header-acc').removeClass('modal-header-acc-manajer');
  $('#modal-footer-acc').removeClass('modal-footer-acc-manajer');
  $('#modal-header-acc').removeClass('modal-header-acc-direktur');
  $('#modal-header-acc').removeClass('modal-header-acc-direktur');

  $('#modal-header-acc').addClass('modal-header-acc-profil'); 
  $('#modal-footer-acc').addClass('modal-footer-acc-profil'); 

  $('#modal-form-acc').modal('show');
  $('#form-profil').show();
  $('#modal-form-acc-title').text('View Profil');

  $('#form-persetujuan').hide();
  $('#button-acc-submit').hide();
   $.ajax({
      url: "{{ url('admin/laporan/user') }}" + '/' + id,
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
           if(data.foto != '-') $('#view-form-profil-foto').attr('src',data.foto); 
           $('#view-form-profil-nama').text(data.nama); 
           $('#view-form-profil-no-hp').text(data.no_hp); 
           $('#view-form-profil-email').text(data.email); 
           $('#view-form-profil-status').text(data.status); 
           $('#view-form-profil-cabang').text(data.cabang); 
           $('#view-form-profil-wilayah').text(data.wilayah); 
        
      },
      error : function() {
          alert("Nothing Data");
      }
    });
}
    $(function(){
            $('#modal-form-acc form').validator().on('submit', function (e) {
                  var id = $('#id').val();
                  var id_user = $('#id_user').val();

                if('{{$status}}' == 'ft_admin' || '{{$status}}' == 'ft_sponsorship'){
                  var alamat = "{{ url('admin/')}}"+ '/' +id_user +'/laporan-acc-ft-admin-spons/'+id;
                }else if ('{{$status}}' == 'ft_kacab'){
                  var alamat = "{{ url('admin/')}}"+ '/' +id_user +'/laporan-acc-ft-kacab/'+id;
                }else  if('{{$status}}' == 'manajer'){
                  var alamat = "{{ url('admin/')}}"+ '/' +id_user +'/laporan-acc-manajer/'+id;
                }

                    $.ajax({
                        url :alamat,
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