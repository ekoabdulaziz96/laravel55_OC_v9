<script type="text/javascript">
@if (Auth::user()->active == 0)
  // setTimeout(function() {
		  document.getElementById('logout-form').submit();
	// }, 2000);
@endif

function readProfilURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#form-profil-foto-view')
                        .attr('src', e.target.result)
                        // .width(150)
                        // .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

 function userUpdateProfil(id){


  $('#modal-form-profil-title').text('Perbarui Profil');
  $('#modal-form-profil').modal('show');
  $('#form-profil-data-diri').show();
  	$('#form-profil-nama').attr('name','nama'); 
  	$('#form-profil-nama').attr('autofokus','autofokus'); 
  	$('#form-profil-nama').attr('autofokus','autofokus'); 
    $('#form-profil-no-hp').attr('name','no_hp'); 
    $('#form-profil-no-hp').attr('required','required'); 
    $('#form-profil-no-hp').attr('autofokus','autofokus'); 
    $('#form-profil-foto').attr('name','foto'); 

  $('#form-profil-view-email').hide();
    $('#form-profil-password').removeAttr('name','password'); 
    $('#form-profil-password').removeAttr('required','required'); 
    $('#form-profil-password').removeAttr('autofokus','autofokus'); 
    $('#form-profil-email').removeAttr('name','email'); 
    $('#form-profil-email').removeAttr('required','required'); 
    $('#form-profil-email').removeAttr('autofokus','autofokus'); 

  $('#form-profil-view-password').hide();
    $('#form-profil-password-lama').removeAttr('name','password_lama'); 
    $('#form-profil-password-lama').removeAttr('required','required'); 
    $('#form-profil-password-lama').removeAttr('autofokus','autofokus');     
    $('#form-profil-password-baru').removeAttr('name','password_baru'); 
    $('#form-profil-password-baru').removeAttr('required','required'); 
    $('#form-profil-password-baru').removeAttr('autofokus','autofokus');  
    $('#form-profil-password-baru-ulangi').removeAttr('name','password_baru_ulangi'); 
    $('#form-profil-password-baru-ulangi').removeAttr('required','required'); 
    $('#form-profil-password-baru-ulangi').removeAttr('autofokus','autofokus'); 

   console.log('cek');
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
        console.log(data);
           $('#type').val('profil'); 
           $('#id_user_profil').val(data.id); 
           $('#form-profil-nama').val(data.nama); 
           $('#form-profil-no-hp').val(data.no_hp); 
           $('#form-profil-status').text(data.status); 
           $('#form-profil-cabang').text(data.cabang); 
           $('#form-profil-wilayah').text(data.wilayah); 
        if(data.foto != '-'){
           		$('#form-profil-dt-foto').attr('src',data.foto);
           		$('#form-profil-dt-foto-download').attr('href',data.foto);
           }else {
              $('#form-profil-dt-foto-download').hide();
           }  
   console.log(id);

      },
      error : function() {
          alert("Nothing Data");
      }
    });
} 

function userUpdatePassword(id){

  $('#modal-form-profil-title').text('Perbarui Password');
  $('#modal-form-profil').modal('show');

  $('#form-profil-data-diri').hide();
  	$('#form-profil-nama').removeAttr('name','nama'); 
  	$('#form-profil-nama').removeAttr('autofokus','autofokus'); 
  	$('#form-profil-nama').removeAttr('autofokus','autofokus'); 
    $('#form-profil-no-hp').removeAttr('name','no_hp'); 
    $('#form-profil-no-hp').removeAttr('required','required'); 
    $('#form-profil-no-hp').removeAttr('autofokus','autofokus'); 
    $('#form-profil-foto').removeAttr('name','foto'); 

  $('#form-profil-view-email').hide();
    $('#form-profil-password').removeAttr('name','password'); 
    $('#form-profil-password').removeAttr('required','required'); 
    $('#form-profil-password').removeAttr('autofokus','autofokus'); 
    $('#form-profil-email').removeAttr('name','email'); 
    $('#form-profil-email').removeAttr('required','required'); 
    $('#form-profil-email').removeAttr('autofokus','autofokus'); 
    
  $('#form-profil-view-password').show();
    $('#form-profil-password-lama').attr('name','password_lama'); 
    $('#form-profil-password-lama').attr('required','required'); 
    $('#form-profil-password-lama').attr('autofokus','autofokus');     
    $('#form-profil-password-baru').attr('name','password_baru'); 
    $('#form-profil-password-baru').attr('required','required'); 
    $('#form-profil-password-baru').attr('autofokus','autofokus');  
    $('#form-profil-password-baru-ulangi').attr('name','password_baru_ulangi'); 
    $('#form-profil-password-baru-ulangi').attr('required','required'); 
    $('#form-profil-password-baru-ulangi').attr('autofokus','autofokus'); 

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
           $('#type').val('password'); 
           $('#id_user_profil').val(data.id); 
        
      },
      error : function() {
          alert("Nothing Data");
      }
    });
}
function userUpdateEmail(id){

  $('#modal-form-profil-title').text('Perbarui Email');
  $('#modal-form-profil').modal('show');

  $('#form-profil-data-diri').hide();
  	$('#form-profil-nama').removeAttr('name','nama'); 
  	$('#form-profil-nama').removeAttr('autofokus','autofokus'); 
  	$('#form-profil-nama').removeAttr('autofokus','autofokus'); 
    $('#form-profil-no-hp').removeAttr('name','no_hp'); 
    $('#form-profil-no-hp').removeAttr('required','required'); 
    $('#form-profil-no-hp').removeAttr('autofokus','autofokus'); 
    $('#form-profil-foto').removeAttr('name','foto'); 

  $('#form-profil-view-email').show();
    $('#form-profil-password').attr('name','password'); 
    $('#form-profil-password').attr('required','required'); 
    $('#form-profil-password').attr('autofokus','autofokus'); 
    $('#form-profil-email').attr('name','email'); 
    $('#form-profil-email').attr('required','required'); 
    $('#form-profil-email').attr('autofokus','autofokus'); 

  $('#form-profil-view-password').hide();
    $('#form-profil-password-lama').removeAttr('name','password_lama'); 
    $('#form-profil-password-lama').removeAttr('required','required'); 
    $('#form-profil-password-lama').removeAttr('autofokus','autofokus');     
    $('#form-profil-password-baru').removeAttr('name','password_baru'); 
    $('#form-profil-password-baru').removeAttr('required','required'); 
    $('#form-profil-password-baru').removeAttr('autofokus','autofokus');  
    $('#form-profil-password-baru-ulangi').removeAttr('name','password_baru_ulangi'); 
    $('#form-profil-password-baru-ulangi').removeAttr('required','required'); 
    $('#form-profil-password-baru-ulangi').removeAttr('autofokus','autofokus'); 

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
           $('#type').val('email'); 
           $('#id_user_profil').val(data.id); 
        
      },
      error : function() {
          alert("Nothing Data");
      }
    });
}

 $(function(){
    $('#modal-form-profil form').validator().on('submit', function (e) {
          var type = $('#type').val();

            $.ajax({
                url :'{{ route('admin.profil-update') }}',
                type : "POST",
                data: new FormData($("#modal-form-profil form")[0]),
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
                    $('#modal-form-profil').modal('hide');
                    swal({
                        title: data.title,
                        text: data.message,
                        type: data.type,
                        timer: data.timer,
                    }).catch(swal.noop);
                    setTimeout(function () { location.reload(1); }, 1500);
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