<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Timetable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use LaravelQRCode\Facades\QRCode;

class AttendanceController extends Controller
{
    public function index($timetable_id): Application|Factory|View
    {
        $attendances = Attendance::where('timetable_id', $timetable_id)->get();
        $timetable= Timetable::find($timetable_id);
        return view('attendance.index', compact('timetable','attendances'));
    }

//    public function generateQRCode($timetable_id): Application|Factory|View
//    {
//        $timetable= Timetable::with('course')->find($timetable_id);;
//
//        $path = public_path().'/'.$timetable_id.'.png';
//        $qrCode = '/'.$timetable_id.'.png';
//        QrCode::url(env('APP_URL').'/attendance/'.$timetable_id.'/capture')
//            ->setOutfile($path )
//            ->setSize(10)
//            ->png();
//        return view('qr-code.index', compact('qrCode', 'timetable'));
//    }

    public function generateQRCode($timetable_id): Application|Factory|View
    {
        $timetable = Timetable::find($timetable_id);

        return view('qr-code.index', compact( 'timetable'));
    }
    public function create($timetable_id): Application|Factory|View
    {
        $attendance = Attendance::where('timetable_id', $timetable_id)->get();
        $timetable= Timetable::with('course')->find($timetable_id);
        return view('attendance.create', compact('timetable', 'attendance'));
    }

}
