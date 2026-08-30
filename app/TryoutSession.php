<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TryoutSession extends Model
{
    protected $guarded = ['id'];
    
    public function tryout_answers()
    {
        return $this->hasMany(TryoutAnswer::class, 'id_session', 'id');
    }
    
    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    
    public function tryout()
    {
        return $this->belongsTo(TryOut::class, 'id_tryout', 'id');    
    }
}
