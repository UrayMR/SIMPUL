<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link d-flex align-items-center text-decoration-none">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo"
                    style="height: 32px; width: auto; object-fit: contain;" alt="Logo">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2 fs-5"
                style="text-transform: none">SILAYANKRIS</span>
        </a>

        <a href="" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none  sidebar-toggle">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner">
        <ul class="menu-inner py-1 flex-grow-1">
            <!-- Dashboard -->
            <li class="menu-item {{ request()->is(ltrim('admin/dashboard', '/')) ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bi bi-speedometer2"></i>
                    <div>Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is(ltrim('home', '/')) ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div>Halaman Utama</div>
                </a>
            </li>

            <!-- Master Data -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Master Data</span>
            </li>

            <li class="menu-item {{ request()->is(ltrim('admin/users*', '/')) ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div>Data Pengguna</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is(ltrim('admin/sekolah*', '/')) ? 'active' : '' }}">
                <a href="{{ route('admin.sekolah.index') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bx bx-building"></i>
                    <div>Data Sekolah</div>
                </a>
            </li>

            <!-- Master Data -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pendataan</span>
            </li>

            <li class="menu-item {{ request()->is(ltrim('admin/berita*', '/')) ? 'active' : '' }}">
                <a href="{{ route('admin.berita.index') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bx bx-news"></i>
                    <div>Data Berita</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is(ltrim('admin/gereja*', '/')) ? 'active' : '' }}">
                <a href="{{ route('admin.gereja.index') }}" class="menu-link text-decoration-none">
                    <i class="menu-icon tf-icons bi bi-hospital"></i>
                    <div>Data Gereja</div>
                </a>
            </li>
            <li
                class="menu-item {{ request()->is('admin/per-bulan*') || request()->is('admin/per-semester*') || request()->is('admin/per-tahun*') ? 'open' : '' }}">
                <a href="" class="menu-link menu-toggle text-decoration-none">
                    <i class="menu-icon tf-icons bx bx-folder"></i>
                    <div data-i18n="Berkas TPG Guru">Berkas TPG Guru</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('admin/per-bulan*') ? 'active' : '' }}">
                        <a href="{{ route('admin.per-bulan.index') }}" class="menu-link text-decoration-none">
                            <div>Perbulan</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/per-semester*') ? 'active' : '' }}">
                        <a href="{{ route('admin.per-semester.index') }}" class="menu-link text-decoration-none">
                            <div>Persemester</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/per-tahun*') ? 'active' : '' }}">
                        <a href="{{ route('admin.per-tahun.index') }}" class="menu-link text-decoration-none">
                            <div>Pertahun</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- PROFIL PENGGUNA -->
            {{-- <div class="menu-footer w-100 border-top p-3 mt-auto">
			<div class="d-flex align-items-center">
				<div class="avatar flex-shrink-0 me-3">
					<span class="avatar-initial rounded-circle bg-primary text-white fw-bold">
						{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
					</span>
				</div>
				<div class="d-flex flex-column">
					<span class="fw-semibold">{{ Auth::user()->name ?? 'Admin' }}</span>
					<small class="text-muted">{{ Auth::user()->role ?? 'Administrator' }}</small>
				</div>
			</div>
		</div> --}}
        </ul>
    </div>

</aside>