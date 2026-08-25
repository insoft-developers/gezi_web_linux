<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DashboardMenuSetting;
use Yajra\DataTables\Datatables;
use Session;

class DashboardMenuSettingController extends Controller
{
    
    public function table()
    {
        $data = DashboardMenuSetting::all();
        return Datatables::of($data)
            ->addColumn('action', function($data){
                return '<center><a onclick="editData('. $data->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a></center>';
        })->rawColumns(['action'])
        ->make(true);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'dashboard_menu_setting';
        return view('setting.dms', compact('view'));
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
        $data = DashboardMenuSetting::find($id);
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
        $data = DashboardMenuSetting::find($id);
        
        
        $data->update($input);
        
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
        //
    }
}
