@extends('layouts.auth')

@section('title', 'Login - SILAYANKRIS')

@section('content')
	<div class="card">
		<div class="card-header bg-primary">
			<div class="app-brand justify-content-center p-2" style="margin-bottom: 0px !important">
				<a href="{{ route('home') }}" class="app-brand-link gap-2 text-decoration-none">
					<span class="app-brand-logo demo">
						<img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="40">
					</span>
					<span class="app-brand-text demo text-white fw-bolder"
						style="text-transform: uppercase; letter-spacing: 2px">SILAYANKRIS</span>
				</a>
			</div>
		</div>
		<div class="card-body pt-3">
			<div class="text-center">
				<h4 class="mb-2">Selamat Datang Kembali 👋</h4>
				<p>Silakan masukkan email dan password untuk mengakses layanan kami.</p>
			</div>

			<form id="formAuthentication" method="POST" action="{{ route('login', ['type' => request('type')]) }}">
				@csrf
				<div class="mb-3">
					<label for="email" class="form-label">Email</label>
					<div class="input-group input-group-merge">
						<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
							placeholder="Masukkan email anda" value="{{ old('email') }}" required autofocus />
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
						<input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
							placeholder="Masukkan password anda" required />
						<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
					</div>
					@error('password')
						<div class="text-danger mt-1 small">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-2">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="remember-me" name="remember-me" />
						<label class="form-check-label" for="remember-me">
							Ingat Saya
						</label>
					</div>
				</div>

				<div class="mb-3">
					<button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
				</div>
			</form>

			@guest
				<p class="text-center">
					<span>Tidak dapat masuk? </span>
					<a href="/#contact" class="text-primary ">
						<span>Hubungi Kami</span>
					</a>
				</p>
			@endguest
		</div>
	</div>
@endsection
