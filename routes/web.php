<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursePaymentController;
use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeacherCourseController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileSettingController;

// Guest routes
Route::redirect('/beranda', '/beranda');
Route::get('/', [HomeController::class, 'index'])->name('beranda');

Route::view('/lowongan-karir', 'pages.guest.career')->name('lowongan-karir');
Route::get('/kategori-kursus', [HomeController::class, 'categories'])->name('kategori-kursus');
Route::get('/kursus', [UserCourseController::class, 'index'])->name('course.index');
Route::get('/kursus/{course}', [UserCourseController::class, 'show'])->name('course.show');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/users/pending-list', [UserController::class, 'pendingList'])->name('users.pending-list');
        Route::patch('/users/{user}/approve-teacher', [UserController::class, 'approveTeacher'])->name('users.approve-teacher');
        Route::patch('/users/{user}/reject-teacher', [UserController::class, 'rejectTeacher'])->name('users.reject-teacher');
        Route::resource('/users', UserController::class);

        Route::resource('/categories', CategoryController::class);

        Route::get('/courses/pending-list', [CourseController::class, 'pendingList'])->name('courses.pending-list');
        Route::patch('/courses/{course}/approve', [CourseController::class, 'approveCourse'])->name('courses.approve');
        Route::patch('/courses/{course}/reject', [CourseController::class, 'rejectCourse'])->name('courses.reject');
        Route::resource('/courses', CourseController::class);

        Route::patch('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
        Route::patch('/transactions/{transaction}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');
        Route::resource('/transactions', TransactionController::class);
    });

Route::middleware(['auth', 'role:teacher'])
    ->group(function () {
        Route::get('/guru/kursus', [TeacherCourseController::class, 'index'])->name('teacher.courses.index');
        Route::get('/guru/kursus/buat', [TeacherCourseController::class, 'create'])->name('teacher.courses.create');
        Route::post('/guru/kursus', [TeacherCourseController::class, 'store'])->name('teacher.courses.store');
        Route::get('/guru/kursus/{course}', [TeacherCourseController::class, 'show'])->name('teacher.courses.show');
        Route::get('/guru/kursus/{course}/edit', [TeacherCourseController::class, 'edit'])->name('teacher.courses.edit');
        Route::put('/guru/kursus/{course}', [TeacherCourseController::class, 'update'])->name('teacher.courses.update');
        Route::delete('/guru/kursus/{course}', [TeacherCourseController::class, 'destroy'])->name('teacher.courses.destroy');
    });

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/payment', [CoursePaymentController::class, 'index'])->name('student.payment.index');
        Route::post('/payment', [CoursePaymentController::class, 'store'])->name('student.payment.store');
        Route::post('/payment/apply', [CoursePaymentController::class, 'apply'])->name('student.payment.apply');
        Route::get('/riwayat-transaksi', [TransactionController::class, 'history'])->name('history.index');

        Route::get('/settings', [ProfileSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [ProfileSettingController::class, 'update'])->name('settings.update');
        Route::put('/settings/password', [ProfileSettingController::class, 'updatePassword'])->name('settings.update-password');
    });

require __DIR__ . '/auth.php';
