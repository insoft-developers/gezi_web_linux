<?php

namespace App\Exports;

use App\Bts;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BtsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $request = $this->request;

        $query = Bts::query()
            ->with([
                'user.location',
                'user.kelas',
                'user.school',
                'hostMasuk',
                'hostPulang',
            ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'waktu_masuk',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate(
                'waktu_masuk',
                '<=',
                $request->tanggal_selesai
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER USER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('user_id')) {
            $query->where('userid', $request->user_id);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER LOCATION
        |--------------------------------------------------------------------------
        */

        if ($request->filled('location_id')) {

            $locationId = $request->location_id;

            $query->whereHas('user.location', function ($q) use ($locationId) {
                $q->where('location_id', $locationId);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER HOST / JADWAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('host_id')) {
            $query->where('host_masuk', $request->host_id);
        }

        return $query->orderByDesc('id');
    }


    public function headings(): array
    {
        return [
            'ID',
            'Nama User',
            'Kelas',
            'Sekolah',
            'Phone',
            'Location',
            'Latitude Masuk',
            'Longitude Masuk',
            'Latitude Pulang',
            'Longitude Pulang',
            'Status',
            'Waktu Masuk',
            'Waktu Pulang',
            'Keterangan Masuk',
            'Keterangan Pulang',
            'Catatan Admin Masuk',
            'Catatan Admin Pulang',
            'Host Masuk',
            'Host Pulang',
        ];
    }


    public function map($data): array
    {
        return [
            $data->id,

            optional($data->user)->name ?? '',

            optional(optional($data->user)->kelas)->nama_kelas ?? '',

            optional(optional($data->user)->school)->school_name ?? '',

            optional($data->user)->phone ?? '',

            optional(optional($data->user)->location)->name ?? '',

            $data->lat_masuk ?? '',

            $data->lng_masuk ?? '',

            $data->lat_pulang ?? '',

            $data->lng_pulang ?? '',

            $this->status($data->status),

            $data->waktu_masuk
                ? date('d-m-Y H:i', strtotime($data->waktu_masuk))
                : '',

            $data->waktu_pulang
                ? date('d-m-Y H:i', strtotime($data->waktu_pulang))
                : '',

            $data->keterangan_masuk ?? '',

            $data->keterangan_pulang ?? '',

            $data->catatan_admin_masuk ?? '',

            $data->catatan_admin_pulang ?? '',

            optional($data->hostMasuk)->name ?? '',

            optional($data->hostPulang)->name ?? '',
        ];
    }


    private function status($status)
    {
        if ($status == 1) {
            return 'Masuk';
        }

        if ($status == 2) {
            return 'Pulang';
        }

        return 'Tidak Diketahui';
    }
}