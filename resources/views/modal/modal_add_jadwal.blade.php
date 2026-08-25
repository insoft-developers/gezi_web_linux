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
              <label>Nama Jadwal</label>
              <input maxlength="50" type="text" class="form-control" id="name" name="name" required />
          </div>
          <div class="form-group">
              <label>Jam Masuk</label>
              <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" required />
          </div>
           <div class="form-group">
              <label>Jam Pulang</label>
              <input type="time" class="form-control" id="jam_pulang" name="jam_pulang" required />
          </div>
           <div class="form-group">
              <label>Status</label>
              <select class="form-control" id="is_active" name="is_active" required />
                <option value="">Plih</option>
                <option value="1">Aktif</option>
                <option value="0">Tdk Aktif</option>
              </select>
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