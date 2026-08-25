<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = "kelas";
    protected $fillable =['nama_kelas','tingkat_id'];
    
    
    public function user() {
        return $this->hasMany('App\User', 'id_kelas');
    }
    
    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'tingkat_id', 'id');
    }
}
