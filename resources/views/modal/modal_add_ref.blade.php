<div class="modal fade" id="modal-add">
  <div class="modal-dialog">
      <form id="form-add">
              {{ csrf_field() }} {{ method_field('POST') }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Default Modal</h4>
      </div>
      <div class="modal-body">
          <input type="hidden" id="id">
          <div class="form-group">
              <label>Reference Image</label>
              <input type="file" class="form-control" id="ref_image" name="ref_image" required>
              <small class="text-mute">Image Size 600 x 400 for the best appearance</small>
          </div>
          <div class="form-group">
              <label>Title</label>
              <textarea class="form-control" id="ref_title" name="ref_title" style="height:90px;" required></textarea>
          </div>
          <div class="form-group">
              <label>Reference URL</label>
              <textarea class="form-control" id="ref_url" name="ref_url" style="height:90px;" required></textarea>
          </div>
          <div class="form-group">
              <label>Kelas</label>
              <select style="width:100%;" class="form-control" id="id_kelas" name="id_kelas[]" multiple="multiple" required>
                 @foreach($kelas as $key)
                    <option value="{{ $key->id }}">{{ $key->nama_kelas }}</option>
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