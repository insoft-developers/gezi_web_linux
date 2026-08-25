<div class="modal fade" id="modal-add-jawaban">
  <div class="modal-dialog">
      <form id="form-simpan-jawaban">
              {{ csrf_field() }} {{ method_field('POST') }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
          <input type="hidden" id="id">
          <input type="hidden" id="id_soal" name="id_soal" value="{{ $pertanyaan->id }}">
          <input type="hidden" id="id_guru" name="id_guru" value="{{ Session::get('id') }}">
          <input type="hidden" id="status" name="status" value="1">
          
          <div class="form-group">
              <label>Jawab Pertanyaan: </label>
              <textarea required class="form-control" id="jawaban" name="jawaban" style="height:90px;"></textarea>
          </div>
          <div class="form-group">
              <label>Image</label>
              <input type="file" class="form-control" id="jawaban_gambar" name="jawaban_gambar">
             
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