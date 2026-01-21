@extends('layouts.auth')

@section('title', 'Login - SIMPUL')

@section('content')
    <div class="card">
        <div class="card-header bg-app-primary">
            <div class="app-brand justify-content-center p-2" style="margin-bottom: 0px !important">
                <a href="{{ route('beranda') }}" class="app-brand-link gap-2 text-decoration-none">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/img/logo/Circle Logo Simpul.png') }}" alt="Logo" width="40">
                    </span>
                    <span class="app-brand-text demo text-white fw-bolder"
                        style="text-transform: uppercase; letter-spacing: 2px">SIMPUL</span>
                </a>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="text-center">
                <h4 class="mb-2">Selamat Datang Kembali 👋</h4>
                <p>Silakan masukkan email dan password untuk mengakses layanan kami.</p>
            </div>

            <form id="formAuthentication" method="POST" action="{{ route('login') }}" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group input-group-merge">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Masukkan email anda" value="{{ old('email') }}" required
                            autofocus />
                    </div>
                    @error('email')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror

                </div>

                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Masukkan password anda" required />
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    @error('password')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label text-muted" for="remember">
                            Ingat saya
                        </label>
                    </div>

                </div>


                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                </div>
                <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">

                    {{-- DAFTAR --}}
                    <a href="{{ route('register.student.index') }}" class="btn btn-outline-secondary  btn-md px-4">
                        <i class="bi bi-person-plus me-1"></i>
                        Daftar Akun
                    </a>

                    {{-- HUBUNGI ADMIN --}}
                    <a href="/#contact" class="btn btn-outline-secondary btn-md px-4">
                        <i class="bi bi-headset me-1"></i>
                        Hubungi Admin
                    </a>

                </div>

            </form>



        </div>
    </div>
@endsection
