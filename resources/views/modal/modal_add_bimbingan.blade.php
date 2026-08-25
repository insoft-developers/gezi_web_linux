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
              <label>Title</label>
              <input maxlength="50" type="text" class="form-control" id="judul" name="judul" required />
          </div>
          <div class="form-group">
              <label>Link Video</label>
              <input type="text" class="form-control" id="link_video" name="link_video" required />
          </div>
          
          <div class="form-group">
              <label>Kategori</label>
              <select style="width:100%;" id="id_kategori" name="id_kategori" class="form-control" required>
                  <option value=""> - Pilih Kategori - </option>
                  @foreach($kategori as $key)
                    <option value="{{ $key->id }}">{{ $key->category_name }} - [ {{ $key->mapel_name }} ]</option>
                  @endforeach
              </select>        
          </div>
          
          <div class="form-group">
              <label>Kelas</label>
              <select style="width:100%;" id="id_kelas" name="id_kelas[]" class="form-control" required multiple>
                  <option value=""> - Pilih Kelas - </option>
                 
              </select>        
          </div>
          
          
          <div class="form-group">
              <label>Mapel</label>
              <select id="id_mapel" name="id_mapel" class="form-control" required readonly>
                  
              </select>        
          </div>
          
          
          
          
          <div class="form-group">
              <label>Bimbingan Status</label>
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