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
              <label>Subject Name</label>
              <input type="text" class="form-control" id="subject_name" name="subject_name" required />
          </div>
          
          <div class="form-group">
              <label>Image</label>
              <input type="file" class="form-control" id="image" name="image">
              <small class="text-mute">Image Size 600 x 400 for the best appearance</small>
          </div>
          
          <div class="form-group">
              <label>Status</label>
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