<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_id',
        'quarter',
        'total_score'
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'id');
    }

    public function classrooms()
    {
        return $this->belongsTo(Classroom::class, 'class_id', 'id');
    }
   
}
