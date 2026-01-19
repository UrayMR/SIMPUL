<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::redirect('/', '/beranda');
Route::view('/beranda', 'pages.guest.home')->name('beranda');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        // Dashboard route
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
