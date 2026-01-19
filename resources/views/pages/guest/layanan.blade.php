@extends('layouts.app')

@section('title', 'SILAYANKRIS - Kementerian Agama Kota Surabaya')

{{-- Landing Page --}}
@section('content')


    <main>
        {{-- Hero Section --}}
        <section class="hero py-5 text-center bg-light">
            <div class="container">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    Selamat Datang di SILAYANKRIS
                </h1>
                <p class="fs-5 mb-3">
                    <strong>SILAYANKRIS</strong> - Sistem Informasi Layanan Penyelenggara Kristen
                    Kementerian Agama Kota Surabaya
                </p>
                <p class="text-muted mb-5">
                    Website ini digunakan untuk mengelola data <strong>Gereja</strong> dan data
                    <strong>Berkas TPG Guru</strong> secara digital dan terintegrasi.
                </p>

                <div class="row justify-content-center">
                    {{-- Card 1: Layanan Gereja --}}
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-lg h-100">
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

                    {{-- Card 2: Layanan TPG Guru --}}
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-lg h-100">
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
    </main>



@endsection
