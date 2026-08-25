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
              <label>Nama Kelas</label>
              <input maxlength="50" type="text" class="form-control" id="nama_kelas" name="nama_kelas" required />
          </div>
          <div class="form-group">
              <label>Tingkat</label>
              <select class="form-control" id="tingkat_id" name="tingkat_id" required />
                <option value="">pilih tingkat</option>
                @foreach($tingkats as $tingkat)
                <option value="{{ $tingkat->id }}">{{ $tingkat->name }}</option>
                @endforeach
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