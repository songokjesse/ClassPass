<?php

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Timetable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;

Route::post("/login", function (Request $request) {
    $request->validate([
        "email" => ["required", "email"],
        "password" => ["required"],
        "device_name" => ["required"],
    ]);

    $user = User::where("email", $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            "email" => ["The provided credentials are incorrect."],
        ]);
    }

    return response()->json([
        "token" => $user->createToken($request->device_name)->plainTextToken,
    ]);
});

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::post("/logout", function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    });

    Route::get("/user", function (Request $request) {
        return $request->user();
    });

    Route::post("/attendance", function (Request $request) {
        $request->validate([
            "user_id" => ["required", "exists:students,user_id"],
            'timetable_id' => ["required", "exists:timetables,id"],
        ]);

        $student = Student::where('user_id', $request['user_id'])->firstOrFail();
        $timetable = Timetable::where('id', $request['timetable_id'])->firstOrFail();

        $classDate = Carbon::parse($timetable->date)->timezone('Africa/Nairobi');
        $classStartTime = Carbon::parse($classDate->format('Y-m-d') . ' ' . $timetable->start_time)->timezone('Africa/Nairobi');
        $classEndTime = Carbon::parse($classDate->format('Y-m-d') . ' ' . $timetable->end_time)->timezone('Africa/Nairobi');

        $currentTime = Carbon::now('Africa/Nairobi'); // Adjust time zone if necessary
        $gracePeriodMinutes = 30;
        // Check if attendance submission is before class start time->tz('UTC')->tz('Africa/Nairobi')
        if ($currentTime->lt($classStartTime)) {
            return response()->json([
                'message' => 'Attendance submission is not yet open for class starting at ' . $classStartTime->format('H:i'),
                'success' => false,
            ], 422);
        }

        // Check if attendance submission is after class end time with grace period
        $timeDifference = $currentTime->diffInMinutes($classEndTime);
        if ($timeDifference > $gracePeriodMinutes) {
            return response()->json([
                'message' => 'Attendance submission time has passed for class ending at ' . $classEndTime->format('H:i'),
                'success' => false,
            ], 422);
        }

        // Check if attendance submission is on the correct date
        if ($currentTime->format('Y-m-d') !== $classDate->format('Y-m-d')) {
            return response()->json([
                'message' => 'Attendance submission is only allowed on the class date: ' . $classDate->format('Y-m-d'),
                'success' => false,
            ], 422);
        }


        if (Attendance::where(['timetable_id' => $request['timetable_id'],'student_id' => $student->id])->exists()) {
            return response()->json([
                'message' => "You have already submitted attendance for today's Lesson.",
                'success' => false,
                "state" => "Redirect",
            ], 422);
        }
        Attendance::create([
            'student_id' => $student->id,
            'timetable_id' => $request['timetable_id'],
        ]);

        return response()->json([
            "message" => "You have successfully submitted attendance for today's class.",
        ], 201);
    });
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'admission_number' => ['required', 'string', 'max:255'],
        'device_name' => ['required'],
    ]);

    $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => Hash::make($request['password']),
    ]);

//    Add student admission number to the student table
    Student::create([
        'user_id' => $user->id,
        'admission_no' => $request['admission_number'],
    ]);

    event(new Registered($user));

    return response()->json([
        'token' => $user->createToken($request->device_name)->plainTextToken,
    ]);
});

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
