@extends('master')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>Rekap Nilai Siswa Tahunan</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('default') }}">Dashboard</a></li>
            <li class="active">Rekap Nilai Siswa</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Rekap Nilai Siswa</h3>
            </div>

            <div class="box-body">

                <div class="row" style="margin-bottom:15px">

                    <div class="col-md-2">
                        <label>Tahun</label>
                        <select id="tahun" class="form-control">
                            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Kelas</label>
                        <select id="id_kelas" class="form-control">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}">
                                {{ $k->nama_kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Sekolah</label>
                        <select id="school_id" class="form-control">
                            <option value="">Semua Sekolah</option>
                            @foreach($sekolah as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->school_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Lokasi</label>
                        <select id="location_id" class="form-control">
                            <option value="">Semua Lokasi</option>
                            @foreach($lokasi as $l)
                            <option value="{{ $l->id }}">
                                {{ $l->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="button" id="btnExportExcel"
                            class="btn btn-success form-control">
                            <i class="fa fa-file-excel-o"></i> Export Excel
                        </button>
                    </div>

                </div>

                <div class="table-responsive">
                    <table id="rekap_nilai_table"
                        class="table table-bordered table-striped table-condensed nowrap"
                        style="width:100%">

                        <thead>
                            <tr>
                                <th rowspan="2">No.</th>
                                <th rowspan="2" style="min-width:180px">Nama Siswa</th>
                                <th rowspan="2">Lokasi</th>
                                <th rowspan="2">Kelas</th>
                                <th rowspan="2">Sekolah</th>
                                <th rowspan="2">HP</th>

                                @foreach([
                                'Jan','Feb','Mar','Apr','Mei','Jun',
                                'Jul','Agu','Sep','Okt','Nov','Des'
                                ] as $bulan)
                                <th colspan="3" class="text-center">
                                    {{ $bulan }} {{ $tahun ?? date('Y') }}
                                </th>
                                @endforeach
                            </tr>

                            <tr>
                                @for($i = 1; $i <= 12; $i++)
                                    <th>KD</th>
                                    <th>BS</th>
                                    <th>Qz</th>
                                    @endfor
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection