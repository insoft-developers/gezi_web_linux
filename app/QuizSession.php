<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
