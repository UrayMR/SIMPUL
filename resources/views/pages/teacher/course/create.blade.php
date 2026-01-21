@extends('layouts.app')

@section('title', 'Tambah Kursus Baru')

@section('content')
	<section class="bg-app-primary text-white py-5 py-lg-6 mb-0">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-lg-8">
					<span class="badge bg-white text-app-primary px-3 py-2 rounded-pill mb-3 fw-semibold">
						Tambah Kursus
					</span>
					<h1 class="fw-extrabold display-5 mb-3 lh-sm text-white">
						Buat Kursus Baru
					</h1>
					<p class="fs-5 opacity-75 mb-0">
						Isi detail kursus yang ingin Anda buat di bawah ini.
					</p>
				</div>
			</div>
		</div>
	</section>
	<section class="py-5 bg-light">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="bg-white rounded-4 p-4">
						<form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="title" class="form-label fw-semibold">Judul Kursus <span class="text-danger">*</span></label>
									<input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
										value="{{ old('title') }}" required maxlength="150" placeholder="Masukkan judul kursus">
									@error('title')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-6 mb-3">
									<label for="category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
									<x-select-input id="category_id" name="category_id" label="Kategori" :options="$categories" :selected="old('category_id')"
										required />
									@error('category_id')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="price" class="form-label fw-semibold">Harga Kursus (Rp) <span
											class="text-danger">*</span></label>
									<input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
										value="{{ old('price', 0) }}" min="0" step="1000" required placeholder="Masukkan harga kursus">
									@error('price')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-6 mb-3">
									<label for="video_url" class="form-label fw-semibold">URL Video Youtube <span
											class="text-danger">*</span></label>
									<input type="url" name="video_url" id="video_url"
										class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url') }}"
										placeholder="https://www.youtube.com/watch?v=..." required>
									@error('video_url')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="mb-3">
								<label for="description" class="form-label fw-semibold">Deskripsi Kursus</label>
								<textarea name="description" id="description" rows="4"
								 class="form-control @error('description') is-invalid @enderror" maxlength="1000"
								 placeholder="Masukkan deskripsi kursus (opsional)">{{ old('description') }}</textarea>
								@error('description')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="mb-3">
								<label for="thumbnail_file" class="form-label fw-semibold">Gambar Thumbnail (Opsional)</label>
								<div class="mb-3" id="thumbnail-preview-container"
									style="display: {{ old('thumbnail_file') ? 'block' : 'none' }};">
									<img id="thumbnail-preview" src="{{ old('thumbnail_file') ? old('thumbnail_file') : '#' }}"
										alt="Preview Thumbnail" class="img-thumbnail" style="max-width: 200px;">
								</div>
								<input type="file" name="thumbnail_file" id="thumbnail_file"
									class="form-control @error('thumbnail_file') is-invalid @enderror" accept="image/*">
								@error('thumbnail_file')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 2MB.</small>
							</div>

							<div class="mb-4">
								<label for="hero_file" class="form-label fw-semibold mt-4">Gambar Banner <span
										class="text-danger">*</span></label>
								<div class="mb-3" id="hero-preview-container" style="display:none;">
									<img id="hero-preview" src="#" alt="Preview Hero" class="img-thumbnail" style="max-width: 200px;">
								</div>
								<input type="file" name="hero_file" id="hero_file"
									class="form-control @error('hero_file') is-invalid @enderror" accept="image/*" required>
								@error('hero_file')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 4MB.</small>
							</div>

							<div class="d-flex justify-content-end gap-2">
								<a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary">Batal</a>
								<button type="submit" class="btn btn-app-primary fw-semibold" id="submitCourseBtn">
									<span class="button-content">Tambah Kursus</span>
									<span class="spinner-content d-none">
										<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
										Sedang Menambah...
									</span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const courseForm = document.querySelector('form[action="{{ route('teacher.courses.store') }}"]');
			const submitCourseBtn = document.getElementById('submitCourseBtn');
			if (courseForm && submitCourseBtn) {
				courseForm.addEventListener('submit', function() {
					submitCourseBtn.disabled = true;
					submitCourseBtn.querySelector('.button-content').classList.add('d-none');
					submitCourseBtn.querySelector('.spinner-content').classList.remove('d-none');
				});
			}
			// Preview Thumbnail
			const thumbnailInput = document.getElementById('thumbnail_file');
			const thumbnailPreviewContainer = document.getElementById('thumbnail-preview-container');
			const thumbnailPreview = document.getElementById('thumbnail-preview');

			function updateThumbnailPreview(file) {
				if (file) {
					const reader = new FileReader();
					reader.onload = function(e) {
						thumbnailPreview.src = e.target.result;
						thumbnailPreviewContainer.style.display = 'block';
					};
					reader.readAsDataURL(file);
				} else {
					thumbnailPreview.src = '#';
					thumbnailPreviewContainer.style.display = 'none';
				}
			}
			thumbnailInput.addEventListener('change', function(event) {
				updateThumbnailPreview(event.target.files[0]);
			});
			// If file already selected (after validation error), show preview
			if (thumbnailInput.files && thumbnailInput.files[0]) {
				updateThumbnailPreview(thumbnailInput.files[0]);
			}
			// Preview Hero Image
			const heroInput = document.getElementById('hero_file');
			const heroPreviewContainer = document.getElementById('hero-preview-container');
			const heroPreview = document.getElementById('hero-preview');

			function updateHeroPreview(file) {
				if (file) {
					const reader = new FileReader();
					reader.onload = function(e) {
						heroPreview.src = e.target.result;
						heroPreviewContainer.style.display = 'block';
					};
					reader.readAsDataURL(file);
				} else {
					heroPreview.src = '#';
					heroPreviewContainer.style.display = 'none';
				}
			}
			heroInput.addEventListener('change', function(event) {
				updateHeroPreview(event.target.files[0]);
			});
			if (heroInput.files && heroInput.files[0]) {
				updateHeroPreview(heroInput.files[0]);
			}
		});
	</script>
@endpush
