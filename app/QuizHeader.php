<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizHeader extends Model
{
    protected $guarded = ['id'];


    public function session():HasMany
    {
        return $this->hasMany(QuizSession::class, 'id_quiz', 'id');
    }
}
