<style>
    .container {
      position: relative;
      width: 50%;
      max-width: 400px;
      height: auto;
      /*background-color: black;*/
      
    }

    .image {
      display: block;
      width: 50%;
      height: auto;
    }

    .overlay {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      height: 100%;
      width: 100%;
      opacity: 0;
      transition: .3s ease;
      /*background-color: red;*/
    }

    .container:hover .overlay {
      opacity: 1;
    }

    .icon {
      color:  #AFAAAA;
      font-size: 100px;
      position: absolute;
      top: 75%;
      left: 50%;
      transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      text-align: center;
    }

    .fa-download:hover {
      color: #EEEEEE;
    }
</style>

{{-- form model --}}
<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-form" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header" id="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title text-center" ></h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    {{-- input form --}}
                   <span id="form-input">

                     <div class="form-group">
                          <label for="nama" class="col-md-2 col-md-offset-1">Nama :</label>
                          <div class="col-md-8">
                              <input type="text" id="nama" name="nama" class="form-control" autofocus required pattern="[a-zA-Z ]{1,20}" title="pastikan tidak lebih dr 20 karakter">
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>                       
                      <div class="form-group">
                          <label for="no_hp" class="col-md-2 col-md-offset-1">Nomor HP :</label>
                          <div class="col-md-8">
                              <input type="text" id="no_hp" name="no_hp" class="form-control" autofocus required value="0800000000">
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>    
                   
                      <div class="form-group">
                          <label for="email" class="col-md-2 col-md-offset-1">Email :</label>
                          <div class="col-md-8">
                              <input type="email" id="email" name="email" class="form-control" autofocus required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>                       
                      <div class="form-group">
                          <label for="password" class="col-md-2 col-md-offset-1">password :</label>
                          <div class="col-md-8">
                              <input type="text" id="password" name="password" class="form-control" autofocus required value="onecareindonesia">
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>                       
                     {{--  <div class="form-group">
                          <label for="password_confirmation" class="col-md-2 col-md-offset-1">Konfirmasi Password :</label>
                          <div class="col-md-8">
                              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autofocus required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div> --}}
                        <div class="form-group">
                          <label for="status" class="col-md-2 col-md-offset-1">Status :</label>
                            <div class="col-md-8">
                               <select  id="status" name="status" class="form-control " autofocus required style="width: 100% ;" >
                                  <option value=""> --pilih-- </option>
                                  <option value="super_admin" >Super Admin</option>
                                  <option value="direktur" >Direktur</option>
                                  <option value="manajer" >Manajer </option>
                                  <option value="ft_kacab" >FT Kepala Cabang</option>
                                  <option value="ft_admin" >FT Admin</option>
                                  <option value="ft_sponsorship" >FT Sponsorship</option>
                                </select>
                              <span class="help-block with-errors"></span>
                           </div>
                      </div>    
                      <div id="form_cabang">

                      </div>    
                      <div id="form_wilayah" >

                      </div>                          
                      <div class="form-group" >
                          <label for="foto" class="col-md-2 col-md-offset-1">Foto :</label>
                          <div class="col-md-8">
                              <input type="file" id="foto" name="foto" class="form-control" onchange="readURL(this);" >
                              <span class="help-block with-errors"></span>
                          </div >

                          {{-- <img id="admin_foto" src="#" alt="belum ada gambar"  width="150" height="200"/> --}}
                      </div> 
                         <div class="container" align="center">
                            <img id="admin_foto" src="#" alt="belum ada gambar"  class="image">
                            <span class="overlay" id="admin_foto_download">
                              <a id="admin_foto_download_link" href="#" class="icon" title="download gambar" download>
                                <i class="fa fa-download" ></i>
                              </a>
                            </span>
                          </div>
           
                    </span>
                    {{-- end input form --}}
                    
                    {{-- show form --}}
                   <span id="form-show">
                       
                             <table id="form-show-table" class="table table-striped table-responsive" style="">
                              <tr>
                                <td width="30%" align="center">Nama</td>
                                <td width="3%" align="center">:</td>
                                <td id="form-show-nama" width="67%"></td>
                              </tr>                              
                              <tr>
                                <td width="30%" align="center">Email</td>
                                <td width="3%" align="center">:</td>
                                <td id="form-show-email" width="67%"></td>
                              </tr>
                              <tr>
                                <td width="30%" align="center">Active</td>
                                <td width="3%" align="center">:</td>
                                <td id="form-show-active" width="67%"></td>
                              </tr>                              
                               <tr>
                                <td width="30%" align="center">status</td>
                                <td width="3%" align="center">:</td>
                                <td id="form-show-status" width="67%"></td>
                              </tr>
                              <tr>
                                <td width="30%" align="center">Cabang</td>
                                <td width="3%" align="center">:</td>
                                <td id="form-show-cabang" width="67%"></td>
                              </tr>
                               <tr>
                                <td width="30%" align="center">wilayah</td>
                                <td width="3%" align="center">:</td>
                                <td id="form-show-wilayah" width="67%"></td>
                              </tr>    
                              <tr>
                                <td width="30%" align="center">Foto</td>
                                <td width="3%" align="center">:</td>
                                <td  width="67%" >
{{--                                   <span align="center">
                                    <img class="rounded-square pull-center" align="center" width="30%" height="20%" src="" alt="" id="form-show-foto-src">
                                    </span>
                                    <span id="form-show-foto"></span> --}}
                                     <div class="container" align="center" style="margin-left: -12%">
                                      <img id="form-show-foto-src" src="#" alt="belum ada gambar"  class="image">
                                      <span class="overlay" id="form_show_foto_download">
                                        <a id="form_show_foto_download_link" href="#" class="icon" title="download gambar" download>
                                          <i class="fa fa-download" ></i>
                                        </a>
                                      </span>
                                  </div>
                                </td>
                              </tr>                               
                           </table>
                    </span>

                  {{-- delete form --}}
                   <span id="form-delete" class="inline">
                     <p class="text-center" id="form-delete-text"></p>
                   </span>
                   {{-- end delete form --}}
                </div>

                <div class="modal-footer" id="modal-footer">
                    <span >
                      <button id="button-submit" type="submit"  class="btn btn-primary btn-save">
                        <span id="button-submit-text">Submit</span>
                      </button>
                    </span>
                    <span id="button-cancel">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                      <span id="button-cancel-text">Cancel</span>
                    </button>            
                    </span>
                </div>

            </form>
        </div>
    </div>
</div>