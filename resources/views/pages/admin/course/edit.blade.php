@extends('layouts.admin')

@section('title', 'Ubah Kursus')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}" class="text-decoration-none">Data Kursus</a></li>
	<li class="breadcrumb-item active" aria-current="page">Ubah Kursus</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Ubah Kursus</h5>
				<a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left"></i> Batal
				</a>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="title" class="form-label">Judul Kursus <span class="text-danger">*</span></label>
							<input type="text" name="title" class="form-control" required placeholder="Masukkan judul kursus"
								value="{{ old('title', $course->title) }}">
							@error('title')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-6 mb-3">
							<label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
							<select name="category_id" class="form-select" required>
								@foreach ($categories as $id => $name)
									<option value="{{ $id }}" {{ old('category_id', $course->category_id) == $id ? 'selected' : '' }}>
										{{ $name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="teacher_id" class="form-label">Pengajar <span class="text-danger">*</span></label>
							<select name="teacher_id" class="form-select" required>
								@foreach ($teachers as $id => $name)
									<option value="{{ $id }}" {{ old('teacher_id', $course->teacher_id) == $id ? 'selected' : '' }}>
										{{ $name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6 mb-3">
							<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
							<select name="status" class="form-select" required>
								<option value="approved" {{ old('status', $course->status) == 'approved' ? 'selected' : '' }}>Disetujui</option>
								<option value="pending" {{ old('status', $course->status) == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="rejected" {{ old('status', $course->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 mb-3">
							<label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
							<input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
								value="{{ old('price', $course->price) }}" min="0" step="1000" required
								placeholder="Masukkan harga kursus">
							@error('price')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="mb-3">
						<label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
						<textarea name="description" class="form-control" rows="4" required>{{ old('description', $course->description) }}</textarea>
						@error('description')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="thumbnail_file" class="form-label">Thumbnail</label>
						<img src="{{ asset('storage/' . $course->thumbnail_path) }}" class="img-thumbnail mb-3" style="max-width: 200px;"
							id="thumbnail-img">
						<input type="file" name="thumbnail_file" id="thumbnail_file" class="form-control">
					</div>
					<div class="mb-3">
						<label for="hero_file" class="form-label">Hero Image</label>
						<img src="{{ asset('storage/' . $course->hero_path) }}" class="img-thumbnail mb-3" style="max-width: 200px;"
							id="hero-img">
						<input type="file" name="hero_file" id="hero_file" class="form-control">
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit" class="btn btn-primary" id="submitCourseBtn">
							<span class="button-content">Simpan Perubahan</span>
							<span class="spinner-content d-none">
								<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
								Sedang Menyimpan...
							</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Spinner submit
			const courseForm = document.querySelector('form[action*="courses/update"]');
			const submitCourseBtn = document.getElementById('submitCourseBtn');
			if (courseForm && submitCourseBtn) {
				courseForm.addEventListener('submit', function() {
					submitCourseBtn.disabled = true;
					submitCourseBtn.querySelector('.button-content').classList.add('d-none');
					submitCourseBtn.querySelector('.spinner-content').classList.remove('d-none');
				});
			}

			// Preview Thumbnail langsung timpa src img lama
			const thumbnailInput = document.getElementById('thumbnail_file');
			const thumbnailImg = document.getElementById('thumbnail-img');
			thumbnailInput.addEventListener('change', function(event) {
				const file = event.target.files[0];
				if (file) {
					const reader = new FileReader();
					reader.onload = function(e) {
						thumbnailImg.src = e.target.result;
					};
					reader.readAsDataURL(file);
				}
			});

			// Preview Hero Image langsung timpa src img lama
			const heroInput = document.getElementById('hero_file');
			const heroImg = document.getElementById('hero-img');
			heroInput.addEventListener('change', function(event) {
				const file = event.target.files[0];
				if (file) {
					const reader = new FileReader();
					reader.onload = function(e) {
						heroImg.src = e.target.result;
					};
					reader.readAsDataURL(file);
				}
			});
		});
	</script>
@endpush
