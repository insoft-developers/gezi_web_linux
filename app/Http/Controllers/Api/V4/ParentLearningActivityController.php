<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ParentLearningActivityController extends Controller
{
    private function isParentOfStudent($studentId)
    {
        $parent = auth('parent-api')->user();

        return $parent && $parent->children()
            ->where('users.id', $studentId)
            ->exists();
    }

    private function authorizeStudent($studentId)
    {
        if (!$this->isParentOfStudent($studentId)) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        return null;
    }

    private function applyMonthFilter($query, $column, Request $request)
    {
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth($column, $request->month)
                ->whereYear($column, $request->year);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween($column, [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }

        return $query;
    }

    private function paginateCollection($collection, Request $request)
    {
        $perPage = min(
            max((int) $request->get('per_page', 15), 1),
            100
        );

        $page = max((int) $request->get('page', 1), 1);

        $total = $collection->count();

        $items = $collection
            ->slice(($page - 1) * $perPage, $perPage)
            ->values();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );
    }

    /**
     * GET: Ringkasan aktivitas video dan PDF
     */
    public function summary(Request $request, $studentId)
    {
        if ($response = $this->authorizeStudent($studentId)) {
            return $response;
        }

        $videoQuery = DB::table('student_video_activities')
            ->where('student_id', $studentId);

        $this->applyMonthFilter(
            $videoQuery,
            'last_watched_at',
            $request
        );

        $videoSummary = $videoQuery->selectRaw("
            COUNT(*) as total_video,
            COALESCE(SUM(watch_count), 0) as total_tontonan
        ")->first();

        $pdfQuery = DB::table('student_pdf_activities')
            ->where('student_id', $studentId);

        $this->applyMonthFilter(
            $pdfQuery,
            'last_opened_at',
            $request
        );

        $pdfSummary = $pdfQuery->selectRaw("
            COUNT(*) as total_pdf,
            COALESCE(SUM(open_count), 0) as total_pembukaan
        ")->first();

        return response()->json([
            'success' => true,
            'message' => 'Ringkasan aktivitas berhasil diambil.',
            'data' => [
                'total_video' => (int) $videoSummary->total_video,
                'total_tontonan' => (int) $videoSummary->total_tontonan,
                'total_pdf' => (int) $pdfSummary->total_pdf,
                'total_pembukaan' => (int) $pdfSummary->total_pembukaan
            ]
        ]);
    }

    /**
     * GET: Riwayat aktivitas video
     *
     * video_type:
     * bimbingan
     * tobk
     */
    public function videos(Request $request, $studentId)
    {
        if ($response = $this->authorizeStudent($studentId)) {
            return $response;
        }

        $query = DB::table('student_video_activities')
            ->where('student_id', $studentId);

        if ($request->filled('video_type')) {
            $query->where('video_type', $request->video_type);
        }

        $this->applyMonthFilter(
            $query,
            'last_watched_at',
            $request
        );

        $activities = $query
            ->orderBy('last_watched_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $items = $activities->map(function ($activity) {
            $video = null;

            if ($activity->video_type === 'bimbingan') {
                $video = DB::table('bimbingans')
                    ->where('id', $activity->video_id)
                    ->select('id', 'judul', 'link_video')
                    ->first();
            } elseif ($activity->video_type === 'tobk') {
                $video = DB::table('tobk_videos')
                    ->where('id', $activity->video_id)
                    ->select('id', 'judul', 'link_video')
                    ->first();
            }

            return [
                'id' => $activity->id,
                'video_type' => $activity->video_type,
                'video_id' => $activity->video_id,
                'judul' => $video ? $video->judul : 'Video tidak ditemukan',
                'link_video' => $video ? $video->link_video : null,
                'watch_count' => (int) $activity->watch_count,
                'last_watched_at' => $activity->last_watched_at,
                'created_at' => $activity->created_at
            ];
        });

        $data = $this->paginateCollection($items, $request);

        return response()->json([
            'success' => true,
            'message' => 'Aktivitas video berhasil diambil.',
            'data' => $data
        ]);
    }

    /**
     * GET: Riwayat aktivitas PDF
     */
    public function pdfs(Request $request, $studentId)
    {
        if ($response = $this->authorizeStudent($studentId)) {
            return $response;
        }

        $query = DB::table('student_pdf_activities')
            ->leftJoin(
                'materi_pelajaran',
                'student_pdf_activities.pdf_id',
                '=',
                'materi_pelajaran.id'
            )
            ->where('student_pdf_activities.student_id', $studentId);

        $this->applyMonthFilter(
            $query,
            'student_pdf_activities.last_opened_at',
            $request
        );

        $items = $query
            ->select(
                'student_pdf_activities.id',
                'student_pdf_activities.pdf_id',
                'student_pdf_activities.open_count',
                'student_pdf_activities.first_opened_at',
                'student_pdf_activities.last_opened_at',
                'materi_pelajaran.judul',
                'materi_pelajaran.link_file'
            )
            ->orderBy(
                'student_pdf_activities.last_opened_at',
                'desc'
            )
            ->orderBy('student_pdf_activities.id', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'pdf_id' => $item->pdf_id,
                    'judul' => $item->judul ?: 'Materi tidak ditemukan',
                    'link_file' => $item->link_file,
                    'open_count' => (int) $item->open_count,
                    'first_opened_at' => $item->first_opened_at,
                    'last_opened_at' => $item->last_opened_at
                ];
            });

        $data = $this->paginateCollection($items, $request);

        return response()->json([
            'success' => true,
            'message' => 'Aktivitas PDF berhasil diambil.',
            'data' => $data
        ]);
    }
}
