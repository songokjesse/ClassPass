<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\TimetableController;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
});

Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
])->group(function () {
    Route::get("/dashboard", function () {
        $courses = Course::where("user_id", Auth::id())->get();
        return view("dashboard", compact("courses"));
    })->name("dashboard");

    Route::resource('courses', CourseController::class);
    Route::get('/courses/{courseId}/timetables', [TimetableController::class, "index"])->name("timetable.index");
});
