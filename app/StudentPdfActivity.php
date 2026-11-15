<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPdfActivity extends Model
{
    protected $table = 'student_pdf_activities';

    protected $fillable = [
        'student_id',
        'pdf_id',
        'open_count',
        'first_opened_at',
        'last_opened_at',
    ];
}