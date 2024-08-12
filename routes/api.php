<?php

use App\Models\User;
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
});
