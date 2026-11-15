<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentVideoActivity;
use App\StudentPdfActivity;
use App\Bimbingan;
use App\TobkVideo;
use App\MateriPembelajaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class StudentActivityController extends Controller
{
    /**
     * Mencatat aktivitas membuka video Bimbingan atau TOBK.
     */
    public function recordVideo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_type' => 'required|in:bimbingan,tobk',
            'video_id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $videoExists = $request->video_type == 'bimbingan'
            ? Bimbingan::where('id', $request->video_id)->exists()
            : TobkVideo::where('id', $request->video_id)->exists();

        if (!$videoExists) {
            return response()->json([
                'success' => false,
                'message' => 'Video tidak ditemukan',
            ], 404);
        }

        $student = $request->user();
        $now = Carbon::now();

        $activity = StudentVideoActivity::firstOrCreate(
            [
                'student_id' => $student->id,
                'video_type' => $request->video_type,
                'video_id' => $request->video_id,
            ],
            [
                'watch_count' => 0,
            ]
        );

        $activity->increment('watch_count');

        $activity->last_watched_at = $now;
        $activity->save();

        return response()->json([
            'success' => true,
            'message' => 'Aktivitas video berhasil dicatat',
            'data' => [
                'video_type' => $activity->video_type,
                'video_id' => $activity->video_id,
                'watch_count' => $activity->watch_count,
                'last_watched_at' => $activity->last_watched_at,
            ],
        ]);
    }

    /**
     * Mencatat aktivitas membuka materi PDF.
     */
    public function recordPdf(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pdf_id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $pdfExists = MateriPembelajaran::where('id', $request->pdf_id)
            ->where('is_active', 1)
            ->exists();

        if (!$pdfExists) {
            return response()->json([
                'success' => false,
                'message' => 'Materi PDF tidak ditemukan atau tidak aktif',
            ], 404);
        }

        $student = $request->user();
        $now = Carbon::now();

        $activity = StudentPdfActivity::firstOrCreate(
            [
                'student_id' => $student->id,
                'pdf_id' => $request->pdf_id,
            ],
            [
                'open_count' => 0,
                'first_opened_at' => $now,
            ]
        );

        $activity->increment('open_count');

        $activity->last_opened_at = $now;
        $activity->save();

        return response()->json([
            'success' => true,
            'message' => 'Aktivitas PDF berhasil dicatat',
            'data' => [
                'pdf_id' => $activity->pdf_id,
                'open_count' => $activity->open_count,
                'first_opened_at' => $activity->first_opened_at,
                'last_opened_at' => $activity->last_opened_at,
            ],
        ]);
    }
}
