@extends('layouts.admin')

@section('title', 'Detail Kursus')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}" class="text-decoration-none">Data Kursus</a></li>
	<li class="breadcrumb-item active" aria-current="page">Detail Kursus</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Detail Kursus</h5>
				<a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left"></i> Kembali
				</a>
			</div>
			<div class="card-body">
				<div class="row mb-4 align-middle">
					<div class="col-md-6 text-start mb-3">
						<img src="{{ asset('storage/' . $course->thumbnail_path) }}" class="img-thumbnail rounded shadow-sm mb-2"
							style="width: 100%; max-width: 350px; height: 200px; object-fit: cover; border: 2px solid #dee2e6;">
						<div class="fw-semibold mt-2">Thumbnail</div>
					</div>
					<div class="col-md-6 text-start mb-3">
						<img src="{{ asset('storage/' . $course->hero_path) }}" class="img-thumbnail rounded shadow-sm mb-2"
							style="width: 100%; max-width: 350px; height: 200px; object-fit: cover; border: 2px solid #dee2e6;">
						<div class="fw-semibold mt-2">Hero Image</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-6 mb-3">
						<label class="form-label text-start d-block">Judul Kursus</label>
						<input type="text" class="form-control" value="{{ $course->title }}" disabled>
					</div>
					<div class="col-md-6 mb-3">
						<label class="form-label text-start d-block">Kategori</label>
						<input type="text" class="form-control" value="{{ $course->category->name ?? '-' }}" disabled>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-6 mb-3">
						<label class="form-label text-start d-block">Pengajar</label>
						<input type="text" class="form-control" value="{{ $course->teacher->user->name ?? '-' }}" disabled>
					</div>
					<div class="col-md-6 mb-3">
						<label class="form-label text-start d-block">Status</label>
						<input type="text" class="form-control" value="{{ ucfirst($course->status) }}" disabled>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-12 mb-3">
						<label class="form-label text-start d-block">Harga</label>
						<input type="text" class="form-control" value="Rp {{ number_format($course->price, 0, ',', '.') }}" disabled>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-12 mb-3">
						<label class="form-label text-start d-block">Video URL</label>
						@if (!empty($course->video_url))
							<input type="text" class="form-control" value="{{ $course->video_url }}" disabled>
						@else
							<input type="text" class="form-control" value="-" disabled>
						@endif
					</div>
				</div>
				<div class="mb-3">
					<label class="form-label text-start d-block">Deskripsi</label>
					<textarea class="form-control" rows="4" disabled>{{ $course->description }}</textarea>
				</div>
			</div>
			<div class="card-footer bg-white border-0 pt-0">
				<div class="d-flex align-items-center">
					<span class="fw-semibold">Jumlah Enrollments:</span>
					<span class="ms-2">{{ $course->enrollments_count ?? $course->enrollments()->count() }}</span>
				</div>
				@if ($course->status === 'pending')
					<div class="d-flex justify-content-end gap-2 mt-3">
						<button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalApproveCourse">
							<i class="bi bi-check-circle"></i> Approve
						</button>
						<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalRejectCourse">
							<i class="bi bi-x-circle"></i> Reject
						</button>
					</div>

					<!-- Modal Approve -->
					<div class="modal fade" id="modalApproveCourse" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content rounded-4 shadow-lg border-0 p-2">
								<div class="modal-header border-0 pb-0">
									<div class="d-flex align-items-center gap-2 w-100">
										<i class="bi bi-check-circle text-success fs-3 me-2"></i>
										<div class="flex-grow-1">
											<h5 class="modal-title mb-0 fw-bold text-success">Konfirmasi Approve</h5>
											<small class="text-muted">Kursus akan diaktifkan</small>
										</div>
										<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
								</div>
								<div class="modal-body pt-3 pb-0 px-4">
									<p class="mb-3 fs-6">Approve <strong>{{ $course->title }}</strong> sebagai kursus aktif?</p>
								</div>
								<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
									<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
									<form action="{{ route('admin.courses.approve', $course) }}" method="POST" class="d-inline">
										@csrf
										@method('PATCH')
										<button type="submit" class="btn btn-success px-4 btn-approve-course">
											<span class="button-content"><i class="bi bi-check-circle me-1"></i> Approve</span>
											<span class="spinner-content d-none">
												<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
												Memproses...
											</span>
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>

					<!-- Modal Reject -->
					<div class="modal fade" id="modalRejectCourse" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content rounded-4 shadow-lg border-0 p-2">
								<div class="modal-header border-0 pb-0">
									<div class="d-flex align-items-center gap-2 w-100">
										<i class="bi bi-x-circle text-danger fs-3 me-2"></i>
										<div class="flex-grow-1">
											<h5 class="modal-title mb-0 fw-bold text-danger">Konfirmasi Reject</h5>
											<small class="text-muted">Pengajuan kursus akan ditolak</small>
										</div>
										<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
								</div>
								<div class="modal-body pt-3 pb-0 px-4">
									<p class="mb-3 fs-6">Tolak pengajuan <strong>{{ $course->title }}</strong> sebagai kursus?</p>
								</div>
								<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
									<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
									<form action="{{ route('admin.courses.reject', $course) }}" method="POST" class="d-inline">
										@csrf
										@method('PATCH')
										<button type="submit" class="btn btn-danger px-4 btn-reject-course">
											<span class="button-content"><i class="bi bi-x-circle me-1"></i> Reject</span>
											<span class="spinner-content d-none">
												<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
												Memproses...
											</span>
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Spinner for approve button
			document.querySelectorAll('.btn-approve-course').forEach(function(btn) {
				btn.closest('form').addEventListener('submit', function(e) {
					btn.disabled = true;
					btn.querySelector('.button-content').classList.add('d-none');
					btn.querySelector('.spinner-content').classList.remove('d-none');
				});
			});
			// Spinner for reject button
			document.querySelectorAll('.btn-reject-course').forEach(function(btn) {
				btn.closest('form').addEventListener('submit', function(e) {
					btn.disabled = true;
					btn.querySelector('.button-content').classList.add('d-none');
					btn.querySelector('.spinner-content').classList.remove('d-none');
				});
			});
		});
	</script>
@endpush
