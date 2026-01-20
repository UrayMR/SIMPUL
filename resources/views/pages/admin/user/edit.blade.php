@extends('layouts.admin')

@section('title', 'Ubah Pengguna')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
	<li class="breadcrumb-item active" aria-current="page">Ubah Pengguna</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Ubah Pengguna</h5>
				<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left"></i> Batal
				</a>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PUT')

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="role" class="form-label">Peran <span class="text-danger">*</span></label>
							<x-select-input id="role" name="role" label="Peran" :options="[
							    'teacher' => 'Teacher',
							    'student' => 'Student',
							    'admin' => 'Admin',
							]" :selected="old('role', $user->role)" :searchable="false"
								required disabled />
						</div>

						<div class="col-md-6 mb-3">
							<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
							<x-select-input id="status" name="status" label="Status" :options="[
							    'active' => 'Aktif',
							    'inactive' => 'Nonaktif',
							    'pending' => 'Pending',
							    'rejected' => 'Ditolak',
							]" :selected="old('status', $user->status)" :searchable="false"
								required />
						</div>
					</div>

					{{-- NAMA --}}
					<div class="mb-3">
						<label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
						<input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap"
							value="{{ old('name', $user->name) }}">
						@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					{{-- EMAIL --}}
					<div class="mb-3">
						<label for="email" class="form-label">Email <span class="text-danger">*</span></label>
						<input type="email" name="email" class="form-control" required placeholder="Masukkan email"
							value="{{ old('email', $user->email) }}">
						@error('email')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- NOMOR TELEPON --}}
					<div class="mb-3">
						<label for="phone_number" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
						<input type="text" name="phone_number" class="form-control" required placeholder="Masukkan nomor telepon"
							value="{{ old('phone_number', $user->phone_number) }}">
						@error('phone_number')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- PASSWORD --}}
					<div class="mb-3">
						<label for="password" class="form-label">Password <span class="text-muted">(Opsional)</span></label>
						<div class="input-group">
							<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
								placeholder="Biarkan kosong jika password tidak ingin mengubah">
							<button type="button" class="btn password-toggle-btn" id="togglePassword">
								<i class="bi bi-eye-slash"></i>
							</button>
						</div>
						@error('password')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- KONFIRMASI PASSWORD --}}
					<div class="mb-3">
						<label for="password_confirmation" class="form-label">Konfirmasi Password <span
								class="text-muted">(Opsional)</span></label>
						<div class="input-group">
							<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
								id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru jika mengubah">
							<button type="button" class="btn password-toggle-btn" id="togglePasswordConfirm">
								<i class="bi bi-eye-slash"></i>
							</button>
						</div>
						@error('password_confirmation')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- FOTO --}}
					<div class="mb-3" id="photoForm">
						<label for="profile_picture_file" class="form-label">Foto Profil <span class="text-muted">(Opsional)</span></label>
						@php
							$name = old('name', $user->name ?? 'User');
							$defaultAvatar =
							    'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&color=000&size=300';
						@endphp
						<div class="text-center mb-3" id="old-photo-container"
							style="{{ !empty($user->teacher->profile_picture_path) ? '' : 'display:none;' }}">
							<img
								src="{{ !empty($user->teacher->profile_picture_path) ? asset('storage/' . $user->teacher->profile_picture_path) : $defaultAvatar }}"
								class="img-thumbnail rounded"
								style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
						</div>
						<div class="text-center mb-3" id="photo-preview-container" style="display:none;">
							<img id="photo-preview" src="#" alt="Preview Foto Profil" class="img-thumbnail rounded"
								style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
						</div>
						<input type="file" class="form-control @error('profile_photo_file') is-invalid @enderror"
							id="profile_picture_file" name="profile_picture_file" accept="image/*">
						<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 2MB. Ukuran pas foto: 3x4.</small>
						@error('profile_picture_file')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="d-flex justify-content-end mt-4">
						<button type="submit" class="btn btn-primary" id="submitUserBtn">
							<span class="button-content">
								<i class="bi bi-save me-2"></i> Simpan Pengguna
							</span>
							<span class="spinner-content d-none">
								<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
								Sedang Menyimpan Pengguna
							</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	@endsection

	@push('scripts')
		<script>
			const photoInput = document.getElementById('profile_picture_file');
			const previewContainer = document.getElementById('photo-preview-container');
			const previewImage = document.getElementById('photo-preview');
			const photoForm = document.getElementById('photoForm');
			const roleSelect = document.getElementById('role');
			const oldPhoto = document.getElementById('old-photo-container');

			// Show/hide photoForm based on role selection
			function togglePhotoForm() {
				if (roleSelect.value === 'teacher') {
					photoForm.style.display = 'block';
				} else {
					photoForm.style.display = 'none';
				}
			}
			// Initial check on page load
			togglePhotoForm();
			// Listen for changes
			roleSelect.addEventListener('change', togglePhotoForm);

			photoInput.addEventListener('change', function(event) {
				const file = event.target.files[0];
				if (file) {
					if (oldPhoto) oldPhoto.style.display = 'none';
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

			const passwordInput = document.getElementById("password");
			const togglePassword = document.getElementById("togglePassword");

			togglePassword.addEventListener("click", function() {
				const type = passwordInput.type === "password" ? "text" : "password";
				passwordInput.type = type;
				this.querySelector("i").classList.toggle("bi-eye");
				this.querySelector("i").classList.toggle("bi-eye-slash");
			});

			const passwordConfirmInput = document.getElementById("password_confirmation");
			const togglePasswordConfirm = document.getElementById("togglePasswordConfirm");

			togglePasswordConfirm.addEventListener("click", function() {
				const type = passwordConfirmInput.type === "password" ? "text" : "password";
				passwordConfirmInput.type = type;
				this.querySelector("i").classList.toggle("bi-eye");
				this.querySelector("i").classList.toggle("bi-eye-slash");
			});

			const userForm = document.querySelector('form[action="{{ route('admin.users.update', $user) }}"]');
			const submitUserBtn = document.getElementById('submitUserBtn');
			if (userForm && submitUserBtn) {
				userForm.addEventListener('submit', function() {
					submitUserBtn.disabled = true;
					submitUserBtn.querySelector('.button-content').classList.add('d-none');
					submitUserBtn.querySelector('.spinner-content').classList.remove('d-none');
				});
			}
		</script>
	@endpush
