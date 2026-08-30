<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TryOut extends Model
{
    protected $table = 'try_outs';
    protected $guarded = ['id'];
    
    
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function session():HasMany
    {
        return $this->hasMany(TryoutSession::class, 'id_tryout', 'id');
    }
    
}
