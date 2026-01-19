@extends('layouts.app')

@section('title', 'SILAYANKRIS - Kementerian Agama Kota Surabaya')

{{-- Landing Page --}}
@section('content')
    <style>
        .hover-item:hover .hover-link {
            color: #008080 !important;
            /* biru elegan */
            transform: translateX(3px);
        }

        .hover-item:hover {
            opacity: 0.9;
        }
    </style>

    <div class="container-fluid  py-4 bg-primary text-light">
        <div class="container pb-3 ">
            <h1 class="fw-bold mb-0">Berita</h1>
            <p class="text-light fs-6 mb-0">Pusat pengumuman layanan kristen</p>
        </div>
    </div>


    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Judul --}}

        {{-- Search dan Reset --}}
        <div class="row  mb-3 ">
            <div class="col-12 col-md-6 flex-grow-1">
                <form method="GET" class="w-100 d-flex align-items-center gap-2">
                    {{-- Input pencarian --}}
                    <div class="input-group ">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
                            placeholder="Cari judul berita..." style="width: 50%; height: 50px;">
                        <button class="btn btn-outline-secondary border" type="submit">Cari</button>
                    </div>

                    <a href="{{ url()->current() }}"
                        class="btn btn-secondary border d-flex align-items-center justify-content-center {{ request('search') ? '' : 'd-none' }}"
                        style="height:50px; min-width:48px; padding:0 12px;">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </form>
            </div>
        </div>
        {{-- Card Hero Berita --}}
        @if ($berita->count() > 0)
            @if ($berita->currentPage() == 1)
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-none bg-transparent mb-3 border-bottom border-md rounded-0 pb-3"
                            style="border-bottom-style: dashed !important; border-color: rgb(179, 174, 174) !important;">

                            <div class="row g-4">

                                {{-- HERO GAMBAR --}}
                                <div class="col-md-7">
                                    <a href="{{ route('berita.show', $berita->first()->slug) }}">
                                        <div class="img-hover-slide">
                                            <img class="img-fluid rounded news-image"
                                                src="{{ asset('storage/' . $berita->first()->gambar_path) }}"
                                                style="width: 100%; height: 350px; object-fit: cover;">
                                        </div>
                                    </a>
                                </div>

                                {{-- HERO TEKS --}}
                                <div class="col-md-5">
                                    <div class="card-body p-0">
                                        <a href="{{ route('berita.show', $berita->first()->slug) }}"
                                            class="text-decoration-none news-title card-title h2">
                                            {{ Str::limit($berita->first()->judul, 75, '...') }}
                                        </a>
                                        <p class="card-text fs-6 mt-2">{{ Str::limit($berita->first()->isi, 250, '...') }}
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                {{ $berita->first()->created_at->locale('id')->translatedFormat('d F Y') }}
                                            </small>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="alert bg-primary text-light mt-4">
                Belum ada berita yang tersedia.
            </div>
        @endif

        {{-- Card All Berita --}}
        @php
            $listBerita = $berita->currentPage() == 1 ? $berita->skip(1) : $berita;
        @endphp
        <div class="row">
            <div class="col-md-9">
                @foreach ($listBerita as $item)
                    <div class="card border-0 shadow-none bg-transparent mb-3 border-bottom border-md rounded-0  pb-3"
                        style="border-bottom-style: dashed !important; border-color: rgb(179, 174, 174) !important;">
                        <div class="row g-4 border-bottom-2">
                            <div class="col-md-3">
                                <a href="{{ route('berita.show', $item->slug) }}">
                                    <div class="img-hover-slide">
                                        <img class="img-fluid rounded news-image"
                                            src="{{ asset('storage/' . $item->gambar_path) }}"
                                            style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px;">

                                    </div>
                                </a>
                            </div>
                            <div class="col-md-9 ">
                                <div class="card-body p-0">
                                    <a href="{{ route('berita.show', $item->slug) }}"
                                        class="text-decoration-none news-title card-title h5">
                                        {{ Str::limit($item->judul, 50, '...') }}
                                    </a>
                                    <p class="card-text mt-2">{{ Str::limit($item->isi, 150, '...') }}</p>
                                    <p class="card-text"><small
                                            class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2 my-4">
                    <div class="small text-muted">
                        Halaman <strong>{{ $currentPage }}</strong> dari <strong>{{ $lastPage }}</strong><br>
                        Menampilkan <strong>{{ $perPage }}</strong> per halaman (total
                        <strong>{{ $total }}</strong> berita)
                    </div>

                    <div>
                        {{ $berita->links() }}
                    </div>
                </div>

            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="border-radius: 12px; background: #f8f9fa;">
                    <h5 class="fw-bold mb-3 pb-2 border-bottom">
                        Rekomendasi Berita
                    </h5>

                    <div class="d-flex flex-column gap-3">

                        @foreach ($randomBerita as $item)
                            <div class="d-flex align-items-start rounded hover-item"
                                style="transition: .2s; cursor: pointer;">

                                <span class="fw-bold text-primary me-3 fs-4" style="line-height: 1;">
                                    {{ $loop->iteration }}
                                </span>

                                <a href="{{ route('berita.show', $item->slug) }}"
                                    class="text-dark text-decoration-none fw-medium hover-link" style="transition: .2s;">
                                    {{ $item->judul }}
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
