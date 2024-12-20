<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use App\Models\StudentClassroom;

class StudentsController extends Controller
{
    //
    public function admin_index(Request $request)
    {
        $search = $request->input('search');
        $table_header = [
            'Student ID',
            'Full Name',
            'Address',
            'Birth Date',
            'Status',
            'Action'
        ];

        $items = Students::when($search, function ($query, $search) {
            return $query
                ->where('studentId', 'like', '%' . $search . '%')
                ->orWhere('fullname', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%');
        })->with('class')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // $user = Students::find(auth()->user()->id);

        // return view('pages.student', [
        //     'test' => $user,
        //     'headers' => $table_header,
        //     'items' => $items,
        //     'search' => $search
        // ]);

        return view('pages.admin_student', compact('table_header', 'items', 'search'));
    }
    public function index(Request $request, $classId)
    {
        $search = $request->input('search');
        $table_header = [
            'Student ID',
            'Full Name',
            'Address',
            'Birth Date',
            'Status',
            'Action'
        ];

        $items = StudentClassroom::where('classroom_id', $classId)->with('student', 'classrooms')->when($search, function ($query, $search) {
            $query->whereHas('student', function ($query) use ($search) {
                $query->where('fullname', 'like', '%' . $search . '%')
                    // ->orWhere('studentId', 'like', '%' . $search . '%')
                    ->orWhere('fullname', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $user = Students::find(auth()->user()->id);
        $all = Students::where('status', 'active')->get();

        // return view('pages.student', [
        //     'test' => $user,
        //     'headers' => $table_header,
        //     'items' => $items,
        //     'search' => $search
        // ]);

        return view('pages.student', compact('user', 'table_header', 'items', 'search', 'classId', 'all'));
    }

    public function final_assessment(Request $request, $classId)
    {
        $search = $request->input('search');
        $table_header = [
            'Student ID',
            'Full Name',
            'Address',
            'Birth Date',
            'Status',
            'Action'
        ];

        $items = StudentClassroom::where('classroom_id', $classId)->with('student', 'classrooms')->when($search, function ($query, $search) {
            $query->whereHas('student', function ($query) use ($search) {
                $query->where('fullname', 'like', '%' . $search . '%')
                    // ->orWhere('studentId', 'like', '%' . $search . '%')
                    ->orWhere('fullname', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            })
                ->$query->whereHas('classrooms', function ($query) use ($search) {
                    $query->where('status', 'like', 'active');
                });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $user = Students::find(auth()->user()->id);
        $all = Students::where('status', 'active')->get();

        // return view('pages.student', [
        //     'test' => $user,
        //     'headers' => $table_header,
        //     'items' => $items,
        //     'search' => $search
        // ]);

        return view('pages.student', compact('user', 'table_header', 'items', 'search', 'classId', 'all'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'studentId' => 'required|string|max:255',
            'birthdate' => 'required|string|max:255',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $existingStudent = Students::where('studentId', $request->input('studentId'))->first();

        if ($existingStudent) {
            return redirect()->back()->with('error', 'Student with this ID already exists.');
        }


        $student = new Students();
        $student->studentId = $request->input('studentId');
        $student->fullname = $request->input('fullname');
        $student->address = $request->input('address');
        $student->birthdate = $request->input('birthdate');

        if ($request->hasFile('profilePicture')) {
            $imageName = time() . '.' . $request->profilePicture->extension();
            $request->profilePicture->move(public_path('student'), $imageName);
            $student->profile = $imageName;
        }

        $student->save();

        return redirect()->route('organizations-admin-students')->with('success', 'Registration successful. Please login.');
    }
    public function update(Request $request)
    {
        // Validate the input data, including the image if provided
        $request->validate([
            'fullname' => 'required|string|max:255',
            'studentId' => 'required|string|max:255',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the user by ID
        $item = Students::findOrFail($request->id);

        // If a profile picture is uploaded, store it and update the user's profile picture field
        if ($request->hasFile('profilePicture')) {
            $imageName = time() . '.' . $request->profilePicture->extension();
            $request->profilePicture->move(public_path('student'), $imageName);
            $item->profile = $imageName;
        }

        // Update the user's other fields
        $item->fill($request->except('profilePicture')); // Exclude profilePicture from fill()

        // Save the updated user
        $item->save();

        // Redirect with a success message
        return redirect()->route('organizations-users')->with('success', 'User updated successfully');
    }
}
