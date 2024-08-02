<?php

namespace App\Http\Controllers;

use App\Models\Course;

class TimetableController extends Controller
{
    public function index($courseId)
    {
        $course = Course::find($courseId);
        $timetables = $course->timetables;
        return view('timetable.index', compact('timetables', 'course'));
    }
}
