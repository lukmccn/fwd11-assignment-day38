<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Route untuk REST API LMS Platform.
| Public routes: register, login
| Protected routes: logout, me, courses (CRUD)
|
*/

// ==================
// PUBLIC ROUTES
// ==================
Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

// ==================
// PROTECTED ROUTES (butuh token Sanctum)
// ==================
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me',      [AuthController::class, 'me']);

    // Courses
    Route::apiResource('courses', CourseController::class);
});