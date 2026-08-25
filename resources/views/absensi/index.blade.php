@extends('master')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>
            Absensi
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="{{ route('default') }}">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>

            <li>
                Settings
            </li>

            <li class="active">
                Absensi
            </li>
        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-header">

                        <h3 class="box-title">
                            Data Absensi
                        </h3>

                    </div>


                    <div class="box-body">

                        {{-- FILTER --}}

                        <div class="row">

                            <div class="col-md-2">

                                <label>Tanggal Mulai</label>

                                <input
                                    type="date"
                                    id="tanggal_mulai"
                                    class="form-control"
                                >

                            </div>


                            <div class="col-md-2">

                                <label>Tanggal Selesai</label>

                                <input
                                    type="date"
                                    id="tanggal_selesai"
                                    class="form-control"
                                >

                            </div>


                            <div class="col-md-2">

                                <label>Status</label>

                                <select
                                    id="filter_status"
                                    class="form-control"
                                >

                                    <option value="">
                                        Semua
                                    </option>

                                    <option value="1">
                                        Masuk
                                    </option>

                                    <option value="2">
                                        Pulang
                                    </option>

                                </select>

                            </div>


                            <div class="col-md-2">

                                <label>User</label>

                                <select
                                    id="filter_user_id"
                                    class="form-control input-select2"
                                >

                                    <option value="">
                                        Semua Siswa
                                    </option>

                                    @foreach($users as $user)

                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-2">

                                <label>Location</label>

                                <select
                                    id="filter_location_id"
                                    class="form-control"
                                >

                                    <option value="">
                                        Semua Location
                                    </option>

                                    @foreach($locations as $location)

                                        <option value="{{ $location->id }}">
                                            {{ $location->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-2">

                                <label>Jadwal</label>

                                <select
                                    id="filter_jadwal_id"
                                    class="form-control"
                                >

                                    <option value="">
                                        Semua Jadwal
                                    </option>

                                    @foreach($jadwals as $jadwal)

                                        <option value="{{ $jadwal->id }}">
                                            {{ isset($jadwal->name) ? $jadwal->name : $jadwal->id }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>


                        <br>


                        <div class="row">

                            <div class="col-md-12">

                                <button
                                    type="button"
                                    id="btn-filter"
                                    class="btn btn-primary"
                                >
                                    <i class="fa fa-search"></i>
                                    Filter
                                </button>

                                <button
                                    type="button"
                                    id="btn-reset"
                                    class="btn btn-default"
                                >
                                    <i class="fa fa-refresh"></i>
                                    Reset
                                </button>

                            </div>

                        </div>


                        <hr>


                        {{-- TABLE --}}

                        <div class="table-responsive">

                            <table
                                id="absensi_table"
                                class="table table-bordered table-striped nowrap"
                                width="100%"
                            >

                                <thead>

                                <tr>

                                    <th width="5%">
                                        ID
                                    </th>
                                    <th>Action</th>


                                    <th>
                                        Siswa
                                    </th>

                                    <th>
                                        Jadwal
                                    </th>

                                    <th>
                                        Location
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Tgl Masuk
                                    </th>

                                    <th>
                                        Jadwal Waktu Masuk
                                    </th>
                                    <th>
                                        Jam Masuk
                                    </th>

                                    <th>
                                        Tgl Pulang
                                    </th>
                                    <th>
                                        Jadwal Waktu Pulang
                                    </th>

                                    <th>
                                        Jam Pulang
                                    </th>

                                    <th>
                                        Keterangan Masuk
                                    </th>
                                    <th>
                                        Keterangan Pulang
                                    </th>
                                     <th>
                                        Catatan Masuk
                                    </th>
                                    <th>
                                        Catatan Pulang
                                    </th>

                                </tr>

                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
     @include('modal.modal_add_absensi')
    @include('modal.modal_hapus')

</div>

@endsection