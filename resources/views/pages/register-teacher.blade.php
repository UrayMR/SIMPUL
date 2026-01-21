@extends('layouts.app')

@section('title', 'Registrasi Guru')

@section('content')
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-10 col-lg-8 col-xl-7">
				<div class="card border shadow rounded-4 bg-white" style="border-color: #e5e7eb;">
					<div class="card-body p-4 p-md-5 px-lg-5 py-lg-5">
						<div class="mb-5 text-center">
							<h2 class="fw-bold mb-2" style="letter-spacing:0.5px;">Daftar Sebagai Guru</h2>
							<div class="text-muted mb-1">Isi data di bawah dengan benar untuk mendaftar</div>
						</div>
						<form method="POST" action="{{ route('register.teacher.store') }}" enctype="multipart/form-data"
							autocomplete="off">
							@csrf
							<div class="row g-4">
								<div class="col-12">
									<label for="name" class="form-label text-muted small">Nama Lengkap <span
											class="text-danger">*</span></label>
									<input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" id="name"
										name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
									@error('name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-12">
									<label for="email" class="form-label text-muted small">Email <span class="text-danger">*</span></label>
									<div class="input-group rounded-3">
										<span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope"></i></span>
										<input type="email" class="form-control border-start-0 rounded-end-3 @error('email') is-invalid @enderror"
											id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
									</div>
									@error('email')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-12">
									<label for="phone_number" class="form-label text-muted small">Nomor Telepon <span
											class="text-danger">*</span></label>
									<div class="input-group rounded-3">
										<span class="input-group-text bg-white border-end-0"><i class="bi bi-telephone"></i></span>
										<input type="text"
											class="form-control border-start-0 rounded-end-3 @error('phone_number') is-invalid @enderror"
											id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel">
									</div>
									@error('phone_number')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-12 col-md-6">
									<label for="password" class="form-label text-muted small">Password <span class="text-danger">*</span></label>
									<input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" id="password"
										name="password" required autocomplete="new-password">
									@error('password')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-12 col-md-6">
									<label for="password_confirmation" class="form-label text-muted small">Konfirmasi Password <span
											class="text-danger">*</span></label>
									<input type="password" class="form-control rounded-3 @error('password_confirmation') is-invalid @enderror"
										id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
									@error('password_confirmation')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-12">
									<label for="profile_picture_file" class="form-label text-muted small">Foto Profil <span
											class="text-danger">*</span></label>
									<div class="text-center mb-3" id="photo-preview-container" style="display:none;">
										<img id="photo-preview" src="#" alt="Preview Foto Profil" class="img-thumbnail rounded"
											style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
									</div>
									<input type="file" class="form-control rounded-3 @error('profile_picture_file') is-invalid @enderror"
										id="profile_picture_file" name="profile_picture_file" accept="image/*" required>
									<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 2MB. Ukuran pas foto: 3x4.</small>
									@error('profile_picture_file')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-12">
									<label for="bio" class="form-label text-muted small">Bio (Opsional)</label>
									<textarea class="form-control rounded-3 @error('bio') is-invalid @enderror" id="bio" name="bio"
									 rows="3">{{ old('bio') }}</textarea>
									@error('bio')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-12">
									<label for="expertise" class="form-label text-muted small">Keahlian (Opsional)</label>
									<input type="text" class="form-control rounded-3 @error('expertise') is-invalid @enderror" id="expertise"
										name="expertise" value="{{ old('expertise') }}">
									@error('expertise')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="d-flex flex-column flex-md-row gap-3 mt-5">
								<a href="{{ route('beranda') }}" class="btn btn-app-outline-secondary btn-lg fw-semibold flex-fill">
									<i class="bi bi-arrow-left me-2"></i> Kembali
								</a>
								<button type="submit" class="btn btn-app-primary	 btn-lg fw-semibold flex-fill shadow-sm">
									<span class="button-content"><i class="bi bi-person-plus me-2"></i> Daftar</span>
									<span class="spinner-content d-none">
										<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
										Mendaftar...
									</span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		const form = document.querySelector('form[action="{{ route('register.teacher.store') }}"]');
		const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
		const photoInput = document.getElementById('profile_picture_file');
		const previewContainer = document.getElementById('photo-preview-container');
		const previewImage = document.getElementById('photo-preview');

		if (form && submitBtn) {
			form.addEventListener('submit', function() {
				submitBtn.disabled = true;
				submitBtn.querySelector('.button-content').classList.add('d-none');
				submitBtn.querySelector('.spinner-content').classList.remove('d-none');
			});
		}

		if (photoInput) {
			photoInput.addEventListener('change', function(event) {
				const file = event.target.files[0];
				if (file) {
					const reader = new FileReader();
					reader.onload = function(e) {
						previewImage.src = e.target.result;
						previewContainer.style.display = 'block';
					};
					reader.readAsDataURL(file);
				} else {
					previewContainer.style.display = 'none';
				}
			});
		}
	</script>
@endpush
