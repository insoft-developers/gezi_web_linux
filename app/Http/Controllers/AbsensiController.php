<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Datatables;
use App\Absensi;
use App\Exports\AbsensiExport;
use App\User;
use App\Location;
use App\Jadwal;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;
use PDF;

class AbsensiController extends Controller
{
    public function index()
    {
        if (!Session::has('id')) {
            return Redirect(route('login'));
        }

        $view = 'absensi';

        $users = User::orderBy('name')->get();

        $locations = Location::orderBy('name')->get();

        $jadwals = Jadwal::orderBy('id', 'desc')->get();

        return view('absensi.index', compact(
            'view',
            'users',
            'locations',
            'jadwals'
        ));
    }


    public function table(Request $request)
    {
        $query = Absensi::query();

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'tanggal_masuk',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate(
                'tanggal_masuk',
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
            $query->where('user_id', $request->user_id);
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER LOCATION
        |--------------------------------------------------------------------------
        */

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER JADWAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('jadwal_id')) {
            $query->where('jadwal_id', $request->jadwal_id);
        }


        return Datatables::of($query)

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


            ->addColumn('user_id', function ($data) {
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


            ->addColumn('location_name', function ($data) {

                return optional($data->location)->name ?? '';
            })


            ->addColumn('jadwal_name', function ($data) {
                return optional($data->jadwal)->name ?? '';
            })


            ->editColumn('tanggal_masuk', function ($data) {

                return $data->tanggal_masuk
                    ? date('d-m-Y', strtotime($data->tanggal_masuk))
                    : '-';
            })


            ->editColumn('tanggal_pulang', function ($data) {

                return $data->tanggal_pulang
                    ? date('d-m-Y', strtotime($data->tanggal_pulang))
                    : '-';
            })


            ->editColumn('jam_masuk', function ($data) {

                return $data->jam_masuk
                    ? date('H:i:s', strtotime($data->jam_masuk))
                    : '-';
            })


            ->editColumn('jam_pulang', function ($data) {

                return $data->jam_pulang
                    ? date('H:i:s', strtotime($data->jam_pulang))
                    : '-';
            })


            ->addColumn('koordinat_masuk', function ($data) {

                if (!$data->latitude_masuk || !$data->longitude_masuk) {
                    return '-';
                }

                return $data->latitude_masuk .
                    ', ' .
                    $data->longitude_masuk;
            })


            ->addColumn('koordinat_pulang', function ($data) {

                if (!$data->latitude_pulang || !$data->longitude_pulang) {
                    return '-';
                }

                return $data->latitude_pulang .
                    ', ' .
                    $data->longitude_pulang;
            })

            ->addColumn('waktu_masuk', function ($data) {
                return optional($data->jadwal)->jam_masuk ?? '';
            })

            ->addColumn('waktu_pulang', function ($data) {
                return optional($data->jadwal)->jam_pulang ?? '';
            })



            ->addColumn('action', function ($data) {
                return '<center>
                  <a title="Edit Data" onclick="editData(' . $data->id . ')" style="margin-bottom:5px;width:25px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>' .
                    '<br><a title="Hapus Data" onclick="deleteData(' . $data->id . ')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })
            ->rawColumns(['action', 'status_label'])
            ->make(true);
    }


    public function edit(String $id)
    {
        return Absensi::find($id);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        try {

            $request->validate([
                'jadwal_id'          => 'required|integer|exists:jadwals,id',
                'location_id'        => 'required|integer|exists:locations,id',
                'user_id'            => 'required|integer|exists:users,id',
                'status'             => 'required|integer|in:1,2',

                'tanggal_masuk'      => 'required|date',
                'tanggal_pulang'     => 'nullable|date|after_or_equal:tanggal_masuk',

                'jam_masuk'          => 'required|date_format:H:i',
                'jam_pulang'         => 'nullable|date_format:H:i',

                'latitude_masuk'     => 'nullable|string|max:255',
                'longitude_masuk'    => 'nullable|string|max:255',

                'latitude_pulang'    => 'nullable|string|max:255',
                'longitude_pulang'   => 'nullable|string|max:255',

                'keterangan_masuk'  => 'nullable|string|max:255',
                'keterangan_pulang' => 'nullable|string|max:255',

                'alasan_masuk'       => 'nullable|string|max:255',
                'alasan_pulang'      => 'nullable|string|max:255',
            ]);


            $data = Absensi::find($id);
            $data->update($input);


            return response()->json([
                "success" => true,
                "message" => "Berhasil"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function destroy(String $id)
    {
        return Absensi::destroy($id);
    }


    public function exportExcel(Request $request)
    {
        return Excel::download(
            new AbsensiExport($request),
            'data-absensi-' . date('Y-m-d-H-i-s') . '.xlsx'
        );
    }


    public function exportPdf(Request $request)
    {
        $query = Absensi::with([
            'user',
            'user.kelas',
            'user.school',
            'location',
            'jadwal'
        ]);

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'tanggal_masuk',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate(
                'tanggal_masuk',
                '<=',
                $request->tanggal_selesai
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('jadwal_id')) {
            $query->where('jadwal_id', $request->jadwal_id);
        }

        $data = $query
            ->orderBy('id', 'desc')
            ->get();

        $pdf = PDF::loadView(
            'absensi.pdf',
            [
                'data' => $data,
                'request' => $request
            ]
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream(
            'data-absensi-' . date('Y-m-d-H-i-s') . '.pdf'
        );
    }
}
