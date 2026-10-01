<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Bts;
use App\Exports\BtsExport;
use App\Location;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class BtsController extends Controller
{

    public function index()
    {
        if (!Session::has('id')) {
            return Redirect(route('login'));
        }

        $view = 'bts';
        $users = User::select('id', 'name')->where('is_active', 1)->get();
        $locations = Location::all();

        return view('bts.index', compact(
            'view',
            'users',
            'locations'
        ));
    }


    public function table(Request $request)
    {
        $query = Bts::query()
            ->with(['user.location']);

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'waktu_masuk',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate(
                'waktu_masuk',
                '<=',
                $request->tanggal_selesai
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER USER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('user_id')) {
            $query->where('userid', $request->user_id);
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER LOCATION
        |--------------------------------------------------------------------------
        */

        if ($request->filled('location_id')) {
            $locationId = $request->location_id;
            $query->whereHas('user.location', function ($q) use ($locationId) {
                $q->where('location_id', $locationId);
            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER JADWAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('host_id')) {
            $query->where('host_masuk', $request->host_id);
        }


        return DataTables::of($query)

            ->addColumn('status_label', function ($data) {

                if ($data->status == 1) {
                    return '<span class="label label-success">
                                <i class="fa fa-sign-in"></i> Masuk
                            </span>';
                }

                if ($data->status == 2) {
                    return '<span class="label label-warning">
                                <i class="fa fa-sign-out"></i> Pulang
                            </span>';
                }

                return '<span class="label label-default">
                            Tidak Diketahui
                        </span>';
            })


            ->addColumn('userid', function ($data) {
                return optional($data->user)->name ?? '';
            })

            ->addColumn('kelas', function ($data) {
                return optional(optional($data->user)->kelas)->nama_kelas ?? '';
            })
            ->addColumn('sekolah', function ($data) {
                return optional(optional($data->user)->school)->school_name ?? '';
            })
            ->addColumn('phone', function ($data) {
                return optional($data->user)->phone ?? '';
            })


            ->addColumn('location_id', function ($data) {

                return optional(optional($data->user)->location)->name ?? '';
            })



            ->editColumn('waktu_masuk', function ($data) {

                return $data->waktu_masuk
                    ? date('d-m-Y H:i', strtotime($data->waktu_masuk))
                    : '-';
            })


            ->editColumn('waktu_pulang', function ($data) {

                return $data->waktu_pulang
                    ? date('d-m-Y H:i', strtotime($data->waktu_pulang))
                    : '-';
            })


            ->addColumn('lat_masuk', function ($row) {
                if ($row->lat_masuk && $row->lng_masuk) {
                    $url = "https://www.google.com/maps/search/?api=1&query={$row->lat_masuk},{$row->lng_masuk}";

                    return '
            <div style="text-align:center">
                <a href="' .
                        $url .
                        '" target="_blank" class="text-primary fw-bold">
                    ' .
                        $row->lat_masuk .
                        ' , ' .
                        $row->lng_masuk .
                        '
                </a>
            </div>
        ';
                } else {
                    return '<div style="text-align:center">-</div>';
                }
            })


            ->addColumn('lat_pulang', function ($row) {
                if ($row->lng_pulang && $row->lng_pulang) {
                    $url = "https://www.google.com/maps/search/?api=1&query={$row->lng_pulang},{$row->lng_pulang}";

                    return '
            <div style="text-align:center">
                <a href="' .
                        $url .
                        '" target="_blank" class="text-primary fw-bold">
                    ' .
                        $row->lng_pulang .
                        ' , ' .
                        $row->lng_pulang .
                        '
                </a>
            </div>
        ';
                } else {
                    return '<div style="text-align:center">-</div>';
                }
            })

            ->addColumn('host_masuk', function ($data) {
                return optional($data->hostMasuk)->name ?? '-';
            })

            ->addColumn('host_pulang', function ($data) {
                return optional($data->hostPulang)->name ?? '-';
            })


            ->addColumn('action', function ($data) {
                return '<center>
                  <a title="Edit Data" onclick="editData(' . $data->id . ')" style="margin-bottom:5px;width:25px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>' .
                    '<br><a title="Hapus Data" onclick="deleteData(' . $data->id . ')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })
            ->rawColumns(['action', 'status_label', 'lat_masuk', 'lat_pulang'])
            ->make(true);
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
    public function store(Request $request) {}

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
        $data = Bts::find($id);
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
        $request->validate([
            "userid" => "required",
            "status" => "required",
            "waktu_masuk" => "required",
            "waktu_pulang" => "required",
            "lat_masuk" => "nullable",
            "lng_masuk" => "nullable",
            "lat_pulang" => "nullable",
            "lng_pulang" => "nullable",
            "keterangan_masuk" => "nullable",
            "keterangan_pulang" => "nullable",
            "catatan_admin_masuk" => "nullable",
            "catatan_admin_pulang" => "nullable",
            "host_masuk" => "required",
            "host_pulang" => "nullable"
        ]);

        $data = Bts::find($id);
        $data->update($input);
        return response()->json([
            "success" => true,
            "message" => "Berhasil update data"

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
        return Bts::destroy($id);
    }


    public function exportExcel(Request $request)
    {
        return Excel::download(
            new BtsExport($request),
            'data-bts-' . date('Y-m-d-H-i-s') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = Bts::query()
            ->with([
                'user.location',
                'user.kelas',
                'user.school',
                'hostMasuk',
                'hostPulang',
            ]);

        /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'waktu_masuk',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate(
                'waktu_masuk',
                '<=',
                $request->tanggal_selesai
            );
        }

        /*
    |--------------------------------------------------------------------------
    | FILTER STATUS
    |--------------------------------------------------------------------------
    */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
    |--------------------------------------------------------------------------
    | FILTER USER
    |--------------------------------------------------------------------------
    */

        if ($request->filled('user_id')) {
            $query->where('userid', $request->user_id);
        }

        /*
    |--------------------------------------------------------------------------
    | FILTER LOCATION
    |--------------------------------------------------------------------------
    */

        if ($request->filled('location_id')) {

            $locationId = $request->location_id;

            $query->whereHas('user.location', function ($q) use ($locationId) {
                $q->where('location_id', $locationId);
            });
        }

        /*
    |--------------------------------------------------------------------------
    | FILTER HOST
    |--------------------------------------------------------------------------
    */

        if ($request->filled('host_id')) {
            $query->where('host_masuk', $request->host_id);
        }

        $data = $query
            ->orderByDesc('id')
            ->get();

        $pdf = Pdf::loadView('bts.pdf', [
            'data' => $data,
            'request' => $request,
        ]);

        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream(
            'data-bts-' . date('Y-m-d-His') . '.pdf'
        );
    }
}
