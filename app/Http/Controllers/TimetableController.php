<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimetableRequest;
use App\Models\Course;
use App\Models\Timetable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class TimetableController extends Controller
{
    public function index($courseId): View|Factory|Application
    {
        $course = Course::find($courseId);
        $timetables = $course->timetables;
        return view('timetable.index', compact('timetables', 'course'));
    }
    public function create($courseId): View|Factory|Application
    {
        $course = Course::find($courseId);
        return view('timetable.create', compact('course'));
    }
    public function store(StoreTimetableRequest $request): RedirectResponse
    {
        $timezone = 'Africa/Nairobi';
        $date = $request->date;
        $startDateTime = Carbon::parse($date . ' ' . $request->start_time, $timezone);
        $endDateTime = Carbon::parse($date . ' ' . $request->end_time, $timezone);

        // Convert to UTC for storage
        $startDateTimeUTC = $startDateTime->utc();
        $endDateTimeUTC = $endDateTime->utc();

        $timetable = new Timetable();
        $timetable->course_id = $request->course_id;
        $timetable->location_name = $request->location_name;
        $timetable->date = $startDateTimeUTC->toDateString(); // This will store the date in UTC
        $timetable->start_time = $startDateTimeUTC->toTimeString();
        $timetable->end_time = $endDateTimeUTC->toTimeString();
        $timetable->save();

        return redirect()->route('timetable.index', $request->course_id)
            ->with('success', 'Lesson Time added successfully.');

    }

    public function show(Timetable $lesson)
    {
        $timeRemaining = $lesson->time_remaining;
        dd($timeRemaining);
//        return view('lessons.show', compact('lesson', 'timeRemaining'));
    }
}
