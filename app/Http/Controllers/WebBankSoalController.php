<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\BankSoal;
use App\Kelas;
use App\BankSoalDetail;
use App\BankSoalAnswer;
use App\BankSoalSession;
use App\Category;
use App\TryoutDetail;
use DB;
use Session;

class WebBankSoalController extends Controller
{
   
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'banksoal';
        $kategori = Category::where('is_active', 1)->get();
        $kelas = Kelas::all();
        return view('banksoal.banksoal', compact('view','kategori','kelas'));
    }
  
  
    public function store(Request $request)
    {
        $input = $request->all();
        $query = BankSoal::create($input);
        $id = $query->id;
        
        $bank = BankSoal::findorFail($id);
        $bank->id_kelas = implode(",", $input['id_kelas']);
        $bank->save();

        return response()->json([
            'success'=>true
        ]);
    }
    
    
    public function kelasBankSoal($id)
    {
        $bank = BankSoal::findorFail($id);
        $kelas = explode(",", $bank->id_kelas);
        return $kelas;
    }


    public function bankSoalDetail($id)
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'detail-bank-soal';
        $ids = $id;
        $banksoal = BankSoal::findorFail($id);
        return view('banksoal.detail', compact('view', 'ids', 'banksoal'));
    }
    
    
    public function detailAdd(Request $request) 
    {
        $input = $request->all();
        
        $input['gambar_soal'] = null;
        $unique = uniqid();
        $nm = 'soal-'.$unique;
        if($request->hasFile('gambar_soal')){
            $input['gambar_soal'] = str_slug($nm, '-').'.'.$request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/banksoal'), $input['gambar_soal']);
        }
        
        
        $input['gambar_a'] = null;
        $nma = 'a-'.$unique;
        if($request->hasFile('gambar_a')){
            $input['gambar_a'] = str_slug($nma, '-').'.'.$request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/banksoal'), $input['gambar_a']);
        }
        
        $input['gambar_b'] = null;
        $nmb = 'b-'.$unique;
        if($request->hasFile('gambar_b')){
            $input['gambar_b'] = str_slug($nmb, '-').'.'.$request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/banksoal'), $input['gambar_b']);
        }
        
        
        $input['gambar_c'] = null;
        $nmc = 'c-'.$unique;
        if($request->hasFile('gambar_c')){
            $input['gambar_c'] = str_slug($nmc, '-').'.'.$request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/banksoal'), $input['gambar_c']);
        }
        
        $input['gambar_d'] = null;
        $nmd = 'd-'.$unique;
        if($request->hasFile('gambar_d')){
            $input['gambar_d'] = str_slug($nmd, '-').'.'.$request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/banksoal'), $input['gambar_d']);
        }
        
        $input['gambar_e'] = null;
        $nme = 'e-'.$unique;
        if($request->hasFile('gambar_e')){
            $input['gambar_e'] = str_slug($nme, '-').'.'.$request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/banksoal'), $input['gambar_e']);
        }

        
        BankSoalDetail::create($input);

        return response()->json([
            'success'=>true
        ]);
    }
    
    
    public function generateNomor(Request $request)
    {
        $input = $request->all();
        $query = BankSoalDetail::where('id_bank_soal', $input['idbanksoal'])->max('no_soal');
        return $query + 1;
    }
    
    
    
    public function detailEdit($id) 
    {
        $detail = BankSoalDetail::findorFail($id);
        return $detail;
    }
    
    
    public function detailUpdate(Request $request, $id)
    {
        $input = $request->all();
        $detail = BankSoalDetail::findorFail($id);
        
        $unique = uniqid();
        $uni = 'soal-'.$unique;
        $una = 'a-'.$unique;
        $unb = 'b-'.$unique;
        $unc = 'c-'.$unique;
        $und = 'd-'.$unique;
        $une = 'e-'.$unique;
        
        $input['gambar_soal'] = $detail->gambar_soal;
        if($request->hasFile('gambar_soal')){
            if($detail->gambar_soal != NULL){
                unlink(public_path('/images/banksoal/'.$detail->gambar_soal));
            }
            
            $input['gambar_soal'] = str_slug($uni, '-').'.'.$request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/banksoal'), $input['gambar_soal']);
        }
        
        $input['gambar_a'] = $detail->gambar_a;
        if($request->hasFile('gambar_a')){
            if($detail->gambar_a != NULL){
                unlink(public_path('/images/banksoal/'.$detail->gambar_a));
            }
            
            $input['gambar_a'] = str_slug($una, '-').'.'.$request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/banksoal'), $input['gambar_a']);
        }
        
        
        $input['gambar_b'] = $detail->gambar_b;
        if($request->hasFile('gambar_b')){
            if($detail->gambar_b != NULL){
                unlink(public_path('/images/banksoal/'.$detail->gambar_b));
            }
            
            $input['gambar_b'] = str_slug($unb, '-').'.'.$request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/banksoal'), $input['gambar_b']);
        }
        
        
        $input['gambar_c'] = $detail->gambar_c;
        if($request->hasFile('gambar_c')){
            if($detail->gambar_c != NULL){
                unlink(public_path('/images/banksoal/'.$detail->gambar_c));
            }
            
            $input['gambar_c'] = str_slug($unc, '-').'.'.$request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/banksoal'), $input['gambar_c']);
        }
        
        
        $input['gambar_d'] = $detail->gambar_d;
        if($request->hasFile('gambar_d')){
            if($detail->gambar_d != NULL){
                unlink(public_path('/images/banksoal/'.$detail->gambar_d));
            }
            
            $input['gambar_d'] = str_slug($und, '-').'.'.$request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/banksoal'), $input['gambar_d']);
        }
        
        
        $input['gambar_e'] = $detail->gambar_e;
        if($request->hasFile('gambar_e')){
            if($detail->gambar_e != NULL){
                unlink(public_path('/images/banksoal/'.$detail->gambar_e));
            }
            
            $input['gambar_e'] = str_slug($une, '-').'.'.$request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/banksoal'), $input['gambar_e']);
        }
        
        
        $detail->update($input);
        
        return response()->json([
            'success'=>true
        ]);
    }
    
    
    public function deleteImage(Request $request) 
    {
        $input = $request->all();
        $detail = BankSoalDetail::findorFail($input['id']);
        $type = $input['type'];
        if($type == 0) {
            if(! empty($detail->gambar_soal) && file_exists(public_path('/images/banksoal/'.$detail->gambar_soal))) {
                unlink(public_path('/images/banksoal/'.$detail->gambar_soal));
            }
            $detail->update(['gambar_soal'=> NULL]);
        }
        
        
        if($type == 1) {
            if(! empty($detail->gambar_a) && file_exists(public_path('/images/banksoal/'.$detail->gambar_a))) {
                unlink(public_path('/images/banksoal/'.$detail->gambar_a));
            }
            
            $detail->update(['gambar_a'=> NULL]);
        }
        
        if($type == 2) {
            if(! empty($detail->gambar_b) && file_exists(public_path('/images/banksoal/'.$detail->gambar_b))) {
                unlink(public_path('/images/banksoal/'.$detail->gambar_b));
            }

            $detail->update(['gambar_b'=> NULL]);
        }
        
        
        if($type == 3) {
            if(! empty($detail->gambar_c) && file_exists(public_path('/images/banksoal/'.$detail->gambar_c))) {
                unlink(public_path('/images/banksoal/'.$detail->gambar_c));
            }
            $detail->update(['gambar_c'=> NULL]);
        }
        
        
        if($type == 4) {
            if(! empty($detail->gambar_d) && file_exists(public_path('/images/banksoal/'.$detail->gambar_d))) {
                unlink(public_path('/images/banksoal/'.$detail->gambar_d));
            }
            $detail->update(['gambar_d'=> NULL]);
        }
        
        if($type == 5) {
            if(! empty($detail->gambar_e) && file_exists(public_path('/images/banksoal/'.$detail->gambar_e))) {
                unlink(public_path('/images/banksoal/'.$detail->gambar_e));
            }
            $detail->update(['gambar_e'=> NULL]);
        }
        
        return response()->json([
            'success'=>true
        ]);
        
    }
    
    
    public function deleteDetail(Request $request) 
    {
        
        $input = $request->all();
        $detail = BankSoalDetail::findorFail($input['id']);
        if($detail->gambar_soal != NULL){
            unlink(public_path('/images/banksoal/'.$detail->gambar_soal));
        }
        
        if($detail->gambar_a != NULL){
            unlink(public_path('/images/banksoal/'.$detail->gambar_a));
        }
        
        if($detail->gambar_b != NULL){
            unlink(public_path('/images/banksoal/'.$detail->gambar_b));
        }
        
        if($detail->gambar_c != NULL){
            unlink(public_path('/images/banksoal/'.$detail->gambar_c));
        }
        
        if($detail->gambar_d != NULL){
            unlink(public_path('/images/banksoal/'.$detail->gambar_d));
        }
        
        if($detail->gambar_e != NULL){
            unlink(public_path('/images/banksoal/'.$detail->gambar_e));
        }

        BankSoalDetail::destroy($input['id']);
        \App\TryoutReport::where('id_soal', $input['id'])->where('kategori', 'banksoal')->delete();

        return response()->json([
            'success'=>true

        ]);
    }
  
  
    public function edit($id)
    {
        $bank = BankSoal::findorFail($id);
        $data['data'] = $bank;
        $kategori = Category::findorFail($bank->id_kategori);
        $kelas = explode(",", $kategori->id_kelas);
        
        $html = "";
        foreach($kelas as $k) {
            
            $kls = Kelas::findorFail($k);
            $html .= '<option value="'.$k.'">'.$kls->nama_kelas.'</option>';
        }
        
        $data['kelas'] = $html;
        return $data;
    }

  
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $bank = BankSoal::findorFail($id);
        
        $bank->update($input);
        
        $bank->id_kelas = implode("," , $input['id_kelas']);
        $bank->save();
        return response()->json([
            'success'=>true
        ]);
    }


    public function destroy($id)
    {
        BankSoal::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function bankSoalTable(Request $request)
    {
        $banksoal = DB::table('bank_soals')
            ->select('bank_soals.*', 'kelas.nama_kelas', 'categories.category_name')
            ->join('kelas', 'kelas.id', '=', 'bank_soals.id_kelas')
            ->leftJoin('categories', 'categories.id', '=', 'bank_soals.id_kategori')
            ->when($request->kelas_id, function ($query, $kelas_id) {
                $query->whereRaw('FIND_IN_SET(?, bank_soals.id_kelas)', [$kelas_id]);
            })
            ->when($request->kategori_id, function ($query, $kategoriId) {
                $query->where('bank_soals.id_kategori', $kategoriId);
            })
            ->when($request->status_id !== null && $request->status_id !== '', function ($query) use ($request) {
                $query->where(
                    'bank_soals.is_active',
                    $request->status_id
                );
            })
            ->orderBy('bank_soals.urutan', 'asc')
            ->orderBy('bank_soals.id', 'asc');
                    
        return Datatables::of($banksoal)
           
           
           ->addColumn('jumlah_soal', function($banksoal){
               $d = BankSoalDetail::where('id_bank_soal', $banksoal->id);
               return '<div style="text-align:right;padding:4px;border-radius:3px;background-color:'.$banksoal->warna_soal.'"><strong><span style="color:'.$banksoal->warna_tulisan.';">'.$d->count().'</span></strong></div><br><div style="text-align:right;padding:4px;border-radius:3px;background-color:'.$banksoal->warna_jawaban.'"><strong><span style="color:'.$banksoal->warna_tulisan_jawaban.';">jawaban</span></strong></div>';
           })
           
           ->addColumn('target_score', function($banksoal){
              return '<div style="text-align:right;">'.number_format($banksoal->target_score).'</div>';
           })
           
           ->editColumn('id_kategori', function($banksoal){
               $kategori = Category::findorFail($banksoal->id_kategori);
               return '<div style="white-space:normal;width:200px;">'.$kategori->category_name.'</div>';
           })
           
           ->addColumn('id_kelas', function($banksoal){
               $kelasString = $banksoal->id_kelas;
               $kelasArray = explode(",", $kelasString);
               
               $html = "";
              
               for($i=0; $i < count($kelasArray); $i++) 
               {
                   $id = (int)$kelasArray[$i]; 
                   $kelas = Kelas::findorFail($id);
                  
                   $html .= $kelas->nama_kelas.', ';
               }
             
               
               return '<div style="width:250px;white-space:normal;">'.$html.'</div>';
           })
           
           ->addColumn('is_active', function($banksoal){
               if($banksoal->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           
           
           ->addColumn('is_repeated', function($banksoal){
               if($banksoal->is_repeated == 1) {
                   return '<center><span class="label label-success">Yes</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">No</span></center>';
               }
           })
           
           ->addColumn('is_skipped', function($banksoal){
               if($banksoal->is_skipped == 1) {
                   return '<center><span class="label label-success">Yes</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">No</span></center>';
               }
           })
           
           
           ->editColumn('judul', function($banksoal){
               return '<div style="text-align:left;white-space:nowrap;"><span class="t-urutan">'.$banksoal->urutan.'</span>  <strong>'.$banksoal->judul.'</strong><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( '.$banksoal->short_name.' )</div>';
           })
           
           ->addColumn('action', function($banksoal){
                return '<center><a onclick="detailSoal('. $banksoal->id.')" style="width:25px;margin-bottom:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a>'.
                '<br><a onclick="copyData('. $banksoal->id.')" style="margin-bottom:4px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-copy"></i></a>'.
                '<br><a onclick="editData('. $banksoal->id.')" style="width:25px;margin-bottom:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<br><a onclick="deleteData('. $banksoal->id.')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
        })->rawColumns(['judul','action','id_kelas','is_active','is_repeated','is_skipped','id_kategori','jumlah_soal','target_score'])
        ->make(true);
    }
    
    
    public function bankSoalDetailTable($id) 
    {
        $detail = BankSoalDetail::where('id_bank_soal', $id)->get();
        return Datatables::of($detail)
           
           
           ->addColumn('is_active', function($detail){
               if($detail->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           
           ->addColumn('soal', function($detail){
               if(! empty($detail->gambar_soal)) {
                   return '<div><a href="'.asset('images/banksoal/').'/'.$detail->gambar_soal.'" target="_blank"><img style="width:90px;" class="img-responsive" src="'.asset('images/banksoal/').'/'.$detail->gambar_soal.'"></a><small onclick="deleteImage('.$detail->id.', 0)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small><br>'.$detail->soal.'</div>';
               } else {
                   return '<div>'.$detail->soal.'</div>';
               }
               
           })
           
           ->addColumn('jawaban_a', function($detail){
               $html = '';
               $html = '<div>';
               $html .= '<b>A</b>. '.$detail->jawaban_a.'';
               if(! empty($detail->gambar_a)) {
                   $html .= '<a href="'.asset('images/banksoal/').'/'.$detail->gambar_a.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/banksoal/').'/'.$detail->gambar_a.'"></a><small onclick="deleteImage('.$detail->id.', 1)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>B</b>. '.$detail->jawaban_b.'';
               if(! empty($detail->gambar_b)) {
                   $html .= '<a href="'.asset('images/banksoal/').'/'.$detail->gambar_b.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/banksoal/').'/'.$detail->gambar_b.'"></a><small onclick="deleteImage('.$detail->id.', 2)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>C</b>. '.$detail->jawaban_c.'';
               if(! empty($detail->gambar_c)) {
                   $html .= '<a href="'.asset('images/banksoal/').'/'.$detail->gambar_c.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/banksoal/').'/'.$detail->gambar_c.'"></a><small onclick="deleteImage('.$detail->id.', 3)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>D</b>. '.$detail->jawaban_d.'';
               if(! empty($detail->gambar_d)) {
                   $html .= '<a href="'.asset('images/banksoal/').'/'.$detail->gambar_d.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/banksoal/').'/'.$detail->gambar_d.'"></a><small onclick="deleteImage('.$detail->id.', 4)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>E</b>. '.$detail->jawaban_e.'';
               if(! empty($detail->gambar_e)) {
                   $html .= '<a href="'.asset('images/banksoal/').'/'.$detail->gambar_e.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/banksoal/').'/'.$detail->gambar_e.'"></a><small onclick="deleteImage('.$detail->id.', 5)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '</div>';
               return $html;
           })
           ->addColumn('action', function($detail){
                return '<center><a onclick="editData('. $detail->id.')" style="width:25px;margin-bottom:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<br><a onclick="deleteData('. $detail->id.')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
        })->rawColumns(['soal','jawaban_a','is_active','action'])
        ->make(true);
    }
    
    
    public function copyBankSoal(Request $request) 
    {
        $input = $request->all();
        $soalAsal = BankSoalDetail::where('id_bank_soal', $input['dari'])->get();
        if($input['jenis'] == 1) {
            
            $no = TryoutDetail::where('id_tryout', $input['tujuan'])
                ->select('no_soal')
                ->orderBy('id', 'desc');
            $nos = $no->first();    
            
            $noSoal = 1;
            if($no->count() > 0) {
                $noSoal = $nos->no_soal + 1;    
            }
            
            foreach($soalAsal as $s) {
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
                
                if(! empty($s->gambar_soal)) {
                if(! file_exists(public_path('images/question/'.$s->gambar_soal)) && file_exists(public_path('images/banksoal/'.$s->gambar_soal)) ) {
                    File::copy(public_path('images/banksoal/'.$s->gambar_soal), public_path('images/question/'.$s->gambar_soal));    
                    }
                }
                
                if(! empty($s->gambar_a)) {
                    if(! file_exists(public_path('images/question/'.$s->gambar_a)) && file_exists(public_path('images/banksoal/'.$s->gambar_a))) {
                        File::copy(public_path('images/banksoal/'.$s->gambar_a), public_path('images/question/'.$s->gambar_a));    
                    }
                }
                
                if(! empty($s->gambar_b)) {
                    if(! file_exists(public_path('images/question/'.$s->gambar_b)) && file_exists(public_path('images/banksoal/'.$s->gambar_b))) {
                        File::copy(public_path('images/banksoal/'.$s->gambar_b), public_path('images/question/'.$s->gambar_b));    
                    }
                }
                
                if(! empty($s->gambar_c)) {
                    if(! file_exists(public_path('images/question/'.$s->gambar_c)) && file_exists(public_path('images/banksoal/'.$s->gambar_c))) {
                        File::copy(public_path('images/banksoal/'.$s->gambar_c), public_path('images/question/'.$s->gambar_c));    
                    }
                }
                
                if(! empty($s->gambar_d)) {
                    if(! file_exists(public_path('images/question/'.$s->gambar_d)) && file_exists(public_path('images/banksoal/'.$s->gambar_d))) {
                        File::copy(public_path('images/banksoal/'.$s->gambar_d), public_path('images/question/'.$s->gambar_d));    
                    }
                }
                
                if(! empty($s->gambar_e)) {
                    if(! file_exists(public_path('images/question/'.$s->gambar_e)) && file_exists(public_path('images/banksoal/'.$s->gambar_e))) {
                        File::copy(public_path('images/banksoal/'.$s->gambar_e), public_path('images/question/'.$s->gambar_e));    
                    }
                }
                
                $td->save();
                $noSoal++;
            }
                    
        } else if($input['jenis'] == 2) {
            $no = \App\BankSoalDetail::where('id_bank_soal', $input['tujuan'])
                ->select('no_soal')
                ->orderBy('id', 'desc');
            $nos = $no->first();    
            
            $noSoal = 1;
            if($no->count() > 0) {
                $noSoal = $nos->no_soal + 1;    
            }
            
            // dd($noSoal);
            foreach($soalAsal as $s) {
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
                $td->save();
                
                $noSoal++;
            }
        }
        
        return response()->json([
            "success" => true
            ]);
    }
    
    public function deleteAll(Request $request)
    {
        $input = $request->all();
        
        try {
            $banksoal = BankSoalDetail::where('id_bank_soal', $input['id'])->get();
           
            foreach($banksoal as $key) {
                \App\TryoutReport::where('id_soal', $key->id)->where('kategori', 'banksoal')->delete();
            }
            BankSoalDetail::where('id_bank_soal', $input['id'])->delete();
    
            return response()->json([
                'success'=>true
    
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=> $e->getMessage()
    
            ]);
        }
        
    }  
    
    public function getKategori($idKelas)
    {
        $kategori = DB::table('categories')
            ->whereRaw('FIND_IN_SET(?, id_kelas)', [$idKelas])
            ->get();
            
        return response()->json($kategori);
    }
    
    
}
