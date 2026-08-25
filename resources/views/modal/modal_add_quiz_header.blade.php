<div class="modal fade" id="modal-add">
  <div class="modal-dialog">
      <form id="form-simpan">
              {{ csrf_field() }} {{ method_field('POST') }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
          <input type="hidden" id="id">
        
          <div class="form-group">
              <label>Kelas</label>
              <select style="width:100%;" class="form-control" id="id_kelas" name="id_kelas[]" multiple required>
                  
                  @foreach($kelas as $key)
                    <option value="{{ $key->id }}">{{ $key->nama_kelas }}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group">
              <label>Judul</label>
              <input type="text" class="form-control" id="judul" name="judul" required />
          </div>
           <div class="form-group">
              <label>Short Name</label>
              <input type="text" class="form-control" id="short_name" name="short_name" required />
          </div>
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Waktu</label>
                      <input type="number" class="form-control" id="waktu_kuis" name="waktu_kuis" required />
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Target Score</label>
                      <input type="number" class="form-control" id="target_score" name="target_score" required />
                  </div>
              </div>
          </div>
          
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" id="is_active" name="is_active" required>
                          <option value=""> - Pilih - </option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option> 
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Urutan</label>
                      <input type="number" class="form-control" id="urutan" name="urutan" required />
                  </div>
              </div>
             
          </div>
          
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Warna Soal:</label>
                      <div class="input-group my-colorpicker2">
                        <input type="text" class="form-control" id="warna_soal" name="warna_soal" required>
                        <div class="input-group-addon">
                        <i></i>
                      </div>
                    </div>
                  </div>
              </div>
          
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Warna Tulisan Soal:</label>
                      <div class="input-group my-colorpicker2">
                        <input type="text" class="form-control" id="warna_tulisan_soal" name="warna_tulisan_soal" required>
                        <div class="input-group-addon">
                        <i></i>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
          
          
          <div class="row" >
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Warna Jawaban Terpilih:</label>
                      <div class="input-group my-colorpicker2">
                        <input type="text" class="form-control" id="warna_jawaban" name="warna_jawaban" required>
                        <div class="input-group-addon">
                        <i></i>
                      </div>
                    </div>
                  </div>
              </div>
         
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Warna Tulisan Jawaban Terpilih:</label>
                      <div class="input-group my-colorpicker2">
                        <input type="text" class="form-control" id="warna_tulisan_jawaban" name="warna_tulisan_jawaban" required>
                        <div class="input-group-addon">
                        <i></i>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
     </form> 
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->