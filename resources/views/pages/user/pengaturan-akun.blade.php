@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')

    <style>
        :root {
            --primary: #008080;
            --light-teal: #e9f5f4;
        }

        .settings-wrapper {
            padding: 50px 0;
            background: #f8f9fa;
            min-height: calc(100vh - 72px);
        }

        /* HEADER SECTION */
        .settings-header {
            background: white;
            padding: 40px 0;
            margin-bottom: 40px;
            border-bottom: 1px solid #e0e0e0;
        }

        .settings-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #222;
            margin: 0 0 10px 0;
        }

        .settings-header p {
            color: #999;
            font-size: 15px;
            margin: 0;
        }

        /* TAB NAVIGATION */
        .settings-tabs {
            display: flex;
            gap: 0;
            background: white;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 40px;
        }

        .settings-tabs a {
            padding: 18px 24px;
            color: #555;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            border-bottom: 3px solid transparent;
            transition: all .3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .settings-tabs a:hover {
            color: var(--primary);
            background: var(--light-teal);
        }

        .settings-tabs a.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
            background: var(--light-teal);
        }

        /* CONTENT CARD */
        .settings-card {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
        }

        .form-section-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        /* FORM ELEMENTS */
        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control,
        .form-select {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 11px 12px;
            font-size: 14px;
            transition: all .3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 128, 128, 0.1);
        }

        .form-control[readonly] {
            background: #f8f9fa;
            color: #666;
            cursor: not-allowed;
            border-color: #e0e0e0;
        }

        /* PHOTO UPLOAD */
        .photo-upload-box {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .photo-preview {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-upload-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        /* BUTTON STYLES */
        .btn {
            border: none;
            border-radius: 6px;
            padding: 11px 24px;
            font-weight: 600;
            transition: all .3s ease;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: #006b6b;
        }

        .btn-secondary {
            background: #e9ecef;
            color: #555;
        }

        .btn-secondary:hover {
            background: #dee2e6;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        /* FORM ROWS */
        .form-row {
            margin-bottom: 20px;
        }

        .form-row.row {
            margin-bottom: 25px;
        }

        @media (max-width: 768px) {
            .settings-wrapper {
                padding: 30px 0;
            }

            .settings-header h1 {
                font-size: 24px;
            }

            .settings-card {
                padding: 25px;
            }

            .settings-tabs {
                gap: 10px;
                overflow-x: auto;
            }

            .settings-tabs a {
                padding: 15px 16px;
                font-size: 13px;
                white-space: nowrap;
            }

            .photo-preview {
                width: 120px;
                height: 120px;
                font-size: 36px !important;
            }
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 40px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
            font-size: 20px;
        }

        .toggle-password:hover {
            color: var(--primary);
        }
    </style>

    <!-- Breadcrumb -->
    <div class="container-fluid pt-3 text-dark border-bottom">
        <div class="container pb-3">
            <a href="/home" class="text-dark text-decoration-none">Home</a>
            <span class="mx-2">></span>
            <a href="#" class="text-dark text-decoration-none">Pengaturan Akun</a>
        </div>
    </div>

    <!-- Header -->
    <div class="container-fluid py-4 bg-primary text-light">
        <div class="container">
            <h1 class="fw-bold mb-0">Pengaturan Akun</h1>
            <p class="mb-0">Lihat detail profil Anda dan ubah password untuk keamanan akun.</p>
        </div>
    </div>


    <div class="settings-wrapper">
        <div class="container my-4">

            <div class="card shadow-sm border-0 p-4">

                {{-- HEADER SMALL --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold">Pengaturan Akun</h4>
                </div>

                {{-- TAB --}}
                <div class="settings-tabs mb-4">
                    <a href="?tab=profile"
                        class="settings-tabs-item {{ request('tab', 'profile') == 'profile' ? 'active' : '' }}">
                        <i class="bx bx-user"></i> Profil Pengguna
                    </a>

                    <a href="?tab=password" class="settings-tabs-item {{ request('tab') == 'password' ? 'active' : '' }}">
                        <i class="bx bx-lock"></i> Ubah Password
                    </a>
                </div>

                {{-- TAB PROFIL --}}
                @if (request('tab', 'profile') == 'profile')

                    <div class="row">
                        {{-- FOTO PROFIL KIRI --}}
                        <div class="col-md-3 text-center mb-4">

                            @php
                                $photoPath = null;
                                if (auth()->user()->profile_photo_path) {
                                    $fullPath = public_path('storage/' . auth()->user()->profile_photo_path);
                                    if (file_exists($fullPath)) {
                                        $photoPath = asset('storage/' . auth()->user()->profile_photo_path);
                                    }
                                }

                                // Inisial jika tidak ada foto
                                $nameParts = explode(' ', auth()->user()->name);
                                $initials = strtoupper(
                                    substr($nameParts[0], 0, 1) .
                                        (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''),
                                );
                            @endphp

                            <form action="{{ route('user.settings.update-photo') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="photo-upload-box">

                                    @if ($photoPath)
                                        <img id="photoPreview" src="{{ $photoPath }}"
                                            class="img-thumbnail rounded shadow-sm"
                                            style="width: 150px; height: 200px; object-fit: cover; margin-bottom: 15px;">
                                    @else
                                        <div id="photoPreview"
                                            class="rounded shadow-sm d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 150px; height: 200px; background:#008080; color:white; font-size:48px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                            {{ $initials }}
                                        </div>
                                    @endif

                                    <div class="photo-upload-text mt-2 mb-2">Ubah Foto Profil</div>

                                    <input type="file" id="photoInput" name="profile_photo" accept="image/*"
                                        class="d-none" onchange="previewPhoto(event)">

                                    <div class="d-flex justify-content-center gap-2 mt-2">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            onclick="document.getElementById('photoInput').click()">
                                            <i class="bx bx-upload"></i> Pilih Foto
                                        </button>

                                        <button type="submit" class="btn btn-primary btn-sm" id="saveFotoBtn"
                                            style="display:none;">
                                            <i class="bx bx-save"></i> Simpan
                                        </button>
                                    </div>

                                    <div id="photoError" class="text-danger small mt-2 text-center" style="display:none;">
                                        <i class="bx bx-error-circle"></i> <span id="photoErrorMsg"></span>
                                    </div>

                                    @error('profile_photo')
                                        <div class="text-danger small mt-2 text-center">
                                            <i class="bx bx-error-circle"></i> {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </form>

                        </div>

                        {{-- DATA PROFIL KANAN --}}
                        <div class="col-md-9">
                            <div class="form-section-title">Informasi Akun</div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control"
                                        value="{{ auth()->user()->nomor_telepon ?? '-' }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Peran</label>
                                    <input type="text" class="form-control"
                                        value="{{ ucfirst(str_replace('-', ' ', auth()->user()->role)) }}" readonly>
                                </div>
                            </div>

                            {{-- INFORMASI GURU --}}
                            @php $guru = auth()->user()->role === 'guru' ? auth()->user()->guru : null; @endphp

                            @if ($guru)
                                <hr>
                                <div class="form-section-title">Informasi Guru</div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">NIK</label>
                                        <input type="text" class="form-control" value="{{ $guru->nik }}" readonly>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" value="{{ $guru->tempat_lahir }}"
                                            readonly>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="text" class="form-control"
                                            value="{{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d F Y') : '-' }}"
                                            readonly>
                                    </div>
                                </div>

                                <label class="form-label">Asal Sekolah Induk</label>
                                @forelse ($guru->sekolah as $sekolah)
                                    <input type="text" class="form-control mb-2" value="{{ $sekolah->nama }}"
                                        readonly>
                                @empty
                                    <input type="text" class="form-control" value="-" readonly>
                                @endforelse

                            @endif

                            {{-- INFORMASI GEREJA --}}
                            @php $staff = auth()->user()->role === 'staff-gereja' ? auth()->user()->staffGereja : null; @endphp

                            @if ($staff && $staff->gereja)
                                <hr>

                                <h5 class="fw-bold mb-3">Informasi Gereja</h5>

                                <label class="form-label">Nama Gereja</label>
                                <input type="text" class="form-control" value="{{ $staff->gereja->nama }}" readonly>
                            @endif

                        </div>
                    </div>
            </div>

            @endif



            {{-- TAB 2: UBAH PASSWORD --}}
            @if (request('tab') == 'password')
                <div class="settings-card">

                    <div class="form-section-title">Ubah Password</div>

                    <form action="{{ route('user.settings.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <label class="form-label">Password Lama</label>
                            <div class="password-wrapper">
                                <input type="password" id="old_password" name="old_password"
                                    class="form-control @error('old_password') is-invalid @enderror"
                                    placeholder="Masukkan password lama" required>
                                <span class="toggle-password" data-target="old_password">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
                            @error('old_password')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <label class="form-label">Password Baru</label>
                            <div class="password-wrapper">
                                <input type="password" id="new_password" name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror"
                                    placeholder="Masukkan password baru (minimal 8 karakter dengan huruf besar, huruf kecil, dan angka)"
                                    required>
                                <span class="toggle-password" data-target="new_password">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <div class="password-wrapper">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                    class="form-control" placeholder="Ulangi password baru" required>
                                <span class="toggle-password" data-target="new_password_confirmation">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Simpan Password
                            </button>
                        </div>
                    </form>

                </div>
            @endif

        </div>


        <script>
            function previewPhoto(event) {
                const file = event.target.files[0];
                const photoError = document.getElementById('photoError');
                const photoErrorMsg = document.getElementById('photoErrorMsg');

                if (!file) return;

                // Validasi tipe file
                if (!file.type.startsWith('image/')) {
                    photoErrorMsg.textContent = 'Format file harus berupa gambar (jpg, jpeg, png)';
                    photoError.style.display = 'block';
                    event.target.value = '';
                    return;
                }

                // Validasi ukuran file (2MB = 2097152 bytes)
                if (file.size > 2097152) {
                    photoErrorMsg.textContent = 'Ukuran file maksimal adalah 2MB. File Anda berukuran ' + (file.size / 1048576)
                        .toFixed(2) + 'MB';
                    photoError.style.display = 'block';
                    event.target.value = '';
                    return;
                }

                // Jika valid, sembunyikan error message
                photoError.style.display = 'none';

                const reader = new FileReader();
                reader.onload = (e) => {
                    const preview = document.getElementById('photoPreview');

                    // Jika masih div inisial, ganti dengan img
                    if (preview.tagName === 'DIV') {
                        const newImg = document.createElement('img');
                        newImg.id = 'photoPreview';
                        newImg.className = 'photo-preview';
                        newImg.alt = 'Profile Photo';
                        preview.parentNode.replaceChild(newImg, preview);
                        document.getElementById('photoPreview').src = e.target.result;
                    } else {
                        preview.src = e.target.result;
                    }

                    document.getElementById('saveFotoBtn').style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            }
        </script>

        <script>
            document.querySelectorAll('.toggle-password').forEach(btn => {
                btn.addEventListener('click', function() {
                    const target = document.getElementById(this.dataset.target);

                    if (target.type === "password") {
                        target.type = "text";
                        this.innerHTML = `<i class="bx bx-show"></i>`;
                    } else {
                        target.type = "password";
                        this.innerHTML = `<i class="bx bx-hide"></i>`;
                    }
                });
            });
        </script>


        <x-toast />

    @endsection
