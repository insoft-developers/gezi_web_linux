<?php

namespace App\Http\Controllers;

use App\Exports\QuizSessionExport;
use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Quiz;
use App\Kelas;
use App\Location;
use App\QuizHeader;
use App\QuizSession;
use App\User;
use App\QuizAnswer;
use App\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ExquizController extends Controller
{

    public function index()
    {
        if (! Session::has('id')) {
            return Redirect(route('login'));
        }

        $view = 'exquiz';
        $ids = '';
        return view('quiz.exquiz', compact('view', 'ids'));
    }


    public function sess_quizes($id, $awal, $akhir)
    {
        $ids = '';
        $view = 'exquiz';

        $sekarang = date('Y-m-d');
        $date = strtotime($sekarang . ' -1 day');
        $tanggal = date('Y-m-d 00:00:01', $date);

        if ($awal == "0" || $akhir == "0") {
            $periode_akhir = date('Y-m-d 23:59:59');
            $periode_awal = $tanggal;
        } else {
            $periode_akhir = $akhir . " 23:59:59";
            $periode_awal = $awal . " 00:00:01";
        }
        $kuis = QuizSession::where('id_quiz', $id)->whereBetween('created_at', [$periode_awal, $periode_akhir])->orderBy('created_at', 'desc')->get();
        return view('quiz.session_fix', compact('view', 'ids', 'kuis'));
    }


    public function store(Request $request)
    {
        $input = $request->all();
        Quiz::create($input);

        return response()->json([
            'success' => true
        ]);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $quiz = Quiz::findorFail($id);
        return $quiz;
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();
        $kuis = Quiz::findorFail($id);
        $kuis->update($input);

        return response()->json([
            'success' => true
        ]);
    }


    public function destroy($id)
    {
        Quiz::destroy($id);

        return response()->json([
            'success' => true

        ]);
    }



    public function exquizTable()
    {
        $quiz = QuizHeader::query();

        return Datatables::of($quiz)
            ->addColumn('created_at', function ($quiz) {
                return '<center>' . date('d-m-Y', strtotime($quiz->created_at)) . '</center>';
            })

            ->addColumn('id_kelas', function ($quiz) {
                $kelasString = $quiz->id_kelas;
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

            ->addColumn('jumlah', function ($quiz) {

                return '<div style="text-align:right;">' . optional($quiz->session)->count() . '</div>';
            })

            ->addColumn('action', function ($quiz) {
                return '<center><a onclick="sessData(' . $quiz->id . ')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
            })->rawColumns(['jumlah', 'id_kelas', 'created_at', 'action'])
            ->make(true);
    }


    public function sess_quiz($id)
    {
        if (! Session::has('id')) {
            return Redirect(route('login'));
        }

        $view = 'exquiz';
        $ids = $id;
        $sekolah = School::all();
        $siswa = User::all();
        $kelas = Kelas::all();
        $location = Location::all();

        return view('quiz.session', compact('view', 'ids', 'sekolah', 'siswa', 'kelas', 'location'));
    }

    public function quiz_result(Request $request)
    {
        $input = $request->all();
        $answer = QuizAnswer::where('id_quiz', $input['id'])->orderBy('id')->get();
        $ht = '';
        $ht .= '<table class="table table-bordered table-striped">';
        $ht .= '<thead>';
        $ht .= '<tr><th>No Soal</th><th>Jawaban Siswa</th><th>Kunci Jawaban</th><th>Waktu</th><th>Hasil</th><th>Score</th></tr>';
        $ht .= '</thead>';
        foreach ($answer as $index => $key) {
            $detail = \App\Quiz::findorFail($key->id_soal);
            $ht .= '<tr><td>' . $key->no_kuis . '</td><td>' . strtoupper($key->jawaban_user) . '</td><td>' . strtoupper($detail->kunci_jawaban) . '</td><td style="text-align:right";>' . $key->lama_pengerjaan . ' detik</td><td><center>' . strtoupper($key->hasil_jawaban) . '</center></td><td style="text-align:right;">' . $key->score . '</td></tr>';
        }
        $ht .= '</table>';
        return $ht;
    }


    public function countRecord(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $awal = $input['awal'];
        $akhir = $input['akhir'];
        // $tanggal_awal = strtotime($awal.' -1 day');
        $periode_awal = $awal . " 00:00:01";
        $periode_akhir = $akhir . " 23:59:59";

        $quiz = QuizSession::where('id_quiz', $id)->whereBetween('created_at', [$periode_awal, $periode_akhir])->orderBy('created_at', 'desc')->count('id');

        return $quiz;
    }

    public function quizSessionTable(Request $request, $id)
    {
        $answerSummary = QuizAnswer::select(
            'id_quiz',
            DB::raw('SUM(score) as total_score'),
            DB::raw('SUM(lama_pengerjaan) as total_time')
        )
            ->groupBy('id_quiz');

        $quiz = QuizSession::with([
            'quiz',
            'user.school',
            'user.kelas',

        ])

            ->join(
                'quiz_headers',
                'quiz_sessions.id_quiz',
                '=',
                'quiz_headers.id'
            )
            ->leftJoinSub($answerSummary, 'answer_summary', function ($join) {
                $join->on('quiz_sessions.id', '=', 'answer_summary.id_quiz');
            })
            ->where('quiz_sessions.id_quiz', $id)
            ->select(
                'quiz_sessions.*',
                DB::raw('COALESCE(answer_summary.total_score, 0) as total_score'),
                DB::raw('COALESCE(answer_summary.total_time, 0) as total_time')
            );

        if ($request->filled('date_start') && $request->filled('date_end')) {
            $quiz->whereBetween('quiz_sessions.created_at', [
                $request->date_start . ' 00:00:00',
                $request->date_end . ' 23:59:59',
            ]);
        }

        if ($request->filled('siswa_id')) {
            $quiz->where('user_id', $request->siswa_id);
        }

        if ($request->filled('location_id')) {
            $location = $request->location_id;
            $quiz->whereHas('user', function ($query) use ($location) {
                $query->where('location_id', $location);
            });
        }

        if ($request->filled('sekolah_id')) {
            $id = $request->sekolah_id;
            $quiz->whereHas('user', function ($query) use ($id) {
                $query->where('school_id', $id);
            });
        }

        if ($request->filled('kelas_id')) {
            $id = $request->kelas_id;
            $quiz->whereHas('user', function ($query) use ($id) {
                $query->where('id_kelas', $id);
            });
        }

        if ($request->filled('lulus_id')) {

            if ($request->lulus_id == 'lulus') {

                $quiz->whereRaw(
                    'COALESCE(answer_summary.total_score, 0) >= quiz_headers.target_score'
                );
            } elseif ($request->lulus_id == 'tidak') {

                $quiz->whereRaw(
                    'COALESCE(answer_summary.total_score, 0) < quiz_headers.target_score'
                );
            }
        }

        return Datatables::of($quiz)

            ->addColumn('created_at', function ($quiz) {
                return '<center>' . date('d-m-Y', strtotime($quiz->created_at)) . '</center>';
            })

            ->addColumn('judul', function ($quiz) {

                return '<div>' . optional($quiz->quiz)->judul ?? '' . '</div>';
            })

            ->addColumn('siswa', function ($quiz) {

                return '<div>' . optional($quiz->user)->name . '</div>';
            })

            ->addColumn('location_id', function ($quiz) {
                return optional(optional($quiz->user)->location)->name ?? '';
            })

            ->addColumn('nis', function ($quiz) {
                return '<div>' . optional($quiz->user)->nis . '</div>';
            })
            ->addColumn('phone', function ($quiz) {
                return '<div>' . optional($quiz->user)->phone . '</div>';
            })
            ->addColumn('school_id', function ($quiz) {


                return '<div>' . optional(optional($quiz->user)->school)->school_name . '</div>';
            })

            ->addColumn('id_kelas', function ($quiz) {

                return '<div>' . optional(optional($quiz->user)->kelas)->nama_kelas . '</div>';
            })

            ->addColumn('target_score', function ($quiz) {

                return '<div style="text-align:right;">' . optional($quiz->quiz)->target_score ?? '' . '</div>';
            })

            ->addColumn('score', function ($quiz) {
                return '<div style="text-align:right;">'
                    . ($quiz->total_score ?? 0)
                    . '</div>';
            })

            ->addColumn('time', function ($quiz) {
                return '<div style="text-align:right;">'
                    . ($quiz->total_time ?? 0)
                    . '</div>';
            })

            ->addColumn('resume', function ($quiz) {

                $score = $quiz->total_score;
                $target = optional($quiz->quiz)->target_score ?: 0;

                if ($score >= $target) {
                    return '<div>LULUS</div>';
                }

                return '<div>TIDAK LULUS</div>';
            })

            ->addColumn('action', function ($quiz) {
                return '<center><a onclick="detailData(' . $quiz->id . ')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
            })->rawColumns(['time', 'id_kelas', 'target_score', 'score', 'resume', 'siswa', 'judul', 'created_at', 'action', 'nis', 'school_id', 'phone'])
            ->make(true);
    }


    public function deleteSession(Request $request)
    {
        $input = $request->all();
        dd($input);
    }

    public function exportExcel(Request $request, $id)
    {
        return Excel::download(
            new QuizSessionExport($request, $id),
            'laporan-sesi-kompetensi-dasar.xlsx'
        );
    }
}
