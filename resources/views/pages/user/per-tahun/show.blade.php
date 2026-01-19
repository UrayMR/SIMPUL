@extends('layouts.app')

@section('title', 'Detail Berkas Per-tahun')

@section('content')

    <div class="container-fluid pt-3 text-dark border-bottom">
        <div class="container pb-3">
            <a href="/home" class="text-dark fs-6 mb-0 text-decoration-none">Home</a>
            <span class="mx-2">></span>
            <a href="" class="text-dark fs-6 mb-0 text-decoration-none">Layanan</a>
            <span class="mx-2">></span>
            <a href="/user/pertahun" class="text-dark fs-6 mb-0 text-decoration-none">Upload Berkas Per-tahun</a>
            <span class="mx-2">></span>
            <span class="text-dark fs-6 mb-0">Detail Berkas Per-tahun</span>
        </div>
    </div>

    <div class="container-fluid  py-4 bg-primary text-light">
        <div class="container pb-3 ">
            <h1 class="fw-bold mb-0">Detail Berkas Per-tahun</h1>
            <p class="text-light fs-6 mb-0">Layanan Guru untuk melihat detail berkas per-tahun</p>
        </div>
    </div>

    <div class="container py-5">
        {{-- HITUNG PROGRESS --}}
        @php
            $totalField = 13;
            $uploaded = collect([
                $perTahun->biodata_path,
                $perTahun->sertifikat_pendidik_path,
                $perTahun->sk_dirjen_kelulusan_path,
                $perTahun->nrg_path,
                $perTahun->nuptk_path,
                $perTahun->npwp_path,
                $perTahun->ktp_path,
                $perTahun->ijazah_sd_path,
                $perTahun->ijazah_smp_path,
                $perTahun->ijazah_sma_pga_path,
                $perTahun->sk_pns_gty_path,
                $perTahun->ijazah_s1_path,
                $perTahun->transkrip_nilai_s1_path,
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
                ][$perTahun->status] ?? 'badge bg-label-secondary';
        @endphp

        {{-- HEADER UTAMA --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">
                Detail Berkas Per-Tahun
                <span class="text-muted d-block d-md-inline mt-1 mt-md-0 ms-md-2 text-muted">
                    {{ \Carbon\Carbon::parse($perTahun->periode_per_tahun)->translatedFormat('(Y)') }}
                </span>
            </h4>

            <a href="{{ route('user.pertahun.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>


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
                    {{ $perTahun->status }}
                </span>

                {{-- CATATAN --}}
                @if ($perTahun->catatan)
                    <div class="mt-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea class="form-control" rows="3" readonly>{{ $perTahun->catatan }}</textarea>
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
                        <input type="text" class="form-control" value="{{ $perTahun->guru->user->name }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" value="{{ $perTahun->guru->nik }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" value="{{ $perTahun->guru->user->nomor_telepon }}"
                            readonly>
                        readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" value="{{ $perTahun->guru->tempat_lahir }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control"
                            value="{{ $perTahun->guru->tanggal_lahir?->format('d F Y') }}" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Asal Sekolah Induk</label>
                        @if ($perTahun->guru && $perTahun->guru->sekolah && $perTahun->guru->sekolah->count())
                            @foreach ($perTahun->guru->sekolah as $sekolah)
                                <input type="text" class="form-control mb-1" value="{{ $sekolah->nama }}" readonly>
                            @endforeach
                        @else
                            <input type="text" class="form-control" value="-" readonly>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- Periode Per Tahun --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="fw-semibold mb-0">Periode Per-tahun</h5>
            </div>

            <div class="card-body">
                <input type="text" class="form-control"
                    value="{{ \Carbon\Carbon::parse($perTahun->periode_per_tahun)->translatedFormat('Y') }}" readonly>
            </div>
        </div>

        {{-- CARD: FILES --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="fw-semibold mb-0">Berkas Upload</h5>
            </div>

            <div class="card-body">
                {{-- FILES UPLOAD --}}
                @foreach ([
            'Biodata' => $perTahun->biodata_path,
            'Sertifikat Pendidik' => $perTahun->sertifikat_pendidik_path,
            'Surat Keputusan Dirjen atau Kelulusan' => $perTahun->sk_dirjen_kelulusan_path,
            'NRG - Nomor Registrasi Guru' => $perTahun->nrg_path,
            'NUPTK - Nomor Unik Pendidik dan Tenaga Kependidikan' => $perTahun->nuptk_path,
            'NPWP - Nomor Pokok Wajib Pajak' => $perTahun->npwp_path,
            'KTP - Kartu Tanda Penduduk' => $perTahun->ktp_path,
            'Ijazah SD' => $perTahun->ijazah_sd_path,
            'Ijazah SMP' => $perTahun->ijazah_smp_path,
            'Ijazah SMA atau PGA' => $perTahun->ijazah_sma_pga_path,
            'Surat Keputusan PNS atau GTY' => $perTahun->sk_pns_gty_path,
            'Ijazah S1' => $perTahun->ijazah_s1_path,
            'Transkrip Nilai S1' => $perTahun->transkrip_nilai_s1_path,
        ] as $label => $path)
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ $label }} (PDF)</label>
                        @if ($path)
                            <div class="d-flex flex-column">
                                <input type="text" class="form-control mb-2" value="{{ basename($path) }}" readonly>
                                <a href="{{ route('gdrive.preview', ['path' => $path]) }}" target="_blank"
                                    class="text-primary text-decoration-underline">
                                    Lihat File
                                </a>
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada file</p>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
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
