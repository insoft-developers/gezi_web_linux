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
          <input type="hidden" id="from" name="from" value="{{ Session::get('id') }}">
          <input type="hidden" id="destination" name="destination" value="0">
          <input type="hidden" id="page" name="page" value="page">
          <input type="hidden" id="status" name="status" value="0">
          <div class="form-group">
              <label>Title</label>
              <input maxlength="50" type="text" class="form-control" id="title" name="title" required />
          </div>
          <div class="form-group">
              <label>Isi Pengumuman</label>
              <textarea class="form-control" id="content" name="content" style="height:90px;" required></textarea>
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