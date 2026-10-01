<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>Data BTS</title>

    <style>

        @page {
            margin: 20px 15px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 9px;
            color: #555;
        }

        .filter {
            margin-bottom: 12px;
            border: 1px solid #ddd;
            padding: 7px;
        }

        .filter table {
            width: 100%;
            border: none;
        }

        .filter td {
            border: none;
            padding: 2px 4px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background: #343a40;
            color: white;
            border: 1px solid #222;
            padding: 5px 3px;
            text-align: center;
            font-size: 8px;
        }

        table.data td {
            border: 1px solid #bbb;
            padding: 4px 3px;
            vertical-align: middle;
            font-size: 8px;
        }

        table.data tr:nth-child(even) {
            background: #f5f5f5;
        }

        .center {
            text-align: center;
        }

        .status-masuk {
            font-weight: bold;
        }

        .status-pulang {
            font-weight: bold;
        }

        .footer {
            margin-top: 10px;
            font-size: 8px;
            color: #666;
        }

    </style>

</head>

<body>

    <div class="header">

        <h2>LAPORAN DATA BTS</h2>

        <p>
            Dicetak pada {{ date('d-m-Y H:i') }}
        </p>

    </div>


    {{-- FILTER YANG DIGUNAKAN --}}

    <div class="filter">

        <table>

            <tr>

                <td width="15%">
                    <strong>Tanggal</strong>
                </td>

                <td width="35%">
                    {{ $request->tanggal_mulai ?: '-' }}
                    s/d
                    {{ $request->tanggal_selesai ?: '-' }}
                </td>

                <td width="15%">
                    <strong>Status</strong>
                </td>

                <td width="35%">

                    @if($request->status == 1)
                        Masuk
                    @elseif($request->status == 2)
                        Pulang
                    @else
                        Semua
                    @endif

                </td>

            </tr>

        </table>

    </div>


    {{-- DATA --}}

    <table class="data">

        <thead>

            <tr>

                <th>No</th>

                <th>Nama</th>

                <th>Kelas</th>

                <th>Sekolah</th>

                <th>Phone</th>

                <th>Location</th>

                <th>Koordinat Masuk</th>

                <th>Koordinat Pulang</th>

                <th>Status</th>

                <th>Waktu Masuk</th>

                <th>Waktu Pulang</th>

                <th>Keterangan Masuk</th>

                <th>Keterangan Pulang</th>

                <th>Catatan Admin Masuk</th>

                <th>Catatan Admin Pulang</th>

                <th>Host Masuk</th>

                <th>Host Pulang</th>

            </tr>

        </thead>


        <tbody>

            @forelse($data as $row)

                <tr>

                    <td class="center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ optional($row->user)->name ?? '-' }}
                    </td>

                    <td>
                        {{ optional(optional($row->user)->kelas)->nama_kelas ?? '-' }}
                    </td>

                    <td>
                        {{ optional(optional($row->user)->school)->school_name ?? '-' }}
                    </td>

                    <td>
                        {{ optional($row->user)->phone ?? '-' }}
                    </td>

                    <td>
                        {{ optional(optional($row->user)->location)->name ?? '-' }}
                    </td>

                    <td class="center">

                        @if($row->lat_masuk && $row->lng_masuk)

                            {{ $row->lat_masuk }},
                            {{ $row->lng_masuk }}

                        @else

                            -

                        @endif

                    </td>

                    <td class="center">

                        @if($row->lat_pulang && $row->lng_pulang)

                            {{ $row->lat_pulang }},
                            {{ $row->lng_pulang }}

                        @else

                            -

                        @endif

                    </td>

                    <td class="center">

                        @if($row->status == 1)

                            Masuk

                        @elseif($row->status == 2)

                            Pulang

                        @else

                            Tidak Diketahui

                        @endif

                    </td>

                    <td class="center">

                        @if($row->waktu_masuk)

                            {{ date('d-m-Y H:i', strtotime($row->waktu_masuk)) }}

                        @else

                            -

                        @endif

                    </td>

                    <td class="center">

                        @if($row->waktu_pulang)

                            {{ date('d-m-Y H:i', strtotime($row->waktu_pulang)) }}

                        @else

                            -

                        @endif

                    </td>

                    <td>
                        {{ $row->keterangan_masuk ?? '-' }}
                    </td>

                    <td>
                        {{ $row->keterangan_pulang ?? '-' }}
                    </td>

                    <td>
                        {{ $row->catatan_admin_masuk ?? '-' }}
                    </td>

                    <td>
                        {{ $row->catatan_admin_pulang ?? '-' }}
                    </td>

                    <td>
                        {{ optional($row->hostMasuk)->name ?? '-' }}
                    </td>

                    <td>
                        {{ optional($row->hostPulang)->name ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="17" class="center">
                        Tidak ada data
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        Total data:
        <strong>{{ $data->count() }}</strong>

    </div>

</body>
</html>