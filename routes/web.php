<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TimetableController;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use LaravelQRCode\Facades\QRCode;


Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
])->group(function () {
    Route::get("/", function () {
        $courses = Course::where("user_id", Auth::id())->get();
        return view("dashboard", compact("courses"));
    });

    Route::get("/dashboard", function () {
        $courses = Course::where("user_id", Auth::id())->get();
        return view("dashboard", compact("courses"));
    })->name("dashboard");

    Route::resource('courses', CourseController::class);
    Route::get('/courses/{courseId}/timetables', [TimetableController::class, "index"])->name("timetable.index");
    Route::get('/courses/{courseId}/timetables/create', [TimetableController::class, "create"])->name("timetable.create");
    Route::post('/timetables', [TimetableController::class, "store"])->name("timetable.store");
    Route::get('/attendance/{timetable_id}', [AttendanceController::class, "index"])->name("attendance.index");
    Route::post('/attendance/{timetable_id}', [AttendanceController::class, "store"])->name("attendance.store");
    Route::get('/qr-code/{timetable_id}', [AttendanceController::class, "generateQRCode"])->name("attendance.qr-code");
//    Route::get('/attendance/{timetable_id}/capture', [AttendanceController::class, "create"])->name("attendance.create");
});

Route::get('/attendance/{timetable_id}/capture', [AttendanceController::class, "create"])->name("attendance.create");
