<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Datatables;

class ReportController extends Controller
{
    public function rekapNilai()
    {
        if (!Session::has('id')) {
            return Redirect(route('login'));
        }

        $view = 'rekap-nilai';
        $tahun = date('Y');

        $kelas = DB::table('kelas')
            ->orderBy('nama_kelas', 'asc')
            ->get();

        return view('siswa.rekap_nilai', compact(
            'view',
            'tahun',
            'kelas'
        ));
    }


    public function tableRekapNilai(Request $request)
    {
        $tahun = (int) $request->input('tahun', date('Y'));

        /*
    |--------------------------------------------------------------------------
    | Fungsi untuk membuat query rekap per kategori
    |--------------------------------------------------------------------------
    */
        $buatRekap = function ($sessionTable, $answerTable, $userColumn, $examColumn, $answerSessionColumn, $prefix) use ($tahun) {

            // Ambil sesi terakhir per siswa, per ujian, per bulan
            $latest = DB::table($sessionTable)
                ->selectRaw("
                {$userColumn} as student_id,
                {$examColumn} as exam_id,
                MONTH(created_at) as bulan,
                MAX(id) as latest_id
            ")
                ->whereYear('created_at', $tahun)
                ->groupBy(
                    $userColumn,
                    $examColumn,
                    DB::raw('MONTH(created_at)')
                );

            // Buat kolom Januari sampai Desember
            $select = ["sessions.student_id"];

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $select[] = DB::raw("
                SUM(
                    CASE
                        WHEN sessions.bulan = {$bulan}
                        THEN answers.score
                        ELSE 0
                    END
                ) as {$prefix}_{$bulan}
            ");
            }

            return DB::table($sessionTable . ' as original')
                ->joinSub($latest, 'sessions', function ($join) {
                    $join->on('original.id', '=', 'sessions.latest_id');
                })
                ->join($answerTable . ' as answers', $answerSessionColumn, '=', 'original.id')
                ->select($select)
                ->groupBy('sessions.student_id');
        };

        /*
    |--------------------------------------------------------------------------
    | Rekap Kompetensi Dasar
    |--------------------------------------------------------------------------
    */
        $kd = $buatRekap(
            'quiz_sessions',
            'quiz_answers',
            'user_id',
            'id_quiz',
            'answers.id_quiz',
            'kd'
        );

        /*
    |--------------------------------------------------------------------------
    | Rekap Bank Soal
    |--------------------------------------------------------------------------
    */
        $bank = $buatRekap(
            'bank_soal_sessions',
            'bank_soal_answers',
            'id_user',
            'id_bank_soal',
            'answers.id_session',
            'bank'
        );

        /*
    |--------------------------------------------------------------------------
    | Rekap Tryout / Quiz
    |--------------------------------------------------------------------------
    */
        $quiz = $buatRekap(
            'tryout_sessions',
            'tryout_answers',
            'id_user',
            'id_tryout',
            'answers.id_session',
            'quiz'
        );

        /*
    |--------------------------------------------------------------------------
    | Query seluruh siswa
    |--------------------------------------------------------------------------
    */
        $data = DB::table('users')
            ->leftJoin('kelas', 'users.id_kelas', '=', 'kelas.id')
            ->select(
                'users.id',
                'users.name as nama_siswa',
                'kelas.nama_kelas as nama_kelas'
            )
            ->leftJoinSub($kd, 'rekap_kd', function ($join) {
                $join->on('users.id', '=', 'rekap_kd.student_id');
            })
            ->leftJoinSub($bank, 'rekap_bank', function ($join) {
                $join->on('users.id', '=', 'rekap_bank.student_id');
            })
            ->leftJoinSub($quiz, 'rekap_quiz', function ($join) {
                $join->on('users.id', '=', 'rekap_quiz.student_id');
            });




        // Tambahkan 36 kolom nilai
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $data->addSelect(
                DB::raw("COALESCE(rekap_kd.kd_{$bulan}, 0) as bulan_{$bulan}_kd"),
                DB::raw("COALESCE(rekap_bank.bank_{$bulan}, 0) as bulan_{$bulan}_bank"),
                DB::raw("COALESCE(rekap_quiz.quiz_{$bulan}, 0) as bulan_{$bulan}_quiz")
            );
        }

        if ($request->filled('id_kelas')) {
            $data->where('users.id_kelas', $request->id_kelas);
        }


        // EXPORT EXCEL (CSV yang bisa dibuka di Microsoft Excel)
        if ($request->get('export') == 1) {

            $rows = $data->get();

            $filename = 'Rekap_Nilai_' . $request->tahun . '.csv';

            return response()->stream(function () use ($rows) {

                $output = fopen('php://output', 'w');

                // BOM agar karakter terbaca dengan benar di Excel
                fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

                $header = array(
                    'No.',
                    'Nama Siswa',
                    'Kelas'
                );

                $namaBulan = array(
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Agu',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                );

                foreach ($namaBulan as $bulan) {
                    $header[] = $bulan . ' KD';
                    $header[] = $bulan . ' BS';
                    $header[] = $bulan . ' Qz';
                }

                fputcsv($output, $header, ';');

                $no = 1;

                foreach ($rows as $row) {

                    $baris = array(
                        $no++,
                        $row->nama_siswa,
                        $row->nama_kelas
                    );

                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                        $kd = 'bulan_' . $bulan . '_kd';
                        $bank = 'bulan_' . $bulan . '_bank';
                        $quiz = 'bulan_' . $bulan . '_quiz';

                        $baris[] = $row->$kd == 0 ? '-' : $row->$kd;
                        $baris[] = $row->$bank == 0 ? '-' : $row->$bank;
                        $baris[] = $row->$quiz == 0 ? '-' : $row->$quiz;
                    }

                    fputcsv($output, $baris, ';');
                }

                fclose($output);
            }, 200, array(
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ));
        }



        return Datatables::of($data)
            ->editColumn('nama_siswa', function ($row) {
                return $row->nama_siswa;
            })
            ->make(true);
    }
}
