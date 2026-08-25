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
              <label>Mapel Name</label>
              <input type="text" class="form-control" id="mapel_name" name="mapel_name" required />
          </div>
          
          <div class="form-group">
              <label>Mapel Image</label>
              <input type="file" class="form-control" id="mapel_image" name="mapel_image" required>
              <small class="text-mute">Image Size 600 x 400 for the best appearance</small>
          </div>
          <div class="form-group">
              <label>Kelas</label>
              <select style="width:100%;" class="form-control" id="id_kelas" name="id_kelas[]" data-placeholder="Pilih Kelas" multiple="mutiple" required="required">
                @foreach($kelas as $key)
                    <option value="{{ $key->id }}">{{ $key->nama_kelas }}</option>
                @endforeach
              </select>
          </div>
          
          <div class="form-group">
              <label>Mapel Status</label>
              <select id="is_active" name="is_active" class="form-control" required>
                  <option value="">Status</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
              </select>        
          </div>
          <div class="form-group">
              <label>Urutan</label>
              <input type="number" class="form-control" id="urutan" name="urutan" required />
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