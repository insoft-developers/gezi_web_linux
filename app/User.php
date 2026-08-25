<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','id_kelas','school_id','profile_image','is_active','location_id', 'is_qrcode'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function kelas() {
        return $this->belongsTo('App\Kelas', 'id_kelas');
    }
    
    public function school() {
        return $this->belongsTo('App\School', 'school_id', 'id');
    }
    
    
    public function location() {
        return $this->belongsTo('App\Location', 'location_id', 'id');
    }
    
    public function quizSessions()
    {
        return $this->hasMany(QuizSession::class, 'user_id', 'id');
    }
    
    public function bankSoalSessions()
    {
        return $this->hasMany(BankSoalSession::class, 'id_user', 'id');
    }


}
