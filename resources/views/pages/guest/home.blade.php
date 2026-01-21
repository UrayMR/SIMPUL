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


        .hero-title {
            font-weight: 800;
            font-size: clamp(2.2rem, 4vw, 3.5rem);
            line-height: 1.15;
            color: var(--app-primary);
            letter-spacing: -0.02em;
        }

        .hero-highlight {
            color: var(--app-primary);
            opacity: 0.85;
        }

        .hero-subtitle {
            font-size: 1.05rem;
            color: #444;
            line-height: 1.7;
            max-width: 680px;
            margin: 0 auto;
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


        .see-more-link {
            font-size: 0.95rem;
            transition: 0.3s ease;
        }

        .see-more-link:hover {
            letter-spacing: 0.02em;
            text-decoration: underline;
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

                        <h1 class="hero-title mb-3">
                            Belajar Terarah<br>
                            <span class="hero-highlight">Bertemu di Satu SIMPUL</span>
                        </h1>

                        <p class="hero-subtitle mb-4">
                            Platform pembelajaran terintegrasi bagi pendidik dan <br> peserta didik
                            dengan materi berkualitas dan terarah
                        </p>

                        <a href="/kursus" class="btn btn-app-primary btn-lg px-5">
                            Jelajahi Course
                        </a>

                    </div>
                </div>

            </div>
        </section>


        {{-- DAFTAR STUDENT BANNER SECTION --}}
        <section class="profil-section bg-app-primary text-app-">
            <div class="container">
                <div class="row align-items-center">

                    {{-- KIRI: IMAGE --}}
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <div class="profil-image">
                            <img src="{{ asset('assets/img/background/1.png') }}" alt="Profil"
                                class="img-fluid rounded-4">
                        </div>
                    </div>

                    {{-- KANAN: KONTEN --}}
                    <div class="col-lg-7 profil-content ps-lg-5">
                        <h1 class="fw-bold  text-app-white mb-3 ">
                            Temukan Kelas Sesuai Kebutuhanmu
                        </h1>

                        <p class="mb-4">
                            Beragam kategori pembelajaran dirancang untuk mendukung proses belajar yang terstruktur,
                            <br>aplikatif, dan mudah dipahami.

                        </p>

                        <a href="#" class="btn btn-light text-app-primary fw-semibold">
                            Jelajahi Semua Kategori →
                        </a>
                    </div>

                </div>
            </div>
        </section>



        {{-- COURSE SECTION --}}
        <section class="pelayanan-section bg-white" data-aos="fade-up"data-aos-delay="400">
            <div class="container py-5 ">

                {{-- Header konsisten --}}
                <div class="text-center mb-3">
                    {{-- <h6 class="fw-bold text-secondary mb-1">KELAS UNGGULAN</h6> --}}
                    <h2 class="fw-bold text-app-primary mb-2">KELAS UNGGULAN</h2>
                    <div class="partner-divider mx-auto mb-3 bg-app-primary"></div>
                    <p class="text-muted fs-6 mb-0">
                        Kelas unggulan dari pendidik terpilih dengan materi relevan dan terstruktur
                    </p>
                </div>
                {{-- LINK LIHAT LEBIH BANYAK --}}
                <div class="d-flex justify-content-center justify-content-lg-end mb-3">
                    <a href="/kursus" class="fw-semibold text-app-primary text-decoration-none see-more-link">
                        Lihat Lebih Banyak →
                    </a>
                </div>
                <div class="row">
                    @foreach ($courses as $course)
                        <div class="col-12 col-md-6 col-lg-3 mb-4 fade-up">
                            <x-card title="{{ $course->title }}" category="{{ $course->category->name }}"
                                    price="{{ $course->price }}" teacher="{{ $course->teacher->user->name }}"
                                    id="{{ $course->id }}" image="{{ $course->thumbnail_path }}" count="{{ $course->enrollments_count }} " />
                        </div>
                    @endforeach

                </div>




            </div>
        </section>

        {{-- DAFTAR GURU SECTION --}}
        <section class="profil-section bg-white pt-1 pb-4">
            <div class="container ">
                <div class="row align-items-center bg-app-primary rounded p-4 p-lg-5">

                    {{-- KIRI: KONTEN --}}
                    <div class="col-lg-7 profil-content">
                        <h1 class="fw-bold  text-app-white  mb-3">
                            Tertarik untuk jadi Guru untuk Penghasilan Tambahan?
                        </h1>

                        <p class="mb-4">
                            Dosen, guru, atau praktisi di bidang tertentu dapat<br> berkontribusi dalam ekosistem
                            pembelajaran.
                        </p>

                        <a href="#" class="btn btn-light text-app-primary fw-semibold">
                            Daftar sebagai Pendidik →
                        </a>
                    </div>

                    {{-- KANAN: IMAGE --}}
                    <div class="col-lg-5 text-center">
                        <div class="profil-image">
                            <img src="{{ asset('assets/img/background/2.png') }}" alt="Profil"
                                class="img-fluid rounded-4">
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
