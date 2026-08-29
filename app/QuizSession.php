<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizSession extends Model
{
    
    
    public function quiz_answers()
    {
        return $this->hasMany(QuizAnswer::class, 'id_quiz', 'id');
    }
    
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function quiz():BelongsTo
    {
        return $this->belongsTo(QuizHeader::class, 'id_quiz', 'id');
    }
}
