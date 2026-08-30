<?php

namespace App\Http\Controllers;

use App\Exports\TryoutSessionExport;
use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\TryOut;
use App\Kelas;
use App\Location;
use App\School;
use App\TryoutSession;
use App\User;
use App\TryoutAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class WebTryoutSessionController extends Controller
{
    public function index()
    {
        if (! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'tryout-session';
        return view('tryout.session', compact('view'));
    }


    public function sessionDetail($id)
    {
        if (! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'exam';
        $tryout = TryOut::findorFail($id);

        $sekolah = School::all();
        $siswa = User::all();
        $kelas = Kelas::all();
        $location = Location::all();
        $ids = $id;
        return view('tryout.exam', compact('view', 'tryout', 'ids', 'kelas', 'sekolah', 'siswa', 'location'));
    }

    public function detailExam($id)
    {
        $answer = TryoutAnswer::where('id_session', $id)->orderBy('id')->get();
        $ht = '';
        $ht .= '<table class="table table-bordered table-striped">';
        $ht .= '<thead>';
        $ht .= '<tr><th>No Soal</th><th>Jawaban Siswa</th><th>Kunci Jawaban</th><th>Waktu</th><th>Hasil</th><th>Score</th></tr>';
        $ht .= '</thead>';
        foreach ($answer as $index => $key) {

            if ($index == 0) {
                $selisih = $key->init_time - $answer[$index]->waktu_selesai;
            } else {
                $selisih = $answer[$index - 1]->waktu_selesai - $answer[$index]->waktu_selesai;
            }

            $detail = \App\TryoutDetail::findorFail($key->id_soal);


            $ht .= '<tr><td>' . $key->no_soal . '</td><td>' . strtoupper($key->jawaban_user) . '</td><td><center>' . strtoupper($detail->kunci_jawaban) . '</center></td><td style="text-align:right";>' . $selisih . ' detik</td><td><center>' . strtoupper($key->hasil_jawaban) . '</center></td><td style="text-align:right;">' . $key->score . '</td></tr>';
        }
        $ht .= '</table>';
        return $ht;
    }

    public function examTable(Request $request, $id)
    {

        $exam = TryoutSession::query()
            ->where('id_tryout', $id)
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

        // Filter tanggal mulai
        $exam->when($request->date_start, function ($query) use ($request) {
            $query->whereDate(
                'tryout_sessions.created_at',
                '>=',
                $request->date_start
            );
        });

        // Filter tanggal akhir
        $exam->when($request->date_end, function ($query) use ($request) {
            $query->whereDate(
                'tryout_sessions.created_at',
                '<=',
                $request->date_end
            );
        });


        $exam->when($request->siswa_id, function ($query) use ($request) {
            $query->where(
                'tryout_sessions.id_user',
                $request->siswa_id
            );
        });

        $exam->when($request->sekolah_id, function ($query) use ($request) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where('school_id', $request->sekolah_id);
            });
        });

        $exam->when($request->location_id, function ($query) use ($request) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where('location_id', $request->location_id);
            });
        });


        $exam->when($request->kelas_id, function ($query) use ($request) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where('id_kelas', $request->kelas_id);
            });
        });

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




        return Datatables::of($exam)
            ->addColumn('judul', function ($exam) {

                return '<div>' . optional($exam->tryout)->judul ?? '' . '</div>';
            })

            ->addColumn('id_user', function ($exam) {
                return '<div>' . optional($exam->users)->name ?? '' . '</div>';
            })
            ->addColumn('location_id', function ($exam) {
                return '<div>' . optional(optional($exam->users)->location)->name ?? '' . '</div>';
            })
            ->addColumn('nis', function ($exam) {
                return '<div>' . optional($exam->users)->nis ?? '' . '</div>';
            })
            ->addColumn('phone', function ($exam) {
                return '<div>' . optional($exam->users)->phone ?? '' . '</div>';
            })
            ->addColumn('school_id', function ($exam) {

                return '<div>' . optional(optional($exam->users)->school)->school_name ?? '' . '</div>';
            })

            ->addColumn('id_kelas', function ($exam) {
                return '<div>' . optional(optional($exam->users)->kelas)->nama_kelas ?? '' . '</div>';
            })
            ->addColumn('score', function ($exam) {

                return '<div style="text-align:right;">' .$exam->total_score . '</div>';
            })
            ->addColumn('target', function ($exam) {
                return '<div style="text-align:right;">' . optional($exam->tryout)->target_score ?? '' . '</div>';
            })
            ->addColumn('resume', function ($exam) {

                $score  = $exam->total_score;
                $target = $exam->tryout->target_score ?? 0;

                if ($score >= $target) {
                    return '<div class="text-success">
                        <strong>LULUS</strong>
                    </div>';
                }

                return '<div class="text-danger">
                    <strong>TIDAK LULUS</strong>
                </div>';
            })
            ->addColumn('created_at', function ($exam) {
                return '<center>' . date('d-m-Y', strtotime($exam->created_at)) . '</center>';
            })
            ->addColumn('detail', function ($exam) {
                return '<center><a onclick="listData(' . $exam->id . ')" style="width:25px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a><br><a onclick="resetData(' . $exam->id . ')" style="width:25px;margin-top:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })->rawColumns(['created_at', 'target', 'resume', 'score', 'id_kelas', 'id_user', 'judul', 'detail', 'nis', 'school_id', 'phone', 'location_id'])
            ->make(true);
    }


    public function sessionTable()
    {
        $tryout = TryOut::query();
        return Datatables::of($tryout)
            ->addColumn('id_kelas', function ($tryout) {
                $kelasString = $tryout->id_kelas;
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
            ->addColumn('freq', function ($tryout) {

                return '<div style="text-align:right;">' . optional($tryout->session)->count() . '</div>';
            })
            ->addColumn('is_active', function ($tryout) {
                if ($tryout->is_active == 1) {
                    return '<center><span class="label label-success">Active</span></center>';
                } else {
                    return '<center><span class="label label-danger">Inactive</span></center>';
                }
            })
            ->addColumn('target_score', function ($tryout) {
                return '<div style="text-align:right;">' . $tryout->target_score . '</div>';
            })
            ->addColumn('created_at', function ($tryout) {
                return '<center>' . date('d-m-Y', strtotime($tryout->created_at)) . '</center>';
            })
            ->addColumn('action', function ($tryout) {
                return '<center><a onclick="listData(' . $tryout->id . ')" style="width:25px;margin-right:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
            })->rawColumns(['created_at', 'target_score', 'freq', 'id_kelas', 'is_active', 'action'])
            ->make(true);
    }

    public function resetTryout(Request $request)
    {
        $input = $request->all();

        $query = TryoutSession::destroy($input['id']);
        if ($query) {
            TryoutAnswer::where('id_session', $input['id'])->delete();
            return $query;
        }
    }


    public function exportExcel(Request $request, $id)
    {
        return Excel::download(
            new TryoutSessionExport($id, $request),
            'hasil-tryout-' . date('Y-m-d-His') . '.xlsx'
        );
    }
}
