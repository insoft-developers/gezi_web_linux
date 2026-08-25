<div class="modal modal-danger fade" id="modal-hapus">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-titles">Hapus Data</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_hapus">  
        <p>Anda Yakin Ingin Menghapus Data Ini...?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
        <button onclick="deleteDataConfirm()" type="button" class="btn btn-outline">Yes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>