<div class="modal fade" id="modal-copy">
  <div class="modal-dialog">
      <form id="form-copy">
              {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Copy Data</h4>
      </div>
      <div class="modal-body">
          <input type="hidden" id="dari" name="dari">
          <div class="form-group">
              <label>Copy Data Soal Ke:</label>
              <select id="tujuan" name="tujuan" class="form-control" required>
                  <option value=""> - Pilih - </option>
                  @foreach($head as $h)
                    <option value="{{ $h->id }}">{{ $h->judul }}</option>
                  @endforeach
              </select> 
          </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Execute</button>
      </div>
    </div>
     </form> 
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->