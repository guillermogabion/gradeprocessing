<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'student_id',
        'classroom_id',
        'assessment_type',
        'score',
        'max_score',
        'image',
        'date',
        'percentage'
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'id');
    }

    public function classrooms()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
