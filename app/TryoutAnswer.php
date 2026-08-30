<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TryoutAnswer extends Model
{
    protected $guarded = ['id'];

    public function soal():BelongsTo
    {
        return $this->belongsTo(TryoutDetail::class, 'id_soal', 'id');
    }
}
