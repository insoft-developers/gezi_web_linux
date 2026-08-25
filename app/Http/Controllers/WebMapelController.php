<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Mapel;
use App\Kelas;
use Session;
class WebMapelController extends Controller
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
        $view = 'mapel';
        $kelas = Kelas::all();
        return view('bimbel.mapel', compact('view','kelas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        
        $input['mapel_image'] = null;
        $unique = uniqid();
        if($request->hasFile('mapel_image')){
            $input['mapel_image'] = str_slug($unique, ' - ').'.'.$request->mapel_image->getClientOriginalExtension();
            $request->mapel_image->move(public_path('/images/mapel'), $input['mapel_image']);
        }

        $query = Mapel::create($input);
        $id = $query->id;
        
        $kelas = $input['id_kelas'];
        $kelasString = implode(",", $kelas);
        $mapel = Mapel::findorFail($id);
        $mapel->id_kelas = $kelasString;
        $mapel->save();
        

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
        $mapel = Mapel::findorFail($id);
        $data['data'] = $mapel;
        $kelasString = $mapel->id_kelas;
        $kelas = explode("," , $kelasString);
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
        $input = $request->all();
        $mapel = Mapel::findorFail($id);
        
        $input['mapel_image'] = $mapel->mapel_image;

        if($request->hasFile('mapel_image')){
            if($mapel->mapel_image != NULL){
                unlink(public_path('/images/mapel/'.$mapel->mapel_image));
            }
            
            $unique = uniqid();
            $input['mapel_image'] = str_slug($unique, ' - ').'.'.$request->mapel_image->getClientOriginalExtension();
            $request->mapel_image->move(public_path('/images/mapel'), $input['mapel_image']);
        }
        
        
        
       
        $mapel->update($input);
        
        $kelasString = implode(",", $input['id_kelas']);
        $query = Mapel::findorFail($id);
        $query->id_kelas = $kelasString;
        $query->save();
        
        
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
        $mapel=Mapel::findorFail($id);
        if($mapel->mapel_image != NULL){
            unlink(public_path('/images/mapel/'.$mapel->mapel_image));
        }

        Mapel::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function mapelTable()
    {
        $mapel = Mapel::all();
        return Datatables::of($mapel)
           ->addColumn('urutan', function($mapel) {
               return '<center><strong>'.$mapel->urutan.'</strong></center>';
           })
           ->addColumn('mapel_image', function($mapel){
               return '<img style="width:150px;height:100px;border-radius:10px;" src="'.asset('images/mapel').'/'.$mapel->mapel_image.'" >';
           })
           ->addColumn('is_active', function($mapel){
               if($mapel->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           
           ->addColumn('id_kelas', function($mapel){
               if($mapel->id_kelas == null) {
                   return '';
               }
               
               $kelasString = $mapel->id_kelas;
               $kelasArray = explode(",", $kelasString);
               
               $html = "";
               $html .= "<ul>";
               for($i=0; $i < count($kelasArray); $i++) 
               {
                   $id = (int)$kelasArray[$i]; 
                   $kelas = Kelas::find($id);
                   if($kelas) {
                       $html .= '<li>'.$kelas->nama_kelas.'</li>';    
                   } else {
                       $html .= '<li>-</li>';
                   }
                   
               }
               $html .= "</ul>";
               
               return '<div>'.$html.'</div>';
           })
           
           ->addColumn('created_at', function($mapel){
               if(! empty($mapel->created_at)) {
                    return '<center>'.date('d-m-Y', strtotime($mapel->created_at)).'</center>';    
               } else {
                    return '';
               }
               
           })
            ->addColumn('action', function($mapel){
                return '<center><a onclick="editData('. $mapel->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="deleteData('. $mapel->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['urutan','created_at','is_active','id_kelas','mapel_image','action'])
        ->make(true);
    
    }
}
