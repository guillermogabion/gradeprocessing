<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\StudentClassroom;

class StudentClassroomController extends Controller
{
    //

    // public function getStudents(Request $request)
    // {
    //     $students = StudentClassroom::where('classroom_id', $request->input('classroom_id'))->with('user_studentclassroom', 'classroom_studentclassroom')->get();
    //     return response()->json([
    //         'students' => $students,
    //     ], 201);
    // }

    // public function getMyRoom()
    // {
    //     $student = StudentClassroom::where('user_id', auth()->user()->id)->with('classroom_studentclassroom')->orderBy('created_at', 'desc')->get();

    //     return response()->json([
    //         'student' => $student,
    //     ], 200);
    // }

    public function adds(Request $request)
    {
        // Validate the input request
        $validatedData = $request->validate([
            'student_id' => 'required|integer|exists:students,id', // Check if the student exists
            'classroom_id' => 'required|integer|exists:classrooms,id', // Check if the classroom exists
        ]);

        try {
            // Check if the student is already enrolled in the specified class
            $isEnrolled = StudentClassroom::where([
                'student_id' => $validatedData['student_id'],
                'classroom_id' => $validatedData['classroom_id'],
            ])->exists();

            if ($isEnrolled) {
                // Return a conflict response if already enrolled
                return response()->json([
                    'status' => 'error',
                    'message' => 'This student is already enrolled in this class.',
                ], 409); // HTTP 409 Conflict
            }

            // Enroll the student in the class
            StudentClassroom::create([
                'student_id' => $validatedData['student_id'],
                'classroom_id' => $validatedData['classroom_id'],
            ]);

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Class enrollment submitted successfully!',
            ], 201); // HTTP 201 Created

        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
                'request' => $validatedData
            ], 500); // HTTP 500 Internal Server Error
        }
    }






    public function delete($id)
    {
        $students = Classroom::findOrFail($id)->delete();
        return response()->json([
            'message' => 'Class enrollment deleted successfully!',
            'students' => $students,
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:granted,declined,pending'
        ]);

        $students = StudentClassroom::findOrFail($id);

        if ($students->status === $request->input('status')) {
            return response()->json([
                'message' => 'No changes were made, the status is already ' . $students->status,
                'students' => $students,
            ], 200);
        }

        $students->status = $request->input('status');
        $students->save();

        return response()->json([
            'message' => 'Class enrollment updated successfully!',
            'students' => $students,
        ], 200);
    }

    public function updateStatusWeb(Request $request, $classId)
    {
        $request->validate([
            'status' => 'required|string|in:active,inactive',
        ]);

        $user = StudentClassroom::findOrFail($request->id);
        $user->status = $request->input('status');
        $user->save();

        return redirect()->route('students', ['classId' => $classId])->with('success', 'Student Class status updated successfully');
    }
}
