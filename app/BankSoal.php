<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankSoal extends Model
{
    protected $guarded = ['id']; 

    public function session():HasMany
    {
        return $this->hasMany(BankSoalSession::class, 'id_bank_soal', 'id');
    }
}
