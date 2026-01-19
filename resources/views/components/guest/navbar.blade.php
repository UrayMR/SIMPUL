<style>
    :root {
        --primary: #008080;
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
        }
    }

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
        background-color: #E9F5F4 !important;
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
            transition: transform .25s ease, opacity .25s ease;
        }
    }
</style>

@php
    $profilePhotoUrl = null;
    if (auth()->check()) {
        $profilePhoto = auth()->user()->profile_photo_path;
        if ($profilePhoto) {
            $profilePhotoPath = public_path('storage/' . $profilePhoto);
            if (file_exists($profilePhotoPath)) {
                $profilePhotoUrl = asset('storage/' . $profilePhoto);
            }
        }
        $nameParts = preg_split('/\s+/', trim(auth()->user()->name));
        $initials = strtoupper(collect($nameParts)->filter()->map(fn($p) => mb_substr($p, 0, 1))->take(2)->implode(''));
    }
@endphp

@php
    $isLayananActive =
        request()->is('layanan') ||
        request()->is('user/perbulan*') ||
        request()->is('user/persemester*') ||
        request()->is('user/pertahun*') ||
        request()->is('user/pendataan-gereja*');
@endphp

<nav class="navbar navbar-expand-lg smart-navbar show py-3">
    <div class="container">

        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLanding">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo Mobile -->
        <a class="navbar-brand mobile-logo d-lg-none" href="/">
            <img src="{{ asset('assets/img/logo.png') }}" height="34">
        </a>

        <!-- Logo Desktop -->
        <a class="navbar-brand d-none d-lg-flex align-items-center gap-2" href="/">
            <img src="{{ asset('assets/img/logo.png') }}" height="34">
            <span class="fw-bold fs-5 text-primary">SILAYANKRIS</span>
        </a>

        <!-- Mobile Profile -->
        @auth
            <div class="nav-profile-mobile d-lg-none">
                <div class="dropdown">
                    <a data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            @if (!empty($profilePhotoUrl))
                                <img src="{{ $profilePhotoUrl }}" class="rounded-circle"
                                    style="width:40px;height:40px;object-fit:cover;">
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
                            @if (!empty($profilePhotoUrl))
                                <img src="{{ $profilePhotoUrl }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center rounded-circle text-white"
                                    style="width:42px;height:42px;font-weight:600;background: var(--primary);">
                                    {{ $initials ?? 'U' }}
                                </div>
                            @endif
                            <div>
                                <strong>{{ auth()->user()->name }}</strong>
                                <div style="font-size: 0.8rem; color:#777;">
                                    {{ auth()->user()->role }}
                                </div>
                            </div>
                        </li>

                        <li><a class="dropdown-item dropdown-user-item" href="{{ route('user.settings.index') }}"><i
                                    class="bx bx-cog"></i>
                                Pengaturan Akun</a></li>
                        <li><a class="dropdown-item dropdown-user-item text-danger" href="{{ route('logout') }}">
                                <i class="bx bx-power-off"></i> Keluar</a>
                        </li>
                    </ul>
                </div>
            </div>
        @endauth

        <!-- Menu -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarLanding">

            <ul class="navbar-nav ms-lg-4 gap-lg-4">

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('berita*') ? 'active' : '' }}" href="/berita">Berita</a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ $isLayananActive ? 'active' : '' }}" href="/layanan">Layanan</a>
                    </li>
                @endguest

                @auth
                    @if (auth()->user()->role == 'guru' || auth()->user()->role == 'staff-gereja')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ $isLayananActive ? 'active' : '' }}"
                                data-bs-toggle="dropdown">Layanan</a>
                            <ul class="dropdown-menu">
                                @if (auth()->user()->role == 'guru')
                                    <li><a class="dropdown-item" href="{{ route('user.perbulan.index') }}">Upload Berkas
                                            Per-bulan</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.persemester.index') }}">Upload Berkas
                                            Per-semester</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.pertahun.index') }}">Upload Berkas
                                            Per-tahun</a></li>
                                @endif

                                @if (auth()->user()->role == 'staff-gereja')
                                    <li><a class="dropdown-item" href="/user/pendataan-gereja">Pendataan Gereja</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                                href="/admin/dashboard">Dashboard</a>
                        </li>
                    @endif
                @endauth

                @auth
                    <li class="nav-item dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                            <div class="avatar avatar-online me-2">
                                @if (!empty($profilePhotoUrl))
                                    <img src="{{ $profilePhotoUrl }}" class="rounded-circle"
                                        style="width:40px;height:40px;object-fit:cover;">
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
                                @if (!empty($profilePhotoUrl))
                                    <img src="{{ $profilePhotoUrl }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded-circle text-white"
                                        style="width:42px;height:42px;font-weight:600;background: var(--primary);">
                                        {{ $initials ?? 'U' }}
                                    </div>
                                @endif
                                <div>
                                    <strong>{{ auth()->user()->name }}</strong>
                                    <div style="font-size: 0.8rem; color:#777;">{{ auth()->user()->role }}</div>
                                </div>
                            </li>

                            <li><a class="dropdown-item dropdown-user-item" href="{{ route('user.settings.index') }}"><i
                                        class="bx bx-cog"></i>
                                    Pengaturan Akun</a></li>
                            <li><a class="dropdown-item dropdown-user-item text-danger" href="{{ route('logout') }}"><i
                                        class="bx bx-power-off"></i> Keluar</a></li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <a href="/login" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold mt-3 mt-lg-0">Masuk</a>
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
</script>
