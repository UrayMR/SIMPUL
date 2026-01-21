@extends('layouts.app')

@section('title', 'Detail Kursus Saya')

@section('content')
    <style>
        .teacher-profile h4 {
            font-size: 1.6rem;
            font-weight: 700;
        }

        .teacher-card {
            border-radius: 1.25rem;
            border: 1px solid #eef2f7;
            background: #fff;
            transition: all 0.3s ease;
        }

        .teacher-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .teacher-avatar {
            width: 120px;
            height: 120px;
            border-radius: 1.25rem;
            overflow: hidden;
            background: #f3f4f6;
            flex-shrink: 0;
        }

        .teacher-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .teacher-name {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .teacher-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.6rem;
            border-radius: 999px;
        }

        .teacher-meta {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .teacher-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .teacher-bio {
            font-size: 0.95rem;
            color: #374151;
            line-height: 1.7;
        }

        .teacher-avatar-wrapper {
            min-width: 140px;
        }

        .badge.bg-success-subtle {
            background-color: #e6f7f1;
        }

        .course-preview h3 {
            font-size: 1.6rem;
        }

        .course-preview iframe {
            border: none;
        }
    </style>

    {{-- Section Video --}}
    <section class="course-preview py-5 bg-white">
        <div class="container border-bottom p-5">

            {{-- ROW 1 : VIDEO + TITLE --}}
            <div class="row g-5 align-items-start">

                <!-- LEFT : VIDEO -->
                <div class="col-12 col-lg-6">
                    <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                        <iframe src="https://www.youtube.com/embed/{{ $course->video_url }}" title="Preview Kursus"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

                <!-- RIGHT : TITLE & DESCRIPTION -->
                <div class="col-12 col-lg-6">
                    <h3 class="fw-bold text-app-gray mb-3">
                        {{ $course->title }}
                    </h3>

                    <p class="text-app-gray mb-0">
                        {{ $course->description }}
                    </p>
                </div>

            </div>

            <hr class="my-5">

            {{-- ROW 2 : META + CONTACT --}}
            <div class="row g-5 align-items-start">

                <!-- LEFT : CATEGORY - AUTHOR -->
                <div class="col-lg-7">
                    <h6 class="fw-bold mb-4 text-app-primary fs-5">
                        Informasi Detail Kursus
                    </h6>

                    <div class="row g-3">

                        {{-- Kategori --}}
                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-4 border d-flex align-items-start gap-3 h-100">
                                <i class="bi bi-bookmark-fill fs-4 text-app-primary"></i>
                                <div>
                                    <div class="text-muted small">Kategori</div>
                                    <div class="fw-semibold text-app-gray">
                                        {{ $course->category->name }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Terjual --}}
                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-4 border d-flex align-items-start gap-3 h-100">
                                <i class="bi bi-people-fill fs-4 text-app-primary"></i>
                                <div>
                                    <div class="text-muted small">Total Terjual</div>
                                    <div class="fw-semibold text-app-gray">
                                        {{ $course->enrollments_count }} Peserta
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal Dibuat --}}
                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-4 border d-flex align-items-start gap-3 h-100">
                                <i class="bi bi-calendar-event fs-4 text-app-primary"></i>
                                <div>
                                    <div class="text-muted small">Tanggal Dibuat</div>
                                    <div class="fw-semibold text-app-gray">
                                        {{ $course->created_at->translatedFormat('l, d F Y H:i') }} WIB
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pengajar --}}
                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-4 border d-flex align-items-start gap-3 h-100">
                                <i class="bi bi-person-fill fs-4 text-app-primary"></i>
                                <div>
                                    <div class="text-muted small">Pengajar</div>
                                    <div class="fw-semibold text-app-gray">
                                        {{ $course->teacher->user->name }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- RIGHT : SUMMARY -->
                <div class="col-lg-5">
                    <div class="p-4 rounded-4 border h-100 bg-white">


                        {{-- Total Pendapatan --}}
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="icon-box bg-white bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-cash fs-4 text-app-primary"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Total Pendapatan</div>
                                <div class="fs-4 fw-bold text-app-gray">
                                    Rp {{ number_format($transactionsSumAmount ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        {{-- Status Kursus --}}
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-box bg-white bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-clipboard-check fs-4 text-app-primary"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Status Kursus</div>

                                @php
                                    $statusClass = match ($course->status) {
                                        'approved' => 'success',
                                        'pending' => 'warning',
                                        'rejected' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span
                                    class="text-white badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-3 py-2 rounded-pill fw-semibold">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
        {{-- ACTION BUTTONS --}}
        <div class="container py-4">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3  pt-4">

                {{-- LEFT : BACK --}}
                <a href="{{ route('teacher.courses.index') }}" class="btn btn-outline-secondary rounded px-4">
                    <i class="bi bi-arrow-left me-2"></i>
                    Kembali
                </a>

                {{-- RIGHT : EDIT & DELETE --}}
                <div class="d-flex gap-2">

                    {{-- Edit --}}
                    <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning rounded px-4">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Kursus
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus kursus ini? Data tidak dapat dikembalikan.')">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger rounded px-4">
                            <i class="bi bi-trash me-2"></i>
                            Hapus Kursus
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>





@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Spinner for delete course (match admin/teacher index logic)
            document.querySelectorAll('.modal form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    var btn = form.querySelector('.btn-delete-course');
                    if (btn) {
                        btn.disabled = true;
                        var buttonContent = btn.querySelector('.button-content');
                        var spinnerContent = btn.querySelector('.spinner-content');
                        if (buttonContent && spinnerContent) {
                            buttonContent.classList.add('d-none');
                            spinnerContent.classList.remove('d-none');
                        }
                    }
                });
            });
        });
    </script>
@endpush
