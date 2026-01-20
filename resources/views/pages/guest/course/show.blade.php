@extends('layouts.app')

@section('title', $course->title ?? 'Detail Kelas')

@section('content')
    <style>
.teacher-profile h4 {
    font-size: 1.4rem;
}

.teacher-avatar {
    width: 110px;
    height: 110px;
    flex-shrink: 0;
}

.teacher-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 3px solid #e5e7eb;
}

.badge.bg-success-subtle {
    background-color: #e6f7f1;
}

    </style>
    <section class="course-detail py-5 bg-white ">
        <div class="container border-bottom p-5">
            <div class="row align-items-center g-5">

                <!-- LEFT CONTENT -->
                <div class="col-lg-6">
                    <h1 class="fw-bold mb-3">
                        {{ $course->title ?? 'C++ Dasar' }}
                    </h1>

                    <p class="text-muted mb-4">
                        {{ $course->description ?? 'Sebagai bahasa pemrograman yang sangat populer dan bisa diandalkan dari sisi performa, C++ banyak digunakan di berbagai industri seperti software, game development, IoT, VR, robotik, scientific computing, hingga machine learning.' }}
                    </p>

                    <!-- META INFO -->
                    <div class="d-flex flex-wrap align-items-center gap-4 mb-4">

                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="bx bi-bookmark-fill me-1"></i>
                            <span> {{ $course->category->name }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="bi bi-people-fill me-1"></i>
                            <span>0 Terjual</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="bi bi-person-fill me-1"></i>
                            <span>{{ $course->teacher->user->name }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="bi bi-cash "></i>
                            <div
                                class="course-price {{ (float) $course->price === 0.0 ? 'text-app-primary' : 'text-dark' }}">
                                <span>
                                    {{ (float) $course->price === 0.0 ? 'GRATIS' : 'Rp ' . number_format((float) $course->price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                    </div>

                    <!-- CTA -->
                    <a href="#" class="btn btn-app-secondary px-4 py-2 fw-semibold rounded-3">
                        Beli Kelas
                    </a>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="col-lg-6 text-center">
                    <div class="course-banner shadow-sm rounded-4 overflow-hidden">
                        <img src="{{ asset('assets/img/' . ($course->image ?? 'kemenag2.jpg')) }}"
                            alt="{{ $course->title ?? 'Course Image' }}" class="img-fluid w-100">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="teacher-profile py-5 bg-white pt-0 ">
    <div class="container ">
        <div class="row justify-content-center">

            <div class="col-lg-10 ">
                <h4 class="fw-bold mb-4">
                    Tentang Pengajar
                </h4>

                <div class="card border-0 shadow-sm rounded-4 bg-app-primary">
                    <div class="card-body p-4">

                        <div class="d-flex flex-column flex-md-row align-items-start gap-4">

                            <!-- FOTO -->
                            <div class="teacher-avatar">
                                <img
                                    src="{{ asset('assets/img/foto bu ester fix_34.svg') }}"
                                    {{-- $course->teacher->profile_picture_path ??  --}}
                                    alt="{{ $course->teacher->user->name }}"
                                    class="img-fluid rounded-circle"
                                >
                            </div>
                            <!-- INFO -->
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center  gap-2 mb-1">
                                    <h5 class="fw-bold text-white mb-0">
                                        {{ $course->teacher->user->name }}
                                    </h5>

                                    @if($course->teacher->approved_at)
                                        <span class="badge bg-success text-white fw-semibold">
                                            Terverifikasi
                                        </span>
                                    @endif
                                </div>

                                <div class="text-white  mb-2">
                                    Keahlian :
                                    {{ $course->teacher->expertise }}
                                </div>

                                <p class="text-white mb-0">
                                    Biografi :
                                    {{ $course->teacher->bio }}
                                </p>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection
