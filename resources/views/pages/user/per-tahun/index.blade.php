@extends('layouts.app')

@section('title', 'Berkas Per-tahun')

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
            <span class="text-dark">Upload Berkas Per-tahun</span>
        </div>
    </div>

    <!-- Header -->
    <div class="container-fluid py-4 bg-primary text-light">
        <div class="container">
            <h1 class="fw-bold mb-0">Upload Berkas Per-tahun</h1>
            <p class="mb-0">Layanan Guru untuk upload berkas per-tahun</p>
        </div>
    </div>


    <div class="container py-5">

        {{-- ===========================
             RIWAYAT UPLOAD
        ============================ --}}
        <div class="text-center mb-4">
            <div class="text-muted fw-semibold">Per-tahun</div>
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
                                        $item->biodata_path,
                                        $item->sertifikat_pendidik_path,
                                        $item->sk_dirjen_kelulusan_path,
                                        $item->nrg_path,
                                        $item->nuptk_path,
                                        $item->npwp_path,
                                        $item->ktp_path,
                                        $item->ijazah_sd_path,
                                        $item->ijazah_smp_path,
                                        $item->ijazah_sma_pga_path,
                                        $item->sk_pns_gty_path,
                                        $item->ijazah_s1_path,
                                        $item->transkrip_nilai_s1_path,
                                    ];
                                    $uploaded = collect($fields)->filter()->count();
                                    $filesTotal = 13;
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
                                        @if ($item->periode_per_tahun)
                                            {{ \Carbon\Carbon::parse($item->periode_per_tahun)->translatedFormat('Y') }}
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
                                            <a href="{{ route('user.pertahun.edit', $item) }}"
                                                class="btn btn-sm btn-warning text-white">
                                                <i class="bi bi-pencil"></i> Lengkapi
                                            </a>
                                        @else
                                            <a href="{{ route('user.pertahun.show', $item) }}"
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
                        <strong>{{ $total }}</strong> periode tahun)
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
            <div class="text-muted fw-semibold">Per-tahun</div>
            <h2 class="fw-bold mb-0">Form Upload Berkas</h2>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">

                <form action="{{ route('user.pertahun.store') }}" method="POST" enctype="multipart/form-data">
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
                            <h5 class="fw-semibold mb-0">Pilih Periode Per-tahun</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <x-select-input label="Periode" name="periode_per_tahun" :options="collect(range(now()->subYears(10)->year, now()->year))
                                    ->mapWithKeys(fn($year) => [$year => $year])
                                    ->toArray()" required
                                    placeholder="Pilih Periode" :value="old('periode_per_tahun')" />
                                <input type="hidden" name="guru_id" value="{{ $guru->id }}">
                            </div>

                        </div>
                    </div>


                    {{-- FILE UPLOAD --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-semibold mb-0">Upload Berkas</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Biodata (PDF)</label>
                                <input type="file" name="biodata_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sertifikat Pendidik (PDF)</label>
                                <input type="file" name="sertifikat_pendidik_path" class="form-control"
                                    accept=".pdf" placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Surat Keputusan Dirjen atau Kelulusan (PDF)</label>
                                <input type="file" name="sk_dirjen_kelulusan_path" class="form-control"
                                    accept=".pdf" placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">NRG - Nomor Registrasi Guru (PDF)</label>
                                <input type="file" name="nrg_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">NUPTK - Nomor Unik Pendidik dan Tenaga Kependidikan
                                    (PDF)</label>
                                <input type="file" name="nuptk_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">NPWP - Nomor Pokok Wajib Pajak (PDF)</label>
                                <input type="file" name="npwp_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">KTP - Kartu Tanda Penduduk (PDF)</label>
                                <input type="file" name="ktp_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ijazah SD (PDF)</label>
                                <input type="file" name="ijazah_sd_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ijazah SMP (PDF)</label>
                                <input type="file" name="ijazah_smp_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ijazah SMA atau PGA (PDF)</label>
                                <input type="file" name="ijazah_sma_pga_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Surat Keputusan PNS atau GTY (PDF)</label>
                                <input type="file" name="sk_pns_gty_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ijazah S1 (PDF)</label>
                                <input type="file" name="ijazah_s1_path" class="form-control" accept=".pdf"
                                    placeholder="Pilih file PDF">
                                <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Transkrip Nilai S1 (PDF)</label>
                                <input type="file" name="transkrip_nilai_s1_path" class="form-control" accept=".pdf"
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
