<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\TryOut;
use App\Kelas;
use App\TryoutDetail;
use App\TryoutSession;
use App\TryoutAnswer;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TryoutReportExport;
use App\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class WebTryoutController extends Controller
{

    public function index()
    {
        if (! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'tryout';
        $kelas = Kelas::all();
        $subjects = Subject::where('is_active', 1)->get();
        return view('tryout.tryout', compact('view', 'kelas', 'subjects'));
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $id_kelas = implode(",", $input['id_kelas']);


        $input['id_kelas'] = $id_kelas;
        TryOut::create($input);

        return response()->json([
            'success' => true
        ]);
    }


    public function tryoutDetail($id)
    {
        if (! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'detail';
        $ids = $id;
        $tryout = TryOut::findorFail($id);
        return view('tryout.detail', compact('view', 'ids', 'tryout'));
    }


    public function detailAdd(Request $request)
    {
        $input = $request->all();

        $input['gambar_soal'] = null;
        $unique = uniqid();
        $nm = 'soal-' . $unique;
        if ($request->hasFile('gambar_soal')) {
            $input['gambar_soal'] = str_slug($nm, '-') . '.' . $request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/question'), $input['gambar_soal']);
        }


        $input['gambar_a'] = null;
        $nma = 'a-' . $unique;
        if ($request->hasFile('gambar_a')) {
            $input['gambar_a'] = str_slug($nma, '-') . '.' . $request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/question'), $input['gambar_a']);
        }

        $input['gambar_b'] = null;
        $nmb = 'b-' . $unique;
        if ($request->hasFile('gambar_b')) {
            $input['gambar_b'] = str_slug($nmb, '-') . '.' . $request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/question'), $input['gambar_b']);
        }


        $input['gambar_c'] = null;
        $nmc = 'c-' . $unique;
        if ($request->hasFile('gambar_c')) {
            $input['gambar_c'] = str_slug($nmc, '-') . '.' . $request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/question'), $input['gambar_c']);
        }

        $input['gambar_d'] = null;
        $nmd = 'd-' . $unique;
        if ($request->hasFile('gambar_d')) {
            $input['gambar_d'] = str_slug($nmd, '-') . '.' . $request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/question'), $input['gambar_d']);
        }

        $input['gambar_e'] = null;
        $nme = 'e-' . $unique;
        if ($request->hasFile('gambar_e')) {
            $input['gambar_e'] = str_slug($nme, '-') . '.' . $request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/question'), $input['gambar_e']);
        }


        TryoutDetail::create($input);

        return response()->json([
            'success' => true
        ]);
    }


    public function detailEdit($id)
    {
        $detail = TryoutDetail::findorFail($id);
        return $detail;
    }


    public function detailUpdate(Request $request, $id)
    {
        $input = $request->all();
        $detail = TryoutDetail::findorFail($id);

        $unique = uniqid();
        $uni = 'soal-' . $unique;
        $una = 'a-' . $unique;
        $unb = 'b-' . $unique;
        $unc = 'c-' . $unique;
        $und = 'd-' . $unique;
        $une = 'e-' . $unique;

        $input['gambar_soal'] = $detail->gambar_soal;
        if ($request->hasFile('gambar_soal')) {
            if ($detail->gambar_soal != NULL && file_exists(public_path('/images/question/' . $detail->gambar_soal))) {
                unlink(public_path('/images/question/' . $detail->gambar_soal));
            }

            $input['gambar_soal'] = str_slug($uni, '-') . '.' . $request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/question'), $input['gambar_soal']);
        }

        $input['gambar_a'] = $detail->gambar_a;
        if ($request->hasFile('gambar_a')) {
            if ($detail->gambar_a != NULL && file_exists(public_path('/images/question/' . $detail->gambar_a))) {
                unlink(public_path('/images/question/' . $detail->gambar_a));
            }

            $input['gambar_a'] = str_slug($una, '-') . '.' . $request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/question'), $input['gambar_a']);
        }


        $input['gambar_b'] = $detail->gambar_b;
        if ($request->hasFile('gambar_b')) {
            if ($detail->gambar_b != NULL && file_exists(public_path('/images/question/' . $detail->gambar_b))) {
                unlink(public_path('/images/question/' . $detail->gambar_b));
            }

            $input['gambar_b'] = str_slug($unb, '-') . '.' . $request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/question'), $input['gambar_b']);
        }


        $input['gambar_c'] = $detail->gambar_c;
        if ($request->hasFile('gambar_c')) {
            if ($detail->gambar_c != NULL && file_exists(public_path('/images/question/' . $detail->gambar_c))) {
                unlink(public_path('/images/question/' . $detail->gambar_c));
            }

            $input['gambar_c'] = str_slug($unc, '-') . '.' . $request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/question'), $input['gambar_c']);
        }


        $input['gambar_d'] = $detail->gambar_d;
        if ($request->hasFile('gambar_d')) {
            if ($detail->gambar_d != NULL && file_exists(public_path('/images/question/' . $detail->gambar_d))) {
                unlink(public_path('/images/question/' . $detail->gambar_d));
            }

            $input['gambar_d'] = str_slug($und, '-') . '.' . $request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/question'), $input['gambar_d']);
        }


        $input['gambar_e'] = $detail->gambar_e;
        if ($request->hasFile('gambar_e')) {
            if ($detail->gambar_e != NULL && file_exists(public_path('/images/question/' . $detail->gambar_e))) {
                unlink(public_path('/images/question/' . $detail->gambar_e));
            }

            $input['gambar_e'] = str_slug($une, '-') . '.' . $request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/question'), $input['gambar_e']);
        }


        $detail->update($input);

        return response()->json([
            'success' => true
        ]);
    }


    public function deleteImage(Request $request)
    {
        $input = $request->all();
        $detail = TryoutDetail::findorFail($input['id']);
        $type = $input['type'];
        if ($type == 0) {
            unlink(public_path('/images/question/' . $detail->gambar_soal));
            $detail->update(['gambar_soal' => NULL]);
        }


        if ($type == 1) {
            unlink(public_path('/images/question/' . $detail->gambar_a));
            $detail->update(['gambar_a' => NULL]);
        }

        if ($type == 2) {
            unlink(public_path('/images/question/' . $detail->gambar_b));
            $detail->update(['gambar_b' => NULL]);
        }


        if ($type == 3) {
            unlink(public_path('/images/question/' . $detail->gambar_c));
            $detail->update(['gambar_c' => NULL]);
        }


        if ($type == 4) {
            unlink(public_path('/images/question/' . $detail->gambar_d));
            $detail->update(['gambar_d' => NULL]);
        }

        if ($type == 5) {
            unlink(public_path('/images/question/' . $detail->gambar_e));
            $detail->update(['gambar_e' => NULL]);
        }

        return response()->json([
            'success' => true
        ]);
    }


    public function deleteDetail(Request $request)
    {

        $input = $request->all();
        $detail = TryoutDetail::findorFail($input['id']);
        if ($detail->gambar_soal != NULL) {
            unlink(public_path('/images/question/' . $detail->gambar_soal));
        }

        if ($detail->gambar_a != NULL) {
            unlink(public_path('/images/question/' . $detail->gambar_a));
        }

        if ($detail->gambar_b != NULL) {
            unlink(public_path('/images/question/' . $detail->gambar_b));
        }

        if ($detail->gambar_c != NULL) {
            unlink(public_path('/images/question/' . $detail->gambar_c));
        }

        if ($detail->gambar_d != NULL) {
            unlink(public_path('/images/question/' . $detail->gambar_d));
        }

        if ($detail->gambar_e != NULL) {
            unlink(public_path('/images/question/' . $detail->gambar_e));
        }

        TryoutDetail::destroy($input['id']);

        \App\TryoutReport::where('id_soal', $input['id'])->where('kategori', 'tryout')->delete();

        return response()->json([
            'success' => true

        ]);
    }


    public function detailDeleteAll(Request $request)
    {
        $input = $request->all();

        $tryout = TryoutDetail::findorFail($input['id']);
        foreach ($tryout as $key) {
            \App\TryoutReport::where('id_soal', $key->id)->where('kategori', 'tryout')->delete();
        }

        TryoutDetail::where('id_tryout', $input['id'])->delete();

        return response()->json([
            'success' => true

        ]);
    }


    public function edit($id)
    {
        $tryout = TryOut::findorFail($id);

        $id_kelas_array = explode(",", $tryout->id_kelas);

        $data['data'] = $tryout;
        $data['kelas'] = $id_kelas_array;
        return $data;
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();
        $tryout = TryOut::findorFail($id);

        $kelas_array = implode(",", $input['id_kelas']);

        $input['id_kelas'] = $kelas_array;
        $tryout->update($input);

        return response()->json([
            'success' => true
        ]);
    }


    public function destroy($id)
    {
        TryOut::destroy($id);

        return response()->json([
            'success' => true

        ]);
    }



    public function tryoutTable(Request $request)
    {
        $tryout = DB::table('try_outs')
            ->select(
                'try_outs.*',
                'kelas.nama_kelas',
                'subjects.subject_name',
                DB::raw('(
            SELECT COUNT(*)
            FROM tryout_details
            WHERE tryout_details.id_tryout = try_outs.id
        ) as session_count')
            )
            ->join('kelas', 'kelas.id', '=', 'try_outs.id_kelas')
            ->leftJoin('subjects', 'subjects.id', '=', 'try_outs.subject_id')
            ->when($request->kelas_id, function ($query, $kelas_id) {
                $query->whereRaw(
                    'FIND_IN_SET(?, try_outs.id_kelas)',
                    [$kelas_id]
                );
            })
            ->when($request->subject_id, function ($query, $subject_id) {
                $query->where('try_outs.subject_id', $subject_id);
            })
            ->when(
                $request->status_id !== null && $request->status_id !== '',
                function ($query) use ($request) {
                    $query->where(
                        'try_outs.is_active',
                        $request->status_id
                    );
                }
            )
            ->orderBy('try_outs.urutan', 'asc')
            ->orderBy('try_outs.id', 'asc');


        return Datatables::of($tryout)
            ->addColumn('nama_kelas', function ($tryout) {
                $id_kelas_array = explode(",", $tryout->id_kelas);

                $html = '';
                foreach ($id_kelas_array as $key) {
                    $kelas = Kelas::where('id', $key);
                    if ($kelas->count() > 0) {
                        $class = $kelas->first();
                        $html .= $class->nama_kelas . ', ';
                    }
                }

                return '<div style="width:250px;white-space:normal;">' . $html . '</div>';
            })

            ->addColumn('jumlah_soal', function ($tryout) {
                return '<div style="text-align:right;padding:4px;border-radius:3px;background-color:' . $tryout->warna_soal . '"><strong><span style="color:' . $tryout->warna_tulisan . ';">' . $tryout->session_count . '</span></strong></div><br><div style="text-align:right;padding:4px;border-radius:3px;background-color:' . $tryout->warna_jawaban . '"><strong><span style="color:' . $tryout->warna_tulisan_jawaban . ';">jawaban</span></strong></div>';
            })

            ->addColumn('time_limit', function ($tryout) {
                return '<div style="text-align:right;">' . $tryout->time_limit . '</div>';
            })
            ->addColumn('target_score', function ($tryout) {
                return '<div style="text-align:right;">' . $tryout->target_score . '</div>';
            })
            ->addColumn('is_active', function ($tryout) {
                if ($tryout->is_active == 1) {
                    return '<center><span class="label label-success">Active</span></center>';
                } else {
                    return '<center><span class="label label-danger">Inactive</span></center>';
                }
            })
            ->addColumn('is_random_question', function ($tryout) {
                if ($tryout->is_random_question == 1) {
                    return '<center><span class="label label-success">Yes</span></center>';
                } else {
                    return '<center><span class="label label-danger">No</span></center>';
                }
            })

            ->addColumn('is_random_answer', function ($tryout) {
                if ($tryout->is_random_answer == 1) {
                    return '<center><span class="label label-success">Yes</span></center>';
                } else {
                    return '<center><span class="label label-danger">No</span></center>';
                }
            })



            ->addColumn('is_repeated', function ($tryout) {
                if ($tryout->is_repeated == 1) {
                    return '<center><span class="label label-success">Yes</span></center>';
                } else {
                    return '<center><span class="label label-danger">No</span></center>';
                }
            })

            ->addColumn('is_skipped', function ($tryout) {
                if ($tryout->is_skipped == 1) {
                    return '<center><span class="label label-success">Yes</span></center>';
                } else {
                    return '<center><span class="label label-danger">No</span></center>';
                }
            })
            ->editColumn('judul', function ($tryout) {
                return '<div style="text-align:left;white-space:nowrap;"><span class="t-urutan">' . $tryout->urutan . '</span>  <strong>' . $tryout->judul . '</strong><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( ' . $tryout->short_name . ' )</div>';
            })

            ->addColumn('subject_id', function ($tryout) {
                return $tryout->subject_name ?? '';
            })

            ->addColumn('action', function ($tryout) {
                return '<center><a onclick="listData(' . $tryout->id . ')" style="width:25px;margin-bottom:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a>' .
                    '<br><a onclick="copyData(' . $tryout->id . ')" style="margin-bottom:4px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-copy"></i></a>' .
                    '<br><a onclick="editData(' . $tryout->id . ')" style="width:25px;margin-bottom:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>' .
                    '<br><a onclick="deleteData(' . $tryout->id . ')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })->rawColumns(['judul', 'jumlah_soal', 'is_repeated', 'is_skipped', 'time_limit', 'target_score', 'is_active', 'action', 'nama_kelas', 'is_random_question', 'is_random_answer'])
            ->make(true);
    }


    public function detailTable($id)
    {
        $detail = TryoutDetail::where('id_tryout', $id)->get();
        return Datatables::of($detail)


            ->addColumn('is_active', function ($detail) {
                if ($detail->is_active == 1) {
                    return '<center><span class="label label-success">Active</span></center>';
                } else {
                    return '<center><span class="label label-danger">Inactive</span></center>';
                }
            })

            ->addColumn('soal', function ($detail) {
                if (! empty($detail->gambar_soal)) {
                    return '<div><a href="' . asset('images/question/') . '/' . $detail->gambar_soal . '" target="_blank"><img style="width:90px;" class="img-responsive" src="' . asset('images/question/') . '/' . $detail->gambar_soal . '"></a><small onclick="deleteImage(' . $detail->id . ', 0)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small><br>' . $detail->soal . '</div>';
                } else {
                    return '<div>' . $detail->soal . '</div>';
                }
            })

            ->addColumn('jawaban_a', function ($detail) {
                $html = '';
                $html = '<div>';
                $html .= '<b>A</b>. ' . $detail->jawaban_a . '';
                if (! empty($detail->gambar_a)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $detail->gambar_a . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $detail->gambar_a . '"></a><small onclick="deleteImage(' . $detail->id . ', 1)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                $html .= '<br><b>B</b>. ' . $detail->jawaban_b . '';
                if (! empty($detail->gambar_b)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $detail->gambar_b . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $detail->gambar_b . '"></a><small onclick="deleteImage(' . $detail->id . ', 2)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                $html .= '<br><b>C</b>. ' . $detail->jawaban_c . '';
                if (! empty($detail->gambar_c)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $detail->gambar_c . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $detail->gambar_c . '"></a><small onclick="deleteImage(' . $detail->id . ', 3)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                $html .= '<br><b>D</b>. ' . $detail->jawaban_d . '';
                if (! empty($detail->gambar_d)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $detail->gambar_d . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $detail->gambar_d . '"></a><small onclick="deleteImage(' . $detail->id . ', 4)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                $html .= '<br><b>E</b>. ' . $detail->jawaban_e . '';
                if (! empty($detail->gambar_e)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $detail->gambar_e . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $detail->gambar_e . '"></a><small onclick="deleteImage(' . $detail->id . ', 5)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('action', function ($detail) {
                return '<center><a onclick="editData(' . $detail->id . ')" style="width:25px;margin-bottom:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>' .
                    '<br><a onclick="deleteData(' . $detail->id . ')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })->rawColumns(['soal', 'jawaban_a', 'is_active', 'action'])
            ->make(true);
    }


    public function getJenisCopy($jenis)
    {
        if ($jenis == 1) {
            $data = Tryout::all();
        } else if ($jenis == 2) {
            $data = \App\BankSoal::all();
        }

        $html = "";
        foreach ($data as $key) {
            $html .= '<option value="' . $key->id . '">' . $key->judul . '</option>';
        }

        return $html;
    }


    public function copyTryout(Request $request)
    {
        $input = $request->all();
        $soalAsal = TryoutDetail::where('id_tryout', $input['dari'])->get();
        if ($input['jenis'] == 1) {

            $no = TryoutDetail::where('id_tryout', $input['tujuan'])
                ->select('no_soal')
                ->orderBy('id', 'desc');
            $nos = $no->first();

            $noSoal = 1;
            if ($no->count() > 0) {
                $noSoal = $nos->no_soal + 1;
            }

            foreach ($soalAsal as $s) {
                $td = new TryoutDetail;
                $td->id_tryout = $input['tujuan'];
                $td->no_soal = $noSoal;
                $td->soal = $s->soal;
                $td->gambar_soal = $s->gambar_soal;
                $td->jawaban_a = $s->jawaban_a;
                $td->jawaban_b = $s->jawaban_b;
                $td->jawaban_c = $s->jawaban_c;
                $td->jawaban_d = $s->jawaban_d;
                $td->jawaban_e = $s->jawaban_e;
                $td->gambar_a = $s->gambar_a;
                $td->gambar_b = $s->gambar_b;
                $td->gambar_c = $s->gambar_c;
                $td->gambar_d = $s->gambar_d;
                $td->gambar_e = $s->gambar_e;
                $td->kunci_jawaban = $s->kunci_jawaban;
                $td->score = $s->score;
                $td->is_active = $s->is_active;
                $td->created_at = date('Y-m-d h:i:s');
                $td->updated_at = date('Y-m-d h:i:s');
                $td->save();
                $noSoal++;
            }
        } else if ($input['jenis'] == 2) {
            $no = \App\BankSoalDetail::where('id_bank_soal', $input['tujuan'])
                ->select('no_soal')
                ->orderBy('id', 'desc');
            $nos = $no->first();

            $noSoal = 1;
            if ($no->count() > 0) {
                $noSoal = $nos->no_soal + 1;
            }

            // dd($noSoal);
            foreach ($soalAsal as $s) {
                $td = new \App\BankSoalDetail;
                $td->id_bank_soal = $input['tujuan'];
                $td->no_soal = $noSoal;
                $td->soal = $s->soal;
                $td->gambar_soal = $s->gambar_soal;
                $td->jawaban_a = $s->jawaban_a;
                $td->jawaban_b = $s->jawaban_b;
                $td->jawaban_c = $s->jawaban_c;
                $td->jawaban_d = $s->jawaban_d;
                $td->jawaban_e = $s->jawaban_e;
                $td->gambar_a = $s->gambar_a;
                $td->gambar_b = $s->gambar_b;
                $td->gambar_c = $s->gambar_c;
                $td->gambar_d = $s->gambar_d;
                $td->gambar_e = $s->gambar_e;
                $td->kunci_jawaban = $s->kunci_jawaban;
                $td->score = $s->score;
                $td->is_active = $s->is_active;
                $td->created_at = date('Y-m-d h:i:s');
                $td->updated_at = date('Y-m-d h:i:s');


                if (! empty($s->gambar_soal)) {
                    if (! file_exists(public_path('images/banksoal/' . $s->gambar_soal)) && file_exists(public_path('images/question/' . $s->gambar_soal))) {
                        File::copy(public_path('images/question/' . $s->gambar_soal), public_path('images/banksoal/' . $s->gambar_soal));
                    }
                }

                if (! empty($s->gambar_a)) {
                    if (! file_exists(public_path('images/banksoal/' . $s->gambar_a)) && file_exists(public_path('images/question/' . $s->gambar_a))) {
                        File::copy(public_path('images/question/' . $s->gambar_a), public_path('images/banksoal/' . $s->gambar_a));
                    }
                }

                if (! empty($s->gambar_b)) {
                    if (! file_exists(public_path('images/banksoal/' . $s->gambar_b)) && file_exists(public_path('images/question/' . $s->gambar_b))) {
                        File::copy(public_path('images/question/' . $s->gambar_b), public_path('images/banksoal/' . $s->gambar_b));
                    }
                }

                if (! empty($s->gambar_c)) {
                    if (! file_exists(public_path('images/banksoal/' . $s->gambar_c)) && file_exists(public_path('images/question/' . $s->gambar_c))) {
                        File::copy(public_path('images/question/' . $s->gambar_c), public_path('images/banksoal/' . $s->gambar_c));
                    }
                }

                if (! empty($s->gambar_d)) {
                    if (! file_exists(public_path('images/banksoal/' . $s->gambar_d)) && file_exists(public_path('images/question/' . $s->gambar_d))) {
                        File::copy(public_path('images/question/' . $s->gambar_d), public_path('images/banksoal/' . $s->gambar_d));
                    }
                }

                if (! empty($s->gambar_e)) {
                    if (! file_exists(public_path('images/banksoal/' . $s->gambar_e)) && file_exists(public_path('images/question/' . $s->gambar_e))) {
                        File::copy(public_path('images/question/' . $s->gambar_e), public_path('images/banksoal/' . $s->gambar_e));
                    }
                }

                $td->save();

                $noSoal++;
            }
        }

        return response()->json([
            "success" => true
        ]);
    }


    public function laporan()
    {
        if (! Session::has('id')) {
            return Redirect(route('login'));
        }
        $kelas = \App\Kelas::all();
        $view = 'laporan-tryout';
        return view('tryout.laporan', compact('view', 'kelas'));
    }


    public function export()
    {
        $utama = \App\User::all();
        $tryout = TryOut::where('is_active', 1)->get();
        return Excel::download(new TryoutReportExport($utama, $tryout), 'laporan_tryout.xlsx');
    }


    public function displayReport(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        if (! empty($id)) {
            $utama = \App\User::where('id_kelas', $id)->get();
            $tryout = TryOut::where('is_active', 1)->where('id_kelas', $id)->get();
        } else {
            $utama = \App\User::all();
            $tryout = TryOut::where('is_active', 1)->get();
        }




        $html = "";

        $html .= '<table style="font-size:13px;width:400%;" id="tryout_laporan_table" class="table table-bordered table-striped">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th style="vertical-align:middle" rowspan="2" width="5%">ID</th>';
        $html .= '<th style="vertical-align:middle" rowspan="2" width="50">Username</th>';
        $html .= '<th style="vertical-align:middle" rowspan="2"><span style="white-space:nowrap;">Nama_Peserta</span></th>';
        foreach ($tryout as $t) {
            $detail = \App\TryoutDetail::where('id_tryout', $t->id)->get();
            foreach ($detail as $d) {
                $html .= '<th width="1%">' . $d->no_soal . '</th>';
            }
        }

        $html .= '</tr>';
        $html .= '<tr>';

        foreach ($tryout as $t) {

            $detail = \App\TryoutDetail::where('id_tryout', $t->id)->get();
            foreach ($detail as $d) {
                $html .= '<th width="1%">' . $t->short_name . '</th>';
            }
        }
        $html .= '</tr>';

        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($utama as $key) {
            $html .= '<tr>';
            $html .= '<td>' . $key->id . '</td>';
            $html .= '<td>' . $key->email . '</td>';
            $html .= '<td>' . $key->name . '</td>';
            foreach ($tryout as $t) {

                $detail = \App\TryoutDetail::where('id_tryout', $t->id)->get();
                foreach ($detail as $d) {
                    $ans = \App\TryoutAnswer::where('id_soal', $d->id)->where('id_user', $key->id)->get();
                    if ($ans->count() > 0) {
                        if ($ans[0]->hasil_jawaban == 'benar') {
                            $html .= '<td style="background-color:green;color:white;" width="1%"><center>1</center></td>';
                        } else {
                            $html .= '<td width="1%"><center>0</center></td>';
                        }
                    } else {
                        $html .= '<td width="1%"><center>0</center></td>';
                    }
                }
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';

        $html .= '</table>';

        return $html;
    }

    function generateNomorSoal(Request $request)
    {
        $input = $request->all();
        $nomorSoal = (DB::table('tryout_details')
            ->where('id_tryout', $input['id'])
            ->max('no_soal') ?? 0) + 1;

        return $nomorSoal;
    }
}
