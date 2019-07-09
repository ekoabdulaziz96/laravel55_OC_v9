
      <script>
     $(document).on('click', '#pilihan-tambah', function(){
           var btnhapus = "<span class='col-md-1'><button type='button' class='btn btn-danger' id='pilihan-hapus'><i class='fa fa-trash' aria-hidden='true'></i></button></span>";
           $('#pilihan-set').append('<span id="pilihan-list"><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" placeholder="pilihan" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btnhapus+'</div></span>');
            // console.log('cek');
   
    });
    $(document).on('click', '#pilihan-hapus', function(){
        $(this).parents('#pilihan-list').remove();
    });


      function addForm() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        // $('#ModalAdd').modal('show');
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
            $('#keterangan-tipe').hide();
            $('#form-delete').hide();
            $('#form-show').hide();

            $('#button-submit').show();
            $('#button-submit').removeClass('btn-primary');
            $('#button-submit').removeClass('btn-danger');
            $('#button-submit').addClass('btn-success');
            $('#button-submit').removeClass('btn-warning');
            $('#button-submit-text').text('Tambah');

            $('#nama').removeAttr('readonly','readonly');
            $('#urutan').removeAttr('readonly','readonly');
            
            $('#view').removeAttr('readonly','readonly');
            $('#kategori').removeAttr('readonly','readonly');
            $("#view1").iCheck('check');
            $("#kategori2").iCheck('check');
            $('#form-tipe').show();


            $('#textarea-set').find('span').remove();
            $('#pilihan-set').find('span').remove();

            $('#form-warning').hide();

            $('#tipe').change(function(){
            var tipe= $("#tipe").val();
            if (tipe=='textarea'){
               $('#textarea-set').find('span').remove();
               $('#pilihan-set').find('span').remove();
               $('#form-warning').hide();
               $('#textarea-set').append('<span> <div class="form-group"> <label for="set_row" class="col-md-2 col-md-offset-1" align="right">lebar :</label> <div class="col-md-8"> <input type="text" id="set_row" name="set_row" class="form-control" placeholder="10" autofocus >  <span class="help-block with-errors" style="color:red"><i>*pastikan diisi dg format angka (0-9) maks 100, jika tidak maka diberlakukan default value<i/></span></div></div></span>');
        
            }else if (tipe =='radio' || tipe=='checkbox' || tipe=='select'){

              $('#pilihan-set').find('span').remove();
              $('#textarea-set').find('span').remove();
               $('#form-warning').show();
              var btntambah = "<span class='col-md-1'><button type='button' class='btn btn-success' id='pilihan-tambah'><i class='fa fa-plus' aria-hidden='true'></i></button></span>";
               $('#pilihan-set').append('<span><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" placeholder="pilihan" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btntambah+'</div></span>');
            }else {
              $('#textarea-set').find('span').remove();
              $('#pilihan-set').find('span').remove();
              $('#form-warning').hide();             
            }
        });
      }

      function editFormKet(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin/form') }}" + '/' + id + "/edit",
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
            $('#button-submit-text').text('Update');


            $('#id').val(data.id);
      
            $('#nama').val(data.nama);
            $('#nama').attr('readonly','readonly');
            $('#urutan').val(data.urutan);
            $('#urutan').attr('readonly','readonly');
            $('#tipe').val(data.tipe);
            $('#form-tipe').hide();
            $('#ket-tipe').val(data.tipe);
            $('#ket-tipe').attr('readonly','readonly');
            
            if(data.kategori == '1_formula_pagi'){
              $("#kategori1").iCheck('check');
            }else if (data.kategori == '2_formula_inti'){
              $("#kategori2").iCheck('check');
            }else{
              $("#kategori3").iCheck('check');
            }
              $("#kategori1,#kategori2,#kategori3").iCheck('disable');

            if(data.view == 'show'){
              $("#view1").iCheck('check');
            }else{
              $("#view2").iCheck('check');
            }
              $("#view1,#view2").iCheck('disable');

// ready function
           if (data.tipe=='textarea'){
              $('#textarea-set').find('span').remove();
              $('#pilihan-set').find('span').remove();
               $('#form-warning').hide();
             $('#textarea-set').append('<span> <div class="form-group"> <label for="set_row" class="col-md-2 col-md-offset-1" align="right">lebar :</label> <div class="col-md-8"> <input type="text" id="set_row" name="set_row" class="form-control" placeholder="10" autofocus >  <span class="help-block with-errors"></span></div></div></span>');
                $('#set_row').val(data.set_row);
              }

          },
          error : function() {
              alert("Nothing Data");
          }
        });
      }   

      function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin/form') }}" + '/' + id + "/edit",
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
            $('#keterangan-tipe').hide();
            $('#form-delete').hide();
            $('#form-show').hide();

            $('#button-submit').show();
            $('#button-submit').removeClass('btn-primary');
            $('#button-submit').removeClass('btn-danger');
            $('#button-submit').removeClass('btn-success');
            $('#button-submit').addClass('btn-warning');
            $('#button-submit-text').text('Update');


            $('#id').val(data.id);
            $('#nama').val(data.nama);
            $('#tipe').val(data.tipe);
            $('#urutan').val(data.urutan);

            if(data.kategori == '1_formula_pagi'){
              $("#kategori1").iCheck('check');
            }else if (data.kategori == '2_formula_inti'){
              $("#kategori2").iCheck('check');
            }else{
              $("#kategori3").iCheck('check');
            }
              $("#kategori1,#kategori2,#kategori3").iCheck('enable');

            if(data.view == 'show'){
              $("#view1").iCheck('check');
            }else{
              $("#view2").iCheck('check');
            }
              $("#view1,#view2").iCheck('enable');

            $('#nama').removeAttr('readonly','readonly');
            $('#urutan').removeAttr('readonly','readonly');
            $('#form-tipe').show();

// ready function
           if (data.tipe=='textarea'){
              $('#textarea-set').find('span').remove();
              $('#pilihan-set').find('span').remove();
               $('#form-warning').hide();

              $('#textarea-set').append('<span> <div class="form-group"> <label for="set_row" class="col-md-2 col-md-offset-1" align="right">lebar :</label> <div class="col-md-8"> <input type="text" id="set_row" name="set_row" class="form-control" placeholder="10" autofocus >  <span class="help-block with-errors" ></span></div></div></span>');
                $('#set_row').val(data.set_row);
        
            }else if (data.tipe =='radio' || data.tipe=='checkbox' || data.tipe=='select'){
               $('#textarea-set').find('span').remove();
               $('#pilihan-set').find('span').remove();
               $('#form-warning').show();

              var btntambah = "<span class='col-md-1'><button type='button' class='btn btn-success' id='pilihan-tambah'><i class='fa fa-plus' aria-hidden='true'></i></button></span>";
               $('#pilihan-set').append('<span><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" value="'+data.pilihan[0].nama+'" placeholder="pilihan" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btntambah+'</div></span>');

                for(var i = 1;i < data.count; i++){
                  var btnhapus = "<span class='col-md-1'><button type='button' class='btn btn-danger' id='pilihan-hapus'><i class='fa fa-trash' aria-hidden='true'></i></button></span>";
                   $('#pilihan-set').append('<span id="pilihan-list"><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" placeholder="pilihan" value="'+data.pilihan[i].nama+'" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btnhapus+'</div></span>');
                    // console.log('cek');
                };
            }else {
              $('#textarea-set').find('span').remove();
              $('#pilihan-set').find('span').remove();
               $('#form-warning').hide();            
            }
// change function
    $('#tipe').change(function(){
        var tipe= $("#tipe").val();
        if (tipe=='textarea'){
           if (data.tipe=='textarea'){
            $('#set_row').val(data.set_row);
             $('#form-warning').hide();
          }else {
           $('#textarea-set').find('span').remove();
           $('#pilihan-set').find('span').remove();
           $('#form-warning').hide();
           $('#textarea-set').append('<span> <div class=\"form-group {{ $errors->has("set_row") ? "has-error" : "" }}\"> <label for="set_row" class="col-md-2 col-md-offset-1" align="right">lebar :</label> <div class="col-md-8"> <input type="text" id="set_row" name="set_row" pattern="[0-9]{1,3}" title="hanya angka 0-9, maks 100" class="form-control" placeholder="10" autofocus required> @if ($errors->has("set_row")) <span class="help-block"> <strong>{{ $errors->first("set_row") }}</strong></span> @endif </div></div></span>');
          }
    
        }else if (tipe =='radio'){
             if (data.tipe=='radio'){
                $('#pilihan-set').find('span').remove();
                $('#textarea-set').find('span').remove();
                $('#form-warning').show();
               var btntambah = "<span class='col-md-1'><button type='button' class='btn btn-success' id='pilihan-tambah'><i class='fa fa-plus' aria-hidden='true'></i></button></span>";
               $('#pilihan-set').append('<span><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" value="'+data.pilihan[0].nama+'" placeholder="pilihan" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btntambah+'</div></span>');

                for(var i = 1;i < data.count; i++){
                  var btnhapus = "<span class='col-md-1'><button type='button' class='btn btn-danger' id='pilihan-hapus'><i class='fa fa-trash' aria-hidden='true'></i></button></span>";
                   $('#pilihan-set').append('<span id="pilihan-list"><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" placeholder="pilihan" value="'+data.pilihan[i].nama+'" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btnhapus+'</div></span>');
                    // console.log('cek');
                };
            }else{
              $('#pilihan-set').find('span').remove();
              $('#textarea-set').find('span').remove();
               $('#form-warning').show();
              var btntambah = "<span class='col-md-1'><button type='button' class='btn btn-success' id='pilihan-tambah'><i class='fa fa-plus' aria-hidden='true'></i></button></span>";
               $('#pilihan-set').append('<span><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" placeholder="pilihan" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btntambah+'</div></span>');
                }
        }else if ( tipe=='checkbox' ){
           if (data.tipe=='checkbox'){
                $('#pilihan-set').find('span').remove();
                $('#textarea-set').find('span').remove();
                $('#form-warning').show();
               var btntambah = "<span class='col-md-1'><button type='button' class='btn btn-success' id='pilihan-tambah'><i class='fa fa-plus' aria-hidden='true'></i></button></span>";
               $('#pilihan-set').append('<span><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" value="'+data.pilihan[0].nama+'" placeholder="pilihan" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btntambah+'</div></span>');

                for(var i = 1;i < data.count; i++){
                  var btnhapus = "<span class='col-md-1'><button type='button' class='btn btn-danger' id='pilihan-hapus'><i class='fa fa-trash' aria-hidden='true'></i></button></span>";
                   $('#pilihan-set').append('<span id="pilihan-list"><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" placeholder="pilihan" value="'+data.pilihan[i].nama+'" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btnhapus+'</div></span>');
                    // console.log('cek');
                };
            }else{
              $('#pilihan-set').find('span').remove();
              $('#textarea-set').find('span').remove();
               $('#form-warning').show();
              var btntambah = "<span class='col-md-1'><button type='button' class='btn btn-success' id='pilihan-tambah'><i class='fa fa-plus' aria-hidden='true'></i></button></span>";
               $('#pilihan-set').append('<span><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" placeholder="pilihan" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btntambah+'</div></span>');
                }
        }else if ( tipe=='select' ){
           if (data.tipe=='select'){
                $('#pilihan-set').find('span').remove();
                $('#textarea-set').find('span').remove();
               $('#form-warning').show();
               var btntambah = "<span class='col-md-1'><button type='button' class='btn btn-success' id='pilihan-tambah'><i class='fa fa-plus' aria-hidden='true'></i></button></span>";
               $('#pilihan-set').append('<span><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" value="'+data.pilihan[0].nama+'" placeholder="pilihan" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btntambah+'</div></span>');

                for(var i = 1;i < data.count; i++){
                  var btnhapus = "<span class='col-md-1'><button type='button' class='btn btn-danger' id='pilihan-hapus'><i class='fa fa-trash' aria-hidden='true'></i></button></span>";
                   $('#pilihan-set').append('<span id="pilihan-list"><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" placeholder="pilihan" value="'+data.pilihan[i].nama+'" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btnhapus+'</div></span>');
                    // console.log('cek');
                };
            }else{
              $('#pilihan-set').find('span').remove();
              $('#textarea-set').find('span').remove();
               $('#form-warning').show();
              var btntambah = "<span class='col-md-1'><button type='button' class='btn btn-success' id='pilihan-tambah'><i class='fa fa-plus' aria-hidden='true'></i></button></span>";
               $('#pilihan-set').append('<span><div class=\"form-group {{ $errors->has("pilihan[]") ? "has-error" : "" }}\"> <label for="pilihan" class="col-md-2 col-md-offset-1" align="right">List pilihan :</label> <div class="col-md-7"> <input type="text"  name="pilihan[]" class="form-control" placeholder="pilihan" autofocus required>  @if ($errors->has("pilihan[]")) <span class="help-block"> <strong>{{ $errors->first("pilihan") }}</strong></span> @endif</div> '+btntambah+'</div></span>');
                }

        }else {
          $('#textarea-set').find('span').remove();
          $('#pilihan-set').find('span').remove();
          $('#form-warning').hide();
        }
    });


          },
          error : function() {
              alert("Nothing Data");
          }
        });
      }
      function deleteForm(id) {
        save_method = 'delete';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin/form') }}" + '/' + id + "/edit",
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
            $('#nama').val(data.nama);
          },
          error : function() {
              alert("Nothing Data");
          }
        });
      }

       function showForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin/form') }}" + '/' + id,
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
           if(data.tipe == 'text'){
              $('#form-show-text').show();
               $('#show-text-label').text(data.nama+ ' : ');
               $('#show-text').attr('placeholder',data.nama);
              $('#form-show-textarea').hide();
              $('#form-show-date').hide();
              $('#form-show-time').hide();
              $('#form-show-file').hide();
              $('#form-show-checkbox').hide();
              $('#form-show-radio').hide();
              $('#form-show-select').hide();
              
           }else if(data.tipe == 'date'){
              $('#form-show-text').hide();
              $('#form-show-textarea').hide();
              $('#form-show-date').show();
               $('#show-date-label').text(data.nama+ ' : ');
               $('#show-date').attr('placeholder','2018-04-28');
              $('#form-show-file').hide();
              $('#form-show-time').hide();
              $('#form-show-checkbox').hide();
              $('#form-show-radio').hide();
              $('#form-show-select').hide();
              
           }else if(data.tipe == 'time'){
              $('#form-show-text').hide();
              $('#form-show-textarea').hide();
              $('#form-show-date').hide();
              $('#form-show-time').show();
               $('#show-time-label').text(data.nama+ ' : ');
               $('#show-time').attr('placeholder','23:55');
              $('#form-show-file').hide();
              $('#form-show-checkbox').hide();
              $('#form-show-radio').hide();
              $('#form-show-select').hide();
              
           }else if(data.tipe == 'file'){
              $('#form-show-text').hide();
              $('#form-show-textarea').hide();
              $('#form-show-date').hide();
              $('#form-show-time').hide();
              $('#form-show-file').show();
               $('#show-file-label').text(data.nama+ ' : ');
              $('#form-show-checkbox').hide();
              $('#form-show-radio').hide();
              $('#form-show-select').hide();
              
           }else if(data.tipe == 'textarea'){
              $('#form-show-text').hide();
              $('#form-show-textarea').show();
               $('#show-textarea-label').text(data.nama+ ' : ');
               $('#show-textarea').attr('placeholder',data.nama);
               $('#show-textarea').attr('rows',data.set_row);
              $('#form-show-date').hide();
              $('#form-show-time').hide();
              $('#form-show-file').hide();
              $('#form-show-checkbox').hide();
              $('#form-show-radio').hide();
              $('#form-show-select').hide();
              // console.log(data.set_row);
           }else if(data.tipe == 'checkbox'){
              $('#form-show-text').hide();
              $('#form-show-textarea').hide();
              $('#form-show-date').hide();
              $('#form-show-time').hide();
              $('#form-show-file').hide();
              $('#form-show-checkbox').show();
               $('#show-checkbox-label').text(data.nama+ ' : ');
               $('#show-checkbox').find('input').remove();
               $('#show-checkbox').find('label').remove();
               $('#show-checkbox').find('br').remove();
              for(var i = 0;i < data.count; i++){
                $('#show-checkbox').append('<label class="form-control"> <input type="checkbox" class="flat" name="checkbox[]" autocomplete="off">&nbsp;'+data.pilihan[i].nama+'</label>');
              }
                  $('input[type="checkbox"], input[type="radio"]').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass   : 'iradio_flat-green'
                  });
              $('#form-show-radio').hide();
              $('#form-show-select').hide();
            } else if(data.tipe == 'radio'){
              $('#form-show-text').hide();
              $('#form-show-textarea').hide();
              $('#form-show-date').hide();
              $('#form-show-time').hide();
              $('#form-show-file').hide();
              $('#form-show-checkbox').hide();
              $('#form-show-radio').show();
               $('#show-radio-label').text(data.nama+ ' : ');
               $('#show-radio').find('input').remove();
               $('#show-radio').find('label').remove();
               $('#show-radio').find('br').remove();
              for(var i = 0;i < data.count; i++){
                $('#show-radio').append('<label class="form-control"> <input type="radio" class="flat" name="radio[]" autocomplete="off">&nbsp;'+data.pilihan[i].nama+'</label>');
              }
                  $('input[type="checkbox"], input[type="radio"]').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass   : 'iradio_flat-green'
                  });

              $('#form-show-select').hide();
            }else if(data.tipe == 'select'){
              $('#form-show-text').hide();
              $('#form-show-textarea').hide();
              $('#form-show-date').hide();
              $('#form-show-time').hide();
              $('#form-show-file').hide();
              $('#form-show-checkbox').hide();
              $('#form-show-radio').hide();
              $('#form-show-select').show();
               $('#show-select-label').text(data.nama+ ' : ');
               $('#show-select').find('option').remove();
               $('#show-select').append('<option value=""> --pilih-- </option>');
              var x = document.getElementById("show-select");
             
              var j = 0;
              for(var i = 0;i < data.count; i++){
                  j = document.createElement("option");
                  j.text = data.pilihan[i].nama;
                 x.options.add(j, i+1);
                 j++;
              }
            }
            $('#button-submit').hide();
          },
          error : function() {
              alert("Nothing Data");
          }
        });
      }


      $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                    var id = $('#id').val();

                  if(save_method == 'delete'){

                    var csrf_token = $('meta[name="csrf-token"]').attr('content');
                      $.ajax({
                      url : "{{ url('admin/form') }}" + '/' + id,
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
                    if (save_method == 'add') url = "{{ url('admin/form') }}";
                    else url = "{{ url('admin/form') . '/' }}" + id;

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