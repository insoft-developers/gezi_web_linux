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
              <label>NIS</label>
              <input type="text" class="form-control" id="nis" name="nis"/>
          </div>
          <div class="form-group">
              <label>Kelas</label>
              <select class="form-control" id="id_kelas" name="id_kelas" required>
                  <option value=""> - Pilih Kelas - </option>
                  @foreach($kelas as $key)
                  <option value="{{ $key->id }}">{{ $key->nama_kelas }}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group">
              <label>Grup Kelas</label>
              <input required type="text" class="form-control" id="class_group" name="class_group"/>
          </div>
          
          <div class="form-group">
              <label>HP Ayah</label>
              <input type="text" class="form-control" id="fathers_phone" name="fathers_phone"/>
          </div>
          
          <div class="form-group">
              <label>HP Ibu</label>
              <input type="text" class="form-control" id="mothers_phone" name="mothers_phone"/>
          </div>
          
          <div class="form-group">
              <label>Sekolah</label>
              <select class="form-control" id="school_id" name="school_id" required>
                  <option value=""> - Pilih Sekolah - </option>
                  @foreach($sekolah as $key)
                  <option value="{{ $key->id }}">{{ $key->school_name }}</option>
                  @endforeach
              </select>
          </div>
          
          <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" id="email" name="email" required />
          </div>
          <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" id="password" name="password" required />
          </div>
          <div class="form-group">
              <label>Phone Number</label>
              <input type="text" class="form-control" id="phone" name="phone"/>
          </div>
          
          <div class="form-group">
              <label>Lokasi</label>
              <select class="form-control" id="location_id" name="location_id">
                  <option value=""> - Pilih - </option>
                  @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                  @endforeach
              </select>
          </div>
          
          
          <div class="form-group">
              <label>Status</label>
              <select class="form-control" id="is_active" name="is_active" required>
                  <option value=""> - Pilih - </option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
              </select>
          </div>
          
          <div class="form-group">
              <label>Show QRcode ?</label>
              <select class="form-control" id="is_qrcode" name="is_qrcode" required>
                  <option value=""> - Pilih - </option>
                  <option value="1">Ya</option>
                  <option value="0">Tidak</option>
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