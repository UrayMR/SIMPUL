<style>
	:root {
		--primary: #1E3A8A;
	}

	/* Kompensasi untuk fixed navbar */
	body {
		padding-top: 72px;
	}

	@media (max-width: 991px) {
		body {
			padding-top: 60px;
		}
	}

	/* ===== NAVLINK Hover + Active ===== */
	.navbar .nav-link {
		color: #555;
		padding-bottom: 4px;
		border-bottom: 2px solid transparent;
		transition: .2s ease;
	}

	.navbar .nav-link:hover,
	.navbar .nav-link.active {
		color: var(--primary) !important;
		border-bottom-color: var(--primary);
	}

	.navbar .nav-link.profile-dropdown:hover,
	.navbar .nav-link.profile-dropdown.active {
		border-bottom-color: transparent !important;
	}

	.dropdown-toggle:hover::after {
		background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' fill='none' stroke='%23333' stroke-width='2' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4 6l4 4 4-4' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") !important;
	}

	/* ===== MOBILE FIX ===== */
	@media (max-width: 991px) {
		.navbar {
			height: 60px;
		}

		.navbar-toggler {
			position: absolute;
			left: 10px;
			top: 50%;
			transform: translateY(-50%);
		}

		.mobile-logo {
			position: absolute;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
		}

		.nav-profile-mobile {
			position: absolute;
			right: 10px;
			top: 50%;
			transform: translateY(-50%);
		}

		.navbar-collapse {
			background: white;
			padding: 15px;
			z-index: 10;
			max-height: 0;
			overflow: hidden;
			opacity: 0;
			transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1);
		}

		.navbar-collapse.show-animated {
			max-height: 1000px;
			opacity: 1;
			transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1);
		}
	}

	/* ===== TOGGLER COLOR (use brand primary) ===== */
	/* .navbar-toggler {
								border-color: var(--primary);
				}
				.navbar-toggler-icon {
								background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath stroke='%231E3A8A' stroke-linecap='round' stroke-width='2' d='M2 4.5h12M2 8.5h12M2 12.5h12'/%3E%3C/svg%3E");
				} */
	/* USER DROPDOWN */
	.dropdown-user-menu {
		min-width: 240px;
		border-radius: 14px !important;
		padding: 0 !important;
		overflow: hidden;
	}

	.dropdown-user-header {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 12px 16px;
		background: #f8f9fa;
	}

	.dropdown-user-header img,
	.dropdown-user-header>div:first-child {
		width: 42px;
		height: 42px;
		border-radius: 50%;
		object-fit: cover;
		flex-shrink: 0;
	}

	.dropdown-user-item {
		padding: 10px 16px !important;
		display: flex !important;
		gap: 10px;
		font-size: 0.92rem;
		align-items: center;
	}

	.dropdown-user-item:hover {
		background: #E9F5F4 !important;
		color: var(--primary) !important;
	}

	/* ===== DROPDOWN MENU STYLING ===== */
	.dropdown-menu {
		border-radius: 8px !important;
		border: none !important;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
		background-color: white !important;
		padding: 6px !important;
	}

	.dropdown-menu .dropdown-item {
		color: #555 !important;
		padding: 10px 16px !important;
		transition: all .2s ease;
		background-color: transparent !important;
		border-radius: 6px !important;
		margin-bottom: 2px;
	}

	.dropdown-menu .dropdown-item:last-child {
		margin-bottom: 0;
	}

	.dropdown-menu .dropdown-item:hover,
	.dropdown-menu .dropdown-item:focus,
	.dropdown-menu .dropdown-item.active {
		background-color: #c1d9ff !important;
		color: var(--primary) !important;
	}

	/* ===== SMART NAVBAR FINAL VERSION ===== */
	.smart-navbar {
		position: fixed !important;
		/* stabil */
		top: 0;
		left: 0;
		width: 100%;
		z-index: 9999;
		transition: transform .35s ease, opacity .35s ease, box-shadow .35s ease;
		background: white;
		box-shadow: 0 4px 12px rgba(140, 193, 193, 0.15) !important;
	}

	.smart-navbar.scrolled {
		box-shadow: 0 3px 12px rgba(140, 193, 193, 0.10) !important;
	}

	.smart-navbar.hide {
		transform: translateY(-100%);
		opacity: 0;
	}

	.smart-navbar.show {
		transform: translateY(0);
		opacity: 1;
	}

	/* FIX MOBILE COLLAPSE */
	@media (max-width: 991px) {

		/* collapse menjadi panel di bawah navbar */
		.navbar-collapse {
			position: fixed !important;
			top: 60px;
			left: 0;
			width: 100%;
			background: #fff;
			padding: 20px;
			z-index: 998;
			height: auto;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
		}

		/* AGAR HAMBURGER SELALU TERLIHAT */
		.navbar-toggler {
			z-index: 9999 !important;
		}
	}

	@media (max-width: 991px) {
		.navbar-collapse {
			/* transition handled above for max-height and opacity */
		}
	}
</style>

@php
	$profilePicture = null;
	$initials = null;
	if (auth()->check()) {
	    $user = auth()->user();
	    $nameParts = preg_split('/\s+/', trim($user->name));
	    $initials = strtoupper(collect($nameParts)->filter()->map(fn($p) => mb_substr($p, 0, 1))->take(2)->implode(''));

	    if ($user->role === 'teacher' && $user->teacher && !empty($user->teacher->profile_picture_path)) {
	        $teacherPicturePath = $user->teacher->profile_picture_path;
	        if (file_exists(storage_path('app/public/' . $teacherPicturePath))) {
	            $profilePicture = asset('storage/' . $teacherPicturePath);
	        }
	    }
	}
@endphp

<nav class="navbar navbar-expand-lg smart-navbar show py-3">
	<div class="container">

		<!-- Toggle -->
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLanding">
			<i class="bi bi-list fs-3 text-app-primary"></i>
		</button>

		<!-- Logo Mobile -->
		<a class="navbar-brand mobile-logo d-lg-none" href="/">
			<img src="{{ asset('assets/img/logo/Logo Simpul.svg') }}" height="46">
		</a>

		<!-- Logo Desktop -->
		<a class="navbar-brand d-none d-lg-flex align-items-center gap-2" href="/">
			<img src="{{ asset('assets/img/logo/Logo Simpul.svg') }}" height="46">
			<span class="fw-bold fs-5 text-app-primary">SIMPUL</span>
		</a>

		<!-- Mobile Profile -->
		@auth
			<div class="nav-profile-mobile d-lg-none">
				<div class="dropdown">
					<a data-bs-toggle="dropdown">
						<div class="avatar avatar-online">
							@if (!empty($profilePicture))
								<img src="{{ $profilePicture }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
							@else
								<div class="d-flex align-items-center justify-content-center rounded-circle text-white"
									style="width:40px;height:40px;font-weight:600;background: var(--primary);">
									{{ $initials ?? 'U' }}
								</div>
							@endif
						</div>
					</a>

					<ul class="dropdown-menu dropdown-menu-end dropdown-user-menu shadow">
						<li class="dropdown-user-header">
							@if (!empty($profilePicture))
								<img src="{{ $profilePicture }}">
							@else
								<div class="d-flex align-items-center justify-content-center rounded-circle text-white"
									style="width:42px;height:42px;font-weight:600;background: var(--primary);">
									{{ $initials ?? 'U' }}
								</div>
							@endif
							<div>
								<strong>{{ auth()->user()->name }}</strong>
								<div style="font-size: 0.8rem; color:#777;">
									{{ auth()->user()->email }}
								</div>
							</div>
						</li>
						@auth
							@if (auth()->user()->role === 'admin')
								<li><a class="dropdown-item dropdown-user-item" href="{{ route('admin.dashboard') }}">

										<i class="bi bi-speedometer2"></i> Kembali ke Dashboard</a></li>
							@endif
						@endauth
						<li><a class="dropdown-item dropdown-user-item"
								href="{{ route('course.index', ['search' => '', 'sort_price' => '', 'ownership' => true]) }}">
								<i class="bi bi-book"></i> Kursus Saya</a></li>
						<li><a class="dropdown-item dropdown-user-item" href="{{ route('history.index') }}">
								<i class="bi bi-receipt"></i> Riwayat Transaksi</a></li>
						<li><a class="dropdown-item dropdown-user-item" href="{{ route('settings.index') }}"><i class="bx bx-cog"></i>
								Pengaturan Akun</a></li>
						<li><a class="dropdown-item dropdown-user-item text-danger" href="{{ route('logout') }}">
								<i class="bx bx-power-off"></i> Keluar</a>
						</li>
					</ul>
				</div>
			</div>
		@endauth

		<!-- Menu -->
		<div class="collapse navbar-collapse" id="navbarLanding">

			<!-- ===== MENU TENGAH ===== -->
			<ul class="navbar-nav mx-auto gap-lg-4 align-items-lg-center">

				<li class="nav-item">
					<a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route(name: 'beranda') }}">Beranda</a>
				</li>

				<li class="nav-item">
					<a class="nav-link {{ request()->is('kursus*') ? 'active' : '' }}" href="{{ route('course.index') }}">Kursus</a>
				</li>

				<li class="nav-item">
					<a class="nav-link {{ request()->is(patterns: 'lowongan-karir') ? 'active' : '' }}"
						href="{{ route('lowongan-karir.index') }}">Lowongan Karir</a>
				</li>
				@auth
					@if (auth()->user()->role === 'teacher')
						<li class="nav-item">
							<a class="nav-link {{ request()->is(patterns: 'pengajar/kursus*') ? 'active' : '' }}"
								href="{{ route('teacher.courses.index') }}">Kelola Kursus</a>
						</li>
					@endif
				@endauth

			</ul>

			<!-- ===== RIGHT ACTION (LOGIN / PROFILE) ===== -->
			<ul class="navbar-nav align-items-lg-center gap-3">

				@auth
					<li class="nav-item dropdown d-none d-lg-block">
						<a class="nav-link dropdown-toggle d-flex align-items-center profile-dropdown" data-bs-toggle="dropdown">
							<div class="avatar avatar-online">
								@if (!empty($profilePicture))
									<img src="{{ $profilePicture }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
								@else
									<div class="d-flex align-items-center justify-content-center rounded-circle text-white"
										style="width:40px;height:40px;font-weight:600;background: var(--primary);">
										{{ $initials ?? 'U' }}
									</div>
								@endif
							</div>
						</a>

						<ul class="dropdown-menu dropdown-menu-end dropdown-user-menu shadow">
							<li class="dropdown-user-header d-flex flex-column" style="gap: 1px; align-items: start;">
								<strong>{{ auth()->user()->name }}</strong>
								<div style="font-size: 0.8rem; color:#777;">{{ auth()->user()->email }}</div>
							</li>
							@auth
								@if (auth()->user()->role === 'admin')
									<li><a class="dropdown-item dropdown-user-item" href="{{ route('admin.dashboard') }}">
											<i class="bi bi-speedometer2"></i> Kembali ke Dashboard</a></li>
								@endif
							@endauth

							<li><a class="dropdown-item dropdown-user-item"
									href="{{ route('course.index', ['search' => '', 'sort_price' => '', 'ownership' => true]) }}">
									<i class="bi bi-book"></i> Kursus Saya</a></li>
							<li><a class="dropdown-item dropdown-user-item" href="{{ route('history.index') }}">
									<i class="bi bi-receipt"></i> Riwayat Transaksi</a></li>
							<li><a class="dropdown-item dropdown-user-item" href="{{ route('settings.index') }}">
									<i class="bx bx-cog"></i> Pengaturan Akun</a></li>
							<li><a class="dropdown-item dropdown-user-item text-danger" href="{{ route('logout') }}">
									<i class="bx bx-power-off"></i> Keluar</a></li>
						</ul>
					</li>
				@endauth

				@guest
					<li class="nav-item">
						<a href="{{ route('login') }}"
							class="btn btn-app-primary w-100 w-lg-auto px-4 py-2 rounded-3 fw-semibold mt-3 mt-lg-0 text-center">
							Masuk
						</a>

					</li>
				@endguest

			</ul>

		</div>

	</div>
</nav>

<script>
	const navbar = document.querySelector(".smart-navbar");
	let lastScroll = 0;
	let scrollTimeout = null;

	window.addEventListener("scroll", () => {
		const currentScroll = window.pageYOffset;

		// Tambah shadow
		if (currentScroll > 10) {
			navbar.classList.add("scrolled");
		} else {
			navbar.classList.remove("scrolled");
		}

		// Sembunyikan ketika scroll turun
		if (currentScroll > lastScroll && currentScroll > 80) {
			navbar.classList.add("hide");
			navbar.classList.remove("show");
		} else {
			navbar.classList.add("show");
			navbar.classList.remove("hide");
		}

		lastScroll = currentScroll;

		// Tampilkan kembali jika user berhenti scroll
		clearTimeout(scrollTimeout);
		scrollTimeout = setTimeout(() => {
			navbar.classList.add("show");
			navbar.classList.remove("hide");
		}, 200);
	});
	// Navbar collapse animation for mobile
	document.addEventListener('DOMContentLoaded', function() {
		const collapse = document.getElementById('navbarLanding');
		if (!collapse) return;

		// Helper to set max-height dynamically for smooth open
		function setMaxHeight() {
			if (window.innerWidth > 991) return;
			collapse.style.maxHeight = collapse.scrollHeight + 'px';
		}

		function resetMaxHeight() {
			if (window.innerWidth > 991) return;
			collapse.style.maxHeight = '';
		}

		// Listen for Bootstrap collapse events
		collapse.addEventListener('show.bs.collapse', function() {
			if (window.innerWidth <= 991) {
				collapse.classList.add('show-animated');
				setTimeout(setMaxHeight, 10); // allow class to apply first
			}
		});
		collapse.addEventListener('shown.bs.collapse', function() {
			if (window.innerWidth <= 991) {
				setMaxHeight();
			}
		});
		collapse.addEventListener('hide.bs.collapse', function() {
			if (window.innerWidth <= 991) {
				// animate close by setting max-height to 0
				collapse.style.maxHeight = collapse.scrollHeight + 'px';
				setTimeout(() => {
					collapse.style.maxHeight = '0px';
				}, 10);
				collapse.classList.remove('show-animated');
			}
		});
		collapse.addEventListener('hidden.bs.collapse', function() {
			if (window.innerWidth <= 991) {
				resetMaxHeight();
			}
		});
		// If already open on load (e.g. after resize), ensure class is set
		if (collapse.classList.contains('show') && window.innerWidth <= 991) {
			collapse.classList.add('show-animated');
			setMaxHeight();
		}
		// Reset max-height on window resize
		window.addEventListener('resize', function() {
			if (window.innerWidth > 991) {
				resetMaxHeight();
			} else if (collapse.classList.contains('show')) {
				setMaxHeight();
			}
		});
	});
</script>
