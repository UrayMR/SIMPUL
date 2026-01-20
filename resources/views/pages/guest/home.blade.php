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


        


        

        .hero-section {
            position: relative;
            min-height: 90vh;
            background-image: url('{{ asset('assets/img/background/Hero.svg') }}');
            /* background-color: black; */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.45);
            /* background: #fffff; */
            /* gelap biar teks kebaca */
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: #fff;
        }

        

        

        .partner-divider {
            width: 80px;
            height: 3px;
            /* background: #008080; */
            border-radius: 999px;
        }

        

        /* ===== PROFIL BANNER SECTION ===== */
        .profil-section {
            padding: 5rem 0;
        }

        .profil-content h1 {
            font-size: 2.3rem;
            line-height: 1.25;
        }

        @media (max-width: 991px) {
            .profil-content {
                text-align: center;
                margin-bottom: 2rem;
            }
        }



        .profil-image img {
            max-width: 100%;
            height: auto;
            display: block;
            border-radius: 1.5rem;

        }

        .profil-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.25;
        }

        .profil-content p {
            font-size: 1.05rem;
            margin-top: 1rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .profil-content .btn {
            padding: 0.8rem 2.2rem;
            font-weight: 600;
            border-radius: 0.75rem;
        }

        @media (max-width: 991px) {
            .profil-banner {
                flex-direction: column;
                text-align: center;
            }

            .profil-content h1 {
                font-size: 2rem;
            }
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
        <section class="hero-section">
            <div class="hero-overlay"></div>
            <div class="container hero-content">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-9">

                        <h1 class="fw-bold text-app-primary display-5 mb-2">
                            Belajar Bersama SIMPUL
                        </h1>
                        <h1 class="fw-bold text-app-primary display-5 mb-2">
                            Jadi Talenta Digital Terbaik
                        </h1>


                        {{-- <p class="fs-5 text-dark mb-4">
                            <strong>SIMPUL</strong> – Sistem Informasi Manajemen Pembelajaran Unggul<br>
                            Platform kursus online untuk belajar langsung dari para ahli
                        </p> --}}

                        <p class="mb-3 fs-5  text-dark">
                            {{-- Temukan berbagai course berkualitas dari guru terbaik,<br>
                            tingkatkan skill, dan raih peluang karier yang lebih baik. --}}
                            Platform online course terbaik dengan dukungan mentor<br> berpengalaman dan materi terlengkap
                        </p>

                        <a href="/courses" class="btn btn-app-primary btn-lg px-5">
                            Jelajahi Course
                        </a>


                    </div>
                </div>
            </div>
        </section>


        {{-- DAFTAR STUDENT BANNER SECTION --}}
        <section class="profil-section bg-app-primary text-light">
            <div class="container">
                <div class="row align-items-center">

                    {{-- KIRI: IMAGE --}}
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <div class="profil-image">
                            <img src="{{ asset('assets/img/kemenag2.jpg') }}" alt="Profil" class="img-fluid rounded-4">
                        </div>
                    </div>

                    {{-- KANAN: KONTEN --}}
                    <div class="col-lg-7 profil-content">
                        <h1 class="fw-bold mb-3">
                            Siap membangun karir Freelancer profesional?<br>
                            Freelance Plus Solusinya
                        </h1>

                        <p class="mb-4">
                            Kuasai strategi menjadi freelancer profesional untuk meningkatkan
                            pendapatan secara langsung bersama para pakar berpengalaman.
                        </p>

                        <a href="#" class="btn btn-light text-app-primary fw-semibold">
                            Daftar Sekarang →
                        </a>
                    </div>

                </div>
            </div>
        </section>



        {{-- COURSE SECTION --}}
        <section class="pelayanan-section" data-aos="fade-up"data-aos-delay="400">
            <div class="container py-5 border-bottom">

                {{-- Header konsisten --}}
                <div class="text-center mb-5">
                    {{-- <h6 class="fw-bold text-secondary mb-1">KELAS UNGGULAN</h6> --}}
                    <h2 class="fw-bold text-app-primary mb-2">KELAS UNGGULAN</h2>
                    <div class="partner-divider mx-auto mb-3 bg-app-primary"></div>
                    <p class="text-muted fs-6 mb-0">
                        Pilih jenis kelas yang ingin Anda pelajari dengan SIMPUL
                    </p>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3 mb-4 fade-up">
                        <x-card title="Kelas Dasar Agama Kristen" price="3000" />
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-4 fade-up">
                        <x-card title="Kelas Dasar Agama Kristen " price="2000000000" />
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-4 fade-up">
                        <x-card title="Internet of Things (IoT) Project - Building Health Monitoring Systemssssssss"
                            category="IT" price="0" link="/courses/1" />
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-4 fade-up">
                        <x-card title="Kelas Dasar Agama Kristen" price="0" />
                    </div>
                </div>
            </div>
        </section>

        {{-- DAFTAR GURU SECTION --}}
        <section class="profil-section bg-app-white">
            <div class="container">
                <div class="row align-items-center bg-app-primary rounded-4 p-4 p-lg-5">

                    {{-- KIRI: KONTEN --}}
                    <div class="col-lg-7 text-light profil-content">
                        <h1 class="fw-bold mb-3">
                            Tertarik untuk jadi Guru & Memberi Dampak Positif?
                        </h1>

                        <p class="mb-4">
                            Lebih dari 100+ Guru telah bekerja sama dengan SIMPUL untuk<br>membangun pendidikan yang lebih
                            baik di Indonesia.
                        </p>

                        <a href="#" class="btn btn-light text-app-primary fw-semibold">
                            Daftar Sekarang →
                        </a>
                    </div>

                    {{-- KANAN: IMAGE --}}
                    <div class="col-lg-5 text-center">
                        <div class="profil-image">
                            <img src="{{ asset('assets/img/kemenag2.jpg') }}" alt="Profil" class="img-fluid rounded-4">
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
