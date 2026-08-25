<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Quiz;
use App\Kelas;
use App\QuizHeader;
use Session;

class WebQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'quiz';
        $kelas = Kelas::all();
        $idquiz = $id;
        $header = QuizHeader::findorFail($id);
        return view('quiz.quiz', compact('view','kelas', 'idquiz', 'header'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateNomor(Request $request)
    {
        $input = $request->all();
        $query = Quiz::where('id_quiz', $input['idquiz'])->max('no_kuis');
        return $query + 1;
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
        $input['gambar_soal'] = null;
        $unique = uniqid();
        $nm = 'soal-'.$unique;
        if($request->hasFile('gambar_soal')){
            $input['gambar_soal'] = str_slug($nm, '-').'.'.$request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/quiz'), $input['gambar_soal']);
        }
        
        
        $input['gambar_a'] = null;
        $nma = 'a-'.$unique;
        if($request->hasFile('gambar_a')){
            $input['gambar_a'] = str_slug($nma, '-').'.'.$request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/quiz'), $input['gambar_a']);
        }
        
        $input['gambar_b'] = null;
        $nmb = 'b-'.$unique;
        if($request->hasFile('gambar_b')){
            $input['gambar_b'] = str_slug($nmb, '-').'.'.$request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/quiz'), $input['gambar_b']);
        }
        
        
        $input['gambar_c'] = null;
        $nmc = 'c-'.$unique;
        if($request->hasFile('gambar_c')){
            $input['gambar_c'] = str_slug($nmc, '-').'.'.$request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/quiz'), $input['gambar_c']);
        }
        
        $input['gambar_d'] = null;
        $nmd = 'd-'.$unique;
        if($request->hasFile('gambar_d')){
            $input['gambar_d'] = str_slug($nmd, '-').'.'.$request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/quiz'), $input['gambar_d']);
        }
        
        $input['gambar_e'] = null;
        $nme = 'e-'.$unique;
        if($request->hasFile('gambar_e')){
            $input['gambar_e'] = str_slug($nme, '-').'.'.$request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/quiz'), $input['gambar_e']);
        }
        
        Quiz::create($input);

        return response()->json([
            'success'=>true
        ]);
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
        $quiz = Quiz::findorFail($id);
        return $quiz;
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
        $input = $request->all();
        $kuis = Quiz::findorFail($id);
        
        $unique = uniqid();
        $uni = 'soal-'.$unique;
        $una = 'a-'.$unique;
        $unb = 'b-'.$unique;
        $unc = 'c-'.$unique;
        $und = 'd-'.$unique;
        $une = 'e-'.$unique;
        
        $input['gambar_soal'] = $kuis->gambar_soal;
        if($request->hasFile('gambar_soal')){
            if($kuis->gambar_soal != NULL && file_exists(public_path('/images/quiz/'.$kuis->gambar_soal))){
                unlink(public_path('/images/quiz/'.$kuis->gambar_soal));
            }
            
            $input['gambar_soal'] = str_slug($uni, '-').'.'.$request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/quiz'), $input['gambar_soal']);
        }
        
        $input['gambar_a'] = $kuis->gambar_a;
        if($request->hasFile('gambar_a')){
            if($kuis->gambar_a != NULL && file_exists(public_path('/images/quiz/'.$kuis->gambar_a))){
                unlink(public_path('/images/quiz/'.$kuis->gambar_a));
            }
            
            $input['gambar_a'] = str_slug($una, '-').'.'.$request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/quiz'), $input['gambar_a']);
        }
        
        
        $input['gambar_b'] = $kuis->gambar_b;
        if($request->hasFile('gambar_b')){
            if($kuis->gambar_b != NULL && file_exists(public_path('/images/quiz/'.$kuis->gambar_b))){
                unlink(public_path('/images/quiz/'.$kuis->gambar_b));
            }
            
            $input['gambar_b'] = str_slug($unb, '-').'.'.$request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/quiz'), $input['gambar_b']);
        }
        
        
        $input['gambar_c'] = $kuis->gambar_c;
        if($request->hasFile('gambar_c')){
            if($kuis->gambar_c != NULL && file_exists(public_path('/images/quiz/'.$kuis->gambar_c))){
                unlink(public_path('/images/quiz/'.$kuis->gambar_c));
            }
            
            $input['gambar_c'] = str_slug($unc, '-').'.'.$request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/quiz'), $input['gambar_c']);
        }
        
        
        $input['gambar_d'] = $kuis->gambar_d;
        if($request->hasFile('gambar_d')){
            if($kuis->gambar_d != NULL && file_exists(public_path('/images/quiz/'.$kuis->gambar_d))){
                unlink(public_path('/images/quiz/'.$kuis->gambar_d));
            }
            
            $input['gambar_d'] = str_slug($und, '-').'.'.$request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/quiz'), $input['gambar_d']);
        }
        
        
        $input['gambar_e'] = $kuis->gambar_e;
        if($request->hasFile('gambar_e')){
            if($kuis->gambar_e != NULL && file_exists(public_path('/images/quiz/'.$kuis->gambar_e))){
                unlink(public_path('/images/quiz/'.$kuis->gambar_e));
            }
            
            $input['gambar_e'] = str_slug($une, '-').'.'.$request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/quiz'), $input['gambar_e']);
        }
        
        
        $kuis->update($input);
        
        return response()->json([
            'success'=>true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $detail = Quiz::findorFail($id);
        if($detail->gambar_soal != NULL){
            unlink(public_path('/images/quiz/'.$detail->gambar_soal));
        }
        
        if($detail->gambar_a != NULL){
            unlink(public_path('/images/quiz/'.$detail->gambar_a));
        }
        
        if($detail->gambar_b != NULL){
            unlink(public_path('/images/quiz/'.$detail->gambar_b));
        }
        
        if($detail->gambar_c != NULL){
            unlink(public_path('/images/quiz/'.$detail->gambar_c));
        }
        
        if($detail->gambar_d != NULL){
            unlink(public_path('/images/quiz/'.$detail->gambar_d));
        }
        
        if($detail->gambar_e != NULL){
            unlink(public_path('/images/quiz/'.$detail->gambar_e));
        }

        Quiz::destroy($id);
        
        
        return response()->json([
            'success'=>true

        ]);
        
        
        
       
    }
    
    
    
    public function deleteImage(Request $request) 
    {
        $input = $request->all();
        $detail = Quiz::findorFail($input['id']);
        $type = $input['type'];
        if($type == 0) {
            unlink(public_path('/images/quiz/'.$detail->gambar_soal));
            $detail->update(['gambar_soal'=> NULL]);
        }
        
        
        if($type == 1) {
            unlink(public_path('/images/quiz/'.$detail->gambar_a));
            $detail->update(['gambar_a'=> NULL]);
        }
        
        if($type == 2) {
            unlink(public_path('/images/quiz/'.$detail->gambar_b));
            $detail->update(['gambar_b'=> NULL]);
        }
        
        
        if($type == 3) {
            unlink(public_path('/images/quiz/'.$detail->gambar_c));
            $detail->update(['gambar_c'=> NULL]);
        }
        
        
        if($type == 4) {
            unlink(public_path('/images/quiz/'.$detail->gambar_d));
            $detail->update(['gambar_d'=> NULL]);
        }
        
        if($type == 5) {
            unlink(public_path('/images/quiz/'.$detail->gambar_e));
            $detail->update(['gambar_e'=> NULL]);
        }
        
        return response()->json([
            'success'=>true
        ]);
        
    }
    
    
    public function quizTable($ids)
    {
        $quiz = Quiz::where('id_quiz', $ids)->get();
        return Datatables::of($quiz)
            ->addColumn('soal_kuis', function($quiz){
               if(! empty($quiz->gambar_soal)) {
                   return '<div><a href="'.asset('images/quiz/').'/'.$quiz->gambar_soal.'" target="_blank"><img style="width:90px;" class="img-responsive" src="'.asset('images/quiz/').'/'.$quiz->gambar_soal.'"></a><small onclick="deleteImage('.$quiz->id.', 0)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small><br>'.$quiz->soal_kuis.'</div>';
               } else {
                   return '<div>'.$quiz->soal_kuis.'</div>';
               }
               
           })
           ->addColumn('created_at', function($quiz){
               return '<center>'.date('d-m-Y', strtotime($quiz->created_at)).'</center>';
           })
        
           ->addColumn('jawaban_a', function($quiz){
               $html = '';
               $html = '<div>';
               $html .= '<b>A</b>. '.$quiz->jawaban_a.'';
               if(! empty($quiz->gambar_a)) {
                   $html .= '<a href="'.asset('images/quiz/').'/'.$quiz->gambar_a.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/quiz/').'/'.$quiz->gambar_a.'"></a><small onclick="deleteImage('.$quiz->id.', 1)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>B</b>. '.$quiz->jawaban_b.'';
               if(! empty($quiz->gambar_b)) {
                   $html .= '<a href="'.asset('images/quiz/').'/'.$quiz->gambar_b.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/quiz/').'/'.$quiz->gambar_b.'"></a><small onclick="deleteImage('.$quiz->id.', 2)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>C</b>. '.$quiz->jawaban_c.'';
               if(! empty($quiz->gambar_c)) {
                   $html .= '<a href="'.asset('images/quiz/').'/'.$quiz->gambar_c.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/quiz/').'/'.$quiz->gambar_c.'"></a><small onclick="deleteImage('.$quiz->id.', 3)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>D</b>. '.$quiz->jawaban_d.'';
               if(! empty($quiz->gambar_d)) {
                   $html .= '<a href="'.asset('images/quiz/').'/'.$quiz->gambar_d.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/quiz/').'/'.$quiz->gambar_d.'"></a><small onclick="deleteImage('.$quiz->id.', 4)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>E</b>. '.$quiz->jawaban_e.'';
               if(! empty($quiz->gambar_e)) {
                   $html .= '<a href="'.asset('images/quiz/').'/'.$quiz->gambar_e.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/quiz/').'/'.$quiz->gambar_e.'"></a><small onclick="deleteImage('.$quiz->id.', 5)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '</div>';
               return $html;
           })
           
           ->addColumn('judul', function($quiz){
               $header = QuizHeader::findorFail($quiz->id_quiz);
               return '<div>'.$header->judul.'</div>';
           })
           ->addColumn('kunci_jawaban', function($quiz){
               return '<center>'.strtoupper($quiz->kunci_jawaban).'</center>';
           })
           ->addColumn('score', function($quiz){
               return '<div style="text-align:right;">'.strtoupper($quiz->score).'</div>';
           })
           ->addColumn('action', function($quiz){
                return '<center><a onclick="editData('. $quiz->id.')" style="margin-bottom:6px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<br><a onclick="deleteData('. $quiz->id.')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
        })->rawColumns(['soal_kuis','judul','kunci_jawaban','jawaban_a','created_at','action','score'])
        ->make(true);
    
    }
}
