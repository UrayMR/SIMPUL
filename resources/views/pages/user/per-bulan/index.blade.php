@extends('layouts.app')

@section('title', 'Berkas Perbulan')

@section('content')

    <!-- Toast Notification -->
    <x-toast />

    <!-- Breadcrumb -->
    <div class="container-fluid pt-3 text-dark border-bottom">
        <div class="container pb-3">
            <a href="/home" class="text-dark text-decoration-none">Home</a>
            <span class="mx-2">></span>
            <a href="#" class="text-dark text-decoration-none">Layanan</a>
            <span class="mx-2">></span>
            <span class="text-dark">Upload Berkas Per-bulan</span>
        </div>
    </div>

    <!-- Header -->
    <div class="container-fluid py-4 bg-primary text-light">
        <div class="container">
            <h1 class="fw-bold mb-0">Upload Berkas Per-bulan</h1>
            <p class="mb-0">Layanan Guru untuk upload berkas per-bulan</p>
        </div>
    </div>


    <div class="container py-5">

        {{-- ===========================
             RIWAYAT UPLOAD
        ============================ --}}
        <div class="text-center mb-4">
            <div class="text-muted fw-semibold">Per-bulan</div>
            <h2 class="fw-bold mb-0">Riwayat Upload Berkas</h2>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead class="table-hover">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Periode</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Progress Upload</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($items as $item)
                                @php
                                    // Cek kelengkapan file
                                    $fields = [
                                        $item->daftar_gaji_path,
                                        $item->daftar_hadir_path,
                                        $item->rekening_bank_path,
                                        $item->ceklist_berkas,
                                    ];
                                    $uploaded = collect($fields)->filter()->count();
                                    $filesTotal = 4;
                                    $progress = ($uploaded / $filesTotal) * 100;
                                    $isIncomplete = $uploaded < $filesTotal;
                                @endphp

                                <tr>
                                    {{-- Make numbering continuous across pages using paginator firstItem() --}}
                                    <td>{{ optional($items)->firstItem() ? $items->firstItem() + $loop->index : $loop->iteration }}
                                    </td>

                                    {{-- Nama --}}
                                    <td>{{ $item->guru->user->name }}</td>

                                    {{-- PERIODE --}}
                                    <td>
                                        @if ($item->periode_per_bulan)
                                            {{ \Carbon\Carbon::parse($item->periode_per_bulan)->translatedFormat('F Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td>{{ $item->created_at->format('d M Y') }}</td>

                                    {{-- PROGRESS --}}
                                    <td style="min-width: 60px;">
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar 
                            @if ($progress == 100) bg-success
                            @elseif($progress >= 50) bg-warning
                            @else bg-danger @endif"
                                                style="width: {{ $progress }}%;"></div>
                                        </div>
                                        <small class="text-muted">{{ $uploaded }}/{{ $filesTotal }}</small>
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @if ($isIncomplete && $item->status !== 'ditolak')
                                            <span class="badge bg-label-secondary">Belum Lengkap</span>
                                        @elseif ($item->status === 'ditolak')
                                            <span class="badge bg-label-danger">Ditolak</span>
                                        @elseif ($item->status === 'menunggu')
                                            <span class="badge bg-label-warning">Menunggu</span>
                                        @elseif ($item->status === 'diterima')
                                            <span class="badge bg-label-success">Diterima</span>
                                        @endif
                                    </td>

                                    {{-- AKSI --}}
                                    <td>
                                        @if ($isIncomplete || $item->status === 'ditolak')
                                            <a href="{{ route('user.perbulan.edit', $item) }}"
                                                class="btn btn-sm btn-warning text-white">
                                                <i class="bi bi-pencil"></i> Lengkapi
                                            </a>
                                        @else
                                            <a href="{{ route('user.perbulan.show', $item) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> Buka
                                            </a>
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada pengajuan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                    <div class="small text-muted">
                        Halaman <strong>{{ $currentPage }}</strong> dari <strong>{{ $lastPage }}</strong><br>
                        Menampilkan <strong>{{ $perPage }}</strong> per halaman (total
                        <strong>{{ $total }}</strong> periode bulanan)
                    </div>
                    <div>
                        {{ $items->links() }}
                    </div>
                </div>

            </div>
        </div>



        {{-- ===========================
             FORM UPLOAD BARU
        ============================ --}}

        <div class="text-center mb-4">
            <div class="text-muted fw-semibold">Per-bulan</div>
            <h2 class="fw-bold mb-0">Form Upload Berkas</h2>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">

                <form action="{{ route('user.perbulan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- INFORMASI GURU --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-semibold mb-0">Informasi Data Guru</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control" value="{{ $guru->nik }}" readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nomor HP</label>
                                    <input type="text" class="form-control" value="{{ $user->nomor_telepon }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" value="{{ $guru->tempat_lahir }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="text" class="form-control"
                                        value="{{ $guru->tanggal_lahir?->format('d F Y') }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Asal Sekolah Induk</label>
                                @forelse ($guru->sekolah as $sekolah)
                                    <input type="text" class="form-control mb-1" value="{{ $sekolah->nama }}" readonly>
                                @empty
                                    <input type="text" class="form-control" value="-" readonly>
                                @endforelse
                            </div>

                        </div>
                    </div>


                    {{-- PERIODE --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-semibold mb-0">Pilih Periode Per-Bulan</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Periode</label>
                                <input type="month" name="periode_per_bulan" class="form-control" required
                                    min="{{ now()->subMonths(35)->format('Y-m') }}" max="{{ now()->format('Y-m') }}"
                                    value="{{ old('periode_per_bulan') }}">
                            </div>

                            <input type="hidden" name="guru_id" value="{{ $guru->id }}">

                        </div>
                    </div>


                    {{-- FILE UPLOAD --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-semibold mb-0">Upload Berkas</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Daftar Gaji (PDF)</label>
                                <input type="file" name="daftar_gaji_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Daftar Hadir (PDF)</label>
                                <input type="file" name="daftar_hadir_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rekening Bank (PDF)</label>
                                <input type="file" name="rekening_bank_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ceklist Berkas (PDF)</label>
                                <input type="file" name="ceklist_berkas" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>
                        </div>
                    </div>


                    {{-- SUBMIT --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
