<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\studentAssessment;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentAssessmentController extends Controller
{
    //

    // public function index(Request $request)
    // {
    //     $search = $request->input('search');
    //     $table_header = [
    //         '',
    //         'User ID',
    //         'Full Name',
    //         'Role',
    //         'Status',
    //         'Action'
    //     ];

    //     $items = User::when($search, function ($query, $search) {
    //         return $query->where('name', 'like', '%' . $search . '%')
    //             ->orWhere('userId', 'like', '%' . $search . '%')
    //             ->orWhere('role', 'like', '%' . $search . '%')
    //             ->orWhere('status', 'like', '%' . $search . '%');
    //     })
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10);

    //     $user = User::find(auth()->user()->id);

    //     return view('pages.users', [
    //         'test' => $user,
    //         'headers' => $table_header,
    //         'items' => $items,
    //         'search' => $search
    //     ]);
    // }
    public function index(Request $request, $classId, $studentId)
    {
        $search = $request->input('search');
        $table_header = [
            'ID',
            'Assessment Type',
            'Quarter Period',
            'Score',
            'Maximum Score',
            'Execution Date',
            'Action'
        ];

        $items = studentAssessment::where('classroom_id', $classId)
            ->where('student_id', $studentId)
            ->with('student', 'classrooms')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $student = Students::where('id', $studentId)->first();
        $subject = Classroom::where('id', $classId)->get();

        // Task Totals and Max Scores for 'ww', 'pt', 'qa'
        $assessmentTypes = ['ww', 'pt', 'qa'];
        $assessmentTotals = [];
        $assessmentMaxTotals = [];

        foreach ($assessmentTypes as $type) {
            $totals = studentAssessment::where('student_id', $studentId)
                ->where('assessment_type', $type)
                ->select(
                    'classroom_id',
                    'student_id',
                    'quarter',
                    DB::raw('SUM(score) as total_score')
                )
                ->groupBy('classroom_id', 'student_id', 'quarter')
                ->get();

            $maxTotals = studentAssessment::where('student_id', $studentId)
                ->where('assessment_type', $type)
                ->select(
                    'classroom_id',
                    'student_id',
                    'quarter',
                    DB::raw('SUM(max_score) as total_max_score')
                )
                ->groupBy('classroom_id', 'student_id', 'quarter')
                ->get();

            $assessmentTotals[$type] = $totals;
            $assessmentMaxTotals[$type] = $maxTotals;
        }

        // Fetch subject percentages
        $taskPercentage = Classroom::with('subject')->find($classId);
        $writtenWorkValue = $taskPercentage->subject->ww ?? 0;
        $performanceTaskValue = $taskPercentage->subject->pt ?? 0;
        $quarterAssessmentValue = $taskPercentage->subject->qa ?? 0;

        // Calculate scores by quarter for each type
        $calculatedScoresByQuarter = [];
        foreach ($assessmentTypes as $type) {
            $totals = $assessmentTotals[$type];
            $maxTotals = $assessmentMaxTotals[$type];
            foreach ($totals as $total) {
                $maxTotal = $maxTotals->where('quarter', $total->quarter)->first();
                if ($maxTotal) {
                    $weight = ($type === 'ww') ? $writtenWorkValue : (($type === 'pt') ? $performanceTaskValue : $quarterAssessmentValue);
                    $calculatedScoresByQuarter[$type][$total->quarter] = ($total->total_score / $maxTotal->total_max_score) * ($weight / 100);
                }
            }
        }

        // Combine total scores for each quarter
        $totalCalculatedScoreByQuarter = [];
        foreach (array_keys($calculatedScoresByQuarter['ww'] ?? []) as $quarter) {
            $totalCalculatedScoreByQuarter[$quarter] =
                ($calculatedScoresByQuarter['ww'][$quarter] ?? 0) +
                ($calculatedScoresByQuarter['pt'][$quarter] ?? 0) +
                ($calculatedScoresByQuarter['qa'][$quarter] ?? 0);
        }

        // Dynamically Save or Update Final Assessments
        foreach ($totalCalculatedScoreByQuarter as $quarter => $totalScore) {
            // Directly update or insert without conditions
            DB::table('final_assessments')->updateOrInsert(
                [
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'quarter' => $quarter,
                ],
                [
                    'total_score' => $totalScore,
                    'updated_at' => now(),
                ]
            );
        }

        return view('pages.student_assessment', compact(
            'table_header',
            'items',
            'search',
            'student',
            'subject',
            'classId',
            'studentId',
            'totalCalculatedScoreByQuarter',
            'calculatedScoresByQuarter'
        ));
    }



    public function storeAssessmentDetails(Request $request)
    {
        // Log the incoming request data for debugging
        \Log::debug($request->all()); // This will log the incoming request data

        // Validate the input


        // Check if assessment_type exists and is an array
        if (!is_array($request->assessment_type) || count($request->assessment_type) === 0) {
            return response()->json(['message' => 'No assessment data provided.'], 400);
        }

        // Prepare data for insertion
        $data = [];
        foreach ($request->assessment_type as $key => $type) {
            $data[] = [
                'quarter' => $request->quarter[$key],
                'assessment_type' => $type,
                'score' => $request->score[$key],
                'max_score' => $request->max_score[$key],
                'date' => $request->date_executed[$key],
                'image' => $request->image[$key] ?? null,
                'student_id' => $request->studentId,
                'classroom_id' => $request->classId,

            ];
        }

        // Insert data into the database (assuming a table named 'assessments')
        studentAssessment::insert($data);

        return response()->json([
            'message' => 'Assessment details successfully saved.',
        ]);
    }

    public function update(Request $request)
    {


        // Find the assessment record by its ID
        $item = studentAssessment::findOrFail($request->id);

        // Update the item's fields with the validated data
        $item->assessment_type = $request->assessment_type;
        $item->score = $request->score;
        $item->max_score = $request->max_score;
        $item->date = $request->date;
        $item->quarter = $request->quarter;

        // If an image is provided, handle it here (optional)
        if ($request->hasFile('image')) {
            // Store the image and get the file path
            $imagePath = $request->file('image')->store('public/assessments');
            $item->image = $imagePath;  // Update the image field with the file path
        }

        // Save the updated record
        $item->save();

        // Return a success response or redirect
        // return redirect()->route('assessments')->with('success', 'Assessment Detail updated successfully');
    }
}
