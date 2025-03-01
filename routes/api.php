<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherAuthController;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\StudentController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\MarkController;

Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);

Route::get('/assignments', [AssignmentController::class, 'index']);
Route::post('/assignments', [AssignmentController::class, 'store']);

Route::post('/marks', [MarkController::class, 'store']);
Route::post('/update-assignment-status', [AssignmentController::class, 'updateAssignmentStatus']);
Route::get('/assignments/{student_id}', [AssignmentController::class, 'getAssignmentsByStudent']);

Route::post('/store-marks', [MarkController::class, 'storeMarks']);
Route::get('/assignments/student/{student_id}', [AssignmentController::class, 'getAssignmentsByStudent']);

Route::prefix('teacher')->group(function () {
    Route::post('/register', [TeacherAuthController::class, 'register']); // (Optional)
    Route::post('/login', [TeacherAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [TeacherAuthController::class, 'logout']);
    });
});

Route::get('/test-password', function () {
    $teacher = Teacher::where('email', 'tony@stark.com')->first();

    if (!$teacher) {
        return "❌ Teacher not found!";
    }

    if (Hash::check('password123', $teacher->password)) {
        return "✅ Password is correct!";
    } else {
        return "❌ Invalid password!";
    }
});


Route::get('/common-assignments', [AssignmentController::class, 'getCommonAssignments']);
Route::post('/common-assignments', [AssignmentController::class, 'createCommonAssignment']);


