<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class BankSoalExamExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithTitle
{
    protected $request;
    protected $id;

    public function __construct(Request $request, $id)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function query()
    {
        // ==========================================
        // TOTAL SCORE
        // ==========================================

        $scoreSub = DB::table('bank_soal_answers')
            ->select(
                'id_session',
                DB::raw('SUM(score) as total_score')
            )
            ->groupBy('id_session');


        // ==========================================
        // TOTAL WAKTU
        // ==========================================

        $durationSub = DB::table('bank_soal_answers')
            ->select(
                'id_session',
                DB::raw('MAX(waktu_selesai) as max_duration')
            )
            ->groupBy('id_session');


        // ==========================================
        // QUERY UTAMA
        // ==========================================

        $exam = DB::table('bank_soal_sessions')

            ->leftJoinSub(
                $scoreSub,
                'scores',
                function ($join) {
                    $join->on(
                        'bank_soal_sessions.id',
                        '=',
                        'scores.id_session'
                    );
                }
            )

            ->leftJoinSub(
                $durationSub,
                'durations',
                function ($join) {
                    $join->on(
                        'bank_soal_sessions.id',
                        '=',
                        'durations.id_session'
                    );
                }
            )

            ->leftJoin(
                'users',
                'users.id',
                '=',
                'bank_soal_sessions.id_user'
            )

            ->leftJoin(
                'schools',
                'schools.id',
                '=',
                'users.school_id'
            )

            ->leftJoin(
                'kelas',
                'kelas.id',
                '=',
                'users.id_kelas'
            )

            ->leftJoin(
                'locations',
                'locations.id',
                '=',
                'users.location_id'
            )

            ->leftJoin(
                'bank_soals',
                'bank_soals.id',
                '=',
                'bank_soal_sessions.id_bank_soal'
            )

            ->where(
                'bank_soal_sessions.id_bank_soal',
                $this->id
            )

            ->select([
                'bank_soal_sessions.id',
                'bank_soal_sessions.created_at',

                'bank_soals.judul as bank_soal_judul',
                'users.name as user_name',
                'locations.name as location_name',
                'users.nis',
                'schools.school_name',
                'users.phone',
                'kelas.nama_kelas',

                'bank_soals.target_score',

                DB::raw(
                    'COALESCE(scores.total_score, 0) as total_score'
                ),

                DB::raw(
                    'COALESCE(durations.max_duration, 0) as max_duration'
                ),
            ]);


        // ==========================================
        // FILTER TANGGAL
        // ==========================================

        if (
            $this->request->filled('date_start') &&
            $this->request->filled('date_end')
        ) {

            $exam->whereBetween(
                'bank_soal_sessions.created_at',
                [
                    $this->request->date_start . ' 00:00:00',
                    $this->request->date_end . ' 23:59:59'
                ]
            );
        }


        // ==========================================
        // FILTER SISWA
        // ==========================================

        if ($this->request->filled('siswa_id')) {

            $exam->where(
                'bank_soal_sessions.id_user',
                $this->request->siswa_id
            );
        }


        // ==========================================
        // FILTER LOKASI
        // ==========================================

        if ($this->request->filled('location_id')) {

            $exam->where(
                'users.location_id',
                $this->request->location_id
            );
        }


        // ==========================================
        // FILTER SEKOLAH
        // ==========================================

        if ($this->request->filled('sekolah_id')) {

            $exam->where(
                'users.school_id',
                $this->request->sekolah_id
            );
        }


        // ==========================================
        // FILTER KELAS
        // ==========================================

        if ($this->request->filled('kelas_id')) {

            $exam->where(
                'users.id_kelas',
                $this->request->kelas_id
            );
        }


        // ==========================================
        // FILTER LULUS / TIDAK LULUS
        // ==========================================

        if ($this->request->filled('lulus_id')) {

            if ($this->request->lulus_id == 'lulus') {

                $exam->whereRaw(
                    'COALESCE(scores.total_score, 0)
                    >= bank_soals.target_score'
                );
            } elseif ($this->request->lulus_id == 'tidak') {

                $exam->whereRaw(
                    'COALESCE(scores.total_score, 0)
                    < bank_soals.target_score'
                );
            }
        }
        $exam->orderBy('bank_soal_sessions.id', 'asc');



        return $exam;
    }


    // ==========================================
    // HEADER EXCEL
    // ==========================================

    public function headings(): array
    {
        return [
            'ID',
            'Date',
            'Judul',
            'Siswa',
            'Lokasi',
            'NIS',
            'Sekolah',
            'Telp',
            'Kelas',
            'Score',
            'Target',
            'Waktu',
            'Resume',
        ];
    }


    // ==========================================
    // DATA EXCEL
    // ==========================================

    public function map($exam): array
    {
        $score = $exam->total_score ?: 0;
        $target = $exam->target_score ?: 0;

        $seconds = (int) ($exam->max_duration ?: 0);

        $menit = floor($seconds / 60);
        $detik = $seconds % 60;

        $time = sprintf(
            '%02d:%02d',
            $menit,
            $detik
        );

        return [
            $exam->id,

            date(
                'd-m-Y',
                strtotime($exam->created_at)
            ),

            $exam->bank_soal_judul ?: '-',

            $exam->user_name ?: '-',

            $exam->location_name ?: '-',

            $exam->nis ?: '-',

            $exam->school_name ?: '-',

            $exam->phone ?: '-',

            $exam->nama_kelas ?: '-',

            $score,

            $target,

            $time,

            $score >= $target
                ? 'LULUS'
                : 'TIDAK LULUS',
        ];
    }


    public function title(): string
    {
        return 'Laporan Sesi';
    }
}
