<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    //

    public function index(Request $request)
    {
        $search = $request->input('search');
        $table_header = [
            'Class ID',
            'Subject',
            'Instructor',
            'Day',
            'Time',
            'Duration',
            'Action'
        ];
        $table_header_teacher = [
            'Class ID',
            'Subject Name',
            'Day',
            'Time',
            'Duration',
            'Status',
            'Action',
            'Active'
        ];

        $items = Classroom::when($search, function ($query, $search) {
            return $query->where('classId', 'like', '%' . $search . '%')
                ->orWhereHas('user_id', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        })->with('user')
            ->orderByRaw("status = 'active' DESC")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $room = Classroom::get();
        $all_subject = Subject::get();
        $user = Classroom::find(auth()->user()->id);

        return view('pages.class', [
            'all_class' => $room,
            'my_class' => $user,
            'headers' => $table_header,
            'headers_teacher' => $table_header_teacher,
            'items' => $items,
            'search' => $search,
            'all_subject' => $all_subject,
        ]);
    }

    public function showAll()
    {
        $class = Classroom::where('class_instructor_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json([
            'class' => $class,
        ], 200);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'class_days' => 'required|string',
            'class_time' => 'required|string',
            'duration' => 'nullable|string|max:255',
            'subject_id' => 'nullable|string|max:255',
        ]);

        $existingClassroom = Classroom::where('class_days', $validatedData['class_days'])
            ->where('class_time', $validatedData['class_time'])
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($existingClassroom) {
            return response()->json([
                'message' => 'A classroom with the same schedule and subject already exists.',
                'data' => $existingClassroom,
            ], 409);
        }

        $classroom = new Classroom();
        $classroom->classId = $this->generateUniqueClassId();
        $classroom->class_days = $validatedData['class_days'];
        $classroom->class_time = $validatedData['class_time'];
        $classroom->user_id = auth()->user()->id;
        $classroom->duration = $validatedData['duration'];
        $classroom->subject_id = $validatedData['subject_id'];

        $classroom->save();

        return response()->json([
            'message' => 'Classroom created successfully!',
            'data' => $classroom,
        ], 201);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'class_days' => 'required|string',
            'class_time' => 'required|string',
            'duration' => 'nullable|string|max:255',
        ]);

        // Find the classroom by ID
        $classroom = Classroom::find($request->id);

        if (!$classroom) {
            return response()->json([
                'message' => 'Classroom not found.',
            ], 404);
        }

        $existingClassroom = Classroom::where('class_days', $validatedData['class_days'])
            ->where('class_time', $validatedData['class_time'])
            ->where('user_id', auth()->user()->id)
            ->where('id', '!=', $request->id)
            ->first();

        if ($existingClassroom) {
            return response()->json([
                'message' => 'A classroom with the same schedule and subject already exists.',
                'data' => $existingClassroom,
            ], 409);
        }

        $classroom->class_days = $validatedData['class_days'];
        $classroom->class_time = $validatedData['class_time'];
        $classroom->duration = $validatedData['duration'];

        $classroom->save();

        return response()->json([
            'message' => 'Classroom updated successfully!',
            'data' => $classroom,
        ], 200); // 200 OK status code
    }



    private function generateUniqueClassId()
    {
        $letters = Str::random(6); // Generates 6 random letters
        $numbers = str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT); // Generates 9 random numbers

        return $letters . $numbers;
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string|in:active,inactive',
        ]);

        $user = Classroom::findOrFail($request->id);
        $user->status = $request->input('status');
        $user->save();

        return redirect()->route('organizations-classrooms')->with('success', 'Class status updated successfully');
    }
}
