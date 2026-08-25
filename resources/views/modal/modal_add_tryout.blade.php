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
              <label>Urutan</label>
              <input type="number" class="form-control" id="urutan" name="urutan" required />
          </div>
          
          <div class="form-group">
              <label>Judul</label>
              <input type="text" class="form-control" id="judul" name="judul" required />
          </div>
          <div class="form-group">
              <label>Subject</label>
              <select class="form-control" id="subject_id" name="subject_id" required />
              <option value="">- Select -</option>
              @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
              @endforeach
              </select>
          </div>
          <div class="form-group">
              <label>Short Name</label>
              <input type="text" class="form-control" id="short_name" name="short_name" required />
          </div>
          
          <div class="form-group">
              <label>Kelas</label>
              <select style="width:100%;" id="id_kelas" name="id_kelas[]" class="form-control" required multiple="multiple">
                  <option value=""> - Pilih Kelas - </option>
                  @foreach($kelas as $kls)
                  <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
                  @endforeach
              </select>        
          </div>
          <div class="form-group">
              <label>Status</label>
              <select id="is_active" name="is_active" class="form-control" required>
                  <option value="">Status</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
              </select>        
          </div>
          
          
          <div class="row">
              <div class="col-md-6">
                   <label>Is Repeated ?</label>
                  <select id="is_repeated" name="is_repeated" class="form-control" required>
                      <option value=""> - Pilih - </option>
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                  </select>
              </div>
              <div class="col-md-6">
                  <label>Is Skipped ?</label>
                  <select id="is_skipped" name="is_skipped" class="form-control" required>
                      <option value=""> - Pilih - </option>
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                  </select>
              </div>
          </div>
          
          <div class="row" style="margin-top:15px;">
              <div class="col-md-6">
                   <label>Time Limit</label>
                   <input type="number" class="form-control" id="time_limit" name="time_limit" required />
              </div>
              <div class="col-md-6">
                  <label>Target Score</label>
                  <input type="number" class="form-control" id="target_score" name="target_score" required />
              </div>
          </div>
          <div class="row"  style="margin-top:15px;">
              <div class="col-md-12">
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
          </div>
          
          
          <div class="row"  style="margin-top:15px;">
              <div class="col-md-12">
                  <div class="form-group">
                    <label>Warna Tulisan Soal:</label>
                      <div class="input-group my-colorpicker2">
                        <input type="text" class="form-control" id="warna_tulisan" name="warna_tulisan" required>
                        <div class="input-group-addon">
                        <i></i>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
          
          
          <div class="row"  style="margin-top:15px;">
              <div class="col-md-12">
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
          </div>
          
          
          <div class="row"  style="margin-top:15px;">
              <div class="col-md-12">
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