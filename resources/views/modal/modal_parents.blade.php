
<div class="modal fade" id="modal-parent" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-aqua">
                <button type="button" class="close"
                        data-dismiss="modal">
                    &times;
                </button>

                <h4 class="modal-title">
                    <i class="fa fa-users"></i>
                    Aktivasi Akun Orang Tua
                </h4>
            </div>

            <div class="modal-body">

                <input type="hidden" id="parent_student_id">

                <div class="alert alert-info">
                    Password awal akun baru adalah
                    <strong>12345678</strong>.
                    Orang tua wajib mengganti password
                    saat login pertama.
                </div>

                <div class="form-group">
                    <label>Nama Ayah</label>
                    <input type="text"
                           id="father_name"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>Nomor HP Ayah</label>
                    <input type="text"
                           id="father_phone"
                           class="form-control">
                    <small>Contoh: 081234567890</small>
                </div>

                <hr>

                <div class="form-group">
                    <label>Nama Ibu</label>
                    <input type="text"
                           id="mother_name"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>Nomor HP Ibu</label>
                    <input type="text"
                           id="mother_phone"
                           class="form-control">
                </div>

                <hr>

                <div class="form-group">
                    <label>Nama Wali (Opsional)</label>
                    <input type="text"
                           id="guardian_name"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>Nomor HP Wali</label>
                    <input type="text"
                           id="guardian_phone"
                           class="form-control">
                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal">
                    Batal
                </button>

                <button type="button"
                        class="btn btn-success"
                        onclick="simpanAktivasiOrangTua()">
                    <i class="fa fa-check"></i>
                    Aktifkan Akun
                </button>

            </div>

        </div>
    </div>
</div>
