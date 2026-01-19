<style>
    :root {
        --primary: #008080;
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

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <!-- Toggle Sidebar (tampil hanya di layar kecil) -->

    <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none ">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm  mt-2"></i>
            </a>
        </div>
        <!-- BREADCRUMB -->
        <div class="d-flex align-items-center flex-grow-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">

                    {{-- Breadcrumb berikutnya dari halaman --}}
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>

        <!-- User Dropdown -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
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

                    <li><a class="dropdown-item dropdown-user-item" href="{{ route('admin.settings.index') }}"><i class="bx bx-cog"></i>Pengaturan
                            Akun</a>
                    </li>
                    <li><a class="dropdown-item dropdown-user-item text-danger" href="{{ route('logout') }}">
                            <i class="bx bx-power-off"></i> Keluar</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
