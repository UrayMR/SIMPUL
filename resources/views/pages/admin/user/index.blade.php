@extends('layouts.appadmin')

@section('title', 'Manajemen User')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Pengguna</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 mb-2">
            {{-- Row responsive: di mobile col-12 (full), di md col-6 untuk search dan auto untuk button --}}
            <h5 class="card-title fw-semibold">Daftar Data Pengguna</h5>

            <div class="row g-2 align-items-center">

                <!-- Search -->
                <div class="col-12 col-md-6">
                    <form method="GET" class="w-100 d-flex align-items-center gap-2">
                        {{-- Input pencarian --}}
                        <div class="input-group ">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
                                placeholder="Cari nama atau email...">
                            <button class="btn btn-outline-secondary border" type="submit">Cari</button>
                        </div>

                        <a href="{{ url()->current() }}"
                            class="btn btn-secondary border d-flex align-items-center gap-1
          {{ request('search') ? '' : 'd-none' }}">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            <span>Reset</span>
                        </a>
                    </form>
                </div>

                <!-- Button: full width on mobile, auto-width on md+ and aligned to right -->
                <div class="col-12 col-md-auto ms-md-auto text-md-end">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary w-100 w-md-auto">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body ">
            {{-- Tabel User --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="">
                        <tr class="text-start">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-start">{{ $users->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span>
                                        {{ $user->role == 'staff-gereja' ? 'Pengurus Gereja' : ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge w-100 {{ $user->status === 'aktif' ? 'badge bg-label-success' : ($user->status === 'nonaktif' ? 'badge bg-label-danger' : 'badge bg-label-warning') }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>


                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="btn btn-sm btn-info text-light">
                                        <i class="bx bx-info-circle"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="btn btn-sm btn-warning text-light">
                                        <i class="bx bx-pencil"></i> Ubah
                                    </a>

                                    @if (auth()->id() !== $user->id)
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalCenter{{ $user->id }}">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Tidak dapat menghapus akun sendiri">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                    Tidak ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            @foreach ($users as $user)
                @if (auth()->id() !== $user->id)
                    <div class="modal fade" id="modalCenter{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Konfirmasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Apakah anda yakin ingin menghapus
                                        <strong>{{ Str::limit($user->name, 15, '...') }}</strong>?
                                        <br><br>
                                        Semua data yang pernah dibuat oleh pengguna ini akan terhapus juga.
                                    </p>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Tidak
                                        </button>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            onsubmit=" ">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">
                                                <i class="bx bx-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach


            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div class="small text-muted">
                    Halaman <strong>{{ $currentPage }}</strong> dari <strong>{{ $lastPage }}</strong><br>
                    Menampilkan <strong>{{ $perPage }}</strong> data per halaman (total
                    <strong>{{ $total }}</strong> user)
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
