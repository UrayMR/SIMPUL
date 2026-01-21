@extends('layouts.app')

@section('title', $course->title ?? 'Detail Kursus Saya')

@section('content')
	<style>
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
					<form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" class="d-inline"
						onsubmit="return confirm('Yakin ingin menghapus kursus ini?')">
						@csrf
						@method('DELETE')
						<button class="btn btn-outline-danger fw-semibold"><i class="bi bi-trash"></i> Hapus</button>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection
