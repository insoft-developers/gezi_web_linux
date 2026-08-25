<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Question;
use App\Qanswer;
use App\Kelas;
use App\User;
use Session;
class WebQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'question';
        $ids = '';
        return view('question.index', compact('view', 'ids'));
    }
    
    
    public function editStatusQuestion($id)
    {
        $question = Question::findorFail($id);
        return $question;
    }
    
    
    public function updateQuestionStatus(Request $request , $id)
    {
        $input = $request->all();
        
        $question = Question::findorFail($id);
        $question->status = $input['status'];
        $question->save();
        return response()->json([
            "success" => true,
            ]);
    }
    
    
    public function questionTable()
    {
        $question = Question::all();
                    
        return Datatables::of($question)
           ->addColumn('soal', function($question){
               $html = "";
               if(! empty($question->gambar_soal)) {
                    $html .= '<img style="border-radius:10px; width:150px;" class="img-responsive" src="'.asset('storage/images/question').'/'.$question->gambar_soal.'">';    
               }
               
               $html .= '<div>'.$question->soal.'</div>';
               
               return '<div>'.$html.'</div>';
           })
           
           ->addColumn('id_user', function($question){
               $user = User::findorFail($question->id_user);
               return '<div>'.$user->name.'</div>';
           })
           
           ->addColumn('id_kelas', function($question){
               $kelas = Kelas::findorFail($question->id_kelas);
               return '<div>'.$kelas->nama_kelas.'</div>';
           })
           
           ->addColumn('is_active', function($question){
               if($question->status == 1) {
                   return '<center><span class="label label-success">Published</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Holded</span></center>';
               }
           })
           
           ->addColumn('jawaban', function($question){
               $jumlah = Qanswer::where('id_soal', $question->id)->get();
               return '<div style="text-align:right;">'.$jumlah->count().'</div>';
           })
           
           ->addColumn('created_at', function($question){
               return '<div>'.date('d-m-Y', strtotime($question->created_at)).'</div>';
           })
           
           ->addColumn('action', function($question){
                return '<center><a onclick="editData('. $question->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="jawabData('. $question->id.')" style="width:80px;" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-check"></i> Jawab</a></center>';
        })->rawColumns(['soal','id_user', 'id_kelas', 'jawaban','is_active','action','created_at'])
        ->make(true);
    
    }
    
    
    public function answerQuestion($id) 
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = "question";
        $ids = $id;
        $pertanyaan = Question::findorFail($id);
        return view('question.answer', compact('view','ids','pertanyaan'));
        
    }
    
    
    public function questionAnswerTable($id)
    {
        $question = Qanswer::where('id_soal', $id)->get();
                    
        return Datatables::of($question)
           ->addColumn('jawaban', function($question){
               $admin = \App\Admin::findorfail($question->id_guru);
               
               $html = "";
               $html .= '<div style="display:inline-block !important; margin-bottom:20px;"><img style="width:50px;height:50px;border-radius:25px;margin-right:10px;" src="'.asset('storage/images/profil').'/'.$admin->profile_image.'"><span>'.$admin->name.'</span></div>';
               if(! empty($question->jawaban_gambar)) {
                   
                   if(Session::get('id') == $question->id_guru) {
                        $html .= '<img style="width:100px;margin-bottom:10px;border-radius:10px;" class="img-responsive" src="'.asset('storage/images/answer/').'/'.$question->jawaban_gambar.'"><small onclick="deleteImage('.$question->id.', 0)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';    
                   } else {
                       $html .= '<img style="width:100px;margin-bottom:10px;border-radius:10px;" class="img-responsive" src="'.asset('storage/images/answer/').'/'.$question->jawaban_gambar.'">';
                   }
                   
               }
               $html .= "<p>".$question->jawaban."<p>";
               
               if(Session::get('id') == $question->id_guru) {
                   $html .= '<button onclick="editJawaban('.$question->id.')" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</button><button onclick="deleteJawaban('.$question->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>';
                   
                   return '<div>'.$html.'</div>';
               } else {
                   return '<div>'.$html.'</div>';
               }
               
           })
           ->addColumn('action', function($question){
             return '<div>'.date('d-m-Y H:i:s', strtotime($question->created_at)).'</div>';   
           
                
        })->rawColumns(['action','jawaban'])
        ->make(true);
    }
    
    
    public function jawabanAdd(Request $request) 
    {
        $input = $request->all();
        $input['jawaban_gambar'] = null;
        $unique = uniqid();
        if($request->hasFile('jawaban_gambar')){
            $input['jawaban_gambar'] = str_slug($unique, ' - ').'.'.$request->jawaban_gambar->getClientOriginalExtension();
            $request->jawaban_gambar->move(public_path('/storage/images/answer'), $input['jawaban_gambar']);
        }

        Qanswer::create($input);

        return response()->json([
            'success'=>true
        ]);
    }
    
    
    public function jawabanEdit($id)
    {
        $answer = Qanswer::findorFail($id);
        return $answer;
    }
    
    public function jawabanUpdate(Request $request, $id )
    {
        $input = $request->all();
        $answer = Qanswer::findorFail($id);
        
        $input['jawaban_gambar'] = $answer->jawaban_gambar;

        if($request->hasFile('jawaban_gambar')){
            if($answer->jawaban_gambar != NULL){
                unlink(public_path('/storage/images/answer/'.$answer->jawaban_gambar));
            }
            
            $unique = uniqid();
            $input['jawaban_gambar'] = str_slug($unique, ' - ').'.'.$request->jawaban_gambar->getClientOriginalExtension();
            $request->jawaban_gambar->move(public_path('/storage/images/answer'), $input['jawaban_gambar']);
        }

        $answer->update($input);
        
        return response()->json([
            'success'=>true
        ]);
    }
    
    
    public function jawabanDelete($id)
    {
        $answer=Qanswer::findorFail($id);
        if($answer->jawaban_gambar != NULL){
            unlink(public_path('/storage/images/answer/'.$answer->jawaban_gambar));
        }

        Qanswer::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    public function deleteImage(Request $request) 
    {
        $input = $request->all();
        $answer = Qanswer::findorFail($input['id']);
        unlink(public_path('/storage/images/answer/'.$answer->jawaban_gambar));
        $answer->update(['jawaban_gambar'=> NULL]);
        
        return response()->json([
            'success'=>true
        ]);
        
    }
}
