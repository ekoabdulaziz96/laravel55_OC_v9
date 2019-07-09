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
                              <input type="text" id="nama" name="nama" class="form-control" autofocus required>
                              <span class="help-block with-errors"></span>
                          </div>
                      </div> 
                       <div class="form-group">
                          <label for="maks_wilayah" class="col-md-2  col-md-offset-1">Maks. Wilayah : </label>
                          <div class="col-md-8">
                               <input type="text" class="form-control bfh-number"  data-min="0" id="maks_wilayah" name="maks_wilayah" autofocus required  >
                              <span class="help-block with-errors"></span>
                          </div>
                        </div> 
           
                    </span>
                    {{-- end input form --}}

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