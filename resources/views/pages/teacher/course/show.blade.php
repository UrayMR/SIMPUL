@extends('layouts.app')

@section('title', 'Detail Kursus Saya')

@section('content')
	<style>
		.teacher-profile h4 {
			font-size: 1.6rem;
			font-weight: 700;
		}

		.teacher-card {
			border-radius: 1.25rem;
			border: 1px solid #eef2f7;
			background: #fff;
			transition: all 0.3s ease;
		}

		.teacher-card:hover {
			transform: translateY(-4px);
			box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
		}

		.teacher-avatar {
			width: 120px;
			height: 120px;
			border-radius: 1.25rem;
			overflow: hidden;
			background: #f3f4f6;
			flex-shrink: 0;
		}

		.teacher-avatar img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.teacher-name {
			font-size: 1.25rem;
			font-weight: 700;
		}

		.teacher-badge {
			font-size: 0.75rem;
			padding: 0.35rem 0.6rem;
			border-radius: 999px;
		}

		.teacher-meta {
			font-size: 0.9rem;
			color: #6b7280;
		}

		.teacher-meta span {
			display: inline-flex;
			align-items: center;
			gap: 6px;
		}

		.teacher-bio {
			font-size: 0.95rem;
			color: #374151;
			line-height: 1.7;
		}

		.teacher-avatar-wrapper {
			min-width: 140px;
		}

		.badge.bg-success-subtle {
			background-color: #e6f7f1;
		}

		.course-preview h3 {
			font-size: 1.6rem;
		}

		.course-preview iframe {
			border: none;
		}
	</style>

	{{-- Section Video --}}
	<section class="course-preview py-5 bg-white">
		<div class="container border-bottom p-5">

			{{-- ROW 1 : VIDEO + TITLE --}}
			<div class="row g-5 align-items-start">

				<!-- LEFT : VIDEO -->
				<div class="col-12 col-lg-6">
					<div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
						<iframe src="https://www.youtube.com/embed/{{ $course->video_url }}" title="Preview Kursus"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
						</iframe>
					</div>
				</div>

				<!-- RIGHT : TITLE & DESCRIPTION -->
				<div class="col-12 col-lg-6">
					<h3 class="fw-bold text-app-gray mb-3">
						{{ $course->title }}
					</h3>

					<p class="text-app-gray mb-0">
						{{ $course->description }}
					</p>
				</div>

			</div>

			<hr class="my-5">

			{{-- ROW 2 : META + CONTACT --}}
			<div class="row g-5 align-items-start">

				<!-- LEFT : CATEGORY - AUTHOR -->
				<div class="col-lg-7">
					<h6 class="fw-bold mb-4 text-app-primary fs-5">
						Informasi Detail Kursus
					</h6>

					<div class="row g-3">

						{{-- Kategori --}}
						<div class="col-12 col-md-6">
							<div class="p-3 rounded-4 border d-flex align-items-start gap-3 h-100">
								<i class="bi bi-bookmark-fill fs-4 text-app-primary"></i>
								<div>
									<div class="text-muted small">Kategori</div>
									<div class="fw-semibold text-app-gray">
										{{ $course->category->name }}
									</div>
								</div>
							</div>
						</div>

						{{-- Terjual --}}
						<div class="col-12 col-md-6">
							<div class="p-3 rounded-4 border d-flex align-items-start gap-3 h-100">
								<i class="bi bi-people-fill fs-4 text-app-primary"></i>
								<div>
									<div class="text-muted small">Total Terjual</div>
									<div class="fw-semibold text-app-gray">
										{{ $course->enrollments_count }} Peserta
									</div>
								</div>
							</div>
						</div>

						{{-- Tanggal Dibuat --}}
						<div class="col-12 col-md-6">
							<div class="p-3 rounded-4 border d-flex align-items-start gap-3 h-100">
								<i class="bi bi-calendar-event fs-4 text-app-primary"></i>
								<div>
									<div class="text-muted small">Tanggal Dibuat</div>
									<div class="fw-semibold text-app-gray">
										{{ $course->created_at->translatedFormat('l, d F Y H:i') }} WIB
									</div>
								</div>
							</div>
						</div>

						{{-- Pengajar --}}
						<div class="col-12 col-md-6">
							<div class="p-3 rounded-4 border d-flex align-items-start gap-3 h-100">
								<i class="bi bi-person-fill fs-4 text-app-primary"></i>
								<div>
									<div class="text-muted small">Pengajar</div>
									<div class="fw-semibold text-app-gray">
										{{ $course->teacher->user->name }}
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<!-- RIGHT : SUMMARY -->
				<div class="col-lg-5">
					<div class="p-4 rounded-4 border h-100 bg-white">

						{{-- Total Pendapatan --}}
						<div class="d-flex align-items-center gap-3 mb-4">
							<div class="icon-box bg-white bg-opacity-10 rounded-3 p-3">
								<i class="bi bi-cash fs-4 text-app-primary"></i>
							</div>
							<div>
								<div class="text-muted small">Total Pendapatan</div>
								<div class="fs-4 fw-bold text-app-gray">
									Rp {{ number_format($transactionsSumAmount ?? 0, 0, ',', '.') }}
								</div>
							</div>
						</div>

						<hr class="my-3">

						{{-- Status Kursus --}}
						<div class="d-flex align-items-center gap-3">
							<div class="icon-box bg-white bg-opacity-10 rounded-3 p-3">
								<i class="bi bi-clipboard-check fs-4 text-app-primary"></i>
							</div>
							<div>
								<div class="text-muted small">Status Kursus</div>

								@php
									$statusClass = match ($course->status) {
									    'approved' => 'success',
									    'pending' => 'warning',
									    'rejected' => 'danger',
									    default => 'secondary',
									};
								@endphp

								<span
									class="text-white badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-3 py-2 rounded-pill fw-semibold">
									{{ ucfirst($course->status) }}
								</span>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
		<div class="container py-4">
			<div
				class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3  pt-4">

				<a href="{{ route('teacher.courses.index') }}" class="btn btn-outline-secondary rounded px-4">
					Kembali
				</a>

				<div class="d-flex gap-2">

					<a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-app-outline-primary">
						<i class="bi bi-pencil"></i> Edit
					</a>

					<button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
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
