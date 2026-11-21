<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ref;
use Yajra\DataTables\Datatables;
use App\Kelas;
use App\ParentLink;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Parent_;

class ParentLinkController extends Controller
{
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        $view = 'parent-link';
        $kelas = Kelas::all();
        return view('home.parent_link', compact('view','kelas'));
    }
    
    public function store(Request $request)
    {
        
        try {
            $input = $request->all();
            $kelas = implode(",", $input['id_kelas']);
    
            $ref = new ParentLink();
            $ref->title = $input['title'];
            $ref->url = $input['url'];
            $ref->id_kelas = $kelas;
            $ref->is_active = $input['is_active'];
            $ref->created_at = date('Y-m-d H:i:s');
            $ref->updated_at = date('Y-m-d H:i:s');
            $ref->save();
    
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e) {
            return response()->json([
                'success'=>false,
                'message' => $e->getMessage()
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
        $ref['data'] = ParentLink::findorFail($id);
        $ref['kelas'] = explode(",", $ref['data']->id_kelas);
        return response()->json($ref);
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
            $ref = ParentLink::findorFail($id);
          
            $kelas = implode(",", $input['id_kelas']);
    
            
            $ref->title = $input['title'];
            $ref->url = $input['url'];
            $ref->id_kelas = $kelas;
            $ref->is_active = $input['is_active'];
            $ref->updated_at = date('Y-m-d H:i:s');
            $ref->save();
    
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e) {
            return response()->json([
                'success'=>false,
                'message' => $e->getMessage()
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
        return ParentLink::destroy($id);
    }
    
    
    
    public function table()
    {
        $ref = ParentLink::all();
        return Datatables::of($ref)
            ->addColumn('is_active', function($ref){
               if($ref->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
            })
            ->addColumn('id_kelas', function($ref){
                $kelas = explode(",", $ref->id_kelas);
                $html = "";
                $html .= "<ul>";
                foreach($kelas as $k) {
                    $nk = Kelas::findorFail($k);
                    $html .= "<li>".$nk->nama_kelas."</li>";
                }
                $html .= "</ul>";
                return $html;
            })
            ->addColumn('url', function($ref){

                return '<a target="_blank" href="'.$ref->url.'">Buka File</a>';

            })
           
            ->addColumn('action', function($ref){
                return '<center><a onclick="editData('. $ref->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="deleteData('. $ref->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
        })->rawColumns(['action', 'url', 'id_kelas','is_active'])
        ->make(true);
    
    }
}
