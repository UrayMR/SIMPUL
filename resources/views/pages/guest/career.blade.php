@extends('layouts.app')

@section('title', 'Karir Pengajar')

@section('content')
<style>
    html, body {
        overflow-x: hidden;
    }
</style>
    {{-- HERO SECTION --}}
    <section class="py-5 bg-app-primary text-white">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-lg-7">
                    <span class="badge bg-white text-app-primary px-3 py-2 rounded-pill mb-3 fw-semibold">
                        Karir di SIMPUL
                    </span>

                    <h1 class="fw-bold text-white display-6 mb-3">
                        Bergabung Menjadi Pengajar di SIMPUL
                    </h1>

                    <p class="fs-5 opacity-75 mb-4">
                        Bagikan keahlian dan pengalamanmu untuk menjangkau lebih banyak peserta didik
                        melalui platform pembelajaran unggulan lokal.
                    </p>

                    <a href="{{ route('register.teacher.index') }}"
                        class="btn btn-light text-app-primary fw-semibold px-4 py-2 rounded-3">
                        Daftar Menjadi Pengajar
                    </a>
                </div>

                <div class="col-lg-5 text-center">
                    <img src="{{ asset('assets/img/background/2.png') }}" alt="Pengajar SIMPUL" class="img-fluid"
                        style="max-height: 300px;">
                </div>

            </div>
        </div>
    </section>

    {{-- TENTANG KARIR --}}
    <section class="py-5 bg-light">
        <div class="container">

            <div class="text-center mb-5">
                <h3 class="fw-bold mb-2">
                    Mengapa Mengajar di SIMPUL?
                </h3>
                <p class="text-muted">
                    SIMPUL memberikan ruang bagi pendidik untuk berkembang dan berdampak lebih luas
                </p>
            </div>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-people-fill fs-1 text-app-primary mb-3"></i>
                            <h5 class="fw-semibold mb-2">Jangkauan Luas</h5>
                            <p class="text-muted mb-0">
                                Ajar ribuan peserta didik dari berbagai daerah melalui satu platform.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-cash-coin fs-1 text-app-primary mb-3"></i>
                            <h5 class="fw-semibold mb-2">Pendapatan Tambahan</h5>
                            <p class="text-muted mb-0">
                                Dapatkan penghasilan dari kursus yang kamu kelola dan kembangkan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-award-fill fs-1 text-app-primary mb-3"></i>
                            <h5 class="fw-semibold mb-2">Pengajar Terverifikasi</h5>
                            <p class="text-muted mb-0">
                                Tingkatkan kredibilitas dengan status pengajar terverifikasi SIMPUL.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- BENEFIT --}}
    <section class="py-5 bg-white">
        <div class="container">

            <div class="row align-items-center g-5">

                <div class="col-lg-6" data-aos="fade-right">
                    <h3 class="fw-bold mb-4">
                        Benefit Menjadi Pengajar
                    </h3>

                    <ul class="list-unstyled">
                        <li class="d-flex align-items-start mb-3" data-aos="fade-up" data-aos-delay="100">
                            <i class="bi bi-check-circle-fill text-app-primary me-3 mt-1"></i>
                            <span>Manajemen kursus yang mudah dan terstruktur</span>
                        </li>
                        <li class="d-flex align-items-start mb-3" data-aos="fade-up" data-aos-delay="100">
                            <i class="bi bi-check-circle-fill text-app-primary me-3 mt-1"></i>
                            <span>Fleksibel mengatur waktu dan materi ajar</span>
                        </li>
                        <li class="d-flex align-items-start mb-3" data-aos="fade-up" data-aos-delay="100">
                            <i class="bi bi-check-circle-fill text-app-primary me-3 mt-1"></i>
                            <span>Dukungan tim SIMPUL untuk pengelolaan kursus</span>
                        </li>
                        <li class="d-flex align-items-start mb-3" data-aos="fade-up" data-aos-delay="100">
                            <i class="bi bi-check-circle-fill text-app-primary me-3 mt-1"></i>
                            <span>Kesempatan membangun personal branding sebagai pendidik</span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <img src="{{ asset('assets/img/background/3.png') }}" alt="Benefit Pengajar" class="img-fluid"
                        style="max-height: 320px;">
                </div>

            </div>
        </div>
    </section>

    {{-- CTA DAFTAR --}}
    <section id="daftar" class="pt-1 pb-5 bg-light">
        <div class="container ">
            <div class="card border rounded-4" data-aos="zoom-in" data-aos-delay="150">
                <div class="card-body p-5 text-center">

                    <h3 class="fw-bold mb-2">
                        Siap Bergabung Bersama SIMPUL?
                    </h3>
                    <p class="text-muted mb-4"> 
                        Daftarkan dirimu sebagai pengajar dan mulai berbagi ilmu hari ini.
                    </p>

                    <a href="{{ route('register.teacher.index') }}"
                        class="btn btn-app-primary px-5 py-2 fw-semibold rounded-3" data-aos="zoom-in" data-aos-delay="300">
                        Daftar Menjadi Pengajar
                    </a>

                </div>
            </div>
        </div>
    </section>

@endsection
