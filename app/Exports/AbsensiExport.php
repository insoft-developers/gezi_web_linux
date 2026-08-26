<?php

namespace App\Exports;

use App\Absensi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $request = $this->request;

        $query = Absensi::with([
            'user',
            'user.kelas',
            'user.school',
            'location',
            'jadwal',
            'hostMasuk',
            'hostPulang'
        ]);

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'tanggal_masuk',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate(
                'tanggal_masuk',
                '<=',
                $request->tanggal_selesai
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('jadwal_id')) {
            $query->where('jadwal_id', $request->jadwal_id);
        }

        return $query->orderBy('id', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Kelas',
            'Sekolah',
            'Phone',
            'Jadwal',
            'Jam Jadwal Masuk',
            'Jam Jadwal Pulang',
            'Cabang',
            'Status',
            'Tanggal Masuk',
            'Jam Masuk',
            'Keterangan Masuk',
            'Tanggal Pulang',
            'Jam Pulang',
            'Keterangan Pulang',
            'Latitude Masuk',
            'Longitude Masuk',
            'Latitude Pulang',
            'Longitude Pulang',
            'Alasan Masuk',
            'Alasan Pulang',
            'Host Masuk',
            'Host Pulang'
        ];
    }

    public function map($data): array
    {
        return [
            $data->id,

            optional($data->user)->name,

            optional(optional($data->user)->kelas)->nama_kelas,

            optional(optional($data->user)->school)->school_name,

            optional($data->user)->phone,

            optional($data->jadwal)->name,

            optional($data->jadwal)->jam_masuk,

            optional($data->jadwal)->jam_pulang,

            optional($data->location)->name,

            $data->status == 1
                ? 'Masuk'
                : ($data->status == 2 ? 'Pulang' : 'Tidak Diketahui'),

            $data->tanggal_masuk
                ? date('d-m-Y', strtotime($data->tanggal_masuk))
                : '',

            $data->jam_masuk
                ? date('H:i', strtotime($data->jam_masuk))
                : '',

            $data->keterangan_masuk,

            $data->tanggal_pulang
                ? date('d-m-Y', strtotime($data->tanggal_pulang))
                : '',

            $data->jam_pulang
                ? date('H:i', strtotime($data->jam_pulang))
                : '',

            $data->keterangan_pulang,

            $data->latitude_masuk,

            $data->longitude_masuk,

            $data->latitude_pulang,

            $data->longitude_pulang,

            $data->alasan_masuk,

            $data->alasan_pulang,

            optional($data->hostMasuk)->name ?? '',

            optional($data->hostPulang)->name ?? ''
        ];
    }
}