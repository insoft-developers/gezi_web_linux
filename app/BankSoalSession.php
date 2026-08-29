<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankSoalSession extends Model
{
    protected $fillable = ['id_bank_soal', 'id_user']; 
    
    
    public function bank_soal_answers():HasMany
    {
        return $this->hasMany(BankSoalAnswer::class, 'id_session', 'id');
    }
    
    
    public function users():BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    
    public function bank_soal():BelongsTo
    {
        return $this->belongsTo(BankSoal::class, 'id_bank_soal', 'id');    
    }
}
