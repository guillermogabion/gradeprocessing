<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'classId',
        'class_schedule',
        'class_instructor_id',
        'class_other',
        'subject_id'
    ];

    public function class_classroom()
    {
        return $this->hasMany(StudentClassroom::class, 'classroom_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
