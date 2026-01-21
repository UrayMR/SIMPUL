<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\ProfileSettingRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfilePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileSettingController extends Controller
{
  public function index()
  {
    return view('pages.settings.index');
  }

  public function update(ProfileSettingRequest $request)
  {
    $user = Auth::user();

    $data = $request->validated();

    if ($request->hasFile('profile_picture')) {
      if ($user->profile_picture_path && Storage::disk('public')->exists($user->profile_picture_path)) {
        Storage::disk('public')->delete($user->profile_picture_path);
      }

      $file = $request->file('profile_picture');
      $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('profiles', $filename, 'public');
      $user->profile_picture_path = $path;
    }

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->phone_number = $data['phone_number'];

    if ($user->role === User::ROLE_TEACHER && $user->teacher) {
      if ($request->filled('bio')) {
        $user->teacher->bio = $request->input('bio');
      }
      if ($request->filled('expertise')) {
        $user->teacher->expertise = $request->input('expertise');
      }
      $user->teacher->save();
    }

    $user->save();

    return back()->with('success', 'Data akun berhasil diperbarui.');
  }

  public function updatePassword(ProfilePasswordRequest $request)
  {
    $data = $request->validated();

    $user = Auth::user();
    if (!Hash::check($data['old_password'], $user->password)) {
      return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
    }

    $user->password = Hash::make($data['new_password']);

    $user->save();

    return back()->with('success', 'Password berhasil diperbarui.');
  }
}
