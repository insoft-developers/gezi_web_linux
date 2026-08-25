<div class="modal fade" id="modal-add">
    <div class="modal-dialog">

        <form id="form-simpan">

            {{ csrf_field() }}
            {{ method_field('POST') }}

            <div class="modal-content">

                <div class="modal-header">

                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                    <h4 class="modal-title"></h4>

                </div>

                <div class="modal-body">

                    <input type="hidden" id="id">

                    {{-- jadwal_id --}}

                    <div class="form-group">
                        <label>Jadwal</label>

                        <select
                            class="form-control"
                            id="jadwal_id"
                            name="jadwal_id"
                            required>

                            <option value="">-- Pilih Jadwal --</option>

                            @foreach($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}">
                                    {{ $jadwal->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    {{-- location_id --}}

                    <div class="form-group">
                        <label>Location</label>

                        <select
                            class="form-control"
                            id="location_id"
                            name="location_id"
                            required>

                            <option value="">-- Pilih Location --</option>

                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">
                                    {{ $location->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    {{-- user_id --}}

                    <div class="form-group">
                        <label>User</label>

                        <select style="width: 100%;" 
                            class="form-control"
                            id="user_id"
                            name="user_id"
                            required>

                            <option value="">-- Pilih Siswa --</option>

                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    {{-- status --}}

                    <div class="form-group">
                        <label>Status</label>

                        <select
                            class="form-control"
                            id="status"
                            name="status"
                            required>

                            <option value="1">Masuk</option>
                            <option value="2">Pulang</option>

                        </select>
                    </div>


                    <div class="row">

                        {{-- tanggal_masuk --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Tanggal Masuk</label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="tanggal_masuk"
                                    name="tanggal_masuk"
                                    required>

                            </div>

                        </div>


                        {{-- tanggal_pulang --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Tanggal Pulang</label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="tanggal_pulang"
                                    name="tanggal_pulang">

                            </div>

                        </div>

                    </div>


                    <div class="row">

                        {{-- jam_masuk --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Jam Masuk</label>

                                <input step="60" 
                                    type="time"
                                    class="form-control"
                                    id="jam_masuk"
                                    name="jam_masuk"
                                    required>

                            </div>

                        </div>


                        {{-- jam_pulang --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Jam Pulang</label>

                                <input
                                    step="60"
                                    type="time"
                                    class="form-control"
                                    id="jam_pulang"
                                    name="jam_pulang">

                            </div>

                        </div>

                    </div>


                    {{-- latitude masuk --}}

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Latitude Masuk</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="latitude_masuk"
                                    name="latitude_masuk">

                            </div>

                        </div>


                        {{-- longitude masuk --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Longitude Masuk</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="longitude_masuk"
                                    name="longitude_masuk">

                            </div>

                        </div>

                    </div>


                    {{-- latitude pulang --}}

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Latitude Pulang</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="latitude_pulang"
                                    name="latitude_pulang">

                            </div>

                        </div>


                        {{-- longitude pulang --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Longitude Pulang</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="longitude_pulang"
                                    name="longitude_pulang">

                            </div>

                        </div>

                    </div>


                    {{-- keterangan masuk --}}

                    <div class="form-group">

                        <label>Keterangan Masuk</label>

                        <select
                            class="form-control"
                            id="keterangan_masuk"
                            name="keterangan_masuk">
                            <option value="">Pilih keterangan masuk</option>
                            <option value="tepat-waktu">Tepat Waktu</option>
                            <option value="terlambat">Terlambat</option>
                        </select>

                    </div>


                    {{-- keterangan pulang --}}

                    <div class="form-group">

                        <label>Keterangan Pulang</label>

                        <select
                            class="form-control"
                            id="keterangan_pulang"
                            name="keterangan_pulang">
                            <option value="">Pilih keterangan pulang</option>
                            <option value="tepat-waktu">Tepat Waktu</option>
                            <option value="pulang-cepat">Pulang Cepat</option>
                        </select>

                    </div>


                    {{-- alasan masuk --}}

                    <div class="form-group">

                        <label>Alasan Masuk Terlambat</label>

                        <textarea
                            class="form-control"
                            id="alasan_masuk"
                            name="alasan_masuk"></textarea>

                    </div>


                    {{-- alasan pulang --}}

                    <div class="form-group">

                        <label>Alasan Pulang Cepat</label>

                        <textarea
                            class="form-control"
                            id="alasan_pulang"
                            name="alasan_pulang"></textarea>

                    </div>


                   

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-default pull-left"
                        data-dismiss="modal">

                        Close

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Save changes

                    </button>

                </div>

            </div>

        </form>

    </div>
</div>