@extends('layouts.app')

@section('title', 'Detail Berkas Per-Semester')

@section('content')

    <div class="container-fluid pt-3 text-dark border-bottom">
        <div class="container pb-3">
            <a href="/home" class="text-dark fs-6 mb-0 text-decoration-none">Home</a>
            <span class="mx-2">></span>
            <a href="" class="text-dark fs-6 mb-0 text-decoration-none">Layanan</a>
            <span class="mx-2">></span>
            <a href="/user/persemester" class="text-dark fs-6 mb-0 text-decoration-none">Lengkapi Berkas Per-Semester</a>
            <span class="mx-2">></span>
            <span class="text-dark fs-6 mb-0">Detail Berkas Per-Semester</span>
        </div>
    </div>

    <div class="container-fluid  py-4 bg-primary text-light">
        <div class="container pb-3 ">
            <h1 class="fw-bold mb-0">Detail berkas Per-Semester</h1>
            <p class="text-light fs-6 mb-0">Layanan Guru untuk melihat detail berkas per-semester</p>
        </div>
    </div>

    <div class="container py-5">
        {{-- HITUNG PROGRESS --}}
        @php
            $totalField = 11;
            $uploaded = collect([
                $perSemester->sk_pbm_path,
                $perSemester->sk_terakhir_berkala_path,
                $perSemester->sp_bersedia_mengembalikan_path,
                $perSemester->sp_kebenaran_berkas_path,
                $perSemester->sp_perangkat_pembelajaran_path,
                $perSemester->keaktifan_simpatika_path,
                $perSemester->berkas_s28a_path,
                $perSemester->berkas_skmt_path,
                $perSemester->permohonan_skbk_path,
                $perSemester->berkas_skbk_path,
                $perSemester->sertifikat_pengembangan_diri_path,
            ])
                ->filter()
                ->count();

            $progress = ($uploaded / $totalField) * 100;

            $statusBadgeClass =
                [
                    'menunggu' => 'badge bg-label-warning',
                    'ditolak' => 'badge bg-label-danger',
                    'diterima' => 'badge bg-label-success',
                    'belum lengkap' => 'badge bg-label-secondary',
                ][$perSemester->status] ?? 'badge bg-label-secondary';
        @endphp

        {{-- HEADER UTAMA --}}
        <div class="d-flex justify-content-between align-items-center mb-6">
            <h4 class="fw-bold">
                Detail Berkas Per-semester <span
                    class="text-muted d-block d-md-inline mt-1 mt-md-0 ms-md-2">({{ $perSemester->periode_per_semester }})</span>
                </span>
            </h4>

            <a href="{{ route('user.persemester.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-5"></div>
        {{-- CARD: PROGRESS + STATUS --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="fw-semibold mb-0">Progress Pengajuan</h5>
            </div>

            <div class="card-body">

                {{-- PROGRESS --}}
                <label class="form-label fw-semibold">Kelengkapan Berkas</label>
                <div class="progress mb-2" style="height: 18px;">
                    <div class="progress-bar 
                    @if ($progress == 100) bg-success
                    @elseif($progress >= 50) bg-warning text-dark
                    @else bg-danger @endif"
                        style="width: {{ $progress }}%;">
                        {{ round($progress) }}%
                    </div>
                </div>
                <small class="text-muted">{{ $uploaded }} dari {{ $totalField }} dokumen terupload</small>

                <hr>

                {{-- STATUS --}}
                <label class="form-label fw-semibold">Status Pengajuan</label><br>
                <span class="badge {{ $statusBadgeClass }} px-3 py-2 text-capitalize">
                    {{ $perSemester->status }}
                </span>

                {{-- CATATAN --}}
                @if ($perSemester->catatan)
                    <div class="mt-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea class="form-control" rows="3" readonly>{{ $perSemester->catatan }}</textarea>
                    </div>
                @endif

            </div>
        </div>



        {{-- CARD: INFORMASI GURU --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="fw-semibold mb-0">Informasi Guru</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ $perSemester->guru->user->name }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" value="{{ $perSemester->guru->nik }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" value="{{ $perSemester->guru->user->nomor_telepon }}"
                            readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" value="{{ $perSemester->guru->tempat_lahir }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control"
                            value="{{ $perSemester->guru->tanggal_lahir?->format('d F Y') }}" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Asal Sekolah Induk</label>
                        @if ($perSemester->guru && $perSemester->guru->sekolah && $perSemester->guru->sekolah->count())
                            @foreach ($perSemester->guru->sekolah as $sekolah)
                                <input type="text" class="form-control mb-1" value="{{ $sekolah->nama }}" readonly>
                            @endforeach
                        @else
                            <input type="text" class="form-control" value="-" readonly>
                        @endif
                    </div>

                </div>
            </div>
        </div>


        {{-- Periode Per Semester --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="fw-semibold mb-0">Periode Per-semester</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="periode_per_semester" class="form-label">Periode Per-semester</label>
                    <input type="text" name="periode_per_semester" id="periode_per_semester"
                        class="form-control @error('periode_per_semester') is-invalid @enderror"
                        value="{{ old('periode_per_semester', $perSemester->periode_per_semester) }}" readonly>
                </div>
            </div>
        </div>


        {{-- CARD: FILES --}}
        <form action="{{ route('user.persemester.update', $perSemester) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-semibold mb-0">Berkas Upload</h5>
                </div>

                <div class="card-body">

                    @php
                        $files = [
                            'Surat Keputusan PBM' => $perSemester->sk_pbm_path,
                            'Surat Keputusan Terakhir atau Berkala' => $perSemester->sk_terakhir_berkala_path,
                            'Surat Pernyataan Bersedia Mengembalikan' => $perSemester->sp_bersedia_mengembalikan_path,
                            'Surat Pernyataan Kebenaran Berkas' => $perSemester->sp_kebenaran_berkas_path,
                            'Surat Pernyataan Perangkat Pembelajaran' => $perSemester->sp_perangkat_pembelajaran_path,
                            'Bukti Keaktifan SIMPATIKA' => $perSemester->keaktifan_simpatika_path,
                            'Berkas S28a' => $perSemester->berkas_s28a_path,
                            'Berkas SKMT' => $perSemester->berkas_skmt_path,
                            'Permohonan SKBK' => $perSemester->permohonan_skbk_path,
                            'Berkas SKBK' => $perSemester->berkas_skbk_path,
                            'Sertifikat Pengembangan Diri' => $perSemester->sertifikat_pengembangan_diri_path,
                        ];
                    @endphp

                    @foreach ($files as $label => $filePath)
                        @php
                            $fieldName = collect([
                                'Surat Keputusan PBM' => 'sk_pbm_path',
                                'Surat Keputusan Terakhir atau Berkala' => 'sk_terakhir_berkala_path',
                                'Surat Pernyataan Bersedia Mengembalikan' => 'sp_bersedia_mengembalikan_path',
                                'Surat Pernyataan Kebenaran Berkas' => 'sp_kebenaran_berkas_path',
                                'Surat Pernyataan Perangkat Pembelajaran' => 'sp_perangkat_pembelajaran_path',
                                'Bukti Keaktifan SIMPATIKA' => 'keaktifan_simpatika_path',
                                'Berkas S28a' => 'berkas_s28a_path',
                                'Berkas SKMT' => 'berkas_skmt_path',
                                'Permohonan SKBK' => 'permohonan_skbk_path',
                                'Berkas SKBK' => 'berkas_skbk_path',
                                'Sertifikat Pengembangan Diri' => 'sertifikat_pengembangan_diri_path',
                            ])[$label];
                        @endphp

                        <div class="mb-3">
                            <label for="{{ $fieldName }}" class="form-label">{{ $label }} (File)</label>
                            <input type="file" name="{{ $fieldName }}" id="{{ $fieldName }}"
                                class="form-control" accept=".pdf">

                            @if ($filePath)
                                <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                    <a href="{{ route('gdrive.preview', ['path' => $filePath]) }}" target="_blank"
                                        class="text-primary text-decoration-underline">
                                        Lihat File Lama
                                    </a>
                                    <span class="text-muted old-file-name">
                                        {{ basename($filePath) }}
                                    </span>
                                </div>
                            @else
                                <p class="text-muted mt-1">Belum ada file</p>
                            @endif
                        </div>
                    @endforeach

                    {{-- SUBMIT --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Simpan
                        </button>
                    </div>

                </div>
            </div>

        </form>

    </div>


    <style>
        .old-file-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 350px;
        }
    </style>

@endsection
