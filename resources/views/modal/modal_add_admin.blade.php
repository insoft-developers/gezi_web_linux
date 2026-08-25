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
              <label>Profile Image</label>
              <input type="file" class="form-control" id="profile_image" name="profile_image">
              <small class="text-mute">Image Size 80 x 110 for the best appearance</small>
          </div>
          <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" class="form-control" id="name" name="name" required />
          </div>
          
          <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" id="email" name="email" required />
          </div>
          <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" id="password" name="password" required/>
          </div>
          <div class="form-group">
              <label>Level</label>
              <select id="level" name="level" class="form-control" required>
                  <option value="0"> - Admin - </option>
                  <option value="1"> - Super Admin - </option>
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