<div class="modal fade" id="modal-add">
  <div class="modal-dialog">
      <form id="form-save">
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
              <label>Icon Image</label>
              <input type="file" class="form-control" id="icon_image" name="icon_image" required>
              <small class="text-mute">Image Size 512 x 512 for the best appearance</small>
          </div>
          <div class="form-group">
              <label>Name</label>
              <textarea class="form-control" id="name" name="name" style="height:90px;"></textarea>
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