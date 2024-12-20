<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //


    public function index(Request $request)
    {
        $search = $request->input('search');
        $table_header = [
            'ID',
            'Subject',
            'Written Work',
            'Performance Task',
            'Quarterly Assessment',
            'Action'
        ];


        $items = Subject::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $all = Subject::get();

        return view('pages.subject', compact(
            'table_header',
            'items',
            'search',
            'all'
        ));
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'ww' => 'required|string',
            'pt' => 'required|string',
            'qa' => 'required|string',
        ]);

        $existingSubject = Subject::where('name', $validatedData['name'])
            ->first();

        if ($existingSubject) {
            return response()->json([
                'message' => 'A subject already exists.',
                'data' => $existingSubject,
            ], 409);
        }

        $subject = new Subject();
        $subject->name = $validatedData['name'];
        $subject->ww = $validatedData['ww'];
        $subject->pt = $validatedData['pt'];
        $subject->qa = $validatedData['qa'];

        $subject->save();

        return response()->json([
            'message' => 'Subject created successfully!',
            'data' => $subject,
        ], 201);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'ww' => 'required|string',
            'pt' => 'required|string',
            'qa' => 'required|string',
        ]);

        // Find the classroom by ID
        $subject = Subject::find($request->id);

        if (!$subject) {
            return response()->json([
                'message' => 'Subject not found.',
            ], 404);
        }

        

        $subject->name = $validatedData['name'];
        $subject->ww = $validatedData['ww'];
        $subject->pt = $validatedData['pt'];
        $subject->qa = $validatedData['qa'];

        $subject->save();

        return response()->json([
            'message' => 'Subject updated successfully!',
            'data' => $subject,
        ], 200); // 200 OK status code
    }
}
