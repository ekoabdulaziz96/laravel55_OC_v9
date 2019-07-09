
      <script>
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#admin_foto')
                        .attr('src', e.target.result)
                        // .width(150)
                        // .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

      function addUser() {
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

            $('#form-input').show();
             $('#id').val('');
             $('#admin_foto').attr('src','');

            $('#form-delete').hide();
            $('#form-show').hide();

            $('#button-submit').show();
            $('#button-submit').removeClass('btn-primary');
            $('#button-submit').removeClass('btn-danger');
            $('#button-submit').addClass('btn-success');
            $('#button-submit').removeClass('btn-warning');
            $('#button-submit-text').text('Tambah');

             $('#form_cabang').find('span').remove();
             $('#form_wilayah').find('span').remove();


            $('#status').change(function(){

               $('#form_cabang').find('span').remove();
               $('#form_wilayah').find('span').remove();
              var status = $("#status").val();
              if (status =='ft_kacab' || status =='ft_admin' || status =='ft_sponsorship' ){
               $('#form_cabang').append('<span> <div class="form-group"> <label for="cabang" class="col-md-2 col-md-offset-1">Cabang :</label> <div class="col-md-8"> <select  id="cabang" name="cabang" class="form-control " autofocus required style="width: 100% ;" >  <option value=""> --pilih-- </option> @foreach ($cabangs as $cabang) <option value="{{ $cabang->slug }}" >{{ $cabang->nama }}</option> @endforeach </select> <span class="help-block with-errors"></span> </div> </div> </span>');
              }
            });
            $('#form_cabang').change(function(){

               $('#form_wilayah').find('span').remove();

               $('#form_wilayah').append('<span><div class="form-group"> <label for="wilayah" class="col-md-2 col-md-offset-1">Wilayah :</label> <div class="col-md-8"> <select  id="wilayah" name="wilayah" class="form-control " autofocus required style="width: 100% ;" > </select> <span class="help-block with-errors"></span> </div> </div></span>');

              var cabang = $("#cabang").val();
                $.ajax({
                  url: "{{ url('admin/user/cabang') }}" + '/' + cabang,
                  type: "GET",
                  dataType: "JSON",
                  success: function(data) {
               $('#wilayah').find('option').remove();
                  

                    for(var i = 1; i <=data.maks_wilayah;i++){
                      $('#wilayah').append('<option value="'+i+'"> '+i+' </option>');
                    }
              
                  },
                  error : function() {
                      alert("Nothing Data");
                  }
                });
            });
           $('#admin_foto_download').hide(); 
      }

      function editUser(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin/user') }}" + '/' + id + "/edit",
          type: "GET",
          dataType: "JSON",
          success: function(data) {
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
            $('#keterangan-tipe').show();            
            $('#form-delete').hide();
            $('#form-show').hide();

            $('#button-submit').show();
            $('#button-submit').removeClass('btn-primary');
            $('#button-submit').removeClass('btn-danger');
            $('#button-submit').removeClass('btn-success');
            $('#button-submit').addClass('btn-warning');
            $('#button-submit-text').text('Perbarui');


            $('#id').val(data.id);   
            $('#nama').val(data.nama);
            $('#email').val(data.email);
            $('#password').val('*********');
            $('#no_hp').val(data.no_hp);
            $('#password').attr('readonly','readonly');
            $('#status').val(data.status);
              if(data.foto != '-'){
                $('#admin_foto').attr('src',data.foto); 
                $('#admin_foto_download').show(); 
                $('#admin_foto_download_link').attr('href',data.foto); 
              }else {
                $('#admin_foto').attr('src',''); 
                $('#admin_foto_download').hide(); 
              }


            $('#form_cabang').find('span').remove();
            $('#form_wilayah').find('span').remove();
            if(data.status == 'ft_sponsorship' || data.status == 'ft_kacab' || data.status == 'ft_admin' ){
                $('#form_cabang').append('<span> <div class="form-group"> <label for="cabang" class="col-md-2 col-md-offset-1">Cabang :</label> <div class="col-md-8"> <select  id="cabang" name="cabang" class="form-control " autofocus required style="width: 100% ;" >  <option value=""> --pilih-- </option> @foreach ($cabangs as $cabang) <option value="{{ $cabang->slug }}" >{{ $cabang->nama }}</option> @endforeach </select> <span class="help-block with-errors"></span> </div> </div> </span>');
            
             $('#cabang').val(data.cabang);

             $('#form_wilayah').append('<span><div class="form-group"> <label for="wilayah" class="col-md-2 col-md-offset-1">Wilayah :</label> <div class="col-md-8"> <select  id="wilayah" name="wilayah" class="form-control " autofocus required style="width: 100% ;" > </select> <span class="help-block with-errors"></span> </div> </div></span>');
              var cabang = $("#cabang").val();
                $.ajax({
                  url: "{{ url('admin/user/cabang') }}" + '/' + cabang,
                  type: "GET",
                  dataType: "JSON",
                  success: function(dt) {
                    $('#wilayah').find('option').remove();
                    for(var i = 1; i <=dt.maks_wilayah;i++){
                      if (i == data.wilayah){
                        $('#wilayah').append('<option value="'+i+'" selected> '+i+' </option>');
                      }else{
                        $('#wilayah').append('<option value="'+i+'"> '+i+' </option>');
                      }
                    }
                  }          
                })

              }

//change_event
            $('#status').change(function(){

               $('#form_cabang').find('span').remove();
               $('#form_wilayah').find('span').remove();
              var status = $("#status").val();
              if (status =='ft_kacab' || status =='ft_admin' || status =='ft_sponsorship' ){
               $('#form_cabang').append('<span> <div class="form-group"> <label for="cabang" class="col-md-2 col-md-offset-1">Cabang :</label> <div class="col-md-8"> <select  id="cabang" name="cabang" class="form-control " autofocus required style="width: 100% ;" >  <option value=""> --pilih-- </option> @foreach ($cabangs as $cabang) <option value="{{ $cabang->slug }}" >{{ $cabang->nama }}</option> @endforeach </select> <span class="help-block with-errors"></span> </div> </div> </span>');
              }
            })
            $('#form_cabang').change(function(){

               $('#form_wilayah').find('span').remove();

               $('#form_wilayah').append('<span><div class="form-group"> <label for="wilayah" class="col-md-2 col-md-offset-1">Wilayah :</label> <div class="col-md-8"> <select  id="wilayah" name="wilayah" class="form-control " autofocus required style="width: 100% ;" > </select> <span class="help-block with-errors"></span> </div> </div></span>');

              var cabang = $("#cabang").val();
                $.ajax({
                  url: "{{ url('admin/user/cabang') }}" + '/' + cabang,
                  type: "GET",
                  dataType: "JSON",
                  success: function(dt) {
                    $('#wilayah').find('option').remove();
                    for(var i = 1; i <=dt.maks_wilayah;i++){
                      if (i == data.wilayah && cabang ==data.cabang){
                        $('#wilayah').append('<option value="'+i+'" selected> '+i+' </option>');
                      }else{
                        $('#wilayah').append('<option value="'+i+'"> '+i+' </option>');
                      }
                    }
                  } ,
                  error : function() {
                      alert("Nothing Data");
                  }
                })
            })

          },
          error : function() {
              alert("Nothing Data");
          }
        });
      }  
function showUser(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin/user') }}" + '/' + id + "/edit",
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
              $('#form-show-foto').attr('src','url('+data.foto+')');
              $('#form-show-nama').text(data.nama);
              $('#form-show-email').text(data.email);
              $('#form-show-active').text(data.active);
              $('#form-show-status').text(data.status);
              $('#form-show-cabang').text(data.cabang);
              $('#form-show-wilayah').text(data.wilayah);
              if(data.foto == '-'){
                $('#form-show-foto').text(data.foto);
                $('#form-show-foto-src').attr('src','');
                $('#form_show_foto_download').hide(); 

              }else{
                $('#form-show-foto').text('');
                $('#form-show-foto-src').attr('src',data.foto); 
                $('#form_show_foto_download').show(); 
                $('#form_show_foto_download_link').attr('href',data.foto); 
              }
               
            $('#button-submit').hide();
          },
          error : function() {
              alert("Nothing Data");
          }
        });
      }
      
      function deleteUser(id) {
        save_method = 'delete';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin/user') }}" + '/' + id + "/edit",
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
            $('#form-delete-text').text('Apakah anda yakin ingin menghapus '+'"'+data.nama+'"');
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

      function resetPasswordUser(id){
          var csrf_token = $('meta[name="csrf-token"]').attr('content');
          swal({
              title: 'Apakah anda yakin?',
              text: "ingin reset password menjadi : onecareindonesia ",
              type: 'warning',
              showCancelButton: true,
              cancelButtonColor: '#d33',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Reset Password'
          }).then(function () {
              $.ajax({
                  url: "{{ url('admin/user/password') }}" + '/' + id,
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
                            text: 'gagal, reset',
                            type: 'error',
                            timer: 5000
                        }).catch(swal.noop);
                  }
              });
          }).catch(swal.noop);
        }      

  function resetFotoUser(id){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    swal({
        title: 'Apakah anda yakin?',
        text: "ingin reset foto yang tersimpan",
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Reset Foto'
    }).then(function () {
        $.ajax({
            url: "{{ url('admin/user/foto') }}" + '/' + id,
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
                      text: 'gagal, reset',
                      type: 'error',
                      timer: 5000
                  }).catch(swal.noop);
            }
        });
    }).catch(swal.noop);
  }

      $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                    var id = $('#id').val();

                  if(save_method == 'delete'){
                    var csrf_token = $('meta[name="csrf-token"]').attr('content');
                      $.ajax({
                      url : "{{ url('admin/user') }}" + '/' + id,
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
                    if (save_method == 'add') url = "{{ url('admin/user') }}";
                    else url = "{{ url('admin/user') . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
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

    </script>