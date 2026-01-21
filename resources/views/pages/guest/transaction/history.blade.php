@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="container py-5">

        {{-- HEADER --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-1">Riwayat Transaksi</h3>
                <p class="text-muted mb-0">
                    Daftar transaksi pembelian kelas yang pernah Anda lakukan
                </p>
            </div>
        </div>

        {{-- CARD --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Metode</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- CONTOH DATA --}}
                            @forelse ($transactions as $trx)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <div class="fw-semibold">{{ $trx->course->title }}</div>
                                        <small class="text-muted">
                                            Pengajar: {{ $trx->course->teacher->user->name }}
                                        </small>
                                    </td>

                                    <td>
                                        {{ $trx->created_at->translatedFormat('d F Y') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $trx->created_at->format('H:i') }} WIB
                                        </small>
                                    </td>

                                    <td>Transfer Bank</td>

                                    <td class="fw-semibold">
                                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        @if ($trx->status === 'pending')
                                            <span
                                                class="badge rounded-pill px-3 py-2
            bg-warning-subtle text-warning d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-clock-fill"></i>
                                                Menunggu
                                            </span>
                                        @elseif ($trx->status === 'approved')
                                            <span
                                                class="badge rounded-pill px-3 py-2
            bg-success-subtle text-success d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Berhasil
                                            </span>
                                        @else
                                            <span
                                                class="badge rounded-pill px-3 py-2
            bg-danger-subtle text-danger d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-x-circle-fill"></i>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>



                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 @if ($transactions->count() > 0)
    <div class="d-flex flex-column flex-md-row
                justify-content-between align-items-center
                gap-3 mt-4">

        {{-- INFO --}}
        <div class="pagination-info ">
            Menampilkan
            {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }}
            dari
            {{ $transactions->total() }}
            data
        </div>

        {{-- PAGINATION --}}
        <div>
            {{ $transactions->links('pagination::bootstrap-4') }}
        </div>

    </div>
@endif


            </div>
        </div>

    </div>
@endsection
