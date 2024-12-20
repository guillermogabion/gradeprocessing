<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\FinalAssessmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\StudentAssessmentController;
use App\Http\Controllers\StudentClassroomController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectController;
use App\Models\FinalAssessment;
use Illuminate\Http\Request;


Route::post('/register_web', [UsersController::class, 'register'])->name('register_web');

Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : redirect()->route('login');
});



Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    // users 
    Route::get('/users', [UsersController::class, 'index'])->name('organizations-users');
    Route::post('/user_add', [UsersController::class, 'register'])->name('user-add');
    Route::post('/user_update', [UsersController::class, 'update'])->name('user-update');
    Route::post('/users/{id}/status', [UsersController::class, 'updateStatus'])->name('users.updateStatus');


    // subject 
    Route::get('/subject', [SubjectController::class, 'index'])->name('organizations-subject');
    Route::post('/subject_add', [SubjectController::class, 'store'])->name('subject-add');
    Route::post('/subject_update', [SubjectController::class, 'update'])->name('subject-update');


    // class 
    Route::get('/class', [ClassroomController::class, 'index'])->name('organizations-classrooms');
    Route::post('/class_add', [ClassroomController::class, 'store'])->name('class-add');
    Route::post('/class_update', [ClassroomController::class, 'update'])->name('class-update');
    Route::post('/class/{id}/status', [ClassroomController::class, 'updateStatus'])->name('class.updateStatus');


    // students 
    Route::get('/admin-students', [StudentsController::class, 'admin_index'])->name('organizations-admin-students');
    Route::get('class/{classId}/students', [StudentsController::class, 'index'])->name('students');
    Route::post('/student_add', [StudentsController::class, 'register'])->name('student-add');
    Route::post('/student_update', [StudentsController::class, 'update'])->name('student-update');


    // classroom_student 
    Route::get('studentclass_add', [StudentClassroomController::class, 'store'])->name('studentclass_add');
    Route::post('/student_adds', [StudentClassroomController::class, 'adds'])->name('student-adds');
    Route::post('/student/{id}/status', [StudentClassroomController::class, 'updateStatusWeb'])->name('student_classroom.updateStatus');



    // assessments 
    Route::get('class/{classId}/students/{studentId}', [StudentAssessmentController::class, 'index'])->name('assessments');
    Route::post('assessment_add', [StudentAssessmentController::class, 'storeAssessmentDetails'])->name('assessment_add');
    Route::post('assessment_update', [StudentAssessmentController::class, 'update'])->name('assessment_update');
    // profile 
    Route::get('/details', [DetailsController::class, 'index'])->name('details');
    Route::post('/details-store', [DetailsController::class, 'store'])->name('details-store');


    // organization 
    Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations');
    Route::post('/organizations_add', [OrganizationController::class, 'store'])->name('organizations-add');
    Route::post('/organizations_update', [OrganizationController::class, 'update'])->name('organizations-update');
    Route::post('/organizations/{id}/status', [OrganizationController::class, 'updateStatus'])->name('organizations.updateStatus');


    // position 
    Route::get('/positions', [PositionsController::class, 'index'])->name('positions');
    Route::post('/position_add', [PositionsController::class, 'store'])->name('position-add');
    Route::post('/positions/{id}/status', [PositionsController::class, 'updateStatus'])->name('positions.updateStatus');


    //   rating 

    Route::get('/ratings', [FinalAssessmentController::class, 'index'])->name('organizations-rating');
});
