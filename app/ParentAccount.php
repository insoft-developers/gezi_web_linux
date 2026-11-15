<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class ParentAccount extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'parent_accounts';

    protected $fillable = [
        'name',
        'phone',
        'password',
        'school_id',
        'is_active',
        'must_change_password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'must_change_password' => 'boolean',
    ];

    public function children()
    {
        return $this->belongsToMany(
            User::class,
            'parent_student',
            'parent_id',
            'student_id'
        )->withPivot('relationship')
         ->withTimestamps();
    }
}
