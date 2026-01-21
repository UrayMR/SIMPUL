<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterStudentController;
use App\Http\Controllers\Auth\RegisterTeacherController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class, 'index'])->name('login');
  Route::post('/login', [AuthController::class, 'store']);

  Route::get('/register', [RegisterStudentController::class, 'index'])->name('register.student.index');
  Route::post('/register', [RegisterStudentController::class, 'store'])->name('register.student.store');
});

Route::get('/register/guru', [RegisterTeacherController::class, 'index'])->name('register.teacher.index');
Route::post('/register/guru', [RegisterTeacherController::class, 'store'])->name('register.teacher.store');

Route::middleware('auth')->group(function () {
  Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');
});
