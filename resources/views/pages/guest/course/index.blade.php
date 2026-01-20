@extends('layouts.app')

@section('title', 'Course')

<style>
    .card:hover {
        transform: translateY(-4px);
        transition: 0.3s ease;
    }

    input.form-control-lg {
        border-radius: 12px 0 0 12px;
    }

    .input-group .btn {
        border-radius: 0 12px 12px 0;
    }
</style>

{{-- Landing Page --}}
@section('content')
    <section class="bg-app-primary text-white py-5 py-lg-6">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">

                    <span class="badge bg-white text-app-primary px-3 py-2 rounded-pill mb-3 fw-semibold">
                        🎓 Katalog Kelas
                    </span>

                    <h1 class="fw-extrabold display-5 mb-3 lh-sm text-white">
                        Temukan Kelas Sesuai Kebutuhanmu
                    </h1>

                    <p class="fs-5 opacity-75 mb-0">
                        Mulai dari penguatan akademik, keterampilan praktis, <br>hingga pengembangan kompetensi profesional
                        semua tersedia dalam satu platform.
                    </p>

                </div>
            </div>
        </div>
    </section>


    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <!-- SIDEBAR -->
                <aside class="col-lg-3 mb-4">
                    <div class="bg-white rounded-4 shadow-sm p-4">

                        <form method="GET">

                            {{-- SEARCH --}}
                            <div class="mb-4">
                                <label class="fw-bold mb-2 d-block">Cari Kelas</label>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="Nama kelas...">
                            </div>

                            {{-- TOPIK / CATEGORY --}}
                            <h6 class="fw-bold mb-3">Kategori</h6>

                            @foreach ($categories as $category)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="categories[]"
                                        value="{{ $category->id }}"
                                        {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach

                            <h6 class="fw-bold mt-4 mb-3">Lainnya</h6>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="ownership" id="owned"
                                    value="true" {{ request('ownership') === true ? 'checked' : '' }}>
                                <label class="form-check-label" for="owned">
                                    Sudah Dimiliki
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="ownership" id="not_owned"
                                    value="false" {{ request('ownership') === false ? 'checked' : '' }}>
                                <label class="form-check-label" for="not_owned">
                                    Belum Dimiliki
                                </label>
                            </div>
                            {{-- BUTTON --}}
                            <div class="d-flex gap-2 pt-2">
                                <button type="submit" class="btn btn-app-primary flex-grow-1">
                                    <i class="bi bi-search me-1"></i> Terapkan Filter
                                </button>
                                <a href="{{ route('course.index') }}" id="resetFilters"
                                    class="btn btn-app-outline-secondary d-inline-flex align-items-center justify-content-center p-0"
                                    style="width: 44px; height: 44px;" aria-label="Reset filter">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>


                        </form>

                    </div>
                </aside>

                <div class="col-lg-9">
                    <div class="row">
                        @forelse ($courses as $course)
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <x-card title="{{ $course->title }}" category="{{ $course->category->name }}"
                                    price="{{ $course->price }}" teacher="{{ $course->teacher->user->name }}"
                                    id="{{ $course->id }}" />
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="bg-white rounded-4 shadow-sm p-5 text-center">
                                    <div class="mb-3 fs-1">🔍</div>

                                    <h5 class="fw-bold mb-2">
                                        Kelas tidak ditemukan
                                    </h5>

                                    <p class="text-muted mb-4">
                                        Kami tidak menemukan kelas yang sesuai dengan pencarian atau filter yang kamu pilih.
                                    </p>

                                    <a href="{{ route('course.index') }}" class="btn btn-app-primary">
                                        Reset Filter
                                    </a>
                                </div>
                            </div>
                        @endforelse
                        @if ($courses->count() > 0)
                            <div class="d-flex justify-content-between align-items-center ">
                                <div class="pagination-info">
                                    Menampilkan halaman {{ $courses->firstItem() }} ke {{ $courses->lastItem() }} dari
                                    {{ $courses->total() }}
                                    halaman
                                </div>
                                {{ $courses->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
