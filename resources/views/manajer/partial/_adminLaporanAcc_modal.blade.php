{{-- form model acc --}}
<div class="modal fade" id="modal-form-acc" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-acc" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div id="modal-header-acc" class=" modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title text-center" id="modal-form-acc-title" >hhh</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_user" name="id_user">
                    <input type="hidden" id="id" name="id">
                  <span id="form-profil">
                      <div class="row">
                      <div class="col-md-2" align="center">
                        <br><br>
                          <img src="" alt="belum ada foto" width="100%" id="view-form-profil-foto">
                      </div>
                      <div class="col-md-10">
                        <table border="0" class="table table-responsive table-hover table-striped">
                          <tr>
                            <td width="2%"></td>
                            <td width="20%" >Nama</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="view-form-profil-nama"></td>
                          </tr>
                          <tr>
                            <td width="2%"></td>
                            <td width="20%" >No Hp</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="view-form-profil-no-hp"></td>
                          </tr> 
                          <tr>
                            <td width="2%"></td>
                            <td width="20%" >Email</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="view-form-profil-email"></td>
                          </tr> 
                          <tr>
                            <td width="2%"></td>
                            <td width="20%" >Status</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="view-form-profil-status"></td>
                          </tr> 
                          <tr>
                            <td width="2%" ></td>
                            <td width="20%" >Cabang</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="view-form-profil-cabang"></td>
                          </tr>  
                           <tr>
                            <td width="2%"></td>
                            <td width="20%" >Wilayah</td>
                            <td width="3%" align="center">:</td>
                            <td width="75%" id="view-form-profil-wilayah"></td>
                          </tr>      
                        </table>
                      </div>
                    </div>
              </span>
              <span id="form-persetujuan">
                  {{-- form input --}}

                    <div class="form-group">
                          <label for="persetujuan_dari" class="col-md-2 col-md-offset-1">Persetujuan Dari :</label>
                          <div class="col-md-8">
                              <input type="text"  id="persetujuan_dari" name="persetujuan_dari" class="form-control" readonly> 
                          </div>
                      </div> 
                        <div class="form-group" id="form-status_acc_laporan">
                          <label for="status_acc_laporan" class="col-md-2  col-md-offset-1" >Persetujuan Laporan : </label>
                            <div class="col-md-8">
                               <select  id="status_acc_laporan" name="status_acc_laporan" class="form-control " autofocus required style="width: 100% ;" >
                                  <option value=""> --pilih-- </option>
                                  <option value="baru" >Baru</option>
                                  <option value="proses" >Proses</option>
                                  <option value="perbaikan" >Perbaikan</option>
                                  <option value="disetujui" >Disetujui</option>
                                </select>
                              <span class="help-block with-errors"></span>
                           </div>
                        </div>

                     <div class="form-group">
                          <label for="komentar" class="col-md-2 col-md-offset-1">Komentar :</label>
                          <div class="col-md-8">
                              <textarea id="komentar" name="komentar" class="form-control" autofocus required title="maks 999" placeholder="tulis disini" rows="8">-</textarea>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div> 
                  {{-- end form input --}}
                      <br>
                      <hr>
                      <div align="center" ><span id="form-acc-show-laporan-title" class="text-center" style="font-size: 18pt;font-weight: bold;margin-bottom: 10%"></span>
                      </div>
                       <table class="table  table-responsive" >
                            <tr style="background-color: #C4ECEC" >
                              <td width="30%" align="center">Tanggal Laporan</td>
                              <td width="3%" align="center">:</td>
                              <td id="form-acc-show-tgl" width="67%"></td>
                            </tr>                             
                            <tr style="background-color: #C4ECEC" >
                              <td width="30%" align="center" >Kehadiran</td>
                              <td width="3%" align="center">:</td>
                              <td id="form-acc-show-kehadiran" width="67%"></td>
                            </tr> 
                      </table>
                      <span id="form-acc-show-laporan">
                       <table class="table table-striped table-responsive" style="">
                          @foreach ($form_all as $form)
                            <tr id="form-acc-show-{{ $form->slug }}">
                              <td width="5%" align="center" id="form-acc-show-no-{{ $form->slug }}"></td>
                                @if (substr($form->nama,0,10) != 'keterangan')
                                  <td width="20%" >{{ $form->nama }}</td>
                                @else
                                  <td width="20%" align="center"><i>keterangan:</i></td>
                                @endif
                              <td width="3%" align="center">:</td>
                              <td id="form-acc-show-data-{{ $form->slug }}" width="72%">
                                  @if ($form->tipe == 'file')
                                   <span id="form-acc-show-file-{{ $form->slug }}" > 
                                    <a href="#" id="form-acc-show-file-download-{{ $form->slug }}" download> 
                                      <i class="fa fa-2x fa-file-o" ></i>
                                        &nbsp; <span id="form-acc-show-file-text-{{ $form->slug }}"></span> &nbsp;
                                      <i class="fa fa-download"></i>
                                    </a>
                                  </span>
                                  @endif

                              </td>
                         </tr>
                          @endforeach
                                                         
                      </table>
                    </span>
                   {{-- end show form --}}
              </span>
                </div>

                <div  id="modal-footer-acc" class=" modal-footer">
                    <button type="submit" class="btn btn-success" id="button-acc-submit"">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>            
                </div>

            </form>
        </div>
    </div>
</div>   