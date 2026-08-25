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
              <label>News Title</label>
              <input maxlength="50" type="text" class="form-control" id="news_title" name="news_title" required />
          </div>
          <div class="form-group">
              <label>News Content</label>
              <textarea class="form-control" id="news_content" name="news_content" style="height:90px;"></textarea>
          </div>
          <div class="form-group">
              <label>News Image</label>
              <input type="file" class="form-control" id="news_image" name="news_image" required>
              <small class="text-mute">Image Size 600 x 400 for the best appearance</small>
          </div>
          
          
          <div class="form-group">
              <label>News Status</label>
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