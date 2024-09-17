<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\Timetable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttendanceController extends Controller
{
    public function index($timetable_id): Application|Factory|View
    {
        $attendances = Attendance::where('timetable_id', $timetable_id)->get();
        $timetable = Timetable::find($timetable_id);
        return view('attendance.index', compact('timetable', 'attendances'));
    }

    public function generateQRCode($timetable_id): Application|Factory|View
    {
        $timetable = Timetable::find($timetable_id);

        return view('qr-code.index', compact('timetable'));
    }

    public function create($timetable_id): Application|Factory|View
    {
        $attendance = Attendance::where('timetable_id', $timetable_id)->get();
        $timetable = Timetable::with('course')->find($timetable_id);
        return view('attendance.create', compact('timetable', 'attendance'));
    }

    public function downloadAttendees($timetableId): BinaryFileResponse
    {
        $timetable = Timetable::find($timetableId);
        $filename = $timetable->course->course_code."_".$timetable->course->course_name.'_'.$timetable->date.'_Attendees.xlsx';
        return Excel::download(new AttendanceExport($timetableId), $filename);
    }
}
