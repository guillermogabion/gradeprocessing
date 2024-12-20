<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profile',
        'name',
        'role',
        'password',
        'userId',
        'status',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function position()
    {
        return $this->belongsTo(Positions::class, 'id', 'user_id');
    }
    public function candidates()
    {
        return $this->belongsTo(Candidate::class, 'id', 'user_id');
    }
    public function user_classroom()
    {
        return $this->hasMany(StudentClassroom::class, 'user_id', 'id');
    }

    public function details()
    {
        return $this->hasOne(Details::class, 'user_id');
    }
}
