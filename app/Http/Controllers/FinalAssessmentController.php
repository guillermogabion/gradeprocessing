<?php

namespace App\Http\Controllers;

use App\Models\FinalAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinalAssessmentController extends Controller
{
    //


    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = DB::table('final_assessments')
            ->join('students', 'final_assessments.student_id', '=', 'students.id')
            ->join('classrooms', 'final_assessments.class_id', '=', 'classrooms.id')
            ->join('subjects', 'classrooms.subject_id', '=', 'subjects.id') // Join the subjects table
            ->select(
                'students.fullname',
                'classrooms.classId as class_id',
                'subjects.name as subject', // Select subject name
                DB::raw("SUM(CASE WHEN final_assessments.quarter = '1st' THEN final_assessments.total_score ELSE '' END) as first_quarter"),
                DB::raw("SUM(CASE WHEN final_assessments.quarter = '2nd' THEN final_assessments.total_score ELSE '' END) as second_quarter"),
                DB::raw("SUM(CASE WHEN final_assessments.quarter = '3rd' THEN final_assessments.total_score ELSE '' END) as third_quarter"),
                DB::raw("SUM(CASE WHEN final_assessments.quarter = '4th' THEN final_assessments.total_score ELSE '' END) as fourth_quarter")
            )
            ->when($search, function ($query, $search) {
                $query->where('students.fullname', 'like', '%' . $search . '%')
                    ->orWhere('students.studentId', 'like', '%' . $search . '%')
                    ->orWhere('classrooms.classId', 'like', '%' . $search . '%');
            })
            ->groupBy('students.fullname', 'classrooms.classId', 'subjects.name')
            ->paginate(10);

        return view('pages.rating', compact('data', 'search'));
    }
}
