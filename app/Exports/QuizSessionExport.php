<?php

namespace App\Exports;

use App\QuizAnswer;
use App\QuizSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QuizSessionExport implements FromQuery, WithHeadings, WithMapping
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
        $answerSummary = QuizAnswer::select(
            'id_quiz',
            DB::raw('SUM(score) as total_score'),
            DB::raw('SUM(lama_pengerjaan) as total_time')
        )
            ->groupBy('id_quiz');

        $query = QuizSession::with([
            'quiz',
            'user.school',
            'user.kelas',
            'user.location',
        ])
            ->join(
                'quiz_headers',
                'quiz_sessions.id_quiz',
                '=',
                'quiz_headers.id'
            )
            ->leftJoinSub(
                $answerSummary,
                'answer_summary',
                function ($join) {
                    $join->on(
                        'quiz_sessions.id',
                        '=',
                        'answer_summary.id_quiz'
                    );
                }
            )
            ->where(
                'quiz_sessions.id_quiz',
                $this->id
            )
            ->select(
                'quiz_sessions.*',
                'quiz_headers.target_score',
                DB::raw(
                    'COALESCE(answer_summary.total_score, 0) as total_score'
                ),
                DB::raw(
                    'COALESCE(answer_summary.total_time, 0) as total_time'
                )
            );

        // ============================
        // FILTER TANGGAL
        // ============================

        if (
            $this->request->filled('date_start') &&
            $this->request->filled('date_end')
        ) {
            $query->whereBetween(
                'quiz_sessions.created_at',
                [
                    $this->request->date_start . ' 00:00:00',
                    $this->request->date_end . ' 23:59:59',
                ]
            );
        }

        // ============================
        // FILTER SISWA
        // ============================

        if ($this->request->filled('siswa_id')) {
            $query->where(
                'quiz_sessions.user_id',
                $this->request->siswa_id
            );
        }

        // ============================
        // FILTER LOKASI
        // ============================

        if ($this->request->filled('location_id')) {
            $query->whereHas('user', function ($q) {
                $q->where(
                    'location_id',
                    $this->request->location_id
                );
            });
        }

        // ============================
        // FILTER SEKOLAH
        // ============================

        if ($this->request->filled('sekolah_id')) {
            $query->whereHas('user', function ($q) {
                $q->where(
                    'school_id',
                    $this->request->sekolah_id
                );
            });
        }

        // ============================
        // FILTER KELAS
        // ============================

        if ($this->request->filled('kelas_id')) {
            $query->whereHas('user', function ($q) {
                $q->where(
                    'id_kelas',
                    $this->request->kelas_id
                );
            });
        }

        // ============================
        // FILTER LULUS
        // ============================

        if ($this->request->filled('lulus_id')) {

            if ($this->request->lulus_id == 'lulus') {

                $query->whereRaw(
                    'COALESCE(answer_summary.total_score, 0)
                     >= quiz_headers.target_score'
                );

            } elseif ($this->request->lulus_id == 'tidak') {

                $query->whereRaw(
                    'COALESCE(answer_summary.total_score, 0)
                     < quiz_headers.target_score'
                );
            }
        }

        return $query;
    }

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
            'Target',
            'Score',
            'Time',
            'Resume',
        ];
    }

    public function map($quiz): array
    {
        $score = $quiz->total_score ?: 0;
        $target = $quiz->target_score ?: 0;

        return [
            $quiz->id,
            date('d-m-Y', strtotime($quiz->created_at)),
            $quiz->quiz ? $quiz->quiz->judul : '',
            $quiz->user ? $quiz->user->name : '',
            $quiz->user && $quiz->user->location
                ? $quiz->user->location->name
                : '',
            $quiz->user ? $quiz->user->nis : '',
            $quiz->user && $quiz->user->school
                ? $quiz->user->school->school_name
                : '',
            $quiz->user ? $quiz->user->phone : '',
            $quiz->user && $quiz->user->kelas
                ? $quiz->user->kelas->nama_kelas
                : '',
            $target,
            $score,
            $quiz->total_time ?: 0,
            $score >= $target
                ? 'LULUS'
                : 'TIDAK LULUS',
        ];
    }
}