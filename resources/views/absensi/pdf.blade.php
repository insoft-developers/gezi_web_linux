<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <title>Laporan Absensi</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .filter {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background: #eeeeee;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

    </style>

</head>

<body>

<h2>LAPORAN ABSENSI</h2>

@if($request->tanggal_mulai || $request->tanggal_selesai)

<div class="filter">

    Periode:

    {{ $request->tanggal_mulai ?: '-' }}

    s/d

    {{ $request->tanggal_selesai ?: '-' }}

</div>

@endif


<table>

    <thead>

    <tr>

        <th>No</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Jadwal</th>
        <th>Cabang</th>
        <th>Status</th>
        <th>Tgl Masuk</th>
        <th>Jam Masuk</th>
        <th>Keterangan</th>
        <th>Tgl Pulang</th>
        <th>Jam Pulang</th>
        <th>Keterangan</th>
        <th>Catatan Masuk</th>
        <th>Catatan Pulang</th>
        <th>Host Masuk</th>
        <th>Host Pulang</th>

    </tr>

    </thead>

    <tbody>

    @foreach($data as $key => $absensi)

    <tr>

        <td class="text-center">
            {{ $key + 1 }}
        </td>

        <td>
            {{ optional($absensi->user)->name }}
        </td>

        <td>
            {{ optional(optional($absensi->user)->kelas)->nama_kelas }}
        </td>

        <td>
            {{ optional($absensi->jadwal)->name }}
        </td>

        <td>
            {{ optional($absensi->location)->name }}
        </td>

        <td class="text-center">

            @if($absensi->status == 1)
                Masuk
            @elseif($absensi->status == 2)
                Pulang
            @else
                -
            @endif

        </td>

        <td>
            {{ $absensi->tanggal_masuk
                ? date('d-m-Y', strtotime($absensi->tanggal_masuk))
                : '-' }}
        </td>

        <td>
            {{ $absensi->jam_masuk
                ? date('H:i', strtotime($absensi->jam_masuk))
                : '-' }}
        </td>

        <td>
            {{ $absensi->keterangan_masuk ?: '-' }}
        </td>

        <td>
            {{ $absensi->tanggal_pulang
                ? date('d-m-Y', strtotime($absensi->tanggal_pulang))
                : '-' }}
        </td>

        <td>
            {{ $absensi->jam_pulang
                ? date('H:i', strtotime($absensi->jam_pulang))
                : '-' }}
        </td>

        <td>
            {{ $absensi->keterangan_pulang ?: '-' }}
        </td>
        <td>{{ $absensi->alasan_masuk ?? '' }}</td>
        <td>{{ $absensi->alasan_pulang ?? '' }}</td>
        <td>{{ optional($absensi->hostMasuk)->name ?? '' }}</td>
        <td>{{ optional($absensi->hostPulang)->name ?? '' }}</td>

    </tr>

    @endforeach

    </tbody>

</table>

</body>
</html>