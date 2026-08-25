<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizes';
    
    protected $fillable = [
        "no_kuis",
        "id_quiz",
        "soal_kuis",
        "gambar_soal",
        "jawaban_a",
        "gambar_a",
        "jawaban_b",
        "gambar_b",
        "jawaban_c",
        "gambar_c",
        "jawaban_d",
        "gambar_d",
        "jawaban_e",
        "gambar_e",
        "kunci_jawaban",
        "id_kelas",
        "score"
        
    ];
    
    public function QuizAnswer() {
        return $this->belongsTo('App\QuizAnswer','id_soal');
    }
}
