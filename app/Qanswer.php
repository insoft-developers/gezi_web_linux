<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qanswer extends Model
{
    protected $fillable = [
      "id_guru",
      "id_soal",
      "jawaban",
      "jawaban_gambar",
      "status"
    ];
}
