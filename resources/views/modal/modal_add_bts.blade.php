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

                    {{-- user_id --}}

                    <div class="form-group">
                        <label>User</label>

                        <select style="width: 100%;" 
                            class="form-control"
                            id="userid"
                            name="userid"
                            required>

                            <option value="">-- Pilih Siswa --</option>

                            @foreach($users ?? [] as $user)
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

                                <label>Waktu Masuk</label>

                                <input
                                    step="2"
                                    type="datetime-local"
                                    class="form-control"
                                    id="waktu_masuk"
                                    name="waktu_masuk"
                                    required>

                            </div>

                        </div>


                        {{-- tanggal_pulang --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Waktu Pulang</label>

                                <input
                                    step="2"
                                    type="datetime-local"
                                    class="form-control"
                                    id="waktu_pulang"
                                    name="waktu_pulang">

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
                                    id="lat_masuk"
                                    name="lat_masuk">

                            </div>

                        </div>


                        {{-- longitude masuk --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Longitude Masuk</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="lng_masuk"
                                    name="lng_masuk">

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
                                    id="lat_pulang"
                                    name="lat_pulang">

                            </div>

                        </div>


                        {{-- longitude pulang --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Longitude Pulang</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="lng_pulang"
                                    name="lng_pulang">

                            </div>

                        </div>

                    </div>


                    {{-- keterangan masuk --}}

                    <div class="form-group">

                        <label>Keterangan Masuk</label>

                        <textarea
                            class="form-control"
                            id="keterangan_masuk"
                            name="keterangan_masuk">
                          
                        </textarea>

                    </div>


                    {{-- keterangan pulang --}}

                    <div class="form-group">

                        <label>Keterangan Pulang</label>

                        <textarea
                            class="form-control"
                            id="keterangan_pulang"
                            name="keterangan_pulang">
                          
                        </textarea>

                    </div>


                    {{-- alasan masuk --}}

                    <div class="form-group">

                        <label>Catatan Masuk</label>

                        <textarea
                            class="form-control"
                            id="catatan_admin_masuk"
                            name="catatan_admin_masuk"></textarea>

                    </div>


                    {{-- alasan pulang --}}

                    <div class="form-group">

                        <label>Catatan Pulang</label>

                        <textarea
                            class="form-control"
                            id="catatan_admin_pulang"
                            name="catatan_admin_pulang"></textarea>

                    </div>

                     <div class="form-group">
                        <label>Tutor Masuk</label>

                        <select style="width: 100%;" 
                            class="form-control"
                            id="host_masuk"
                            name="host_masuk"
                            required>

                            <option value="">-- Pilih Tutor --</option>

                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                     <div class="form-group">
                        <label>Tutor Pulang</label>

                        <select style="width: 100%;" 
                            class="form-control"
                            id="host_pulang"
                            name="host_pulang"
                            required>

                            <option value="">-- Pilih Tutor --</option>

                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach

                        </select>
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