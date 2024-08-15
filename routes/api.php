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


        // Validate if a user submitted attendance before or after the class
        $classStartTime = Carbon::parse($timetable->start_time);
        $classEndTime = Carbon::parse($timetable->end_time);
        $classDate = Carbon::parse($timetable->date);
        $currentTime = Carbon::now('Africa/Nairobi'); // Replace with appropriate time zone

        // Allow a 5-minute grace period after class end
        $gracePeriod = 30;

        if ($currentTime->lt($classStartTime)) {
            return response()->json([
                'message' => 'Attendance submission is not yet open.',
                'success' => false,
            ], 422);
        } elseif ($currentTime->diffInMinutes($classEndTime) > $gracePeriod) {
            return response()->json([
                'message' => 'You have missed the attendance submission time.',
                'success' => false,
            ], 422);
        } elseif ($currentTime->diffInDays($classDate) !== 0) {
            return response()->json([
                'message' => 'Attendance submission is only allowed on the class date.',
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
