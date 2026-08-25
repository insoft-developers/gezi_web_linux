<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Category;
use App\Kelas;
use App\Mapel;
use DB;
use App\MateriPembelajaran;
use Session;
class WebMateriController extends Controller
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
        $view = 'materi';
        $kategori = DB::table('categories')
                    ->select('categories.*', 'mapels.mapel_name')
                    ->join('mapels', 'mapels.id', '=', 'categories.id_mapel')
                    ->get();
        return view('bimbel.materi', compact('view', 'kategori'));
    }
    
    
    public function setKategori(Request $request) 
    {
        $input = $request->all();
        return Category::where('id_kelas', $input['idKelas'])->where('id_mapel', $input['idMapel'])->get();
        
    }

    
    public function create()
    {
        //
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
        $query = MateriPembelajaran::create($input);
        $id = $query->id;
        
        $mp = MateriPembelajaran::findorFail($id);
        $mp->id_kelas = implode(",", $input['id_kelas']);
        $mp->save();
        
        
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
        $materi = MateriPembelajaran::findorFail($id);
        
        $data['data'] = $materi;
        $mapel = Mapel::findorFail($materi->id_mapel);
        $data['mapel'] = $mapel;
        $kategori = Category::findorFail($materi->id_kategori);
        $kelas = explode(",", $kategori->id_kelas);
        
        $html = "";
        foreach($kelas as $k) {
            $kls = Kelas::findorFail($k);
            $html .= '<option value="'.$k.'">'.$kls->nama_kelas.'</option>';
        }
        
        $data['kelas'] = $html;
        
        return $data;
    }
    
    
    public function kelasMateriSelect($id)
    {
        $materi = MateriPembelajaran::findorFail($id);
        $kelas = explode(",", $materi->id_kelas); 
        return $kelas;
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
        $materi = MateriPembelajaran::findorFail($id);
        
        $materi->update($input);
        
        $kelas = implode(",", $input['id_kelas']);
        $m = MateriPembelajaran::findorFail($id);
        $m->id_kelas = $kelas;
        $m->save();
        
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
        MateriPembelajaran::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function materiTable()
    {
        $materi = DB::table('materi_pelajaran')
                    ->select('materi_pelajaran.*', 'kelas.nama_kelas', 'mapels.mapel_name', 'categories.category_name')
                    ->join('kelas', 'kelas.id', '=', 'materi_pelajaran.id_kelas')
                    ->join('mapels', 'mapels.id', '=', 'materi_pelajaran.id_mapel')
                    ->join('categories', 'categories.id', '=', 'materi_pelajaran.id_kategori')
                    ->get();
        return Datatables::of($materi)
           ->addColumn('link_file', function($materi){
               return '<div><a href="https://drive.google.com/uc?export=view&id='.$materi->link_file.'" target="_blank">'.$materi->link_file.'</a><div>';
           })
           ->addColumn('is_active', function($materi){
               if($materi->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           ->addColumn('nama_kelas', function($materi){
               $kelasString = $materi->id_kelas;
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
           
            ->addColumn('action', function($materi){
                return '<center><a onclick="editData('. $materi->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="deleteData('. $materi->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['nama_kelas','link_file','is_active','action'])
        ->make(true);
    
    }
}
