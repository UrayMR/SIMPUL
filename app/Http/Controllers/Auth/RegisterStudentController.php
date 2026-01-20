<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\RegisterStudentRequest;
use Illuminate\Support\Facades\Auth;

class RegisterStudentController extends Controller
{
  public function index()
  {
    return view('pages.register-student');
  }

  public function store(RegisterStudentRequest $request)
  {
    $data = $request->validated();

    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'phone_number' => $data['phone_number'],
      'password' => bcrypt($data['password']),
      'role' => User::ROLE_STUDENT,
      'status' => User::STATUS_ACTIVE,
    ]);

    Auth::login($user);

    return redirect()->route('beranda')->with('success', 'Registrasi berhasil!');
  }
}
