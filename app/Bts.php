<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bts extends Model
{
    protected $guarded = ['id'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }

    public function hostMasuk(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_masuk', 'id');
    }

    public function hostPulang(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_pulang', 'id');
    }
}
