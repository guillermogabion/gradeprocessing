<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\Details;
use App\Models\studentAssessment;
use App\Models\Students;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

    public function index(Request $request)
    {
        $profile = Details::find(auth()->user()->id);
        $students = Students::count();
        $users = User::count();
        $subject = Subject::count();
        $class = Classroom::where('status', 'active')->count();

        $studentsByYear = DB::table('students')
            ->select(
                DB::raw('YEAR(birthdate) as year'), // Group by the year of birth
                DB::raw('COUNT(*) as total_students') // Count the number of students per year
            )
            ->groupBy(DB::raw('YEAR(birthdate)'))
            ->orderBy(DB::raw('YEAR(birthdate)'))
            ->get();


        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $startOfMonth = Carbon::createFromDate($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // Fetch classrooms for the selected month and year
        $classrooms = Classroom::with('subject')
            ->where('status', 'active')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth]) // Assuming classes are scheduled within this period
            ->get();

        // Format the data to match calendar view (group by days)
        $classData = $classrooms->map(function ($classroom) {
            return [
                'classId' => $classroom->classId,
                'subject' => $classroom->subject->name,
                'classDays' => explode(',', $classroom->class_days), // splitting days into array
                'classTime' => $classroom->class_time,
                'duration' => $classroom->duration,
            ];
        });



        return view('pages.home', compact('year', 'month', 'profile', 'students', 'users', 'class', 'subject', 'studentsByYear', 'classData', 'startOfMonth', 'endOfMonth'));
    }
}
