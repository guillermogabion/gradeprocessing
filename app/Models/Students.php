<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $fillable = [
        'studentId',
        'fullname',
        'address',
        'birthdate',
        'profile',
        'status',
        'class_id'
    ];

    public function class()
    {
        return $this->belongsTo(Classroom::class, 'class_id', 'id');
    }
}
