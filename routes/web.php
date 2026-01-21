<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeacherCourseController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::redirect('/beranda', '/beranda');
Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::view('/lowongan-karir', 'pages.guest.career')->name('lowongan-karir');
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
        Route::get('/guru/kursus/{course}/edit', [TeacherCourseController::class, 'edit'])->name('teacher.courses.edit');
        Route::put('/guru/kursus/{course}', [TeacherCourseController::class, 'update'])->name('teacher.courses.update');
        Route::delete('/guru/kursus/{course}', [TeacherCourseController::class, 'destroy'])->name('teacher.courses.destroy');
    });

Route::middleware(['auth'])
    ->group(function () {
      Route::get('/payment', [TransactionController::class, 'payment'])->name('payment.index');
    });

Route::middleware(['auth'])
    ->prefix('user/pengaturan-akun')
    ->as('user.settings.')
    ->group(function () {
        Route::get('/', function () {
            return view('pages.user.pengaturan-akun');
        })->name('index');

        Route::put('/photo', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ],           [
                'profile_photo.mimes' => 'Format gambar harus berupa jpg, jpeg, atau png.',
                'profile_photo.max' => 'Ukuran gambar maksimal adalah 2MB.',
            ]);

            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();

            // Delete old photo if exists 
            if ($user->profile_photo_path) {
                try {
                    if (\Illuminate\Support\Facades\Storage::exists('public/' . $user->profile_photo_path)) {
                        \Illuminate\Support\Facades\Storage::delete('public/' . $user->profile_photo_path);
                    }
                } catch (\Exception $e) {
                    // Ignore deletion errors
                }
            }

            // Store new photo
            $file = $request->file('profile_photo');
            $filename = 'profile_' . \Illuminate\Support\Facades\Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profiles', $filename, 'public');

            if ($path) {
                $user->profile_photo_path = $path;
                $user->save();
                return back()->with('success', 'Foto profil berhasil diperbarui.');
            }

            return back()->with('error', 'Gagal menyimpan foto profil.');
        })->name('update-photo');

        Route::put('/password', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).+$/', // At least one uppercase, one lowercase, and one digit
            ],           [
                'old_password.required' => 'Password lama wajib diisi.',
                'new_password.required' => 'Kata sandi baru wajib diisi.',
                'new_password.min' => 'Kata sandi baru harus terdiri dari minimal 8 karakter.',
                'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak sesuai.',
                'new_password.regex' => 'Kata sandi baru harus mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka.',
            ]);


            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();

            if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
            }

            $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
            $user->save();

            return back()->with('success', 'Password berhasil diperbarui.');
        })->name('update-password');
    });

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/pengaturan-akun')
    ->as('admin.settings.')
    ->group(function () {
        Route::get('/', function () {
            return view('pages.admin.pengaturan-akun');
        })->name('index');

        Route::put('/photo', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ],           [
                'profile_photo.mimes' => 'Format gambar harus berupa jpg, jpeg, atau png.',
                'profile_photo.max' => 'Ukuran gambar maksimal adalah 2MB.',
            ]);

            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();

            // Delete old photo if exists
            if ($user->profile_photo_path) {
                try {
                    if (\Illuminate\Support\Facades\Storage::exists('public/' . $user->profile_photo_path)) {
                        \Illuminate\Support\Facades\Storage::delete('public/' . $user->profile_photo_path);
                    }
                } catch (\Exception $e) {
                    // Ignore deletion errors
                }
            }

            // Store new photo
            $file = $request->file('profile_photo');
            $filename = 'profile_' . \Illuminate\Support\Facades\Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profiles', $filename, 'public');

            if ($path) {
                $user->profile_photo_path = $path;
                $user->save();
                return back()->with('success', 'Foto profil berhasil diperbarui.');
            }

            return back()->with('error', 'Gagal menyimpan foto profil.');
        })->name('update-photo');

        Route::put('/password', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).+$/', // At least one uppercase, one lowercase, and one digit
            ],           [
                'old_password.required' => 'Password lama wajib diisi.',
                'new_password.required' => 'Kata sandi baru wajib diisi.',
                'new_password.min' => 'Kata sandi baru harus terdiri dari minimal 8 karakter.',
                'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak sesuai.',
                'new_password.regex' => 'Kata sandi baru harus mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka.',
            ]);

            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();

            if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
            }

            $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
            $user->save();

            return back()->with('success', 'Password berhasil diperbarui.');
        })->name('update-password');
    });

require __DIR__ . '/auth.php';
