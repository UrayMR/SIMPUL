<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\RegisterTeacherRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterTeacherController extends Controller
{
  public function index()
  {
    return view('pages.register-teacher');
  }

  public function store(RegisterTeacherRequest $request)
  {
    $data = $request->validated();
    DB::beginTransaction();
    try {
      $profilePicturePath = null;
      if ($request->hasFile('profile_picture_file')) {
        $profilePicturePath = $request->file('profile_picture_file')->store('profile-pictures', 'public');
      }

      $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'password' => Hash::make($data['password']),
        'role' => User::ROLE_TEACHER,
        'status' => User::STATUS_PENDING,
      ]);

      $teacherData = [
        'bio' => $data['bio'] ?? null,
        'expertise' => $data['expertise'] ?? null,
      ];
      if ($profilePicturePath) {
        $teacherData['profile_picture_path'] = $profilePicturePath;
      }
      $user->teacher()->create($teacherData);

      DB::commit();

      return redirect()->route('beranda')->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan admin.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->withInput()->withErrors(['register' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
    }
  }
}
