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
                    <input type="hidden" id="id_user" name="id_user" value="{{ $user->id }}">
                    <input type="hidden" id="id" name="id">

                    {{-- input form--}}
                   <span id="form-input">
                      <div class="form-group">
                          <label for="created_at" class="col-md-2 col-md-offset-1">Tanggal Laporan :</label>
                          <div class="col-md-8">
                              <input type="text" id="created_at" name="created_at" class="form-control" readonly >
                              <span class="help-block with-errors"></span>
                          </div>
                      </div>
                        <div class="form-group" >
                          <label for="kehadiran" class="col-md-2 col-md-offset-1 " >Kehadiran : </label>
                            <div class="col-md-8">
                               <select  id="kehadiran" name="kehadiran" class="form-control " autofocus required style="width: 100% ;" >
                                  <option value=""> --pilih-- </option>
                                  <option value="hadir" >Hadir</option>
                                  <option value="libur" >Libur</option>
                                  <option value="cuti" >Cuti</option>
                                  <option value="ijin" >Ijin</option>
                                  <option value="alpha" >Alpha (tanpa keterangan)</option>
                                </select>
                              <span class="help-block with-errors"></span>
                           </div>
                        </div>

                    {{-- input form hadir--}}
                   <span id="form-input-hadir">
                     @foreach ($form_all as $form)
                     @if ($form->tipe =='text')
                     <span id="view_{{ $form->slug }}">
                        <div class="form-group" >
                           @if (substr($form->nama,0,10) != 'keterangan') 
                            <hr>
                              <label class="col-md-1 text-center" id="view_no_{{ $form->slug }}"></label>
                           @else 
                              <label class="col-md-1"></label>
                           @endif
                            <label for="{{ $form->slug }}" class="col-md-2">{{ $form->nama }}</label>
                            <div class="col-md-8">
                                <input type="text" id="{{ $form->slug }}" name="{{ $form->slug }}" class="form-control" placeholder="{{ $form->nama }}" autofocus required >
                                <span class="help-block with-errors"></span>
                            </div>
                       </div>
                      </span>

                       @elseif($form->tipe =='textarea')
                         <span id="view_{{ $form->slug }}">
                           <div class="form-group" >
                            @if (substr($form->nama,0,10) != 'keterangan') 
                                <hr>
                              <label class="col-md-1 text-center" id="view_no_{{ $form->slug }}"></label>
                            @else
                              <label class="col-md-1"></label>
                            @endif                           
                              @if (substr($form->nama,0,10) == 'keterangan')
                                  <label for="{{ $form->slug }}" class="col-md-2 " style="font-size: 10"><i>keterangan:</i></label>
                                  <div class="col-md-8">
                                    <textarea id="{{ $form->slug }}" name="{{ $form->slug }}" placeholder="{{ $form->nama }}" class="form-control" cols="10" rows="{{ $form->set_row }}" ></textarea>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                @else
                                  <label for="{{ $form->slug }}" class="col-md-2 ">{{ $form->nama }}</label>
                                  <div class="col-md-8">
                                    <textarea id="{{ $form->slug }}" name="{{ $form->slug }}" placeholder="{{ $form->nama }}" class="form-control" cols="10" rows="{{ $form->set_row }}" required autofocus></textarea>
                                      <span class="help-block with-errors"></span>
                                  </div>
                                @endif


                            </div> 
                          </span>

                        @elseif($form->tipe =='date')
                         <span id="view_{{ $form->slug }}">
                           <div class="form-group" >
                            @if (substr($form->nama,0,10) != 'keterangan') 
                                <hr>
                              <label class="col-md-1 text-center" id="view_no_{{ $form->slug }}"></label>
                            @else
                              <label class="col-md-1"></label>
                            @endif                           
                              <label for="{{ $form->slug }}"  class="col-md-2 ">{{ $form->nama }}</label>
                                <div class="col-md-8">
                                  <div class="input-group date">
                                    <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right formdatepicker" id="{{ $form->slug }}" name="{{ $form->slug }}" autofocus required placeholder="2018-12-30">
                                  </div>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div> 
                        </span>

                        @elseif($form->tipe =='time')
                         <span id="view_{{ $form->slug }}">
                           <div class="form-group" >
                            @if (substr($form->nama,0,10) != 'keterangan') 
                                <hr>
                              <label class="col-md-1 text-center" id="view_no_{{ $form->slug }}"></label>
                            @else
                              <label class="col-md-1"></label>
                            @endif                           
                              <label for="{{ $form->slug }}" class="col-md-2  ">{{ $form->nama }}</label>
                                <div class="col-md-8">
                                   <div class="input-group bootstrap-timepicker">
                                    <div class="input-group-addon">
                                      <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right timepicker" id="{{ $form->slug }}" name="{{ $form->slug }}" required autofocus placeholder="23:59">
                                  </div>
      
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>    
                          </span>

                        @elseif($form->tipe =='file')
                         <span id="view_{{ $form->slug }}">
                           <div class="form-group" >
                            @if (substr($form->nama,0,10) != 'keterangan') 
                                <hr>
                              <label class="col-md-1 text-center" id="view_no_{{ $form->slug }}"></label>
                            @else
                              <label class="col-md-1"></label>
                            @endif                           
                              <label for="{{ $form->slug }}" class="col-md-2">{{ $form->nama }}</label>
                                <div class="col-md-8">
                                  <div class="input-group ">
                                    <div class="input-group-addon">
                                      <i class="fa fa-upload"></i>
                                    </div>
                                    <input type="file" class="form-control pull-right " id="{{ $form->slug }}" name="{{ $form->slug }}" required autofocus>
                                    <span id="{{ $form->slug }}_download"></span>
                                  </div>
                                    <span class="help-block with-errors"></span>
                                    <span style="font-size: 10; color: red" >*maks 2 MB</span>


                                    <span id="file_{{ $form->slug }}" > 
                                      <a href="#" id="file_download_{{ $form->slug }}" download> 
                                        <i class="fa fa-2x fa-file-o" ></i>
                                          &nbsp; <span id="file_text_{{ $form->slug }}"></span> &nbsp;
                                        <i class="fa fa-download"></i>
                                      </a>
                                    </span>
                                </div>
                            </div> 
                           </span>

                        @elseif($form->tipe =='checkbox')
                         <span id="view_{{ $form->slug }}">
                           <div class="form-group" >
                            @if (substr($form->nama,0,10) != 'keterangan') 
                                <hr>
                              <label class="col-md-1 text-center" id="view_no_{{ $form->slug }}"></label>
                            @else
                              <label class="col-md-1"></label>
                            @endif                           
                              <label for="{{ $form->slug }}" class="col-md-2  ">{{ $form->nama }}</label>
                                <div class="col-md-8 ">
                                 @php
                                    $pilihans = $form->pilihan->all();
                                  @endphp
                                  @foreach ($pilihans as $pilihan)
                                     <label class="form-control"> 
                                        <input type="checkbox" class="flat" name="{{ $form->slug.'[]' }}" autocomplete="off" value="{{$pilihan->slug }}" id="{{ $form->slug.$pilihan->slug }}" autofocus> {{ $pilihan->nama }}
                                      </label>
                                  @endforeach
                                    <span style="font-size: 10; color: red" >*pastikan untuk memilih salah satu</span>
                                </div>
                            </div> 
                           </span>

                        @elseif($form->tipe =='radio')
                         <span id="view_{{ $form->slug }}">
                           <div class="form-group" >
                            @if (substr($form->nama,0,10) != 'keterangan') 
                                <hr>
                              <label class="col-md-1 text-center" id="view_no_{{ $form->slug }}"></label>
                            @else
                              <label class="col-md-1"></label>
                            @endif                           
                              <label for="{{ $form->slug }}" class="col-md-2  ">{{ $form->nama }}</label>
                                <div class="col-md-8 ">
                                 @php
                                    $pilihans = $form->pilihan->all();
                                  @endphp
                                  @foreach ($pilihans as $pilihan)
                                     <label class="form-control"> 
                                        <input type="radio" class="flat" name="{{ $form->slug}}" autocomplete="off" value="{{ $pilihan->slug }}" id="{{ $form->slug.$pilihan->slug }}" required autofocus> {{ $pilihan->nama }}
                                      </label>
                                  @endforeach
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div> 
                         </span>

                         @elseif($form->tipe =='select')
                         <span id="view_{{ $form->slug }}">
                           <div class="form-group" >
                            @if (substr($form->nama,0,10) != 'keterangan') 
                                <hr>
                              <label class="col-md-1 text-center" id="view_no_{{ $form->slug }}"></label>
                            @else
                              <label class="col-md-1"></label>
                            @endif                           
                              <label for="{{ $form->slug }}" class="col-md-2  ">{{ $form->nama }}</label>
                                <div class="col-md-8 ">
                                  <select id="{{ $form->slug }}" name="{{ $form->slug }}" class="form-control"  style="margin: 0px ;" required autofocus>
                                    <option value=""> --pilih-- </option>
                                   @php
                                      $pilihans = $form->pilihan->all();
                                    @endphp
                                    @foreach ($pilihans as $pilihan)
                                       <option value="{{ $pilihan->slug }}">{{ $pilihan->nama }}</option>
                                    @endforeach
                                  </select>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div> 
                        </span>


                       @endif

                     @endforeach 

                    </span>
                  </span>
                    {{-- end input form --}}

                    {{-- show form --}}
                   <span id="form-show">
                      <div align="center" ><span id="form-show-laporan-title" class="text-center" style="font-size: 18pt;font-weight: bold;margin-bottom: 10%"></span>
                      </div>

                       <table class="table  table-responsive" >
                            <tr style="background-color: #C4ECEC" >
                              <td width="30%" align="center">Tanggal Laporan</td>
                              <td width="3%" align="center">:</td>
                              <td id="form-show-tgl" width="67%"></td>
                            </tr>                             
                            <tr style="background-color: #C4ECEC" >
                              <td width="30%" align="center" >Kehadiran</td>
                              <td width="3%" align="center">:</td>
                              <td id="form-show-kehadiran" width="67%"></td>
                            </tr> 
                      </table>
                  
                      <span id="form-show-hadir">
                      <hr>
                      <table id="form-show-table" class="table table-striped table-responsive" style="">
                          @foreach ($form_all as $form)
                            <tr id="form-show-{{ $form->slug }}">
                              <td width="5%" align="center" id="form-show-no-{{ $form->slug }}"></td>
                                @if (substr($form->nama,0,10) != 'keterangan')
                                  <td width="20%" >{{ $form->nama }}</td>
                                @else
                                  <td width="20%" align="center"><i>keterangan:</i></td>
                                @endif
                              <td width="3%" align="center">:</td>
                              <td id="form-show-data-{{ $form->slug }}" width="72%">
                                  @if ($form->tipe == 'file')
                                   <span id="form-show-file-{{ $form->slug }}" > 
                                    <a href="#" id="form-show-file-download-{{ $form->slug }}" download> 
                                      <i class="fa fa-2x fa-file-o" ></i>
                                        &nbsp; <span id="form-show-file-text-{{ $form->slug }}"></span> &nbsp;
                                      <i class="fa fa-download"></i>
                                    </a>
                                  </span>
                                  @endif

                              </td>
                         </tr>
                          @endforeach
                                                         
                      </table>
                    </span>
                  </span>
                   {{-- end show form --}}

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


{{-- form model acc --}}
<div class="modal fade" id="modal-form-acc" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- <form id="form-form" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data"> --}}
                {{-- {{ csrf_field() }} {{ method_field('POST') }} --}}
                <div id="modal-header-acc" class=" modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title text-center" id="modal-form-acc-title" >hhh</h3>
                </div>
                <div class="modal-body">
                      <table class="table table-striped table-responsive" >
                            <tr >
                              <td width="30%" align="center">Staus Laporan</td>
                              <td width="3%" align="center">:</td>
                              <td id="form-acc-show-status" width="67%"></td>
                            </tr>                             
                            <tr >
                              <td width="30%" align="center" >Komentar</td>
                              <td width="3%" align="center">:</td>
                              <td id="form-acc-show-komentar" width="67%"></td>
                            </tr> 
                                                         
                      </table>
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
                </div>

                <div  id="modal-footer-acc" class=" modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                    </button>            
    
                </div>

            {{-- </form> --}}
        </div>
    </div>
</div>