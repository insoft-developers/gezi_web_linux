<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\User;
use App\Kelas;
use App\School;
use Session;
use App\Location;
use App\QuizSession;
use App\BankSoalSession;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use DB;
use App\QuizAnswer;
use App\BankSoalAnswer;
use App\TryoutSession;
use App\TryoutAnswer;


class WebSiswaController extends Controller
{
    
    
    
    
    public function export(Request $request)
    {
        return Excel::download(
            new SiswaExport($request),
            'data-siswa-' . date('Y-m-d-H-i-s') . '.xlsx'
        );
    }

    
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
        
        if(Session::get('level') != 1) {
            return Redirect(route('default'));
        }
        
        
        $view = 'siswa';
        $kelas = Kelas::all();
        $sekolah = School::all();
        $locations = Location::all();
        
        $groups = User::select('class_group')->groupBy('class_group')->get();
        return view('siswa.siswa', compact('view', 'kelas','sekolah','locations','groups'));
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
        $input['profile_image'] = null;
        $unique = uniqid();
        if($request->hasFile('profile_image')){
            $input['profile_image'] = str_slug($unique, ' - ').'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/storage/images/profil'), $input['profile_image']);
        }

        $user = new User;
        $user->name = $input['name'];
        $user->nis = $input['nis'];
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);
        $user->id_kelas = $input['id_kelas'];
        $user->class_group = $input['class_group'];
        $user->fathers_phone = $input['fathers_phone'];
        $user->mothers_phone = $input['mothers_phone'];
        $user->profile_image = $input['profile_image'];
        $user->phone = $input['phone'];
        $user->created_at = date('Y-m-d H:i:s');
        $user->school_id = $input['school_id'];
        $user->is_active = $input['is_active'];
        $user->location_id = $input['location_id'];
        $user->is_qrcode = $input['is_qrcode'];
        $user->save();
        
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
        $user = User::findorFail($id);
        return $user;
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
        $user = User::findorFail($id);
        
        $input['profile_image'] = $user->profile_image;

        if($request->hasFile('profile_image')){
            if($user->profile_image != NULL){
                unlink(public_path('/storage/images/profil/'.$user->profile_image));
            }
            
            $unique = uniqid();
            $input['profile_image'] = str_slug($unique, ' - ').'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/storage/images/profil'), $input['profile_image']);
        }

        $user->name = $input['name'];
        $user->nis = $input['nis'];
        $user->email = $input['email'];
        $user->id_kelas = $input['id_kelas'];
        $user->class_group = $input['class_group'];
        $user->fathers_phone = $input['fathers_phone'];
        $user->mothers_phone = $input['mothers_phone'];
        $user->profile_image = $input['profile_image'];
        $user->phone = $input['phone'];
        $user->school_id = $input['school_id'];
        $user->is_active = $input['is_active'];
        $user->location_id = $input['location_id'];
        $user->is_qrcode = $input['is_qrcode'];
        if(! empty($input['password']))
        {
            $user->password = bcrypt($input['password']);
        }
        
        $user->save();
        
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
        $user=User::findorFail($id);
        if($user->profile_image != NULL && file_exists(public_path('/storage/images/profil/'.$user->profile_image))){
            unlink(public_path('/storage/images/profil/'.$user->profile_image));
        }

        User::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
  public function siswaTable(Request $request)
    {
       
    
        $siswa = User::with([
            'location',
            'kelas',
            'school'
        ]);
    
    
    
        // Lokasi
        if ($request->filled('location_id')) {
            $siswa->where(
                'location_id',
                $request->location_id
            );
        }
    
        // Kelas
        if ($request->filled('id_kelas')) {
            $siswa->where(
                'id_kelas',
                $request->id_kelas
            );
        }
    
        // Group Kelas
        // Kolom langsung di users.class_group
        if ($request->filled('class_group')) {
            $siswa->where(
                'class_group',
                $request->class_group
            );
        }
    
        // Sekolah
        if ($request->filled('school_id')) {
            $siswa->where(
                'school_id',
                $request->school_id
            );
        }
    
        // Tanggal pendaftaran mulai
        if ($request->filled('date_start')) {
            $siswa->where(
                'created_at',
                '>=',
                $request->date_start . ' 00:00:00'
            );
        }
    
        // Tanggal pendaftaran sampai
        if ($request->filled('date_end')) {
            $siswa->where(
                'created_at',
                '<=',
                $request->date_end . ' 23:59:59'
            );
        }
    
    
        $filteredUserIds = (clone $siswa)
            ->select('users.id');
    
    
      
    
        $quizScores = DB::table('quiz_sessions as qs')
    
            ->join(
                DB::raw('(
                    SELECT
                        user_id,
                        id_quiz,
                        MAX(id) AS latest_session_id
                    FROM quiz_sessions
                    GROUP BY user_id, id_quiz
                ) as latest'),
                function ($join) {
                    $join->on(
                        'qs.id',
                        '=',
                        'latest.latest_session_id'
                    );
                }
            )
    
            ->join(
                'quiz_answers as qa',
                'qa.id_quiz',
                '=',
                'qs.id'
            )
    
            // HANYA USER YANG LOLOS FILTER
            ->whereIn(
                'qs.user_id',
                $filteredUserIds
            )
    
            ->select(
                'qs.user_id',
                DB::raw('SUM(qa.score) as total_score')
            )
    
            ->groupBy('qs.user_id')
    
            ->pluck(
                'total_score',
                'qs.user_id'
            );
    
    
      
        $bankScores = DB::table('bank_soal_sessions as bss')
    
            ->join(
                DB::raw('(
                    SELECT
                        id_user,
                        id_bank_soal,
                        MAX(id) AS latest_session_id
                    FROM bank_soal_sessions
                    GROUP BY id_user, id_bank_soal
                ) as latest'),
                function ($join) {
                    $join->on(
                        'bss.id',
                        '=',
                        'latest.latest_session_id'
                    );
                }
            )
    
            ->join(
                'bank_soal_answers as bsa',
                'bsa.id_session',
                '=',
                'bss.id'
            )
    
            // HANYA USER YANG LOLOS FILTER
            ->whereIn(
                'bss.id_user',
                $filteredUserIds
            )
    
            ->select(
                'bss.id_user',
                DB::raw('SUM(bsa.score) as total_score')
            )
    
            ->groupBy('bss.id_user')
    
            ->pluck(
                'total_score',
                'bss.id_user'
            );
    
    
        /*
        |--------------------------------------------------------------------------
        | DATATABLE
        |--------------------------------------------------------------------------
        */
    
        return Datatables::of($siswa)
    
           
            ->addColumn('quiz_score', function ($siswa) use ($quizScores) {
    
                return $quizScores->get(
                    $siswa->id,
                    0
                );
    
            })
    
    
           
    
            ->addColumn('bank_score', function ($siswa) use ($bankScores) {
    
                return $bankScores->get(
                    $siswa->id,
                    0
                );
    
            })
    
    
          
            ->addColumn('location_id', function ($siswa) {
    
                return $siswa->location->name ?? '-';
    
            })
    
    
           
            ->addColumn('profile_image', function ($siswa) {
    
                if (!empty($siswa->profile_image)) {
    
                    return '<a href="' .
                        asset('/storage/images/profil') .
                        '/' .
                        $siswa->profile_image .
                        '" target="_blank">
                            Foto
                        </a>';
    
                }
    
                return '<a href="' .
                    asset('/images/playstore.png') .
                    '" target="_blank">
                        Foto
                    </a>';
    
            })
    
    
            ->addColumn('id_kelas', function ($siswa) {
    
                return $siswa->kelas
    
                    ? '<div>' .
                        $siswa->kelas->nama_kelas .
                      '</div>'
    
                    : '<div>not found</div>';
    
            })
    
    
    
            ->addColumn('created_at', function ($siswa) {
    
                return '<center>' .
                    date(
                        'd-m-Y',
                        strtotime($siswa->created_at)
                    ) .
                    '</center>';
    
            })
    
    
           
    
            ->addColumn('last_action', function ($siswa) {
    
                if (!empty($siswa->last_activity)) {
    
                    return '<center>' .
                        date(
                            'd-m-Y H:i:s',
                            strtotime($siswa->last_activity)
                        ) .
                        '</center>';
    
                }
    
                return '';
    
            })
    
    
            /*
            |--------------------------------------------------------------------------
            | SCHOOL
            |--------------------------------------------------------------------------
            */
    
            ->addColumn('school_id', function ($siswa) {
    
                return $siswa->school->school_name ?? '-';
    
            })
    
    
            /*
            |--------------------------------------------------------------------------
            | ACTIVE
            |--------------------------------------------------------------------------
            */
    
            ->addColumn('is_active', function ($siswa) {
    
                if ($siswa->is_active == 1) {
    
                    return '<center>
                        <span class="label label-success">
                            Active
                        </span>
                    </center>';
    
                }
    
                return '<center>
                    <span class="label label-danger">
                        Inactive
                    </span>
                </center>';
    
            })
    
    
            /*
            |--------------------------------------------------------------------------
            | NAME
            |--------------------------------------------------------------------------
            */
    
            ->addColumn('name', function ($siswa) {
    
                $html = '';
                
                if ($siswa->is_login == 1) {
    
                    $html .= '<div>' .
                        $siswa->name .
                        '<br>
                        <span class="label label-success">
                            Login
                        </span>
                        </div>';
    
                } else {
                    $html.= '<div>' .
                    $siswa->name .
                    '<br>
                    <span class="label label-danger">
                        Logout
                    </span>
                    </div>';
                }
                
                if($siswa->is_qrcode == 1) {
                    $html .= '<br> <span class="label label-info">
                            Bisa Absen <i class="fa fa-check"></i>
                        </span>';
                }
                return $html;
    
                
    
            })
    
    
            /*
            |--------------------------------------------------------------------------
            | LAMA MENJADI SISWA
            |--------------------------------------------------------------------------
            */
    
            ->addColumn('lama', function ($siswa) {
    
                if (!$siswa->created_at) {
                    return '-';
                }
    
                $diff = $siswa->created_at->diff(now());
    
                $hasil = [];
    
                if ($diff->y > 0) {
                    $hasil[] = $diff->y . ' tahun';
                }
    
                if ($diff->m > 0) {
                    $hasil[] = $diff->m . ' bulan';
                }
    
                if ($diff->d > 0) {
                    $hasil[] = $diff->d . ' hari';
                }
    
                return count($hasil)
                    ? implode(' ', $hasil)
                    : 'Hari ini';
    
            })
    
    
            /*
            |--------------------------------------------------------------------------
            | ACTION
            |--------------------------------------------------------------------------
            */
    
            ->addColumn('action', function ($siswa) {
    
                $html = '<center>';
    
                if ($siswa->is_active == 1) {
    
                    $html .= '<a
                        onclick="deactivate(' . $siswa->id . ')"
                        style="margin-bottom:5px;width:80px;"
                        class="btn btn-danger btn-xs">
    
                        <i class="glyphicon glyphicon-remove"></i>
                        Deactivate
    
                    </a>';
    
                } else {
    
                    $html .= '<a
                        onclick="activate(' . $siswa->id . ')"
                        style="margin-bottom:5px;width:80px;"
                        class="btn btn-success btn-xs">
    
                        <i class="glyphicon glyphicon-check"></i>
                        Activate
    
                    </a>';
    
                }
    
                $html .= '<br>
    
                    <a
                        onclick="editData(' . $siswa->id . ')"
                        style="margin-bottom:5px;width:80px;"
                        class="btn btn-primary btn-xs">
    
                        <i class="glyphicon glyphicon-edit"></i>
                        Edit
    
                    </a>';
    
                $html .= '<br>
    
                    <a
                        onclick="deleteData(' . $siswa->id . ')"
                        style="margin-bottom:5px;width:80px;"
                        class="btn btn-danger btn-xs">
    
                        <i class="glyphicon glyphicon-trash"></i>
                        Delete
    
                    </a>';
    
                $html .= '<br>
    
                    <a
                        onclick="reset(' . $siswa->id . ')"
                        style="width:80px;"
                        class="btn btn-success btn-xs">
    
                        <i class="glyphicon glyphicon-refresh"></i>
                        Reset
    
                    </a>';
    
                if ($siswa->is_login == 1) {
    
                    $html .= '<br>
    
                        <a
                            onclick="logoutData(' . $siswa->id . ')"
                            style="width:80px;margin-top:5px;"
                            class="btn btn-warning btn-xs">
    
                            <i class="glyphicon glyphicon-off"></i>
                            Logout
    
                        </a>';
    
                }
                
                 $html .= '<br>
    
                <a
                    onclick="resetSession(' . $siswa->id . ')"
                    style="width:80px;margin-top:5px;"
                    class="btn btn-danger btn-xs">
                    Clear Session

                </a>';
    
                $html .= '</center>';
    
                return $html;
    
            })
    
    
            /*
            |--------------------------------------------------------------------------
            | RAW HTML
            |--------------------------------------------------------------------------
            */
    
            ->rawColumns([
                'is_active',
                'school_id',
                'created_at',
                'id_kelas',
                'profile_image',
                'action',
                'name',
                'last_action'
            ])
    
    
            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */
    
            ->filterColumn('id_kelas', function ($query, $keyword) {
    
                $query->whereHas('kelas', function ($q) use ($keyword) {
    
                    $q->where(
                        'nama_kelas',
                        'like',
                        '%' . $keyword . '%'
                    );
    
                });
    
            })
    
    
            ->filterColumn('school_id', function ($query, $keyword) {
    
                $query->whereHas('school', function ($q) use ($keyword) {
    
                    $q->where(
                        'school_name',
                        'like',
                        '%' . $keyword . '%'
                    );
    
                });
    
            })
    
    
            ->filterColumn('is_active', function ($query, $keyword) {
    
                if (
                    str_contains(
                        strtolower($keyword),
                        'active'
                    )
                ) {
    
                    $query->where(
                        'is_active',
                        1
                    );
    
                } elseif (
                    str_contains(
                        strtolower($keyword),
                        'inactive'
                    )
                ) {
    
                    $query->where(
                        'is_active',
                        0
                    );
    
                }
    
            })
    
    
            ->filterColumn('name', function ($query, $keyword) {
    
                $query->where(
                    'name',
                    'like',
                    '%' . $keyword . '%'
                );
    
            })
    
    
            ->filterColumn('last_action', function ($query, $keyword) {
    
                $query->whereDate(
                    'last_activity',
                    'like',
                    '%' . $keyword . '%'
                );
    
            })
    
    
            ->filterColumn('created_at', function ($query, $keyword) {
    
                $query->whereDate(
                    'created_at',
                    'like',
                    '%' . $keyword . '%'
                );
    
            })
    
    
            /*
            |--------------------------------------------------------------------------
            | ORDERING
            |--------------------------------------------------------------------------
            */
    
            ->orderColumn('id_kelas', function ($query, $order) {
    
                $query
                    ->join(
                        'kelas',
                        'users.id_kelas',
                        '=',
                        'kelas.id'
                    )
                    ->orderBy(
                        'kelas.nama_kelas',
                        $order
                    );
    
            })
    
    
            ->orderColumn('school_id', function ($query, $order) {
    
                $query
                    ->join(
                        'schools',
                        'users.school_id',
                        '=',
                        'schools.id'
                    )
                    ->orderBy(
                        'schools.school_name',
                        $order
                    );
    
            })
    
    
            ->orderColumn('is_active', function ($query, $order) {
    
                $query->orderBy(
                    'is_active',
                    $order
                );
    
            })
    
    
            ->orderColumn('name', function ($query, $order) {
    
                $query->orderBy(
                    'name',
                    $order
                );
    
            })
    
    
            ->orderColumn('last_action', function ($query, $order) {
    
                $query->orderBy(
                    'last_activity',
                    $order
                );
    
            })
    
    
            ->orderColumn('created_at', function ($query, $order) {
    
                $query->orderBy(
                    'created_at',
                    $order
                );
    
            })
    
    
            ->make(true);
    }
    
    public function contactList($id) 
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'contact';
        $ids = $id;
        return view('siswa.contact', compact('view', 'ids'));
    }
    
    
    public function contactTable($id)
    {
        $contact = \App\Contact::where('id_user', $id)->get();
        return Datatables::of($contact)
        ->addColumn('phone_number', function($contact){
            return '<div>'.$contact->phone_number.'</div>';
        })      
        ->rawColumns(['phone_number'])
        ->make(true);
    
    }
    
    
    public function logoutUser($id) {
        $user = User::findorFail($id);
        $user->is_login = 0;
        $user->save();
        return response()->json(['success'=> true]);
        
    }
    
    
    public function resetPassword($id) {
        $user = User::findorFail($id);
        $user->password = bcrypt(1234);
        $user->save();
        
        return $user;
    }
    
    public function siswaActivate(Request $request) {
        $input = $request->all();
        $user = User::find($input['id']);
        $user->is_active = 1;
        $user->save();
        
        return response()->json([
            "success" => true
        ]);
    }
    
    
    public function siswaDeactivate(Request $request) {
        $input = $request->all();
        $user = User::find($input['id']);
        $user->is_active = 0;
        $user->save();
        
        return response()->json([
            "success" => true
        ]);
    }
    
    
    public function siswaSessionDelete(Request $request)
    {
        $input = $request->all();
        
        $id = $input['id'];
        $type = $input['tipe'];
        
        if($type == 'kompetensi_dasar') {
            QuizSession::where('user_id', $id)->delete();
            QuizAnswer::where('id_user', $id)->delete();
        }
        
        
        else if($type == 'quiz') {
            TryoutSession::where('id_user', $id)->delete();
            TryoutAnswer::where('id_user', $id)->delete();
        }
        
        else if($type == 'bank_soal') {
            BankSoalSession::where('id_user', $id)->delete();
            BankSoalAnswer::where('id_user', $id)->delete();
        }
        
        
        return response()->json(true);
        
        
    }
    
    
}
