<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Timetable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index($timetable_id): Application|Factory|View
    {
        $attendances = Attendance::where('timetable_id', $timetable_id)->get();
        $timetable= Timetable::with('course')->find($timetable_id);;
        return view('attendance.index', compact('timetable','attendances'));
    }
}
