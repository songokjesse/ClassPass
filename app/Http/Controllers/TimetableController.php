<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimetableRequest;
use App\Models\Course;
use App\Models\Timetable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

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
        $timetable = new Timetable($request->validated());
        $timetable->course_id = $request->course_id;
        $timetable->save();
        return redirect()->route('timetable.index', $request->course_id)
            ->with('success', 'Lesson Time added successfully.');

    }
}
