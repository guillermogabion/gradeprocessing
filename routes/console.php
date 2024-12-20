<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


Artisan::command('add-admin-and-student', function () {
    $adminData = [
        'userId' => "admin123",
        'name' => "admin",
        'password' => "Password01!",
        'role' => "admin",

    ];
    $studentData = [
        'userId' => "student123",
        'name' => "super_admin",
        'password' => "Password01!",
        'role' => "super_admin",

    ];
    $teacherData = [
        'userId' => "teacher123",
        'name' => "teacher",
        'password' => "Password01!",
        'role' => "teacher",

    ];

    $users = [$adminData, $studentData, $teacherData];

    foreach ($users as $data) {
        if (User::where('userId', $data['userId'])->exists()) {
            $this->error("User with userId '{$data['userId']}' already exists. Skipping.");
            continue;
        }

        $user = new User();
        $user->userId = $data['userId'];
        $user->name = $data['name'];
        $user->role = $data['role'];
        $user->password = Hash::make($data['password']);

        if ($user->save()) {
            $this->info("{$data['userId']} added successfully.");
        } else {
            $this->error("Failed to add {$data['userId']}.");
        }
    }
})->purpose('Add Admin');
