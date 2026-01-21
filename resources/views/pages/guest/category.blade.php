@extends('layouts.app')

@section('title', 'Kategori Kursus')

@section('content')
	{{-- STYLE --}}
	<style>
		.category-card {
			transition: all 0.3s ease;
		}

		.category-card:hover {
			transform: translateY(-6px);
			box-shadow: 0 16px 30px rgba(0, 0, 0, 0.12);
		}

		.icon-wrapper {
			width: 60px;
			height: 60px;
			background: rgba(0, 81, 128, 0.1);
			color: #3b82f6;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-inline: auto;
			font-size: 1.5rem;
		}
	</style>
	{{-- HERO --}}
	<section class="bg-app-primary text-white py-5">
		<div class="container text-center">
			<h1 class="fw-bold mb-2 text-white">
				Kategori Kursus
			</h1>
			<p class="opacity-75 mb-0">
				Jelajahi kursus berdasarkan bidang dan minatmu
			</p>
		</div>
	</section>

	{{-- CATEGORY LIST --}}
	<section class="py-5 bg-light">
		<div class="container">

			<div class="row g-4">
				@forelse ($categories as $category)
					<div class="col-6 col-md-4 col-lg-3">

						<a href="{{ route('course.index', ['categories[]' => $category->id]) }}" class="text-decoration-none">

							<div class="card border-0 shadow-sm rounded-4 h-100 category-card">
								<div class="card-body text-center p-4">

									{{-- ICON --}}
									<div class="icon-wrapper mb-3">
										<i class="bi bi-grid-fill"></i>
									</div>

									{{-- NAME --}}
									<h6 class="fw-bold text-dark mb-1">
										{{ $category->name }}
									</h6>

									{{-- COUNT --}}
									<div class="text-muted small">
										{{ $category->courses_count ?? 0 }} Kursus
									</div>

								</div>
							</div>

						</a>

					</div>
				@empty
					<div class="col-12 text-center">
						<p class="text-muted">
							Belum ada kategori tersedia.
						</p>
					</div>
				@endforelse
			</div>

		</div>
	</section>

@endsection
