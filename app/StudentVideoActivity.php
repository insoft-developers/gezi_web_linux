<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentVideoActivity extends Model
{
    protected $table = 'student_video_activities';

    protected $fillable = [
        'student_id',
        'video_type',
        'video_id',
        'watch_count',
        'last_watched_at',
    ];
}