@extends('layouts.app')

@section('title', 'Manajemen Kursus Saya')

@section('content')
	<style>
		.modal {
			z-index: 11000 !important;
		}

		.modal-backdrop {
			z-index: 10990 !important;
		}

		.course-card-hover {
			transition: transform 0.28s cubic-bezier(.33, 1, .68, 1), box-shadow 0.28s cubic-bezier(.33, 1, .68, 1);
		}

		.course-card-link {
			cursor: pointer;
			display: block;
		}

		.course-card-hover:hover {
			transform: scale(1.015);
			box-shadow: 0 12px 36px 0 rgba(0, 0, 0, 0.16), 0 2px 8px 0 rgba(0, 0, 0, 0.10);
			z-index: 2;
		}

		.course-card-link:active .course-card-hover {
			transform: scale(1.015);
		}
	</style>

	<section class="bg-app-primary text-white py-5 py-lg-6 mb-0">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-lg-8">
					<span class="badge bg-white text-app-primary px-3 py-2 rounded-pill mb-3 fw-semibold">
						🗂️ Kursus Saya
					</span>
					<h1 class="fw-extrabold display-5 mb-3 lh-sm text-white">
						Kelola & Pantau Kursus Anda
					</h1>
					<p class="fs-5 opacity-75 mb-0">
						Lihat statistik, tambah, edit, dan pantau performa kursus Anda secara efisien.
					</p>
				</div>
			</div>
		</div>
	</section>

	<section class="py-5 bg-light">
		<div class="container">
			<div class="row mb-5 g-4 justify-content-center">
				<div class="col-md-4">
					<div class="bg-white rounded-4 shadow-sm p-4 text-center h-100">
						<div class="mb-2">
							<i class="bi bi-cash-coin fs-1 text-success"></i>
						</div>
						<h6 class="fw-bold mb-1 fs-5">Total Pendapatan</h6>
						<div class="fs-3 fw-bold text-success">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="bg-white rounded-4 shadow-sm p-4 text-center h-100">
						<div class="mb-2">
							<i class="bi bi-book fs-1 text-primary"></i>
						</div>
						<h6 class="fw-bold mb-1 fs-5">Total Kursus</h6>
						<div class="fs-3 fw-bold text-primary">{{ $courses->count() }}</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="bg-white rounded-4 shadow-sm p-4 text-center h-100">
						<div class="mb-2">
							<i class="bi bi-people fs-1 text-info"></i>
						</div>
						<h6 class="fw-bold mb-1 fs-5">Total Peserta</h6>
						<div class="fs-3 fw-bold text-info">{{ $courses->sum('enrollments_count') }}</div>
					</div>
				</div>
			</div>

			<div class="d-flex justify-content-between align-items-center mb-4">
				<h4 class="fw-bold mb-0">Daftar Kursus Saya</h4>
				<a href="{{ route('teacher.courses.create') }}" class="btn btn-app-primary shadow">
					<i class="bi bi-plus-circle me-1"></i> Tambah Kursus
				</a>
			</div>

			<div class="row">
				@forelse ($courses as $course)
					<div class="col-12 col-md-6 col-lg-4 mb-4">
						<a href="{{ route('teacher.courses.show', $course) }}" class="text-decoration-none course-card-link">
							<div class="card border-1 h-100 position-relative overflow-hidden course-card-hover">
								@if ($course->thumbnail_path)
									<img src="{{ asset('storage/' . $course->thumbnail_path) }}" alt="Thumbnail {{ $course->title }}"
										class="card-img-top object-fit-cover"
										style="height: 180px; min-height: 180px; max-height: 180px; width: 100%;">
								@else
									<div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
										<span class="text-muted"><i class="bi bi-image fs-1"></i></span>
									</div>
								@endif
								<div class="card-body pb-4">
									<div class="d-flex align-items-center gap-2 mb-2">
										<span class="badge bg-light text-dark border fw-normal">{{ $course->category->name ?? '-' }}</span>
										@if ($course->status === 'approved')
											<span class="badge bg-success">Aktif</span>
										@elseif ($course->status === 'pending')
											<span class="badge bg-warning text-dark">Pending</span>
										@elseif ($course->status === 'rejected')
											<span class="badge bg-danger">Rejected</span>
										@else
											<span class="badge bg-secondary">Nonaktif</span>
										@endif
									</div>
									<h5 class="fw-bold mb-1 text-truncate" title="{{ $course->title }}">{{ $course->title }}</h5>
									<div class="mb-2 small text-muted">Dibuat: {{ $course->created_at->format('d M Y') }}</div>
									@if ($course->description)
										<div class="mb-2 text-muted small" style="min-height: 38px; max-height: 38px; overflow: hidden;">
											{{ Str::limit(strip_tags($course->description), 60) }}</div>
									@endif
									<div class="mb-2 d-flex gap-3 align-items-center">
										<span class="fw-bold text-dark">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
										<span class="fw-semibold text-secondary"><i class="bi bi-people text-muted"></i>
											{{ $course->enrollments_count }} peserta</span>
									</div>
								</div>
								<div class="card-footer bg-white border-0 d-flex flex-column gap-2 pb-3 pt-0">
									<div class="d-flex align-items-center justify-content-between mb-2">
										<span class="text-muted small"><i class="bi bi-cash-coin text-success"></i> Total Pendapatan Kursus:</span>
										<span class="fw-bold text-success">Rp
											{{ number_format($course->transactions_sum_amount ?? 0, 0, ',', '.') }}</span>
									</div>
									<div class="d-flex justify-content-end gap-2">
										<a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-app-outline-primary fw-semibold"
											onclick="event.stopPropagation(); event.preventDefault(); window.location.href=this.href;">
											<i class="bi bi-pencil"></i> Edit
										</a>
										<button type="button" class="btn btn-outline-danger fw-semibold" data-bs-toggle="modal"
											data-bs-target="#modalDeleteCourse{{ $course->id }}"
											onclick="event.stopPropagation(); event.preventDefault();">
											<i class="bi bi-trash"></i> Hapus
										</button>
									</div>
								</div>
							</div>
						</a>
					</div>
				@empty
					<div class="col-12">
						<div class="bg-white rounded-4 shadow-sm p-5 text-center">
							<div class="mb-3 fs-1">📭</div>
							<h5 class="fw-bold mb-2">Belum ada kursus yang Anda buat.</h5>
							<p class="text-muted mb-4">Ayo mulai berbagi ilmu dengan membuat kursus pertamamu!</p>
							<a href="{{ route('teacher.courses.create') }}" class="btn btn-app-primary">
								<i class="bi bi-plus-circle me-1"></i> Buat Kursus
							</a>
						</div>
					</div>
				@endforelse
			</div>
		</div>

		{{-- Delete Modals --}}
		@foreach ($courses as $course)
			<div class="modal fade" id="modalDeleteCourse{{ $course->id }}" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content rounded-4 shadow-lg border-0 p-2">
						<div class="modal-header border-0 pb-0">
							<div class="d-flex align-items-center gap-2 w-100">
								<i class="bi bi-exclamation-triangle-fill text-danger fs-3 me-2"></i>
								<div class="flex-grow-1">
									<h5 class="modal-title mb-0 fw-bold text-danger">Konfirmasi Hapus</h5>
									<small class="text-muted">Aksi ini tidak dapat dibatalkan</small>
								</div>
								<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
						</div>
						<div class="modal-body pt-3 pb-0 px-4">
							<p class="mb-3 fs-6">Apakah Anda yakin ingin menghapus
								<strong>{{ Str::limit($course->title, 15, '...') }}</strong>?
							</p>
						</div>
						<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
							<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
							<form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" class="d-inline">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger px-4 btn-delete-course">
									<span class="button-content"><i class="bi bi-trash me-1"></i> Hapus</span>
									<span class="spinner-content d-none">
										<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
										Menghapus
									</span>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</section>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			document.querySelectorAll('.modal form').forEach(function(form) {
				form.addEventListener('submit', function(e) {
					var btn = form.querySelector('.btn-delete-course');
					if (btn) {
						btn.disabled = true;
						var buttonContent = btn.querySelector('.button-content');
						var spinnerContent = btn.querySelector('.spinner-content');
						if (buttonContent && spinnerContent) {
							buttonContent.classList.add('d-none');
							spinnerContent.classList.remove('d-none');
						}
					}
				});
			});
		});
	</script>
@endpush
