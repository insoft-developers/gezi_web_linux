<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Location;
use App\Jadwal;
use Illuminate\Support\Str;
use Yajra\DataTables\Datatables;


class JadwalController extends Controller
{


    public function table()
    {
        $data = Jadwal::all();
        return Datatables::of($data)
            ->addColumn('is_active', function ($data) {
                return $data->is_active
                    ? '<span class="badge bg-green">Aktif</span>'
                    : '<span class="badge bg-red">Tidak Aktif</span>';
            })
            ->addColumn('action', function ($data) {
                return '<center>
                  <a onclick="editData(' . $data->id . ')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>' .
                    '<br><a onclick="deleteData(' . $data->id . ')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
            })->rawColumns(['action', 'is_active'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'jadwal';
        return view('setting.jadwal', compact('view'));
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

        Jadwal::create($input);

        return response()->json([
            'success' => true
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
        $data = Jadwal::find($id);
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
        $data = Jadwal::find($id);


        $data->update($input);

        return response()->json([
            'success' => true
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
        Jadwal::destroy($id);
        return response()->json([
            'success' => true

        ]);
    }
}
