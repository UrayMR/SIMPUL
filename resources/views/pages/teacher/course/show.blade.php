@extends('layouts.app')

@section('title', $course->title ?? 'Detail Kursus Saya')

@section('content')
	<style>
		/* Pastikan modal dan backdrop di atas navbar */
		.modal {
			z-index: 11000 !important;
		}

		.modal-backdrop {
			z-index: 10990 !important;
		}

		.course-preview h3 {
			font-size: 1.6rem;
		}

		.course-preview iframe {
			border: none;
		}

		.course-detail-section {
			border-radius: 1.25rem;
			border: 1px solid #eef2f7;
			background: #fff;
			box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.06);
			padding: 2.5rem 2rem;
		}

		.course-detail-section .meta-label {
			color: #6b7280;
			font-size: 0.98rem;
		}

		.course-detail-section .meta-value {
			font-weight: 600;
			color: #111827;
		}

		.course-detail-section .meta-icon {
			color: #0d6efd;
			margin-right: 0.5rem;
		}

		.course-detail-footer {
			border-top: 1px solid #f1f1f1;
			padding-top: 1.5rem;
			margin-top: 2rem;
		}
	</style>

	<section class="course-preview pt-5  bg-white">
		<div class="container border-bottom p-5">
			<div class="row g-5 align-items-center">
				<div class="col-lg-7 order-1 order-lg-1">
					<div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
						<iframe src="https://www.youtube.com/embed/{{ $course->video_url }}" title="Preview Kelas"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
						</iframe>
					</div>
				</div>
				<div class="col-lg-5 order-2 order-lg-2">
					<h3 class="fw-bold mb-3">
						{{ $course->title }}
					</h3>
					<p class="text-muted mb-4">
						{{ $course->description }}
					</p>
					<ul class="list-unstyled text-muted">
						<li class="mb-2">
							<i class="bi bi-bookmark-fill text-app-primary me-2"></i>
							{{ $course->category->name }}
						</li>
						<li class="mb-2">
							<i class="bi bi-people-fill text-app-primary me-2"></i>
							{{ $course->enrollments_count }} Terjual
						</li>
						<li>
							<i class="bx bx-calendar text-app-primary me-2"></i>
							{{ $course->created_at->format('d M Y') }}
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="py-5 bg-light">
		<div class="container px-5">
			<h4 class="fw-bold mb-4">Informasi Detail Kursus</h4>
			<div class="row g-4 mb-4">
				<div class="col-6">
					<div class="d-flex align-items-center gap-3">
						<i class="bi bi-people-fill fs-3 text-app-primary"></i>
						<div>
							<div class="text-muted small">Total Enrollment</div>
							<div class="fw-bold fs-4">{{ $course->enrollments_count }}</div>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="d-flex align-items-center gap-3">
						<i class="bi bi-cash-coin fs-3 text-success"></i>
						<div>
							<div class="text-muted small">Total Pendapatan</div>
							<div class="fw-bold fs-4 text-success">Rp {{ number_format($course->transactions_sum_amount ?? 0, 0, ',', '.') }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="d-flex align-items-center gap-3">
						<i class="bi bi-tag fs-3 text-secondary"></i>
						<div>
							<div class="text-muted small">Harga</div>
							<div class="fw-bold">
								{{ (float) $course->price === 0.0 ? 'GRATIS' : 'Rp ' . number_format((float) $course->price, 0, ',', '.') }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 mb-4">
					<div class="d-flex align-items-center gap-3">
						<i class="bi bi-check-circle fs-3 text-info"></i>
						<div>
							<div class="text-muted small">Status</div>
							<div class="fw-bold">
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
						</div>
					</div>
				</div>
			</div>
			<div class="d-flex justify-content-between gap-2 mt-5">
				<div>
					<a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary fw-semibold">
						Kembali
					</a>
				</div>
				<div>
					<a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-app-outline-primary fw-semibold">
						<i class="bi bi-pencil"></i> Edit
					</a>
					<button type="button" class="btn btn-outline-danger fw-semibold" data-bs-toggle="modal"
						data-bs-target="#modalDeleteCourse">
						<i class="bi bi-trash"></i> Hapus
					</button>
				</div>
			</div>
		</div>
	</section>

	{{-- Modal Konfirmasi Hapus --}}
	<div class="modal fade" id="modalDeleteCourse" tabindex="-1" aria-hidden="true">
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
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Spinner for delete course (match admin/teacher index logic)
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
