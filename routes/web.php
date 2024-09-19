<?php

use App\Http\Controllers\FormsController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('forms')->group(function () {
    Route::get('/', [FormsController::class, 'index'])->name('mainPage');
    Route::get('/groups', [FormsController::class,'showGroups'])->name('find.groups');
    Route::get('/students/on/course', [FormsController::class, 'findStudentsOnCourse'])->name('find.students');

    Route::get('/students/all/courses', [FormsController::class, 'allStudentsCourses'])->name('get.all.students.courses');
    Route::post('/student/{student_id}/course/add', [FormsController::class, 'addStudentToCourse'])->name('add.student.to.course');
    Route::delete('/student/{student_id}/course/delete', [FormsController::class, 'deleteStudentFromCourse'])->name('delete.student.from.course');

    Route::post('/add', [FormsController::class, 'addNewStudent'])->name('add.student');
    Route::delete('/delete', [FormsController::class, 'deleteStudent'])->name('delete.student');


});
