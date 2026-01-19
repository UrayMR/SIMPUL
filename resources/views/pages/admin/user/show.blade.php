@extends('layouts.appadmin')

@section('title', 'Detail Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Data Pengguna</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Data Pengguna</h5>

            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="row mb-2">
                {{-- FOTO KIRI --}}
                <div class="col-md-3 text-center mb-3">

                    @php
                        $photoPath = null;
                        if ($user->profile_photo_path) {
                            $fullPath = public_path('storage/' . $user->profile_photo_path);
                            if (file_exists($fullPath)) {
                                $photoPath = asset('storage/' . $user->profile_photo_path);
                            }
                        }
                    @endphp

                    @if ($photoPath)
                        <img src="{{ $photoPath }}" class="img-thumbnail rounded shadow-sm"
                            style="width: 305px; height: 305px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) . '&background=random&color=000&size=300' }}"
                            class="img-thumbnail rounded shadow-sm" style="width: 305px; height: 305px; object-fit: cover;">
                    @endif
                </div>

                {{-- FORM KANAN (LABEL TETAP RATA KIRI) --}}
                <div class="col-md-9">
                    {{-- PERAN & STATUS --}}
                    <div class="row">
                        {{-- PERAN (kiri) --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-start d-block">Peran</label>
                            <select class="form-select" disabled>
                                <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="staff-gereja" {{ $user->role == 'staff-gereja' ? 'selected' : '' }}>Pengurus
                                    Gereja</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        {{-- STATUS (kanan) --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-start d-block">Status</label>
                            <select class="form-select" disabled>
                                <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $user->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label class="form-label text-start d-block">Nama</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label text-start d-block">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>

                    {{-- NOMOR TELEPON --}}
                    <div class="mb-3">
                        <label class="form-label text-start d-block">Nomor Telepon</label>
                        <input type="text" class="form-control" value="{{ $user->nomor_telepon }}" readonly>
                    </div>
                </div>
            </div>

            {{-- FORM GURU --}}
            @if ($user->role === 'guru' && $user->guru)
                <hr>
                <h5>Data Guru</h5>

                <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" class="form-control" value="{{ $user->guru->nik }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" value="{{ $user->guru->tempat_lahir }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="text" class="form-control"
                        value="{{ \Carbon\Carbon::parse($user->guru->tanggal_lahir)->translatedFormat('d F Y') }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Asal Sekolah Induk</label>
                    @if ($user->guru && $user->guru->sekolah && $user->guru->sekolah->count())
                        @foreach ($user->guru->sekolah as $sekolah)
                            <input type="text" class="form-control mb-1" value="{{ $sekolah->nama }}" readonly>
                        @endforeach
                    @else
                        <input type="text" class="form-control" value="-" readonly>
                    @endif
                </div>
            @endif

            {{-- FORM STAFF GEREJA --}}
            @if ($user->role === 'staff-gereja' && $user->staffGereja)
                <hr>
                <h5>Data Pengurus Gereja</h5>

                <div class="mb-3">
                    <label class="form-label">Gereja</label>
                    <select class="form-select" disabled>
                        @if (is_array($gerejas))
                            @foreach ($gerejas as $id => $nama)
                                <option value="{{ $id }}"
                                    {{ $user->staffGereja->gereja_id == $id ? 'selected' : '' }}>
                                    {{ $nama }}
                                </option>
                            @endforeach
                        @else
                            @foreach ($gerejas as $gereja)
                                <option value="{{ $gereja->id }}"
                                    {{ $user->staffGereja->gereja_id == $gereja->id ? 'selected' : '' }}>
                                    {{ $gereja->nama }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            @endif

            {{-- TANGGAL DIBUAT --}}
            <div class="mb-3">
                <label class="form-label">Dibuat Pada</label>
                <input type="text" class="form-control" value="{{ $user->created_at->translatedFormat('d F Y, H:i') }}"
                    readonly>
            </div>

            {{-- TANGGAL DIUPDATE --}}
            <div class="mb-3">
                <label class="form-label">Diperbarui Pada</label>
                <input type="text" class="form-control" value="{{ $user->updated_at->translatedFormat('d F Y, H:i') }}"
                    readonly>
            </div>
        </div>
    </div>
@endsection
