<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index($course_id){
        $course = Course::find($course_id);
        $attendances = $course->attendances;
        return view('attendance.index', compact('course', 'attendances'));
    }
}
