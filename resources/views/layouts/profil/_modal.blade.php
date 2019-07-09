
{{-- form model acc --}}
<div class="modal fade" id="modal-form-profil" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-profil-user" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div id="modal-header-profil" class=" modal-header modal-header-acc-profil">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title text-center" id="modal-form-profil-title" ></h3>
                </div>
  {{-- body --}}
                <div class="modal-body">
                    <input type="hidden" id="id_user_profil" name="id_user_profil">
                    {{-- <input type="hidden" id="id" name="id"> --}}
                    <input type="hidden" id="type" name="type">
         {{--dt diri  --}}
                  <span id="form-profil-data-diri">
                      <div class="row">
                      <div class="col-md-2" align="center">
                            <img id="form-profil-dt-foto" src="#" alt="belum ada foto"  width="100%"  >
                              <a id="form-profil-dt-foto-download" href="#" title="download gambar" download>download
                                <i class="fa fa-download" ></i>
                              </a>
                      </div>
                      <div class="col-md-10">
                         <table border="0" class="table table-responsive table-hover table-striped">
                          <tr>
                            <td width="2%"></td>
                            <td width="12%" >Status</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="form-profil-status"></td>
                          </tr> 
                          <tr>
                            <td width="2%" ></td>
                            <td width="12%" >Cabang</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="form-profil-cabang"></td>
                          </tr>  
                           <tr>
                            <td width="2%"></td>
                            <td width="12%" >Wilayah</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="form-profil-wilayah"></td>
                          </tr>      
                        </table>
                        <div class="form-group">
                            <label for="form-profil-nama" class="col-md-2">&nbsp;&nbsp;Nama :</label>
                            <div class="col-md-10">
                                <input type="text" id="form-profil-nama" name="nama" class="form-control" pattern="[a-zA-Z ]{1,20}" title="pastikan tidak lebih dr 20 karakter">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>                       
                        <div class="form-group">
                            <label for="form-profil-no-hp" class="col-md-2">&nbsp;&nbsp;Nomor HP :</label>
                            <div class="col-md-10">
                                <input type="text" id="form-profil-no-hp" name="no_hp" class="form-control" value="0800000000">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>    
                         <div class="form-group" >
                            <label for="form-profil-foto" class="col-md-2">&nbsp;&nbsp;Foto :</label>
                            <div class="col-md-10">
                                <input type="file" id="form-profil-foto" name="foto" class="form-control" onchange="readProfilURL(this);" >
                                <span class="help-block with-errors"></span>
                                <img id="form-profil-foto-view" src="" alt=""  width="150" height="200"/>

                            </div >
                          </div> 
                      </div>
                    </div>
              </span>
          {{-- email --}}
              <span id="form-profil-view-email">
                <p style="color: red" align="center"><u>"Harap Diperhatikan"</u><br>Ketika proses penggatian Email berhasil di lakukan, maka Anda akan diminta untuk melakukan aktivasi email kembali guna aktivasi akun anda.</p>
              
                  <div class="form-group">
                      <label for="form-profil-email" class="col-md-2 col-md-offset-1">Email Baru:</label>
                      <div class="col-md-8">
                          <input type="email" id="form-profil-email" name="email" class="form-control" >
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="form-profil-password" class="col-md-2 col-md-offset-1">Password:</label>
                      <div class="col-md-8">
                          <input type="password" id="form-profil-password" name="password" class="form-control" >
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>                      
              </span>
          {{-- password --}}
              <span id="form-profil-view-password">
                 <div class="form-group">
                      <label for="form-profil-password-lama" class="col-md-2 col-md-offset-1">Password Lama:</label>
                      <div class="col-md-8">
                          <input type="password" id="form-profil-password-lama" name="password_lama" class="form-control" >
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>                 
                  <div class="form-group">
                      <label for="form-profil-password-baru" class="col-md-2 col-md-offset-1">Password Baru:</label>
                      <div class="col-md-8">
                          <input type="password" id="form-profil-password-baru" name="password_baru" class="form-control" >
                          <span class="help-block with-errors"></span>
                      </div>
                  </div>                   
                  <div class="form-group">
                      <label for="form-profil-password-baru-ulangi" class="col-md-2 col-md-offset-1">Ulangi Password Baru:</label>
                      <div class="col-md-8">
                          <input type="password" id="form-profil-password-baru-ulangi" name="password_baru_ulangi" class="form-control" >
                          <span class="help-block with-errors"></span>
                      </div>
                  </div> 
              </span>

           </div>
{{-- footer --}}
          <div  id="modal-footer-profil" class=" modal-footer modal-footer-acc-profil">
              <button type="submit" class="btn btn-success" id="button-profil-submit"">Submit</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>            
          </div>
        </form>
      </div>
    </div>
</div>
    