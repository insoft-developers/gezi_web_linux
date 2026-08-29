<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Quiz;
use App\Kelas;
use App\QuizHeader;
use Illuminate\Support\Facades\DB;

class QuizHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'quiz-header';
        $kelas = Kelas::all();
        $head = QuizHeader::all();
        return view('quiz.index', compact('view', 'kelas', 'head'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function copyQuiz(Request $request)
    {
        $input = $request->all();
        $kelas_origin = $input['dari'];


        $kelas_dest = $input['tujuan'];

        $nok = Quiz::where('id_quiz', $kelas_dest)->max('no_kuis');
        $nokuis = (int)$nok + 1;


        $quizes = Quiz::where('id_quiz', $kelas_origin)->get();
        foreach ($quizes as $key) {


            $n = new Quiz;
            $n->no_kuis = $nokuis;
            $n->id_quiz = $kelas_dest;
            $n->gambar_soal = $key->gambar_soal;
            $n->soal_kuis = $key->soal_kuis;
            $n->jawaban_a = $key->jawaban_a;
            $n->jawaban_b = $key->jawaban_b;
            $n->jawaban_c = $key->jawaban_c;
            $n->jawaban_d = $key->jawaban_d;
            $n->jawaban_e = $key->jawaban_e;
            $n->gambar_a = $key->gambar_a;
            $n->gambar_b = $key->gambar_b;
            $n->gambar_c = $key->gambar_c;
            $n->gambar_d = $key->gambar_d;
            $n->gambar_e = $key->gambar_e;
            $n->kunci_jawaban = $key->kunci_jawaban;
            $n->id_kelas = $kelas_dest;
            $n->tipe_soal = $key->tipe_soal;
            $n->score = $key->score;
            $n->save();

            $nokuis++;
        }

        return response()->json([
            "success" => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kelas' => ['required', 'array'],
            'id_kelas.*' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            $input = $request->except('id_kelas');

            $input['id_kelas'] = implode(',', $request->id_kelas);

            $quizHeader = QuizHeader::create($input);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Quiz berhasil dibuat',
                'data' => $quizHeader,
            ], 201);
        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat quiz',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = QuizHeader::findorFail($id);
        $data['data'] = $quiz;
        $kelas = explode(",", $quiz->id_kelas);
        $data['kelas'] = $kelas;
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kelas' => ['required', 'array'],
            'id_kelas.*' => ['required'],
        ]);

        try {
            $quiz = QuizHeader::findOrFail($id);

            $input = $request->except('id_kelas');

            $input['id_kelas'] = implode(',', $request->id_kelas);

            $quiz->update($input);

            return response()->json([
                'success' => true,
                'message' => 'Quiz berhasil diperbarui',
                'data' => $quiz->fresh(),
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui quiz',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        QuizHeader::destroy($id);

        return response()->json([
            'success' => true
        ]);
    }



    public function quizHeaderTable(Request $request)
    {
        $quiz = DB::table('quiz_headers')
            ->select('quiz_headers.*', 'kelas.nama_kelas')
            ->join('kelas', 'kelas.id', '=', 'quiz_headers.id_kelas')
            ->when($request->kelas_id, function ($query, $kelas_id) {
                $query->whereRaw('FIND_IN_SET(?, quiz_headers.id_kelas)', [$kelas_id]);
            })
            ->when($request->status_id !== null && $request->status_id !== '', function ($query) use ($request) {
                $query->where(
                    'quiz_headers.is_active',
                    $request->status_id
                );
            })
            ->orderBy('quiz_headers.urutan', 'asc')
            ->orderBy('quiz_headers.id', 'asc');

        return Datatables::of($quiz)
            ->addColumn('urutan', function ($quiz) {
                return '<center><strong>' . $quiz->urutan . '</strong></center>';
            })
            ->addColumn('created_at', function ($quiz) {
                return '<center>' . date('d-m-Y', strtotime($quiz->created_at)) . '</center>';
            })


            ->addColumn('jumlah', function ($quiz) {
                $d = Quiz::where('id_quiz', $quiz->id)->get();
                return '<div style="text-align:right;padding:4px;border-radius:3px;background-color:' . $quiz->warna_soal . '"><strong><span style="color:' . $quiz->warna_tulisan_soal . ';">' . $d->count() . '</span></strong></div><br><div style="text-align:right;padding:4px;border-radius:3px;background-color:' . $quiz->warna_jawaban . '"><strong><span style="color:' . $quiz->warna_tulisan_jawaban . ';">jawaban</span></strong></div>';
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
            ->addColumn('waktu_kuis', function ($quiz) {
                return '<div style="text-align:right;">' . $quiz->waktu_kuis . '</div>';
            })
            ->addColumn('target_score', function ($quiz) {
                return '<div style="text-align:right;">' . $quiz->target_score . '</div>';
            })
            ->addColumn('is_active', function ($quiz) {
                if ($quiz->is_active == 1) {
                    return '<center><span class="label label-success">Active</span></center>';
                } else {
                    return '<center><span class="label label-danger">Inactive</span></center>';
                }
            })

            ->addColumn('is_skipped', function ($quiz) {
                if ($quiz->is_skipped == 1) {
                    return '<center><span class="label label-success">Yes</span></center>';
                } else {
                    return '<center><span class="label label-danger">No</span></center>';
                }
            })

            ->addColumn('action', function ($quiz) {
                return '<center><a onclick="soalData(' . $quiz->id . ')" style="margin-bottom:4px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a>' .
                    '<br><a onclick="copyData(' . $quiz->id . ')" style="margin-bottom:4px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-copy"></i></a>' .
                    '<br><a onclick="editData(' . $quiz->id . ')" style="margin-bottom:4px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>' .
                    '<br><a onclick="deleteData(' . $quiz->id . ')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })->rawColumns(['urutan', 'is_active', 'waktu_kuis', 'target_score', 'jumlah', 'id_kelas', 'created_at', 'action', 'is_skipped'])
            ->make(true);
    }
}
