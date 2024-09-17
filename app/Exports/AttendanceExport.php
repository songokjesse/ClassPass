<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, ShouldAutoSize,WithHeadings
{
    private $timetableId;

    public function __construct($timetableId)
    {
        $this->timetableId = $timetableId;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $attendances = Attendance::whereHas('timetable', function ($query) {
            $query->where('id', $this->timetableId);
        })->get();
        $counter = 1;
        return $attendances->map(function ($attendance) use ($counter) {
            $student = $attendance->student;
            $user = $student->user;

            return [
                'No' => $counter++,
                'Name' => $user->name,
                'Email' => $user->email,
                'Admission Number' => $student->admission_no,
                'Location' => $attendance->timetable->location_name,
                'Attendance Date' => $attendance->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Email',
            'Admission Number',
            'Location',
            'Attendance Date',
        ];
    }
}
