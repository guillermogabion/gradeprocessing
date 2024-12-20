<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClassroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'classroom_id',
        'status'
    ];

    public function student()
    {
        return $this->hasMany(Students::class,  'id', 'student_id');
    }

    public function classrooms()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
