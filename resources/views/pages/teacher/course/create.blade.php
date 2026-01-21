@extends('layouts.app')

@section('title', 'Tambah Kursus Baru')

@section('content')
	<section class="bg-app-primary text-white py-5 py-lg-6 mb-0">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-lg-8">
					<span class="badge bg-white text-app-primary px-3 py-2 rounded-pill mb-3 fw-semibold">
						🗂️ Kursus Saya
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
										value="{{ old('price', 0) }}" min="0" step="any" required placeholder="Masukkan harga kursus">
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
								<label for="hero_file" class="form-label fw-semibold">Gambar Banner <span class="text-danger">*</span></label>
								<div id="hero-drop-area" class="drop-area mb-2 position-relative">
									<div id="hero-drop-content" class="drop-content">
										<div id="hero-drop-text" class="text-app-primary fw-semibold">Seret & lepas gambar di sini<br><span
												class="fw-normal text-app-gray">atau klik untuk memilih</span></div>
									</div>
									<div id="hero-preview-wrapper" class="preview-wrapper d-none">
										<img id="hero-preview" src="#" alt="Preview Hero" class="img-thumbnail preview-img">
										<button type="button" id="hero-remove-btn" class="btn btn-sm btn-light preview-remove"
											aria-label="Hapus gambar">&times;</button>
									</div>
								</div>
								<input type="file" name="hero_file" id="hero_file"
									class="form-control d-none @error('hero_file') is-invalid @enderror" accept="image/*" required>
								@error('hero_file')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 4MB.</small>
							</div>

							<div class="mb-3">
								<div class="form-check mb-3">
									<input class="form-check-input" type="checkbox" id="enable-thumbnail">
									<label class="form-check-label" for="enable-thumbnail">
										Custom Thumbnail
									</label>
								</div>
								<div id="thumbnail-upload-section">
									<label for="thumbnail_file" class="form-label fw-semibold">Gambar Thumbnail (Opsional)</label>
									<div id="thumbnail-drop-area" class="drop-area mb-2 position-relative">
										<div id="thumbnail-drop-content" class="drop-content">
											<div id="thumbnail-drop-text" class="text-app-primary fw-semibold">Seret & lepas gambar di sini<br><span
													class="fw-normal text-app-gray">atau klik untuk memilih</span></div>
										</div>
										<div id="thumbnail-preview-wrapper" class="preview-wrapper d-none">
											<img id="thumbnail-preview" src="#" alt="Preview Thumbnail" class="img-thumbnail preview-img">
											<button type="button" id="thumbnail-remove-btn" class="btn btn-sm btn-light preview-remove"
												aria-label="Hapus gambar">&times;</button>
										</div>
									</div>
									<input type="file" name="thumbnail_file" id="thumbnail_file"
										class="form-control d-none @error('thumbnail_file') is-invalid @enderror" accept="image/*">
									@error('thumbnail_file')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
									<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 2MB.</small>
								</div>
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
			// Checkbox toggle thumbnail upload
			const enableThumbnail = document.getElementById('enable-thumbnail');
			const thumbnailUploadSection = document.getElementById('thumbnail-upload-section');
			const thumbnailInput = document.getElementById('thumbnail_file');
			const thumbnailPreviewWrapper = document.getElementById('thumbnail-preview-wrapper');
			const thumbnailDropText = document.getElementById('thumbnail-drop-text');

			function toggleThumbnailSection() {
				if (enableThumbnail.checked) {
					thumbnailUploadSection.style.display = '';
				} else {
					thumbnailUploadSection.style.display = 'none';
					thumbnailInput.value = '';
					if (thumbnailPreviewWrapper) {
						thumbnailPreviewWrapper.classList.add('d-none');
					}
					if (thumbnailDropText) {
						thumbnailDropText.classList.remove('d-none');
					}
				}
			}
			enableThumbnail.addEventListener('change', toggleThumbnailSection);
			toggleThumbnailSection();
			const courseForm = document.querySelector('form[action="{{ route('teacher.courses.store') }}"]');
			const submitCourseBtn = document.getElementById('submitCourseBtn');
			if (courseForm && submitCourseBtn) {
				courseForm.addEventListener('submit', function() {
					submitCourseBtn.disabled = true;
					submitCourseBtn.querySelector('.button-content').classList.add('d-none');
					submitCourseBtn.querySelector('.spinner-content').classList.remove('d-none');
				});
			}

			// Drag & Drop Thumbnail
			const thumbnailDropArea = document.getElementById('thumbnail-drop-area');
			const thumbnailPreview = document.getElementById('thumbnail-preview');
			const thumbnailRemoveBtn = document.getElementById('thumbnail-remove-btn');

			function updateThumbnailPreview(file) {
				if (file) {
					const reader = new FileReader();
					reader.onload = function(e) {
						thumbnailPreview.src = e.target.result;
						thumbnailPreviewWrapper.classList.remove('d-none');
						thumbnailDropText.classList.add('d-none');
					};
					reader.readAsDataURL(file);
				} else {
					thumbnailPreview.src = '#';
					thumbnailPreviewWrapper.classList.add('d-none');
					thumbnailDropText.classList.remove('d-none');
				}
			}

			thumbnailRemoveBtn.addEventListener('click', function(e) {
				e.preventDefault();
				thumbnailInput.value = '';
				updateThumbnailPreview(null);
			});

			thumbnailDropArea.addEventListener('click', function() {
				thumbnailInput.click();
			});
			thumbnailDropArea.addEventListener('dragover', function(e) {
				e.preventDefault();
				thumbnailDropArea.classList.add('drop-area-hover');
			});
			thumbnailDropArea.addEventListener('dragleave', function(e) {
				e.preventDefault();
				thumbnailDropArea.classList.remove('drop-area-hover');
			});
			thumbnailDropArea.addEventListener('drop', function(e) {
				e.preventDefault();
				thumbnailDropArea.classList.remove('drop-area-hover');
				if (e.dataTransfer.files && e.dataTransfer.files[0]) {
					thumbnailInput.files = e.dataTransfer.files;
					updateThumbnailPreview(e.dataTransfer.files[0]);
				}
			});
			thumbnailInput.addEventListener('change', function(event) {
				updateThumbnailPreview(event.target.files[0]);
			});
			// If file already selected (after validation error), show preview
			if (thumbnailInput.files && thumbnailInput.files[0]) {
				updateThumbnailPreview(thumbnailInput.files[0]);
			}

			// Drag & Drop Hero
			const heroDropArea = document.getElementById('hero-drop-area');
			const heroInput = document.getElementById('hero_file');
			const heroPreview = document.getElementById('hero-preview');
			const heroDropText = document.getElementById('hero-drop-text');

			const heroPreviewWrapper = document.getElementById('hero-preview-wrapper');
			const heroRemoveBtn = document.getElementById('hero-remove-btn');

			function updateHeroPreview(file) {
				if (file) {
					const reader = new FileReader();
					reader.onload = function(e) {
						heroPreview.src = e.target.result;
						heroPreviewWrapper.classList.remove('d-none');
						heroDropText.classList.add('d-none');
					};
					reader.readAsDataURL(file);
				} else {
					heroPreview.src = '#';
					heroPreviewWrapper.classList.add('d-none');
					heroDropText.classList.remove('d-none');
				}
			}

			heroRemoveBtn.addEventListener('click', function(e) {
				e.preventDefault();
				heroInput.value = '';
				updateHeroPreview(null);
			});

			heroDropArea.addEventListener('click', function() {
				heroInput.click();
			});
			heroDropArea.addEventListener('dragover', function(e) {
				e.preventDefault();
				heroDropArea.classList.add('drop-area-hover');
			});
			heroDropArea.addEventListener('dragleave', function(e) {
				e.preventDefault();
				heroDropArea.classList.remove('drop-area-hover');
			});
			heroDropArea.addEventListener('drop', function(e) {
				e.preventDefault();
				heroDropArea.classList.remove('drop-area-hover');
				if (e.dataTransfer.files && e.dataTransfer.files[0]) {
					heroInput.files = e.dataTransfer.files;
					updateHeroPreview(e.dataTransfer.files[0]);
				}
			});
			heroInput.addEventListener('change', function(event) {
				updateHeroPreview(event.target.files[0]);
			});
			if (heroInput.files && heroInput.files[0]) {
				updateHeroPreview(heroInput.files[0]);
			}
		});
	</script>
@endpush
