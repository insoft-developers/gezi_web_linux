@extends('master')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>
            BTS
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="{{ route('default') }}">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>

            <li>
                Absensi
            </li>

            <li class="active">
                BTS
            </li>
        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-header">

                        <h3 class="box-title">
                            Data BTS
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
                                    class="form-control">

                            </div>


                            <div class="col-md-2">

                                <label>Tanggal Selesai</label>

                                <input
                                    type="date"
                                    id="tanggal_selesai"
                                    class="form-control">

                            </div>


                            <div class="col-md-2">

                                <label>Status</label>

                                <select
                                    id="filter_status"
                                    class="form-control">

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
                                    class="form-control input-select2">

                                    <option value="">
                                        Semua Siswa
                                    </option>

                                    @foreach($users??[] as $user)

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
                                    class="form-control">

                                    <option value="">
                                        Semua Location
                                    </option>

                                    @foreach($locations??[] as $location)

                                    <option value="{{ $location->id }}">
                                        {{ $location->name }}
                                    </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-2">

                                <label>Tutor</label>

                                <select
                                    id="filter_host_id"
                                    class="form-control">

                                    <option value="">
                                        Semua Tutor
                                    </option>

                                    @foreach($users ?? [] as $user)

                                    <option value="{{ $user->id }}">
                                        {{ isset($user->name) ? $user->name : $user->id }}
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
                                    class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                    Filter
                                </button>

                                <button
                                    type="button"
                                    id="btn-reset"
                                    class="btn btn-default">
                                    <i class="fa fa-refresh"></i>
                                    Reset
                                </button>

                                <button style="margin-left: 40px;"
                                    type="button"
                                    id="btn-export-excel"
                                    class="btn btn-success">

                                    <i class="fa fa-file-excel-o"></i>
                                    Export Excel
                                </button>

                                <button
                                    type="button"
                                    id="btn-export-pdf"
                                    class="btn btn-danger">

                                    <i class="fa fa-file-pdf-o"></i>
                                    Export PDF
                                </button>

                            </div>

                        </div>


                        <hr>


                        {{-- TABLE --}}

                        <div class="table-responsive">

                            <table
                                id="bts_table"
                                class="table table-bordered table-striped nowrap"
                                width="100%">

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
                                            Kelas
                                        </th>
                                        <th>
                                            Sekolah
                                        </th>
                                        <th>
                                            Telepon
                                        </th>

                                        <th>
                                            Cabang
                                        </th>
                                        <th>
                                            Lokasi Masuk
                                        </th>
                                        <th>
                                            Lokasi Pulang
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Waktu Masuk
                                        </th>

                                        <th>
                                            Waktu Pulang
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
                                        <th>
                                            Host Masuk
                                        </th>
                                        <th>
                                            Host Pulang
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

    @include('modal.modal_add_bts')
    @include('modal.modal_hapus')

</div>

@endsection