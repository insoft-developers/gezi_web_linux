<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldQueue;

class UsersExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    public function query()
    {
        return User::query()->with(['kelas', 'school']);
    }

    public function map($siswa): array
    {
        return [
            $siswa->id,
            $siswa->version,
            $siswa->profile_image ?? '-',
            $siswa->is_active ? 'Active' : 'Inactive',
            $siswa->created_at ? $siswa->created_at->format('d-m-Y H:i') : '-',
            $siswa->name,
            $siswa->quiz_score ?? 0,
            $siswa->bank_score ?? 0,
            $siswa->last_action ?? '-',
            $siswa->location_id ?? '-',
            $siswa->nis ?? '-',
            $siswa->kelas->nama_kelas ?? '-', // relasi ke tabel kelas
            $siswa->school->school_name ?? '-', // relasi ke tabel sekolah
            $siswa->email ?? '-',
            $siswa->phone ?? '-',
        ];
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'Version',
            'Profile Image',
            'Status',
            'Created At',
            'Name',
            'Quiz Score',
            'Bank Score',
            'Last Action',
            'Location ID',
            'NIS',
            'Kelas',
            'Sekolah',
            'Email',
            'Phone',
        ];
    }

}
