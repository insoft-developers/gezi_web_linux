<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankSoalSession extends Model
{
    protected $fillable = ['id_bank_soal', 'id_user']; 
    
    
    public function bank_soal_answers()
    {
        return $this->hasMany(BankSoalAnswer::class, 'id_session', 'id');
    }
    
    
    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    
    public function bank_soal()
    {
        return $this->belongsTo(BankSoal::class, 'id_bank_soal', 'id');    
    }
}
