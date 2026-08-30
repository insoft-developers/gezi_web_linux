<?php

namespace App\Exports;

use App\TryoutSession;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TryoutSessionExport implements FromQuery, WithHeadings, WithMapping
{
    protected $id;
    protected $request;

    public function __construct($id, Request $request)
    {
        $this->id = $id;
        $this->request = $request;
    }

    public function query()
    {
        $request = $this->request;

        $exam = TryoutSession::query()
            ->where('id_tryout', $this->id)

            ->with([
                'tryout',
                'users.school',
                'users.kelas',
                'users.location'
            ])

            ->select('tryout_sessions.*')

            // Total score
            ->selectSub(function ($query) {
                $query->from('tryout_answers')
                    ->selectRaw('COALESCE(SUM(score), 0)')
                    ->whereColumn(
                        'tryout_answers.id_session',
                        'tryout_sessions.id'
                    );
            }, 'total_score')

            // Jumlah jawaban
            ->selectSub(function ($query) {
                $query->from('tryout_answers')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn(
                        'tryout_answers.id_session',
                        'tryout_sessions.id'
                    );
            }, 'total_answer');

        // =========================
        // FILTER TANGGAL
        // =========================

        $exam->when($request->date_start, function ($query) use ($request) {
            $query->whereDate(
                'tryout_sessions.created_at',
                '>=',
                $request->date_start
            );
        });

        $exam->when($request->date_end, function ($query) use ($request) {
            $query->whereDate(
                'tryout_sessions.created_at',
                '<=',
                $request->date_end
            );
        });

        // =========================
        // FILTER SISWA
        // =========================

        $exam->when($request->siswa_id, function ($query) use ($request) {
            $query->where(
                'tryout_sessions.id_user',
                $request->siswa_id
            );
        });

        // =========================
        // FILTER SEKOLAH
        // =========================

        $exam->when($request->sekolah_id, function ($query) use ($request) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where(
                    'school_id',
                    $request->sekolah_id
                );
            });
        });

        // =========================
        // FILTER LOKASI
        // =========================

        $exam->when($request->location_id, function ($query) use ($request) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where(
                    'location_id',
                    $request->location_id
                );
            });
        });

        // =========================
        // FILTER KELAS
        // =========================

        $exam->when($request->kelas_id, function ($query) use ($request) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where(
                    'id_kelas',
                    $request->kelas_id
                );
            });
        });

        // =========================
        // FILTER LULUS
        // =========================

        $exam->when(
            $request->lulus_id !== null &&
            $request->lulus_id !== '',
            function ($query) use ($request) {

                if ($request->lulus_id == 1) {

                    // LULUS
                    $query->whereRaw('
                        (
                            SELECT COALESCE(SUM(ta.score), 0)
                            FROM tryout_answers ta
                            WHERE ta.id_session = tryout_sessions.id
                        ) >= (
                            SELECT target_score
                            FROM try_outs
                            WHERE try_outs.id = tryout_sessions.id_tryout
                        )
                    ');

                } elseif ($request->lulus_id == 0) {

                    // TIDAK LULUS
                    $query->whereRaw('
                        (
                            SELECT COALESCE(SUM(ta.score), 0)
                            FROM tryout_answers ta
                            WHERE ta.id_session = tryout_sessions.id
                        ) < (
                            SELECT target_score
                            FROM try_outs
                            WHERE try_outs.id = tryout_sessions.id_tryout
                        )
                    ');
                }
            }
        );

        return $exam;
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
            'Score',
            'Target',
            'Resume',
        ];
    }

    public function map($exam): array
    {
        $score = $exam->total_score ?? 0;
        $target = optional($exam->tryout)->target_score ?? 0;

        $resume = $score >= $target
            ? 'LULUS'
            : 'TIDAK LULUS';

        return [
            $exam->id,

            date(
                'd-m-Y',
                strtotime($exam->created_at)
            ),

            optional($exam->tryout)->judul ?? '',

            optional($exam->users)->name ?? '',

            optional(optional($exam->users)->location)->name ?? '',

            optional($exam->users)->nis ?? '',

            optional(optional($exam->users)->school)->school_name ?? '',

            optional($exam->users)->phone ?? '',

            optional(optional($exam->users)->kelas)->nama_kelas ?? '',

            $exam->total_score ?? 0,

            $target,

            $resume,
        ];
    }
}