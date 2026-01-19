@extends('layouts.appadmin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                            <div class="text-center text-md-start">
                                <h4 class="mb-1 fw-bold text-primary">Selamat datang di SILAYANKRIS</h4>
                                <div class="text-muted">Ringkasan cepat data sistem</div>
                            </div>
                            <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid d-none d-sm-block"
                                style="max-height: 64px" alt="Welcome" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="col-12 col-md-6 col-lg-3">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-label-primary p-2"><i class="bx bx-user text-primary"></i></span>
                                <i class="bi bi-arrow-right-short fs-4 text-muted"></i>
                            </div>
                            <div class="fw-semibold text-muted">Pengguna</div>
                            <div class="fs-3 fw-bold">{{ $stats['users'] ?? '-' }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <a href="{{ route('admin.gereja.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-label-success p-2"><i class="bi bi-hospital text-success"></i></span>
                                <i class="bi bi-arrow-right-short fs-4 text-muted"></i>
                            </div>
                            <div class="fw-semibold text-muted">Gereja</div>
                            <div class="fs-3 fw-bold">{{ $stats['gereja'] ?? '-' }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <a href="{{ route('admin.sekolah.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-label-info p-2"><i class="bx bx-building text-info"></i></span>
                                <i class="bi bi-arrow-right-short fs-4 text-muted"></i>
                            </div>
                            <div class="fw-semibold text-muted">Sekolah</div>
                            <div class="fs-3 fw-bold">{{ $stats['sekolah'] ?? '-' }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <a href="{{ route('admin.berita.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-label-warning p-2"><i class="bx bx-news text-warning"></i></span>
                                <i class="bi bi-arrow-right-short fs-4 text-muted"></i>
                            </div>
                            <div class="fw-semibold text-muted">Berita</div>
                            <div class="fs-3 fw-bold">{{ $stats['berita'] ?? '-' }}</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="{{ route('admin.per-bulan.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-label-primary p-2"><i class="bx bx-folder text-primary"></i></span>
                                <i class="bi bi-arrow-right-short fs-4 text-muted"></i>
                            </div>
                            <div class="fw-semibold text-muted">Berkas TPG Perbulan</div>
                            <div class="fs-3 fw-bold">{{ $stats['per_bulan'] ?? '-' }}</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="{{ route('admin.per-semester.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-label-info p-2"><i class="bx bx-folder text-info"></i></span>
                                <i class="bi bi-arrow-right-short fs-4 text-muted"></i>
                            </div>
                            <div class="fw-semibold text-muted">Berkas TPG Persemester</div>
                            <div class="fs-3 fw-bold">{{ $stats['per_semester'] ?? '-' }}</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="{{ route('admin.per-tahun.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-label-warning p-2"><i class="bx bx-folder text-warning"></i></span>
                                <i class="bi bi-arrow-right-short fs-4 text-muted"></i>
                            </div>
                            <div class="fw-semibold text-muted">Berkas TPG Pertahun</div>
                            <div class="fs-3 fw-bold">{{ $stats['per_tahun'] ?? '-' }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Quick Actions -->
            <div class="col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h5 class="fw-semibold mb-1">Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <a href="{{ route('admin.gereja.create') }}" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-circle me-1 text-white"></i> <span class="text-white">Tambah
                                        Gereja</span>
                                </a>
                            </div>
                            <div class="col-12 col-md-6">
                                <a href="{{ route('admin.sekolah.create') }}" class="btn btn-info w-100">
                                    <i class="bi bi-hospital me-1 text-white"></i> <span class="text-white">Tambah
                                        Sekolah</span>
                                </a>
                            </div>
                            <div class="col-12 col-md-6">
                                <a href="{{ route('admin.berita.create') }}" class="btn btn-warning w-100">
                                    <i class="bi bi-journal-plus me-1 text-white"></i> <span class="text-white">Tambah
                                        Berita</span>
                                </a>
                            </div>
                            <div class="col-12 col-md-6">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-secondary w-100">
                                    <i class="bi bi-person-plus me-1 text-white"></i> <span class="text-white">Tambah
                                        Pengguna</span>
                                </a>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Items -->

    </div>
    </div>
@endsection
