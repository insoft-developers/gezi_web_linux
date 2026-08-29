<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BankSoal;
use App\BankSoalSession;
use App\BankSoalAnswer;
use App\BankSoalDetail;
use App\Exports\BankSoalExamExport;
use App\Kelas;
use App\Location;
use App\School;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class WebBankSessionController extends Controller
{
    public function index()
    {
        if (! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'banksoal-session';
        return view('banksoal.session', compact('view'));
    }

    public function ikutBankSoal($id)
    {
        $view = 'banksoal-exam';
        $banksoal = BankSoal::findorFail($id);
        $sekolah = School::all();
        $siswa = User::all();
        $kelas = Kelas::all();
        $location = Location::all();
        $ids = $id;
        return view('banksoal.exam', compact('view', 'banksoal', 'ids', 'sekolah', 'siswa', 'kelas', 'location'));
    }

    public function bankSoalSessionTable()
    {
        $banksoal = BankSoal::query();
        return DataTables::of($banksoal)


            ->addColumn('id_kelas', function ($banksoal) {
                $kelasString = $banksoal->id_kelas;
                $kelasArray = explode(",", $kelasString);

                $html = "";

                foreach ($kelasArray as $kelasId) {
                    $id = (int) trim($kelasId);

                    $kelas = Kelas::find($id);

                    if ($kelas) {
                        $html .= '<span class="badge badge-primary mr-1 mb-1">'
                            . e($kelas->nama_kelas)
                            . '</span>';
                    }
                }

                return '<div style="width:250px;white-space:normal;">' . $html . '</div>';
            })
            ->addColumn('freq', function ($banksoal) {

                return '<div style="text-align:right;">' . optional($banksoal->session)->count() ?? '0' . '</div>';
            })
            ->addColumn('is_active', function ($banksoal) {
                if ($banksoal->is_active == 1) {
                    return '<center><span class="label label-success">Active</span></center>';
                } else {
                    return '<center><span class="label label-danger">Inactive</span></center>';
                }
            })
            ->addColumn('target_score', function ($banksoal) {
                return '<div style="text-align:right;">' . $banksoal->target_score . '</div>';
            })
            ->addColumn('created_at', function ($banksoal) {
                return '<center>' . date('d-m-Y', strtotime($banksoal->created_at)) . '</center>';
            })
            ->addColumn('action', function ($banksoal) {
                return '<center><a onclick="listData(' . $banksoal->id . ')" style="width:25px;margin-right:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
            })->rawColumns(['created_at', 'target_score', 'freq', 'id_kelas', 'is_active', 'action'])
            ->make(true);
    }


    public function bankSoalExamTable(Request $request, $id)
    {

        // Subquery: total skor per session
        $scoreSub = DB::table('bank_soal_answers')
            ->select(
                'id_session',
                DB::raw('SUM(score) as total_score')
            )
            ->groupBy('id_session');

        // Subquery: durasi per session
        $durationSub = DB::table('bank_soal_answers')
            ->select(
                'id_session',
                DB::raw('MAX(waktu_selesai) as max_duration')
            )
            ->groupBy('id_session');

        // Query utama
        $exam = DB::table('bank_soal_sessions')

            ->leftJoinSub($scoreSub, 'scores', function ($join) {
                $join->on(
                    'bank_soal_sessions.id',
                    '=',
                    'scores.id_session'
                );
            })

            ->leftJoinSub($durationSub, 'durations', function ($join) {
                $join->on(
                    'bank_soal_sessions.id',
                    '=',
                    'durations.id_session'
                );
            })

            ->leftJoin('users', 'users.id', '=', 'bank_soal_sessions.id_user')

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
                $id
            )

            ->select([
                'bank_soal_sessions.*',
                'users.name as user_name',
                'users.nis',
                'locations.name as location_name',
                'users.phone',
                'schools.school_name',
                'kelas.nama_kelas',
                'bank_soals.judul as bank_soal_judul',
                'bank_soals.target_score',
                'scores.total_score',
                'durations.max_duration'
            ]);


        // =====================================================
        // FILTER TANGGAL
        // =====================================================

        if (
            $request->filled('date_start') &&
            $request->filled('date_end')
        ) {
            $exam->whereBetween(
                'bank_soal_sessions.created_at',
                [
                    $request->date_start . ' 00:00:00',
                    $request->date_end . ' 23:59:59'
                ]
            );
        }


        // =====================================================
        // FILTER SISWA
        // =====================================================

        if ($request->filled('siswa_id')) {
            $exam->where(
                'bank_soal_sessions.id_user',
                $request->siswa_id
            );
        }


        // =====================================================
        // FILTER LOKASI
        // =====================================================

        if ($request->filled('location_id')) {
            $exam->where(
                'users.location_id',
                $request->location_id
            );
        }


        // =====================================================
        // FILTER SEKOLAH
        // =====================================================

        if ($request->filled('sekolah_id')) {
            $exam->where(
                'users.school_id',
                $request->sekolah_id
            );
        }


        // =====================================================
        // FILTER KELAS
        // =====================================================

        if ($request->filled('kelas_id')) {
            $exam->where(
                'users.id_kelas',
                $request->kelas_id
            );
        }


        // =====================================================
        // FILTER LULUS / TIDAK LULUS
        // =====================================================

        if ($request->filled('lulus_id')) {

            if ($request->lulus_id == 'lulus') {

                $exam->whereRaw(
                    'COALESCE(scores.total_score, 0) >= bank_soals.target_score'
                );
            } elseif ($request->lulus_id == 'tidak') {

                $exam->whereRaw(
                    'COALESCE(scores.total_score, 0) < bank_soals.target_score'
                );
            }
        }
        return DataTables::of($exam)
            ->addColumn('time', function ($exam) {
                $seconds = (int) ($exam->max_duration ?? 0);
                $menit = floor($seconds / 60);
                $detik = $seconds % 60;

                return '<div>' . sprintf('%02d:%02d', $menit, $detik) . '</div>';
            })
            ->addColumn('location', function ($exam) {
                return '<div>' . ($exam->location_name ?? '-') . '</div>';
            })
            ->addColumn('id_user', function ($exam) {
                return '<div>' . ($exam->user_name ?? '-') . '</div>';
            })
            ->addColumn('nis', function ($exam) {
                return '<div>' . ($exam->nis ?? '-') . '</div>';
            })
            ->addColumn('phone', function ($exam) {
                return '<div>' . ($exam->phone ?? '-') . '</div>';
            })
            ->addColumn('school_id', function ($exam) {
                return '<div>' . ($exam->school_name ?? '-') . '</div>';
            })
            ->addColumn('id_kelas', function ($exam) {
                return '<div>' . ($exam->nama_kelas ?? '-') . '</div>';
            })
            ->addColumn('judul', function ($exam) {
                return '<div>' . ($exam->bank_soal_judul ?? '-') . '</div>';
            })
            ->addColumn('score', function ($exam) {
                return '<div style="text-align:right;">' . number_format($exam->total_score ?? 0, 0, ',', '.') . '</div>';
            })
            ->addColumn('target', function ($exam) {
                return '<div style="text-align:right;">' . number_format($exam->target_score ?? 0, 0, ',', '.') . '</div>';
            })
            ->addColumn('resume', function ($exam) {
                $score = $exam->total_score ?? 0;
                $target = $exam->target_score ?? 0;
                return '<div>' . ($score >= $target ? 'LULUS' : 'TIDAK LULUS') . '</div>';
            })
            ->addColumn('created_at', function ($exam) {
                return '<center>' . date('d-m-Y', strtotime($exam->created_at)) . '</center>';
            })
            ->addColumn('detail', function ($exam) {
                return '<center><a onclick="listData(' . $exam->id . ')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
            })
            ->rawColumns([
                'id_user',
                'nis',
                'phone',
                'school_id',
                'id_kelas',
                'judul',
                'score',
                'target',
                'resume',
                'created_at',
                'detail',
                'location',
                'time'
            ])
            ->make(true);
    }

    public function detailExam($id)
    {
        $answer = BankSoalAnswer::where('id_session', $id)->orderBy('id')->get();
        $ht = '';
        $ht .= '<table class="table table-bordered table-striped">';
        $ht .= '<thead>';
        $ht .= '<tr><th>No Soal</th><th>Jawaban Siswa</th><th>Kunci Jawaban</th><th>Hasil</th><th>Score</th></tr>';
        $ht .= '</thead>';
        foreach ($answer as $index => $key) {

            $detail = \App\BankSoalDetail::findorFail($key->id_soal);

            $ht .= '<tr><td>' . $key->no_soal . '</td><td>' . strtoupper($key->jawaban_user) . '</td><td>' . strtoupper($detail->kunci_jawaban) . '</td><td><center>' . strtoupper($key->hasil_jawaban) . '</center></td><td style="text-align:right;">' . $key->score . '</td></tr>';
        }
        $ht .= '</table>';
        return $ht;
    }


    public function exportExcel(Request $request, $id)
    {
        return Excel::download(
            new BankSoalExamExport($request, $id),
            'laporan-sesi-bank-soal.xlsx'
        );
    }
}
