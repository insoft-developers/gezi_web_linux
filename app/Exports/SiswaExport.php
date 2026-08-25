<?php

namespace App\Exports;

use App\User;
use App\Location;
use App\Kelas;
use App\School;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;

        /*
        |--------------------------------------------------------------------------
        | 1. QUERY SISWA
        |--------------------------------------------------------------------------
        */

        $siswaQuery = User::with([
            'location',
            'kelas',
            'school'
        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. FILTER LOKASI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('location_id')) {
            $siswaQuery->where(
                'location_id',
                $request->location_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 3. FILTER KELAS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('id_kelas')) {
            $siswaQuery->where(
                'id_kelas',
                $request->id_kelas
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 4. FILTER GROUP KELAS
        |--------------------------------------------------------------------------
        |
        | class_group adalah kolom langsung di users
        |
        */

        if ($request->filled('class_group')) {
            $siswaQuery->where(
                'class_group',
                $request->class_group
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 5. FILTER SEKOLAH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('school_id')) {
            $siswaQuery->where(
                'school_id',
                $request->school_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 6. FILTER TANGGAL MULAI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_start')) {

            $siswaQuery->where(
                'created_at',
                '>=',
                $request->date_start . ' 00:00:00'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | 7. FILTER TANGGAL AKHIR
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_end')) {

            $siswaQuery->where(
                'created_at',
                '<=',
                $request->date_end . ' 23:59:59'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | 8. AMBIL USER ID YANG SUDAH DIFILTER
        |--------------------------------------------------------------------------
        */

        $filteredUserIds = (clone $siswaQuery)
            ->select('users.id');


        /*
        |--------------------------------------------------------------------------
        | 9. QUIZ SCORE
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | 10. BANK SOAL SCORE
        |--------------------------------------------------------------------------
        */

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
        | 11. AMBIL DATA SISWA
        |--------------------------------------------------------------------------
        */

        $siswa = $siswaQuery
            ->orderBy('created_at', 'desc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | 12. NAMA FILTER UNTUK DITAMPILKAN DI EXCEL
        |--------------------------------------------------------------------------
        */

        $filterLocation = 'Semua Lokasi';

        if ($request->filled('location_id')) {

            $location = Location::find(
                $request->location_id
            );

            $filterLocation = $location
                ? $location->name
                : '-';
        }


        $filterKelas = 'Semua Kelas';

        if ($request->filled('id_kelas')) {

            $kelas = Kelas::find(
                $request->id_kelas
            );

            $filterKelas = $kelas
                ? $kelas->nama_kelas
                : '-';
        }


        $filterClassGroup = 'Semua Group Kelas';

        if ($request->filled('class_group')) {

            $filterClassGroup =
                $request->class_group;
        }


        $filterSchool = 'Semua Sekolah';

        if ($request->filled('school_id')) {

            $school = School::find(
                $request->school_id
            );

            $filterSchool = $school
                ? $school->school_name
                : '-';
        }


        $filterDate = 'Semua Tanggal';

        if (
            $request->filled('date_start') &&
            $request->filled('date_end')
        ) {

            $filterDate =
                date(
                    'd-m-Y',
                    strtotime($request->date_start)
                )
                . ' s/d ' .
                date(
                    'd-m-Y',
                    strtotime($request->date_end)
                );

        } elseif ($request->filled('date_start')) {

            $filterDate =
                'Mulai ' .
                date(
                    'd-m-Y',
                    strtotime($request->date_start)
                );

        } elseif ($request->filled('date_end')) {

            $filterDate =
                'Sampai ' .
                date(
                    'd-m-Y',
                    strtotime($request->date_end)
                );
        }


        /*
        |--------------------------------------------------------------------------
        | 13. KIRIM KE VIEW EXCEL
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.export.siswa',
            compact(
                'siswa',
                'quizScores',
                'bankScores',
                'filterLocation',
                'filterKelas',
                'filterClassGroup',
                'filterSchool',
                'filterDate'
            )
        );
    }
}