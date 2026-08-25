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
              <label>Category Image</label>
              <input type="file" class="form-control" id="category_image" name="category_image" required>
              <small class="text-mute">Image Size 512 x 512 for the best appearance</small>
          </div>
          
          <div class="form-group">
              <label>Category Name</label>
              <input maxlength="50" type="text" class="form-control" id="category_name" name="category_name" required />
          </div>
          <div class="form-group">
              <label>Mapel</label>
              <select style="width:100%;" id="id_mapel" name="id_mapel" class="form-control" required>
                  <option value=""> - Pilih Mapel - </option>
                  @foreach($mapel as $m)
                  <option value="{{ $m->id }}">{{ $m->mapel_name }}</option>
                  @endforeach
              </select>        
          </div>
          
          <div class="form-group">
              <label>Kelas</label>
              <select style="width:100%;" id="id_kelas" name="id_kelas[]" class="form-control" multiple required>
                 
              </select>        
          </div>
          
          
          
          
          
          <div class="form-group">
              <label>Category Status</label>
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