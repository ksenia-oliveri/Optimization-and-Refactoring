<?php

use App\Http\Controllers\Api\V1\FormsApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/groups', [FormsApiController::class,'findGroups']);
    Route::get('/students', [FormsApiController::class, 'findStudentsOnCourse']);
    Route::post('/add', [FormsApiController::class, 'addNewStudent']);
    Route::delete('/delete', [FormsApiController::class, 'deleteStudent']);

    Route::get('/students/all/courses', [FormsApiController::class, 'allStudentsCourses']);
    Route::post('/student/{student_id}/course/add', [FormsApiController::class, 'addStudentToCourse']);
    Route::delete('/student/{student_id}/course/delete', [FormsApiController::class, 'deleteStudentFromCourse']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
