@extends('layouts.admin')

@section('title', 'Tambah Kursus')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Data Kursus</a></li>
	<li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Tambah Kursus</h5>
				<a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left me-2"></i> Batal
				</a>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="title" class="form-label">Judul Kursus <span class="text-danger">*</span></label>
							<input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
								value="{{ old('title') }}" required maxlength="150" placeholder="Masukkan judul kursus">
							@error('title')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-6 mb-3">
							<label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
							<x-select-input id="category_id" name="category_id" label="Kategori" :options="$categories" :selected="old('category_id')"
								required />
							@error('category_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="teacher_id" class="form-label">Pengajar <span class="text-danger">*</span></label>
							<x-select-input id="teacher_id" name="teacher_id" label="Pengajar" :options="$teachers" :selected="old('teacher_id')" required />
							@error('teacher_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-6 mb-3">
							<label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
							<input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
								value="{{ old('price', 0) }}" min="0" step="1000" required placeholder="Masukkan harga kursus">
							@error('price')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="mb-3">
						<label for="description" class="form-label">Deskripsi</label>
						<textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
						 maxlength="1000" rows="4" placeholder="Masukkan deskripsi kursus (opsional)">{{ old('description') }}</textarea>
						@error('description')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="video_url" class="form-label">URL Video (Opsional)</label>
						<input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror"
							value="{{ old('video_url') }}" placeholder="https://...">
						@error('video_url')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="thumbnail_file" class="form-label">Thumbnail (Opsional)</label>
						<input type="file" name="thumbnail_file" id="thumbnail_file"
							class="form-control @error('thumbnail_file') is-invalid @enderror" accept="image/*">
						@error('thumbnail_file')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
						<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 2MB.</small>
					</div>
					<div class="mb-3">
						<label for="hero_file" class="form-label">Hero Image <span class="text-danger">*</span></label>
						<input type="file" name="hero_file" id="hero_file" class="form-control @error('hero_file') is-invalid @enderror"
							accept="image/*" required>
						@error('hero_file')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
						<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 4MB.</small>
					</div>
					<div class="d-flex justify-content-end gap-2">
						<button type="submit" class="btn btn-primary" id="submitCourseBtn">
							<span class="button-content">Simpan</span>
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
			const courseForm = document.querySelector('form[action="{{ route('admin.courses.store') }}"]');
			const submitCourseBtn = document.getElementById('submitCourseBtn');
			if (courseForm && submitCourseBtn) {
				courseForm.addEventListener('submit', function() {
					submitCourseBtn.disabled = true;
					submitCourseBtn.querySelector('.button-content').classList.add('d-none');
					submitCourseBtn.querySelector('.spinner-content').classList.remove('d-none');
				});
			}
		});
	</script>
@endpush
