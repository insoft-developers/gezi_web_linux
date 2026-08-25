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
              <label>Menu Name</label>
              <input readonly type="text" class="form-control" id="name" name="name"/>
          </div>
          <div class="form-group">
              <label>Slug</label>
              <input readonly type="text" class="form-control" id="slug" name="slug"/>
          </div>
          <div class="form-group">
              <label>Display Text</label>
              <input type="text" class="form-control" id="display_text" name="display_text" required />
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