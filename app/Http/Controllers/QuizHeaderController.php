<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Quiz;
use App\Kelas;
use App\QuizHeader;

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
        return view('quiz.index', compact('view','kelas','head'));
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
        foreach($quizes as $key) {
            
            
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
          "success"=>true  
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
        $input = $request->all();
        try {
            $query = QuizHeader::create($input);
            $id = $query->id;
            
            
            $kelas = implode(",", $input['id_kelas']);
            $header = QuizHeader::findorFail($id);
            $header->id_kelas = $kelas;
            $header->save();
            
            return response()->json([
                'success'=>true
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
               'success' => $e->getMessage() 
            ]);
            
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
        try {
            $input = $request->all();
            $quiz = QuizHeader::findorFail($id);
            $quiz->update($input);
            
            
            $kuis = QuizHeader::findorFail($id);
            $kuis->id_kelas = implode(",", $input['id_kelas']);
            $kuis->save();
            
            return response()->json([
                'success'=>true
            ]);
        } catch (\Exception $e) {
            return response()->json([
               'success' => $e->getMessage() 
            ]);
            
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
            'success'=>true
        ]);
    }
    
    
    
    public function quizHeaderTable()
    {
        $quiz = QuizHeader::all();
        return Datatables::of($quiz)
          ->addColumn('urutan', function($quiz) {
               return '<center><strong>'.$quiz->urutan.'</strong></center>';
           })
           ->addColumn('created_at', function($quiz){
               return '<center>'.date('d-m-Y', strtotime($quiz->created_at)).'</center>';
           })
           
           
           ->addColumn('jumlah', function($quiz){
               $d = Quiz::where('id_quiz', $quiz->id)->get();
               return '<div style="text-align:right;padding:4px;border-radius:3px;background-color:'.$quiz->warna_soal.'"><strong><span style="color:'.$quiz->warna_tulisan_soal.';">'.$d->count().'</span></strong></div><br><div style="text-align:right;padding:4px;border-radius:3px;background-color:'.$quiz->warna_jawaban.'"><strong><span style="color:'.$quiz->warna_tulisan_jawaban.';">jawaban</span></strong></div>';
           })
           
            ->addColumn('id_kelas', function($quiz){
               $kelasString = $quiz->id_kelas;
               $kelasArray = explode(",", $kelasString);
               
               $html = "";
               $html .= "<ul>";
               for($i=0; $i < count($kelasArray); $i++) 
               {
                   $id = (int)$kelasArray[$i]; 
                   $kelas = Kelas::findorFail($id);
                   $html .= '<li>'.$kelas->nama_kelas.'</li>';
               }
               $html .= "</ul>";
               
               return '<div>'.$html.'</div>';
           })
           ->addColumn('waktu_kuis', function($quiz){
               return '<div style="text-align:right;">'.$quiz->waktu_kuis.'</div>';
           })
            ->addColumn('target_score', function($quiz){
               return '<div style="text-align:right;">'.$quiz->target_score.'</div>';
           })
           ->addColumn('is_active', function($quiz){
               if($quiz->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           
           ->addColumn('action', function($quiz){
                return '<center><a onclick="soalData('. $quiz->id.')" style="margin-bottom:4px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a>'.
                 '<br><a onclick="copyData('. $quiz->id.')" style="margin-bottom:4px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-copy"></i></a>'.
                 '<br><a onclick="editData('. $quiz->id.')" style="margin-bottom:4px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<br><a onclick="deleteData('. $quiz->id.')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
        })->rawColumns(['urutan','is_active','waktu_kuis','target_score','jumlah','id_kelas','created_at','action'])
        ->make(true);
    
    }
}
