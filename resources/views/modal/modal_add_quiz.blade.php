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
              <label>No Kuis</label>
              <input maxlength="50" type="text" class="form-control" id="no_kuis" name="no_kuis" required />
          </div>
          <div class="form-group">
              <input type="hidden" id="id_quiz" name="id_quiz" value="{{ $idquiz }}">
          </div>
          <div class="form-group">
              <input type="hidden" id="id_kelas" name="id_kelas" value="1">
          </div>
          <div class="form-group">
              
              <label>Soal Kuis</label>
              <textarea class="form-control" id="soal_kuis" name="soal_kuis" required></textarea>
              <label>Gambar Soal</label>
              <input type="file" class="form-control" id="gambar_soal" name="gambar_soal">
          </div>
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Jawaban A:</label>
                      <input type="text" class="form-control" id="jawaban_a" name="jawaban_a" required>
                      <label>Gambar A</label>
                      <input type="file" class="form-control" id="gambar_a" name="gambar_a">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Jawaban B:</label>
                      <input type="text" class="form-control" id="jawaban_b" name="jawaban_b" required>
                      <label>Gambar B</label>
                      <input type="file" class="form-control" id="gambar_b" name="gambar_b">
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Jawaban C:</label>
                      <input type="text" class="form-control" id="jawaban_c" name="jawaban_c" required>
                      <label>Gambar C</label>
                      <input type="file" class="form-control" id="gambar_c" name="gambar_c">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Jawaban D:</label>
                      <input type="text" class="form-control" id="jawaban_d" name="jawaban_d" required>
                      <label>Gambar D</label>
                      <input type="file" class="form-control" id="gambar_d" name="gambar_d">
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Jawaban E:</label>
                      <input type="text" class="form-control" id="jawaban_e" name="jawaban_e" required>
                      <label>Gambar E</label>
                      <input type="file" class="form-control" id="gambar_e" name="gambar_e">
                  </div>
              </div>
              <div class="col-md-6">
                  
              </div>
          </div>
          <div class="row">
              
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Kunci Jawaban:</label>
                      <select class="form-control" id="kunci_jawaban" name="kunci_jawaban" required>
                          <option value=""> - Pilih - </option>
                          <option value="a">A</option>
                          <option value="b">B</option>
                          <option value="c">C</option>
                          <option value="d">D</option>
                          <option value="e">E</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Score:</label>
                      <input type="number" class="form-control" id="score" name="score" required>
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