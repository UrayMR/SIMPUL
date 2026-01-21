@extends('layouts.app')

@section('title', $course->title ?? 'Detail Kursus')

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

	@if ($enrolled)
		{{-- Section Video --}}
		<section class="course-preview py-5 bg-white">
			<div class="container border-bottom p-5">

				{{-- ROW 1 : VIDEO + TITLE --}}
				<div class="row g-5 align-items-start">

					<!-- LEFT : VIDEO -->
					<div class="col-lg-7">
						<div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
							<iframe src="https://www.youtube.com/embed/{{ $course->video_url }}" title="Preview Kursus"
								allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
							</iframe>
						</div>
					</div>

					<!-- RIGHT : TITLE & DESCRIPTION -->
					<div class="col-lg-5">
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
						<h6 class="fw-bold mb-3 text-app-primary">
							Informasi Kursus
						</h6>
						<div class="d-flex flex-wrap gap-3 gap-lg-5">

							{{-- META GROUP 1 --}}
							<ul class="list-unstyled text-muted mb-0">
								<li class="mb-2 d-flex align-items-center text-app-primary">
									<i class="bi bi-bookmark-fill text-app-primary me-2"></i>
									{{ $course->category->name }}
								</li>

								<li class="mb-2 d-flex align-items-center text-app-primary">
									<i class="bi bi-people-fill text-app-primary me-2"></i>
									{{ $course->enrollments_count }} Terjual
								</li>
							</ul>

							{{-- META GROUP 2 --}}
							<ul class="list-unstyled text-muted mb-0">
								<li class="mb-2 d-flex align-items-center text-app-primary">
									<i class="bx bx-calendar text-app-primary me-2"></i>
									{{ $course->created_at->translatedFormat('l, d F Y H:i') }} WIB
								</li>

								<li class="d-flex align-items-center text-app-primary">
									<i class="bi bi-person-fill text-app-primary me-2"></i>
									{{ $course->teacher->user->name }}
								</li>
							</ul>

						</div>
					</div>

					<!-- RIGHT : CONTACT -->
					<div class="col-lg-5">
						<h6 class="fw-bold mb-3 text-app-primary">
							Hubungi Pengajar
						</h6>

						<div class="mb-2 d-flex align-items-center">
							<i class="bi bi-envelope-fill text-app-primary me-2"></i>
							<a href="mailto:{{ $course->teacher->user->email }}" class="text-decoration-none text-app-primary">
								{{ $course->teacher->user->email }}
							</a>
						</div>

						<div class="d-flex align-items-center">
							<i class="bi bi-whatsapp text-app-primary  me-2"></i>
							<a
								href="https://wa.me/6285335589526?text={{ urlencode('Halo, saya ingin bertanya terkait kursus ' . $course->title) }}"
								target="_blank" class="text-decoration-none  text-app-primary ">
								Chat via WhatsApp
							</a>
						</div>
					</div>

				</div>

			</div>
		</section>
	@else
		{{-- Section Class Detail --}}
		<section class="course-detail py-5 bg-white ">
			<div class="container border-bottom p-5">
				<div class="row align-items-center g-5">

					<!-- LEFT CONTENT -->
					<div class="col-lg-6">
						<h1 class="fw-bold text-app-primary mb-3">
							{{ $course->title ?? 'C++ Dasar' }}
						</h1>

						<p class="text-app-gray mb-4">
							{{ $course->description ?? 'Sebagai bahasa pemrograman yang sangat populer dan bisa diandalkan dari sisi performa, C++ banyak digunakan di berbagai industri seperti software, game development, IoT, VR, robotik, scientific computing, hingga machine learning.' }}
						</p>

						<!-- META INFO -->
						<div class="d-flex flex-wrap align-items-center gap-4 mb-4">
							<div class="d-flex align-items-center gap-1 text-app-gray">
								<i class="bi bi-bookmark-fill me-1"></i>
								<span> {{ $course->category->name }}</span>
							</div>
							<div class="d-flex align-items-center gap-1 text-app-gray">
								<i class="bi bi-people-fill me-1"></i>
								<span>0 Terjual</span>
							</div>
							<div class="d-flex align-items-center gap-1 text-app-gray">
								<i class="bx bx-calendar me-2"></i>
								{{ $course->created_at->translatedFormat('l, d F Y H:i') }} WIB
							</div>
							<div class="d-flex align-items-center gap-1 text-app-gray">
								<i class="bi bi-person-fill me-1"></i>
								<span>{{ $course->teacher->user->name }}</span>
							</div>

							<div class="d-flex align-items-center gap-1 text-app-gray">
								<i class="bi bi-cash "></i>
								<div class="course-price {{ (float) $course->price === 0.0 ? 'text-app-primary' : 'text-dark' }}">
									<span>
										{{ (float) $course->price === 0.0 ? 'GRATIS' : 'Rp ' . number_format((float) $course->price, 0, ',', '.') }}</span>
								</div>
							</div>

						</div>

						<!-- CTA -->
						<form action="{{ route('student.payment.store') }}" method="POST" class="d-inline">
							@csrf
							<input type="hidden" name="course_id" value="{{ $course->id }}">
							<button type="submit" class="btn btn-app-secondary px-4 py-2 fw-semibold rounded-3">
								Beli Kursus
							</button>
						</form>
					</div>

					<!-- RIGHT IMAGE -->
					<div class="col-lg-6 text-center">
						<div class="course-banner shadow-sm rounded-4 overflow-hidden">
							<img src="{{ asset('storage/' . ($course->hero_path ?? '')) }}" alt="{{ $course->title ?? 'Course Image' }}"
								class="img-fluid w-100">
						</div>
					</div>

				</div>
			</div>
		</section>
	@endif

	{{-- Section Teacher Profile --}}
	<section class="teacher-profile py-5 bg-white pt-0">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-12">
					<h4 class="fw-bold text-app-gray mb-4 text-center">
						Tentang Pengajar
					</h4>
					<div class="card teacher-card shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex flex-column flex-md-row gap-4">
								<!-- AVATAR -->
								<div class="teacher-avatar-wrapper d-flex justify-content-center justify-content-md-start">
									<div class="teacher-avatar">
										<img src="{{ asset('storage/' . ($course->teacher->profile_picture_path ?? '')) }}"
											alt="{{ $course->teacher->user->name }}">
									</div>
								</div>

								<!-- INFO -->
								<div class="flex-grow-1">

									<div class="d-flex align-items-center gap-2 mb-2">
										<div class="teacher-name text-app-gray">
											{{ $course->teacher->user->name }}
										</div>

										@if ($course->teacher->approved_at)
											<span class="badge bg-success teacher-badge">
												Terverifikasi
											</span>
										@endif
									</div>

									<div class="teacher-meta mb-1">
										<span>
											<i class="bi bi-award"></i>
											Keahlian: {{ $course->teacher->expertise }}
										</span>
									</div>
									<div class="teacher-bio mb-0">
										<span>
											{{-- <i class="bi bi-award"></i> --}}
											Biografi: {{ $course->teacher->bio }}
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
