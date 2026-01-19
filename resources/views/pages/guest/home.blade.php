@extends('layouts.app')

@section('title', 'SILAYANKRIS - Kementerian Agama Kota Surabaya')

{{-- Landing Page --}}
@section('content')
    <style>
        /* --- Foto Profil 3:4 --- */
        .profil-photo-wrapper {
            width: 100%;
            max-width: 300px;
            /* batas maksimal supaya tidak terlalu besar */
            aspect-ratio: 3 / 4;
            /* rasio 3:4 */
            border-radius: 1rem;
            overflow: hidden;
            margin: auto;
            background: rgba(0, 0, 0, 0) !important;
            padding: 0;
        }

        .profil-photo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 4px solid #008080
                /* memenuhi area 3:4 */
        }


        .logo-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .brand-logo {
            width: 100%;
            max-width: 850px;
            /* dinaikkan ukuran maksimum */
            height: auto;
            /* biar tetap proporsional */
            object-fit: contain;
            padding: 15px;
            /* padding diperbesar */
            border-radius: 12px;
            /* sedikit membulat lebih rapi */
            background: #fff;
        }


        .hero-image {
            width: 100%;
            height: 260px;
            background-image: url('{{ asset('assets/img/kemenag2.jpg') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        @media (min-width: 992px) {
            .hero-image {
                height: 85vh;
            }
        }

        /* ===== Logo / Partner Section ===== */
        .partner-section {
            background: #f8f9fb;
        }

        .partner-card {
            background: #ffffff;
            border-radius: 1.5rem;
            padding: 2rem 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            transition: all 0.25s ease;
        }

        .partner-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.08);
        }

        .partner-logo {
            max-height: 90px;
            object-fit: contain;
            filter: grayscale(20%);
            opacity: 0.9;
            transition: all 0.25s ease;
        }

        .partner-card:hover .partner-logo {
            filter: none;
            opacity: 1;
        }

        .partner-divider {
            width: 80px;
            height: 3px;
            background: #008080;
            border-radius: 999px;
        }

        /* Team image */
        .team-img {
            width: 150px;
            height: 150px;
            overflow: hidden;
        }

        .team-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ===== PROFIL SECTION CUSTOM ===== */
        .profil-section {
            background-color: #008080;
            /* teal seperti contoh */
            color: #ffffff;
        }

        .profil-section .section-subtitle {
            color: rgba(255, 255, 255, 0.8);
        }

        .profil-section .partner-divider {
            background: #ffc107;
            /* garis kuning biar kontras */
        }

        .profil-card {
            background: #ffffff;
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.18);
        }

        @media (min-width: 992px) {
            .profil-card {
                padding: 3rem;
            }
        }

        .profil-photo-wrapper {
            background: #ff4b3a;
            /* merah-oranye di belakang foto, opsional */
            border-radius: 1.25rem;
            padding: 1rem;
        }

        .profil-photo-wrapper img {
            border-radius: 1rem;
        }

        /* Animasi Card Pegawai */
        .pegawai-card {
            transition: all 0.3s ease;
            border-radius: 1rem;
            cursor: pointer
        }

        .pegawai-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.15);
        }

        /* Efek gambar zoom */
        .team-img img {
            transition: all 0.3s ease;
        }



        /* Efek warna nama berubah */
        .pegawai-card:hover h5 {
            color: #008080;
            /* warna teal mengikuti tema */
        }

        /* ----- ANIMASI CARD PELAYANAN ----- */
        .pelayanan-card {
            transition: all 0.3s ease;
            border-radius: 1rem;
        }

        .pelayanan-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.12);
        }

        /* Icon animasi berputar halus */
        .pelayanan-card i {
            transition: 0.3s ease;
        }

        .pelayanan-card:hover i {
            transform: scale(1.12) rotate(4deg);
        }

        /* Animasi fade-in dari bawah */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.6s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>


    <main>
        {{-- HERO SECTION --}}
        <section class="hero-section " data-aos="fade-up">
            <div class="container pb-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="py-4 text-center text-lg-start">
                            <h1 class="fw-bold text-primary mb-3 display-5 ">
                                Selamat Datang di SILAYANKRIS
                            </h1>
                            <p class="fs-5 mb-3">
                                <strong>SILAYANKRIS</strong> - Sistem Informasi Layanan Penyelenggara Kristen <br>
                                Kementerian Agama Kota Surabaya
                            </p>
                            <p class="text-muted mb-5">
                                Akses berbagai layanan dan informasi penyelenggaraan Kristen <br>
                                secara cepat, mudah, dan terintegrasi dalam satu sistem.
                            </p>
                            <a href="/layanan">
                                <button class="btn btn-primary btn-lg">
                                    Hubungi Kami
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="hero-image"></div>
                    </div>
                </div>
            </div>
        </section>
        
        {{-- PROFIL SECTION --}}
        <section class="profil-section" data-aos="fade-up">
            <div class="container py-5">

                {{-- Header konsisten --}}
                <div class="text-center mb-5">
                    <h6 class="fw-bold mb-1 text-uppercase">PROFIL</h6>
                    <h2 class="fw-bold mb-2">Penyelenggara Kristen</h2>
                    <div class="partner-divider mx-auto mb-3"></div>
                    <p class="section-subtitle fs-6 mb-0">
                        Profil singkat Penyelenggara Kristen Kementerian Agama Kota Surabaya.
                    </p>
                </div>

                <div class="profil-card mx-auto">
                    <div class="row align-items-center gy-4">

                        {{-- Foto --}}
                        <div class="col-lg-4 col-md-12 col-sm-12 text-center">
                            {{-- col-12 col-md-6 col-lg-3 --}}
                            <div class="profil-photo-wrapper">
                                <img src="{{ asset('assets/img/foto bu ester fix_34.svg') }}" class="img-fluid shadow-sm"
                                    alt="Penyelenggara Kristen">
                            </div>
                        </div>


                        {{-- Konten --}}
                        <div class="col-lg-8 col-md-12 col-sm-12 ">
                            <p class="text-uppercase text-secondary text-center text-lg-start fw-semibold mb-1"
                                style="letter-spacing: .5px;">
                                Penyelenggara Kristen
                            </p>


                            <h1 class="fw-bold mb-4 text-dark text-center text-lg-start fs-3 fs-md-1"
                                style="line-height: 1.3;">
                                ESTHER SRIWIDYASTUTI, S.Th.
                            </h1>


                            <div class="p-4 mb-2 rounded" style="background: #f7f9fb; border-left: 4px solid #008080;">
                                <p class="text-muted lh-lg mb-0" style="font-size: 0.97rem;">
                                    Selamat datang di Website Resmi <strong>Penyelenggara Kristen</strong>
                                    Kantor Kementerian Agama Kota Surabaya. Melalui Website ini, kami menyediakan
                                    pusat informasi dan layanan terpadu yang berkaitan dengan pendidikan, pembinaan,
                                    serta pelayanan umat Kristen di Kota Surabaya.
                                    Kami berkomitmen memberikan akses yang mudah bagi para guru, pengurus gereja, lembaga keagamaan, dan masyarakat umum terhadap berbagai program, kebijakan,
                                    data, dan berita terbaru. Harapan kami, layanan ini dapat mendukung terwujudnya
                                    pembinaan kehidupan umat beragama yang harmonis, berkualitas, dan berkarakter.
                                    <br><br>
                                    Terima kasih atas kunjungan Anda.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>



        {{-- PELAYANAN SECTION --}}
        <section class="pelayanan-section" data-aos="fade-up"data-aos-delay="400">
            <div class="container py-5 border-bottom">

                {{-- Header konsisten --}}
                <div class="text-center mb-5">
                    <h6 class="fw-bold text-secondary mb-1">JENIS LAYANAN</h6>
                    <h2 class="fw-bold text-dark mb-2">Penyelenggara Kristen</h2>
                    <div class="partner-divider mx-auto mb-3"></div>
                    <p class="text-muted fs-6 mb-0">
                        Pilih jenis layanan yang ingin Anda akses melalui sistem SILAYANKRIS.
                    </p>
                </div>

                <div class="row">
                    {{-- Card 1 --}}
                    <div class="col-md-6 mb-4 fade-up">
                        <div class="card border-0 shadow-lg h-100 pelayanan-card">
                            <div class="card-body text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-building fs-1 text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Layanan Gereja</h5>
                                <p class="card-text text-muted">
                                    Pendataan data Gereja <br> di wilayah Surabaya secara digital dan terintegrasi.
                                </p>
                                <a href="{{ route('login', ['type' => 'gereja']) }}" class="btn btn-primary mt-3">
                                    Masuk ke Layanan Gereja
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Card 2 --}}
                    <div class="col-md-6 mb-4 fade-up">
                        <div class="card border-0 shadow-lg h-100 pelayanan-card">
                            <div class="card-body text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-person-badge fs-1 text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Layanan TPG Guru</h5>
                                <p class="card-text text-muted">
                                    Pendataan berkas Tunjangan Profesi Guru <br> di wilayah Surabaya secara digital dan terintegrasi.
                                </p>
                                <a href="{{ route('login', ['type' => 'tpg']) }}" class="btn btn-primary mt-3">
                                    Masuk ke Layanan TPG Guru
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- PEGAWAI SECTION --}}
        <section class="pegawai-section" style="background-color: #008080; color: #ffffff;" data-aos="fade-up" data-aos-delay="0">
            <div class="container py-5 border-bottom">

                {{-- Header --}}
                <div class="text-center mb-5">
                    <h6 class="fw-bold mb-1 text-uppercase">PEGAWAI</h6>
                    <h2 class="fw-bold mb-2">Penyelenggara Kristen</h2>
                    <div class="partner-divider mx-auto mb-3" style="background: #ffc107;"></div>
                    <p class="text-muted fs-6 mb-0" style="color: rgba(255, 255, 255, 0.8);">
                        <span style="color: rgba(255,255,255,0.8);">
                            Daftar pegawai yang bertugas pada Penyelenggara Kristen.
                        </span>
                    </p>
                </div>

                <div class="row g-4 justify-content-center">

                    {{-- CARD 1 --}}
                    <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card shadow border-0 text-center p-4 pegawai-card">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/endah.svg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">Endah Priyatiningsih, S.Th.</h5>
                            <p class="text-muted mb-3">Pengawas Pendidikan <br> Agama Kristen</p>
                        </div>
                    </div>

                    {{-- CARD 2 --}}
                    <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card shadow border-0 text-center p-4 pegawai-card">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/agus.svg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">Agus <br> Widodo, S.Th.</h5>
                            <p class="text-muted mb-3">Penyuluh Agama Kristen</p>
                        </div>
                    </div>

                    {{-- CARD 3 --}}
                    <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
                        <div class="card shadow border-0 text-center p-4 pegawai-card">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/agustien.svg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">Agustien <br> Indrawati, S.Pd.K.</h5>
                            <p class="text-muted mb-3">Penyuluh Agama Kristen</p>
                        </div>
                    </div>

                    {{-- CARD 4 --}}
                    <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="500">
                        <div class="card shadow border-0 text-center p-4 pegawai-card">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/surja.svg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">Surja <br> Permana, S.Th.</h5>
                            <p class="text-muted mb-3">Penyuluh Agama Kristen</p>
                        </div>
                    </div>

                    {{-- CARD 5 --}}
                    <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="600">
                        <div class="card shadow border-0 text-center p-4 pegawai-card">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/natalia.svg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">Natalia <br> Parhusip, S.Th.</h5>
                            <p class="text-muted mb-3">Penyuluh Agama Kristen</p>
                        </div>
                    </div>

                    {{-- CARD 6 --}}
                    <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="700">
                        <div class="card shadow border-0 text-center p-4 pegawai-card">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/stefanus.svg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">Stefanus <br> Alexander, S.Th.</h5>
                            <p class="text-muted mb-3">Penyuluh Agama Kristen</p>
                        </div>
                    </div>

                    {{-- CARD 7 --}}
                    <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="800">
                        <div class="card shadow border-0 text-center p-4 pegawai-card">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/febrima.svg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">Febrima Yuliana Mouwlaka, S.Si.Teol.</h5>
                            <p class="text-muted mb-3">Penyuluh Agama Ahli Pertama</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- LOGO SECTION --}}
        <section class="logo-section bg-white py-5" data-aos="fade-up">
            <div class="container text-center">

                <div class="row justify-content-center align-items-center g-5">

                    <!-- Logo 1 -->
                    <div class="col-12 col-lg-5 logo-wrapper">
                        <img src="{{ asset('assets/img/Logo kemenag_silayan fix2.svg') }}" class="brand-logo"
                            alt="Logo 1">
                    </div>

                    <!-- Logo 2 -->
                    <div class="col-12 col-lg-5 logo-wrapper">
                        <img src="{{ asset('assets/img/Logo upn_silayan fix2.svg') }}" class="brand-logo"
                            alt="Logo 2">
                    </div>

                </div>

            </div>
        </section>




    </main>
@endsection
